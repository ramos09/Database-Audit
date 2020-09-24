<?php session_start();
 $path = $_SERVER['DOCUMENT_ROOT'].'/TA2/DBAudit';
if(!isset($_SESSION["user"])) header("Location: $path.'/login.php'");
?>

<?php include $path.'/pages/navbars/head.php';
if (isset($_GET['id'])) {
    $makerValue = $_GET['id'];
  }

  if (isset($_POST['period'])) {
    $period = $_POST['period'];
    $_SESSION['period']=$period;
    //  echo $period;
    //  die;
    }
  ?>
<?php include $path.'/query/database-access-query/q-db-access.php'; ?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Database Audit Tool</title>
</head>
<div class="wrapper">

    <?php include $path.'/pages/navbars/top-navbar.php'; ?>
    <?php include $path.'/pages/navbars/left-sidebar.php'; ?>

    <!-- HEADER and BREADCRUMB -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Database Access: <?php echo substr($dbnya,0,-5)?>
                <!-- <small>Optional description</small> -->
            </h1>
            <ol class="breadcrumb">
                <li><a href="/TA2/DBAudit/index.php?id=<?php echo $makerValue?>&usedb=<?php echo $dbnya?>"><i class="fa fa-dashboard"></i>Home</a></li>
                <li><a href="/TA2/DBAudit/pages/database-access/database-access.php?id=<?php echo $makerValue?>&usedb=<?php echo $dbnya?>">Database Access</a></li>
                <li class="active">Database Access List</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <div class="row">
                <div class="col-xs-12">
                    <div class="box ">
                        <div class="box-header">
                            <h3 class="box-title">Database Access List</h3>
                        </div>
                        <div class="box-body">
                            <table id="AccessList" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <?php if ($makerValue == 1) {?>
                                        <th>Login Time</th>
                                        <th>User Host</th>
                                        <th>Command Type</th>
                                        <th>Argument</th>
                                        <?php } else{ ?>
                                          <th>ID</th>
                                          <th>Login Name</th>
                                          <th>Program Name</th>
                                          <th>Date</th>
                                        <!-- <th>More</th> -->
                                        <?php }?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php while ($row = $AccessList->fetch(PDO::FETCH_ASSOC)) {
                                        if ($makerValue == 1) {?>
                                        <td><?php echo ($row['event_time']);?></td>
                                        <td><?php echo ($row['user_host']);?></td>
                                        <td><?php echo ($row['command_type'])?></td>
                                        <td><?php echo ($row['argument'])?></td>
                                      <?php } else{ ?>
                                      <td> <?php echo $row['Id']?> </td>
                                      <td> <?php echo $row['Name']?></td>
                                      <td> <?php echo $row['Program']?></td>
                                      <td><?php echo date('jS \of F Y h:i:s A',strtotime($row['Time'])); ?></td>
                                      <?php }?>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php include $path.'/pages/navbars/footer.php'; ?>

    <?php include $path.'/pages/navbars/control-sidebar.php'; ?>
</div>
<!-- ./wrapper -->

<?php include $path.'/pages/navbars/required-scripts.php'; ?>

<!-- SlimScroll -->
<script src="/TA2/DBAudit/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/TA2/DBAudit/bower_components/fastclick/lib/fastclick.js"></script>

<!-- DATA TABLES -->
<script src="/TA2/DBAudit/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/TA2/DBAudit/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
$(function() {
    $('#AccessList').DataTable({
        'paging': true,
        'lengthChange': true,
        'searching': true,
        'ordering': false,
        'info': true,
        'autoWidth': true
    })
})
</script>

<?php include $path.'/pages/navbars/end.php'; ?>
