<?php
    Use App\App as App;
?>
@extends('layouts.app')
@section('content')
<h3>Level Assignment for {{$rank->description}}</h3>
@if(App::find(2)->access()->where("user_id","=",auth::user()->id)->first() != null)
<div class="row">
    <div class="col-sm-6">
        <div class="card">
        <button id="assign_level" class="btn btn-info">Assign Selected</button>
        </div>
        <table class="table table-sm">
            <thead class="thead-dark">
                <tr>
                    <th colspan="2" class="text-center">Un-assigned Levels</th>
                </tr>
                <tr>
                    <th class="text-center">Select</th>
                    <th>Position Level</th>
                </tr>
            </thead>
            <tbody class="tbody-light" id="levels-unassigned">
                @foreach($levels as $level)
                <tr>
                    <td class="align-middle">
                        <input type="checkbox" class="form-control unassigned-levels" name="assign[]" value="{{$level->id}}">
                    </td>
                    <td class="align-middle">{{$level->description}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="col-sm-6">
        <div class="card">
            <button id="unassign_level" class="btn btn-danger">Un-assign Selected</button>
        </div>
        <table class="table table-sm">
            <thead class="thead-dark">
                <tr>
                    <th colspan="3" class="text-center">Assigned Levels</th>
                </tr>
                <tr>
                    <th width="15%" class="text-center">Select</th>
                    <th width="60%">Position Level</th>
                    <th width="25%">Action</th>
                </tr>
            </thead>
            <tbody class="tbody-light" id="levels-assigned">
                @foreach($assigned_levels as $assigned_level)
                <tr>
                    <td>
                        <input type="checkbox" class="form-control unassigned-levels" name="unassign[]" id="{{$assigned_level->description}}" value="{{$assigned_level->id}}">
                    </td>
                    <td>{{$assigned_level->description}}</td>
                    <td>
                        <button class="btn btn-secondary move-up"><i class="fas fa-chevron-circle-up"></i></button> 
                        <button class="btn btn-secondary move-down"><i class="fas fa-chevron-circle-down"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <button id="apply-assignment" class="btn btn-success">Apply Changes</button>
            <a href="{{route('corporate_ranks')}}" role="button" class="btn btn-warning">Back to Corporate Ranks</a>
        </div>
    </div>
</div>
@else
<div class="alert alert-danger text-center">
    You do not have access to this module.
</div>
@endif
@endsection

@push('jscript')
    <script>
        $("#assign_level").click(function() {
            var position_levels = $('input[name="assign[]"]:checked');
            if ($(position_levels).length > 0) {
                $.ajax({
                    type:'POST',
                    url:'{{route('corpassign_ajax')}}',
                    data: position_levels,
                    datatype: 'json',
                    success: function (data) {
                        myRows = '';
                        for (i=0; i < data.length; i++) {
                            myRows += '<tr><td><input type="checkbox" class="form-control unassigned-levels" name="unassign[]" id="'+data[i].description+'" value="'+data[i].id+'"></td>' +
                                      '<td>'+data[i].description+'</td>' +
                                      '<td><a href="#" role="button" class="btn btn-secondary btn-sm"><i class="fas fa-chevron-circle-up"></i></a> ' +
                                      '<a href="#" role="button" class="btn btn-secondary btn-sm"><i class="fas fa-chevron-circle-down"></i></a></td></tr>';
                        }

                        $("#levels-assigned").append(myRows);
                        $(position_levels).closest('tr').remove();
                    },
                    error: function(xhr, textStatus, errorThrown){
				       alert (errorThrown);
				    }
                });
            }
        });

        $("#unassign_level").click(function() {
            var position_levels = $('input[name="unassign[]"]:checked');
            if ($(position_levels).length > 0) {
                myRows = '';
                $(position_levels).each(function() {
                    myRows += '<tr><td><input type="checkbox" class="form-control unassigned-levels" name="assign[]" value="'+$(this).attr('value')+'"></td>' +
                              '<td>'+$(this).attr('id')+'</td></tr>';
                });

                $("#levels-unassigned").append(myRows);
                $(position_levels).closest('tr').remove();
            }
        });

        $("#apply-assignment").click(function() {
            var position_levels = $('input[name="unassign[]"]');

            if ($(position_levels).length > 0) {
                $.ajax({
                    type:'POST',
                    url:'{{route("corpapply_ajax", [$rank->id])}}',
                    data: position_levels,
                    datatype: 'json',
                    success: function () {
                        window.location.replace('{!! route("corporate_ranks") !!}');
                    },
                    error: function(xhr, textStatus, errorThrown){
				       alert (errorThrown);
				    }
                });
            } else {
                alert ("walang laman");
            }
        });

        $(".move-up").click(function() {
            $(this).closest('tr').prev().before($(this).closest('tr'));
        });

        $(".move-down").click(function() {
            $(this).closest('tr').next().after($(this).closest('tr'));
        });
    </script>
@endpush