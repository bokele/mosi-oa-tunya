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

            <form id="role_form" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group {{ $errors->has('role_name') ? 'has-error' : '' }}">
                                <label for="title">role_name*</label>
                                <input type="text" id="role_name" name="role_name" class="form-control"
                                    value="{{ old('role_name', isset($role) ? $role->name : '') }}" required>
                                @if($errors->has('role_name'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('role_name') }}
                                </em>
                                @endif

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group {{ $errors->has('permissions') ? 'has-error' : '' }}">
                                <label for="permissions">permissions*
                                    <span class="btn btn-info btn-xs select-all">select_all</span>
                                    <span class="btn btn-info btn-xs deselect-all">deselect_all</span></label>
                                <select name="permissions[]" id="permissions" class="form-control select2"
                                    multiple="multiple" required>
                                    @foreach($permissions as $id => $permissions)
                                    <option value="{{ $id }}"
                                        {{ (in_array($id, old('permissions', [])) || isset($role) && $role->permissions->contains($id)) ? 'selected' : '' }}>
                                        {{ $permissions }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('permissions'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('permissions') }}
                                </em>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" name="action" id="action" value="Add">
                    <input type="hidden" name="permission_id" id="permission_id">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fa fa-times" aria-hidden="true"></i> Close
                    </button>


                    <button id="action_button" type="submit" class="btn btn-primary">
                        <i class="fa fa-save fa-2"></i> Create
                    </button>

                </div>
            </form>

        </div>
    </div>
</div>
