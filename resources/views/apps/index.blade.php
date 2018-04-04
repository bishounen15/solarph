<?php
    Use App\App as App;
    $app_instance = new App();
?>
@extends('layouts.app')
@section('content')
<h1>Applications Maintenance</h1>
@if(auth::user()->initialized == 1)
    <a href="{{route('new_app', ["app_type" => 0])}}" role="button" class="btn btn-primary">Create Parent App</a>
    <table class="table">
        <thead class="thead-dark">
            <th width="25%">App Code</th>
            <th width="45%">Title</th>
            <th width="30%">Actions</th>
        </thead>
        <tbody class="tbody-light">
            @foreach($apps as $app)
            <tr>
                <td class="align-middle"><img src="/storage/images/{{$app->app_code}}.png" height="43px" width="45px" alt="">  {{$app->app_code}}</td>
                <td class="align-middle">{{$app->app_title}}</td>
                <td class="align-middle">
                    <a href="{{route('show_app', [0, $app->id])}}" role="button" class="btn btn-sm btn-success">Edit</a>
                    <a href="{{route('new_child', ["app_type" => 1, "app_id" => $app->id])}}" role="button" class="btn btn-sm btn-primary">Add Child</a>
                    <?php
                        $child_count = $app_instance->countChild($app->id);

                        if ($child_count > 0) {
                            // echo '<a href="#" role="button" class="btn btn-sm btn-secondary">Edit Child</a>';
                            $children = $app_instance->childApps($app->id);
                            ?>
                            <div class="btn-group btn-group-sm" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Edit Child
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    @foreach($children as $child)
                                    <a class="dropdown-item" href="{{route('show_app', [1, $child->id])}}">
                                        <img src="/storage/images/{{$child->app_code}}.png" height="43px" width="45px" alt="">
                                        {{$child->app_title}}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            <?php
                        } 
                    ?>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="alert alert-danger text-center">You do not have access to this module.</div>
@endif
@endsection