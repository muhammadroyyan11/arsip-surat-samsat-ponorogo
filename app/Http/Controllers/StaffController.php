<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Division;
use App\Models\Position;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\StaffsExport;
use App\Imports\StaffsImport;
use Maatwebsite\Excel\Facades\Excel;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Staff::with(['division', 'position']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('division_name', function($row){ return $row->division ? $row->division->name : '-'; })
                ->addColumn('position_name', function($row){ return $row->position ? $row->position->name : '-'; })
                ->addColumn('action', function($row){
                    $btn = '<button data-url="'.route('staffs.update', $row->id).'" class="btn btn-sm btn-primary btn-edit" data-name="'.$row->name.'" data-nip="'.$row->nip.'" data-phone="'.$row->phone.'" data-address="'.$row->address.'" data-division="'.$row->division_id.'" data-position="'.$row->position_id.'"><i class="fas fa-edit"></i></button>';
                    $btn .= ' <button data-url="'.route('staffs.destroy', $row->id).'" data-name="'.$row->name.'" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $divisions = Division::all();
        $positions = Position::all();
        return view('staffs.index', compact('divisions', 'positions'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'division_id' => 'required', 'position_id' => 'required']);
        Staff::create($request->all());
        return response()->json(['success' => true, 'message' => 'Staff berhasil ditambahkan.']);
    }

    public function update(Request $request, Staff $staff)
    {
        $request->validate(['name' => 'required', 'division_id' => 'required', 'position_id' => 'required']);
        $staff->update($request->all());
        return response()->json(['success' => true, 'message' => 'Staff berhasil diupdate.']);
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        return response()->json(['success' => true, 'message' => 'Staff berhasil dihapus.']);
    }

    public function export()
    {
        return Excel::download(new StaffsExport, 'staffs.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new StaffsImport, $request->file('file'));
        return redirect()->back()->with('success', 'Data staff berhasil diimpor.');
    }
}
