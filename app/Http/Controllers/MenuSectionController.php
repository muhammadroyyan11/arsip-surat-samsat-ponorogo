<?php

namespace App\Http\Controllers;

use App\Models\MenuSection;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MenuSectionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MenuSection::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<button onclick="editSection('.$row->id.')" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>';
                    $btn .= ' <button data-url="'.route('menu-sections.destroy', $row->id).'" data-name="'.$row->section_name.'" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('menu-sections.index');
    }

    public function store(Request $request)
    {
        $request->validate(['section_name' => 'required', 'order' => 'required|integer']);
        MenuSection::create($request->all());
        return response()->json(['success' => true, 'message' => 'Section berhasil ditambahkan.']);
    }

    public function show(MenuSection $menu_section)
    {
        return response()->json(['success' => true, 'data' => $menu_section]);
    }

    public function update(Request $request, MenuSection $menu_section)
    {
        $request->validate(['section_name' => 'required', 'order' => 'required|integer']);
        $menu_section->update($request->all());
        return response()->json(['success' => true, 'message' => 'Section berhasil diperbarui.']);
    }

    public function destroy(MenuSection $menu_section)
    {
        $menu_section->delete();
        return response()->json(['success' => true, 'message' => 'Section berhasil dihapus.']);
    }
}
