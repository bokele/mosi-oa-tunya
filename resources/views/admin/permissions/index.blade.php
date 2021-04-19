<x-app-layout>
    @section('page-title')
    All Permissions |
    @endsection
    <x-slot name="header">


        <div class="col-sm-6">
            <h1 class="m-0 text-dark font-weight-bold">{{ __('Permissions') }}</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="/home">{{_("Home") }}</a>
                </li>
                <li class="breadcrumb-item active">{{_("Permissions")}}</li>
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
                            <span class="fa fa-list"></span> {{_("Permissions List")}}
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
                                        <th scope="col">{{_('Title')}}</th>
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
    @include('admin.permissions.create')
    @push('scripts')
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable().destroy();
            $('#myTable').DataTable({
                processing: true,
                serverside:true,

                ajax: '{!! route("admin.get.all.permissions") !!}',
                columns:[
                {data: 'actions', name: 'actions', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'created_at', name: 'created_at'},
                {data:'updated_at', name: 'updated_at'}
                ]
            });
            $('#create_record').click(function(){
            $('.modal-title').text('Add New Permission');
            $('#action_button').text('Save');
            $('.modal-header').addClass('bg-dark');
            $('#modal-icon').html('<i class="fa fa-plus" aria-hidden="true"></i>');
            $('#action').val('Add');
            $('#permission_id').val('');
            $("#permission_form")[0].reset();
            // remove the error text


            $('#create_modal').modal('show');

            });

            $('#permission_form').on('submit', function(event){
                event.preventDefault();
                let action_url = '';
                let method = '';
                let data = '';
                if($('#action').val() == 'Add')
                {
                    action_url = "{{ route('admin.permissions.store') }}";

                     data = new FormData(this)
                }
                if($('#action').val() == 'Edit')
                {
                    var id = $('#permission_id').val();
                    action_url = "/admin/permissions/" + id;

                    data = new FormData(this)

                    data.append('_method', 'PUT');
                }

                $.ajax({
                    url: action_url,
                   method :"POST",
                    data:data,
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(data)
                    {
                        $('#error_permission_name').text(''); $('#permission_name').removeClass('is-invalid');
                        $('#permission_name').addClass('is-valid');
                        if(data.errors) {
                            if(data.errors.permission_name){
                                $('#permission_name').addClass('rounded-right');
                                $('#permission_name').addClass('is-invalid');
                                $( '#error_permission_name' ).text( data.errors.permission_name[0]);
                            }
                        }

                        if(data.success){
                            $('#create_modal').modal('hide');
                            $('#permission_form')[0].reset();
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
function editPermission(id){
    $('.modal-title').text('Edit Category');
    $('#action_button').text('Save Change');
    $('.modal-header').addClass('bg-warning');
    $('#modal-icon').html('<i class="fa fa-edit" aria-hidden="true"></i>');

    $("#permission_form")[0].reset();

    $.ajax({
        url: "/admin/permissions/" + id,
        method:'GET',
        dataType:"json",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(data)
        {
            $('#permission_name').val(data.name);
            $('#action').val('Edit');
            $('#permission_id').val(data.id);
            // remove the error text

            $('#create_modal').modal('show');
        }
    });

}

function deletePermission(id,name){
    Swal.fire({
        title: 'Are you sure?',
        html: "You won't be able to revert this!<br /> <b><span class='text-danger'>Delete Permission : "+name+"</span></b>",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/admin/permissions/" + id,
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
