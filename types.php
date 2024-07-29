
<div class="row g-3 align-items-center mx-4 " id="Tab">
       
       <div class="col-auto">
         <h5>Products Table</h5>
       </div>
       
     
       <div class="col-auto " class="ADDC">
         <!-- <span id="passwordHelpInline" class="form-text">
           Must be 8-20 characters long.
         </span> -->
         <button type="submit" class="btn btn-primary" id="addNew"class="ADD">ADD</button>
       </div>
     </div>

     <table class="table table-dark my-4 mx-1">
       <thead class="my-2">
           <th scope="row">#</th>
         
           <td colspan="2" class="table-active">type Name</td>
        
           <td>Description</td>
           <td>prodCount</td>
         
           <td>Delete</td>
           <td>edit</td>
       </thead>
       <tbody class="my-4">
     <?php
      $sqln="SELECT * from `types`   where isActive =1";
      $resultn=mysqli_query($conn,$sqln);
      $num=mysqli_num_rows($resultn);
      if($num>0){
        $i=1;
          while ( $row=mysqli_fetch_assoc($resultn)) {
            echo'<tr>
            <th scope="row">'.$i++.'</th>
            <td colspan="2" class="table-active">'.$row['typeName'].'</td>
            <td>'.$row['typeDescription'].'</td>
           
            <td>'.$row['prodCount'].'</td>
            <td><button type="submit" data-id ='.$row['typeID'].' class="btn btn-danger delete_data">Delete</button></td>
            <td><button type="submit" data-id ='.$row['typeID'].' class="btn btn-primary edit">edit</button></td>
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
        $('#addNew').click(function(){
            uni_modal('Add New product',"typeModal.php")
        })
        $('.edit').click(function(){
            uni_modal('Edit product',"typeModal.php?id="+$(this).attr('data-id'))
        })
        $('.delete_data').click(function(){
            _conf("Are you sure to delete <b>"+$(this).attr('data-id')+"</b> from list?",'delete_data',[$(this).attr('data-id')])
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
            url:'delete.php?a=delType',
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