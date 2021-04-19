<x-app-layout>
    @section('page-title')
    User Staff |
    @endsection
    <x-slot name="header">


        <div class="col-sm-6">
            <h1 class="m-0 text-dark font-weight-bold">{{ __('Categories') }}</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="/home">{{_("Home") }}</a>
                </li>
                <li class="breadcrumb-item active">{{_("Categories")}}</li>
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
                            <span class="fa fa-list"></span> {{_("Category List")}}
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
                                        <th scope="col">{{_("Description")}}</th>
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
                <form id="category_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="category_name">{{ __('Category Name') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-state"></span>
                                            </div>
                                        </div>
                                        <input type="text" name="category_name" id="category_name"
                                            placeholder="{{ __('Category Name') }}" class="form-control " />
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        {{-- <strong id="error_current_status_of_registraion"></strong> --}}
                                        <strong> <span id="error_category_name" class="error"></span></strong>

                                    </span>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <input type="hidden" name="action" id="action" value="Add">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fa fa-times" aria-hidden="true"></i> Close
                        </button>

                        {{-- <button v-show="editmode" type="submit" class="btn btn-success">
                                <i class="fa fa-save fa-2"></i> Update
                            </button> --}}
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
        ajax: '{!! route("admin.get.categorty") !!}',
        columns:[
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'description', name: 'description'},
            {data: 'created_at',  name: 'created_at'},
            {data:'updated_at', name: 'updated_at'}
    ]
    });

    $('#create_record').click(function(){
    $('.modal-title').text('Add New Category');
    $('#action_button').text('Save');
    $('.modal-header').addClass('bg-dark');
    $('#modal-icon').html('<i class="fa fa-plus" aria-hidden="true"></i>');
    $('#action').val('Add');

    $("#category_form")[0].reset();
    // remove the error text

    $('#create_modal').modal('show');

    });

    $('#category_form').on('submit', function(event){
    event.preventDefault();
    let action_url = '';
    if($('#action').val() == 'Add')
    {
    action_url = "{{ route('admin.category.store') }}";
    }
    if($('#action').val() == 'Edit')
    {
    var id = $('#hidden_id').val();
    action_url = '/admin/country/update/'+id;
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
            $('#error_category_name').text(''); $('#category_name').removeClass('is-invalid'); $('#category_name').addClass('is-valid');
            if(data.errors) {
                if(data.errors.category_name){
                    $('#category_name').addClass('rounded-right');
                    $('#category_name').addClass('is-invalid');
                    $( '#error_category_name' ).text( data.errors.category_name[0] );
                }
            }
            if(data.success){
                $('#create_modal').modal('hide');
                $('#category_form')[0].reset();
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
function editCategory(category){
$('.modal-title').text('Edit Category');
$('#action_button').text('Save Change');
$('.modal-header').addClass('bg-warning');
$('#modal-icon').html('<i class="fa fa-edit" aria-hidden="true"></i>');
$('#action').val('Edit');
    $("#category_form")[0].reset();
    $('#category_name').val(category.name);
    // remove the error text

$('#create_modal').modal('show');
}

function deleteCategory(category){
    Swal.fire({
    title: 'Are you sure?',
    html: "You won't be able to revert this!<br/> <b>Delete category : "+category.name+"</b>",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
        url: "/admin/category/delete/" + category.id,
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
