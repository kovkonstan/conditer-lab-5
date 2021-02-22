<?php
header('Content-type:text/html;charset=utf-8');
  include_once('classes.php');
 if (isset($_POST) && isset ($_POST['name']) && isset ($_POST['count'])
         && isset($_POST['type']) )
 {
    $link=new Link('localhost','root','','sklad');
    $item=new Item(0,$_POST['type'],$_POST['name'],$_POST['count'],"2021-02-21 20:52:41");
    echo $link->AddItem($item);
    //header('location:sklad.php');
 }
?>
