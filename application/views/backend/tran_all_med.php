<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
?>
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Manage Transfer History</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item ">Manage Transfer History</li>
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
                                <h4 class="m-b-0 text-white">Manage Transfer History <span class="pull-right"><?php date_default_timezone_set("Asia/Kolkata"); echo date("l jS \of F Y h:i:s A") ?></span></h4>
                            </div>                            
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="example234" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Supplier Name</th>
                                                <th>Batch Number</th>
                                                <th>Expire Date</th>
                                                <th>Purchase Rate</th>
                                                <th>MRP</th>
                                                <th>Qty</th>
                                                <th>Net Amount</th>
                                                <th>Tax</th>
                                                <th>Created</th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            foreach($transfer as $val){
                                                $CI     = & get_instance();
                                                $get_prduct_name = $CI->get_prduct_name($val->product_id);
                                                $supplier_name = $CI->supplier_name($val->supplier_id);
                                                $net_amt = ($val->purchase_rate * $val->instock);
                                                ?>
                                            <tr>
                                                <td><?php echo $get_prduct_name[0]->product_name; ?></td>
                                                <td><?php echo $supplier_name[0]->s_name; ?></td>
                                                <td><?php echo $val->Batch_Number; ?></td>
                                                <td><?php echo $val->expire_date;?></td>
                                                
                                                <td><?php echo $val->purchase_rate; ?></td>
                                                <td><?php echo $val->mrp; ?></td>
                                                <td><?php echo $val->instock; ?></td>
                                                <td><?php echo $net_amt; ?></td>
                                                <td><?php echo $val->tax; ?></td>
                                                <td><?php echo date("d-m-Y", $val->createdat); ?></td> 
                                              
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