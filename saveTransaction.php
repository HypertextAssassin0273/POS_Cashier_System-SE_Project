<?php
session_start();
include 'DBconnection.php';

extract($_POST);
//echo $change;
$code = "";
while(true){
    $code = mt_rand(1,9999999999);
    $code = sprintf("%.10d",$code);
    $sql="SELECT * FROM `transaction` WHERE transNum='$code'";
    $resultn=mysqli_query($conn,$sql);
    $num=mysqli_num_rows($resultn);
    if($num==0){
        break;
    }
}
function numberExist($totalB){
    include 'DBconnection.php';
    extract($_POST);
    $sqlc="SELECT * from customer where custNumber= '$cNum'" ;
    $resultc=$result=mysqli_query($conn,$sqlc);
    $num=mysqli_num_rows($resultc);
    $sqki="";
    if($num>0){
        //num already exists in db
        $sqli="UPDATE customer
        SET amountSpend =  $totalB +amountSpend
        WHERE custNumber=$cNum;";

    }
    
    else{
        //cust buying from the shop first time
        $sqli="INSERT INTO `customer` (`custID`, `custName`, `custNumber`, `amountSpend`, `loyal`, `lastTransaction`) VALUES (NULL, '$cName', '$cNum', '$total',0, current_timestamp());";
    }
    $resulti=mysqli_query($conn,$sqli);
}
function calcBill(){
    include 'DBconnection.php';
    extract($_POST);
    $total =0;
    foreach($product_id as $k => $v){
        $pid= $product_id[$k];
        $qty= $quantity[$k];
        $sql ="SELECT * FROM `products` WHERE `prodID` = $pid ";
        $result=mysqli_query($conn,$sql);
        if($result){
            $row=mysqli_fetch_assoc($result);
            $price=$row['price'];
            $np= $price * $qty;
            $total += $np;
        }
    }
    return $total;
}
$totalBill= calcBill();
numberExist($totalBill);
$uid=$_SESSION['userid'];


// Start a transaction
$conn->begin_transaction();
$sql= "INSERT INTO `transaction` (`transID`, `EmpID`, `transNum`, `total`, `transDate`) VALUES (NULL, '$uid', '$code', '$totalBill', current_timestamp())";
$resultn=mysqli_query($conn,$sql);

$sqls="SELECT * FROM `transaction` WHERE `transNum` LIKE '$code'";
$results=mysqli_query($conn,$sqls);
$row=mysqli_fetch_assoc($results);
$tid=$row['transID'];
$Bill=$totalBill*1.13;
$sqlp="INSERT INTO `payment` (`paymentID`, `transID`, `subTotal`, `Total`, `paymentDate`, `amountReceived`, `ChangeGiven`,`paymentType`) VALUES (NULL, '$tid', '$totalBill', '$Bill', current_timestamp(), '90000', '0','$ptype');";
$resultp=mysqli_query($conn,$sqlp);
$results="";
if($resultn && $resultp){
    foreach($product_id as $k => $v){
        
        $pid= $product_id[$k];
        $qty= $quantity[$k];
       
      $sqls="INSERT INTO `carttable` (`transID`, `prodID`, `qty`) VALUES ('$tid', '$product_id[$k]', '$quantity[$k]')";
      $results=mysqli_query($conn,$sqls);
    }
}





if($resultn && $resultp && $results){
    
    // If everything is successful, commit the transaction
    $conn->commit();
    $resp['status']='success';
    $_SESSION['flashdata']['type'] = 'success';
    $_SESSION['flashdata']['msg'] = 'Transaction successfully saved.';
}else{
     // An error occurred, roll back the transaction
     $conn->rollback();
    $resp['status'] = 'failed';
    $resp['error'] = $conn->error;
}
echo json_encode($resp);
?>