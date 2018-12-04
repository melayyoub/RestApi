@extends('layouts.dash')
@inject('getProfile','App\Http\Controllers\ProfilesCont')
@inject('encode', 'App\Http\Controllers\AdminsCont')


@section('meta')
<meta name="title" content="{{ $user->firstname  }} {{ $user->lastname  }}">
<meta name="description" content="{{ $user->firstname  }} {{ $user->lastname  }} profile page">
  <meta name="keywords" content="{{ $user->firstname  }}, {{ $user->lastname  }}">
  <meta name="author" content="{{ $user->firstname  }} {{ $user->lastname  }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- <i class="fa fa-check text-success" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="{{ $user->firstname  }} {{ $user->lastname  }} is sharing with you"></i> -->
@stop
@section('content')
	<div class="panel-header panel-header-sm">
            </div>
            <div class="content">
            	{!! Form::open(['route' => ['profile.update', $profile->id], 'id'=>'profileform', 'method' => 'put','files'=>'true']) !!}
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="title">Edit Profile</h5>
                            </div>
                            <div class="card-body">
                                
                                    <div class="row">
                                        <div class="col-md-12 px-1">
                                            <div class="form-group">
                                                {{ Form::label('email', 'Username:', ["class" => 'col-md-12 ']) }}{{ Form::text('email', $getProfile->getUserInfo($profile->uid)->email, ["class" => 'form-control', 'disabled'=>1]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 px-1">
                                            <div class="form-group">
                                                {{ Form::label('api_token', 'Api Token', ["class" => 'col-md-12 ']) }}{{ Form::text('email', $getProfile->getUserInfo($profile->uid)->api_token, ["class" => 'form-control', 'disabled'=>1]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 pr-1">
                                            <div class="form-group">
                                                 {{ Form::label('firstname', 'Firstname:', ["class" => 'col-md-12 ']) }}{{ Form::text('firstname', $getProfile->getUserInfo($profile->uid)->firstname, ["class" => 'form-control', 'required' => 'true']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 pl-1">
                                            <div class="form-group">
                                                {{ Form::label('lastname', 'Lastname:', ["class" => 'col-md-12 ']) }}{{ Form::text('lastname', $getProfile->getUserInfo($profile->uid)->lastname, ["class" => 'form-control', 'required' => 'true']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {{ Form::label('job_title', 'Job Title:', ["class" => 'col-md-12 ']) }}{{ Form::text('job_title', $getProfile->getUserInfo($profile->uid)->job_title, ["class" => 'form-control']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 pr-1">
                                            <div class="form-group">
                                                {{ Form::label('industry', 'Industry:', ["class" => 'col-md-12 ']) }}{{ Form::text('industry', $getProfile->getUserInfo($profile->uid)->industry, ["class" => 'form-control']) }}
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {{ Form::label('body', 'About Me:', ["class" => 'col-md-12 ']) }}{{ Form::textarea('description', $profile->description, ["class" => 'form-control', 'required' => 'true']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="row">
									          
									          <div class="col-lg-12">
                                               {{ Form::label('new_password', 'New Password:', ["class" => 'col-md-12 ']) }}{{ Form::text('new_password', null, ["class" => 'form-control col-md-12 block']) }}
                                              </div>
									        </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-user">
                            <div class="image">
                            	
                               

                            </div>
                            <div class="card-body">
                            	<script type="text/javascript">
										  function readURL(input) {
										        if (input.files && input.files[0]) {
										            var reader = new FileReader();

										            reader.onload = function (e) {
										                $('#profile-loaded-image')
										                    .attr('src', e.target.result)
										            };

										            reader.readAsDataURL(input.files[0]);
										        }
										    }
										</script>
                                <div class="author">
                                        <img class="avatar border-gray" id="profile-loaded-image" src="/{{ $profile->picture }}" alt="...">
                                        <h5 class="title">{{ $user->firstname }} {{ $user->lastname }}</h5>
                                    {{ Form::file('image', ['id' => 'profile-image', 'onchange' => 'readURL(this);' , 'class'=>'btn btn-default btn-file']) }}
							        
							        {{ Form::number('uid', Auth::user()->id, ["class" => 'form-control', "hidden"=>1]) }}
                                    <p class="description">
                                        {{ $user->firstname }} {{ $user->lastname }}
                                    </p>
                                </div>
                                <p class="description text-center">
                                    {{$profile->description}}
                                </p>
                            </div>
                                 <div class="well message">
                                    @include('partials._messages')
                                </div>
                            <center>{{ Form::submit('Save', ['class'=>'btn btn-primary btn-block']) }}</center>
                            <hr>
                            <div class="button-container">
                               <!--  <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                                    <i class="fab fa-facebook-f"></i>
                                </button>
                                <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                                    <i class="fab fa-twitter"></i>
                                </button>
                                <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                                    <i class="fab fa-google-plus-g"></i>
                                </button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
{!! Form::close() !!}


@endsection