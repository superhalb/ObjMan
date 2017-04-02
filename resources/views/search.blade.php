  <div class="searchbox">
    <input type="search" name="search" placeholder="Search" />
    <div class="results"></div>
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
          if ( data.length == 0 ) return;
          var result = $('<div class="result"></div>');
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
          $.get("{{ url('/') }}/objects/search/" + searchString , searchObject );
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
