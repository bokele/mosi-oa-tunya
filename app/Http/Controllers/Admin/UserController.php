<?php

namespace App\Http\Controllers\Admin;

use File;
use App\Models\Role;
use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Laravolt\Avatar\Facade as Avatar;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
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
        // dd(\Route::current()->getName());
        $countries = Country::orderBy('name', 'asc')->get();
        $roles = Role::all()->pluck('name', 'id');

        if (\Route::current()->getName() == "admin.all.users") {

            return view('admin.user.index', compact('countries', 'roles'));
        } else if (\Route::current()->getName() == "admin.all.staff") {

            return view('admin.user.staff');
        } else if (\Route::current()->getName() == "admin.all.staff") {

            return view('admin.users.investor');
        } else if (\Route::current()->getName() == "admin.all.customer") {

            return view('admin.users.candidate');
        } else if (\Route::current()->getName() == "admin.all.saler") {

            return view('admin.users.entreprenuer');
        } else if (\Route::current()->getName() == "admin.user.investor") {

            $user = auth()->user();
            $user_id = $user->id;
            $userInfo = User::where('id', $user_id)->get();


            return view('profile.profile', ['userInfo' => $userInfo,]);
        } else if (\Route::current()->getName() == "admin.user.entrepreneur") {

            $user = auth()->user();
            $user_id = $user->id;
            $userInfo = User::where('id', $user_id)->get();


            return view('profile.profile', ['userInfo' => $userInfo,]);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllUser()
    {
        $data = User::with(['country'])->latest()->get();
        return DataTables::of($data)

            ->addColumn('full_name', function ($data) {

                return $data->full_name;
            })
            ->addColumn('country', function ($data) {

                return $data->country->name;
            })
            ->addColumn('created_at', function ($data) {

                return $data->created_at->diffForHumans()
                    . '<br/><span class="text-muted">' . $data->created_at . '</span>';
            })
            ->addColumn('updated_at', function ($data) {


                return $data->updated_at->diffForHumans()
                    . '<br/><span class="text-muted">' . $data->created_at . '</span>';
            })
            ->addColumn('last_login_time', function ($data) {


                return $data->last_login_times
                    . '<br/><span class="text-muted">' . $data->last_login_time . '</span>';
            })
            ->addColumn('type', function ($data) {
                $type = "";

                if ($data->is_staff == true) {
                    if ($data->is_staff == true) {
                        $is_admin = 'Super Admin';
                    } else {
                        $is_admin = 'Non';
                    }
                    $type = '<span style="cursor: pointer;" class="badge badge-success p-1" >Staff</span> <span class="badge badge-primary p-1">' . $is_admin . '</span>';
                } else if ($data->is_investor == true) {
                    $type = '<span style="cursor: pointer;" class="badge badge-primary p-1">Investor</span>';
                } else if ($data->is_entrepreneur == true) {
                    $type = '<span style="cursor: pointer;" class="badge badge-info p-1">Entrepreneur</span>';
                } else if ($data->is_candidate == true) {
                    $type = '<span style="cursor: pointer;" class="badge badge-warning p-1">Candidate</span>';
                }

                return $type;
            })
            ->addColumn('status', function ($data) {
                $status = "";

                if ($data->is_active == true) {
                    $status = '<span style="cursor: pointer;"   class="badge badge-success p-1" onclick="changeStatus(' . $data->id . ', \' desactive\')">Active</span>';
                } else {
                    $status = '<span style="cursor: pointer;" onclick="changeStatus(' . $data->id . ', \' active\')"  class="badge badge-danger p-1">Desactivated</span>';
                }

                return $status;
            })


            ->addColumn('actions', function ($data) {
                $button = '
                        <a
                          type="button"
                            id="' . $data->id . '"
                            href="' . route("admin.users.edit", $data->id) . '"
                            class="edit btn btn-warning btn-sm"
                            data-placement="top"
                            title="User Edit"
                            data-toggle="tooltip modal"
                        >
                          <i class="fa fa-edit blue"></i>
                        </a>
                        <button
                          type="button"
                          id="' . $data->id . '"
                            onclick="deleteUser(' .  $data->id . ',\'' . $data->name . '\')"
                          class="btn btn-danger btn-sm"
                          data-placement="top"
                          title="User Delete"
                          data-toggle="tooltip modal"
                        >
                          <i class="fa fa-trash red"></i>
                        </button>
            ';
                return $button;
            })

            ->rawColumns(['country', 'status', 'type', 'actions', 'created_at', 'updated_at', 'last_login_time'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllAdminstrative()
    {
        $data = User::where('is_staff', 1)->lastest()->get();
        return DataTables::of($data)

            ->editColumn('created_at', function ($data) {

                return $data->created_at->diffForHumans()
                    . '<br/><span class="text-muted">' . $data->created_at . '</span>';
            })
            ->editColumn('updated_at', function ($data) {


                return $data->updated_at->diffForHumans()
                    . '<br/><span class="text-muted">' . $data->updated_at . '</span>';
            })
            ->editColumn('last_login_time', function ($data) {


                return $data->last_login_time->diffForHumans()
                    . '<br/><span class="text-muted">' . $data->last_login_time . '</span>';
            })
            ->addColumn('status', function ($data) {
                $status = '';
                if ($data->status == 'active') {
                    $status = '<span class="badge badge-success p-1">' . $data->status . '</span>';
                } else {
                    $status = '<span class="badge badge-danger p-1">' . $data->status . '</span>';
                }

                return $status;
            })

            ->addColumn('actions', function ($data) {
                $button = '
                        <button
                          type="button"
                            id="' . $data->id . '"
                          class="edit btn btn-warning btn-sm"
                          data-placement="top"
                          title="User Edit"
                          data-toggle="tooltip modal"
                        >
                          <i class="fa fa-edit blue"></i>
                        </button>
                        <button
                          type="button"
                          id="' . $data->id . '"
                            onclick=deleteUser(' .  $data->id . ')
                          class="btn btn-danger btn-sm"
                          data-placement="top"
                          title="User Delete"
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
    public function getAllInvestor()
    {
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllEntrepreneur()
    {
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllCandidate()
    {
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
        // $this->authorize('isAdmin');
        $validator =  Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['email', 'max:255', 'unique:users,email'],
            'gender' => ['required', 'string', 'max:100'],
            'country' => ['required', 'string', 'max:100'],
            'account_type' => ['required',],
            'roles.*' => ['integer',],
            'roles'   => ['required', 'array',],

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }


        $path = public_path('profile/');
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        if ($request->is_active == 'on' || $request->is_active == 'true') {
            $request->merge([
                'is_active' => true,

            ]);
        } else {
            $request->merge([
                'is_active' => false,

            ]);
        }

        if ($request->account_type  == 'is_staff') {
            $request->merge([
                'is_investor' => false,
                'is_candidate' => false,
                'is_entrepreneur' => false,
                'is_superuser' => false,
                'is_staff' => true,
            ]);
        }
        if ($request->account_type == 'is_candidate') {
            $request->merge([
                'is_investor' => false,
                'is_staff' => false,
                'is_entrepreneur' => false,
                'is_superuser' => false,
                'is_candidate' => true,
            ]);
        }
        if ($request->account_type == 'is_investor') {
            $request->merge([
                'is_superuser' => false,
                'is_staff' => false,
                'is_candidate' => false,
                'is_entrepreneur' => false,
                'is_investor' => true,
            ]);
        }
        if ($request->account_type == 'is_entrepreneur') {
            $request->merge([
                'is_candidate' => false,
                'is_staff' => false,
                'is_investor' => false,
                'is_superuser' => false,
                'is_entrepreneur' => true,
            ]);
        }
        if ($request->is_superuser == 'is_superuser') {
            $request->merge([
                'is_candidate' => false,
                'is_entrepreneur' => false,
                'is_staff' => true,
                'is_investor' => false,
                'is_superuser' => true,
            ]);
        }

        if ($request->is_staff == false &&  $request->is_superuser == true) {
            return response()->json(['error' => 'only a staff user can become supper ']);
        } else if ($request->is_staff == true &&  $request->is_superuser == true && $request->is_investor == true) {
            return response()->json(['error' => 'only a staff user can become supper ']);
        } else if ($request->is_staff == true && $request->is_superuser == true && $request->is_candidate == true) {
            return response()->json(['error' => 'only a staff user can become supper ']);
        } else if ($request->is_staff == true && $request->is_superuser == true && $request->is_candidate == true) {
            return response()->json(['error' => 'only a staff user can become supper ']);
        }
        $namAvatare = date('Ymd-His');
        Avatar::create(ucwords($request->get('full_name')))->save($path . $namAvatare . '.png', 100);

        $password = 'Password@2020';
        $user =  User::create([
            'first_name' => ucwords($request->first_name),
            'last_name' => ucwords($request->last_name),
            'email' => $request->email,
            'profile_photo_path' => 'profile/' . $namAvatare . '.png',
            'is_staff' => $request->is_staff,
            'is_superuser' => $request->is_superuser,
            'is_investor' => $request->is_investor,
            'is_candidate ' => $request->is_candidate,
            'is_entrepreneur' => $request->is_entrepreneur,
            'is_active' => $request->is_active,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'place_birth' => $request->place_birth,
            'mobile' => $request->mobile_number,
            'country_id' => $request->country,
            'terms_condition' => true,
            'password' => Hash::make($password),
        ]);
        $user->roles()->sync($request->input('roles', []));

        return response()->json(['success' => 'User data has been successfully Added.']);
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
        $user = User::findOrFail($id);
        $roles = Role::all()->pluck('name', 'id');
        $countries = Country::all();

        // $user->load('country');
        $user->load('roles');

        return view('admin.user.edit', compact('roles', 'user', 'countries'));

        return        $user;
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
        $user = User::findOrFail($id);
        $validator = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['email', 'max:255', 'unique:users,email,' . $user->id],
            'gender' => ['required', 'string', 'max:100'],
            'country' => ['required', 'string', 'max:100'],
            'mobile_number' => ['unique:users,mobile,' . $user->id],
            'account_type' => ['required',],
            'roles.*' => ['integer',],
            'roles'   => ['required', 'array',],
        ]);


        // check id the profile id for staff and diseable other profile
        if ($request->is_active == 'on' || $request->is_active == 'true') {
            $request->merge([
                'is_active' => true,

            ]);
        } else {
            $request->merge([
                'is_active' => false,

            ]);
        }

        if ($request->is_staff == 'on' || $request->is_staff == 'true') {
            $request->merge([
                'is_investor' => false,
                'is_candidate' => false,
                'is_entrepreneur' => false,
                'is_superuser' => false,
                'is_staff' => true,
            ]);
        }

        if ($request->is_candidate == 'on' || $request->is_candidate == 'true') {
            $request->merge([
                'is_investor' => false,
                'is_staff' => false,
                'is_entrepreneur' => false,
                'is_superuser' => false,
                'is_candidate' => true,
            ]);
        }
        if ($request->is_investor == 'on' || $request->is_investor == 'true') {
            $request->merge([
                'is_candidate' => false,
                'is_staff' => false,
                'is_entrepreneur' => false,
                'is_superuser' => false,
                'is_investor' => true,
            ]);
        }
        if ($request->is_entrepreneur == 'on' || $request->is_entrepreneur == 'true') {
            $request->merge([
                'is_candidate' => false,
                'is_staff' => false,
                'is_investor' => false,
                'is_superuser' => false,
                'is_entrepreneur' => true,
            ]);
        }
        if ($request->is_superuser == 'on' || $request->is_superuser == 'true') {
            $request->merge([
                'is_candidate' => false,
                'is_entrepreneur' => false,
                'is_staff' => true,
                'is_investor' => false,
                'is_superuser' => true,
            ]);
        }


        if ($request->is_staff == false &&  $request->is_superuser == true) {
            return response()->json(['error' => 'only a staff user can become supper ']);
        }
        //user can have just
        if (
            $request->is_staff == true &&  $request->is_superuser == true &&
            $request->is_investor == true &&  $request->is_candidate == true &&
            $request->is_entrepreneur == true
        ) {
            return response()->json(['error' => 'Please Check just one profile the user']);
        }

        $namAvatare = "";
        $path = public_path('profile/');
        $request->merge([
            'full_name' => $request->get('first_name') . " " . $request->get('last_name'),

        ]);

        if ($user->name != $request['full_name']) {
            $namAvatare = date('Ymd-His');
            $namAvatare = date('Ymd-His');
            Avatar::create(ucwords($request->get('user_full_name')))->save($path . $namAvatare . '.png', 100);
            $namAvatare = 'profile/' . $namAvatare . '.png';
        } else {
            if ($user->profile_photo_path == "") {
                $namAvatare = date('Ymd-His');
                Avatar::create(ucwords($user->name))->save($path . $namAvatare . '.png', 100);
                $namAvatare = 'profile/' . $namAvatare . '.png';
            } else {
                $namAvatare = $user->avatar;
            }
        }

        $user->first_name = ucwords($request->first_name);
        $user->last_name = ucwords($request->last_name);
        $user->email = $request->email;
        $user->country_id  = $request->country;
        $user->is_staff = $request->is_staff;
        $user->is_active = $request->is_active;
        $user->is_superuser = $request->is_superuser;
        $user->is_investor = $request->is_investor;
        $user->is_candidate = $request->is_candidate;
        $user->is_entrepreneur = $request->is_entrepreneur;
        $user->birth_date = $request->birth_date;
        $user->gender = $request->gender;
        $user->place_birth = $request->place_birth;
        $user->mobile  = $request->mobile_number;
        $user->profile_photo_path = $namAvatare;
        $user->country_id = $request->country;

        $user->update();



        return redirect()->route('admin.all.users')->with(
            [
                'alert-type' => 'success',

                'message' => 'User data has been successfully updated.',
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->is_active = false;
        $data->is_staff = false;
        $data->is_investor = false;
        $data->is_candidate = false;
        $data->is_entrepreneur = false;
        // $data->update();
        $data->delete();
        return response()->json(['success' => 'User has been successfully dalated.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activity($id)
    {
        $data = User::findOrFail($id);
        if ($data->is_active == true) {
            $data->is_active = false;
            $data->update();
            // $data->delete();
            return response()->json(['success' => 'User Profile has been successfully descactivated.']);
        } else {
            $data->is_active = true;
            $data->update();
            // $data->delete();
            return response()->json(['success' => 'User Profile has been successfully activated.']);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  string  $type
     * @return \Illuminate\Http\Response
     */
    public function changeProfile($id, $type)
    {
        $data = User::findOrFail($id);

        if ($type == "candidate") {
            if ($data->is_candidate == true) {
                $data->is_candidate = false;
                $data->update();
            } else {
                $data->is_candidate = true;
                $data->update();
            }
        }
        if ($type == "investor") {
            if ($data->is_investor == true) {
                $data->is_investor = false;
                $data->update();
            } else {
                $data->is_investor = true;
                $data->update();
            }
        }
        if ($type == "entrepreneur") {
            if ($data->is_entrepreneur == true) {
                $data->is_entrepreneur = false;
                $data->update();
            } else {
                $data->is_entrepreneur = true;
                $data->update();
            }
        }

        // $data->delete();
        return response()->json(['success' => 'User profile has been successfully changed.']);
    }
}
