<?php 
session_start();


Class functionality{
    function __construct(){
        include 'DBconnection.php';
    }
    function __destruct(){
       
    }
    function login(){
        include 'DBconnection.php';
        $un = $_POST['username'];
        $p = $_POST['password'];
        $sql = "SELECT * FROM users where username = '$un' and `password` = '$p' ";
        $result=mysqli_query($conn,$sql);
        $num=mysqli_num_rows($result);
        if($num<=0){
            $resp['status'] = "failed2";
            $resp['msg'] = "Invalid credentials .";
        }else{
            $resp['status'] = "success";
            $resp['msg'] = "Login successfully.";
            $row=mysqli_fetch_assoc($result);
            $_SESSION['userid'] = $row['userId'];
            $_SESSION['type'] = $row['Type'];
        }
        return json_encode($resp);
    }
    function logout(){
        session_destroy();
        header("location:./");
    }
    



   
}
$a = isset($_GET['a']) ?$_GET['a'] : '';
$functionality = new functionality();
switch($a){
    case 'login':
        echo $functionality->login();
    break;
    case 'logout':
        echo $functionality->logout();
    break;
    default:
    // default action here
    break;
}