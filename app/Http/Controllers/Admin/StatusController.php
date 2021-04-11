<?php

namespace App\Http\Controllers\Admin;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return middleware
     */
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
        return view('admin.preference.status');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Datatable respone
     */
    public function status()
    {
        $data = Status::query();
        return DataTables::eloquent($data)

            ->editColumn('status_code', function ($data) {

                return '<span class="p-1 mb-1 ' . $data->status_code . '">' . $data->status_code . '</span>';
            })
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
                            onclick=editStatus(' .   $data->id . ')
                          class="edit btn btn-warning btn-sm"
                          data-placement="top"
                          title="Status Edit"
                          data-toggle="tooltip modal"
                        >
                          <i class="fa fa-edit blue"></i>
                        </button>
                        <button
                          type="button"
                          id="' . $data->id . '"
                            onclick=deleteStatus(' .   $data->id . ')
                          class="btn btn-danger btn-sm"
                          data-placement="top"
                          title="Status Delete"
                          data-toggle="tooltip modal"
                        >
                          <i class="fa fa-trash red"></i>
                        </button>
            ';
                return $button;
            })

            ->rawColumns(['status', 'status_code', 'actions'])
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
            'status_name' => ['required', 'unique:statuses,name,type' . $request->type],
            'type' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $status = new Status;
        $status_code = '';
        $status->name = $request->status_name;
        $status->status_code  = $status_code;
        $status->type  = $request->type;
        $status->staff_id = $user->id;

        $status->save();

        return ['success' => 'The Status has been successfull Saved'];
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $status =  Status::findOrFail($id);
        return $status;
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
        $status =  Status::findOrFail($id);
        $validator =  Validator::make($request->all(), [
            'status_name' => ['required', 'unique:statuses,name,type' . $request->type],
            'type' => ['required',],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $status->name = $request->status_name;
        $status->status_code  = $request->status_code;
        $status->staff_id = $user->id;

        $status->save();

        return ['success' => 'The category has been successfull Updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status =  Status::findOrFail($id);
        $status->delete();

        return ['success' => 'The Status has been successfull Deleted'];
    }
}
