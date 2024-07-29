<?php  

include 'DBconnection.php';
$tid = isset($_GET['tid']) ? $_GET['tid'] : NULL;



$sql2="SELECT * FROM `transaction` WHERE `transID` = $tid";
$result2=mysqli_query($conn,$sql2);
 $row2=mysqli_fetch_assoc($result2);
 $transNum=$row2['transNum'];
 $transDate=$row2['transDate'];
 $empId=$row2['EmpID'];
 $total=$row2['total'];
 $sql3="SELECT * FROM `users` WHERE `userId` = $empId";
 $result3=mysqli_query($conn,$sql3);
 $row3=mysqli_fetch_assoc($result3);
 $empName=$row3['name'];
 ?>
 <style>
    #Tab{
        color:white;
    }
 </style>
 <div class="row g-3 align-items-center mx-4 " id="Tab">
       
 <div class="col-auto">
   <h5>Transaction Details </h5>
 </div>
 
 <div class="billBox">
   <h5 class="center my-3">BILL</h5> 
   <table class="my-5">
     <tr><td>Transaction ID</td> 
       <td id="cashierName"><?php echo  $tid ?></td>
       </tr>

       <tr><td>Transaction Num</td> 
         <td id="cashierName"><?php echo  $transNum ?></td>
         </tr>

   <tr><td>Cashier ID :</td> 
    <td id="cashierId"><?php echo  $empId ?></td>
    </tr>
   
    <tr><td>Transaction Date</td> 
     <td id="cashierName"><?php echo  $transDate ?></td>
     </tr>

    <tr><td>Cashier Name:</td> 
    <td id="cashierName"><?php echo  $empName ?></td>
    </tr>



    <tr><td>SUBTOTAL :</td> 
    <td id="sub_total"><?php echo  $total ?></td>
    </tr>
    <tr><td>GST :</td>
    <td>13%</td>
    </tr>

    <tr class="my-8"><td>TOTAL :</td>
      <td id="Total"><?php echo  $total * 1.13?></td></tr>
    
   </table>
  </div>
 

</div>

<table class="table table-dark my-4 mx-1">
 <thead class="my-2">
     <th scope="row">#</th>
     <td>BarCode</td>
     <td colspan="2" class="table-active">Name</td>
     <td>price</td>
     <td>Qty</td>
     <td>Price * qty</td>

 </thead>
 <tbody class="my-4">
 <?php
$sql="SELECT * FROM `carttable` WHERE `transID` = $tid";
$result=mysqli_query($conn,$sql);
 $num=mysqli_num_rows($result);
 if($num>0){
   $i=1;
     while ( $row=mysqli_fetch_assoc($result)) {
      $qty=$row['qty'];
      $pid=$row['prodID'];
      $sqlp="SELECT * FROM `products` WHERE `prodID` = $pid";
      $resultp=mysqli_query($conn,$sqlp);
      $rowp=mysqli_fetch_assoc($resultp);
       echo'<tr>
       <th scope="row">'.$i++.'</th>
       <td>'.$rowp['barcode'].'</td>
       <td colspan="2" class="table-active">'.$rowp['prodName'].'</td>
       <td>'.$rowp['price'].'</td>
       <td>'.$qty.'</td>
       <td>'.$rowp['price'] * $qty.'</td>
     </tr>';

     }

    
    
 }

?>



 </tbody>
</table>
