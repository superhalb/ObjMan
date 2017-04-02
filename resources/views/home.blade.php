@extends('layout')
@section('content')
  @component('search')
  @endcomponent
  <div class="title">
    Object details
  </div>
  <div class="detail">
  </div>
  <a href="{{ action('ObjectController@create') }}">Create new object</a>
  <script type="application/javascript">

    var getDetails = function(){
        var id = $(this).attr('data-id');
        $.get("objects/" + id , function( detail ) {
          $('.detail').html('');
          if ( detail.length == 0 ) return;
          var detailDiv = $('<div class="detailItem"></div>');
          var detailName = $('<div class="detailName"></div>');
          var detailDescription = $('<div class="detailDescription"></div>');
          var detailType = $('<div class="detailType"></div>');
          var detailRelationsTitle = $('<div class="title">Relations</div>');
          var detailRelations = $('<div class="detailRelations"></div>');
	  var detailEdit = $('<button>Edit</button>');
          detailDiv.append( detailName )
                   .append( detailDescription )
                   .append( detailType )
                   .append( detailRelationsTitle )
                   .append( detailRelations )
                   .append( detailEdit );
          detailName.text( detail.name );
          detailDescription.text( detail.description );
          detailType.text( detail.type );
          detailEdit.click( function(){
              window.location.replace("{{ action('ObjectController@store') }}/" + id +"/edit");
          });
          for( var j = 0 ; j < detail.relations.length ; ++j ){
              var relationDiv = $('<div class="relation"></div>');
              relationDiv.text( detail.relations[ j ].name );
              relationDiv.attr('data-id' , detail.relations[ j ].id);
              detailRelations.append(relationDiv);
          }
          $('.detail').append( detailDiv );
        }
      );
    };
 
    $( document ).ready(function() {
      ObjMan.search.setClickResultCallback( getDetails );
    });
</script>
@endsection
