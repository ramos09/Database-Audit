<?php session_start();
 if(!isset($_SESSION["user"])) header("Location: login.php");
 if(isset($_SESSION["user"])){
    $user = $_SESSION["user"];
  }
?>
<?php $path = $_SERVER['DOCUMENT_ROOT'].'/TA2/DBAudit'; ?>
<?php include $path.'/pages/navbars/head.php'; 
include $path.'/connection/connection.php';
?>

    <!-- Main Header -->
    <!-- <header class="main-header"> -->
    <?php if (isset($_GET['id'])) {
        $makerValue = $_GET['id'];
    }
    if(isset($_SESSION["user"])){
        $user = $_SESSION["user"];
        }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Database Audit Tool</title>

    <link rel="stylesheet" href="/TA2/DBAudit/admin/css/bootstrap.min.css" />
    <style>
            .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
            }

            /* Hide default HTML checkbox */
            .switch input {
            opacity: 0;
            width: 0;
            height: 0;
            }

            /* The slider */
            .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
            }

            .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            }

            input:checked + .slider {
            background-color: #2196F3;
            }

            input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
            }

            input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
            }

            /* Rounded sliders */
            .slider.round {
            border-radius: 34px;
            }

            .slider.round:before {
            border-radius: 50%;
            }

    </style>
</head>

</html>    
<body class="bg-light">

<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">

            <div class="card">
                <div class="card-body text-center">
                    <img src="/TA2/DBAudit/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                    <br>
                    <hr>
                    <h3><?php echo  $_SESSION["user"]["name"] ?></h3>
                    <p><?php echo $_SESSION["user"]["email"] ?></p>
                    <i class="fa fa-sign-out" aria-hidden="true"><a href="/TA2/DBAudit/logout.php?">Logout</a></i>
                </div>
            </div>
        </div>
        <div class="col-md-9">           
            <div class="card mb-3">
                <div class="card-body">
                <?php $stmt1 = $dbh->query("Select * FROM dbat.users")
                ?>
                <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {?>
                                    <tr>
                                      <td><?php echo $row['name'] ?></td>
                                      <td><?php echo $row['username'] ?></td>
                                      <td><?php echo $row['email'] ?></td>

                                      <!-- <td><?php //echo $row['status'] ?></td> -->
                                      <!-- Rounded switch -->
                                      <td>   <form method="post" action="">
                                      <?php if ($row['status'] != 0) {?>
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                                <input type="hidden" name="status" value="0"/> 
                                                <input type="hidden" name="id" value="<?=$row['id']?>"/> 
                                            </label> 
                                            <td> <input type="submit" name="test" value="Update"></input></td>
                                        <?php } else { ?>
                                            <label class="switch">
                                                <input type="checkbox" >
                                                <span class="slider round"></span>
                                                <input type="hidden" name="status" value="1"/> 
                                                <input type="hidden" name="id" value="<?=$row['id']?>"/> 
                                            </label>
                                        <td> <input type="submit" name="test" value="Update"></input></td>
                                        <?php } ?>
                                         </form></td>
                                         
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                </div>
            </div>
            
        </div>
    
    </div>
</div>

</body>

<?php
if (isset($_POST['status'], $_POST['id'])){
    $status = $_POST['status'];
    $id = $_POST['id'];
    $update = $dbh->prepare("UPDATE `dbat`.`users` SET `status` = '$status' WHERE `id` = '$id' LIMIT 1;");
    $update->execute();
    echo("<meta http-equiv='refresh' content='1'>");
}
?>
