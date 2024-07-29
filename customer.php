
<div class="row g-3 align-items-center mx-4 " id="Tab">
       
       <div class="col-auto">
         <h5>customers Table</h5>
       </div>
       
     
       <div class="col-auto " class="ADDC">
         <!-- <span id="passwordHelpInline" class="form-text">
           Must be 8-20 characters long.
         </span> -->
         <!-- <button type="submit" class="btn btn-primary" id="addNew"class="ADD">ADD</button> -->
       </div>
     </div>

     <table class="table table-dark my-4 mx-1">
       <thead class="my-2">
           <th scope="row">#</th>
           <td>Name</td>
           <td>Phone Number</td>
           <td>amount spent</td>
           <!-- <td colspan="2" class="table-active">Loyality</td> -->
           <td colspan="2" class="table-active">LastTransaction Date</td>
         
       </thead>
       <tbody class="my-4">
     <?php
      $sqln="SELECT * FROM `customer`";
      $resultn=mysqli_query($conn,$sqln);
      $num=mysqli_num_rows($resultn);
      if($num>0){
        $i=1;
          while ( $row=mysqli_fetch_assoc($resultn)) {
        
            echo'<tr>
            <th scope="row">'.$i++.'</th>
            <td>'.$row['custName'].'</td>
            <td>'.$row['custNumber'].'</td>
            <td>'.$row['amountSpend'].'</td>
     
           
            <td>'.$row['lastTransaction'].'</td>
        
          </tr>';
 
          }
   
         
         
      }
      else{

      }
     ?>
      

       </tbody>
     </table>
     <script>
   
     </script>