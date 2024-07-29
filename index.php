<?php
session_start();
$name='';
if(!isset($_SESSION['userid'])){
    header("Location:./login.php");
    exit;
}
else{
  include 'DBconnection.php' ;
 $uid=$_SESSION['userid'];
  $sql="SELECT * FROM users where userId=$uid";
  $resultn=mysqli_query($conn,$sql);
  $row=mysqli_fetch_assoc($resultn);
  $name=$row['name'];
}
include 'DBconnection.php' ;
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="jquery-ui/jquery-ui.min.css">
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="jquery-ui/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="DataTables/datatables.min.css">
    <script src="DataTables/datatables.min.js"></script>
    <script src="js/script.js"></script>
    <style>
       <style>
       /* body{
        background-color: gray;
       } */
  
    table.table.table-dark.my-4.mx-1 {
    width: 80%;
    /* margin-left: 10%; */
    align-self: center;
    justify-self: center;
    position: relative;
    left: 10%;
}
#Tab{
  width:80%;
  position: relative;
    left: 10%;
    margin-top: 30px;
}
.ADDC{
  position: relative;
    left: 40%;
}
.col-auto {
    flex: 0 0 auto;
    width: 40%;
}
main{
    background-color: black;
}
body{
  background-color: black;
}
    </style>
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-gradient">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">THE SUPERMART</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
            <?php if($_SESSION['type'] == 1 || $_SESSION['type'] == 4): ?>
              
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="./?page=home">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./?page=types">types</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./?page=products">products</a>
              </li>
              <?php endif; ?>
              <!-- #hr and admin can acess emp data -->
              <?php if($_SESSION['type'] == 2 || $_SESSION['type'] == 1): ?>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            employees
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
          <li class="">
                <a  class="dropdown-item" href="./?page=employees">employees data</a>
             </li>
            
            <li><hr class="dropdown-divider"></li>
            <li class="">
                <a class="dropdown-item" href="./?page=employeesLog">employees logs</a>
             </li>
             <li class="">
                <a  class="dropdown-item" href="./?page=deletedEmployees">EX employees data</a>
             </li>
          </ul>
        </li>
        <li class="nav-item">
                <a class="nav-link" href="./?page=customer">Customers</a>
              </li>
              
              <?php endif; ?>
              <?php if($_SESSION['type'] == 1 ||$_SESSION['type'] == 3 ): ?>
              <li class="nav-item">
                <a class="nav-link" href="./?page=transactions">Transactions</a>
              </li>
             
              <?php endif; ?>
              <!-- cahier can acess pos only -->
              <li class="nav-item">
                <a class="nav-link" href="./?page=pos">POS</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="sessions.php?a=logout">Logout</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <div class="container py-3" id="page-container">
        <?php 
            if(isset($_SESSION['flashdata'])):
        ?>
        <div class="dynamic_alert alert alert-<?php echo $_SESSION['flashdata']['type'] ?>">
        <div class="float-end"><a href="javascript:void(0)" class="text-dark text-decoration-none" onclick="$(this).closest('.dynamic_alert').hide('slow').remove()">x</a></div>
            <?php echo $_SESSION['flashdata']['msg'] ?>
        </div>
        <?php unset($_SESSION['flashdata']) ?>
        <?php endif; ?>
        <?php
            include $page.'.php';
        ?>
    </div>
    </main>
    <div class="modal fade" id="uni_modal" role='dialog' data-bs-backdrop="static">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
        </div>
        </div>
    </div>
    <div class="modal fade" id="confirm_modal" role='dialog'>
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header py-2">
            <h5 class="modal-title">Confirmation</h5>
        </div>
        <div class="modal-body">
            <div id="delete_content"></div>
        </div>
        <div class="modal-footer py-1">
            <button type="button" class="btn btn-primary btn-sm rounded-0" id='confirm' onclick="">Continue</button>
            <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
        </div>
    </div>
      
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>