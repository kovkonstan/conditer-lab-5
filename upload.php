<?php
include_once 'classes.php';
$Link=new Link('localhost','root','','sklad');
?>

<?php
session_start();
if($Link->LoginIsExist($_SESSION['user']) != "OK"){
    header("Location: form.php");
    exit;
}

<?php
$uploaddir = './uploads/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {

}

?>