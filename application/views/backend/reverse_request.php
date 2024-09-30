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
                        <h4 class="m-b-0 text-white">Return Stock<span class="pull-right date-display"><?php date_default_timezone_set("Asia/Kolkata");
                                                                                                        echo date("l jS \of F Y h:i:s A") ?></span></h4>
                    </div>
                    <div class="card-body">

                        <form action="" method="post" class="form-horizontal" id="formid" accept-charset="utf-8">
                            <div class="pur_inputs add-purchase">

                                <div class="row align-items-center">
                                <div class="col-md-3">
                                        <div class="form-group" style="margin-bottom: 15px">
                                            <label class="control-label">Store</label>
                                            <select class="form-control" name="store" id="store">
                                                <option>Select Store </option>
                                                <?php
                                                foreach ($store as $row) { ?>
                                                    <option value="<?php echo $row->store_id; ?>"><?php echo $row->store_name; ?></option>
                                                <?php  }
                                                ?>
                                            </select>
                                            <input type = "hidden" name="store_id" id="store_id" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group" style="margin-bottom: 15px">
                                            <label class="control-label">Medicine</label>
                                            <select class="form-control" name="medicine" id="medicine" >
                                             
                                            </select>
                                        </div>
                                    </div>
                                 
                                </div>
                            </div>
                            <div id="append_med_history">
                            <div class="row pos-remove-spacing" id="top-data" style="display:none;">
                                <div class="col">
                                  <label class="control-label">Product Name</label>
                                </div>                                
                                <div class="col">
                                  <label class="control-label">Supplier Name</label>
                                </div>
                                <div class="col">
                                  <label class="control-label">Batch Number</label>
                                </div>
                                <div class="col">
                                  <label class="control-label">Expire Date</label>
                                </div>
                                <div class="col">
                                  <label class="control-label">Instock</label>
                                </div>
                                <div class="col">
                                  <label class="control-label">Request Qty</label>
                                </div>
                                <div class="col">
                                 
                                </div>
                            </div>
                            </div>
                            <table id="inventory" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Supplier Id</th>
                                        <th>Batch Number</th>
                                        <th>Expiry Date</th>
                                        <th>Qty</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="posinfo">

                                </tbody>
                            </table>
                            <input type="submit" id="save" value="Save" style="display: none;" />
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
$('#store').on('change', function() {
  var store_id = this.value;
  $('#store_id').val(store_id);
 vdata = {store_id: store_id};
  $.ajax({
            url: "<?php echo  base_url(); ?>/Invantory/append_medicine",
            type: "post",
            data: vdata,
            dataType: "json",
            success: function(data) {
                    var i=0;

                    //alert(data.length);
                    $('#medicine').empty().append();
                    
                    if (data.length > 0) {
                        $('#medicine').append($("<option>Select Medicine</option>"));
                        $.each(data, function(index, value) {
                            var pro_id = value[0];
                            var pro_name = value[1];
                            
                            $('#medicine').append($("<option></option>").attr("value", pro_id) .text(pro_name));
                            i++;
                            });

                    }
            }
        });

});
    </script>
<script>
    $('#medicine').on('change', function() {
        var med_id = this.value;
        var store_id = $('#store_id').val();
        vdata = { id: med_id,store_id: store_id };
        console.log(vdata);
        $.ajax({
            url: "<?php echo  base_url(); ?>/Invantory/fill_qty",
            type: "post",
            data: vdata,
            success: function(data) {
                $('#append_med_history').append(data);
                $('#top-data').show();
            }
        });
    });
</script>
<script>
    $(document).on("click", '#add_pos', function(e) {
        e.preventDefault()
        $(this).closest('.row').remove();
        var proid = $(this).closest('.row').find('#product_id').val();
        var supplier_id = $(this).closest('.row').find('#supplier_id').val();
        //var Batch_Number = $(this).closest('.row').find('#Batch_Number').val();
        var expire_date = $(this).closest('.row').find('#expire_date').val();
        var batchNumber = $(this).data("id");
        var qty = $(this).closest('.row').find('#req_qty').val();
        vdata = { proid: proid, qty: qty, batchNumber: batchNumber, expire_date: expire_date, supplier_id: supplier_id };
        console.log(vdata);
        $.ajax({
            url: "<?php echo base_url(); ?>Invantory/stock_rev_reg",
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

<script>
    $(document).ready(function() {
        $('#formid').submit(function(e) {
            $.ajax({
                url: "<?php echo base_url(); ?>Invantory/submit_rev_request",
                type: "post",
                data: $('#formid').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
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




<footer class="footer"> © <?php echo date("Y"); ?> Med Jacket</footer>
</div>

</div>
<?php
$this->load->view('backend/footer');
?>