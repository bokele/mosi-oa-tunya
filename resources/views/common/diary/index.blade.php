<x-app-layout>
    @section('page-title')
    Diary |
    @endsection
    <x-slot name="header">


        <div class="col-sm-6">
            <h1 class="m-0 text-dark font-weight-bold">{{ __('Diary') }}</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="/home">{{_("Home") }}</a>
                </li>
                <li class="breadcrumb-item active">{{_("Diary")}}</li>
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
                            <span class="fa fa-list"></span> {{_("Diary List")}}
                        </h3>

                        <div class="card-tools">
                            <a href="{{ route('admin.diaries.create')}} " class="btn btn-dark">
                                <i class="fas fa-plus fa-lg"></i> &nbsp;
                                {{_(" Add New Note")}}
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
                                        <th scope="col">{{_("Title")}}</th>
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
        ajax: '{!! route("admin.diary.list") !!}',
        columns:[
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
            {data: 'diary_code', name: 'diary_code'},
            {data: 'title', name: 'title'},
            {data: 'created_at',  name: 'created_at'},
            {data:'updated_at', name: 'updated_at'}
    ]
    });






});


function deleteDiary(id, code){
Swal.fire({
title: 'Are you sure?',
html: "You won't be able to revert this!<br /> <span class='text-danger'><b>Delete Diary : "+code+"</b></span>",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Yes, delete it!'
}).then((result) => {
if (result.isConfirmed) {
$.ajax({
url: "/admin/diaries/" + id ,
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
    </script>
    @endpush
</x-app-layout>
