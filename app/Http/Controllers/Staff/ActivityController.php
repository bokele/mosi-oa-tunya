<?php

namespace App\Http\Controllers\Staff;

use DOMDocument;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use File;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

use DateTime;

class ActivityController extends Controller
{

    function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('staff.activity.index');
    }

    public function activities()
    {
        $user = auth()->user();

        if ($user->is_superuser == 1) {
            $data = Activity::query();
        } else {
            $data = Activity::query()->where('staff_id', $user->id);
        }
        return DataTables::eloquent($data)
            // ->editColumn('started_at', function ($data) {

            //     return serializeDate($data->started_at);
            // })

            ->editColumn('created_at', function ($data) {

                return $data->created_at->diffForHumans();
            })

            ->editColumn('updated_at', function ($data) {

                return $data->updated_at->diffForHumans();
            })
            ->addColumn('slug', function ($data) {
                $link = '<a href="activity/' . $data->slug . '"  aria-disabled="true">' . $data->slug . '</a>';

                return  $link;
            })



            ->addColumn('actions', function ($data) {
                $button = '
                        <a
                          type="button"
                            id="' . $data->id . '"
                            href="' . route("admin.activity.edit", $data->id) . '"
                          class="edit btn btn-warning btn-sm"
                          data-placement="top"
                          title="activity Edit"
                          data-toggle="tooltip modal"
                        >
                          <i class="fa fa-edit blue"></i>
                        </a>
                        <button
                          type="button"
                          id="' . $data->id . '"
                            onclick="deleteactivity(' . $data->id . ',\'' . $data->activity_code . '\')"
                          class="btn btn-danger btn-sm"
                          data-placement="top"
                          title="activity Delete"
                          data-toggle="tooltip modal"
                        >
                          <i class="fa fa-trash red"></i>
                        </button>
            ';
                return $button;
            })

            ->rawColumns(['actions', 'slug'])
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff.activity.create');
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

        $validated  = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required',
            'started_at' => 'required',
            'ended_at' => 'required',
        ]);


        $createStartDate = new DateTime($request->started_at);
        $start_date = $createStartDate->format('Y-m-d');

        $createEndDate = new DateTime($request->ended_at);
        $end_date = $createEndDate->format('Y-m-d');


        $start_date = Carbon::createFromFormat('Y-m-d', $start_date);

        $end_date = Carbon::createFromFormat('Y-m-d', $end_date);

        if ($end_date->gte($start_date)) {

            $file_name = "";
            $uploaded_file = "";
            // check if folder exit and if not create it
            $path = public_path('support/document/');
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            };

            if ($request->file('support_file')) {
                $support_file = $request->file('support_file');
                // DSF : D: activity S:support F: File
                $file_name = 'DSF-' . date('YmdHis') . '_' . $request->file->getClientOriginalName();
                $support_file->move($path, $file_name);
                $uploaded_file = 'support/document/' . $file_name;
            }
            $activity = new Activity;
            $latesactivity = Activity::orderBy('created_at', 'DESC')->first();
            if ($latesactivity == "") {
                $code = date('ymd') . '-' . str_pad(0 + 1, 8, "0", STR_PAD_LEFT);
            } else {
                $code = date('ymd') . '-' . str_pad($latesactivity->id + 1, 8, "0", STR_PAD_LEFT);
            }
            $dom = new DOMDocument();
            $dom->loadHtml($request->description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $content = $dom->saveHTML();

            $activity->activity_code  = $code;
            $activity->name = $request->title;
            $activity->slug = date('ymd') . '-' . Str::slug($request->title, '-');
            $activity->description = $request->description;
            $activity->started_at = $request->started_at;
            $activity->ended_at = $request->ended_at;
            $activity->support_activite_file = $uploaded_file;
            $activity->staff_id  = $user->id;
            $activity->created_user_id  = $user->id;
            $activity->status_id   = 1;
            $activity->save();
            return redirect()->route('admin.activity.index')->with('success', 'Your Activity has been successfull Saved');
        } else {
            return back()->with('error', 'End date must be greater than Start date');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('staff.activity.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        // $activity =  Activity::findOrFail($id);
        return view('staff.activity.edit', compact('activity'));
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

        $validated  = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required',
            'started_at' => 'required',
            'ended_at' => 'required',
        ]);
        $createStartDate = new DateTime($request->started_at);
        $start_date = $createStartDate->format('Y-m-d');

        $createEndDate = new DateTime($request->ended_at);
        $end_date = $createEndDate->format('Y-m-d');


        $start_date = Carbon::createFromFormat('Y-m-d', $start_date);

        $end_date = Carbon::createFromFormat('Y-m-d', $end_date);

        if ($end_date->gte($start_date)) {
            $file_name = "";
            $uploaded_file = "";
            // check if folder exit and if not create it
            $path = public_path('support/document/');
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            };

            if ($request->file('support_file')) {
                $support_file = $request->file('support_file');
                // DSF : D: activity S:support F: File
                $file_name = 'DSF-' . date('YmdHis') . '_' . $request->file->getClientOriginalName();
                $support_file->move($path, $file_name);
                $uploaded_file = 'support/document/' . $file_name;
            }
            $activity =  Activity::findOrFail($id);
            $latesactivity = Activity::orderBy('created_at', 'DESC')->first();
            if ($latesactivity == "") {
                $code = date('ymd') . '-' . str_pad(0 + 1, 8, "0", STR_PAD_LEFT);
            } else {
                $code = date('ymd') . '-' . str_pad($latesactivity->id + 1, 8, "0", STR_PAD_LEFT);
            }
            $dom =  new DOMDocument();
            $dom->loadHtml($request->description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $content = $dom->saveHTML();


            $activity->name = $request->title;
            $activity->slug = $activity->activity_code . '-' . Str::slug($request->title, '-');
            $activity->description = $request->description;
            $activity->started_at = $request->started_at;
            $activity->ended_at = $request->ended_at;
            $activity->support_activite_file = $uploaded_file;
            $activity->staff_id  = $user->id;
            $activity->status_id   = 1;
            $activity->update();
            return redirect()->route('admin.activity.index')->with('success', 'Your Activity has been successfull Saved');
        } else {
            return back()->with('error', 'End date must be greater than Start date');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $activity =  Activity::findOrFail($id);
        $activity->delete();
        return ['success' => 'The activity  has been successfull Deleted'];
    }
}
