<?php

namespace App\Http\Controllers;

use App\Models\pengajuan_cuti;
use App\Http\Requests\Storepengajuan_cutiRequest;
use App\Http\Requests\Updatepengajuan_cutiRequest;
use Illuminate\Support\Facades\Auth;

class PengajuanCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.cuti.create');
        return true;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storepengajuan_cutiRequest $request)
    {
        $request->validate([
            'jenis_cuti' => 'required|in:tahunan,sakit',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string',
            'surat_sakit' => 'required_if:jenis_cuti,sakit|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $suratPath = null;

        if ($request->hasFile('surat_sakit')) {
            $suratPath = $request->file('surat_sakit')->store('surat_cuti', 'public');
        }

            Pengajuan_Cuti::create([
                'user_id' => Auth::id(),
                'jenis_cuti' => $request->jenis_cuti,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'alasan' => $request->alasan,
                'surat_sakit' => $suratPath, // menyimpan path file
            ]);

            return redirect()->route('dashboard')->with('success', 'Pengajuan cuti berhasil diajukan.');
            
    }

    /**
     * Display the specified resource.
     */
    public function show(pengajuan_cuti $pengajuan_cuti)
    {
            $cuti = pengajuan_cuti::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            $user = Auth::user();
            // dd($cuti);
            return view('dashboard.cuti.index', compact('cuti','user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pengajuan_cuti $pengajuan_cuti)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatepengajuan_cutiRequest $request, pengajuan_cuti $pengajuan_cuti)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pengajuan_cuti $pengajuan_cuti)
    {
        //
    }
}
