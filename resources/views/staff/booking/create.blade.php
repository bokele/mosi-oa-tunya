<x-app-layout>
    @section('page-title')
    Create Booing | Appointment |
    @endsection
    <x-slot name="header">


        <div class="col-sm-6">
            <h1 class="m-0 text-dark font-weight-bold">{{ __('Create Booking') }}</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="/home">{{_("Home") }}</a>
                </li>
                <li class="breadcrumb-item active"><a href="{{route('admin.bookings.index')}}">{{_("Booking") }}</a>
                </li>
                <li class="breadcrumb-item active">{{_("Craete")}}</li>
            </ol>
        </div>
        <!-- /.col -->
    </x-slot>
    <div class="row">
        <div class="col-md-12">
            <section class="user_comment">
                <div class="card card-blue">
                    <div class="card-header">
                        <h3 class="card-title">
                            <span class="fa fa-plus"></span> {{_("Create Booing - Appointment ")}}
                        </h3>


                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">

                        @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                        @endif

                        <form action="{{ route('admin.bookings.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="user">{{ __('User') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-state"></span>
                                                </div>
                                            </div>
                                            <select name="user" id="user" class="form-control {{ $errors->has('user') ? 'is-invalid' : ''
                                                }} ">
                                                <option value="" class="text-center">------------Select
                                                    User------------
                                                </option>
                                                @forelse ($users as $user)
                                                <option value="{{$user->id}}">{{$user->full_name}} -
                                                    @if($user->is_investor)
                                                    {{'Investor'}}
                                                    @elseif($user->is_candidate)
                                                    {{'Candidate'}}
                                                    @elseif($user->is_entrepreneur)
                                                    {{'Entrepreneur'}}
                                                    @endif
                                                </option>
                                                @empty
                                                <option value="">------------Non User Added ------------</option>
                                                @endforelse

                                            </select>
                                        </div>
                                        <span class="invalid-feedback d-block" role="alert">
                                            @error('user')<strong> <span class="error">{{ $message }}</span></strong>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">{{ __('Status') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-state"></span>
                                                </div>
                                            </div>
                                            <select name="status" id="status" placeholder="{{ __('Title') }}" class="form-control {{ $errors->has('user') ? 'is-invalid' : ''
                                                                                }} ">
                                                <option value="" class="text-center">------------Select
                                                    Status------------
                                                </option>

                                                <option value="attended">Attended</option>
                                                <option value="cancel">Cancel</option>
                                                <option value="waiting">Waiting</option>
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
                                        <label for="started_time">{{ __('Started Time') }}<span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-state"></span>
                                                </div>
                                            </div>
                                            <input type="datetime-local" name="started_time" id="started_time"
                                                placeholder="{{ __('Started at') }}" class="form-control {{ $errors->has('started_time') ? 'is-invalid' : ''
                                                                                }} " value="{{old('started_time')}}" />
                                        </div>
                                        <span class="invalid-feedback d-block" role="alert">
                                            @error('started_time')<strong> <span
                                                    class="error">{{ $message }}</span></strong>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ended_time">{{ __('Ended Time') }}<span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-state"></span>
                                                </div>
                                            </div>
                                            <input type="datetime-local" name="ended_time" id="ended_time"
                                                placeholder="{{ __('Ended at') }}" class="form-control {{ $errors->has('ended_time') ? 'is-invalid' : ''
                                                                                }} " value="{{old('ended_time')}}" />
                                        </div>
                                        <span class="invalid-feedback d-block" role="alert">
                                            @error('ended_time')<strong> <span
                                                    class="error">{{ $message }}</span></strong>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label> Come to the Office Or Onlone</label>
                                        <div class="checkbox">
                                            <input type="checkbox" name="come_into_office" id="come_into_office"
                                                checked />
                                        </div>
                                    </div>

                                    <input type="hidden" name="come_into_office" id="hidden_come_into_office"
                                        value="yes" />

                                    <span class="invalid-feedback d-block" role="alert">
                                        @error('come_into_office')<strong> <span
                                                class="error">{{ $message }}</span></strong>
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="summernote">{{ __('User comment') }}<span
                                                class="text-danger">*</span></label>
                                        <textarea name="user_comment" id="summernote"
                                            placeholder="{{ __('User comment') }}" class="form-control {{ $errors->has('user_comment') ? 'is-invalid' : ''
                                                }} ">{{old('user_comment')}}</textarea>

                                        <span class="invalid-feedback d-block" role="alert">
                                            @error('user_comment')<strong> <span
                                                    class="error">{{ $message }}</span></strong>
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="staff_comment">{{ __('Staff comment') }}<span
                                                class="text-danger">*</span></label>
                                        <textarea name="staff_comment" id="staff_comment"
                                            placeholder="{{ __('Staff comment') }}"
                                            class="form-control {{ $errors->has('staff_comment') ? 'is-invalid' : ''
                                                                                }}  summernote">{{old('staff_comment')}}</textarea>
                                        <span class="invalid-feedback d-block" role="alert">
                                            @error('staff_comment')<strong> <span
                                                    class="error">{{ $message }}</span></strong>
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="support_file">Support File<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class=""></span>
                                                </div>
                                            </div>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input {{ $errors->has('support_file') ? 'is-invalid' : ''
                                                                                                                }}"
                                                    id="support_file" name="support_file" :value="old('support_file')">
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
                                        class="fas fa-save    "></i> Save </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function(){

     $('#come_into_office').bootstrapToggle({
      on: 'Office',
      off: 'Online',
      onstyle: 'primary',
      offstyle: 'success'
     });

     $('#come_into_office').change(function(){
      if($(this).prop('checked'))
      {
       $('#hidden_come_into_office').val('yes');
      }
      else
      {
       $('#hidden_come_into_office').val('no');
      }
     });
     });
    </script>
    @endpush
</x-app-layout>
