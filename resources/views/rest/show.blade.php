@extends('layouts.dash')
@inject('getProfile','App\Http\Controllers\ProfilesCont')
@inject('allComments','App\Http\Controllers\CommentsCont')
@inject('Views', 'App\Http\Controllers\ViewsCont')
@inject('encode', 'App\Http\Controllers\AdminsCont')
@inject('likes', 'App\Http\Controllers\LikesCont')
@inject('userList', 'App\UsersByUser')
@inject('User', 'App\User')


@section('meta')
<meta name="title" content="{{ $tables->table }}">
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
    {!! Form::open(array('route' => 'rest.addFields', 'method'=>'post' ,'files'=>'true', 'class'=>'form-group col-md-12')) !!}
      {!! Form::hidden('tableIs', $tables->table) !!}
    <div class="col-md-12 bg-white">
     <center> <h2 class="well">{{ $tables->table }}</h2> </center>
          <div hidden>
            {{ Form::number('uid', Auth::user()->id) }}
          </div>
       <div class="row col-md-12">
          <div class="col-md-8 pull-left">
          {{ Form::submit('Save', ['class' => 'btn btn-success']) }}
            <a href="{{ route('admin-rest.index') }}" class="btn btn-danger ">Back</a>
            </div>
         <div class="col-md-4 pull-right">
           <fieldset id="buildYourFields" class="">
                <legend></legend>
            </fieldset>
            <input type="button" value="Add more fields" class="add btn btn-success" id="add" />
          </div>
        </div>
        <div class="col-md-12">
          {{ Form::label('users', 'Users')}}
            @php 
            $usList=['none'];
              foreach($userList->all() as $key):
                  $usList[$key->id] = $key->firstname . ' ' . $key->lastname;
              endforeach;
            @endphp

          {{ Form::label('users', 'Users')}}
          {{ Form::select('users', $usList, $allowedUsers,array('multiple'=>'multiple','name'=>'users[]', 'class'=>'form-control select2'))}}
            </div>
          
        {!! Form::close() !!}
       
       <div class="well col-md-12" style="margin: 20px;">
        Users have access to this table:

         @foreach($allowedUsers as $key => $value)
          <b>{{ $usList[$value] }}, </b>
         @endforeach
       </div>

    </div>
 

    </div>
    <!-- show table details -->
        <div class="col-md-12 bg-white">
          <table class="table table-bordered">
            <thead>
                <tr>
                   @for($i = 0; $i < sizeof($columns); $i++)
                    @if($columns[$i] !== 'created_at' AND $columns[$i] !== 'updated_at')
                     <th>{{ ucfirst(str_replace('_', ' ',$columns[$i]) )}}</th>
                     @else
                      <td>{{ $columns[$i] }}</td>
                     </td>
                     @endif
                   @endfor
                   <th></th>
                </tr>
                <tr>
                  {!! Form::open(array('route' => 'rest.insert', 'method'=>'post' ,'files'=>'true', 'class'=>'form-group col-md-12')) !!}
                  {!! Form::hidden('tableIs', $tables->table) !!}
                   @for($i = 0; $i < sizeof($columns); $i++)
                   @if($columns[$i] !== 'id' AND $columns[$i] !== 'created_at' AND $columns[$i] !== 'updated_at')
                     <td>{{ Form::text($columns[$i], NULL, ['class'=>'form-control'])}}
                    @else
                      <td> Auto</td>
                     </td>
                     @endif
                   @endfor
                   <td>{{ Form::submit('Insert', ['class'=>'btn btn-success'])}}</td>
                  {!! Form::close() !!}
                </tr>
              </thead>
                <tbody>
              @foreach($table as $key)
                   <tr>
                  @for($i = 0; $i < sizeof($columns); $i++)
                    
                     @php $n = $columns[$i] @endphp
                      <td>{{ $key->$n }}
                     </td>                   
                   @endfor
                   <td> {!! Form::open(array('route' => 'rest.delRow', 'method'=>'post' ,'files'=>'true', 'class'=>'form-group col-md-12')) !!}{!! Form::hidden('tableIs', $tables->table) !!}{!! Form::hidden('id', $key->id) !!}{{ Form::submit('X', ['class' => 'btn btn-danger']) }}{{ Form::close() }}</td>
                   </tr>
              @endforeach
            </tbody>
          </table>
        </div> 
  
       <!-- show table rest examples and details -->
        <div class="col-md-12 bg-white">
            <center><a id="clicktoshow" class="btn" show="restapiinfo" aria-expanded="false">More Info about the Api Calls</a></center>
          <table class="table table-bordered" id="restapiinfo" style="display: none;">
              <thead>
                <tr>
                  <th>
                    METHOD
                  </th>
                  <th>
                    CODES
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                <td>
                  <b>GET</b>
                </td>
                  <td>
                    <table class="table table-bordered">
                      <!-- HTTP CALLS  -->
                      <tr>
                        <td colspan="2">Extra GET:
                          <br> to get a specific ID from this table just add to the URL <code> .../ID </code>
                          <br>Example:
                          <code>
                           <br> GET /api/ddk/{{ $tables->table }}/<b>ID</b> HTTP/1.1
                           <br> ...
                          </code>  <br>
                        </td>
                      </tr>
                      <tr>
                        <th>
                          HTTP CODE
                        </th>
                        <td>
                          <code>
                         <br> GET /api/ddk/{{ $tables->table }} HTTP/1.1
                         <br> Host: {{ $_SERVER['HTTP_HOST'] }}
                         <br> Accept: application/json
                         <br> Content-Type: application/json
                         <br> Authorization: Bearer <b>USER_REST_API_TOKEN</b>
                         <br> Cache-Control: no-cache
                          </code>  
                        </td>
                      </tr>
                       <!-- CURL CALLS  -->
                      <tr>
                        <th>
                          cURL CODE
                        </th>
                        <td>
                          <code>
                         <br> curl -X GET \
                         <br>  '{{ (isset($_SERVER["HTTPS"]) ? 'https' : 'http') }}://{{ $_SERVER['HTTP_HOST'] }}/api/ddk/{{ $tables->table }}' \
                         <br>  -H 'Accept: application/json' \
                         <br>  -H 'Authorization: Bearer <b>USER_REST_API_TOKEN</b>' \
                         <br>  -H 'Cache-Control: no-cache' \
                         <br>  -H 'Content-Type: application/json'
                       </code>
                        </td>
                      </tr>
                        <!-- PHP CALLS  -->
                      <tr>
                        <th>
                          PHP CODE
                        </th>
                        <td>
                          <code>
                           <br> $request = new HttpRequest();
                           <br> $request->setUrl('{{ (isset($_SERVER["HTTPS"]) ? 'https' : 'http') }}://{{ $_SERVER['HTTP_HOST'] }}/api/ddk/{{ $tables->table }}');
                           <br> $request->setMethod(HTTP_METH_GET);

                           <br> $request->setHeaders(array(
                           <br>   'Cache-Control' => 'no-cache',
                           <br>   'Authorization' => 'Bearer <b>USER_REST_API_TOKEN</b>',
                           <br>   'Content-Type' => 'application/json',
                           <br>   'Accept' => 'application/json'
                           <br> ));
                           <br>
                           <br> try {
                           <br>   $response = $request->send();
                           <br>
                           <br>   echo $response->getBody();
                           <br> } catch (HttpException $ex) {
                           <br>   echo $ex;
                           <br> }
                       </code>
                        </td>
                      </tr>
                      <!-- PHP cURL  -->
                      <tr>
                        <th>
                          PHP cURL
                        </th>
                        <td>
                          <code>
                           <br>$curl = curl_init();
                           <br>
                           <br> curl_setopt_array($curl, array(
                           <br>   CURLOPT_URL => "{{ (isset($_SERVER["HTTPS"]) ? 'https' : 'http') }}://{{ $_SERVER['HTTP_HOST'] }}/api/ddk/{{ $tables->table }}",
                           <br>   CURLOPT_RETURNTRANSFER => true,
                           <br>   CURLOPT_ENCODING => "",
                           <br>   CURLOPT_MAXREDIRS => 10,
                           <br>   CURLOPT_TIMEOUT => 30,
                           <br>   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                           <br>   CURLOPT_CUSTOMREQUEST => "GET",
                           <br>   CURLOPT_HTTPHEADER => array(
                           <br>     "Accept: application/json",
                           <br>     "Authorization: Bearer <b>USER_REST_API_TOKEN</b>",
                           <br>     "Cache-Control: no-cache",
                           <br>     "Content-Type: application/json"
                           <br>   ),
                           <br> ));
                           <br>
                           <br> $response = curl_exec($curl);
                           <br> $err = curl_error($curl);
                           <br>
                           <br> curl_close($curl);
                           <br>
                           <br> if ($err) {
                           <br>   echo "cURL Error #:" . $err;
                           <br> } else {
                           <br>   echo $response;
                           <br> }
                       </code>
                        </td>
                      </tr>
                    </table>
                     
                  </td>
                </tr>
                <!--  Post  -->
                <tr>
                <td>
                  <b>POST</b>
                </td>
                  <td>
                    <table class="table table-bordered">
                      <!-- HTTP CALLS  -->
                      <tr>
                        <td colspan="2">Extra POST:
                          <br> to get all fields for a specific table use this parameter <code> fields=1 </code>
                        </td>
                      </tr>
                      <tr>
                        <th>
                          HTTP CODE
                        </th>
                        <td>
                          <code>
                         <br> POST /api/ddk/{{ $tables->table }}?<b>PARAMETERS_OR_FIELDS</b>=VALUE HTTP/1.1
                         <br> Host: {{ $_SERVER['HTTP_HOST'] }}
                         <br> Accept: application/json
                         <br> Content-Type: application/json
                         <br> Authorization: Bearer <b>USER_REST_API_TOKEN</b>
                         <br> Cache-Control: no-cache
                          </code>  
                        </td>
                      </tr>
                       <!-- CURL CALLS  -->
                      <tr>
                        <th>
                          cURL CODE
                        </th>
                        <td>
                          <code>
                         <br> curl -X POST \
                         <br>  '{{ (isset($_SERVER["HTTPS"]) ? 'https' : 'http') }}://{{ $_SERVER['HTTP_HOST'] }}/api/ddk/{{ $tables->table }}?<b>PARAMETERS_OR_FIELDS</b>=VALUE' \
                         <br>  -H 'Accept: application/json' \
                         <br>  -H 'Authorization: Bearer <b>USER_REST_API_TOKEN</b>' \
                         <br>  -H 'Cache-Control: no-cache' \
                         <br>  -H 'Content-Type: application/json'
                       </code>
                        </td>
                      </tr>
                        <!-- PHP CALLS  -->
                      <tr>
                        <th>
                          PHP CODE
                        </th>
                        <td>
                          <code>
                           <br> $request = new HttpRequest();
                           <br> $request->setUrl('{{ (isset($_SERVER["HTTPS"]) ? 'https' : 'http') }}://{{ $_SERVER['HTTP_HOST'] }}/api/ddk/{{ $tables->table }}');
                           <br> $request->setMethod(HTTP_METH_POST);
                           <br>
                           <br>  $request->setQueryData(array(
                           <br>       <b>PARAMETERS_OR_FIELDS</b> => VALUE
                           <br>     ));
                          <br>
                           <br>     $request->setHeaders(array(
                             <br>     'Cache-Control' => 'no-cache',
                            <br>      'Authorization' => 'Bearer <b>USER_REST_API_TOKEN</b>',
                            <br>      'Content-Type' => 'application/json',
                            <br>      'Accept' => 'application/json'
                            <br>    ));
                            <br>
                            <br>    try {
                             <br>     $response = $request->send();
                             <br>
                             <br>     echo $response->getBody();
                             <br>   } catch (HttpException $ex) {
                              <br>    echo $ex;
                              <br>  }
                       </code>
                        </td>
                      </tr>
                      <!-- PHP cURL  -->
                      <tr>
                        <th>
                          PHP cURL
                        </th>
                        <td>
                          <code>
                           <br>$curl = curl_init();
                           <br>
                           <br> curl_setopt_array($curl, array(
                           <br>   CURLOPT_URL => "{{ (isset($_SERVER["HTTPS"]) ? 'https' : 'http') }}://{{ $_SERVER['HTTP_HOST'] }}/api/ddk/{{ $tables->table }}",
                           <br>   CURLOPT_RETURNTRANSFER => true,
                           <br>   CURLOPT_ENCODING => "",
                           <br>   CURLOPT_MAXREDIRS => 10,
                           <br>   CURLOPT_TIMEOUT => 30,
                           <br>   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                           <br>   CURLOPT_CUSTOMREQUEST => "POST",
                           <br>   CURLOPT_HTTPHEADER => array(
                           <br>     "Accept: application/json",
                           <br>     "Authorization: Bearer <b>USER_REST_API_TOKEN</b>",
                           <br>     "Cache-Control: no-cache",
                           <br>     "Content-Type: application/json"
                           <br>   ),
                           <br> ));
                           <br>
                           <br> $response = curl_exec($curl);
                           <br> $err = curl_error($curl);
                           <br>
                           <br> curl_close($curl);
                           <br>
                           <br> if ($err) {
                           <br>   echo "cURL Error #:" . $err;
                           <br> } else {
                           <br>   echo $response;
                           <br> }
                       </code>
                        </td>
                      </tr>
                    </table>
                     
                  </td>
                </tr>
                <!--  UPDATE  -->
                <tr>
                <td>
                  <b>UPDATE</b>
                </td>
                  <td>
                    <table class="table table-bordered">
                      <!-- HTTP CALLS  -->
                      
                      <tr>
                        <th>
                          HTTP CODE
                        </th>
                        <td>
                          <code>
                         <br> PUT /api/ddk/{{ $tables->table }}/<b>ID</b>?<b>PARAMETERS_OR_FIELDS</b>=VALUE HTTP/1.1
                         <br> Host: {{ $_SERVER['HTTP_HOST'] }}
                         <br> Accept: application/json
                         <br> Content-Type: application/json
                         <br> Authorization: Bearer <b>USER_REST_API_TOKEN</b>
                         <br> Cache-Control: no-cache
                          </code>  
                        </td>
                      </tr>
                       <!-- CURL CALLS  -->
                      <tr>
                        <th>
                          cURL CODE
                        </th>
                        <td>
                          <code>
                         <br> curl -X PUT \
                         <br>  '{{ (isset($_SERVER["HTTPS"]) ? 'https' : 'http') }}://{{ $_SERVER['HTTP_HOST'] }}/api/ddk/{{ $tables->table }}/<b>ID</b>?<b>PARAMETERS_OR_FIELDS</b>=VALUE' \
                         <br>  -H 'Accept: application/json' \
                         <br>  -H 'Authorization: Bearer <b>USER_REST_API_TOKEN</b>' \
                         <br>  -H 'Cache-Control: no-cache' \
                         <br>  -H 'Content-Type: application/json'
                       </code>
                        </td>
                      </tr>
                        <!-- PHP CALLS  -->
                      <tr>
                        <th>
                          PHP CODE
                        </th>
                        <td>
                          <code>
                           <br> $request = new HttpRequest();
                           <br> $request->setUrl('{{ (isset($_SERVER["HTTPS"]) ? 'https' : 'http') }}://{{ $_SERVER['HTTP_HOST'] }}/api/ddk/{{ $tables->table }}/<b>ID</b>');
                           <br> $request->setMethod(HTTP_METH_PUT);
                           <br>
                           <br>  $request->setQueryData(array(
                           <br>       <b>PARAMETERS_OR_FIELDS</b> => VALUE
                           <br>     ));
                          <br>
                           <br>     $request->setHeaders(array(
                             <br>     'Cache-Control' => 'no-cache',
                            <br>      'Authorization' => 'Bearer <b>USER_REST_API_TOKEN</b>',
                            <br>      'Content-Type' => 'application/json',
                            <br>      'Accept' => 'application/json'
                            <br>    ));
                            <br>
                            <br>    try {
                             <br>     $response = $request->send();
                             <br>
                             <br>     echo $response->getBody();
                             <br>   } catch (HttpException $ex) {
                              <br>    echo $ex;
                              <br>  }
                       </code>
                        </td>
                      </tr>
                      <!-- PHP cURL  -->
                      <tr>
                        <th>
                          PHP cURL
                        </th>
                        <td>
                          <code>
                           <br>$curl = curl_init();
                           <br>
                           <br> curl_setopt_array($curl, array(
                           <br>   CURLOPT_URL => "{{ (isset($_SERVER["HTTPS"]) ? 'https' : 'http') }}://{{ $_SERVER['HTTP_HOST'] }}/api/ddk/{{ $tables->table }}/<b>ID</b>?<b>PARAMETERS_OR_FIELDS</b>=VALUE",
                           <br>   CURLOPT_RETURNTRANSFER => true,
                           <br>   CURLOPT_ENCODING => "",
                           <br>   CURLOPT_MAXREDIRS => 10,
                           <br>   CURLOPT_TIMEOUT => 30,
                           <br>   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                           <br>   CURLOPT_CUSTOMREQUEST => "PUT",
                           <br>   CURLOPT_HTTPHEADER => array(
                           <br>     "Accept: application/json",
                           <br>     "Authorization: Bearer <b>USER_REST_API_TOKEN</b>",
                           <br>     "Cache-Control: no-cache",
                           <br>     "Content-Type: application/json"
                           <br>   ),
                           <br> ));
                           <br>
                           <br> $response = curl_exec($curl);
                           <br> $err = curl_error($curl);
                           <br>
                           <br> curl_close($curl);
                           <br>
                           <br> if ($err) {
                           <br>   echo "cURL Error #:" . $err;
                           <br> } else {
                           <br>   echo $response;
                           <br> }
                       </code>
                        </td>
                      </tr>
                    </table>
                     
                  </td>
                </tr>
                 <!--  DELETE  -->
                <tr>
                <td>
                  <b>DELETE</b>
                </td>
                  <td>
                    <table class="table table-bordered">
                      <!-- HTTP CALLS  -->
                      
                      <tr>
                        <th>
                          HTTP CODE
                        </th>
                        <td>
                          <code>
                         <br> DELETE /api/ddk/{{ $tables->table }}/<b>ID</b> HTTP/1.1
                         <br> Host: {{ $_SERVER['HTTP_HOST'] }}
                         <br> Accept: application/json
                         <br> Content-Type: application/json
                         <br> Authorization: Bearer <b>USER_REST_API_TOKEN</b>
                         <br> Cache-Control: no-cache
                          </code>  
                        </td>
                      </tr>
                       <!-- CURL CALLS  -->
                      <tr>
                        <th>
                          cURL CODE
                        </th>
                        <td>
                          <code>
                         <br> curl -X DELETE \
                         <br>  '{{ (isset($_SERVER["HTTPS"]) ? 'https' : 'http') }}://{{ $_SERVER['HTTP_HOST'] }}/api/ddk/{{ $tables->table }}/<b>ID</b>' \
                         <br>  -H 'Accept: application/json' \
                         <br>  -H 'Authorization: Bearer <b>USER_REST_API_TOKEN</b>' \
                         <br>  -H 'Cache-Control: no-cache' \
                         <br>  -H 'Content-Type: application/json'
                       </code>
                        </td>
                      </tr>
                        <!-- PHP CALLS  -->
                      <tr>
                        <th>
                          PHP CODE
                        </th>
                        <td>
                          <code>
                           <br> $request = new HttpRequest();
                           <br> $request->setUrl('{{ (isset($_SERVER["HTTPS"]) ? 'https' : 'http') }}://{{ $_SERVER['HTTP_HOST'] }}/api/ddk/{{ $tables->table }}/<b>ID</b>');
                           <br> $request->setMethod(HTTP_METH_DELETE);
                           <br>
                          <br>
                           <br>     $request->setHeaders(array(
                             <br>     'Cache-Control' => 'no-cache',
                            <br>      'Authorization' => 'Bearer <b>USER_REST_API_TOKEN</b>',
                            <br>      'Content-Type' => 'application/json',
                            <br>      'Accept' => 'application/json'
                            <br>    ));
                            <br>
                            <br>    try {
                             <br>     $response = $request->send();
                             <br>
                             <br>     echo $response->getBody();
                             <br>   } catch (HttpException $ex) {
                              <br>    echo $ex;
                              <br>  }
                       </code>
                        </td>
                      </tr>
                      <!-- PHP cURL  -->
                      <tr>
                        <th>
                          PHP cURL
                        </th>
                        <td>
                          <code>
                           <br>$curl = curl_init();
                           <br>
                           <br> curl_setopt_array($curl, array(
                           <br>   CURLOPT_URL => "{{ (isset($_SERVER["HTTPS"]) ? 'https' : 'http') }}://{{ $_SERVER['HTTP_HOST'] }}/api/ddk/{{ $tables->table }}/<b>ID</b>",
                           <br>   CURLOPT_RETURNTRANSFER => true,
                           <br>   CURLOPT_ENCODING => "",
                           <br>   CURLOPT_MAXREDIRS => 10,
                           <br>   CURLOPT_TIMEOUT => 30,
                           <br>   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                           <br>   CURLOPT_CUSTOMREQUEST => "DELETE",
                           <br>   CURLOPT_HTTPHEADER => array(
                           <br>     "Accept: application/json",
                           <br>     "Authorization: Bearer <b>USER_REST_API_TOKEN</b>",
                           <br>     "Cache-Control: no-cache",
                           <br>     "Content-Type: application/json"
                           <br>   ),
                           <br> ));
                           <br>
                           <br> $response = curl_exec($curl);
                           <br> $err = curl_error($curl);
                           <br>
                           <br> curl_close($curl);
                           <br>
                           <br> if ($err) {
                           <br>   echo "cURL Error #:" . $err;
                           <br> } else {
                           <br>   echo $response;
                           <br> }
                       </code>
                        </td>
                      </tr>
                    </table>
                     
                  </td>
                </tr>
              </tbody>
          </table>
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
        var removeButton = $("<br><input type=\"button\" class=\"remove\" value=\"Remove\" />");
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
@stop