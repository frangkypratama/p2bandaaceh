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

class LptController extends Controller
{
    /**
     * Define the source of truth for LPT types and their properties.
     * @return array
     */
    private function getJenisLptOptions(): array
    {
        return [
            'bandara' => [
                'name' => 'LPT Penindakan Bandara',
                'icon' => 'cil-flight-takeoff',
            ],
            'opsar'   => [
                'name' => 'LPT Operasi Pasar',
                'icon' => 'cil-bullhorn',
            ],
            'cukai'   => [
                'name' => 'LPT Penindakan Cukai',
                'icon' => 'cil-storage',
            ],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lpt = Lpt::with('sbp')
                    ->orderBy('tanggal_lpt', 'desc')
                    ->orderBy('nomor_lpt_int', 'desc')
                    ->paginate(10);
        $jenis_lpt_options = $this->getJenisLptOptions();
        return view('lpt.index', compact('lpt', 'jenis_lpt_options'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $jenis = $request->query('jenis');
        $sbp = Sbp::orderBy('tanggal_sbp', 'desc')->get();
        $jenis_lpt_options = $this->getJenisLptOptions();

        return view('lpt.create', compact('sbp', 'jenis', 'jenis_lpt_options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $jenis_lpt_options = $this->getJenisLptOptions();
        $validatedData = $request->validate([
            'nomor_lpt_int' => 'required|integer|unique:lpt,nomor_lpt_int',
            'tanggal_lpt'   => 'required|date',
            'jenis_lpt'     => 'required|in:' . implode(',', array_keys($jenis_lpt_options)),
            'sbp_id'        => 'required|exists:sbp,id',
            'photos'        => 'nullable|array',
            'photos.*'      => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240'
        ]);

        try {
            DB::transaction(function () use ($request, $validatedData) {
                $lptData = $validatedData;

                // Generate nomor_lpt string
                $year = Carbon::parse($validatedData['tanggal_lpt'])->year;
                $lptData['nomor_lpt'] = 'LPT-' . $validatedData['nomor_lpt_int'] . '/KBC.0102/' . $year;

                unset($lptData['photos']);
                $lpt = Lpt::create($lptData);

                if ($request->hasFile('photos')) {
                    foreach ($request->file('photos') as $photo) {
                        $path = $photo->store('lpt-photos', 'public');
                        LptPhoto::create([
                            'lpt_id' => $lpt->id,
                            'file_path' => $path
                        ]);
                    }
                }
            });

            return redirect()->route('lpt.index')->with('success','LPT berhasil dibuat.');
        } catch (\Exception $e) {
            logger()->error('Failed to create LPT: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat LPT. Silakan coba lagi.')->withInput();
        }
    }

    /**
     * Display a preview of the specified resource.
     */
    public function preview($id)
    {
        $lpt = Lpt::with(['sbp', 'photos'])->findOrFail($id);
        $jenis_lpt_options = $this->getJenisLptOptions();

        $pdf = Pdf::loadView('templatecetak.template-lpt', compact('lpt', 'jenis_lpt_options'))
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        $filename = str_replace('/', '-', $lpt->nomor_lpt) . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lpt $lpt)
    {
        $sbp = Sbp::orderBy('tanggal_sbp', 'desc')->get();
        $jenis_lpt_options = $this->getJenisLptOptions();
        return view('lpt.edit', compact('lpt', 'sbp', 'jenis_lpt_options'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lpt $lpt)
    {
        $jenis_lpt_options = $this->getJenisLptOptions();
        $validatedData = $request->validate([
            'nomor_lpt_int' => ['required', 'integer', Rule::unique('lpt')->ignore($lpt->id)],
            'tanggal_lpt'   => 'required|date',
            'jenis_lpt'     => 'required|in:' . implode(',', array_keys($jenis_lpt_options)),
            'sbp_id'        => 'required|exists:sbp,id',
            'photos'        => 'nullable|array',
            'photos.*'      => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        try {
            DB::transaction(function () use ($request, $lpt, $validatedData) {
                $lptData = $validatedData;

                // Re-generate nomor_lpt string
                $year = Carbon::parse($validatedData['tanggal_lpt'])->year;
                $lptData['nomor_lpt'] = 'LPT-' . $validatedData['nomor_lpt_int'] . '/KBC.0102/' . $year;

                unset($lptData['photos']);
                $lpt->update($lptData);

                if ($request->hasFile('photos')) {
                    foreach ($request->file('photos') as $photo) {
                        $path = $photo->store('lpt-photos', 'public');
                        LptPhoto::create([
                            'lpt_id'    => $lpt->id,
                            'file_path' => $path,
                        ]);
                    }
                }
            });
            
            return redirect()->route('lpt.index')->with('success','LPT berhasil diupdate');
        } catch (\Exception $e) {
            logger()->error('LPT gagal diupdate: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui LPT. Silakan coba lagi.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lpt $lpt)
    {
        $lpt->delete();

        return redirect()->route('lpt.index')
                        ->with('success','LPT berhasil dihapus');
    }
}
