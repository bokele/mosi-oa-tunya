<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.preference.role');
    }

    public function role()
    {
        $data = role::query();
        return DataTables::eloquent($data)

            ->editColumn('created_at', function ($data) {

                return $data->created_at->diffForHumans();
            })

            ->editColumn('updated_at', function ($data) {

                return $data->updated_at->diffForHumans();
            })

            ->addColumn('actions', function ($data) {
                $button = '
                  <button
                          type="button"
                          id="' . $data->id . '"
                            onclick=showRole(' .  $data->id . ')
                          class="btn btn-info btn-sm"
                          data-placement="top"
                          title="Role View"
                          data-toggle="tooltip modal"
                        >
                          <i class="fa fa-eye red"></i>
                        </button>
                        <button
                          type="button"
                            id="' . $data->id . '"
                            onclick=editRole(' .  $data->id . ')
                          class="edit btn btn-warning btn-sm"
                          data-placement="top"
                          title="Role Edit"
                          data-toggle="tooltip modal"
                        >
                          <i class="fa fa-edit blue"></i>
                        </button>
                        <button
                          type="button"
                          id="' . $data->id . '"
                            onclick=deleteRole(' .  $data->id . ')
                          class="btn btn-danger btn-sm"
                          data-placement="top"
                          title="Role Delete"
                          data-toggle="tooltip modal"
                        >
                          <i class="fa fa-trash red"></i>
                        </button>

            ';
                return $button;
            })

            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $validator =  Validator::make($request->all(), [
            'role_name' => ['required',],
            'permissions.*' => [
                'integer',
            ],
            'permissions'   => [
                'required',
                'array',
            ],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $role = new Role;
        $role->name = $request->role_name;
        $role->staff_id = $user->id;

        $role->save();
        $role->permissions()->sync($request->input('permissions', []));

        return ['success' => 'The role has been successfull Saved'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role =  Role::findOrFail($id);
        $permissions = Permission::all()->pluck('title', 'id');

        $role->load('permissions');

        return ['permissions' => $permissions, 'role' => $role];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $validator =  Validator::make($request->all(), [
            'role_name' => ['required',],
            'permissions.*' => [
                'integer',
            ],
            'permissions'   => [
                'required',
                'array',
            ],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $role =  Role::findOrFail($id);
        $role->name = $request->role_name;
        $role->staff_id = $user->id;

        $role->update();
        $role->permissions()->sync($request->input('permissions', []));

        return ['success' => 'The role has been successfull Saved'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role =  Role::findOrFail($id);
        $role->delete();
        return ['success' => 'The role has been successfull Deleted'];
    }

    public function massDestroy(Request $request)
    {

        $validator =  Validator::make($request->all(), [
            'ids'   => 'required|array',
            'ids.*' => 'exists:roles,id',
        ]);
        Role::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
