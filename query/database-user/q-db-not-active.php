<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/TA2/DBAudit';
include $path . "/connection/connection.php";
if (isset($_GET['id'])) {
  $makerValue = $_GET['id'];
}
if(isset($_SESSION["id"])){
  $makerValue = $_SESSION["id"];
  // echo "session db ".$makerValue;
}

if (isset($_GET['usedb'])) {
$dbnya = $_GET['usedb'];
}
if(isset($_SESSION["period"])){
  $period = $_SESSION["period"];}
// Database User Not-Active Query
if ($makerValue == 1){
$NotActiveQuery = "
  SELECT *
    FROM $dbnya.inactive_user
  ";
  $NA = $dbh->query($NotActiveQuery);
} else{
$NotActiveQuery = "
SELECT *
  FROM [$dbnya].[dbo].[inactive_user]
";
$NA = $conn->query($NotActiveQuery);
}
?>