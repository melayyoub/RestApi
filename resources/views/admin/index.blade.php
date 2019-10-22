@inject('getInfo', 'App\Http\Controllers\AdminsCont')
@inject('msgsBar', 'App\Http\Controllers\MsgsCont')
@inject('profile', 'App\Http\Controllers\ProfilesCont')
@inject('user', 'Illuminate\Foundation\Auth\User')

@if( ($getInfo->getAdmin(Auth::user()->id) == 1  AND $getInfo->getAdminLevel() == 0)  || Auth::user()->id == 1)
@extends('layouts.dash')

@section('title', 'Admin Panel')

@section('content')
<div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                  <div class="well message">
                      @include('partials._messages')
                  </div>
	    <!-- edit form column -->	      	
	    <div class="well bg-white col-lg-12 has-shadow align-items-center text-center">
	    	
			<h1>Site Extra</h1>
	    	<table class="table table-bordered col-lg-12">
	    		<tbody>
	    			<tr>
	    				<td>
	    					{{ $users }} Users
	    				</td>
	    				<td>
	    					{{ $tables }} Tables
	    				</td>
	    				<td>
	    					{{ $requests }} Requests
	    				</td>
	    			</tr><tr>
	    				<td colspan="2">
	    					Update All Posts Paths (bulk update)
	    				</td>
	    				<td>
	    					{{ Form::open(array('route' => 'admin.updatePath')) }}
		    				{{ Form::submit('Bulk Update', ['class'=>'form-control btn-success']) }}
		    				{{ Form::close() }}
	    				</td>
	    			</tr><tr>
	    				<td colspan="2">
	    					Homepage Featured Posts
	    				</td>
	    				<td>
	    					<a href="/admin-posts" class="form-control btn-success">Click here</a>
	    				</td>
	    			</tr><tr>
	    				<td colspan="2">
	    					Settings
	    				</td>
	    				<td>
	    					<a href="/admin/private/settings" class="form-control btn-success">Click here</a>
	    				</td>
	    			</tr>
	    		</tbody>
			</table>
			<br>
			    </div>
			</div>

@endsection

@endif

