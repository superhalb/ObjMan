@extends('layout')
@section('content')
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Object Management</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Browse objects database</a></li>
      <li><a href="{{ action('ObjectController@create') }}">Create new object</a></li>
    </ul>
  </div>
</nav>
<div class="row">
  <div class="col-sm-3">
    @component('search')
    @endcomponent
  </div>
  <div class="col-sm-9 hidden" id="detailPanel">
    <div class="panel panel-default panel-primary">
      <div class="panel-heading text-uppercase">View object details</div>
      <div class="panel-body">
        <div class="detail">
          <div class="form-group">
            <label>Name</label>
            <div id="detailName"></div>
          </div>
          <div class="form-group">
            <label>Description</label>
            <div id="detailDescription"></div>
          </div>
          <div class="form-group">
            <label>Type</label>
            <div id="detailType"></div>
          </div>
          <div class="form-group">
            <div class="panel panel-default">
            <div class="panel-heading text-uppercase">Relations</div>
            <div class="panel-body" id="detailRelations">
              <div class="row row-center">
                <div class="col-xs-3" id="fromRelations"></div>
                <div class="col-xs-1" id="fromArrows"></div>
                <div class="col-xs-4">
                  <a class="btn btn-primary btn-block disabled" id="relDetailName"></a>
                </div>
                <div class="col-xs-1" id="toArrows"></div>
                <div class="col-xs-3" id="toRelations"></div>
              </div>
            </div>
          </div>
          <a id="detailEdit" class="btn btn-info pull-right">Edit</a>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/template" id="detail-template">
</script>
  <script type="application/javascript">

    var getDetails = function(){
        var id = $(this).attr('data-id');
        $.get("objects/" + id , function( detail ) {
          $("#detailPanel").removeClass('hidden');
          $("#detailName").text( detail.name );
          $("#relDetailName").text( detail.name );
          $("#detailDescription").text( detail.description );
          $("#detailType").text( detail.type );
          var detailEdit = $('#detailEdit');
          detailEdit.click( function(){
              window.location.replace("{{ action('ObjectController@store') }}/" + id +"/edit");
          });
          var fromRelations = $('#fromRelations');
          var fromArrows = $('#fromArrows');
          var toArrows = $('#toArrows');
          var toRelations = $('#toRelations');
          fromRelations.html('');
          fromArrows.html('');
          toArrows.html('');
          toRelations.html('');
          for( var j = 0 ; j < detail.relationsb.length ; ++j ){
              var relationDiv = $('<button class="removeRelation btn btn-primary btn-block disabled"></button>');
              relationDiv.text( detail.relationsb[ j ].name );
              fromRelations.append(relationDiv);
              fromArrows.append($('<div><span class="glyphicon glyphicon-arrow-right"></span></div>'));
          }
          for( var j = 0 ; j < detail.relations.length ; ++j ){
              var relationDiv = $('<button class="removeRelation btn btn-primary btn-block disabled"></button>');
              relationDiv.text( detail.relations[ j ].name );
              toRelations.append(relationDiv);
              toArrows.append($('<div><span class="glyphicon glyphicon-arrow-right"></span></div>'));
          }
        }
      );
    };

    $( document ).ready(function() {
      ObjMan.search.setClickResultCallback( getDetails );
    });
</script>
@endsection
