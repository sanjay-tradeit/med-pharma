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
    </style>
    <div class="container-fluid p-t-10">
        <div class="row m-b-10">
            <div class="col-12">
                <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Purchase/manage_grn" class="text-white"><i class="" aria-hidden="true"></i> Manage GRN </a></button>
              
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
                        <form action="" method="post" id='ReviewForm'> 
                        <div class="pur_inputs add-purchase">
                          
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">Purchase No. </label>
                                        <input type="text" name="po_no" id="po_no" class="form-control" placeholder="Purchase No." autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">Supplier Name</label>
                                        <input type="text" class="form-control" placeholder="Supplier Name" name="supplier_name" id="supplier_name" autocomplete="off" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">Order Type</label>
                                        <input type="text" name="order_type" id="order_type" class="form-control" placeholder="Order Type" cols="8">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">Supplier Code</label>
                                        <input type="text" class="form-control supplier_name" name="supplier_code" placeholder="Supplier Code" id="supplier_code" autocomplete="off" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                               <?php $grnno   =   'GRN'.rand(2000,10000000); ?>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">GRN NO.</label>
                                        <input type="text" name="grn_no" id="grn_no" class="form-control" placeholder="GRN No" value="<?php echo $grnno; ?>"  autocomplete="off" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">DC No.</label>
                                        <input type="text" class="form-control" placeholder="DC No." name="dc_no" id="dc_no" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">DC Date</label>
                                        <input type="date" name="dc_date" class="form-control" id="dc_date">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">Bill Date</label>
                                        <input type="text" name="bill_date" id="bill_date" class="form-control" placeholder="Bill Date" autocomplete="off" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">Bill No.</label>
                                        <input type="text" class="form-control supplier_name" name="bill_no" id="bill_no" placeholder="BILL no." autocomplete="off" readonly>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">Bill Amount</label>
                                        <input type="text" class="form-control " placeholder="Bill Amount" name="bill_amt" id="bill_amt" autocomplete="off" readonly>
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
                                        <th>Tax</th>
                                        <th>SCH No</th>
                                        <th>SCH Date</th>
                                        <th>Ordered Qty</th>
                                        <th>Pending</th>
                                        <th>Received Qty</th>
                                        <th>Total Value</th>
                                        <!-- <th>Received Value</th>
                                        
                                        <th>Total Dues</th> -->
                                        <!-- <th></th>
                                        <th>Add Batch</th> -->
                                    </tr>
                                </thead>
                                <tbody id="append">
                                 </tbody>
                            </table>

                        </div>
                        <div id="append_submit_btn">
                              <!-- <input type="Submit"> -->
                          </div>
                       
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
      //  $(document).ready(function () {
            $(document).on("click", "#sub_btn", function(){
   
             // alert("elo");
        //    event.preventDefault();
        var formval = $('#ReviewForm')[0];
           var data = new FormData(formval);
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "<?php  echo base_url();?>Purchase/save_grn",
                dataType: 'json',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
            success: function(response) {
              if(response.status == 'error') { 
              $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);
              }
               else if(response.status == 'success'){
                  $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);
                    window.setTimeout(function() {
                    window.location = response.curl;
                }, 2000);
              }              
          },
          error: function(response) {
            console.error();
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
        $('#po_no').keypress(function(e) {
        if(e.which === 32) {
            return false;
        }
    });
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
                    $('#store_name').val(val.store_id);
                    $('#bill_no').val(val.invoice_no);
                    var sid = $('#supplier_code').val();
                    var sid = $('#supplier_code').val();
                    var storeid = $('#store_name').val();
                   
                    $.ajax({
                        url: "<?php echo base_url(); ?>Purchase/get_supplier_name",
                        type: "post",
                        data: {
                            sid: sid
                        },
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
    function add_data(po_no) {
        var po_no = $('#po_no').val();
        $.ajax({
            url: "<?php echo base_url(); ?>Purchase/get_medicine_detail",
            type: "post",
            data: { po_no: po_no },
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
  var sid =  $('#appended_check').val();
  $.ajax({
            url: "<?php echo base_url(); ?>Purchase/append_medicine",
            type: "post",
            data: { sid: sid },
            dataType: 'html',
            success: function(data) {
                $('#append').append(data);
            }
        });
});
</script>






<footer class="footer"> © <?php echo date("Y");?> Med Jacket</footer>
</div>
<?php
$this->load->view('backend/footer');
?>