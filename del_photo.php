<?php
include_once 'classes.php';
$Link=new Link('localhost','root','','sklad');

session_start();
if($Link->LoginIsExist($_SESSION['user']) != "OK"){
    header("Location: form.php");
    exit;
}

if (isset($_POST) && isset($_POST['id']) )
{
    $id = $_POST['id'];
    $link=new Link('localhost','root','','sklad');

    $Link->DeletePhoto($id);
    header('location:edit.php?id='.$id);
}
?>