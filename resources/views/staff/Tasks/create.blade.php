<x-app-layout>
    @section('page-title')
    Create Task | Create Event |
    @endsection
    <x-slot name="header">


        <div class="col-sm-6">
            <h1 class="m-0 text-dark font-weight-bold">{{ __('Create Task') }}</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="/home">{{_("Home") }}</a>
                </li>
                <li class="breadcrumb-item active"><a href="{{route('admin.tasks.index')}}">{{_("Tasks") }}</a>
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
                        <form action="{{ route('admin.tasks.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="name">{{ __('Name') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-state"></span>
                                                </div>
                                            </div>
                                            <input type="text" name="name" id="name" placeholder="{{ __('Name') }}"
                                                class="form-control {{ $errors->has('name') ? 'is-invalid' : ''
                                                }} " value="{{old('name')}}" />
                                        </div>
                                        <span class="invalid-feedback d-block" role="alert">
                                            @error('name')<strong> <span class="error">{{ $message }}</span></strong>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="name">{{ __('Name') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-state"></span>
                                                </div>
                                            </div>

                                            <select name="status" id="status"
                                                class="form-control {{ $errors->has('status') ? 'is-invalid' : ''}} ">
                                                <option value='once'>Once</option>
                                                <option value='allday'>Verry Day</option>
                                                <option value='verryWeek'>Verry Week</option>
                                                <option value='VerryYear'>Verry Year</option>


                                            </select>
                                        </div>
                                        <span class="invalid-feedback d-block" role="alert">
                                            @error('status')<strong> <span class="error">{{ $message }}</span></strong>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="started_date">{{ __('Started at') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-state"></span>
                                                </div>
                                            </div>
                                            <input type="datetime-local" name="started_date" id="started_date"
                                                placeholder="{{ __('Started at') }}" class="form-control {{ $errors->has('started_date') ? 'is-invalid' : ''
                                                }} " value="{{old('started_date')}}" />
                                        </div>
                                        <span class="invalid-feedback d-block" role="alert">
                                            @error('started_date')<strong> <span
                                                    class="error">{{ $message }}</span></strong>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ended_date">{{ __('Ended at') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-state"></span>
                                                </div>
                                            </div>
                                            <input type="datetime-local" name="ended_date" id="ended_date"
                                                placeholder="{{ __('Ended at') }}" class="form-control {{ $errors->has('ended_date') ? 'is-invalid' : ''
                                                }} " value="{{old('ended_date')}}" />
                                        </div>
                                        <span class="invalid-feedback d-block" role="alert">
                                            @error('ended_date')<strong> <span
                                                    class="error">{{ $message }}</span></strong>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="summernote">{{ __('Description') }}</label>
                                        <textarea name="description" id="summernote"
                                            placeholder="{{ __('Description') }}" class="form-control {{ $errors->has('description') ? 'is-invalid' : ''
                                                }} " value="{{old('description')}}">{{old('description')}}</textarea>

                                        <span class="invalid-feedback d-block" role="alert">
                                            @error('description')<strong> <span
                                                    class="error">{{ $message }}</span></strong>
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary tn-lg btn-block"> <i
                                        class="fas fa-save    "></i> {{__("Save Task")}}k</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>


</x-app-layout>
