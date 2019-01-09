<?php
class StubPickerInput extends Input {
  public $required_name;
  public $required_value;

  public function __construct( $options ) {
    parent::__construct( $options );
    $this->required_name = $this->name."_required";
    $this->required_value = $this->gather( $this->required_name );
  }

  public function render(){
    ?>
    <div class = "input-block">
      <?php include 'input-label.php' ?>
      <div class = "stub-multiselect">
        <span>Multi-select</span>
        <label>
          <input
            <?php if ( $this->required_value ) { echo "checked"; }?>
            type = "checkbox"
            name = "<?php echo $this->required_name ?>">
          A Value is required
        </label>
      </div>
      <?php include 'error-message.php' ?>
    </div>
    <?php
  }
}
?>