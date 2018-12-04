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
                                <h5 class="card-category">Rest Tables</h5>
                                <h4 class="card-title">Count: {{ $tables->count() }}</h4>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-round btn-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
                                        <i class="now-ui-icons loader_gear"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ route('admin-rest.create') }}">Create a Table</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderded">
                                  <thead>
                                    <tr>
                                      <th>
                                        Name
                                      </th>
                                      <th>
                                        Description
                                      </th>
                                      <th>
                                        Date
                                      </th>
                                    </tr>
                                  </thead>

                                  <tbody>
                                  @if($tables->count() > 0)
                                    @foreach($tables->get() as $table)

                                      <tr>
                                          <td>
                                            {{ $table->table }}
                                          </td>
                                          <td>
                                            {{ $table->body }}
                                          </td>
                                          <td>
                                            {{ $table->created_at }}
                                          </td>
                                          <td>
                                            <a href="{{ route('admin-rest.show', $table->table) }}">View</a>
                                          </td>
                                          <td>
                                            {{ Form::open(['route' => ['admin-rest.destroy', $table->id], 'method'=>'delete']) }}
                                            {{ Form::submit('Delete', ['class'=>'btn btn-danger delete'])}}
                                            {{ Form::close() }}
                                          </td>
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
  jQuery(document).ready(function ($){
      $(".delete").on("click", function(){
          return confirm("Do you want to delete this item? there's no revert after this step.");
      });
    });
</script>
@endsection