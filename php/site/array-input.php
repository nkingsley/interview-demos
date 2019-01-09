<?php
class ArrayInput extends Input {
  public $max_length;
  public $min_length;
  public $default;

  public function __construct( $options ) {
    parent::__construct( $options );

    global $css;
    $css->addFile( 'array-styles.css' );

    $this->max_length = $options->max_length;
    $this->min_length = $options->min_length;
    $this->default = $this->gather( 'array_default_'.$this->name );

    $unadded = $this->gather( 'array_entry_'.$this->name );

    if ( $unadded ) {
      $this->value[] = $unadded;
    }

    if ( ! empty( $this->value ) ) {
      $this->value = array_unique( $this->value );
    }
  }

  public function validate(){
    $length = count( $this->value );
    if ( !! $this->max_length && $length > $this->max_length ) {
      $this->valid = false;
      $this->error_message = "Too many choices added. Limit choices to $this->max_length";
    }
    else if ( !! $this->min_length && $length < $this->min_length ) {
      $this->valid = false;
      $this->error_message = "Too few choices added. Add at least $this->min_length choices";
    }
    else if ( ! isset( $this->default ) || ! isset( $this->value[ $this->default ] ) ) {
      $this->valid = false;
      $this->error_message = "Must pick a default choice ( click the &#x2606; )";
    }
    return $this->valid;
  }

  public function render() {
    ?>
    <label class = "input-block">
      <?php include 'input-label.php' ?>
      <div class = "array-input" id = "<?php echo $this->id ?>">
        <div class = "array-entry">
          <input
            type = "text"
            class = "text-input <?php if ( ! $this->valid ) { echo "input-haserror"; }?>"
            name = "array_entry_<?php echo $this->name ?>">
          <button type = "button" class = "button-primary button-small add-button">
            Add
          </button>
        </div>
        <div class = "array-items">
          <?php if ( ! empty( $this->value ) ) { 
            foreach( $this->value as $index => $item ) {
              $this->renderItem( $item, $index, false );
            }
          }?>
        </div>
        <div style="display:none" class="array-item-clone">
          <?php $this->renderItem( "", 0, true )?>
        </div>
        <input
          id="array-default"
          type = "hidden"
          value = "<?php echo $this->default ?>"
          name = "array_default_<?php echo $this->name ?>">
      </div>
      <?php include 'error-message.php' ?>
    </label>
    <?php

    global $js;

    $js->addFile( 'array-actions.js' );
    ob_start();
    ?>
    var arrayBlock = document.getElementById( '<?php echo $this->id ?>' ),
      addItem = arrayBlock.querySelector( '.array-entry input' );

    arrayBlock.addEventListener( 'click', arrayActions.bind( null, arrayBlock ) );
    addItem.addEventListener( 'keyup', function( event ){
      if ( event.keyCode === '13' ) {
        arrayActions( arrayBlock, event );
      }
      event.preventDefault();
      return false;
    });
    <?php
    $javascript = ob_get_clean();
    $js->add(
      'array-listeners-'.$this->id,
      $javascript
    );
  }

  public function renderItem( $item, $index, $disabled ){
    ?>
      <div class = "array-item" data-index="<?php echo $index ?>">
        <input
          <?php if ( $disabled ) { echo 'disabled'; } ?>
          type = "text"
          class = "text-input"
          name = "<?php echo $this->name ?>[]"
          value = "<?php echo $item ?>">
        <div class = "icon-button array-default <?php if ( $this->default == $index && ! $disabled ) { echo 'is-default'; } ?>"></div>
        <div class = "icon-button array-remove"></div>
      </div>
    <?php
  }

}

