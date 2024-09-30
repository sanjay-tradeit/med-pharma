<?php
$this->load->view('backend/header');
$this->load->view('backend/sidebar');
?>
<div class="page-wrapper">
    <style>
        .table td,
        .table th {
            border-color: #f7f5f5;
        }
        input.append-checkbox {
    position: unset !important;
    opacity: 1 !important;
}
input#delete_btn {
    color: red;
}
    </style>
    <div class="container-fluid p-t-10">
        <div class="row m-b-10">
            <div class="col-12">
                <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>add_grn" class="text-white"><i class="" aria-hidden="true"></i> Add GRN </a></button>
              
            </div>
        </div>
       
        <div class="flashmessage"></div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                    <h4 class="m-b-0 text-white">New GRN <span class="pull-right date-display"><?php date_default_timezone_set("Asia/Kolkata");
                                                                                                    echo date("l jS \of F Y h:i:s A") ?></span></h4>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo base_url(); ?>edit_grn" method="post"> 
                        <div class="pur_inputs">
                      
                            <div class="row">
                                <!-- <div class="col-md-3">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">Store Name</label>
                                        <input type="text" class="form-control supplier_name" name="store_name" placeholder="Store Name" id="store_name"  autocomplete="off">
                                    </div>
                                </div> -->
                                <div class="col-md-2">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">Purchase No. </label>
                                        <input type="text" name="po_no" id="po_no" class="form-control" placeholder="Purchase No."  autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">Supplier Name</label>
                                        <input type="text" class="form-control" placeholder="Supplier Name" name="supplier_name" id="supplier_name"  autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">Order Type</label>
                                        <textarea type="text" name="order_type" id="order_type" class="form-control"  placeholder="Order Type" cols="8"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">Supplier Code</label>
                                        <input type="text" class="form-control supplier_name" name="supplier_code"  id="supplier_code" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">GRN NO.</label>
                                        <input type="text" name="grn_no" id="grn_no" class="form-control" placeholder="GRN No" autocomplete="off" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                               
                                <div class="col-md-2">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">DC No.</label>
                                        <input type="text" class="form-control" placeholder="DC No." name="dc_no" id="dc_no"  autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">DC Date</label>
                                        <textarea type="text" name="dc_date" class="form-control" id="dc_date"   rows="1" cols="8"></textarea>
                                    </div>
                                </div>
                            
                                <div class="col-md-2">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">Bill No.</label>
                                        <input type="text" class="form-control supplier_name" name="bill_no" id="bill_no"  autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">Bill Date</label>
                                        <input type="text" name="bill_date" id="bill_date" class="form-control" placeholder="Bill Date"  autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">Bill Amount</label>
                                        <input type="text" class="form-control " placeholder="Bill Amount" name="bill_amt" id="bill_amt"  autocomplete="off">
                                    </div>
                                </div>

                            </div>

                            <table class="table table-bordered m-t-5 pos_table  purchase">
                                <thead>
                                    <tr>
                                    <th>Item Code</th>
                                        <th style="width:15%">Medicine Name</th>
                                        <th>Generic Name</th>                                   
                                        <th>Batch No</th>
                                        <th>Exp. Date</th>
                                        <th>Pur. Val</th>
                                        <!-- <th>Tax</th> -->
                                        <th>SCH No</th>
                                        <th>SCH Date</th>
                                        <th>Ordered Qty</th>
                                        <th>Received Qty</th>
                                        <th>Total Value</th>
                                        <th></th>
                                        <!-- <th>Add Batch</th>
                                        <th>Action</th> -->
                                    </tr>
                                </thead>
                                <tbody id="append">
                                 </tbody>
                            </table>

                        </div>
                        <div id="append_submit_btn">
                        
                          </div>
                       
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
$(document).ready(function(){
    var url = $(location).attr('href');
    var segments = url.split( '/' );
    var id = segments[6];
    var grn_no = $('#grn_no').val();
    vdata = {id:id};
    $.ajax({
           url: "<?php echo base_url(); ?>Purchase/get_edit_grn",
            type: "post",
            data: vdata,
            dataType: 'json',
            success:function(data){
               if(data){
                $.each(data, function(index, val) {
                 
                   $('#store_name').val(val.store_name);
                   $('#po_no').val(val.po_no);
                   $('#supplier_name').val(val.supplier_name);
                   $('#order_type').val(val.order_type);
                   $('#supplier_code').val(val.supplier_code);
                   $('#grn_no').val(val.grn_no);
                   $('#dc_no').val(val.dc_no);
                   $('#dc_date').val(val.dc_date);
                   $('#bill_no').val(val.bill_no);
                   $('#bill_date').val(val.bill_date);
                   $('#bill_amt').val(val.bill_amt);
                   $('#supplier_code').val(val.supplier_code);
                   $('#bill_no').val(val.bill_no);
                   var sid = $('#supplier_code').val();
                   var grn_no = $('#grn_no').val();
                   console.log(grn_no);
                   console.log(supplier_code);
                   
                   $.ajax({
                       url: "<?php echo base_url(); ?>Purchase/get_supplier_name",
                       type: "post",
                       data: { sid: sid },
                       dataType: 'json',
                       success: function(data) {
                           $.each(data, function(index, val) {                         
                               $('#supplier_name').val(val.s_name);
                               add_data(grn_no);
                               result = false;
                               return;
                           });

                       }
                   });
               });
               }else{
                console.log("empty");
               }
            }
    });
   
    });
    </script>


