<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\UserDepartment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('business.employees.index');
    }

    public function getDataTable()
    {
        $data = Employee::select([
            'employees.id',
            'employees.first_name',
            'employees.last_name',
            'employees.employee_code',
            'employees.job_title',
            'employees.phone',
            'employees.work_email',
            'employees.employment_type',
            'employees.employment_status',
            'employees.joining_date',
            'employees.user_id',
            'employees.status',
            DB::raw('tbl_master_user_department.name AS department_name'),
        ])
        ->leftJoin('tbl_master_user_department', 'tbl_master_user_department.id', '=', 'employees.department')
        ->orderBy('employees.id', 'asc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $buttons  = '<a href="javascript:;" class="btn btn-sm btn-outline-primary me-1" onclick="editEmployee(' . $row->id . ')" title="Edit"><i class="fa fa-pencil"></i></a>';
                $buttons .= '<a href="javascript:;" class="btn btn-sm btn-outline-info me-1" onclick="viewEmployee(' . $row->id . ')" title="View"><i class="fa fa-eye"></i></a>';
                if (!$row->user_id) {
                    $buttons .= '<a href="javascript:;" class="btn btn-sm btn-outline-success" onclick="createUserForEmployee(' . $row->id . ',\'' . addslashes($row->first_name) . '\',\'' . addslashes($row->last_name) . '\')" title="Create Login"><i class="fa fa-user-plus"></i></a>';
                } else {
                    $buttons .= '<span class="badge bg-success ms-1" style="font-size:10px;"><i class="fa fa-check me-1"></i>Has Login</span>';
                }
                return $buttons;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getMasterData()
    {
        $departments = UserDepartment::select('id', 'name')->get();
        $managers    = Employee::select('id', 'first_name', 'last_name')->where('employment_status', 'active')->get();

        return response()->json(['departments' => $departments, 'managers' => $managers]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'employee_code' => 'nullable|string|unique:employees,employee_code',
            'work_email'    => 'nullable|email',
            'personal_email'=> 'nullable|email',
            'phone'         => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'joining_date'  => 'nullable|date',
            'basic_salary'  => 'nullable|numeric|min:0',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()], 422);
        }

        try {
            DB::beginTransaction();

            $data = $request->except('profile_photo', '_token');
            $data['created_by'] = Auth::id();
            $data['status']     = $request->has('status') ? 1 : 0;

            if ($request->hasFile('profile_photo')) {
                $data['profile_photo'] = $request->file('profile_photo')->store('employees/photos', 'public');
            }

            $employee = Employee::create($data);
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Employee saved successfully.', 'employee' => $employee]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'employee_code' => 'nullable|string|unique:employees,employee_code,' . $id,
            'work_email'    => 'nullable|email',
            'personal_email'=> 'nullable|email',
            'phone'         => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'joining_date'  => 'nullable|date',
            'basic_salary'  => 'nullable|numeric|min:0',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()], 422);
        }

        try {
            DB::beginTransaction();

            $data = $request->except('profile_photo', '_token', '_method');
            $data['status'] = $request->has('status') ? 1 : 0;

            if ($request->hasFile('profile_photo')) {
                if ($employee->profile_photo) Storage::disk('public')->delete($employee->profile_photo);
                $data['profile_photo'] = $request->file('profile_photo')->store('employees/photos', 'public');
            }

            $employee->update($data);
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Employee updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function getDetails($id)
    {
        $employee = Employee::with('departmentInfo')->findOrFail($id);
        return response()->json(['success' => true, 'data' => $employee]);
    }

    public function destroy($id)
    {
        Employee::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Employee removed.']);
    }

    // Returns employees without a login account (for user creation dropdown)
    public function getUnlinkedEmployees()
    {
        $employees = Employee::whereNull('user_id')
            ->where('employment_status', 'active')
            ->select('id', 'first_name', 'last_name', 'work_email')
            ->get();

        return response()->json(['success' => true, 'data' => $employees]);
    }

    // Link employee to a user account after user is created
    public function linkUser(Request $request, $id)
    {
        Employee::findOrFail($id)->update(['user_id' => $request->user_id]);
        return response()->json(['success' => true]);
    }
}