<?php

class FormBuilder {
  private $id;
  function __construct( $options = array() ) {
    $this->id = uniqid();
    $this->inputs = $options->inputs;
    $this->clear_selector = $options->clear_selector;
    $this->form_selector = $options->form_selector;

    if ( ! empty( $_POST ) ) {
      foreach( $this->inputs as $input ) {
        if ( ! $input->validate() ) {
          $this->valid = false;
        }
      }
    }
  }

  public $valid = true;

  public function renderInputs() {
    foreach( $this->inputs as $input ) {
      $input->render();
    }

    if ( $this->clear_selector ) {
      $this->addClearScripts();
    }
  }

  private function addClearScripts() {
    global $js;
    $js->addFile( "clear-form.js" );
    ob_start();
    ?>
    document
      .querySelector( "<?php echo $this->clear_selector ?>" )
      .addEventListener( "click", clearForm.bind( null, "<?php echo $this->form_selector ?>" ) );
    <?php
    $javascript = ob_get_clean();
    $js->add(
      "clear-form-".$this->id,
      $javascript
    );
  }
}

class Input {
  public $id;
  public $name;
  public $label;
  public $required = false;
  public $value;

  function __construct( $options ) {
    $this->id = uniqid();
    $this->name = $options->name;
    $this->label = $options->label;

    if ( isset( $options->required ) ) {
      $this->required = $options->required;
    }

    if ( ! isset( $this->value ) ) {
      $this->value = $this->gather( $this->name );
    }
  }

  public $valid = true;

  public function validate(){
    if ( $this->required ) {
      $this->valid = !! $this->value;
    }
    if ( $this->valid ) {
      $this->error_message = "";
    }
    else {
      $this->error_message = $this->label." is required.";
    }
    return $this->valid;
  }

  public function sanitize( $str ) {
    return filter_var( $str, FILTER_SANITIZE_STRING );
  }

  public function gather( $property ){
    if ( isset( $_POST[ $property ] ) ) {
      $val = $_POST[ $property ];
      if ( is_string( $val ) ) {
        return $this->sanitize( $val );
      }
      else if ( is_array( $val ) ){
        $new_val = [];
        foreach( $val as $v ) {
          if ( $v !== "" ) {
            array_push( $new_val, $this->sanitize( $v ) );
          }
        }
        return $new_val;
      }
    }
  }
}

include "array-input.php";
include "text-input.php";
include "stub-picker-input.php";
include "select-input.php";

?>