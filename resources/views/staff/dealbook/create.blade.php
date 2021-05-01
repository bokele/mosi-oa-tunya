<x-app-layout>
    @section('page-title')
    Create DealBook |
    @endsection
    <x-slot name="header">


        <div class="col-sm-6">
            <h1 class="m-0 text-dark font-weight-bold">{{ __('Create DealBook') }}</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="/home">{{_("Home") }}</a>
                </li>
                <li class="breadcrumb-item active"><a href="{{route('admin.dealbooks.index')}}">{{_("DealBook") }}</a>
                </li>
                <li class="breadcrumb-item active">{{_("Craete")}}</li>
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
                        <form action="{{ route('admin.dealbooks.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">{{ __('Category') }}<span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-state"></span>
                                                </div>
                                            </div>
                                            <select type="text" name="category" id="category"
                                                placeholder="{{ __('Title') }}" class="form-control {{ $errors->has('title') ? 'is-invalid' : ''
                                                }} " :value="old('title')">
                                                <option value="" class="text-center">------------Select
                                                    Category------------
                                                </option>
                                                @forelse ($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                @empty
                                                <option value="">------------Non Category Add first------------</option>
                                                @endforelse

                                            </select>
                                        </div>
                                        <span class="invalid-feedback d-block" role="alert">
                                            @error('category')<strong> <span
                                                    class="error">{{ $message }}</span></strong>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">{{ __('Title') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-state"></span>
                                                </div>
                                            </div>
                                            <input type="text" name="title" id="title" placeholder="{{ __('Title') }}"
                                                class="form-control {{ $errors->has('title') ? 'is-invalid' : ''
                                                }} " :value="old('title')" />
                                        </div>
                                        <span class="invalid-feedback d-block" role="alert">
                                            @error('title')<strong> <span class="error">{{ $message }}</span></strong>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="author">{{ __('Author') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-state"></span>
                                                </div>
                                            </div>
                                            <input type="text" name="author" id="author"
                                                placeholder="{{ __('Author') }}" class="form-control {{ $errors->has('author') ? 'is-invalid' : ''
                                                }} " :value="old('author')" />
                                        </div>
                                        <span class="invalid-feedback d-block" role="alert">
                                            @error('author')<strong> <span class="error">{{ $message }}</span></strong>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="video_link">{{ __('Video link') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-state"></span>
                                                </div>
                                            </div>
                                            <input type="url" name="video_link" id="video_link"
                                                placeholder="{{ __('Video Link') }}" class="form-control {{ $errors->has('video_link') ? 'is-invalid' : ''
                                                                                }} " :value="old('video_link')" />
                                        </div>
                                        <span class="invalid-feedback d-block" role="alert">
                                            @error('video_link')<strong> <span
                                                    class="error">{{ $message }}</span></strong>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cover_image">Cover Image <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class=""></span>
                                                </div>
                                            </div>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input {{ $errors->has('cover_image') ? 'is-invalid' : ''
                                                                                }}" id="cover_image" name="cover_image"
                                                    :value="old('cover_image')">
                                                <label class="custom-file-label" for="cover_image">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        @error('cover_image')<strong> <span class="error">{{ $message }}</span></strong>
                                        @enderror
                                    </span>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="summernote">{{ __('Content') }}<span
                                                class="text-danger">*</span></label>
                                        <textarea name="content" id="summernote" placeholder="{{ __('content') }}"
                                            class="form-control {{ $errors->has('content') ? 'is-invalid' : ''
                                                }} " :value="old('content')"></textarea>

                                        <span class="invalid-feedback d-block" role="alert">
                                            @error('content')<strong> <span class="error">{{ $message }}</span></strong>
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary tn-lg btn-block"> <i
                                        class="fas fa-save    "></i> Save </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>


</x-app-layout>
