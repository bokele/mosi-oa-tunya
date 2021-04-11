<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('SEO Setting') }}
        </h2>
    </x-slot>
    <div class="row">
        <div class="col-md-12">
            <section class="content">
                <div class="card card-blue">
                    <div class="card-header">
                        <h3 class="card-title">
                            <span class="fa fa-list"></span> SEO Setting
                        </h3>

                        <div class="card-tools">
                            @if(empty($seo_setting))

                            <button type="button" class="btn btn-dark" name="create_record" id="create_record"
                                data-toggle="modal" data-target="#modalSEOSetting">
                                <i class="fas fa-plus fa-lg"></i> &nbsp;
                                {{_("Add SEO Setting")}}
                            </button>

                            @else
                            @if (!empty($seo_setting->id))
                            <button type="button" class="btn btn-dark" onclick="editSeo({{$seo_setting}})"
                                data-toggle="modal">
                                <i class="fas fa-plus fa-lg"></i> &nbsp;
                                {{_("Update SEO Setting")}}
                            </button>
                            @endif
                            @endif

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="meta_keywords_view"> {{ __('Keywords') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>

                                        <input type="text"
                                            value="{{!empty($seo_setting->meta_keywords)?$seo_setting->meta_keywords : '' }}"
                                            id="meta_keywords_view" class="form-control" disabled
                                            placeholder="{{ __('Meta title') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="meta_author_view"> {{ __('Meta Author') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>

                                        <input type="text" id="meta_author_view"
                                            value="{{!empty($seo_setting->meta_author) ? $seo_setting->meta_author : ''}}"
                                            class="form-control " disabled placeholder="{{ __('Meta Author') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="meta_description_view"> {{ __('Meta Description') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>

                                        <input type="text"
                                            value="{{!empty($seo_setting->meta_description) ? $seo_setting->meta_description : ''}}"
                                            id="meta_description_view" class="form-control " disabled
                                            placeholder="{{ __('Meta Description') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="google_analytics_view"> {{ __('Google Analytics') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>

                                        <input type="text"
                                            value="{{!empty($seo_setting->google_analytics) ? $seo_setting->google_analytics : ''}}"
                                            id="google_analytics_view" class="form-control" disabled
                                            placeholder="{{ __('Google Analytics') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="facebook_analytics_view"> {{ __('Facebook Analytics') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>
                                        <input type="text"
                                            value="{{ !empty($seo_setting->facebook_analytics) ? $seo_setting->facebook_analytics : ''}}"
                                            id="facebook_analytics_view" class="form-control " disabled
                                            placeholder="{{ __('Facebook Analytics') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="yahoo_analytics_view"> {{ __('Yahoo Analytics') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>

                                        <input type="text"
                                            value="{{ !empty($seo_setting->yahoo_analytics) ? $seo_setting->yahoo_analytics : ''}}"
                                            id="yahoo_analytics_view" class="form-control " disabled
                                            placeholder="{{ __('Yahoo Analytics') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bing_analytics_view"> {{ __('Bing Analytics') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>
                                        <input type="text"
                                            value="{{ !empty($seo_setting->bing_analytics) ? $seo_setting->bing_analytics : ''}}"
                                            class="form-control " disabled id="bing_analytics_view"
                                            placeholder="{{ __('Bing Analytics') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="modal fade" id="modalSEOSetting" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header @if($seo_id) bg-warning @else bg-dark @endif ">
                    <h5 class="modal-title" id="staticBackdropLabel">

                        @if($seo_id)
                        <i class="fa fa-edit" aria-hidden="true"></i>
                        @else
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        @endif

                        @if($seo_id)
                        {{ __('Edit SEO Setting') }}
                        @else {{ __('Add SEO Setting') }}
                        @endif
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="seo_form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="meta_keywords"> {{ __('Keywords') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>
                                        <input type="text" name="meta_keywords" id="meta_keywords" class="form-control "
                                            placeholder="{{ __('Keywords') }}">
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><span class="error" id="error_meta_keywords"></span></strong>

                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="meta_author"> {{ __('Meta Author') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>

                                        <input type="text" name="meta_author" id="meta_author" class="form-control"
                                            placeholder="{{ __('Meta Author') }}">
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>
                                            <span class="error" id="error_meta_author"></span></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="meta_description"> {{ __('Meta Description') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>
                                        <input type="text" name="meta_description" id="meta_description"
                                            class="form-control " placeholder="{{ __('Meta Description') }}">
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><span class="error" id="error_meta_description"></span></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="google_analytics"> {{ __('Google Analytics') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>

                                        <input type="text" name="google_analytics" id="google_analytics"
                                            class="form-control" placeholder="{{ __('Google Analytics') }}">
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><span class="error" id="error_google_analytics"></span></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="facebook_analytics"> {{ __('Facebook Analytics') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>
                                        <input type="text" name="facebook_analytics" id="facebook_analytics"
                                            class="form-control " placeholder="{{ __('Facebook Analytics') }}">
                                    </div>

                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>
                                            <span class="error" id="error_facebook_analytics"></span>
                                        </strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="yahoo_analytics"> {{ __('Yahoo Analytics') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>

                                        <input type="text" name="yahoo_analytics" id="yahoo_analytics"
                                            class="form-control " placeholder="{{ __('Yahoo Analytics') }}">
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>
                                            <span class="error" id="error_yahoo_analytics"></span></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bing_analytics"> {{ __('Bing Analytics') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>

                                        <input type="text" name="bing_analytics" id="bing_analytics"
                                            class="form-control {{ $errors->has('bing_analytics') ? 'is-invalid' : '' }}"
                                            placeholder="{{ __('Bing Analytics') }}">
                                    </div>


                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>
                                            <span class="error" id="bing_analytics"></span></strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">

                        <input type="hidden" name="action" id="action" value="Add">
                        <input type="hidden" name="seo_id" id="seo_id" value="@if($seo_id) {{$seo_id}} @endif">
                        <button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"
                                aria-hidden="true"></i> Close</button>
                        <button type="Submit" class="btn btn-primary" id="action_button"> <i
                                class="fas fa-save    "></i>
                            @if($seo_id) Save change @else Save @endif </button>
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
            $('#modalSEOSetting').modal('show');

            });
            $('#seo_form').on('submit', function(event){
            event.preventDefault();
            let action_url = '';
            if($('#action').val() == 'Add')
            {
            action_url = "{{ route('admin.setting.seo.store') }}";
            }
            if($('#action').val() == 'Edit')
            {
            var id = $('#seo_id').val();
            action_url = '/admin/setting/seo/update/'+id;
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

            $('#error_meta_keywords').text(''); $('#meta_keywords').removeClass('is-invalid');$('#meta_keywords').addClass('is-valid');
            $('#error_meta_author').text('');
            $('#meta_author').removeClass('is-invalid');$('#meta_author').addClass('is-valid');
            $('#error_meta_description').text('');
            $('#meta_description').removeClass('is-invalid');$('#meta_description').addClass('is-valid');
            $('#error_google_analytics').text(''); $('#google_analytics').removeClass('is-invalid');$('#google_analytics').addClass('is-valid');
            $('#error_facebook_analytics').text(''); $('#facebook_analytics').removeClass('is-invalid');$('#facebook_analytics').addClass('is-valid');
            if(data.errors) {
            if(data.errors.meta_keywords){
            $('#meta_keywords').addClass('rounded-right');
            $('#meta_keywords').addClass('is-invalid');
            $( '#error_meta_keywords' ).text( data.errors.meta_keywords[0] );
            }
            if(data.errors.meta_author){
            $('#meta_author').addClass('rounded-right');
            $('#meta_author').addClass('is-invalid');
            $( '#error_meta_author' ).text( data.errors.meta_author[0] );
            }
            if(data.errors.meta_description){
            $('#meta_description').addClass('rounded-right');
            $('#meta_description').addClass('is-invalid');
            $( '#error_meta_description' ).text( data.errors.meta_description[0] );
            }

            if(data.errors.google_analytics){
            $('#google_analytics').addClass('rounded-right');
            $('#google_analytics').addClass('is-invalid');
            $( '#error_google_analytics' ).text( data.errors.google_analytics[0] );
            }
            if(data.errors.facebook_analytics){
            $('#facebook_analytics').addClass('rounded-right');
            $('#facebook_analytics').addClass('is-invalid');
            $( '#error_facebook_analytics' ).text( data.errors.facebook_analytics[0] );
            }
            }
            if(data.success){
            $('#modalSEOSetting').modal('hide');
            $('#seo_form')[0].reset();
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

        function editSeo(seo){
            $('#action').val('Edit');
            $("#seo_form")[0].reset();
            $('#meta_keywords').val(seo.meta_keywords);
            $('#meta_author').val(seo.meta_author);
            $('#meta_description').val(seo.meta_description);
            $('#google_analytics').val(seo.google_analytics);
            $('#facebook_analytics').val(seo.facebook_analytics);
            $('#yahoo_analytics').val(seo.yahoo_analytics);
            $('#bing_analytics').val(seo.bing_analytics);
            $('#modalSEOSetting').modal('show');
        }

    </script>

    @endpush
</x-app-layout>
