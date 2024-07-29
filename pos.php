<style>
      .tb{
        width: 100%;
        display: flex;

      }
      .table{
        width: 65%;
        /* overflow-y: scroll; */
      }
   
      .billBox{
        margin-top: 24px;
        width: 35%;
        color: rgb(255, 255, 255);
        /* border: 2px solid black; */
        height: 80vh;
        background-color: rgb(23, 18, 18);
        padding: 12px;
       
      }
      .center{
        text-align: center;
      }
      .billBox tr {
        margin-top: 10px;
        padding-top: 10px;
      }
</style>
<form action="" id="pos-form">
<div class="row g-3 align-items-center mx-4 " >

        <div class="col-auto">
          <label for="inputPassword6" class="col-form-label"  >Barcode</label>
        </div>
        <div class="col-auto">
        <input type="text"  autocomplete="off" autofocus class="form-control form-control-sm control-sm rounded-0" id="barcode"  aria-describedby="passwordHelpInline">
        </div>
       
        
        <div class="col-auto">
          <!-- <span id="passwordHelpInline" class="form-text">
            Must be 8-20 characters long.
          </span> -->
          <!-- <button type="submit" class="btn btn-primary">ADD</button> -->
        </div>
      </div>

     <div class="tb">
      <table class="table table-dark my-4 mx-1" id="item-list">
        <thead class="my-2">
            <th scope="row">item</th>
            <td>BarCode</td>
            <td colspan="2" class="table-active">Name</td>
            <td>Unit Rate</td>
            <td>Qty</td>
            <td>Net Value</td>
            <td>Delete</td>
        </thead>
        <tbody class="my-4">
      
          <!-- <tr>
            <th scope="row">3</th>
            <td>ch#123#$56&</td>
            <td colspan="2" class="table-active">Larry the Bird</td>
            <td>5000</td>
            <td><input type="number" name="" id=""></td>
            <td>15000</td>
            <td><button type="submit" class="btn btn-danger">Delete</button></td>
          </tr> -->
                
        

         


        
        </tbody>
      </table>
      <div class="billBox">
       <h5 class="center my-3">BILL</h5> 
       <table class="my-5">


       <tr><td>Cashier ID :</td> 
        <td id="cashierId"><?php echo $_SESSION['userid']; ?></td>
        </tr>


        <tr><td>Cashier Name:</td> 
        <td id="cashierName"><?php echo $name; ?></td>
        </tr>



        <tr><td>SUBTOTAL :</td> 
        <td id="sub_total">00</td>
        </tr>
        <tr><td>GST :</td>
        <td>13%</td>
        </tr>

        <tr class="my-8"><td>TOTAL :</td>
          <td id="Total">0.00</td></tr>

          <tr class="my-8"><td>Customer Name :</td>
          <td id="cName"> <input type="text" name="cName" class="form-control form-control-lg text-end fs-4" id="tender" value=""></td></tr>


          <tr class="my-8"><td>Customer Number :</td>
          <td id="cNum"> <input type="text" name="cNum" class="form-control form-control-lg text-end fs-4" id="tender" value=""></td></tr>
          <tr>
          <td>payment Type :</td>
          
           <td><select name="ptype" id="type" class="form-control form-control" required>
                <option value="1" >Cash</option>
               
                <option value="2">Card</option>
            </select></td>
          </tr>
          
          <tr class="my-3"><td>FINISH TRANSACTION :</td>
          <input type="hidden" name="total" value="0">
          <td ><button class="btn btn-primary" type="button" onclick="finishT()">Finsih</button></td></tr>
       </table>
      </div>
     </div>
