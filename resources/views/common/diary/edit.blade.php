<x-app-layout>
    @section('page-title')
    Edit Diary |
    @endsection
    <x-slot name="header">


        <div class="col-sm-6">
            <h1 class="m-0 text-dark font-weight-bold">{{ __('Create Diary') }}</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="/home">{{_("Home") }}</a>
                </li>
                <li class="breadcrumb-item active"><a href="{{route('diary')}}">{{_("Diary") }}</a> </li>
                <li class="breadcrumb-item active">{{_("Edit")}}</li>
            </ol>
        </div>
        <!-- /.col -->
    </x-slot>
    <div class="row">
        <div class="col-md-12">
            <section class="content">
                <div class="card card-blue">

                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ route('diary.update', $diary->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="title">{{ __('Title') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-state"></span>
                                                </div>
                                            </div>
                                            <input type="text" name="title" id="title" placeholder="{{ __('Title') }}"
                                                class="form-control {{ $errors->has('title') ? 'is-invalid' : ''
                                                }} " value="{{ $diary->title}}" />
                                        </div>
                                        <span class="invalid-feedback d-block" role="alert">
                                            @error('title')<strong> <span class="error">{{ $message }}</span></strong>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="summernote">{{ __('content') }}</label>
                                        <div class="input-group">


                                            <textarea name="content" id="summernote" placeholder="{{ __('content') }}"
                                                class="form-control {{ $errors->has('content') ? 'is-invalid' : ''
                                                }} " value="{{ $diary->content}}"></textarea>
                                        </div>
                                        <span class="invalid-feedback d-block" role="alert">
                                            @error('content')<strong> <span class="error">{{ $message }}</span></strong>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="support_file">Support File</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-user"></span>
                                                </div>
                                            </div>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input {{ $errors->has('support_file') ? 'is-invalid' : ''
                                                }}" id="support_file" name="support_file">
                                                <label class="custom-file-label" for="support_file">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        @error('support_file')<strong> <span
                                                class="error">{{ $message }}</span></strong>
                                        @enderror
                                    </span>
                                </div>
                                <button type="submit" class="btn btn-primary tn-lg btn-block"> <i
                                        class="fas fa-save    "></i> Save Note</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>


</x-app-layout>
