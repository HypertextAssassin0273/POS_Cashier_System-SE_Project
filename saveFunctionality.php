<?php 
session_start();


Class functionality{
    function __construct(){
        include 'DBconnection.php';
    }
    function __destruct(){
       
    }
 
    function save_product(){
        include 'DBconnection.php';
        extract($_POST);
        $sql=" ";
        if(empty($id)){
       $sql=" INSERT INTO `products` (`prodID`, `prodName`, `barcode`, `price`, `Description`, `dateCreated`, `stocks`,`isActive`,`typeID`) VALUES (NULL, '{$name}', '{$product_code}', '{$price}', '{$description}', current_timestamp(), '{$unit}',1,'$type');";
     

            }
        else{
        
            $sql = "UPDATE `products` SET `prodName` = '{$name}', `barcode` = '{$product_code}', `price` = '{$price}', `Description` = '{$description}', `stocks` = '{$unit}',`typeID` = '{$type}' WHERE `products`.`prodID` = $id;";
        }
     if(empty($id)){
        $sqln ="SELECT * FROM PRODUCTS WHERE `barcode` ='$product_code'";
        $resultn=mysqli_query($conn,$sqln);
        $num=mysqli_num_rows($resultn);
     }
     else{
        $num=0;
     }
        if($num > 0){
            $resp['status'] ='failed';
            $resp['msg'] = 'Product Code already exists.';
        }else{
            $result=mysqli_query($conn,$sql); 
            if($result){

                $resp['status']="success";
                if(empty($id))
                    $resp['msg'] = "Product successfully saved.";
                else
                    $resp['msg'] = "Product successfully updated.";
            }else{
                $resp['status']="failed";
                if(empty($id))
                    $resp['msg'] = "Saving New Product Failed.";
                else
                    $resp['msg'] = "Updating Product Failed.";
                $resp['error']=mysqli_error($conn);
            }
        }
        return json_encode($resp);
    }




    //save emplyeesData
    function saveEmployee(){
        include 'DBconnection.php';
        extract($_POST);
        $sql=" ";
        if(empty($id)){
       $sql=" INSERT INTO `users` (`userid`, `name`, `userName`, `password`, `Type`,`isActive`,`salary`,`transactionCount`) VALUES (NULL, '{$name}', '$userName', '{$password}', '{$type}',1,'$salary',0);";
     

            }
        else{
        
            $sql = "UPDATE `users` SET `userName` = '$userName', `name` = '{$name}', `password` = '{$password}', `Type` = '{$type}',`salary` = '{$salary}' WHERE `users`.`userid` = $id;";
        }

       
            $result=mysqli_query($conn,$sql); 
            if($result){

                $resp['status']="success";
                if(empty($id))
                    $resp['msg'] = "Employee successfully saved.";
                else
                    $resp['msg'] = "Employee successfully updated.";
            }else{
                $resp['status']="failed";
                if(empty($id))
                    $resp['msg'] = "Saving New Employee Failed.";
                else
                    $resp['msg'] = "Updating Employee Failed.";
                $resp['error']=mysqli_error($conn);
            }
        
        return json_encode($resp);

    }

      //save transactionData
      function saveTransaction(){
        
      }


      //save Types
      function saveType(){
        include 'DBconnection.php';
        extract($_POST);
        $sql=" ";
        if(empty($id)){
       $sql=" INSERT INTO `types` (`typeID`, `typeName`, `typeDescription`, `prodCount`, `isActive`) VALUES (NULL, '$name', '$description', '0', '1');;";
     
            }
        else{
        
            $sql = "UPDATE `types` SET `typeName` = '{$name}',  `typeDescription` = '{$description}' WHERE `types`.`typeID` = $id;";
        }
       
     
            $result=mysqli_query($conn,$sql); 
            if($result){

                $resp['status']="success";
                if(empty($id))
                    $resp['msg'] = "types successfully saved.";
                else
                    $resp['msg'] = "types successfully updated.";
            }else{
                $resp['status']="failed";
                if(empty($id))
                    $resp['msg'] = "Saving New type Failed.";
                else{
                    $resp['msg'] = "Updating type Failed.";
                $resp['error']=mysqli_error($conn);
                 }
                }
        return json_encode($resp);
      }
      
  
}
$a = isset($_GET['a']) ?$_GET['a'] : '';
$functionality = new functionality();
switch($a){
  
    case 'save_product':
        echo $functionality->save_product();
    break;
    case 'saveTransaction':
        echo $functionality->saveTransaction();
    break;
    case 'saveEmployee':
        echo $functionality->saveEmployee();
    break;
    case 'saveType':
        echo $functionality->saveType();
    break;
    default:
    // default action here
    break;
}