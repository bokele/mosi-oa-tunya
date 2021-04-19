<div class="modal fade" id="create_modal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
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
            <div class="modal-body">
                <form id="user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="account_type">Account Type</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-genderless"></span>
                                            </div>
                                        </div>

                                        <select id="account_type" name="account_type" class="form-control ">
                                            <option value="">--------------Select Account type--------------
                                            </option>
                                            <option value="is_staff">Staff</option>
                                            <option value="is_investor">Investor</option>
                                            <option value="is_entrepreneur">Entrepreneur</option>
                                            <option value="is_candidate">Candidate</option>
                                        </select>
                                    </div>


                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong id="error_account_type"></strong>
                                    </span>

                                </div>
                            </div>

                            <div class="col-md-12" id="check_role">
                                <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
                                    <label for="roles">{{ _('Roles') }}*
                                        <span class="btn btn-info btn-xs select-all">{{ _('Select_all') }}</span>
                                        <span class="btn btn-info btn-xs deselect-all">{{ _('Deselect_all') }}</span>
                                    </label>
                                    <select name="roles[]" id="roles" class="form-control select2" multiple="multiple"
                                        required>
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
                                            class="form-control" />
                                    </div>

                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong id="error_first_name"></strong>
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
                                            class="form-control" />
                                    </div>

                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong id="error_last_name"></strong>
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
                                            class="form-control " />
                                    </div>

                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong id="error_email"></strong>
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
                                            placeholder="Mobile number : +260979125950" class="form-control " />
                                    </div>

                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong id="is_mobile_number"></strong>
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
                                                        class="custom-control-input custom-control-input-lg"
                                                        id="is_active" required>
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
                                                        class="custom-control-input custom-control-input-lg"
                                                        id="is_superuser">
                                                    <label class="custom-control-label" for="is_superuser">
                                                        <span id="superuser">

                                                            Desactived

                                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        @error('is_superuser') <strong><span
                                                class="error">{{ $message }}</span></strong>
                                        @enderror
                                    </span>
                                </div>
                            </div>



                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <input type="hidden" name="action" id="action" value="Add">
                        <input type="hidden" name="hidden_id" id="hidden_id">
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
</div>
