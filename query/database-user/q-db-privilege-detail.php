<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/TA2/DBAudit';
include $path . "/connection/connection.php";
if (isset($_GET['perm'])) {
  $permission = $_GET['perm'];
}
if (isset($_GET['state'])) {
  $state = $_GET['state'];
  // echo $state;
  // die;
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
  
// Database Privilege List Query
if ($makerValue == 1){
$ListPrivQuery = "SELECT 	`GRANTEE`, 
	`TABLE_CATALOG`, 
	`PRIVILEGE_TYPE`, 
	CASE `IS_GRANTABLE`
          WHEN 'YES' THEN 'GRANT'
          ELSE 'DENY'
        END AS `state_desc`
	FROM 
	`$dbnya`.`privileges_list` 
	where `PRIVILEGE_TYPE` = '".$permission."' AND `IS_GRANTABLE` = '$state'";
	$ListPriv = $dbh->query($ListPrivQuery);
} else { 
$ListPrivQuery = "SELECT [UserName]
      ,[UserType]
      ,[DatabaseUserName]
      ,[Role]
      ,[PermissionState]
      ,[ObjectType]
      ,[ObjectName]
  FROM [$dbnya].[dbo].[privilege_list]
where PermissionType = '".$permission."' AND  PermissionState = '$state'";
$ListPriv = $conn->query($ListPrivQuery);
}
?>