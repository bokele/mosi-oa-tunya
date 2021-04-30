<x-app-layout>
    @section('page-title')
    Status |
    @endsection
    <x-slot name="header">


        <div class="col-sm-6">
            <h1 class="m-0 text-dark font-weight-bold">{{ __('Status') }}</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="/home">{{_("Home") }}</a>
                </li>
                <li class="breadcrumb-item active">{{_("Status")}}</li>
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
                            <span class="fa fa-list"></span> {{_("Status List")}}
                        </h3>

                        <div class="card-tools">
                            <button class="btn btn-dark" name="create_record" id="create_record">
                                <i class="fas fa-plus fa-lg"></i> &nbsp;
                                {{_(" Add New")}}
                            </button>
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
                                        <th scope="col">{{_("Name")}}</th>
                                        <th scope="col">{{_("Code")}}</th>
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
    <div class="modal fade" id="create_modal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" :class="formColor">
                    <h4 class="modal-title">
                        <span :class="formIcon"></span>&nbsp;
                        <span class="headline" :class="formTextColor"></span>
                    </h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="status_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status_name">{{ __('Status Name') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-state"></span>
                                            </div>
                                        </div>
                                        <input type="text" name="status_name" id="status_name"
                                            placeholder="{{ __('Status Name') }}" class="form-control " />
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong> <span id="error_status_name" class="error"></span></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status_name">{{ __('Status Name') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-state"></span>
                                            </div>
                                        </div>
                                        <select name="status_code" id="status_code" class="form-control ">
                                            <option value="">---SELECT CODE---</option>
                                            <option value="bg-primary">bg-primary</option>
                                            <option value="bg-secondary">bg-secondary</option>
                                            <option value="bg-danger">bg-danger</option>
                                            <option value="bg-warning">bg-warning</option>
                                            <option value="bg-info">bg-info</option>
                                            <option value="bg-dark">bg-dark</option>
                                            <option value="bg-light">bg-light</option>
                                        </select>

                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong> <span id="error_status_code" class="error"></span></strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <input type="hidden" name="action" id="action" value="Add">
                        <input type="hidden" name="status_id" id="status_id" value="Add">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fa fa-times" aria-hidden="true"></i> Close
                        </button>
                        <button id="action_button" type="submit" class="btn btn-primary">
                            <i class="fa fa-save fa-2"></i> Create
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(document).ready( function () {

    $('#myTable').DataTable({
        processing: true,
        serverside:true,
        // responsive: {
        // details: {
        // display: $.fn.dataTable.Responsive.display.modal( {
        // header: function ( row ) {
        // var data = row.data();
        // console.log(data);
        // return 'Details for '+data['name'];
        // }
        // } ),
        // renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
        // tableClass: 'table'
        // } )
        // }
        // },
        ajax: '{!! route("admin.get.status") !!}',
        columns:[
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'status_code', name: 'status_code'},
            {data: 'created_at',  name: 'created_at'},
            {data:'updated_at', name: 'updated_at'}
    ]
    });

    $('#create_record').click(function(){
    $('.modal-title').text('Add New Status');
    $('#action_button').text('Save');
    $('.modal-header').addClass('bg-dark');
    $('#modal-icon').html('<i class="fa fa-plus" aria-hidden="true"></i>');
    $('#action').val('Add');

    $("#status_form")[0].reset();
    // remove the error text

    $('#create_modal').modal('show');

    });

    $('#status_form').on('submit', function(event){
    event.preventDefault();
    let action_url = '';
    if($('#action').val() == 'Add')
    {
    action_url = "{{ route('admin.status.store') }}";
    }
    if($('#action').val() == 'Edit')
    {
    var id = $('#status_id').val();
    action_url = '/admin/status/update/'+id;
    }
    $.ajax({
        url: action_url,
        method:"POST",
        data:new FormData(this),
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success:function(data)
        {
            $('#error_status_name').text(''); $('#status_name').removeClass('is-invalid'); $('#status_name').addClass('is-valid');
            $('#error_status_code').text(''); $('#status_code').removeClass('is-invalid'); $('#status_code').addClass('is-valid');
            if(data.errors) {
                if(data.errors.status_name){
                    $('#status_name').addClass('rounded-right');
                    $('#status_name').addClass('is-invalid');
                    $( '#error_status_name' ).text( data.errors.status_name[0] );
                }
                if(data.errors.status_code){
                    $('#status_code').addClass('rounded-right');
                    $('#status_code').addClass('is-invalid');
                    $( '#error_status_code' ).text( data.errors.status_code[0] );
                }
            }
            if(data.success){
                $('#create_modal').modal('hide');
                $('#status_form')[0].reset();
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
});
});
function editStatus(status){
$('.modal-title').text('Edit Status');
$('#action_button').text('Save Change');
$('.modal-header').addClass('bg-warning');
$('#modal-icon').html('<i class="fa fa-edit" aria-hidden="true"></i>');
$('#action').val('Edit');
    $("#status_form")[0].reset();
    $('#status_name').val(status.name);
    $('#status_code').val(status.status_code);
    $('#status_id').val(status.id);
    // remove the error text

$('#create_modal').modal('show');
}

function deleteStatus(status){
    Swal.fire({
    title: 'Are you sure?',
    html: "You won't be able to revert this!<br/> <b>Delete status : "+status.name+"</b>",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
        url: "/admin/status/delete/" + status.id,
        method:'POST',
        dataType:"json",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(data)
        {
            if(data.errors) {
           Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!<br/>'+data.errors,
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
