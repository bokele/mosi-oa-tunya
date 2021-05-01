<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use File;
use DOMDocument;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return view('staff.booking.index');
    }

    public function booking()
    {
        $data = Booking::query()->with(['staff', 'user']);
        return DataTables::eloquent($data)

            ->addColumn('start_time', function ($data) {
                $createStartDate = new DateTime($data->start_time);
                $start_date = $createStartDate->format('d-m-Y H:i:s');
                $start_time = Carbon::createFromFormat('d-m-Y H:i:s', $start_date);

                return $start_time->diffForHumans()
                    . '<br/><span class="text-muted">' . $start_time . '</span>';
            })
            ->addColumn('end_time', function ($data) {
                $createEndDate = new DateTime($data->end_time);
                $end_date = $createEndDate->format('d-m-Y H:i:s');
                $end_time = Carbon::createFromFormat('d-m-Y H:i:s', $end_date);

                return $end_time->diffForHumans()
                    . '<br/><span class="text-muted">' . $end_time . '</span>';
            })
            ->editColumn('created_at', function ($data) {

                return $data->created_at->diffForHumans()
                    . '<br/><span class="text-muted">' . $data->created_at . '</span>';
            })
            ->editColumn('updated_at', function ($data) {

                return $data->updated_at->diffForHumans()
                    . '<br/><span class="text-muted">' . $data->created_at . '</span>';
            })

            ->editColumn('staff', function ($data) {

                return $data->staff ? $data->staff->full_name : '';
            })
            ->editColumn('user', function ($data) {

                return $data->user ? $data->user->full_name : '';
            })

            ->addColumn('status', function ($data) {

                $status = "";

                if ($data->status == 'waiting') {
                    $status = '<span class="badge badge-warning p-1 text-capitalize"> ' . $data->status . '  </span>';
                } elseif ($data->status == 'attended') {
                    $status = '<span class="badge badge-success p-1 text-capitalize">' . $data->status . '  </span>';
                } elseif ($data->status == 'cancel') {
                    $status = '<span class="badge badge-danger p-1 text-capitalize">' . $data->status . '  </span>';
                }
                return $status;
            })
            ->addColumn('actions', function ($data) {

                $button = '';
                $cancel = '';
                if ($data->status != 'cancel') {
                    $cancel = ' <button
                          type="button"
                          id="' . $data->id . '"
                            onclick="cancelBooking(' .  $data->id . ',\'' . ($data->user ? $data->user->full_name : '') . '\')"
                          class="btn btn-dark btn-sm"
                          data-placement="top"
                          title="Delete Appointment "
                          data-toggle="tooltip modal"
                        >
                          <i class="fa fa-times red"></i>
                        </button>';
                }

                $button .= '
                        <a
                          type="button"
                            id="' . $data->id . '"
                           href="' . route("admin.bookings.edit", $data->id)  . '"
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
                            onclick="showBooking(' .  $data->id . ')"
                          class="btn btn-primary btn-sm"
                          data-placement="top"
                          title="Show appointment"
                          data-toggle="tooltip modal"
                        >
                          <i class="fa fa-eye red"></i>
                        </button>'

                    . $cancel .

                    ' <button
                          type="button"
                          id="' . $data->id . '"
                            onclick="deleteBooking(' .  $data->id . ',\'' . ($data->user ? $data->user->full_name : '') . '\')"
                          class="btn btn-danger btn-sm"
                          data-placement="top"
                          title="Delete Appointment "
                          data-toggle="tooltip modal"
                        >
                          <i class="fa fa-trash red"></i>
                        </button>
            ';
                return $button;
            })

            ->rawColumns(['status', 'actions', 'start_time', 'end_time', 'created_at', 'updated_at'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('is_investor', 1)
            ->orWhere('is_candidate', 1)
            ->orWhere('is_entrepreneur', 1)
            ->get();
        return view('staff.booking.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BookingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingRequest $request, Booking $booking)
    {
        $data_validated = $request->validated();
        $user = auth()->user();

        $createStartDate = new DateTime($data_validated['started_time']);
        $start_date = $createStartDate->format('Y-m-d');

        $createEndDate = new DateTime($data_validated['ended_time']);
        $end_date = $createEndDate->format('Y-m-d');


        $start_date = Carbon::createFromFormat('Y-m-d', $start_date);

        $end_date = Carbon::createFromFormat('Y-m-d', $end_date);

        if (!$end_date->gte($start_date)) {
            return back()->with('error', 'Ended date Time must be greater than Started date Time');
        } else {


            $file_name = "";
            $uploaded_file = "";
            // check if folder exit and if not create it
            $path = public_path('support/booking/');
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            };

            if ($request->hasFile('support_file')) {
                $support_file = $request->file('support_file');
                // DSF : D: booking S:support F: File
                $file_name = 'DSF-' . date('YmdHis') . '-' .  $support_file->getClientOriginalName();


                // $path = $request->file('support_file')->store('avatars');
                $support_file->move($path, $file_name);
                $uploaded_file = 'support/booking/' . $file_name;
            }


            $latesbooking = Booking::orderBy('created_at', 'DESC')->first();
            if ($latesbooking == "") {
                $code = date('ymd') . '-' . str_pad(0 + 1, 8, "0", STR_PAD_LEFT);
            } else {
                $code = date('ymd') . '-' . str_pad($latesbooking->id + 1, 8, "0", STR_PAD_LEFT);
            }

            // $dom_content = new DOMDocument();
            // $dom_content->loadHtml($request->user_comment, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            // $user_comment = $dom_content->saveHTML();

            // $dom_satff_content = new DOMDocument();
            // $dom_satff_content->loadHtml($request->staff_comment, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            // $staff_comment = $dom_satff_content->saveHTML();

            $booking->booking_code   = $code;
            $booking->status   = $request->status;
            $booking->start_time  = $request->started_time;
            $booking->end_time  = $request->ended_time;
            $booking->user_comment  = $request->user_comment;
            $booking->staff_comment  = $request->staff_comment;
            $booking->come_into_office = $request->come_into_office;

            $booking->user_id  = $request->user;
            $booking->update();
            return redirect()->route('admin.bookings.index')->with(['alert-type' => 'success', 'message' => 'Your booking has been successfull Saved']);
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
    public function edit(Booking $booking)
    {
        $users = User::where('is_investor', 1)
            ->orWhere('is_candidate', 1)
            ->orWhere('is_entrepreneur', 1)
            ->get();
        return view('staff.booking.edit', compact('booking', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BookingRequest $request
     * @param   Booking $booking
     * @return \Illuminate\Http\Response
     */
    public function update(BookingRequest $request, Booking $booking)
    {
        $request->validated();
        $user = auth()->user();

        $file_name = "";
        $uploaded_file = "";
        // check if folder exit and if not create it
        $path = public_path('support/booking/');


        if ($request->hasFile('support_file')) {
            $support_file = $request->file('support_file');
            // DSF : D: booking S:support F: File
            $file_name = 'DSF-' . date('YmdHis') . '-' .  $support_file->getClientOriginalName();


            // $path = $request->file('support_file')->store('avatars');
            $support_file->move($path, $file_name);
            $uploaded_file = 'support/booking/' . $file_name;
        }

        $booking = new Booking();
        $latesbooking = Booking::orderBy('created_at', 'DESC')->first();
        if ($latesbooking == "") {
            $code = date('ymd') . '-' . str_pad(0 + 1, 8, "0", STR_PAD_LEFT);
        } else {
            $code = date('ymd') . '-' . str_pad($latesbooking->id + 1, 8, "0", STR_PAD_LEFT);
        }

        $dom_content = new DOMDocument();
        $dom_content->loadHtml($request->comment, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $user_comment = $dom_content->saveHTML();

        $dom_satff_content = new DOMDocument();
        $dom_satff_content->loadHtml($request->staff_comment, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $staff_comment = $dom_satff_content->saveHTML();

        $booking->status   = $request->status;
        $booking->start_time  = $request->started_time;
        $booking->end_time  = $request->ended_time;
        $booking->user_comment  = $user_comment;
        $booking->staff_comment  = $staff_comment;
        $booking->come_into_office = $request->come_into_office;

        $booking->user_id  = $request->user;
        $booking->update();
        return redirect()->route('admin.bookings.index')->with(['alert-type' => 'success', 'message' => 'Your booking has been successfull Saved']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Booking $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingRequest $request,  Booking $booking)

    {
        $booking->delete();
        return ['success' => 'The Booking  has been successfull Deleted'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Booking $booking
     * @return \Illuminate\Http\Response
     */
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'cancel']);

        return ['success' => 'The Booking  has been successfull   Cancel'];
    }
}
