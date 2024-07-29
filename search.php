<?php
include 'DBconnection.php';
//$barcode=$_POST['barcode'];
extract($_POST);
$qty = 1;
if(strpos($t,'*') !== false){
    $ex = explode("*",$t);
    $term = (isset($ex[1]))? $ex[1] : "";
    $qty = $ex[0];
}else{
    $term = $t;
}
$sql="SELECT * FROM `products` WHERE `barcode` LIKE '%{$term}%'";
$result=mysqli_query($conn,$sql);
$num=mysqli_num_rows($result);
$data = array();
if($num>0){
    //case if barcode exists in product table in database
    while($row=mysqli_fetch_assoc($result)){
       $row['qty']=1;
        $data[] = array("label"=>$row['barcode']." - ".$row['prodName'],
                        "value"=>$row['barcode'],
                        "id"=>$row['prodID'],
                        "data"=>$row
                        );
    }
}
else{
    //case if barcode doesnot exists in product table in database
    $data[] = array("label"=>"Product Code is Unknown.",
    "value"=>"",
    "id"=>""
    );
}

echo json_encode($data);



?>