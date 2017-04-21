<div class="panel panel-primary">
  <div class="panel-heading text-uppercase" id="searchTitle">Search objects</div>
  <div class="panel-body">
    <div class="form-group">
      <input type="search" name="search" placeholder="Type object name here" class="form-control" />
    </div>
    <div class="alert alert-warning hidden" id="noResultAlert">
      No matching result found.
    </div>
    <div class="results"></div>
  </div>
</div>
  <script type="application/javascript">
    var ObjMan = ObjMan || {};
    ObjMan.search = function() {

      // [ private properties ]

      var searchString = "",
          searchBox,
          searchResults,
          onClickResult,
          timer;

      // [ private methods ]
      function searchObject( data ) {
          searchResults.html('');
          $("#noResultAlert").removeClass('hidden');
          if ( data.length == 0 ) {
            $("#noResultAlert").show();
            return;
          } else {
            $("#noResultAlert").hide();
          }
          var result = $('<div class="result btn btn-primary btn-block"></div>');
          for ( i = 0 ; i < data.length ; ++i ) {
              var item = result.clone();
              item.attr('data-id',data[ i ].id);
              item.text( data[ i ].name );
              item.click( onClickResult );
              searchResults.append( item );
          }
      }

      function smartSeach() {
        var newSearchString = searchBox.val();
        if ( searchString !== newSearchString ) {
          searchString = newSearchString;
          if ( searchString == "" ) {
            searchResults.html('');
            $("#noResultAlert").show();
          } else {
            $.get("{{ url('/') }}/objects/search/" + searchString , searchObject );
          }
        }
      }

      function searchChange() {
        // only search 100ms after a input change
        clearTimeout( timer );
        timer = setTimeout( smartSeach , 100 );
      }

      // [ public methods ]

      return {
          init: function() {
            //
            searchBox = $('[name="search"]');
            searchResults = $('.results');
            searchBox.bind("keyup change", searchChange);
          } ,
          setClickResultCallback: function( callback ) {
            onClickResult = callback;
          }
        };

    }();

    $( document ).ready(function() {
      ObjMan.search.init();
    });
  </script>
