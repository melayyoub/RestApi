@inject('getInfo', 'App\Http\Controllers\AdminsCont')
@inject('msgsBar', 'App\Http\Controllers\MsgsCont')
@inject('profile', 'App\Http\Controllers\ProfilesCont')
@inject('user', 'Illuminate\Foundation\Auth\User')

@if( ($getInfo->getAdmin(Auth::user()->id) == 1  AND $getInfo->getAdminLevel() == 0)  || Auth::user()->id == 1)

@extends('layouts.dash')

@section('content')
<div class="panel-header panel-header-sm">
    </div>
    <div class="content">
          <div class="well message">
              @include('partials._messages')
          </div>
    </div>

@endsection

@endif