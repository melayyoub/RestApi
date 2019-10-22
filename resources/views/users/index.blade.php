@inject('userGet','App\User')

@extends('layouts.dash')

@section('content')
  <div class="panel-header panel-header-sm">
            </div>
            <div class="content">

                <div class="row col-md-12">
                  <div class="well message">
                      @include('partials._messages')
                  </div>
                  <div class="col-md-12">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h5 class="card-category">Rest Users List</h5>
                                <h4 class="card-title">Count: {{ $usersList->count() }}</h4>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-round btn-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
                                        <i class="now-ui-icons loader_gear"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ route('users.create') }}">Add a User</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderded" style="table-layout: fixed;">
                                  <thead>
                                    <tr>
                                      @for($i = 0; $i < sizeof($col); $i++)
                                        @if($col[$i] !== 'created_at' AND $col[$i] !== 'updated_at' AND $col[$i] !== 'uid' AND $col[$i] !== 'updated_at' AND $col[$i] !== 'blocked' AND $col[$i] !== 'ip' AND $col[$i] !== 'role' AND $col[$i] !== 'token' AND  $col[$i] !== 'api_id'  AND $col[$i] !== 'api_token'  AND $col[$i] !== 'remember_token' AND $col[$i] !== 'level'  AND $col[$i] !== 'level' AND $col[$i] !== 'password' AND $col[$i] !== 'profile')
                                         <th>{{ ucfirst(str_replace('_', ' ',$col[$i]) )}}</th>
                                         @elseif($col[$i] == 'api_token')
                                          <th>Rest Api Token</th>
                                         </td>
                                         @endif
                                       @endfor
                                    </tr>
                                  </thead>

                                  <tbody>
                                  @if($usersList->count() > 0)
                                    @foreach($usersList->get() as $key)
                                      <tr>
                                        @for($i = 0; $i < sizeof($col); $i++)
                                        @if($col[$i] !== 'created_at' AND $col[$i] !== 'updated_at' AND $col[$i] !== 'uid' AND $col[$i] !== 'updated_at' AND $col[$i] !== 'blocked' AND $col[$i] !== 'ip' AND $col[$i] !== 'role' AND $col[$i] !== 'token' AND  $col[$i] !== 'api_id'  AND $col[$i] !== 'api_token'  AND $col[$i] !== 'remember_token' AND $col[$i] !== 'level'  AND $col[$i] !== 'level' AND $col[$i] !== 'password' AND $col[$i] !== 'profile')
                                          @php $n = $col[$i]; @endphp
                                           <td> {{ $userGet::where('api_id',$key->api_id)->first()->$n }}</td>
                                           @elseif($col[$i] == 'api_token')
                                            @php $n = $col[$i]; $nid = $key->api_id; @endphp
                                          <td style="font-size:10px;flex-wrap: wrap;"><a id="clicktoshow" class="btn" show="<?php echo $n.''.$nid ?>">Show</a><br><span id="<?php echo $n.''.$nid ?>" style="display: none;width: 100%;">{{ $userGet::where('api_id',$key->api_id)->first()->$n }}</span></td>
                                         @endif
                                       @endfor
                                      </tr>
                                    @endforeach
                                  @endif
                                  </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
                                </div>
                            </div>
                        </div>
                    </div>
  </div>
</div>
<script>
    $(".delete").on("submit", function(){
        return confirm("Do you want to delete this item?");
    });
</script>
@endsection