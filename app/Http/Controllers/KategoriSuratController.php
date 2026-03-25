<?php

namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\KategoriSuratExport;
use App\Imports\KategoriSuratImport;
use Maatwebsite\Excel\Facades\Excel;

class KategoriSuratController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = KategoriSurat::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<button data-url="'.route('kategori-surats.update', $row->id).'" class="btn btn-sm btn-primary btn-edit" data-name="'.$row->name.'"><i class="fas fa-edit"></i></button>';
                    $btn .= ' <button data-url="'.route('kategori-surats.destroy', $row->id).'" data-name="'.$row->name.'" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('kategori-surats.index');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        KategoriSurat::create($request->all());
        return response()->json(['success' => true, 'message' => 'Kategori berhasil ditambahkan.']);
    }

    public function update(Request $request, KategoriSurat $kategori_surat)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $kategori_surat->update($request->all());
        return response()->json(['success' => true, 'message' => 'Kategori berhasil diupdate.']);
    }

    public function destroy(KategoriSurat $kategori_surat)
    {
        $kategori_surat->delete();
        return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus.']);
    }

    public function export()
    {
        return Excel::download(new KategoriSuratExport, 'kategori_surat.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new KategoriSuratImport, $request->file('file'));
        return redirect()->back()->with('success', 'Data kategori surat berhasil diimpor.');
    }
}
