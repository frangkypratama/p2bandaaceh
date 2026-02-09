<?php

namespace App\Http\Controllers;

use App\Models\Lpt;
use App\Models\Sbp;
use Illuminate\Http\Request;

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
                    ->orderByRaw('CAST(nomor_lpt AS UNSIGNED) DESC')
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
        $request->validate([
            'nomor_lpt'   => 'required',
            'tanggal_lpt' => 'required|date',
            'jenis_lpt'   => 'required|in:' . implode(',', array_keys($jenis_lpt_options)),
            'sbp_id'      => 'required|exists:sbp,id',
        ]);

        Lpt::create($request->all());

        return redirect()->route('lpt.index')
                        ->with('success','LPT created successfully.');
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
        $request->validate([
            'nomor_lpt' => 'required',
            'tanggal_lpt' => 'required|date',
            'jenis_lpt'   => 'required|in:' . implode(',', array_keys($jenis_lpt_options)),
            'sbp_id' => 'required|exists:sbp,id',
        ]);

        $lpt->update($request->all());

        return redirect()->route('lpt.index')
                        ->with('success','LPT updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lpt $lpt)
    {
        $lpt->delete();

        return redirect()->route('lpt.index')
                        ->with('success','LPT deleted successfully');
    }
}
