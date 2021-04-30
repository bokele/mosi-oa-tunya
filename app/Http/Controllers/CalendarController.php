<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $validated  = $request->validate([
            'title' => 'required|min:3|max:255',
            'started_at' => 'required',
            'ended_at' => 'required',
        ]);

        $start_date = Carbon::createFromFormat('Y-m-d', $request->started_at);

        $end_date = Carbon::createFromFormat('Y-m-d', $request->ended_at);

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
            $activity->title = $request->title;
            $activity->slug = date('ymd') . '-' . Str::slug($request->title, '-');
            $activity->description = $request->description;
            $activity->started_at = $request->started_at;
            $activity->ended_at = $request->ended_at;
            $activity->support_activite_file = $uploaded_file;
            $activity->staff_id  = $user->id;
            $activity->status_id   = 1;
            $activity->save();
            return redirect()->route('activity')->with('success', 'Your Activity has been successfull Saved');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
