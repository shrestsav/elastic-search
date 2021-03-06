@extends('layouts.app')

@section('content')
<div class="row justify-content-md-center">
  <div class="col-md-5">
    <div class="card-wrapper">
      <div class="card">
        <div class="card-header">
          <h3 class="mb-0">Edit Role</h3>
        </div>
        <div class="card-body">
          <form class="form-horizontal needs-validation" role="form" method="POST" action="{{ url('admin/roles/'.$role->id) }}" novalidate>
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <div class="form-group{{ $errors->has('display_name') ? ' has-error' : '' }}">
              <label class="form-control-label">Display name</label>
              <input type="text" class="form-control" placeholder="Eg:  Admin" name="display_name" value="{{$role->display_name}}" required autofocus>
              <div class="invalid-feedback">
                Display Name is Required
              </div>     
              @if ($errors->has('display_name'))
                <div class="invalid-feedback" style="display: block;">
                  {{ $errors->first('display_name') }}
                </div>
              @endif
            </div>
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
              <label class="form-control-label">Description</label>
              <textarea class="form-control" name="description" rows="3" required>{{$role->description}}</textarea>
              <div class="invalid-feedback">
                Description is Required
              </div> 
              @if ($errors->has('description'))
              <div class="invalid-feedback" style="display: block;">
                {{ $errors->first('description') }}
              </div>
              @endif
            </div>
            <div class="form-group{{ $errors->has('permissions') ? ' has-error' : '' }}">
              <label for="permissions">Permissions</label>
              @foreach ($permissions as $permission)
              <div class="custom-control custom-checkbox mb-3">
                <input class="custom-control-input" type="checkbox" id="permission_{{$permission->id}}"  value="{{$permission->id}}" name="permissions[]" {{in_array($permission->id, $rolePermissions) ? "checked" : null}}>
                <label class="custom-control-label" for="permission_{{$permission->id}}">{{$permission->display_name}}</label>
              </div>
              @endforeach
              @if ($errors->has('permissions'))
                <span class="help-block">
                  <strong>{{ $errors->first('permissions') }}</strong>
                </span>
                @endif
            </div>
            <button type="submit" class="btn btn-outline-success"> Update </button>
            <a class="btn btn-outline-warning" href="{{ url('admin/roles') }}"> Cancel </a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection