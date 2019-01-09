// This is all best done with a reactive system, not vanilla js
function arrayActions( arrayBlock, event ) {
  var target = event.target;

  if ( target.classList.contains( 'add-button' ) ) {
    var clone = arrayBlock.querySelector( '.array-item-clone .array-item').cloneNode( true ),
      total = arrayBlock.querySelectorAll( '.array-items .array-item' ).length,
      entry = arrayBlock.querySelector( '.array-entry input' ),
      cloneInput = clone.querySelector( 'input' ),
      defaultInput = arrayBlock.querySelector( '#array-default' );

    if ( ! total ) {
      defaultInput.value = 0;
      clone.querySelector( '.array-default' ).classList.add( 'is-default' );
    }

    clone.setAttribute( 'data-index', total );
    cloneInput.value = entry.value;
    cloneInput.removeAttribute( 'disabled' );
    entry.value = '';

    arrayBlock
      .querySelector( '.array-items' )
      .appendChild( clone );
  }

  if ( target.classList.contains( 'array-remove' ) ) {
    var parent = target.parentElement;

    if ( parent && parent.parentElement ) {
      var grandparent = parent.parentElement;
      grandparent.removeChild( parent );
      if ( parent.querySelector( '.array-default' ).classList.contains( 'is-default' ) ) {
        var firstChild = grandparent.children[ 0 ];
        firstChild.querySelector( '.array-default' ).classList.add( 'is-default' );
        arrayBlock.querySelector( '#array-default' ).value = firstChild.getAttribute( 'data-index' );
      }

    }
  }

  if ( target.classList.contains( 'array-default' ) ) {
    var defaultInput = arrayBlock.querySelector( '#array-default' ),
      currentDefault = arrayBlock.querySelector( '[data-index="' + defaultInput.value + '"]' );

    if ( currentDefault ) {
      currentDefault.querySelector( '.array-default' ).classList.remove( 'is-default' );
    }

    defaultInput.value = target.parentElement.getAttribute( 'data-index' );

    target.classList.add( 'is-default' );
  }

  event.preventDefault();
}