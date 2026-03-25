<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DivisionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Division::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<button data-url="'.route('divisions.update', $row->id).'" class="btn btn-sm btn-primary btn-edit" data-name="'.$row->name.'"><i class="fas fa-edit"></i></button>';
                    $btn .= ' <button data-url="'.route('divisions.destroy', $row->id).'" data-name="'.$row->name.'" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('divisions.index');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Division::create($request->all());
        return response()->json(['success' => true, 'message' => 'Divisi berhasil ditambahkan.']);
    }

    public function update(Request $request, Division $division)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $division->update($request->all());
        return response()->json(['success' => true, 'message' => 'Divisi berhasil diupdate.']);
    }

    public function destroy(Division $division)
    {
        $division->delete();
        return response()->json(['success' => true, 'message' => 'Divisi berhasil dihapus.']);
    }
}
