<style>
    #uni_modal .modal-footer{
        display:none !important
    }
</style>
<div class="container-fluid">
    <div class="form-group">
        <label class="fs-4">Payable Amount</label>
        <input type="text" class="form-control form-control-lg text-end fs-4" id="gTotal" value="<?php echo number_format($_GET['total'],2) ?>" readonly>
    </div>
    <div class="form-group">
        <label class="fs-4">Tendered Amount</label>
        <input type="text" class="form-control form-control-lg text-end fs-4" id="t" value="0">
    </div>
    <div class="form-group">
        <label class="fs-4">Change</label>
        <input type="text" class="form-control form-control-lg text-end fs-4" id="c" value="0" readonly>
    </div>
    <div class="col-12">
        <div class="row justify-content-end mt-3">
            <button class="btn btn-sm rounded-0 btn-primary me-2 col-auto" type="button" id="submit_sales">Save</button>
            <button class="btn btn-sm rounded-0 btn-dark col-auto me-3" type="button" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#uni_modal').on('shown.bs.modal',function(){
            $('#t').focus()
            document.execCommand("selectAll", false, null)
        })
        $('#t').on('input',function(){
            var tender = $(this).val()
            var change = 0;
            change = parseFloat(tender) - parseFloat("<?php echo $_GET['total'] ?>")
            $('#c').val(parseFloat(change).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
            $('[name="amount_change"]').val(parseFloat(change).toFixed(2))
            $('[name="amount_tendered"]').val(parseFloat(tender))
        })
        $('#submit_sales').click(function(){
            save_transaction()
        })
        
    })
    function save_transaction(){
        $('#c').removeClass('border-danger')
        var tender = $('#t').val()
        var change = $('#c').val()
            change = change.replace(/,/gi,'')
        if(change < 0){
            $('#c').addClass('border-danger')
        }else{
            $('#uni_modal').modal('hide')
            $('#pos-form').submit()
        }
    }
</script>
