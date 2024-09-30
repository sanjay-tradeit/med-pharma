<?php
$this->load->view('backend/header');
$this->load->view('backend/sidebar');
?>
<div class="page-wrapper">

    <div class="container-fluid p-t-10">
        <div class="row m-b-10">
        </div>
        <div class="flashmessage"></div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Transfer Inventory<span class="pull-right date-display"><?php date_default_timezone_set("Asia/Kolkata");
                                                                                                        echo date("l jS \of F Y h:i:s A") ?></span></h4>
                    </div>
                    <div class="card-body">

                        <form action="" method="post" class="form-horizontal" id="formid" accept-charset="utf-8">
                            <div class="pur_inputs add-purchase">

                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <div class="form-group" style="margin-bottom: 15px">
                                            <label class="control-label">Store Name</label>
                                            <select class="form-control" name="store" id="store">
                                                <option>Select Store  </option>
                                                        <?php 
                                                            foreach($store as $row){?>
                                                             <option value="<?php echo $row->id; ?>"><?php echo $row->store_name; ?></option>
                                                           <?php  }
                                                        ?>
                                             </select>
                                             <input type ="hidden" id="store_id">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group" style="margin-bottom: 15px">
                                            <label class="control-label">Select Medicine</label>
                                            <select class="form-control" name="medicine" id="medicine">
                                            <option>Select Medicine</option>
                                                        <?php 
                                                            foreach($medicine as $row){?>
                                                             <option value="<?php echo $row->product_id; ?>"><?php echo $row->product_name; ?></option>
                                                           <?php  }
                                                        ?>        
                                        </select>
                                        </div>
                                    </div>
                                    <div id="stock" style="display:none"><th> GRN Not Added</th></div>
                                </div>
                            </div>
                            <div id="append_med_history">
                            <div class="row pos-remove-spacing" id="top-data" style="display:none;">
                                <div class="col-md-2">
                                  <label class="control-label">Batch Number</label>
                                </div>                                
                                <div class="col-md-2">
                                  <label class="control-label">Exp Date</label>
                                </div>
                                <div class="col-md-2">
                                  <label class="control-label">Total Qty</label>
                                </div><div class="col-md-2">
                                  <label class="control-label">Transfer Qty</label>
                                </div>
                            </div>
                            </div>
                            <table id="inventory" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Purchase Price(With Tax)</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="posinfo">

                                     </tbody>
                            </table>
                           <input type = "submit" id="save" value="Save" style="display: none;"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on("click","#btn",function() {
      $(this).closest('tr').remove();
});
</script> 
<script>
$(document).ready(function(){
    $('#formid').submit(function(e){
       $.ajax({
        url: "<?php echo base_url();?>Invantory/submit_stock_transfer15",
        type:"post",
        data: $('#formid').serialize(),
        dataType:'json', 
        success: function(response){
            if(response.status == 'success') {
               $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);
               window.setTimeout(function() {
                 window.location = response.curl;
              }, 2000);
              $("#submit_btn").attr("disabled", true); 
              }
        }
       });
    })
  
});
</script>
<script>
$('#store').on('change', function() {
    var store_id = this.value;
   // alert(store_id);
    $('#store_id').val(store_id);

});
    </script>
<script>
$('#medicine').on('change', function() {
    var med_id = this.value;
    var store_id = $('#store_id').val();
  
    vdata = {id:med_id, store_id:store_id};
 $.ajax({
  url : "<?php echo  base_url(); ?>/Invantory/get_med15",
  type : "post",
  data : vdata,
  success : function(data){
    //console.log(data);
    if(data=='')
    {
        $('#stock').show();
    }
    else{
         $('#append_med_history').append(data);
         $('#top-data').show();
    }
  
  }

 });
});
</script>

<script>
    $(document).on("click", '#add_pos', function(e) {
        e.preventDefault()
        $(this).closest('.row').remove();
    var batchNumber = $(this).data("id");
    
    var store_id = $(this).closest('.row').find('#store_id').val();
    var qty = $(this).closest('.row').find('#req_qty').val();
    var proid = $(this).closest('.row').find('#product_id').val();
    var exp_date = $(this).closest('.row').find('#exp_date').val();
    var mrp = $(this).closest('.row').find('#mrp').val();

       vdata = {proid: proid, qty:qty, batchNumber: batchNumber, exp_date:exp_date, mrp: mrp, store_id:store_id};
       console.log(vdata);
       $.ajax({
        url: "<?php echo base_url(); ?>Invantory/add_transfer_stock",
        type: "POST",
        dataType: 'html',
        data: vdata,
        success: function(response) {
          $("#posinfo").append(response);
          $('#save').show();
      
        },
        error: function(response) {
          console.error();
        }
      });
    });
    </script>



<footer class="footer"> © <?php echo date("Y"); ?> Med Jacket</footer>
</div>

</div>
<?php
$this->load->view('backend/footer');
?>