
<div class="row g-3 align-items-center mx-4 " id="Tab">
       
       <div class="col-auto">
         <h5>Products Table</h5>
       </div>
       
     
       <div class="col-auto " class="ADDC">
      
       </div>
     </div>

     <table class="table table-dark my-4 mx-1">
       <thead class="my-2">
           <th scope="row">#</th>
           <td>transaction ID</td>
           <td colspan="2" class="table-active">Emp Name</td>
           <td>price</td>
           <td>Date</td>
         
           <!-- <td>Delete</td> -->
           <td>More</td>
       </thead>
       <tbody class="my-4">
     <?php
     include 'DBconnection.php';
      $sqln="SELECT * FROM `transaction`";
      $resultn=mysqli_query($conn,$sqln);
      $num=mysqli_num_rows($resultn);
      if($num>0){
        $i=1;
          while ( $row=mysqli_fetch_assoc($resultn)) {
            $empId=$row['EmpID'];
            $sqlname="SELECT * FROM `users` where userid=$empId";
            $resultname=mysqli_query($conn,$sqlname);
            $numn=mysqli_num_rows($resultname);
            if($numn<=0){
            // means employee is deleted so he/she must be in wx wmployees table
            $sqlname="SELECT * FROM `deletedusers` where userid=$empId";
            $resultname=mysqli_query($conn,$sqlname);
            }
            $rowname=mysqli_fetch_assoc($resultname);
            $empName=$rowname['name'];
            echo'<tr>
            <th scope="row">'.$i++.'</th>
            <td>'.$row['transNum'].'</td>
            <td colspan="2" class="table-active">'.$empName.'</td>
            <td>'.$row['total'].'</td>
            <td>'.$row['transDate'].'</td>
            <!-- <td><button type="submit" data-id ="'.$row['transID'].'" class="btn btn-danger del">Delete</button></td> -->
            <td><button type="submit" data-id ='.$row['transID'].' class="btn btn-primary edit" onClick="document.location.href=`./?page=transaction&tid='.$row['transID'].'`">view</button></td>
          </tr>';
 
          }
   
         
         
      }
      else{

      }
     ?>
      

       </tbody>
     </table>
     <script>
         $(function(){
    
        $('.edit').click(function(){
            
        })
        $('.del').click(function(){
            _conf("Are you sure to delete transaction id: <b>"+$(this).attr('data-id')+"</b> ?",'delete_data',[$(this).attr('data-id')])
        })

        $('table').dataTable({
            columnDefs: [
                { orderable: false, targets:6 }
            ]
        })
    })
    function delete_data($id){
        $('#confirm_modal button').attr('disabled',true)
        $.ajax({
            url:'delete.php?a=delTransaction',
            method:'POST',
            data:{id:$id},
            dataType:'JSON',
            error:err=>{
                consolre.log(err)
                alert("An error occurred.")
                $('#confirm_modal button').attr('disabled',false)
            },
            success:function(resp){
                if(resp.status == 'success'){
                    location.reload()
                }else{
                    alert("An error occurred.")
                    $('#confirm_modal button').attr('disabled',false)
                }
            }
        })
    }
     </script>