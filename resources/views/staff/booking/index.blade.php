<x-app-layout>
    @section('page-title')
    Booking | Appointment |
    @endsection
    <x-slot name="header">


        <div class="col-sm-6">
            <h1 class="m-0 text-dark font-weight-bold">{{ __('Booking') }}</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="/home">{{_("Home") }}</a>
                </li>
                <li class="breadcrumb-item active">{{_("Booking")}}</li>
            </ol>
        </div>
        <!-- /.col -->
    </x-slot>
    <div class="row">
        <div class="col-md-12">
            <section class="content">
                <div class="card card-blue">
                    <div class="card-header">
                        <h3 class="card-title">
                            <span class="fa fa-list"></span> {{_(" Booking List")}}
                        </h3>

                        <div class="card-tools">
                            <a href="{{ route('admin.bookings.create')}} " class="btn btn-dark">
                                <i class="fas fa-plus fa-lg"></i> &nbsp;
                                {{_(" Add New  Booking | Appointment")}}
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%"
                                id="myTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">{{_("Actions")}}</th>
                                        <th scope="col">{{_("Code")}}</th>
                                        <th scope="col">{{_("Satus")}}</th>
                                        <th scope="col">{{_("User")}}</th>
                                        <th scope="col">{{_("Staff")}}</th>
                                        <th scope="col">{{_("Started time")}}</th>
                                        <th scope="col">{{_("Ended time")}}</th>
                                        <th scope="col">{{_("Created at")}}</th>
                                        <th scope="col">{{_("Updated at")}}</th>

                                    </tr>

                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready( function () {

    $('#myTable').DataTable({
        processing: true,
        serverside:true,
        ajax: '{!! route("admin.bookings.list") !!}',
        columns:[
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
            {data: 'booking_code', name: ' booking_code'},
            {data: 'status', name: 'status'},
            {data: 'user', name: 'user'},
            {data: 'staff', name: 'staff'},
            {data: 'start_time', name: 'start_time'},
            {data: 'end_time', name: 'end_time'},
            {data: 'created_at',  name: 'created_at'},
            {data:'updated_at', name: 'updated_at'},

    ]
    });
});


function deleteBooking(id, title){
Swal.fire({
title: 'Are you sure?',
html: "You won't be able to revert this!<br /> <span class='text-danger'><b>Delete  Appointment : "+title+"</b></span>",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Yes, delete it!'
}).then((result) => {
if (result.isConfirmed) {
$.ajax({
url: "/admin/bookings/" + id,
method:'DELETE',
dataType:"json",
headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
success:function(data)
{
if(data.errors) {
Swal.fire({
icon: 'error',
title: 'Oops...',
text: 'Something went wrong!<br />'+data.errors,
footer: '<a href="#">Why do I have this issue?, Contact the admin</a>'
})
}

if(data.success){
$('#myTable').DataTable().ajax.reload();
Swal.fire({
position: 'top-end',
icon: 'success',
title: ""+data.success,
showConfirmButton: false,
toast: true,
timer: 6000
});
}

}
});

}
})
}

function cancelBooking(id, title){
Swal.fire({
title: 'Are you sure?',
html: "Cancel the appointment!<br /> <span class='text-danger'><b>Cancel  Appointment : "+title+"</b></span>",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Yes, Cancel it!'
}).then((result) => {
if (result.isConfirmed) {
$.ajax({
url: "/admin/bookings/cancel/" + id,
method:'POST',
dataType:"json",
headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
success:function(data)
{
if(data.errors) {
Swal.fire({
icon: 'error',
title: 'Oops...',
text: 'Something went wrong!<br />'+data.errors,
footer: '<a href="#">Why do I have this issue?, Contact the admin</a>'
})
}

if(data.success){
$('#myTable').DataTable().ajax.reload();
Swal.fire({
position: 'top-end',
icon: 'success',
title: ""+data.success,
showConfirmButton: false,
toast: true,
timer: 6000
});
}

}
});

}
})
}
    </script>
    @endpush
</x-app-layout>
