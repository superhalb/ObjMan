@extends('layout')
@section('content')
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Object Management</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="{{ url('/') }}">Browse objects database</a></li>
      <li><a href="{{ action('ObjectController@create') }}">Create new object</a></li>
    </ul>
  </div>
</nav>

<div class="panel panel-default panel-primary">
  <div class="panel-heading text-uppercase">Edit object</div>
  <div class="panel-body">
    <form id="createForm"  method="put" action="javascript:updateObject()">
      {!! csrf_field() !!}
      <input type="hidden" name="id" id="id" value="{{ $object->id }}">
      <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" id="name" value="{{ $object->name }}" class="form-control">
      </div>
      <div class="form-group">
        <label>Description</label>
        <input type="text" name="description" id="description" value="{{ $object->description }}" class="form-control">
      </div>
      <div class="form-group">
        <label>Type</label>
        <input type="text" name="type" id="type" value="{{ $object->type }}" class="form-control">
      </div>
      <div class="form-group">
        <div class="panel panel-default panel-dafault">
        <div class="panel-heading text-uppercase">Relations</div>
        <div class="panel-body" id="detailRelations">
          <div class="alert alert-info">
            <p>Click on an arrow to remove its relation.</p>
            <p>When creating a new relation the relation will be from current object to the one selected</p>
          </div>
          <div class="row row-center">
            <div class="col-xs-3">
              @foreach ($object->relationsb as $relation)
                <a class="btn btn-primary btn-block disabled">{{ $relation['name'] }}</a>
              @endforeach
            </div>
            <div class="col-xs-1">
              @foreach ($object->relationsb as $relation)
                <button type="button" class="removeRelation btn btn-block" data-id="{{ $relation['id'] }}"><span class="glyphicon glyphicon-arrow-right"></span></button>
              @endforeach
            </div>
            <div class="col-xs-4">
              <a class="btn btn-primary btn-block disabled" >{{ $object->name }}</a>
            </div>
            <div class="col-xs-1">
              @foreach ($object->relations as $relation)
                <button type="button" class="removeRelation btn btn-block" data-id="{{ $relation['id'] }}"><span class="glyphicon glyphicon-arrow-right"></span></button>
              @endforeach
            </div>
            <div class="col-xs-3">
              @foreach ($object->relations as $relation)
                <a class="btn btn-primary btn-block disabled">{{ $relation['name'] }}</a>
              @endforeach
            </div>
          </div>
          <button type="button" class="btn btn-info pull-right separate" data-toggle="modal" data-target="#myModal">Add relation</button>
        </div>
      </div>
    </form>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add relation</h4>
      </div>
      <div class="modal-body">
        @component('search')
        @endcomponent
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



      <button class="removeObject btn btn-danger pull-right" style="margin-left: 10px">Remove</button>
      <input type="submit" value="Save" class="btn btn-success pull-right" />
    </div>
  </div>
</div>
<div class="alert alert-success hidden" id="savedAlert">
  <strong>Success!</strong> This object has been saved.
</div>
<div class="alert alert-danger hidden" id="removedAlert">
  <strong>Success!</strong> This object has been removed.
</div>
  <script type="application/javascript">

    function updateObject(){
        $.ajax({
            type: "PUT",
            url: "{{ action('ObjectController@update' , $object->id ) }}",
            data: $('#createForm').serialize(),
            success: function( id ) {
              $("#savedAlert").removeClass('hidden');
              $("#savedAlert").show();
              $("#savedAlert").delay(2000).fadeOut('slow' , function(){
                window.location.href=("{{ url('/') }}");
              });
            }
        });
    }

    function removeObject(){
        $.ajax({
            type: "DELETE",
            url: "{{ action('ObjectController@destroy' , $object->id ) }}",
            data: $('#createForm').serialize(),
            success: function( id ) {
                $("input").prop("disabled", true);
                $("#removedAlert").removeClass('hidden');
                $("#removedAlert").show();
                $("#removedAlert").delay(2000).fadeOut('slow', function(){
                  window.location.href=("{{ url('/') }}");
                });
            }
        });
    }

    var addRelation = function(){
        var id = $(this).attr('data-id');
        console.log(id);
        $.ajax({
            type: "PUT",
            url: "{{ action('ObjectController@link' , [ 'from' => $object->id , 'to' => ''] ) }}/" + id,
            data: $('#createForm').serialize(),
            success: function( result ) {
                location.reload( true );
            }
        });
    };

    var removeRelation = function(){
        var id = $(this).attr('data-id');
        $.ajax({
            type: "DELETE",
            url: "{{ action('ObjectController@unlink' , '' ) }}/" + id,
            data: $('#createForm').serialize(),
            success: function( result ) {
                location.reload( true );
            }
        });
    };

    $( document ).ready(function() {
      $(".removeRelation").click( removeRelation );
      $(".removeObject").click( removeObject );
      ObjMan.search.setClickResultCallback( addRelation );
    });
  </script>
@endsection
