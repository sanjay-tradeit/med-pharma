<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
?>
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Requested Stock History</h3>
                </div>
                <div class="flashmessage"></div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item ">Requested Stock History</li>
                    </ol>
                </div>
            </div>
            <div class="container-fluid">

                <div class="row m-b-10"> 
                    <div class="col-12">
                        <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url()?>Invantory/transfer_inventory" class="text-white"><i class="" aria-hidden="true"></i> Transfer Inventory</a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url()?>Invantory/manage_inventory" class="text-white"><i class="" aria-hidden="true"></i> Manage Transfer Inventory </a></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">                                
                                <h4 class="m-b-0 text-white">Requested Stock History <span class="pull-right"><?php date_default_timezone_set("Asia/Kolkata"); echo date("l jS \of F Y h:i:s A") ?></span></h4>
                            </div>                            
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="example234" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Request Id</th>
                                                <th>Product Name</th>
                                                <th>Generic Name</th>
                                                <th>Requested Qty</th>
                                                <th>Full_Fill Qty</th>
                                                <th>Created</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            //print_r($transfer);
                                            foreach($transfer as $val){
                                              
                                                $CI     = & get_instance();
                                                $get_prduct_name = $CI->get_prduct_name($val->product_id);
                                                $get_generic = $CI->get_generic($val->product_id);
                                                $check_stock = $CI->check_status($val->request_id, $val->product_id);
                                                $status = $val->status;//$check_stock[0]->status;
                                               

                                               
                                                ?>
                                            <tr>
                                                <td><?php echo $val->request_id; ?></td>
                                                <td><?php echo $get_prduct_name[0]->product_name; ?></td>
                                                <td> <?php echo $get_generic[0]->generic_name ?></td>
                                                <td><?php echo $val->request_qty; ?></td>
                                                <td><?php echo $val->full_fill_qty; ?></td>
                                                <td><?php echo $val->createdat; ?></td>
                                                <td> 
                                                    <?php
                                                           if($status == "returned"){?>Approved<?php  } else{?>
                                                            <a href="<?php echo base_url(); ?>Invantory/return_back_stock/<?php echo  $val->product_id; ?>/<?php echo $val->store_id; ?>/<?php echo $val->request_qty; ?>/<?php echo $val->request_id; ?>">Transfer</a>
                                                        <?php   }
                                                    ?>
                                                  
                                                </td>
                                            </tr>
                                            <?php } ?>
                               
                                          

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        </div>
            <footer class="footer"> © <?php echo date("Y");?> Med Jacket</footer>
        </div>
<!--Invoice and print view Modal-->
<div class="modal fade" id="invoicemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="75%" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <img src="<?php echo base_url(); ?>assets/images/80X80-coloured.png" height="80" width="110" style="margin-left:330px" alt="homepage" class="dark-logo" />
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="invoicedom">

      </div>
      <div class="modal-footer">
        <div class='text-right'>
            <input id='print' class='btn btn-default btn-outline print' type='submit' value='Print'>
        </div>
      </div>
    </div>
  </div>
</div>  
<script>
    $(document).on("click", '#approveMed', function(e) {
        e.preventDefault();

        var req_id = $(this).data('med-req');
        var pro_id = $(this).data('pro-id');
        var demand = $(this).data('med-qnty');
        var to_store = $(this).data('store-id');
        // var medBth = $(this).data('med-batch');

        rdata = { req_id: req_id, pro_id: pro_id, demand: demand, to_store: to_store };
       
        $.ajax({
            url: "<?php echo base_url(); ?>Invantory/return_stock",
            type: "POST",
            dataType: 'json',
            data: rdata,
            success: function(response) {
                console.log(response);
                if (response.status == 'success') {
                        $(".flashmessage").fadeIn('fast').delay(2000).fadeOut('fast').html(response.message);
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
<script type="text/javascript">
          $(document).ready(function () {
           $("#example234").on("click", ".invoId", function(e){
            //$(".invoId").click(function(e){
                
                e.preventDefault(e);
                // Get the record's ID via attribute  
                var iid = $(this).attr('data-id');
                console.log(iid);
                $('#smodel').trigger("reset");
                $('#invoicemodal').modal('show'); 
                $.ajax({
                    url: '<?php echo base_url();?>Supplier/GetSupplierInvoice?id=' + iid,
                    method: 'GET',
                    data: 'html',
                    dataType: '',
                }).done(function (response) {
                    console.log(response);
                    $('#invoicedom').html(response);
                });
            });
        });   

            </script>
<script>
    $(document).ready(function() {
        $("#print").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div#invoicedom").printArea(options);
        });
    });
    </script>                      
 <?php 

    $this->load->view('backend/footer');

?>