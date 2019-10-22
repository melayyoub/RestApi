@extends('layouts.dash')
@inject('getProfile','App\Http\Controllers\ProfilesCont')
@inject('encode', 'App\Http\Controllers\AdminsCont')
@inject('user', 'Illuminate\Foundation\Auth\User')


@section('content')
<div class="well panel-header panel-header-sm">
    </div>
    <div class="section section-buttons">
                <div class="container">
                    <div class="tim-title">
                        <h2>Basic Linux/Unix Exec Commands</h2>
                    </div>
          <div class="well message">
              @include('partials._messages')
          </div>
          <div class="well">
        {!! Form::open(['method'=>'GET','url'=>'admin-shell','class'=>'navbar-form navbar-left','role'=>'search'])  !!}

          <div class="input-group custom-search-form">
              <input type="text" class="form-control bg-white" name="command" placeholder="Command...">
              <span class="input-group-btn">
                  <button class="btn btn-default-sm" type="submit">
                      <i class="fa fa-search"></i>
                  </button>
              </span>
          </div>
          {!! Form::close() !!}
       
       <div class="row"><textarea name="results" cols="150" rows="50" disabled>{{ $results }}</textarea> </div>
     </div>
  </div>
</div>
@endsection