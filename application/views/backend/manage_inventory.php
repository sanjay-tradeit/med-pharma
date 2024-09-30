<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
?>
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Manage Transfer Inventory</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item ">Manage Transfer Inventory</li>
                    </ol>
                </div>
            </div>
            <div class="container-fluid">

                <div class="row m-b-10"> 
                    <div class="col-12">
                        <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url()?>Invantory/transfer_inventory" class="text-white"><i class="" aria-hidden="true"></i> Add Tranfer Inventory</a></button>
                        <!-- <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url()?>Invantory/manage_inventory" class="text-white"><i class="" aria-hidden="true"></i> Manage Tranfer Inventory </a></button> -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">                                
                                <h4 class="m-b-0 text-white">Manage Transfer Inventory <span class="pull-right"><?php date_default_timezone_set("Asia/Kolkata"); echo date("l jS \of F Y h:i:s A") ?></span></h4>
                            </div>                            
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="example5665" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Stock Transfer Id</th>
                                                <th>Store Name</th>
                                                 
                                                <th>Net Amount</th>
                                                <th>Tax</th>
                                                <!-- <th>Total Amount </th> -->
                                                <th>Created </th>
                                               
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            foreach($transfer as $val){
                                                $CI     = & get_instance();
                                                $get_store_name = $CI->get_store_name($val->store_id);
                                               // print_r($get_store_name);
                                               $storename =   $CI->get_store_name($val->store_id);
                                                // print_r($storename);
                                                if($storename == null)
                                                {
                                                    $strname = '';
                                                }
                                                else {
                                                    $strname = $storename[0]->store_name;
                                                }
                                                ?>
                                            <tr>
                                                <td><?php echo $val->stock_transfer_id; ?></td>
                                                <td><?php echo $strname; ?></td>
                                                <!-- <td><?php // echo $val->instock; ?></td> -->
                                                <td><?php echo $val->net_amount; ?></td>
                                                <td><?php echo $val->total_tax; ?></td>
                                                <!-- <td><?php echo $val->total_amount; ?></td> -->
                                                <td><?php echo date("d-m-Y", $val->createdAT); ?></td>                                             
                                              
                                              
                                                <td class="jsgrid-align-center ">
                                                   <!-- <a href="javascript:void(0);" id="invoId" title="Print Invoice" class="btn btn-sm btn-info waves-effect waves-light invoId" data-id=""><i class="fa fa-print"></i></a> -->
                                                   <a target="_blank"href="<?php echo base_url(); ?>Invantory/tran_all_med/<?php echo $val->stock_transfer_id ;?>" id="invoId" title="View" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-history"></i></a> 
                                                </td>
                                            </tr>
                                            <?php  } ?>
                                          
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
    $("#example5665").on("click", ".invoId", function(e){
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
    <script>
    $(document).ready(function() {
$('#example5665').dataTable( {
        // "aaSorting": [[3,'desc']],
         "ordering": false,
            dom: 'Bfrtip',
            buttons: [
                            {
                                extend: 'copy',
                                title: 'Transfer Inventory List'
                            },
                            {
                                extend: 'excel',
                                title: 'Transfer Inventory List'
                            },
                            {
                                extend: 'pdf',
                                title: 'Transfer Inventory List'
                            },
                            {
                                extend: 'print',
                                title: 'Transfer Inventory List'
                            }
                        ]
    });
        });
</script>                   
 <?php 

    $this->load->view('backend/footer');

?>