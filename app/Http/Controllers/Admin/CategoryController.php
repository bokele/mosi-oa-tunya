<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.preference.category');
    }
    public function category()
    {
        $data = Category::query();
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
                            onclick=editCategory(' .   $data->id . ')
                          class="edit btn btn-warning btn-sm"
                          data-placement="top"
                          title="Category Edit"
                          data-toggle="tooltip modal"
                        >
                          <i class="fa fa-edit blue"></i>
                        </button>
                        <button
                          type="button"
                          id="' . $data->id . '"
                            onclick=deleteCategory(' .   $data->id . ')
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
            'category_name' => ['required', 'unique:categories,name,type' . $request->category_type],
            'category_type' => ['required',],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $category = new Category;
        $category->name = $request->category_name;
        $category->type = $request->category_type;
        $category->staff_id = $user->id;

        $category->save();

        return ['success' => 'The category has been successfull Saved'];
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
    public function edit(Category $category)
    {

        return $category;
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
        $category =  Category::findOrFail($id);
        $user = auth()->user();
        $validator =  Validator::make($request->all(), [
            'category_name' => ['required', 'unique:categories,name,type' . $request->category_type],
            'category_type' => ['required',],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $category->name = $request->category_name;
        $category->type = $request->category_type;
        $category->staff_id = $user->id;

        $category->save();

        return ['success' => 'The category has been successfull updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category =  Category::findOrFail($id);
        $category->delete();
        return ['success' => 'The category has been successfull Deleted'];
    }
}
