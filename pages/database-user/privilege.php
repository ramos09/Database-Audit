<?php session_start();
 $path = $_SERVER['DOCUMENT_ROOT'].'/TA2/DBAudit';
if(!isset($_SESSION["user"])) header("Location: $path.'/login.php'");
?>
<?php include $path.'/pages/navbars/head.php'; 
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
  ?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Database Audit Tool</title>
</head>
<?php include $path.'/query/database-user/q-db-privilege.php'; ?>
<div class="wrapper">

    <?php include $path.'/pages/navbars/top-navbar.php'; ?>
    <?php include $path.'/pages/navbars/left-sidebar.php'; ?>

    <!-- HEADER and BREADCRUMB -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Database Privileges: <?php echo substr($dbnya,0,-5)?>
            </h1>
            <ol class="breadcrumb">
                <li><a href="/TA2/DBAudit/index.php"><i class="fa fa-dashboard"></i>Home</a></li>
                <li><a href="/TA2/DBAudit/pages/database-user/user-list.php?id=<?php echo $makerValue ?>">Database User</a></li>
                <li class='active'>Database Privileges</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box ">
                        <div class="box-header">
                            <h3 class="box-title">Database Privileges</h3>
                        </div>
                        <div class="box-body">
                            <table id="Privilege" class="table table-bordered table-hover">
                                <thead>
                                  <tr>
                                  <?php if ($makerValue == 1) {?>
                                    <th>Permission Name</th>
                                    <th>Permission State</th>
                                    <th>More</th>

                                    <?php } else{ ?>
                                      <th>Permission Name</th>
                                      <th>CLass Description</th>
                                      <th>Type Permission</th>
                                      <th>Permission State</th>
                                      <th>More</th>
                                      <?php }?>  
                                  </tr>
                                </thead>
                                <tbody method="get">
                                    <?php while ($row = $Privilege->fetch(PDO::FETCH_ASSOC)) {?>
                                      <tr  method="POST">
                                        <?php if ($makerValue == 1) {?>
                                          <td value=<?php echo $row['PermissionName'] ?> ><?php echo $row['PermissionName'] ?></td>
                                          <td  value=<?php echo $row['IS_GRANTABLE'] ?>><?php echo $row['state_desc'] ?></td>
                                          <td>
                                            <a method="get" href="/TA2/DBAudit/pages/database-user/privilege-detail.php?state=<?php echo $row['IS_GRANTABLE']?>&perm=<?php echo $row['PermissionName']?>&id=<?php echo $makerValue?>&usedb=<?php echo $dbnya?>"
                                                class="text-muted">
                                                <i class="fa fa-search"></i>
                                            </a>
                                          </td>
                                        <?php } else{ ?>
                                          <td value=<?php echo $row['PermissionName'] ?> ><?php echo $row['PermissionName'] ?></td>
                                          <td><?php echo $row['class_desc'] ?></td>
                                          <td><?php echo $row['type'] ?></td>
                                          <td value=<?php echo $row['state_desc'] ?>><?php echo $row['state_desc'] ?></td>

                                          <td>
                                            <a method="get" href="/TA2/DBAudit/pages/database-user/privilege-detail.php?state=<?php echo $row['state_desc']?>&perm=<?php echo $row['PermissionName']?>&id=<?php echo $makerValue?>&usedb=<?php echo $dbnya?>"
                                                class="text-muted">
                                                <i class="fa fa-search"></i>
                                            </a>
                                          </td>
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
    <?php //include $path.'/pages/navbars/control-sidebar.php'; ?>

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
    $('#Privilege').DataTable({
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
