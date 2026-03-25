<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\KategoriSurat;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SuratKeluar::with(['kategori', 'user']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('kategori_name', function($row){ return $row->kategori ? $row->kategori->name : '-'; })
                ->addColumn('user_name', function($row){ return $row->user ? $row->user->name : '-'; })
                ->addColumn('file_link', function($row){
                    return $row->file_path ? '<a href="'.asset('storage/'.$row->file_path).'" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-download"></i></a>' : '-';
                })
                ->addColumn('action', function($row){
                    $btn = '<button data-url="'.route('surat-keluars.update', $row->id).'" class="btn btn-sm btn-primary btn-edit" data-name="'.$row->nomor_surat.'" data-nomor="'.$row->nomor_surat.'" data-tglsurat="'.$row->tanggal_surat.'" data-tujuan="'.$row->tujuan.'" data-perihal="'.$row->perihal.'" data-kategori="'.$row->kategori_id.'"><i class="fas fa-edit"></i></button>';
                    $btn .= ' <button data-url="'.route('surat-keluars.destroy', $row->id).'" data-name="'.$row->nomor_surat.'" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action', 'file_link'])
                ->make(true);
        }
        $kategories = KategoriSurat::all();
        return view('surat-keluars.index', compact('kategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'tujuan' => 'required',
            'perihal' => 'required',
            'kategori_id' => 'required',
            'file' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:5120'
        ]);

        $data = $request->except('file');
        $data['user_id'] = auth()->id();

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('surat_keluar', 'public');
        }

        SuratKeluar::create($data);
        return response()->json(['success' => true, 'message' => 'Surat Keluar berhasil ditambahkan.']);
    }

    public function update(Request $request, SuratKeluar $surat_keluar)
    {
        $request->validate([
            'nomor_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'tujuan' => 'required',
            'perihal' => 'required',
            'kategori_id' => 'required',
            'file' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:5120'
        ]);

        $data = $request->except('file');

        if ($request->hasFile('file')) {
            if ($surat_keluar->file_path && Storage::disk('public')->exists($surat_keluar->file_path)) {
                Storage::disk('public')->delete($surat_keluar->file_path);
            }
            $data['file_path'] = $request->file('file')->store('surat_keluar', 'public');
        }

        $surat_keluar->update($data);
        return response()->json(['success' => true, 'message' => 'Surat Keluar berhasil diupdate.']);
    }

    public function destroy(SuratKeluar $surat_keluar)
    {
        if ($surat_keluar->file_path && Storage::disk('public')->exists($surat_keluar->file_path)) {
            Storage::disk('public')->delete($surat_keluar->file_path);
        }
        $surat_keluar->delete();
        return response()->json(['success' => true, 'message' => 'Surat Keluar berhasil dihapus.']);
    }
}
