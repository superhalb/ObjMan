@extends('layout')
@section('content')
  <div class="detail">

  <form id="createForm"  method="put" action="javascript:createObject()">
  {!! csrf_field() !!}
    <label>Name</label>
    <input type="text" name="name" id="name"><br>
    <label>Description</label>
    <input type="text" name="description" id="description"><br>
    <label>Type</label>
    <input type="text" name="type" id="type"><br>
    <input type="submit" value="Create" />
  </form>
  </div>

  <a href="{{ url('/') }}">Back to search</a>

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
