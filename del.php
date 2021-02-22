<?php

include_once('classes.php');
$link=new Link('localhost','root','','sklad');
  if (isset($_GET['delid'])) 
  {
      $id = $_GET['delid'];
      $photo=$link->GetPhotoName($id);
      if ($photo!='NOT_FILE')
      {
          unlink($photo);
      }
      $link->DeleteItem($id);
  }
?>
