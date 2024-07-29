<?php 
session_start();


Class Delete{
    function __construct(){
        include 'DBconnection.php';
    }
    function __destruct(){
       
    }
    function DelTransaction(){
        include 'DBconnection.php';
        extract($_POST);
        $sql="DELETE FROM `transaction` where transID = $id";
        $result=mysqli_query($conn,$sql);

        
        if($result){
            $resp['status']='success';
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'Transaction successfully deleted.';
        }else{
            $resp['status']='failed';
           
        }
        return json_encode($resp);
    }
 
    



    function delEmployee(){
        include 'DBconnection.php';
        extract($_POST);
       $sql="DELETE FROM `users` WHERE `users`.`userId` = $id;";
       $result=mysqli_query($conn,$sql);

        
       if($result){
           $resp['status']='success';
           $_SESSION['flashdata']['type'] = 'success';
           $_SESSION['flashdata']['msg'] = 'Employee successfully deleted.';
       }else{
           $resp['status']='failed';
          
       }
        return json_encode($resp);
    }
    function rollbackEmployees(){
        include 'DBconnection.php';
        extract($_POST);
       $sql="DELETE FROM `deletedusers` WHERE `deletedusers`.`userId` = $id;";
       $result=mysqli_query($conn,$sql);

        
       if($result){
           $resp['status']='success';
           $_SESSION['flashdata']['type'] = 'success';
           $_SESSION['flashdata']['msg'] = 'Employee successfully deleted.';
       }else{
           $resp['status']='failed';
          
       }
        return json_encode($resp);
    }
    function delProduct(){
        include 'DBconnection.php';
        extract($_POST);
        $sql="UPDATE `products` SET `isActive` = '0' WHERE `products`.`prodID` = $id;";
        $result=mysqli_query($conn,$sql);
 
         
        if($result){
            $resp['status']='success';
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'product successfully deleted.';
        }else{
            $resp['status']='failed';
           
        }
        return json_encode($resp);
    }
}
$a = isset($_GET['a']) ?$_GET['a'] : '';
$delete = new Delete();
switch($a){
    case 'delTransaction':
        echo $delete->delTransaction();
    break;
    case 'delProduct':
        echo $delete->delProduct();
    break;
    case 'delEmployee':
        echo $delete->delEmployee();
    break;
    case 'rollbackEmployees':
        echo $delete->rollbackEmployees();
    break;
    default:
    // default action here
    break;
}