<?php
  include 'requires.php';
  include 'form-builder.php';

  $css->addFile( 'styles.css' );

  $form_inputs = array(
    new TextInput((object)array(
      "label" => "Label",
      "name" => "label",
      "required" => true
    )),
    new StubPickerInput((object)array(
      "label" => "Type",
      "name" => "type",
    )),
    new ArrayInput((object)array(
      "label" => "Choices",
      "name" => "choices",
      "max_length" => 50,
      "min_length" => 2
    )),
    new SelectInput((object)array(
      "label" => "Order",
      "name" => "order",
      "options" => array( "Display choices in Alphabetical order", "Display choices in entry order" )
    ))
  );

  $form = new FormBuilder((object)array(
    "inputs" => $form_inputs,
    "clear_selector" => "#reset-button",
    "form_selector" => "#field-builder"
  ));
?>
<html>
 <head>
    <title>PHP Craft Demo</title>
    <?php echo $css->render(); ?>
 </head>
 <body>
    <br />
    <form id = "field-builder" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class = "form-basic">
      <div class = "form-header">Field Builder</div>
      <div class = "form-body">
        <?php
          $form->renderInputs()
        ?>
      </div>
      <div class = "form-footer">
        <button type = "submit" class = "button-primary">Save changes</button>
        <button type = "button" class = "button-cancel" id = "reset-button">Cancel</button>
      </div>
    </form>
    <?php echo $js->render(); ?>
    <script>
      document.querySelector( 'form' ).addEventListener( 'keyup', function( event ){
        if ( event.target.tagName === 'INPUT' ) {
          event.target.classList.remove( 'input-haserror' );
          var node = event.target.parentElement;
          while ( node && ! node.classList.contains( 'input-block' ) ) {
            node = node.parentElement;
          }
          if ( node ) {
            var e = node.querySelector( '.error-message' );
            if ( e ) {
              e.style = 'display:none';
            }
          }
        }
      });
    </script>
 </body>
</html>
