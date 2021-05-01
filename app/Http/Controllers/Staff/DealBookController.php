<?php

namespace App\Http\Controllers\Staff;

use File;
use DOMDocument;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\DealBook;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\DealBookRequest;

class DealBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('staff.dealbook.index');
    }

    public function dealbook()
    {
        $data = DealBook::query()->with(['staff', 'published', 'category']);
        return DataTables::eloquent($data)

            ->editColumn('created_at', function ($data) {

                return $data->created_at->diffForHumans()
                    . '<br/><span class="text-muted">' . $data->created_at . '</span>';
            })
            ->editColumn('updated_at', function ($data) {

                return $data->updated_at->diffForHumans()
                    . '<br/><span class="text-muted">' . $data->created_at . '</span>';
            })
            ->editColumn('published_at', function ($data) {

                if ($data->published_at != "") {
                    return $data->published_at->diffForHumans()
                        . '<br/><span class="text-muted">' . $data->published_at . '</span>';
                } else {
                    return "Not yet publish";
                }
            })
            ->editColumn('staff', function ($data) {

                return $data->staff->name;
            })
            ->editColumn('category', function ($data) {

                return $data->category->name;
            })
            ->editColumn('published', function ($data) {

                if ($data->published_by != "") {
                    return $data->published->name;
                } else {
                    return "Not yet publish";
                }
            })
            ->addColumn('slug', function ($data) {
                $link = '<a href="' . route("common.dealbook.show", $data->slug) . '"  aria-disabled="true" target="_blank">' . $data->slug . '</a>';

                return  $link;
            })
            ->addColumn('video_link', function ($data) {
                $link = '<a href="' . $data->video_link . '"  aria-disabled="true" target="_blank">Video link </a>';

                return  $link;
            })

            ->addColumn('status', function ($data) {

                $status = "";

                if ($data->status == 'negotiation') {
                    $status = '<span class="badge badge-warning p-1 text-capitalize"> ' . $data->status . '  </span>';
                } elseif ($data->status == 'approve') {
                    $status = '<span class="badge badge-success p-1 text-capitalize">' . $data->status . '  </span><br/>' .
                        '<span class="badge badge-warning p-1 text-capitalize"> wait payment  </span>';
                } elseif ($data->status == 'wait payment') {
                    $status = '<span class="badge badge-orange p-1 text-capitalize">  ' . $data->status . '  </span>';
                } elseif ($data->status == 'cancel') {
                    $status = '<span class="badge badge-danger p-1 text-capitalize">' . $data->status . '  </span>';
                } elseif ($data->status == 'paid') {
                    $status = '<span class="badge badge-purple p-1 text-capitalize"> ' . $data->status . '   </span>';
                }
                return $status;
            })
            ->addColumn('actions', function ($data) {
                $button = '
                        <a
                          type="button"
                            id="' . $data->id . '"
                           href="' . route("admin.dealbooks.edit", $data->id)  . '"
                          class="edit btn btn-warning btn-sm"
                          data-placement="top"
                          title="Category Edit"
                          data-toggle="tooltip modal"
                        >
                          <i class="fa fa-edit blue"></i>
                        </a>
                        <button
                          type="button"
                          id="' . $data->id . '"
                            onclick="deleteDealBook(' .  $data->id . ',\'' . $data->title . '\')"
                          class="btn btn-danger btn-sm"
                          data-placement="top"
                          title="Category Delete"
                          data-toggle="tooltip modal"
                        >
                          <i class="fa fa-trash red"></i>
                        </button>
            ';
                return $button;
            })

            ->rawColumns(['status', 'actions', 'created_at', 'updated_at', 'slug', 'video_link'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('staff.dealbook.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DealBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DealBookRequest $request)
    {
        $user = auth()->user();
        $data_validated = $request->validated();
        $file_name = "";
        $uploaded_file = "";
        // check if folder exit and if not create it
        $path = public_path('support/dealbook/');
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        };
        if ($request->hasFile('cover_image')) {
            $cover_image = $request->file('cover_image');
            // DSF : D: dealBook S:support F: File
            $file_name = 'DSF-' . date('YmdHis') . '-' .  $cover_image->getClientOriginalName();


            // $path = $request->file('cover_image')->store('avatars');
            $cover_image->move($path, $file_name);
            $uploaded_file = 'support/dealbook/' . $file_name;
        }

        $dealBook = new DealBook();
        $latesdealBook = DealBook::orderBy('created_at', 'DESC')->first();
        if ($latesdealBook == "") {
            $code = date('ymd') . '-' . str_pad(0 + 1, 8, "0", STR_PAD_LEFT);
        } else {
            $code = date('ymd') . '-' . str_pad($latesdealBook->id + 1, 8, "0", STR_PAD_LEFT);
        }


        $dom_content = new DOMDocument();
        $dom_content->loadHtml($request->content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $content = $dom_content->saveHTML();

        $dealBook->dealbook_code   = $code;
        $dealBook->category_id  = $request->category;
        $dealBook->slug  = Str::slug($request->title, '-') . date('ymd') . '-' .  $code;
        $dealBook->title  = $request->title;
        $dealBook->author  = $request->author;

        $dealBook->content  = $content;
        $dealBook->video_link = $request->video_link;
        $dealBook->cover_image = $uploaded_file;
        $dealBook->staff_id  = $user->id;
        $dealBook->save();
        return redirect()->route('admin.dealbooks.index')->with(['alert-type' => 'success', 'message' => 'Your DealBook has been successfull Saved']);
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
     * @param  DealBook $dealBook
     * @return \Illuminate\Http\Response
     */
    public function edit(DealBook $dealbook)
    {

        $categories = Category::orderBy('name', 'asc')->get();
        return view(
            'staff.dealbook.edit',
            compact('dealbook', 'categories')

        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DealBookRequest $request, DealBook $dealBook)
    {
        $user = auth()->user();
        $data_validated = $request->validated();
        $file_name = "";
        $uploaded_file = $dealBook->cover_image;
        // check if folder exit and if not create it
        $path = public_path('support/dealbook/');
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        };
        if ($request->file('cover_image')) {
            $cover_image = $request->file('cover_image');
            // DSF : D: dealBook S:support F: File
            $file_name = 'DSF-' . date('YmdHis') . '_' . $cover_image->getClientOriginalName();
            $cover_image->move($path, $file_name);
            $uploaded_file = 'support/dealbook/' . $file_name;
        }




        $dom_content = new DOMDocument();
        $dom_content->loadHtml($request->content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $content = $dom_content->saveHTML();


        $dealBook->category_id  = $request->category;
        $dealBook->slug  = Str::slug($request->title, '-') . date('ymd') . '-' .  $dealBook->dealbook_code;
        $dealBook->title  = $request->title;
        $dealBook->author  = $request->author;
        $dealBook->content  = $request->content;
        $dealBook->video_link = $request->video_link;
        $dealBook->cover_image = $uploaded_file;
        $dealBook->staff_id  = $user->id;
        $dealBook->update();
        return redirect()->route('admin.dealbooks.index')->with(['alert-type' => 'success', 'message' => 'Your DealBook has been successfull Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DealBook $dealBook)
    {
        $dealBook->delete();
        return ['success' => 'The DealBook  has been successfull Deleted'];
    }
}
