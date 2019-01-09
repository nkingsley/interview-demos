<?php
class TextInput extends Input {
  public function render(){
    ?>
    <label class = "input-block">
      <?php include "input-label.php" ?>
      <input
        type = 'text'
        value = '<?php echo $this->value ?>'
        name = '<?php echo $this->name ?>'
        class = 'text-input <?php if ( ! $this->valid ) { echo "input-haserror"; }?>'>
      <?php include 'error-message.php' ?>
    </label>
    <?php
  }
}
?>