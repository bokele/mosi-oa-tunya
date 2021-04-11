<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Site Setting') }}
        </h2>
    </x-slot>
    <div class="row">
        <div class="col-md-12">
            <section class="content">
                <div class="card card-blue">
                    <div class="card-header">
                        <h3 class="card-title">
                            <span class="fa fa-list"></span> Site Setting
                        </h3>
                        <div class="card-tools">
                            @if(empty($site_setting))
                            <button type="button" class="btn btn-dark" name="create_record" id="create_record"
                                data-toggle="modal">
                                <i class="fas fa-plus fa-lg"></i> &nbsp;
                                {{_("Add Site Setting")}}
                            </button>
                            @else
                            @if (empty($site_setting->facebook))
                            <button type="button" class="btn btn-dark" name="create_record" id="create_record"
                                data-toggle="modal">
                                <i class="fas fa-plus fa-lg"></i> &nbsp;
                                {{_("Add Site Setting")}}
                            </button>

                            @else
                            <button type="button" class="btn btn-dark" onclick="editSocilMedia({{$site_setting}})">
                                <i class="fas fa-plus fa-lg"></i> &nbsp;
                                {{_("Update Site Setting")}}
                            </button>
                            @endif
                            @endif
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="facebook_view"> {{ __('Facebook Name') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-genderless"></span>
                                                </div>
                                            </div>
                                            <input type="text"
                                                value="{{!empty($site_setting->facebook) ? $site_setting->facebook : ''}}"
                                                id="facebook_view" class="form-control " disabled
                                                placeholder="{{ __('Facebook Name') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="facebook_url_view"> {{ __('Facebook url') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-genderless"></span>
                                                </div>
                                            </div>

                                            <input type="text"
                                                value="{{!empty($site_setting->facebook_url) ? $site_setting->facebook_url : ''}}"
                                                id="facebook_url_view" class="form-control " disabled
                                                placeholder="{{ __('Facebook url') }}">
                                        </div>



                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="youtube_view"> {{ __('YouTube Name') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-genderless"></span>
                                                </div>
                                            </div>

                                            <input type="text"
                                                value="{{!empty($site_setting->youtube) ? $site_setting->youtube : ''}}"
                                                id="youtube_view" class="form-control " disabled
                                                placeholder="{{ __('YouTube Name') }}">
                                        </div>




                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="youtube_url_view"> {{ __('YouTube url') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-genderless"></span>
                                                </div>
                                            </div>

                                            <input type="text"
                                                value="{{!empty($site_setting->youtube_url) ?$site_setting->youtube_url : ''}}"
                                                id="youtube_url_view" class="form-control " disabled
                                                placeholder="{{ __('YouTube url') }}">
                                        </div>




                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="instagram_view"> {{ __('Instagram') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-genderless"></span>
                                                </div>
                                            </div>
                                            <input type="text"
                                                value="{{!empty($site_setting->instagram) ? $site_setting->instagram : ''}}"
                                                id="instagram_view" class="form-control " disabled
                                                placeholder="{{ __('Instagram') }}">
                                        </div>




                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="instagram_url_view"> {{ __('Instagram') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-genderless"></span>
                                                </div>
                                            </div>

                                            <input type="text"
                                                value="{{!empty($site_setting->instagram_url) ? $site_setting->instagram_url : ''}}"
                                                id="instagram_url_view" class="form-control " disabled
                                                placeholder="{{ __('Instagram url') }}">
                                        </div>




                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="twitter_view"> {{ __('Twitter') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-genderless"></span>
                                                </div>
                                            </div>

                                            <input type="text"
                                                value="{{!empty($site_setting->twitter) ? $site_setting->twitter : ''}}"
                                                id="twitter_view" class="form-control " disabled
                                                placeholder="{{ __('Twitter ') }}">
                                        </div>




                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="twitter_url_view"> {{ __('Twitter url') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-genderless"></span>
                                                </div>
                                            </div>

                                            <input type="text"
                                                value="{{!empty($site_setting->twitter_url) ? $site_setting->twitter_url : ''}}"
                                                id="twitter_url_view" class="form-control " disabled
                                                placeholder="{{ __('Twitter url ') }}">
                                        </div>




                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade" id="modalSiteSetting" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header @if($site_setting_id) bg-warning @else bg-dark @endif ">
                    <h5 class="modal-title" id="staticBackdropLabel">

                        @if($site_setting_id)
                        <i class="fa fa-edit" aria-hidden="true"></i>
                        @else
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        @endif

                        @if($site_setting_id)
                        {{ __('Edit Social Media Setting') }}
                        @else {{ __('Social Media SEO Setting') }}
                        @endif
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="social_media_form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="facebook"> {{ __('Facebook Name') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>

                                        <input type="text" name="facebook" id="facebook" class="form-control "
                                            placeholder="{{ __('Facebook Name') }}">
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong> <span id='error_facebook' class="error"></span></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="facebook_url"> {{ __('Facebook url') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>

                                        <input type="url" pattern="https://.*" name="facebook_url" id="facebook_url"
                                            class="form-control " placeholder="{{ __('Facebook url') }}">
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong> <span id='error_facebook_url' class="error"></span></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="youtube"> {{ __('YouTube Name') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>

                                        <input type="text" name="youtube" id="youtube" class="form-control "
                                            placeholder="{{ __('YouTube Name') }}">
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong> <span id='error_youtube' class="error"></span></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="youtube_url"> {{ __('YouTube url') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>

                                        <input type="url" pattern="https://.*" name="youtube_url" id="youtube_url"
                                            class="form-control " placeholder="{{ __('YouTube url') }}">
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong> <span id='error_youtube_url' class="error"></span></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="instagram"> {{ __('Instagram') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>

                                        <input type="text" name="instagram" id="instagram" class="form-control "
                                            placeholder="{{ __('Instagram') }}">
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong> <span id='error_instagram' class="error"></span></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="instagram_url"> {{ __('Instagram url') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>

                                        <input type="url" pattern="https://.*" name="instagram_url" id="instagram_url"
                                            class="form-control " placeholder="{{ __('Instagram url') }}">
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong> <span id='error_instagram_url' class="error"></span></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="twitter"> {{ __('Twitter') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>

                                        <input type="text" name="twitter" id="twitter" class="form-control "
                                            placeholder="{{ __('Twitter ') }}">
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong> <span id='error_twitter' class="error"></span></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="twitter_url"> {{ __('Twitter url') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>

                                        <input type="url" pattern="https://.*" name="twitter_url" id="twitter_url"
                                            class="form-control " placeholder="{{ __('Twitter url ') }}">
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong> <span id='error_twitter_url' class="error"></span></strong>
                                    </span>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer justify-content-between">
                        <input type="hidden" name="action" id="action" value="Add">
                        <input type="hidden" name="setting_id" id="setting_id"
                            value="@if($site_setting_id) {{$site_setting_id}} @endif">
                        <button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"
                                aria-hidden="true"></i> Close</button>
                        <button type="Submit" class="btn btn-primary" id="action_button"> <i class="fas fa-save   "></i>
                            @if($site_setting_id) Save change @else Save @endif </button>
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
            $('#modalSiteSetting').modal('show');
            });

            $('#social_media_form').on('submit', function(event){
            event.preventDefault();
            let action_url = '';
            if($('#action').val() == 'Add')
            {
            action_url = "{{ route('admin.setting.socila.media.store') }}";
            }
            if($('#action').val() == 'Edit')
            {
            var id = $('#setting_id').val();
            action_url = '/admin/setting/social-media/update/'+id;
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

            $('#error_facebook').text(''); $('#facebook').removeClass('is-invalid');$('#facebook').addClass('is-valid');
            $('#error_youtube').text('');$('#youtube').removeClass('is-invalid');$('#youtube').addClass('is-valid');
            $('#error_instagram').text('');$('#instagram').removeClass('is-invalid');$('#instagram').addClass('is-valid');
            $('#error_twitter').text(''); $('#twitter').removeClass('is-invalid');$('#twitter').addClass('is-valid');
            $('#error_facebook_url').text(''); $('#facebook_url').removeClass('is-invalid');$('#facebook_url').addClass('is-valid');
            $('#error_youtube_url').text(''); $('#youtube_url').removeClass('is-invalid');$('#youtube_url').addClass('is-valid');
            $('#error_instagram_url').text(''); $('#instagram_url').removeClass('is-invalid');$('#instagram_url').addClass('is-valid');
            $('#error_twitter_url').text(''); $('#twitter_url').removeClass('is-invalid');$('#twitter_url').addClass('is-valid');
            if(data.errors) {
            if(data.errors.facebook){
            $('#facebook').addClass('rounded-right');
            $('#facebook').addClass('is-invalid');
            $( '#error_facebook' ).text( data.errors.facebook[0] );
            }
            if(data.errors.youtube){
            $('#youtube').addClass('rounded-right');
            $('#youtube').addClass('is-invalid');
            $( '#error_youtube' ).text( data.errors.youtube[0] );
            }

            if(data.errors.twitter){
            $('#twitter').addClass('rounded-right');
            $('#twitter').addClass('is-invalid');
            $( '#error_twitter' ).text( data.errors.twitter[0] );
            }
            if(data.errors.facebook_url){
            $('#facebook_url').addClass('rounded-right');
            $('#facebook_url').addClass('is-invalid');
            $( '#error_facebook_url' ).text( data.errors.facebook_url[0] );
            }
            if(data.errors.youtube_url){
            $('#youtube_url').addClass('rounded-right');
            $('#youtube_url').addClass('is-invalid');
            $( '#error_youtube_url' ).text( data.errors.youtube_url[0] );
            }
            if(data.errors.instagram){
            $('#instagram').addClass('rounded-right');
            $('#instagram').addClass('is-invalid');
            $( '#error_instagram' ).text( data.errors.instagram[0] );
            }
            if(data.errors.instagram_url){
            $('#instagram_url').addClass('rounded-right');
            $('#instagram_url').addClass('is-invalid');
            $( '#error_instagram_url' ).text( data.errors.instagram_url[0] );
            }
            if(data.errors.twitter_url){
            $('#twitter_url').addClass('rounded-right');
            $('#twitter_url').addClass('is-invalid');
            $( '#error_twitter_url' ).text( data.errors.twitter_url[0] );
            }
            }
            if(data.success){
            $('#modalSiteSetting').modal('hide');
            $('#social_media_form')[0].reset();
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
        function editSocilMedia(setting){
        $('#action').val('Edit');
        $("#social_media_form")[0].reset();
        $('#facebook').val(setting.facebook);
        $('#youtube').val(setting.youtube);
        $('#instagram').val(setting.instagram);
        $('#facebook_url').val(setting.facebook_url);
        $('#youtube_url').val(setting.youtube_url);
        $('#instagram_url').val(setting.instagram_url);
        $('#twitter_url').val(setting.twitter_url);


        // remove the error text
        $('#modalSiteSetting').modal('show');
        }
    </script>

    @endpush



</x-app-layout>