</form>
     <script>
 $(function(){
    $('#pos-form').submit(function(e){
        e.preventDefault()
        $.ajax({
            url:"saveTransaction.php",
            method:'POST',
            data:$(this).serialize(),
            dataType:'json',
            error:err=>{
                console.log(err)
                alert('An error occured.')
            },
            success:function(resp){
                if(resp.status == 'success'){
                    location.reload()
                }else{
                    console.log(resp)
                    alert('An error occured.')
                }
            }
        })
    })
    $(window).on('keydown',function(e){
        if($.inArray(e.which,[112,113,114,115]) > -1 && e.ctrlKey == true){
            e.preventDefault()
            if(e.which == 112){
                $('#product_code').val('').focus()
            }
            if(e.which == 113){
                $('#disc_perc').focus().select()
                document.execCommand('selectAll', false, null)
            }
            if(e.which == 114){
            
            }
        }
    })
 
   $('#barcode').autocomplete({
       source:function(request, response){
        console.log(request.term)
           $.ajax({
             
               url:"search.php",
               method:"POST",
               data: {t:request.term},
               dataType:'json',
               error:err=>console.log(err),
               success:function(resp){
                   response(resp)
               }
           })
       },
      create:function(event,ui){
          $(this).data("ui-autocomplete")._renderItem = function(ul,item){
             if(item.id == ''){
                return $('<li class="ui-state-disabled px-1" style="opacity:1 !important">'+item.label+'</li>').appendTo(ul);
             }else{
                 return $('<li>').append("<div>"+item.label+"</div>").appendTo(ul);
             }
          }
      },
      select:function(event,ui){
          var data = ui.item.data
          add_item(data)
          setTimeout(() => {
            $('#product_code').val('')
          }, 100);
      },
        minLength: 2
   })
})
function calc_total(){
    console.log("in t")
    $('input[name="quantity[]"]').each(function(){
        var _total = 0
        var tr = $(this).closest('tr')
        var qty = $(this).val()
        console.log(qty)
        var unit_price = tr.find("input[name='price[]']").val()
            // unit_price = unit_price.replace(/,/gi,'')
            console.log(unit_price)
            _total = parseFloat(qty) * parseFloat(unit_price)
            _total = parseFloat(_total).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:3})
            tr.find('.total-price').text(_total)
    })
    var total = 0;
    $('#item-list tbody .total-price').each(function(){
        var _total = $(this).text()
            _total = _total.replace(/,/gi,'')

        total += parseFloat(_total)
    })
    $('#sub_total').text(parseFloat(total).toLocaleString("en-US",{style:'decimal',maximumFractionDigits:2, minimumFractionDigits:2}))
    let ft= total +(total * 0.13)
    $('#Total').text(parseFloat(ft).toLocaleString("en-US",{style:'decimal',maximumFractionDigits:2, minimumFractionDigits:2}))
   // console.log(total)
   $('input[name="total"]').val(total)
}
function finishT(){
  uni_modal("Payment", "tender.php?total="+$('[name="total"]').val())
}
function add_item($data){
  console.log("in add")
    var tr = $('<tr>')
        tr.attr('data-id',$data.prodID)
    var inputs = $('<div class="d-none">')
        inputs.append('<input type="hidden" name="product_id[]" value="'+$data.prodID+'"/>')
        inputs.append('<input type="hidden" name="price[]" value="'+$data.price+'"/>')
         tr.append(inputs.html())
        tr.append('<td scope="row">3</td>')
        tr.append('<td scope="row">'+$data.barcode+'</td>')
        tr.append('<td colspan="2" class="table-active">'+$data.prodName+'</td>')
        tr.append('<td>'+$data.price+'</td>')
        tr.append('<td ><input class="text-center" type="number" name="quantity[]" value="'+$data.qty+'"/></td>')
        tr.append('<td class="text-center total-price">'+(parseFloat($data.price * $data.qty).toLocaleString('en-US'))+'</td>')
        tr.append('<td><button  onclick="rem_item($(this))" class="btn btn-danger">Delete</button></td>')
    //tr.append('<td class="p-1 text-center"><a class="btn btn-danger btn-sm rounded-0" onclick="rem_item($(this))">X</a>'+inputs.html()+'</td>')
    //tr.append('<td class="p-1 text-center"><input class="w-100 text-center" type="number" name="quantity[]" value="'+$data.stocks+'"/></td>')
    //tr.append('<td class="p-1 text-center">'+$data.stocks+'</td>')
    //tr.append('<td class="p-1"><p class="truncate-1">'+$data.prodName+'</p></td>')
    //tr.append('<td class="p-1 text-end">'+(parseFloat($data.price).toLocaleString('en-US'))+'</td>')
    //tr.append('<td class="p-1 text-end total-price">'+(parseFloat($data.price * $data.stocks).toLocaleString('en-US'))+'</td>')
    tr.append('</tr>')
    $('#item-list tbody').append(tr)
    
    calc_total()
    tr.find('input[name="quantity[]"]').on('input keypress',function(){
        calc_total()
    })
}
     </script>