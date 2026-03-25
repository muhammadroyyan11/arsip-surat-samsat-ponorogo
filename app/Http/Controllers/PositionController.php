<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PositionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Position::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<button data-url="'.route('positions.update', $row->id).'" class="btn btn-sm btn-primary btn-edit" data-name="'.$row->name.'"><i class="fas fa-edit"></i></button>';
                    $btn .= ' <button data-url="'.route('positions.destroy', $row->id).'" data-name="'.$row->name.'" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('positions.index');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Position::create($request->all());
        return response()->json(['success' => true, 'message' => 'Posisi berhasil ditambahkan.']);
    }

    public function update(Request $request, Position $position)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $position->update($request->all());
        return response()->json(['success' => true, 'message' => 'Posisi berhasil diupdate.']);
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return response()->json(['success' => true, 'message' => 'Posisi berhasil dihapus.']);
    }
}
