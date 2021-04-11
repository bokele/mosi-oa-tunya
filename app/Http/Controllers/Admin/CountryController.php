<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
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
        return view('admin.preference.country');
    }

    public function country()
    {
        $data = Country::query();
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
                            onclick=ShowCountry(' .  $data->id . ')
                          class="show btn btn-warning btn-sm"
                          data-placement="top"
                          title="Country Show"
                          data-toggle="tooltip modal"
                        >
                          <i class="fa fa-edit blue"></i>
                        </button>
                        <button
                          type="button"
                            id="' . $data->id . '"
                            onclick=editCountry(' .  $data->id . ')
                          class="edit btn btn-warning btn-sm"
                          data-placement="top"
                          title="Country Edit"
                          data-toggle="tooltip modal"
                        >
                          <i class="fa fa-edit blue"></i>
                        </button>
                        <button
                          type="button"
                          id="' . $data->id . '"
                            onclick=deleteCountry(' .  $data->id . ')
                          class="btn btn-danger btn-sm"
                          data-placement="top"
                          title="Country Delete"
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $validator =  Validator::make($request->all(), [
            'country_name' => ['required', 'unique:countries,name'],
            'country_code' => ['required', 'unique:countries,code'],
            'short_name' => ['required',],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $country = new Country();
        $country->name = $request->country_name;
        $country->code = $request->country_code;
        $country->short_name = $request->short_name;
        $country->staff_id = $user->id;

        $country->save();

        return ['success' => 'The country has been successfull Saved'];
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country =  Country::findOrFail($id);
        return $country;
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
        $country =  Country::findOrFail($id);
        $validator =  Validator::make($request->all(), [
            'country_name' => ['required', 'unique:countries,name'. $country->id],
            'country_code' => ['required', 'unique:countries,code' .$country->id],
            'short_name' => ['required',],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }


        $country->name = $request->country_name;
        $country->code = $request->country_code;
        $country->short_name = $request->short_name;
        $country->staff_id = $user->id;

        $country->update();

        return ['success' => 'The country has been successfull Saved'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $country =  Country::findOrFail($id);
        $country->delete();
        return ['success' => 'The country has been successfull Deleted']
    }
}
