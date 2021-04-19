<x-app-layout>
    @section('page-title')
    Edit role |
    @endsection
    <x-slot name="header">


        <div class="col-sm-6">
            <h1 class="m-0 text-dark font-weight-bold">{{ __('Role Edit') }}</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="/home">{{_("Home") }}</a>
                </li>
                <li class="breadcrumb-item active">{{_("role edit")}}</li>
            </ol>
        </div>
        <!-- /.col -->
    </x-slot>

    <div class="card card-warning">
        <div class="card-header ">
            {{ __('Role Edit') }}
        </div>

        <div class="card-body">
            <form action="{{ route("admin.roles.update", [$role->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group {{ $errors->has('role_name') ? 'has-error' : '' }}">
                    <label for="role_name">Title<span class="text-danger">* </span> </label> <input type="text"
                        id="title" name="role_name" class="form-control"
                        value="{{ old('role_name', isset($role) ? $role->name : '') }}" required>
                    @if($errors->has('role_name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('role_name') }}
                    </em>
                    @endif

                </div>
                <div class="form-group {{ $errors->has('permissions') ? 'has-error' : '' }}">
                    <label for="permissions">Permissions
                        <span class="btn btn-info btn-xs select-all">Select all</span>
                        <span class="btn btn-info btn-xs deselect-all">Deselect all</span></label>
                    <select name="permissions[]" id="permissions" class="form-control select2" multiple="multiple"
                        required>
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
                <div>
                    <input class="btn btn-danger" type="submit" value="{{_('Save Change') }}">
                </div>
            </form>


        </div>
    </div>
</x-app-layout>
