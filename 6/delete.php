<?php
include('requests.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET'&&!empty( $_COOKIE["delete"])) {
  $db=DB_Connect();
  $stmt = $db->prepare("DELETE from connection where id_person=:id_value");
  $id2=$_COOKIE["delete"];
  $stmt->bindParam(':id_value', $id2);
  $stmt->execute();
  $stmt = $db->prepare("DELETE from form where id=:id_value");
 // $id2=$_COOKIE["delete"];
  $stmt->bindParam(':id_value', $id2);
  $stmt->execute();
  setcookie("s_d","q");
  setcookie("delete","");
  header('Location: admin.php');
  exit();
}
else{
  header('Location: admin.php');
  exit();
}
?>