<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditLogController extends Controller
{
    public function index()
    {
        return view('audit.index');
    }

    public function data(Request $request)
{
    $query = DB::table('tbl_audit_logs as a')
        ->leftJoin('users as u', 'u.id', '=', 'a.user_id')
        ->select([
            'a.id',
            'a.action',
            'a.module',
            'a.description',
            'a.ip_address',
            'a.old_values',
            'a.new_values',
            'a.created_at',
            DB::raw("COALESCE(a.user_name, CONCAT(u.first_name, ' ', u.last_name)) as user_name"),
        ]);

    if ($request->module)    $query->where('a.module', $request->module);
    if ($request->action)    $query->where('a.action', $request->action);
    if ($request->date_from) $query->whereDate('a.created_at', '>=', $request->date_from);
    if ($request->date_to)   $query->whereDate('a.created_at', '<=', $request->date_to);

    $total = $query->count();

    $start  = intval($request->start ?? 0);
    $length = intval($request->length ?? 25);

    $rows = $query->orderBy('a.id', 'desc')
        ->skip($start)
        ->take($length)
        ->get();

    $data = $rows->map(function ($row, $i) use ($start) {
        $badgeColor = match($row->action) {
            'CREATE'        => 'success',
            'UPDATE'        => 'primary',
            'DELETE'        => 'danger',
            'STATUS_CHANGE' => 'warning',
            'LOGIN'         => 'info',
            'LOGOUT'        => 'secondary',
            default         => 'dark',
        };

        $hasChanges = $row->old_values || $row->new_values;

        return [
            'DT_RowIndex'  => $start + $i + 1,
            'action'       => $row->action,
            'action_badge' => "<span class='badge bg-{$badgeColor}'>{$row->action}</span>",
            'user_name'    => $row->user_name,
            'module'       => $row->module,
            'description'  => $row->description,
            'ip_address'   => $row->ip_address,
            'created_at'   => $row->created_at,
            'changes'      => $hasChanges
                ? "<button class='btn btn-xs btn-outline-secondary' style='font-size:.75rem;' onclick='viewChanges({$row->id})'>View</button>"
                : '—',
        ];
    });

    return response()->json([
        'draw'            => intval($request->draw ?? 1),
        'recordsTotal'    => $total,
        'recordsFiltered' => $total,
        'data'            => $data,
    ]);
}

    public function details($id)
    {
        $row = DB::table('tbl_audit_logs as a')
            ->leftJoin('users as u', 'u.id', '=', 'a.user_id')
            ->where('a.id', $id)
            ->select([
                'a.*',
                DB::raw("CONCAT(u.first_name, ' ', u.last_name) as user_name"),
            ])
            ->first();

        if (!$row) {
            return response()->json(['success' => false]);
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'action'      => $row->action,
                'module'      => $row->module,
                'description' => $row->description,
                'user_name'   => $row->user_name,
                'old_values'  => json_decode($row->old_values, true),
                'new_values'  => json_decode($row->new_values, true),
            ],
        ]);
    }
}