@extends('layout')
@section('content')
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Object Management</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="{{ url('/') }}">Browse objects database</a></li>
      <li class="active"><a href="#">Create new object</a></li>
    </ul>
  </div>
</nav>

<div class="panel panel-default panel-primary">
  <div class="panel-heading text-uppercase">Create new object</div>
  <div class="panel-body">
    <form id="createForm"  method="put" action="javascript:createObject()">
      {!! csrf_field() !!}
      <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" id="name" class="form-control">
      </div>
      <div class="form-group">
        <label>Description</label>
        <input type="text" name="description" id="description" class="form-control">
      </div>
      <div class="form-group">
        <label>Type</label>
        <input type="text" name="type" id="type" class="form-control">
      </div>
      <div class="form-group">
        <input type="submit" value="Create"  class="btn btn-primary pull-right">
      </div>

    </form>
  </div>
</div>
  <script type="application/javascript">

    function createObject(){
        $.ajax({
            type: "POST",
            url: "{{ action('ObjectController@store') }}",
            data: $('#createForm').serialize(),
            success: function( id ) {
		window.location.replace("{{ action('ObjectController@store') }}/" + id +"/edit");
            }
        });
    }

    $( document ).ready(function() {
    });
  </script>
@endsection
