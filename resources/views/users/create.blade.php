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
    {!! Form::open(array('route' => 'users.store', 'method'=>'post' ,'files'=>'true', 'class'=>'form-group col-md-12')) !!}
    <div class="col-md-12 bg-white">
          <div hidden>
            {{ Form::number('uid', Auth::user()->id) }}
          </div>
       <div class="pull-right well">
               
          {{ Form::submit('Add User', ['class' => 'btn btn-success']) }}
            <a href="{{ route('users.index') }}" class="btn btn-danger">Cancel</a>
        </div>
      <div class="form-group well">
         @for($i = 0; $i < sizeof($col); $i++)
              @if($col[$i] !== 'id' AND $col[$i] !== 'created_at' AND $col[$i] !== 'updated_at' AND $col[$i] !== 'uid' AND $col[$i] !== 'updated_at' AND $col[$i] !== 'blocked' AND $col[$i] !== 'ip' AND $col[$i] !== 'role' AND $col[$i] !== 'token' AND $col[$i] !== 'api_token' AND  $col[$i] !== 'api_id' AND  $col[$i] !== 'api_only' AND $col[$i] !== 'remember_token' AND $col[$i] !== 'level'  AND $col[$i] !== 'level' AND $col[$i] !== 'profile')
                    @php $n = $col[$i]; @endphp
                      {{ Form::label($n, ucfirst(str_replace('_', ' ',$n)), ['class'=>'col-md-12']) }}
                      {{ Form::text($n, null, array('class' => 'form-control', 'required' => 'true')) }}
                     @else
                    <!-- <td>{{ $col[$i] }}</td> -->
                   @endif
               @endfor
      </div>
      
        <div class="left-col align-items-center justify-content-between">
            <div class="time">Admin: {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</div>
        </div>

    </div>

        
  
</div>
</div>

{!! Form::close() !!}
@stop