<script>
    $("#po_no").keyup(function() {
     //alert("hello");
        var po_no = $('#po_no').val();
       
        vdata = { po_no: po_no };
        var result;
        $.ajax({
            url: "<?php echo base_url(); ?>Purchase/get_grn_data",
            type: "post",
            data: vdata,
            dataType: 'json',
            success: function(data) {
                $.each(data, function(index, val) {
                    $('#bill_date').val(val.pur_date);
                    $('#bill_amt').val(val.gtotal_amount);
                    $('#supplier_code').val(val.sid);
                    $('#bill_no').val(val.invoice_no);
                    var sid = $('#supplier_code').val();
                    
                    $.ajax({
                        url: "<?php echo base_url(); ?>Purchase/get_supplier_name",
                        type: "post",
                        data: { sid: sid },
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(index, val) {                         
                            $('#supplier_name').val(val.s_name);
                            add_data(sid);
                            result = false;
                             return;
                            });
                        }
                    });
                });
            }
           
        });
    });
</script>


<script>
    function add_data(grn_no) {
        $.ajax({
            url: "<?php echo base_url(); ?>Purchase/get_edit_medicine_detail",
            type: "post",
            data: { grn_no: grn_no },
            dataType: 'html',
            success: function(data) {
                $('#append').html(data);
                $('#append_submit_btn').html('<input type="submit" id="sub_btn" value="Submit">');
            }
        });
    }
</script>


<script>
$(document).on("click", "#appended_check", function(){
 // var id =  $('#appended_check').val();
  var id = $(this).attr("data-id");

        $.ajax({
            url: "<?php echo base_url(); ?>Purchase/edit_append_medicine",
            type: "post",
            data: { grn_id: id },
            dataType: 'html',
            success: function(data) {
            $('#append').append(data);
            }
        });
});
</script>
<script>
$(document).on("click", "#delete_btn", function(){
    var id = $(this).attr("data-id");
    // alert(id);
    $(this).closest("tr").remove();
    vdata ={id:id};
    $.ajax({
    url :"<?php echo base_url(); ?>Purchase/delete_sub_grn",
    type : "post",
    data: vdata,
    success:function(data){
        console.log(data);
    }
    });
});
    </script>

<script>
$(document).on("click", "#sub_btn", function(){
    window.location = "https://browncrystal.com/mad-pharma/purchase/manage_grn";

});
</script>


<footer class="footer"> © <?php echo date("Y");?> Med Jacket</footer>
</div>
<?php
$this->load->view('backend/footer');
?>