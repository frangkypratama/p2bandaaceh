<?php

namespace App\Http\Controllers;

use App\Models\Lpt;
use App\Models\Sbp;
use App\Services\PhotoUploadService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class LptController extends Controller
{
    public function __construct(private PhotoUploadService $photoUploadService)
    {
    }

    private function getJenisLptOptions(): array
    {
        return [
            'bandara' => [
                'name' => 'LPT Penindakan Bandara',
                'icon' => 'cil-flight-takeoff',
            ],
        ];
    }

    public function index()
    {
        $lpt = Lpt::with('sbp')
                    ->orderBy('tanggal_lpt', 'desc')
                    ->orderBy('nomor_lpt_int', 'desc')
                    ->paginate(10)
                    ->appends(request()->query());
        $jenis_lpt_options = $this->getJenisLptOptions();
        return view('lpt.index', compact('lpt', 'jenis_lpt_options'));
    }

    public function create(Request $request)
    {
        $sbp = Sbp::orderBy('tanggal_sbp', 'desc')->orderBy('nomor_sbp_int', 'desc')->paginate(10);

        if ($request->ajax()) {
            return view('lpt.partials.sbp-table', compact('sbp'));
        }

        $jenis = $request->query('jenis');
        $jenis_lpt_options = $this->getJenisLptOptions();

        return view('lpt.create', compact('sbp', 'jenis', 'jenis_lpt_options'));
    }

    public function store(Request $request)
    {
        $jenis_lpt_options = $this->getJenisLptOptions();
        $validatedData = $request->validate([
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
                        $this->addPhotoToLpt($lpt, $photo);
                    }
                }
            });

            return redirect()->route('lpt.index')->with('success', 'LPT berhasil dibuat.');
        } catch (\Exception $e) {
            logger()->error('Failed to create LPT: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat LPT. Silakan coba lagi.')->withInput();
        }
    }

    private function addPhotoToLpt(Lpt $lpt, UploadedFile $photo): void
    {
        $wasCompressed = $this->photoUploadService->compressInPlace($photo, [
            'compress_threshold_kb' => 300,
        ]);

        $extension = $wasCompressed ? 'jpg' : $photo->getClientOriginalExtension();
        $randomName = Str::random(40) . '.' . $extension;

        $lpt->addMedia($photo)
            ->usingFileName($randomName)
            ->toMediaCollection('photos');
    }

    public function preview($id)
    {
        $lpt = Lpt::with(['sbp.bast', 'media'])->findOrFail($id);
        $jenis_lpt_options = $this->getJenisLptOptions();

        $pdf = Pdf::loadView('templatecetak.template-lpt', compact('lpt', 'jenis_lpt_options'))
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        $filename = str_replace('/', '-', $lpt->nomor_lpt) . '.pdf';

        return $pdf->stream($filename);
    }

    public function laporanWa($id)
    {
        $lpt = Lpt::with('sbp.bast')->findOrFail($id);

        $sbp = $lpt->sbp;

        $text = trim(view('template-laporan-wa.template-penindakan-bandara', compact('sbp'))->render());

        return response($text)->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    public function edit(Request $request, Lpt $lpt)
    {
        $sbp = Sbp::orderBy('tanggal_sbp', 'desc')->paginate(10);

        if ($request->ajax()) {
            return view('lpt.partials.sbp-table', compact('sbp'));
        }

        $lpt->load('media');
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
            'deleted_photos.*' => 'integer|exists:media,id'
        ]);

        try {
            DB::transaction(function () use ($request, $lpt, $validatedData) {
                if (!empty($validatedData['deleted_photos'])) {
                    $lpt->media()
                        ->where('collection_name', 'photos')
                        ->whereIn('id', $validatedData['deleted_photos'])
                        ->get()
                        ->each->delete();
                }

                $lptData = $validatedData;

                $year = Carbon::parse($validatedData['tanggal_lpt'])->year;
                $lptData['nomor_lpt'] = 'LPT-' . $validatedData['nomor_lpt_int'] . '/KBC.0102/' . $year;

                unset($lptData['photos']);
                $lpt->update($lptData);

                if ($request->hasFile('photos')) {
                    foreach ($request->file('photos') as $photo) {
                        $this->addPhotoToLpt($lpt, $photo);
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
        DB::transaction(function () use ($lpt) {
            $lpt->clearMediaCollection('photos');
            $lpt->delete();
        });

        return redirect()->route('lpt.index')->with('success', 'LPT berhasil dihapus');
    }

    /**
     * Menampilkan foto LPT dari penyimpanan privat.
     */
    public function showPhoto(Media $photo)
    {
        // Disarankan: Tambahkan pengecekan otorisasi di sini
        // $this->authorize('view', $photo);

        $disk = Storage::disk($photo->disk);
        $path = $photo->getPathRelativeToRoot();

        if (!$disk->exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return new Response($disk->get($path), 200, ['Content-Type' => $photo->mime_type]);
    }
}
