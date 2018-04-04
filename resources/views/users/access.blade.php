@extends('layouts.app')
@section('content')
<h3>Set User Access</h3>
<h5>
    @if($user->information != null)
    {{$user->information->id_number}} - {{$user->information->getFullName()}}
    @else
    {{$user->name}}
    @endif
</h4>
<form action="{{route('set_user_access',[$user->id])}}" method="POST">
<div class="card">
    <input type="submit" class="btn btn-success" value="Apply Changes">
</div>
@foreach($apps as $app)
<div class="card">
    <div class="card-header">{{$app->app_title}}</div>
    <div class="card-body">
        <div class="form-row">
        @foreach($app->children() as $child)
            <div class="form-group col-sm-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="selected_apps[]" value="{{$child->id}}"
                    @if ($child->access()->where("user_id","=",$user->id)->first() != null)
                    checked
                    @endif
                    >
                    <label class="form-check-label" for="defaultCheck1">{{$child->app_title}}</label>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>
@endforeach
</form>
@endsection