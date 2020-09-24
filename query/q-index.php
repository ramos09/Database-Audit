<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/TA2/DBAudit';
include $path . "/connection/connection.php";
// if (isset($_GET['id'])) {
//     $makerValue = $_GET['id'];
//   }
if(isset($_SESSION["id"])){
    $makerValue = $_SESSION["id"];
    // echo "session db ".$makerValue;
}

if(isset($_GET['usedb'])) {
  $dbnya = $_GET['usedb'];
}
if(isset($_SESSION["period"])){
  // $period = $_SESSION["period"];
  $_SESSION['period']=$period;
}

// Database Access Query
if ($makerValue == 1){
$query1 = " SELECT *
FROM `$dbnya`.`general_log`
WHERE DATE(event_time) = (SELECT CURRENT_DATE())
ORDER BY event_time DESC
";
$stmt1 = $dbh->query($query1);
} else {
$query1 = "SELECT [access_log_id]
      ,[spid]
      ,[login_name]
      ,[program_name]
      ,[ip_address]
      ,[access_time]
  FROM [$dbnya].[dbo].[success_access_log]
  WHERE convert(date, [access_time]) = CONVERT(VARCHAR(10), getdate(), 111)
  AND access_time BETWEEN
(
SELECT period_start
FROM $dbnya.dbo.audit_period
WHERE period_id = $period
)
AND
(
SELECT period_end
FROM $dbnya.dbo.audit_period
WHERE period_id= $period
)
";
$stmt1 = $conn->query($query1);

}


// Database Access Per Day Query
if ($makerValue == 1){
  $query2 = "SELECT *
  FROM $dbnya.count_success_log
  WHERE event_time BETWEEN
  (
  SELECT period_start
  FROM $dbnya.audit_period
  WHERE period_id = $period
  )
  AND
  (
  SELECT period_end
  FROM $dbnya.audit_period
  WHERE period_id = $period
  )
  ORDER BY event_time DESC
  ";
  $stmt2 = $dbh->query($query2);

  $queryChart = "SELECT *
  FROM $dbnya.count_success_log
  WHERE event_time BETWEEN
  (
  SELECT period_start
  FROM $dbnya.audit_period
  WHERE period_id = $period
  )
  AND
  (
  SELECT period_end
  FROM $dbnya.audit_period
  WHERE period_id = $period
  )
  ";
  $Chart= $dbh->query($queryChart);

$total = array();
$name = array();

while ($row = $Chart->fetch(PDO::FETCH_ASSOC)) {
    array_push($total, $row['Total']);
    array_push($name, $row['user_host']);
}

  } else {
$query2 = "SELECT DISTINCT [login_name],
[Day]
    ,[Month]
    ,[Year]
    ,[Total]

from [$dbnya].[dbo].[database_access_per_day]
WHERE access_time BETWEEN
(
SELECT period_start
FROM $dbnya.dbo.audit_period
WHERE period_id = $period
)
AND
(
SELECT period_end
FROM $dbnya.dbo.audit_period
WHERE period_id = $period
)
order by Day desc
";
$stmt2 = $conn->query($query2);

$queryChart = "SELECT DISTINCT [Day]
    ,[Month]
    ,[Year]
    ,[Total]
    ,[login_name]
from [$dbnya].[dbo].[database_access_per_day]
WHERE access_time BETWEEN
(
SELECT period_start
FROM $dbnya.dbo.audit_period
WHERE period_id = $period
)
AND
(
SELECT period_end
FROM $dbnya.dbo.audit_period
WHERE period_id = $period
)
order by Day desc
";
$Chart = $conn->query($queryChart);

$total = array();
$name = array();

while ($row = $Chart->fetch(PDO::FETCH_ASSOC)) {
    array_push($total, $row['Total']);
    array_push($name, $row['login_name']);
}
}
?>
