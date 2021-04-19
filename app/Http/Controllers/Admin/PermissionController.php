<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
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
        return view('admin.permissions.index');
    }
    public function permissions()
    {
        $data = Permission::query();
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
                            onclick=ShowPermission(' .  $data->id . ')
                          class="edit btn btn-info btn-sm"
                          data-placement="top"
                          title="Permission View"
                          data-toggle="tooltip modal"
                        >
                          <i class="fa fa-eye blue"></i>
                        </button>
                        <button
                          type="button"
                            id="' . $data->id . '"
                            onclick=editPermission(' .  $data->id . ')
                          class="edit btn btn-warning btn-sm"
                          data-placement="top"
                          title="Permission Edit"
                          data-toggle="tooltip modal"
                        >
                          <i class="fa fa-edit blue"></i>
                        </button>
                        <button
                          type="button"
                          id="' . $data->id . '"
                            onclick=deletePermission(' . $data->id . ',"' . $data->name . '")
                          class="btn btn-danger btn-sm"
                          data-placement="top"
                          title="permission Delete"
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

    public function create()
    {
        // abort_if(Gate::denies('permission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissions.create');
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
            'permission_name' => ['required', 'unique:permissions,name'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $permission = new Permission();
        $permission->name = $request->permission_name;
        $permission->staff_id = $user->id;
        $permission->save();

        return ['success' => 'The permission has been successfull Saved'];
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission =  Permission::findOrFail($id);
        return $permission;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission =  Permission::findOrFail($id);
        return $permission;
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
        $permission =  Permission::findOrFail($id);
        $user = auth()->user();

        $validator =  Validator::make($request->all(), [
            'permission_name' => ['required', 'unique:permissions,name,' . $permission->id],
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }


        $permission->name = $request->permission_name;
        $permission->staff_id = $user->id;

        $permission->update();

        return ['success' => 'The permission has been successfull updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission =  Permission::findOrFail($id);
        $permission->delete();
        return ['success' => 'The permission has been successfull Deleted'];
    }
}
