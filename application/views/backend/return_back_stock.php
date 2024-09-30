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
                            
                            <div  style="text-align:center" ><h4 >Demand<span>=<?php  echo $this->uri->segment(5); ?></span></h4></div>
                                                  
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <form action="" method="post" id="formid">
                                    <input type="hidden" value="<?php echo $this->uri->segment(4) ?>" name="to_store">
                                    <input type="hidden" value="<?php echo $this->uri->segment(6) ?>" name="req_id">
                                    <table id="example234" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Supplier Name</th>
                                                <th>Batch No.</th>
                                                <th>Expire date</th>
                                                <th>Instock</th>
                                                <th>Transfer</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        <?php  foreach($stock as $val){ ?>
                                            <tr>
                                              
                                                <td><input type="text" value="<?php echo $val->product_id; ?>" name="pro_id[]" readonly></td>
                                                <td><input type="text" value="<?php echo $val->supplier_id; ?>" name="supplier_id[]" readonly></td>
                                                <td><input type="text" value="<?php echo $val->Batch_Number; ?>" name="batch[]" readonly></td>
                                                <td><input type="text" value="<?php echo $val->expire_date; ?>" name="exp_date[]" readonly></td>
                                                <td><input type="text" value="<?php echo $val->instock; ?>" name="stock[]" readonly></td>
                                                <td><input type="text" name="return[]"></td>
                                            </tr>
                                          <?php }?>
                               
                                          
                                        </tbody>
                                    </table>
                                    <div id="sbt_btn" style="text-align:center"><input  class="btn btn-info" type="submit"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        </div>
            <footer class="footer"> © <?php echo date("Y");?> Med Jacket</footer>
        </div>
 
        <script>
$(document).ready(function(){
    $('#formid').submit(function(e){
       $.ajax({
        url: "<?php echo base_url();?>Invantory/submit_return_stock",
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

                    
 <?php 

    $this->load->view('backend/footer');

?>