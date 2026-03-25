<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuSection;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Menu::with('section');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('section_name', function($row){ return $row->section ? $row->section->section_name : '-'; })
                ->addColumn('action', function($row){
                    $btn = '<button onclick="editMenu('.$row->id.')" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>';
                    $btn .= ' <button data-url="'.route('menus.destroy', $row->id).'" data-name="'.$row->menu_name.'" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $sections = MenuSection::orderBy('order')->get();
        return view('menus.index', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'section_id' => 'required',
            'menu_name' => 'required',
            'url' => 'required',
            'icon' => 'required',
            'order' => 'required|integer'
        ]);

        Menu::create($request->all());
        return response()->json(['success' => true, 'message' => 'Menu berhasil ditambahkan.']);
    }

    public function show(Menu $menu)
    {
        return response()->json(['success' => true, 'data' => $menu]);
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'section_id' => 'required',
            'menu_name' => 'required',
            'url' => 'required',
            'icon' => 'required',
            'order' => 'required|integer'
        ]);

        $menu->update($request->all());
        return response()->json(['success' => true, 'message' => 'Menu berhasil diperbarui.']);
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return response()->json(['success' => true, 'message' => 'Menu berhasil dihapus.']);
    }
}
