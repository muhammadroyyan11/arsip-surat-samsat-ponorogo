<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Staff;
use App\Models\MenuSection;
use App\Models\UserMenu;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with('staff');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('staff_name', function($row){ return $row->staff ? $row->staff->name : $row->name; })
                ->addColumn('action', function($row){
                    $btn = '<button onclick="manageAccess('.$row->id.')" class="btn btn-sm btn-info text-white"><i class="fas fa-key"></i> Hak Akses</button>';
                    $btn .= ' <button data-url="'.route('users.destroy', $row->id).'" data-name="'.$row->name.'" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $sections = MenuSection::with('menus')->orderBy('order')->get();
        $unregistered_staffs = Staff::doesntHave('user')->get();
        return view('users.index', compact('sections', 'unregistered_staffs'));
    }

    public function store(Request $request)
    {
        $request->validate(['staff_id' => 'required', 'email' => 'required|email|unique:users', 'password' => 'required']);
        $staff = Staff::findOrFail($request->staff_id);
        User::create([
            'staff_id' => $staff->id,
            'name' => $staff->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'staff'
        ]);
        return response()->json(['success' => true, 'message' => 'User berhasil dibuat.']);
    }

    public function getAccess($id)
    {
        $userMenus = UserMenu::where('user_id', $id)->pluck('menu_id')->toArray();
        return response()->json(['success' => true, 'menus' => $userMenus]);
    }

    public function updateAccess(Request $request, $id)
    {
        UserMenu::where('user_id', $id)->delete();
        if ($request->menus) {
            foreach($request->menus as $menu_id) {
                UserMenu::create([
                    'user_id' => $id,
                    'menu_id' => $menu_id
                ]);
            }
        }
        return response()->json(['success' => true, 'message' => 'Hak akses berhasil diperbarui.']);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success' => true, 'message' => 'User berhasil dihapus.']);
    }
}
