<?php
class Requireable {
  private $data;
  private $order;

  public function __construct( $tag ) {
    $this->tag = $tag;
    $this->data = (object)[];
    $this->order = [];
  }

  private function exists( $id ){
    return ! empty( $this->order ) && isset( $this->data->{$id} );
  }

  public function add( $id, $string_data ){
    if ( ! $this->exists( $id )) {
      $this->order[] = $id;
      $this->data->$id = $string_data;
    }
  }

  public function addFile( $filename ) {
    if ( ! $this->exists( $filename ) ) {
      $this->add( $filename, file_get_contents( $filename, true ) );
    }
  }

  public function render(){
    foreach( $this->order as $key ) {
      $data = $this->data->{$key};
      echo "<$this->tag>$data</$this->tag>";
    }
  }
}

$css = new Requireable( 'style' );
$js = new Requireable( 'script' );
?>