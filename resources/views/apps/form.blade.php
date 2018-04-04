@extends('layouts.app')
@section('content')
<h2>{{$modify == 0 ? "Create" : "Edit"}} {{$app_type == 0 ? "Parent" : "Child"}} Application</h2>
@if(auth::user()->initialized == 1)
    <div class="card">
        <div class="card-header">
            Application Details
        </div>
        <div class="card-body">
            <form action="{{ $modify == 1 ? route('modify_app',[$selected_app_id]) : route('create_app',[$app_type]) }}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="parent_id" id="parent_id" value="{{ $app_type == 0 ? $app_type : $app_id }}">
                
                <div class="form-group">
                    <label for="app_code">Application Code</label>
                <input type="text" class="form-control" id="app_code" name="app_code" placeholder="Enter Application Code" value="{{ old('app_code') ? old('app_code') : $app_code }}" {{ $modify == 1 ? "disabled" : "" }}>
                    <small class="form-text text-danger">{{ $errors->first('app_code') }}</small>
                </div>

                <div class="form-group">
                    <label for="app_title">Application Title</label>
                    <input type="text" class="form-control" id="app_title" name="app_title" placeholder="Enter Application Title" value="{{ old('app_title') ? old('app_title') : $app_title }}">
                    <small class="form-text text-danger">{{ $errors->first('app_title') }}</small>
                </div>

                <div class="form-group">
                    <label for="app_desc">Description</label>
                    <textarea class="form-control" rows="3" id="app_desc" name="app_desc" placeholder="Enter Description">{{ old('app_desc') ? old('app_desc') : $app_desc }}</textarea>
                    <small class="form-text text-danger">{{ $errors->first('app_desc') }}</small>
                </div>

                <div class="form-group">
                    <label for="app_image">App Image</label>
                    <input type="file" class="form-control-file" id="app_image" name="app_image" accept=".png">
                </div>

                <button type="submit" class="btn btn-primary">Save App</button>
                <a href="{{route('apps')}}" role="button" class="btn btn-warning">Cancel</a>
            </form>        
        </div>
    </div>
@else
    <div class="alert alert-danger text-center">You do not have access to this module.</div>
@endif
@endsection