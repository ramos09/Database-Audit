<?php session_start();
 $path = $_SERVER['DOCUMENT_ROOT'].'/TA2/DBAudit';
if(!isset($_SESSION["user"])) header("Location: $path.'/login.php'");
?>
<?php include $path.'/pages/navbars/head.php';
if (isset($_GET['id'])) {
    $makerValue = $_GET['id'];
  } ?>
<?php include $path.'/query/database-user/q-db-user.php'; ?>
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
                Database User: <?php echo substr($dbnya,0,-5)?>
            </h1>
            <ol class="breadcrumb">
                <li><a href="/TA2/DBAudit/index.php"><i class="fa fa-dashboard"></i>Home</a></li>
                <li><a href="/TA2/DBAudit/pages/database-user/user-list.php">Database User</a></li>
                <li class='active'>Database User List</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box ">
                        <div class="box-header">
                            <h3 class="box-title">Database User List</h3>
                        </div>
                        <div class="box-body">
                            <table id="ViewList" class="table table-bordered table-hover">
                                <thead>
                                  <tr>
                                  <?php if ($makerValue == 1) {?>
                                    <th>Username</th>
                                    <th>Host</th>
                                    <th>Password</th>
                                    <!-- <th>Password Expired</th> -->
                                    <?php } else{ ?>
                                    <th>Principal_id</th>
                                    <th>Username</th>
                                    <th>Status</th>
                                    <th>Create Date</th>
                                    <th>Modify Date</th>
                                    <?php }?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $LoginName->fetch(PDO::FETCH_ASSOC)) {?>
                                <tr>
                                <?php if ($makerValue == 1) {?>
                                    <?php if($row['username'] ==  NULL){ ?>
                                            <tr style="background-color: #f56954;">
                                                <?php }else{ ?>
                                            <?php }?>
                                    <td><?php echo $row['username'] ?></td>
                                    <td><?php echo $row['HOST'] ?></td>
                                    <td><?php echo $row['PASSWORD'] ?></td>
                                    <?php } else{ ?>
                                        <?php if($row['status'] == 'Deactivated'){ ?>
                                            <tr style="background-color: #f56954;">
                                                <?php }else{ ?>
                                            <?php }?>
                                    <td><?php echo $row['principal_id'] ?></td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['status'] ?></td>
                                    <td><?php echo $row['create_date'] ?></td>
                                    <td><?php echo $row['modify_date'] ?></td>
                                    
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
