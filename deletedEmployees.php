
<div class="row g-3 align-items-center mx-4 " id="Tab">
       
       <div class="col-auto">
         <h5>EX employee Table</h5>
       </div>
       
     
       <div class="col-auto " class="ADDC">
      
       </div>
     </div>

     <table class="table table-dark my-4 mx-1">
       <thead class="my-2">
           <th scope="row">#</th>
           <td>Name</td>
           <td>userName</td>
           <td>password</td>
           <td>Salary</td>
           <td>TransactionCount</td>
           <td colspan="2" class="table-active">Type</td>
           <td colspan="2" class="table-active">Roll Back</td>
       </thead>
       <tbody class="my-4">
     <?php
      $sqln="SELECT * FROM `deletedUsers` where isActive=1";
      $resultn=mysqli_query($conn,$sqln);
      $num=mysqli_num_rows($resultn);
      if($num>0){
        $i=1;
          while ( $row=mysqli_fetch_assoc($resultn)) {
            $type=$row['Type'];
            if($type==1){
              $type='Admin';
            }
            elseif($type==2){
              $type='Human Resource';

            }
            elseif($type==3){
              $type='Cashier';

            }
            echo'<tr>
            <th scope="row">'.$i++.'</th>
            <td>'.$row['name'].'</td>
            <td>'.$row['userName'].'</td>
            <td>'.$row['password'].'</td>
            <td>'.$row['salary'].'</td>
            <td>'.$row['transactionCount'].'</td>
            <td colspan="2" class="table-active">'.$type.'</td>
            <td><button type="submit" data-id ='.$row['userId'].' class="btn btn-danger delete_data">Roll Back</button></td>

           
          </tr>';
 
          }
   
         
         
      }
      else{

      }
     ?>
      

       </tbody>
     </table>
     <script>
        $('.delete_data').click(function(){
            _conf("Are you sure to rollback <b>"+$(this).attr('data-id')+"</b> from list?",'delete_data',[$(this).attr('data-id')])
        })
        function delete_data($id){
        $('#confirm_modal button').attr('disabled',true)
        $.ajax({
            url:'delete.php?a=rollbackEmployees',
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
    