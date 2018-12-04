@extends('layouts.dash')
@inject('getProfile','App\Http\Controllers\ProfilesCont')
@inject('allComments','App\Http\Controllers\CommentsCont')
@inject('Views', 'App\Http\Controllers\ViewsCont')
@inject('encode', 'App\Http\Controllers\AdminsCont')
@inject('likes', 'App\Http\Controllers\LikesCont')
@inject('userList', 'App\UsersByUser')
@inject('User', 'App\User')


@section('meta')
<meta name="title" content="Rest api test page">
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
              
              <div class="col-md-12 bg-white form-group">
                {!! Form::open(['method'=>'GET','url'=>'api-test','role'=>'search'])  !!}
               <center> <h2 class="well">RestApi Test (cURL test)</h2> </center>
                    <div hidden>
                      {{ Form::number('uid', Auth::user()->id) }}
                    </div>
                {{ Form::label('method', 'Method')}}
                {{ Form::select('method', ['GET'=>'GET', 'PUT'=>'PUT', 'POST'=>'POST', 'DELETE'=>'DELETE'], ['GET'],array('class'=>'form-control select2'))}}
            
                {{ Form::label('table', 'Table')}}
                {{ Form::select('table', $tables, null,array('class'=>'form-control select2'))}}
                
                {{ Form::label('q', 'Query')}}
                {{ Form::text('q', null,array('class'=>'form-control select2'))}}
                

            <div>{{ Form::submit('Send', ['class'=>'btn btn-success'])}}</div>

            </div>
                  {!! Form::close() !!}
          </div>
          @if($results)
            <div class="row well col-md-12 bg-white">
            {{ $results }} 
            </div>
          @else
            <div class="row well col-md-12 bg-white">
              Ready
            </div>
          @endif
</div>

@stop