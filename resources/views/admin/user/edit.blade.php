<x-app-layout>
    @section('page-title')
    Edit User |
    @endsection
    <x-slot name="header">


        <div class="col-sm-6">
            <h1 class="m-0 text-dark font-weight-bold">{{ __('Edit User') }}</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="/home">{{_("Home") }}</a>
                </li>
                <li class="breadcrumb-item active">{{_("Edit User")}}</li>
            </ol>
        </div>
        <!-- /.col -->
    </x-slot>

    <div class="card card-warning">
        <div class="card-header">
            {{ _('Edit User') }}
        </div>

        <div class="card-body">
            <form action="{{ route("admin.users.update", [$user->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="account_type">Account Type</label>
                            <div class="input-group ">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-genderless"></span>
                                    </div>
                                </div>

                                <select id="account_type" name="account_type"
                                    class="form-control{{ $errors->has('account_type') ? 'is-invalid' : '' }} ">
                                    <option value="">--------------Select Account type--------------
                                    </option>
                                    <option value="is_staff" {{$user->is_staff ? 'selected' : ''}}>Staff</option>
                                    <option value="is_investor" {{$user->is_investor ? 'selected' : ''}}>Investor
                                    </option>
                                    <option value="is_entrepreneur" {{$user->is_entrepreneur ? 'selected' : ''}}>
                                        Entrepreneur</option>
                                    <option value="is_candidate" {{$user->is_candidate ? 'selected' : ''}}>Candidate
                                    </option>
                                </select>
                            </div>


                            <span class="invalid-feedback d-block" role="alert">
                                <strong id="error_account_type">
                                    @if($errors->has('account_type'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('account_type') }}
                                    </em>
                                    @endif
                                </strong>
                            </span>

                        </div>
                    </div>

                    <div class="col-md-12" id="check_role">
                        <div class="form-group">
                            <label for="roles">{{ _('Roles') }}*
                                <span class="btn btn-info btn-xs select-all">{{ _('Select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all">{{ _('Deselect_all') }}</span>
                            </label>
                            <select name="roles[]" id="roles"
                                class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}"
                                multiple="multiple" required>
                                @foreach($roles as $id => $roles)
                                <option value="{{ $id }}"
                                    {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>
                                    {{ $roles }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('roles'))
                            <em class="invalid-feedback">
                                {{ $errors->first('roles') }}
                            </em>
                            @endif

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                                <input type="text" name="first_name" placeholder="First name" id="first_name"
                                    class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                                    value="{{ old('first_name', isset($user) ? $user->first_name : '') }}" required />
                            </div>

                            <span class="invalid-feedback d-block" role="alert">
                                <strong id="error_first_name">
                                    {{ $errors->first('first_name') }}
                                </strong>
                            </span>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                                <input type="text" name="last_name" placeholder="Last name" id="last_name"
                                    class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                                    value="{{ old('last_name', isset($user) ? $user->last_name : '') }}" required />
                            </div>

                            <span class="invalid-feedback d-block" role="alert">
                                <strong id="error_last_name">{{ $errors->first('last_name') }}</strong>
                            </span>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                                <input type="email" id="email" name="email" placeholder="Email Address"
                                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                    value="{{ old('email', isset($user) ? $user->email : '') }}" required />
                            </div>

                            <span class="invalid-feedback d-block" role="alert">
                                <strong id="error_email">{{ $errors->first('email') }}</strong>
                            </span>

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobile_number">Mobile Number</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-mobile"></span>
                                    </div>
                                </div>
                                <input type="tel" id="mobile_number" name="mobile_number"
                                    placeholder="Mobile number : +260979125950"
                                    value="{{ old('mobile_number', isset($user) ? $user->mobile_number : '') }}"
                                    required
                                    class="form-control {{ $errors->has('mobile_number') ? 'is-invalid' : '' }}" />
                            </div>

                            <span class="invalid-feedback d-block" role="alert">
                                <strong id="is_mobile_number">{{ $errors->first('mobile_number') }}</strong>
                            </span>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-genderless"></span>
                                    </div>
                                </div>

                                <select id="country" name="country" class="form-control ">
                                    <option value="">--------------Select Account type--------------
                                    </option>
                                    @foreach($countries as $country)
                                    <option value="{{ $country->id }}">
                                        {{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <span class=" invalid-feedback d-block" role="alert">
                                <strong id="error_account_type"></strong>
                            </span>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="place_birth">Place Birth</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-mobile"></span>
                                    </div>
                                </div>
                                <input type="text" id="place_birth" name="place_birth" placeholder="Place Birth"
                                    class="form-control " />
                            </div>

                            <span class="invalid-feedback d-block" role="alert">
                                <strong id="is_place_birth"></strong>
                            </span>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-genderless"></span>
                                    </div>
                                </div>

                                <select id="gender" name="gender" class="form-control ">
                                    <option value="">Select your gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>


                            <span class="invalid-feedback d-block" role="alert">
                                <strong id="error_gender"></strong>
                            </span>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="birth_date">Birth Date</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-calendar"></span>
                                    </div>
                                </div>
                                <input type="date" id="birth_date" name="birth_date" placeholder="Birth Date"
                                    class="form-control " />
                            </div>

                            <span class="invalid-feedback d-block" role="alert">
                                <strong id="error_birth_date"></strong>
                            </span>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="is_active">{{ __('Status') }}</label>
                            <div class="input-group">
                                <div class="form-group">
                                    <div class="form-group">
                                        <div
                                            class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success ">
                                            <input type="checkbox" name="is_active" name="is_active"
                                                class="custom-control-input custom-control-input-lg" id="is_active"
                                                required>
                                            <label class="custom-control-label" for="is_active">
                                                <span id="active">
                                                    Desactive
                                                </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="invalid-feedback d-block" role="alert">
                                @error('is_active') <strong><span class="error">{{ $message }}</span></strong>
                                @enderror
                            </span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email">{{ __('Super Admin') }}</label>
                            <div class="input-group">
                                <div class="form-group">
                                    <div class="form-group">
                                        <div
                                            class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success ">
                                            <input type="checkbox" name="is_superuser" name="is_superuser"
                                                class="custom-control-input custom-control-input-lg" id="is_superuser">
                                            <label class="custom-control-label" for="is_superuser">
                                                <span id="superuser">

                                                    Desactived

                                                </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="invalid-feedback d-block" role="alert">
                                @error('is_superuser') <strong><span class="error">{{ $message }}</span></strong>
                                @enderror
                            </span>
                        </div>
                    </div>



                </div>
                <div>
                    <input class="btn btn-danger" type="submit" value="{{ _('Save Change') }}">
                </div>
            </form>


        </div>
    </div>
</x-app-layout>
