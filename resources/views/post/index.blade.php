@extends('layouts.dash')
@inject('getProfile','App\Http\Controllers\ProfilesCont')
@inject('encode', 'App\Http\Controllers\AdminsCont')
@inject('user', 'Illuminate\Foundation\Auth\User')

@section('meta')
<meta name="title" content=" posts">

@stop

@section('leftSideBar')

@stop

@section('content')
<div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                  <div class="well message">
                      @include('partials._messages')
                  </div>
         @foreach($posts as $post)
         <div class="row">
                  <div class="col-md-6">
                    <div class="card card-tasks">
                      <div class="card-header row">
                        <img id="reshare-image" class=" img-thumbnail" alt="{{ $user->find($post->uid)->firstname }} {{ $user->find($post->uid)->lastname }}" width="100%" height="150" src="/{{ $post->image }}" style="height: 100px !important;">
                        <h4 class="card-title" style="margin-top: -50px;background: rgba(250, 250, 250, 0.5);padding: 10px;">{{ $post->title }}</h4>
                        <span style="position: absolute; background:rgba(250, 250, 250, 0.8);right:0;top: 70px;" >
                         @if( Auth::user()->id == $post->uid)
                                    <div class="navbar-right">
                                          <div class="dropdown">
                                              <button class="btn btn-link btn-xs dropdown-toggle" type="button" id="dd1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                  <i class="fa fa-cog" aria-hidden="true"></i>
                                              </button>
                                              <ul class="dropdown-menu" aria-labelledby="dd1" style="float: right;">
                                                  <li>
                                                      {!! Form::open(['route'=>['post.edit', $post->id], 'method'=> 'get']) !!}
                                                      {!! Form::submit('Edit', ["class"=> 'btn-success btn btn-block']) !!}
                                                      {!! Form::close(); !!}
                                                  </li>
                                                  <li>
                                                      {!! Form::open(['route'=>['post.destroy', $post->id], 'method'=> 'DELETE']) !!}
                                                      {!! Form::submit('Delete', ["class"=> 'btn-danger btn btn-block']) !!}
                                                      {!! Form::close(); !!}
                                                  </li>
                                              </ul>

                                          </div>
                                      </div>
                                @endif</span>
                      </div>
                      <div class="card-body">
                        <div class="table-full-width table-responsive">
                          <table class="table">
                            <tr>
                              <td>
                                 <div class="pull-left">
                                      <a href="/profile/{{ $getProfile->getProfInfo($post->uid)->id  }}">
                                          <img class="media-object img-circle" src="/{{ $getProfile->getProfInfo($post->uid)->picture }}" width="50px" height="50px" style="margin-right:8px; margin-top:-5px;">
                                      </a>
                                  </div>
                                 <a href="/profile/{{ $getProfile->getProfInfo($post->uid)->id }}" style="text-decoration:none;"><strong>{{ $user->find($post->uid)->firstname  }} {{ $user->find($post->uid)->lastname  }}</strong></a> – <small><small><a style="text-decoration:none; color:grey;"><i><i class="fa fa-clock-o" aria-hidden="true"></i> {{ date('M j,Y', strtotime($post->created_at)) }}</i></a></small></small>
                              </td>
                              <td colspan="3">
                                  <div class="pull-left col-md-12">
                                    <a href="/post/{{ $post->id }}">{{ $encode->encoded($post->body, 0, 300, 'yes') }}</a>
                                  </div>
                              </td>
                             
                            </tr>
                    <td colspan="4">
                    <div class="row" style="margin: 10px;">
                      <div class="col-md-2 ">
                              <a href="/{{ $getProfile->getProfInfo( Auth::user()->id )->picture  }}">
                                <img class="media-object img-circle" src="/{{ $getProfile->getProfInfo( Auth::user()->id )->picture  }}" width="35px" height="35px" style="margin-left:3px; margin-right:-5px;">
                            </a>
                        </div> 
                     
                      <div class="col-md-10 pull-left">
                      {!! Form::open(['route' => 'comment.store']) !!}
                    
                       {{ Form::textarea('body', null, array('class' => 'Form-control text col-md-10 d-flex align-items-center', 'required' => '', 'rows' => 1)) }}
                         <div hidden>  
                          {{ Form::text('title', $post->uid) }}
                          {{ Form::text('nid', $post->id) }}
                          {{ Form::text('uid', Auth::user()->id) }}
                          {{ Form::text('type', 'post') }}
                        </div>
                      </div>
                      </div>
                      <div class="Form-control text col-md-12 d-flex align-items-center">
                      {!! Form::submit('Comment', ['class'=>'btn btn-default btn-block btn-xs']); !!}
                    </div>
                  {!! Form::close() !!}
                  <br>
           @endforeach
                            </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      
                  </div>
                  </div>
                  
                </div>

@stop