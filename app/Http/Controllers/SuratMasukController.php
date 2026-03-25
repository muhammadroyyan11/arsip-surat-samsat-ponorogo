<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\KategoriSurat;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SuratMasuk::with(['kategori', 'user']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('kategori_name', function($row){ return $row->kategori ? $row->kategori->name : '-'; })
                ->addColumn('user_name', function($row){ return $row->user ? $row->user->name : '-'; })
                ->addColumn('file_link', function($row){
                    return $row->file_path ? '<a href="'.asset('storage/'.$row->file_path).'" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-download"></i></a>' : '-';
                })
                ->addColumn('action', function($row){
                    $btn = '<button onclick="openDisposisi('.$row->id.')" class="btn btn-sm btn-warning text-white"><i class="fas fa-exchange-alt"></i> Disposisi</button> ';
                    $btn .= '<button data-url="'.route('surat-masuks.update', $row->id).'" class="btn btn-sm btn-primary btn-edit" data-name="'.$row->nomor_surat.'" data-nomor="'.$row->nomor_surat.'" data-tglsurat="'.$row->tanggal_surat.'" data-tglterima="'.$row->tanggal_terima.'" data-pengirim="'.$row->pengirim.'" data-perihal="'.$row->perihal.'" data-kategori="'.$row->kategori_id.'"><i class="fas fa-edit"></i></button>';
                    $btn .= ' <button data-url="'.route('surat-masuks.destroy', $row->id).'" data-name="'.$row->nomor_surat.'" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action', 'file_link'])
                ->make(true);
        }
        $kategories = KategoriSurat::all();
        $users = User::where('id', '!=', auth()->id())->get();
        return view('surat-masuks.index', compact('kategories', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'tanggal_terima' => 'required|date',
            'pengirim' => 'required',
            'perihal' => 'required',
            'kategori_id' => 'required',
            'file' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:5120'
        ]);

        $data = $request->except('file');
        $data['user_id'] = auth()->id();

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('surat_masuk', 'public');
        }

        SuratMasuk::create($data);
        return response()->json(['success' => true, 'message' => 'Surat Masuk berhasil ditambahkan.']);
    }

    public function update(Request $request, SuratMasuk $surat_masuk)
    {
        $request->validate([
            'nomor_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'tanggal_terima' => 'required|date',
            'pengirim' => 'required',
            'perihal' => 'required',
            'kategori_id' => 'required',
            'file' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:5120'
        ]);

        $data = $request->except('file');

        if ($request->hasFile('file')) {
            if ($surat_masuk->file_path && Storage::disk('public')->exists($surat_masuk->file_path)) {
                Storage::disk('public')->delete($surat_masuk->file_path);
            }
            $data['file_path'] = $request->file('file')->store('surat_masuk', 'public');
        }

        $surat_masuk->update($data);
        return response()->json(['success' => true, 'message' => 'Surat Masuk berhasil diupdate.']);
    }

    public function destroy(SuratMasuk $surat_masuk)
    {
        if ($surat_masuk->file_path && Storage::disk('public')->exists($surat_masuk->file_path)) {
            Storage::disk('public')->delete($surat_masuk->file_path);
        }
        $surat_masuk->delete();
        return response()->json(['success' => true, 'message' => 'Surat Masuk berhasil dihapus.']);
    }
}
