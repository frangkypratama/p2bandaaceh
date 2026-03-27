<?php

namespace App\Http\Controllers;

use App\Models\Lpt;
use App\Models\Sbp;
use App\Models\LptPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class LptController extends Controller
{
    private function getJenisLptOptions(): array
    {
        return [
            'bandara' => [
                'name' => 'LPT Penindakan Bandara',
                'icon' => 'cil-flight-takeoff',
            ],
        ];
    }

    private function compressPhoto(string $storedPath): void
    {
        $threshold = 300 * 1024;
        $fullPath  = storage_path('app/public/' . $storedPath);

        if (filesize($fullPath) > $threshold) {
            $image = Image::make($fullPath);

            $image->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $image->save($fullPath, 70);

            if (filesize($fullPath) > $threshold) {
                $image->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $image->save($fullPath, 65);
            }
        }
    }

    public function index()
    {
        $lpt = Lpt::with('sbp')
                    ->orderBy('tanggal_lpt', 'desc')
                    ->orderBy('nomor_lpt_int', 'desc')
                    ->paginate(10);
        $jenis_lpt_options = $this->getJenisLptOptions();
        return view('lpt.index', compact('lpt', 'jenis_lpt_options'));
    }

    public function create(Request $request)
    {
        $jenis = $request->query('jenis');
        $sbp = Sbp::orderBy('tanggal_sbp', 'desc')->get();
        $jenis_lpt_options = $this->getJenisLptOptions();

        return view('lpt.create', compact('sbp', 'jenis', 'jenis_lpt_options'));
    }

    public function store(Request $request)
    {
        $jenis_lpt_options = $this->getJenisLptOptions();
        $validatedData = $request->validate([
            // [PERBAIKAN] rule unique yang benar
            'nomor_lpt_int' => ['required', 'integer', Rule::unique('lpt', 'nomor_lpt_int')->whereNull('deleted_at')],
            'tanggal_lpt'   => 'required|date',
            'jenis_lpt'     => 'required|in:' . implode(',', array_keys($jenis_lpt_options)),
            'sbp_id'        => 'required|exists:sbp,id',
            'photos'        => 'nullable|array',
            'photos.*'      => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240'
        ]);

        try {
            DB::transaction(function () use ($request, $validatedData) {
                $lptData = $validatedData;

                $year = Carbon::parse($validatedData['tanggal_lpt'])->year;
                $lptData['nomor_lpt'] = 'LPT-' . $validatedData['nomor_lpt_int'] . '/KBC.0102/' . $year;

                unset($lptData['photos']);
                $lpt = Lpt::create($lptData);

                if ($request->hasFile('photos')) {
                    foreach ($request->file('photos') as $photo) {
                        $path = $photo->store('lpt-photos', 'public');
                        $this->compressPhoto($path);
                        LptPhoto::create([
                            'lpt_id'    => $lpt->id,
                            'file_path' => $path,
                        ]);
                    }
                }
            });

            return redirect()->route('lpt.index')->with('success', 'LPT berhasil dibuat.');
        } catch (\Exception $e) {
            logger()->error('Failed to create LPT: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat LPT. Silakan coba lagi.')->withInput();
        }
    }

    public function preview($id)
    {
        $lpt = Lpt::with(['sbp', 'photos'])->findOrFail($id);
        $jenis_lpt_options = $this->getJenisLptOptions();

        $pdf = Pdf::loadView('templatecetak.template-lpt', compact('lpt', 'jenis_lpt_options'))
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        $filename = str_replace('/', '-', $lpt->nomor_lpt) . '.pdf';

        return $pdf->stream($filename);
    }

    public function edit(Lpt $lpt)
    {
        $lpt->load('photos');
        $sbp = Sbp::orderBy('tanggal_sbp', 'desc')->get();
        $jenis_lpt_options = $this->getJenisLptOptions();
        return view('lpt.edit', compact('lpt', 'sbp', 'jenis_lpt_options'));
    }

    public function update(Request $request, Lpt $lpt)
    {
        $jenis_lpt_options = $this->getJenisLptOptions();
        $validatedData = $request->validate([
            'nomor_lpt_int'    => ['required', 'integer', Rule::unique('lpt', 'nomor_lpt_int')->ignore($lpt->id)->whereNull('deleted_at')],
            'tanggal_lpt'      => 'required|date',
            'jenis_lpt'        => 'required|in:' . implode(',', array_keys($jenis_lpt_options)),
            'sbp_id'           => 'required|exists:sbp,id',
            'photos'           => 'nullable|array',
            'photos.*'         => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'deleted_photos'   => 'nullable|array',
            'deleted_photos.*' => 'integer|exists:lpt_photos,id'
        ]);

        try {
            DB::transaction(function () use ($request, $lpt, $validatedData) {
                if (!empty($validatedData['deleted_photos'])) {
                    $photosToDelete = LptPhoto::where('lpt_id', $lpt->id)
                                              ->whereIn('id', $validatedData['deleted_photos'])
                                              ->get();

                    foreach ($photosToDelete as $photo) {
                        Storage::disk('public')->delete($photo->file_path);
                        $photo->delete();
                    }
                }

                $lptData = $validatedData;

                $year = Carbon::parse($validatedData['tanggal_lpt'])->year;
                $lptData['nomor_lpt'] = 'LPT-' . $validatedData['nomor_lpt_int'] . '/KBC.0102/' . $year;

                unset($lptData['photos']);
                $lpt->update($lptData);

                if ($request->hasFile('photos')) {
                    foreach ($request->file('photos') as $photo) {
                        $path = $photo->store('lpt-photos', 'public');
                        $this->compressPhoto($path);
                        LptPhoto::create([
                            'lpt_id'    => $lpt->id,
                            'file_path' => $path,
                        ]);
                    }
                }
            });

            return redirect()->route('lpt.index')->with('success', 'LPT berhasil diupdate');
        } catch (\Exception $e) {
            logger()->error('LPT gagal diupdate: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui LPT. Silakan coba lagi.')->withInput();
        }
    }

    public function destroy(Lpt $lpt)
    {
        foreach ($lpt->photos as $photo) {
            Storage::disk('public')->delete($photo->file_path);
            $photo->delete();
        }

        $lpt->delete();

        return redirect()->route('lpt.index')->with('success', 'LPT berhasil dihapus');
    }
}