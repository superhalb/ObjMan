@extends('layout')
@section('content')
  <div class="detail">

  <form id="createForm"  method="put" action="javascript:updateObject()">
  {!! csrf_field() !!}
    <label>Name</label>
    <input type="text" name="name" id="name" value="{{ $object->name }}"><br>
    <label>Description</label>
    <input type="text" name="description" id="description" value="{{ $object->description }}"><br>
    <label>Type</label>
    <input type="text" name="type" id="type" value="{{ $object->type }}"><br>
    <input type="hidden" name="id" id="id" value="{{ $object->id }}">
    <div class="title">Relations</div>
    <div>
      <ul class="relations">
        @foreach ($object->relations as $relation)
          <li>{{ $relation['name'] }}<button class="removeRelation" data-id="{{ $relation['id'] }}">Remove</button></li>
        @endforeach
      </ul>
    </div>
    <input type="submit" value="Save" />
  </form>
  </div>

  <div class="title">Add relations</div>
  @component('search')
  @endcomponent

  <button class="removeObject">Remove this Object</button>
  <a href="{{ url('/') }}">Back to search</a>

  <script type="application/javascript">

    function updateObject(){
        $.ajax({
            type: "PUT",
            url: "{{ action('ObjectController@update' , $object->id ) }}",
            data: $('#createForm').serialize(),
            success: function( id ) {
		window.location.href = "{{ action('ObjectController@edit' , $object->id ) }}/";
            }
        });
    }

    function removeObject(){
        $.ajax({
            type: "DELETE",
            url: "{{ action('ObjectController@destroy' , $object->id ) }}",
            data: $('#createForm').serialize(),
            success: function( id ) {
		window.location.href=("{{ url('/') }}");
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
