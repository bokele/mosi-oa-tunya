<x-app-layout>
    @section('page-title')
    All User |
    @endsection
    <x-slot name="header">


        <div class="col-sm-6">
            <h1 class="m-0 text-dark font-weight-bold">{{ __('Users') }}</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="/home">{{_("Home") }}</a>
                </li>
                <li class="breadcrumb-item active">{{_("Users")}}</li>
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
                            <span class="fa fa-list"></span> {{_("Users List")}}
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
                                        <th scope="col">{{_('Status')}}</th>
                                        <th scope="col">{{_('Type')}}</th>
                                        <th scope="col">{{_("Full name")}}</th>
                                        <th scope="col">{{_("Email")}}</th>
                                        <th scope="col">{{_("Country")}}</th>
                                        <th scope="col">{{_("Gender")}}</th>
                                        <th scope="col">{{_("Birth date")}}</th>
                                        <th scope="col">{{_("Place birth")}}</th>
                                        <th scope="col">{{_("mobile")}}</th>
                                        <th scope="col">{{_("Last login time")}}</th>
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

    @include('admin.user.create', ['countries' => $countries, 'roles' => $roles])
    @push('scripts')
    <script>
        $(document).ready( function () {
$('#myTable').DataTable().destroy();
    $('#myTable').DataTable({
        processing: true,
        serverside:true,
        ajax: '{!! route("admin.get.all.user") !!}',
        columns:[
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
            {data: 'status', name: 'status'},
            {data: 'type', name: 'type'},
            {data: 'first_name', name: 'first_name'},
            {data: 'email', name: 'email'},
            {data: 'country', name: 'country'},
            {data: 'gender', name: 'gender'},
            {data: 'birth_date', name: 'birth_date'},
            {data: 'place_birth', name: 'place_birth'},
            {data: 'mobile', name: 'mobile'},
            {data: 'last_login_time', name: 'last_login_time'},
            {data: 'created_at',  name: 'created_at'},
            {data:'updated_at', name: 'updated_at'}
    ]
    });

    $("#account_type").change(function(){
        let account_type = $('#account_type').val();

        if(account_type != 'is_staff'){
            $("#check_role").hide();
        }else{
            $("#check_role").show();
        }

    });

    $('#create_record').click(function(){
    $('.modal-title').text('Add New User');
    $('#action_button').text('Save');
    $('.modal-header').addClass('bg-dark');
    $('#modal-icon').html('<i class="fa fa-plus" aria-hidden="true"></i>');
    $('#action').val('Add');

    $("#user_form")[0].reset();
    // remove the error text

    $("#is_superuser").removeAttr("disabled");
    $('#superuser').text('Desactive')
    $("#is_active").removeAttr("disabled");
    $('#active').text('Desactive')


    $('#create_modal').modal('show');

    });




    // super user check
    $('#is_superuser').on('click', function(){
    if(this.checked == false){
        $('#superuser').text('Desactive');
        $('#account_type').val('')
    }else{
        $('#superuser').text('Active')
        $('#account_type').val('is_staff')

        }
    })
    $('#is_active').on('click', function(){
    let is_active = $('#is_active').val();

    if(this.checked == false){
    $('#active').text('Desactive');
    }else{
    $('#active').text('Active');
    }
    })


    $('#user_form').on('submit', function(event){
    event.preventDefault();
    let action_url = '';
    if($('#action').val() == 'Add')
    {
        action_url = "{{ route('admin.user.store') }}";
    }
    if($('#action').val() == 'Edit')
    {
        var id = $('#hidden_id').val();
        action_url = '/admin/user/update/'+id;
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
            $('#error_first_name').text(''); $('#first_name').removeClass('is-invalid'); $('#first_name').addClass('is-valid');
            $('#error_last_name').text(''); $('#last_name').removeClass('is-invalid'); $('#last_name').addClass('is-valid');
            $('#error_email').text(''); $('#email').removeClass('is-invalid'); $('#email').addClass('is-valid');
            $('#error_gender').text(''); $('#gender').removeClass('is-invalid'); $('#gender').addClass('is-valid');
            $('#error_country').text(''); $('#country').removeClass('is-invalid'); $('#country').addClass('is-valid');

            if(data.errors) {
                if(data.errors.first_name){
                    $('#first_name').addClass('rounded-right');
                    $('#first_name').addClass('is-invalid');
                    $( '#error_first_name' ).text( data.errors.first_name[0] );
                }
                if(data.errors.last_name){
                    $('#last_name').addClass('rounded-right');
                    $('#last_name').addClass('is-invalid');
                    $( '#error_last_name' ).text( data.errors.last_name[0] );
                }
                if(data.errors.email){
                    $('#email').addClass('rounded-right');
                    $('#email').addClass('is-invalid');
                    $( '#error_email' ).text( data.errors.email[0] );
                }
                if(data.errors.gender){
                    $('#gender').addClass('rounded-right');
                    $('#gender').addClass('is-invalid');
                    $( '#error_gender' ).text( data.errors.gender[0] );
                }
                if(data.errors.country){
                    $('#country').addClass('rounded-right');
                    $('#country').addClass('is-invalid');
                    $( '#error_country' ).text( data.errors.country[0] );
                }
                if(data.errors.account_type){
                    $('#account_type').addClass('rounded-right');
                    $('#account_type').addClass('is-invalid');
                    $( '#error_account_type' ).text( data.errors.account_type[0] );
                }
            }
            if(data.success){
                $('#create_modal').modal('hide');
                $('#user_form')[0].reset();
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
function editUser(id){
    $('.modal-title').text('Edit User Information');
    $('#action_button').text('Save Change');
    $('.modal-header').addClass('bg-warning');
    $('#modal-icon').html('<i class="fa fa-edit" aria-hidden="true"></i>');
    $('#action').val('Edit');
    $("#user_form")[0].reset();
    // remove the error text

    $("#is_superuser").removeAttr("disabled");
    $('#superuser').text('Desactive')
    $("#is_active").removeAttr("disabled");
    $('#active').text('Desactive')


    $.ajax({
    url: "/admin/user/edit/"+id ,
    method:'GET',
    dataType:"json",
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    success:function(data)
    {
        $('#country').val(data.country_id);
        $('#first_name').val(data.first_name);
        $('#last_name').val(data.last_name);
        $('#email').val(data.email);
        $('#gender').val(data.gender);
        $('#hidden_id').val(data.id);

        if(data.is_active != 1){
            $('#active').text('Desactive');
            $('#is_active')[0].checked = false
        }else{
            $('#active').text('Active');
            $('#is_active')[0].checked = true

        }
        if(data.is_staff == 1 && data.is_superuser == 0){

            $('#account_type').val('is_staff');
            $('#superuser').text('Desactive');
            ('#is_superuser').attr("disabled", true);
            $('#is_superuser')[0].checked = false

        }
        if(data.is_superuser == 1 && data.is_staff == 1){
            $('#superuser').text('Active');
            $('#is_superuser')[0].checked = true
            $('#account_type').val('is_staff');
        }

        if(data.is_investor == 1){
            $('#account_type').val('is_investor')
            $('#superuser').text('Desactive');
            $('#is_superuser')[0].checked = false

        }
        if(data.is_entrepreneur == 1){

            $('#account_type').val('is_entrepreneur')
            $('#superuser').text('Desactive');
            $('#is_superuser')[0].checked = false

        }
        if(data.is_candidate == 1){

            $('#account_type').val('is_candidate')
            $('#superuser').text('Desactive');
            $('#is_superuser')[0].checked = false

        }
    }


        // remove the error text

    });

    $('#create_modal').modal('show');
}


function deleteUser(id, name){
Swal.fire({
title: 'Are you sure?',
html: "You won't be able to revert this! <br/><span class='text-danger font-weight-bolder'>User name : "+name+"</span>",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Yes, Delete it!'
}).then((result) => {
if (result.isConfirmed) {
$.ajax({
url: "/admin/user/delete/" + id,
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
function changeStatus(id, message){
   Swal.fire({
title: 'Are you sure?',
text: "Do you want to "+message+" this account !",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Yes, Do it!'
}).then((result) => {
if (result.isConfirmed) {
$.ajax({
url: "/admin/user/active/" + id,
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
