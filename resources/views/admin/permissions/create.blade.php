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
            <form id="permission_form">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="permission_name">{{ __('Permission Name') }}</label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-state"></span>
                                        </div>
                                    </div>
                                    <input type="text" name="permission_name" id="permission_name"
                                        placeholder="{{ __('Permission Name') }}" class="form-control " />
                                </div>
                                <span class="invalid-feedback d-block" role="alert">
                                    {{-- <strong id="error_current_status_of_registraion"></strong> --}}
                                    <strong> <span id="error_permission_name" class="error"></span></strong>

                                </span>
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
