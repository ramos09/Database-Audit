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
// Database User Query
if ($makerValue == 1){
    $DBUserQuery = "SELECT
    `Name`,
    `LastAccess`,
    `Total`
    FROM `$dbnya`.`database_usage`
    WHERE LastAccess BETWEEN
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
    GROUP BY `Name`"
    ;
    $DBUser = $dbh->query($DBUserQuery);

    $DBUserChartQuery = "SELECT
    `Name`,
    `LastAccess`,
    `Total`
    FROM `$dbnya`.`database_usage`
    WHERE LastAccess BETWEEN
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
    GROUP BY `Name`
    ";
    $UserChart = $dbh->query($DBUserChartQuery);

    $name = array();
    $total = array();

    while ($row = $UserChart->fetch(PDO::FETCH_ASSOC)) {
    array_push($total, $row['Total']);
    array_push($name, $row['Name']);
    }


} else {
    $DBUserQuery = "SELECT
    login_name as [Name],
    count(*) as [Total]
        FROM $dbnya.dbo.success_access_log
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
        GROUP BY login_name
        ";
    $DBUser = $conn->query($DBUserQuery);

    $DBUserChartQuery = "SELECT
    login_name as [Name],
    count(*) as [Total]
        FROM $dbnya.dbo.success_access_log
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
        GROUP BY login_name
        ";
    $UserChart = $conn->query($DBUserChartQuery);

    $name = array();
    $total = array();

    while ($row = $UserChart->fetch(PDO::FETCH_ASSOC)) {
    array_push($total, $row['Total']);
    array_push($name, $row['Name']);
    }

}

?>
