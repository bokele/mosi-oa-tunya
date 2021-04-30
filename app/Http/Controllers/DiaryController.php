<?php

namespace App\Http\Controllers;

use App\Models\Diary;
use DOMDocument;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use File;
use App\Http\Requests\DiaryRequest;

class DiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('common.diary.index');
    }

    public function diary()
    {
        $user = auth()->user();
        $data = Diary::query()->where('user_id', $user->id);
        return DataTables::eloquent($data)

            ->editColumn('created_at', function ($data) {

                return $data->created_at->diffForHumans();
            })

            ->editColumn('updated_at', function ($data) {

                return $data->updated_at->diffForHumans();
            })

            ->addColumn('actions', function ($data) {
                $button = '
                        <a
                          type="button"
                            id="' . $data->id . '"
                            href="' . route('admin.diaries.edit', $data->id) . '"
                          class="edit btn btn-warning btn-sm"
                          data-placement="top"
                          title="Diary Edit"
                          data-toggle="tooltip modal"
                        >
                          <i class="fa fa-edit blue"></i>
                        </a>
                        <button
                          type="button"
                          id="' . $data->id . '"
                            onclick="deleteDiary(' . $data->id . ',\'' . $data->diary_code . '\')"
                          class="btn btn-danger btn-sm"
                          data-placement="top"
                          title="Diary Delete"
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
        return view('common.diary.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DiaryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiaryRequest $request)
    {



        $user = auth()->user();
        $path = public_path('support/document/' . $user->email . '/');
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        };

        $data_validated = $request->validated();

        $uploaded_file = "";
        if ($request->file('support_file')) {
            $support_file = $request->file('support_file');
            // DSF : D: Diary S:support F: File
            $file_name = 'DSF-' . date('YmdHis') . '-' . $request->file->getClientOriginalName();
            $support_file->move($path, $file_name);
            $uploaded_file = 'support/document/' . $user->email . '/' . $file_name;
        }

        $diary = new Diary;

        $latesDiary = Diary::where('user_id', $user->id)->orderBy('created_at', 'DESC')->first();
        if ($latesDiary == "") {
            $code = date('ymd') . $user->id . '-' . str_pad(0 + 1, 8, "0", STR_PAD_LEFT);
        } else {
            $code = date('ymd') . $user->id . '-' . str_pad($latesDiary->id + 1, 8, "0", STR_PAD_LEFT);
        }
        $dom = new DOMDocument();
        $dom->loadHtml($data_validated['content'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $content = $dom->saveHTML();

        $diary->diary_code  = $code;
        $diary->title = $data_validated['title'];
        $diary->content = $content;
        $diary->support_file = $uploaded_file;
        $diary->user_id = $user->id;
        $diary->save();
        return redirect()->route('admin.diaries.index')->with(['alert-type' => 'success', 'message' =>  'Your Note has been successfull Saved']);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Diary $diary)
    {
        return  view('common.diary.edit', compact('diary'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  DiaryRequest $request
     * @param  Diary $diary
     * @return \Illuminate\Http\Response
     */
    public function update(DiaryRequest $request, Diary $diary)
    {
        $user = auth()->user();
        $data_validated = $request->validated();
        // check if folder exit and if not create it
        $path = public_path('support/document/' . $user->email . '/');

        $file_name = "";
        if ($request->file('support_file')) {
            $support_file = $request->file('support_file');
            // DSF : D: Diary S:support F: File
            $file_name = 'DSF-' . date('YmdHis') . '_' . $request->file->getClientOriginalName();
            $support_file->move($path, $file_name);
        }

        $diary->title = $data_validated['title'];
        $diary->content = $data_validated['content'];
        $diary->support_file = 'support/document/' . $user->email . '/' . $file_name;
        $diary->save();
        return  redirect()->route('admin.diaries.index')->with(['alert-type' => 'success', 'message' => 'Your Note has been successfull Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Diary $diary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Diary $diary)
    {
        $diary->delete();
        return ['success' => 'Your Note has been successfull Deleted'];
    }
}
