@extends('layouts.dash')
@inject('getProfile','App\Http\Controllers\ProfilesCont')
@inject('allComments','App\Http\Controllers\CommentsCont')
@inject('Views', 'App\Http\Controllers\ViewsCont')
@inject('encode', 'App\Http\Controllers\AdminsCont')
@inject('likes', 'App\Http\Controllers\LikesCont')


@section('meta')
<meta name="title" content="Creat New Table">
@stop

@section('title')

<h2>Creat New Rest Table</h2>

@stop


@section('styles')

@stop

@section('content')

 <div class="panel-header panel-header-sm">
            </div>
            <div class="content">

                <div class="row">
                  <div class="well message">
                      @include('partials._messages')
                  </div>
    {!! Form::open(array('route' => 'admin-rest.store', 'method'=>'post' ,'files'=>'true', 'class'=>'form-group col-md-12')) !!}
    <div class="col-md-12 bg-white">
          <div hidden>
            {{ Form::number('uid', Auth::user()->id) }}
          </div>
       <div class="pull-right well">
               
          {{ Form::submit('Create a Table', ['class' => 'btn btn-success']) }}
            <a href="{{ route('admin-rest.index') }}" class="btn btn-danger">Cancel</a>
        </div>
      <div class="form-group well">
          {{ Form::label('title', 'Title: (Your table will start with your ID as "'.Auth::user()->id.'_" then your table name)', ['class'=>'col-md-12']) }}
          {{ Form::text('title', null, array('class' => 'form-control', 'required' => 'true')) }}
      </div>
       <div class="well">
        {{ Form::label('body', 'Table description:', ['class'=>'col-md-12']) }}
            {{ Form::textarea('body', null, array('class' => 'form-control ckeditor', 'required' => 'required')) }}
        </div> 
        <div class="well">
           {{ Form::label('fields', 'Table fields:', ['class'=>'col-md-12']) }}
           <fieldset id="buildYourFields">
                <legend>Build your own form!</legend>
          </fieldset>
          <input type="button" value="Add a field" class="add btn btn-success" id="add" />
        </div>
        
        <div class="left-col align-items-center justify-content-between">
            <div class="time">Author: {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</div>
        </div>

    </div>

        
  
</div>
</div>

<script>
$(document).ready(function() {
  var i =0;
    $("#add").click(function() {
        var lastField = $("#buildYourFields div:last");
        var intId = (lastField && lastField.length && lastField.data("idx") + 1) || 1;
        var fieldWrapper = $("<div class=\"fieldwrapper well\" id=\"field" + intId + "\"/>");
        fieldWrapper.data("idx", intId);
        var fName = $('{{ Form::label("fieldname[]", "Field Name", ["class" => "col-md-12"])}}{{ Form::text("fieldname[]", null, array("class" => "form-control", "required" => "true", "placeholder"=>"Field name")) }}{{ Form::label("typeis[]", "Field Type", ["class" => "col-md-12"])}}{{ Form::select("typeis[]", ["string"=>"String", "integer"=>"INT", "text"=>"Text"], array("class" => "form-control col-md-12", "required" => "true")) }}{{ Form::label("fieldnull[]", "Field Accept Null", ["class" => "col-md-12"])}}{{ Form::select("fieldnull[]", ["yes"=>"Yes", "no"=>"No"], array("class" => "form-control col-md-12", "required" => "true")) }}{{ Form::label("fielddefault[]", "Field Default", ["class" => "col-md-12"])}}{{ Form::text("fielddefault[]", null, array("class" => "form-control", "required" => "true", "placeholder"=>"Field default")) }}</div>');
        i++;
        var removeButton = $("<br><input type=\"button\" class=\"remove\" value=\"-\" />");
        removeButton.click(function() {
            $(this).parent().remove();
            i--;
        });
        fieldWrapper.append(fName);
        fieldWrapper.append(removeButton);
        $("#buildYourFields").append(fieldWrapper);
    });
});
    

</script>
{!! Form::close() !!}
@stop