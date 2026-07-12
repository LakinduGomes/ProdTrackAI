<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Modules;
use App\Models\User;
use App\Models\UserLevel;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use App\Repositories\SystemUserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SystemUserController extends Controller
{
    protected $userRepository;

    public function __construct(SystemUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        if (!Auth::check()) return view('auth.login');
        $users = $this->userRepository->getAll();
        return view('users.index', compact('users'));
    }

    public function getMasterData()
    {
        $user_level = UserLevel::selectRaw('id,code')->get();

        $unlinked_employees = Employee::whereNull('user_id')
            ->where('employment_status', 'active')
            ->select('id', 'first_name', 'last_name', 'work_email')
            ->get();

        return response()->json([
            'user_level'         => $user_level,
            'unlinked_employees' => $unlinked_employees,
        ]);
    }

    public function getDataTable()
    {
        $user_level = User::where('id', Auth::id())->value('level');

        $data = User::select([
            'users.id',
            'users.first_name',
            'users.last_name',
            'users.email',
            'users.status',
            DB::raw('tbl_master_user_level.code AS level_name'),
        ])
        ->leftJoin('tbl_master_user_level', 'tbl_master_user_level.id', '=', 'users.level')
        ->orderBy('users.id', 'asc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) use ($user_level) {
                if ($user_level == 999) {
                    return '
                        <a href="javascript:;" class="btn btn-sm btn-outline-primary" onclick="editInfo(' . $row->id . ')" title="Edit User">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="javascript:;" class="btn btn-sm btn-outline-info" onclick="permissionInfo(' . $row->id . ')" title="Permission">
                            <i class="fa fa-cogs"></i>
                        </a>';
                }
                return '';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'level'      => 'required',
            'password'   => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()], 422);
        }

        try {
            DB::beginTransaction();

            $system_user = User::create([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'level'      => $request->level,
                'password'   => Hash::make($request->password),
                'status'     => $request->status ? 1 : 0,
            ]);

            if ($request->filled('employee_id')) {
                Employee::where('id', $request->employee_id)
                    ->whereNull('user_id')
                    ->update(['user_id' => $system_user->id]);
            }

            DB::commit();

            return response()->json([
                'success'     => true,
                'message'     => 'User created successfully!',
                'system_user' => $system_user,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function storePermissions(Request $request)
    {
        $modules        = Modules::select('id', 'name')->where('status', 1)->get();
        $checkedModules = $request->input('modules', []);

        $checkedModuleArray = [];
        foreach ($checkedModules as $checkedModule) {
            $checkedModuleArray[$checkedModule] = $checkedModule;
        }

        DB::table('tbl_user_permissions')->where('user', $request->user_id)->delete();

        $system_user = null;
        foreach ($modules as $module) {
            if (!empty($checkedModuleArray[$module->id]) && $checkedModuleArray[$module->id] == $module->id) {
                try {
                    $system_user = UserPermission::create([
                        'user'   => $request->user_id,
                        'module' => $module->id,
                    ]);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }
        }

        return response()->json(['success' => true, 'message' => 'Permissions saved successfully!', 'system_user' => $system_user]);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $user = User::find($id);
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not found!'], 404);
            }

            $rules = [
                'first_name' => 'required|string|max:255',
                'last_name'  => 'required|string|max:255',
                'email'      => "required|email|unique:users,email,{$id}",
                'level'      => 'required',
            ];

            if ($request->filled('password')) {
                $rules['password'] = 'min:8|confirmed';
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->all()], 422);
            }

            $updateData = [
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'level'      => $request->level,
                'status'     => $request->status ? 1 : 0,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);
            DB::commit();

            return response()->json(['success' => true, 'message' => 'User updated successfully!', 'user' => $user]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $this->userRepository->delete($id);
        return redirect()->back()->with('success', 'User deleted successfully!');
    }

    public function getUserDetails($id)
    {
        $user = User::select('id', 'first_name', 'last_name', 'email', 'status', 'level')->find($id);
        if ($user) {
            return response()->json(['success' => true, 'data' => $user]);
        }
        return response()->json(['success' => false, 'message' => 'User not found']);
    }

    public function getUserModuleDetails($id)
    {
        $user        = User::select('id', 'first_name', 'last_name', 'email', 'status', 'level')->find($id);
        $modules     = Modules::select('id', 'name')->where('status', 1)->orderBy('section', 'ASC')->get();
        $permissions = UserPermission::select('id', 'user', 'module')->where('user', $id)->get();

        if ($user) {
            return response()->json(['success' => true, 'data' => $user, 'modules' => $modules, 'permissions' => $permissions]);
        }
        return response()->json(['success' => false, 'message' => 'User not found']);
    }
}