<?php
require_once("DBConnection.php");
if(isset($_GET['id'])){
$sql="SELECT * FROM `users` where userid = '{$_GET['id']}' ";
$result=mysqli_query($conn,$sql);
$num=mysqli_num_rows($result);
$row=mysqli_fetch_assoc($result);
$name=$row['name'];
$uname=$row['userName'];
$type=$row['Type'];
$password=$row['password'];
$eid=$row['userId'];
$salary=$row['salary'];
}
?>
<div class="container-fluid">
    <form action="" id="product-form">
        <input type="hidden" name="id" value="<?php echo isset($eid) ? $eid : '' ?>">
        <div class="form-group">
            <label for="name" class="control-label">Name</label>
            <input type="text" name="name" id="name" required class="form-control form-control-sm rounded-0" value="<?php echo isset($name) ? $name : '' ?>">
        </div>
        <div class="form-group">
            <label for="product_code" class="control-label">type</label>
            <select name="type" id="type" class="form-control form-control" required>
                <option value="1" <?php echo isset($type) && $type == 1 ? 'selected' : '' ?>>Admin</option>
                <option value="2" <?php echo isset($type) && $type == 2 ? 'selected' : '' ?>>HUMAN RESOURCE</option>
                <option value="3" <?php echo isset($type) && $type == 3 ? 'selected' : '' ?>>CASHIER</option>
                <option value="4" <?php echo isset($type) && $type == 3 ? 'selected' : '' ?>>Inventory Manager</option>

            </select>
        </div>

        <div class="form-group">
            <label for="unit" class="control-label">UserName</label>
            <input type="text" name="userName" id="unit" required class="form-control form-control-sm rounded-0" value="<?php echo isset($uname) ? $uname : '' ?>">
        </div>
        
        <div class="form-group">
            <label for="description" class="control-label">password</label>
            <input type="text" name="password" id="unit" required class="form-control form-control-sm rounded-0" value="<?php echo isset($password) ? $password : '' ?>">
        </div>
         <div class="form-group">
            <label for="unit" class="control-label">Salary</label>
            <input type="text" name="salary" id="unit" required class="form-control form-control-sm rounded-0" value="<?php echo isset($salary) ? $salary : '' ?>">
        </div>
    </form>
</div>

<script>
    $(function(){
        $('#product-form').submit(function(e){
            e.preventDefault();
            $('.pop_msg').remove()
            var _this = $(this)
            var _el = $('<div>')
                _el.addClass('pop_msg')
            $('#uni_modal button').attr('disabled',true)
            $('#uni_modal button[type="submit"]').text('submitting form...')
            $.ajax({
                url:'saveFunctionality.php?a=saveEmployee',
                method:'POST',
                data:$(this).serialize(),
                dataType:'JSON',
                error:err=>{
                    console.log(err)
                    _el.addClass('alert alert-danger')
                    _el.text("An error occurred.")
                    _this.prepend(_el)
                    _el.show('slow')
                     $('#uni_modal button').attr('disabled',false)
                     $('#uni_modal button[type="submit"]').text('Save')
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        _el.addClass('alert alert-success')
                        $('#uni_modal').on('hide.bs.modal',function(){
                            location.reload()
                        })
                        if("<?php echo isset($product_id) ?>" != 1)
                        _this.get(0).reset();
                    }else{
                        _el.addClass('alert alert-danger')
                    }
                    _el.text(resp.msg)

                    _el.hide()
                    _this.prepend(_el)
                    _el.show('slow')
                     $('#uni_modal button').attr('disabled',false)
                     $('#uni_modal button[type="submit"]').text('Save')
                }
            })
        })
    })
</script>