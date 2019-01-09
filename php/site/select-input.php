<?php
class SelectInput extends Input {
  public $options;
  public function __construct( $options ) {
    parent::__construct( $options );

    $this->options = $options->options;
  }
  public function render(){
    ?>
    <label class = "input-block">
      <?php include 'input-label.php' ?>
      <select name = "<?php echo $this->name ?>" class = "select-input">
        <!-- would prefer options to each have labels and values in real world -->
        <?php foreach( $this->options as $option ) { ?>
          <option
            <?php if ( $this->value == $option ) { echo "selected"; } ?>
            value = "<?php echo $option ?>">
              <?php echo $option ?>
          </option>
        <?php } ?>
      </select>
      <?php include 'error-message.php' ?>
    </label>
    <?php
  }
}
?>