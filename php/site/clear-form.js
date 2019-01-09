function clearForm( formSelector ) {
  var form = document.querySelector( formSelector ),
      inputs = form.getElementsByTagName( 'input' ),
      selects = form.getElementsByTagName( 'select' ),
      arrays = form.querySelectorAll( '.array-items .array-item' );

  for ( var i = 0; i < arrays.length; i++ ) {
    arrays[ i ].parentNode.removeChild( arrays[ i ] );
  }

  for ( var i = 0; i < inputs.length; i++ ) {
    var input = inputs[ i ];

    if ( input.type === 'text' ) {
      input.value = '';
    }
    else if ( input.type === 'checkbox' ) {
      input.checked = false;
    }
  }

  for ( var i = 0; i < selects.length; i++ ) {
      selects[ i ].selectedIndex = 0;
  }

  return false;
}