<?php

namespace App\Http\Controllers;

use App\Models\Lpt;
use App\Models\Sbp;
use Illuminate\Http\Request;

class LptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lpt = Lpt::with('sbp')->orderBy('tanggal_lpt', 'desc')->paginate(10);
        return view('lpt.index', compact('lpt'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sbp = Sbp::orderBy('tanggal_sbp', 'desc')->get();
        return view('lpt.create', compact('sbp'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_lpt' => 'required',
            'tanggal_lpt' => 'required|date',
            'jenis_lpt' => 'required',
            'sbp_id' => 'required|exists:sbp,id',
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
        return view('lpt.edit',compact('lpt', 'sbp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lpt $lpt)
    {
        $request->validate([
            'nomor_lpt' => 'required',
            'tanggal_lpt' => 'required|date',
            'jenis_lpt' => 'required',
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
