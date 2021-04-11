<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Setting') }}
        </h2>
    </x-slot>
    <div class="row">
        <div class="col-md-12">
            <section class="content">
                <div class="card card-blue">
                    <div class="card-header">
                        <h3 class="card-title">
                            <span class="fa fa-list"></span> Setting
                        </h3>
                        <div class="card-tools">
                            @if(empty($setting))
                            <button type="button" class="btn btn-dark" name="create_record" id="create_record"
                                data-toggle="modal">
                                <i class="fas fa-plus fa-lg"></i> &nbsp;
                                {{_("Add Setting")}}
                            </button>
                            @else
                            @if (!empty($setting->id))
                            <button type="button" class="btn btn-dark" onclick="editSetting({{$setting}})"
                                data-toggle="modal" title="{{_("Update Setting")}}">
                                <i class="fas fa-plus fa-lg"></i> &nbsp;
                                {{_("Update Setting")}}
                            </button>
                            @endif
                            @endif


                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="company_name_view"> {{ __('Company Name') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-genderless"></span>
                                                </div>
                                            </div>
                                            <input type="text" id="company_name_view"
                                                value="{{ !empty($setting->company_name) ? $setting->company_name : ''}}"
                                                readonly class="form-control" placeholder="{{ __('Company Name') }}">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email_view"> {{ __('Email') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-genderless"></span>
                                                </div>
                                            </div>
                                            <input type="text" id="email_view" class="form-control "
                                                value="{{ !empty($setting->email) ? $setting->email : ''}}" readonly
                                                placeholder="{{ __('Email') }}">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="moblie_number_view"> {{ __('Mobile  Number') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-genderless"></span>
                                                </div>
                                            </div>
                                            <input type="text"
                                                value="{{ !empty($setting->mobile_phone) ? $setting->mobile_phone : ''}}"
                                                readonly id="moblie_number_view" class="form-control "
                                                placeholder="{{ __('Mobile  Number') }}">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hand_phone_number_view"> {{ __('HandLine Number') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-genderless"></span>
                                                </div>
                                            </div>
                                            <input type="text"
                                                value="{{ !empty($setting->hand_phone_number) ? $setting->hand_phone_number : ''}}"
                                                readonly id="hand_phone_number_view" class="form-control"
                                                placeholder="{{ __('HandLine Number') }}">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address_view"> {{ __('Address') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-genderless"></span>
                                                </div>
                                            </div>

                                            <input type="text" id="address_view" class="form-control "
                                                value="{{ !empty($setting->address) ? $setting->address : ''}}" readonly
                                                placeholder="{{ __('Address') }}" readonly>
                                        </div>

                                    </div>
                                </div>

                        </form>
                    </div>
                </div>
            </section>
        </div>

    </div>

    <div class="modal fade" id="modalSetting" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header @if($setting_id) bg-warning @else bg-dark @endif ">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        @if($setting_id)
                        <i class="fa fa-edit" aria-hidden="true"></i>
                        @else
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        @endif
                        @if($setting_id)
                        {{ __('Edit  Setting') }}
                        @else {{ __('Add Setting') }}
                        @endif
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id='setting_form'>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="company_name"> {{ __('Company Name') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>
                                        <input type="text" name="company_name" id="company_name" class="form-control"
                                            placeholder="{{ __('Company Name') }}">
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><span id='error_company_name' class="error"></span></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email"> {{ __('Email') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>
                                        <input type="text" name="email" id="email" class="form-control "
                                            placeholder="{{ __('Email') }}">
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong> <span id='error_email' class="error"></span></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="moblie_number"> {{ __('Mobile  Number') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>
                                        <input type="text" name="moblie_number" id="moblie_number" class="form-control "
                                            placeholder="{{ __('Mobile  Number') }}">
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong> <span id='error_moblie_number' class="error"></span></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hand_phone_number"> {{ __('HandLine Number') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>
                                        <input type="text" name="hand_phone_number" id="hand_phone_number"
                                            class="form-control" placeholder="{{ __('HandLine Number') }}">
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong> <span id='error_hand_phone_number' class="error"></span></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address"> {{ __('Address') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>

                                        <input type="text" name="address" id="address" class="form-control "
                                            placeholder="{{ __('Address') }}">
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong> <span id='error_address' class="error"></span></strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">

                        <input type="hidden" name="action" id="action" value="Add">
                        <input type="hidden" name="setting_id" id="setting_id"
                            value="@if($setting_id) {{$setting_id}} @endif">
                        <button class=" btn btn-danger" data-dismiss="modal"><i class="fa fa-times"
                                aria-hidden="true"></i> Close</button>


                        <button type="Submit" class="btn btn-primary" id="action_button"> <i
                                class="fas fa-save    "></i>
                            @if($setting_id) Save change @else Save @endif </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    @push('scripts')

    <script>
        $(document).ready( function () {
            $('#create_record').click(function(){
                $('#action').val('Add');
                $(".text-danger").remove();
                $('#setting_form')[0].reset();
                $('#modalSetting').modal('show');

            });

$('#setting_form').on('submit', function(event){
    event.preventDefault();
    let action_url = '';
if($('#action').val() == 'Add')
{
action_url = "{{ route('admin.setting.store') }}";
}
if($('#action').val() == 'Edit')
{
var id = $('#setting_id').val();
action_url = '/admin/setting/update/'+id;
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

    $('#error_company_name').text(''); $('#company_name').removeClass('is-invalid');$('#company_name').addClass('is-valid');
    $('#error_moblie_number').text(''); $('#moblie_number').removeClass('is-invalid');$('#moblie_number').addClass('is-valid');
    // $('#error_hand_phone_number').text(''); $('#hand_phone_number').removeClass('is-invalid');$('#hand_phone_number').addClass('is-valid');
    $('#error_email').text(''); $('#email').removeClass('is-invalid');$('#email').addClass('is-valid');
    $('#error_address').text(''); $('#address').removeClass('is-invalid');$('#address').addClass('is-valid');
    if(data.errors) {
        if(data.errors.company_name){
            $('#company_name').addClass('rounded-right');
            $('#company_name').addClass('is-invalid');
            $( '#error_company_name' ).text( data.errors.company_name[0] );
        }
        if(data.errors.moblie_number){
            $('#moblie_number').addClass('rounded-right');
            $('#moblie_number').addClass('is-invalid');
            $( '#error_moblie_number' ).text( data.errors.moblie_number[0] );
        }

        if(data.errors.email){
            $('#email').addClass('rounded-right');
            $('#email').addClass('is-invalid');
            $( '#error_email' ).text( data.errors.email[0] );
        }
        if(data.errors.address){
            $('#address').addClass('rounded-right');
            $('#address').addClass('is-invalid');
            $( '#error_address' ).text( data.errors.address[0] );
        }
    }
    if(data.success){
        $('#modalSetting').modal('hide');
        $('#setting_form')[0].reset();
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: ""+data.success,
            showConfirmButton: false,
            toast: true,
            timer: 6000
        });

        location.reload();

    }
    }
    });
    });

        });


function editSetting(setting){
    $('#action').val('Edit');
    $("#setting_form")[0].reset();
    $('#company_name').val(setting.company_name);
    $('#email').val(setting.email);
    $('#moblie_number').val(setting.mobile_phone);
    $('#hand_phone_number').val(setting.hand_phone_number);
    $('#address').val(setting.address);

    // remove the error text
    $('#modalSetting').modal('show');
}

    </script>

    @endpush



</x-app-layout>
