<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DisposisiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Disposisi::with(['suratMasuk', 'fromUser'])
                ->where('to_user_id', auth()->id())
                ->orderBy('created_at', 'desc');
                
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nomor_surat', function($row){ return $row->suratMasuk->nomor_surat; })
                ->addColumn('pengirim', function($row){ return $row->suratMasuk->pengirim; })
                ->addColumn('dari', function($row){ return $row->fromUser->name; })
                ->addColumn('status_label', function($row){
                    $class = $row->status == 'Pending' ? 'warning' : 'success';
                    return '<span class="badge bg-'.$class.'">'.$row->status.'</span>';
                })
                ->addColumn('action', function($row){
                    $btn = '<button onclick="viewDetail('.$row->id.')" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i> Detail</button>';
                    if($row->status == 'Pending') {
                        $btn .= ' <button onclick="markDone('.$row->id.')" class="btn btn-sm btn-success"><i class="fas fa-check"></i> Selesai</button>';
                    }
                    return $btn;
                })
                ->rawColumns(['status_label', 'action'])
                ->make(true);
        }
        return view('disposis.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'surat_masuk_id' => 'required',
            'to_user_id' => 'required',
            'sifat' => 'required',
            'catatan_disposisi' => 'nullable',
            'deadline' => 'nullable|date'
        ]);

        Disposisi::create([
            'surat_masuk_id' => $request->surat_masuk_id,
            'from_user_id' => auth()->id(),
            'to_user_id' => $request->to_user_id,
            'sifat' => $request->sifat,
            'catatan_disposisi' => $request->catatan_disposisi,
            'deadline' => $request->deadline,
            'status' => 'Pending'
        ]);

        return response()->json(['success' => true, 'message' => 'Disposisi berhasil dikirim.']);
    }

    public function markDone($id)
    {
        $disposisi = Disposisi::where('to_user_id', auth()->id())->findOrFail($id);
        $disposisi->update(['status' => 'Selesai']);
        return response()->json(['success' => true, 'message' => 'Status disposisi diperbarui menjadi Selesai.']);
    }

    public function show($id)
    {
        $disposisi = Disposisi::with(['suratMasuk.kategori', 'fromUser'])->findOrFail($id);
        return response()->json(['success' => true, 'data' => $disposisi]);
    }
}
