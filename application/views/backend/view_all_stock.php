<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
    $CI     = & get_instance();
?>
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Stock Information</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item ">Stock Information</li>
                    </ol>
                </div>
            </div>
        
            <div class="container-fluid">
                <div class="row m-b-10"> 
                    <div class="col-12">
                    <?php if($this->session->userdata('user_type') =='SALESMAN'){ ?>
                        <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url();?>Invantory/Request_stock" class="text-white"><i class="" aria-hidden="true"></i> Request Medicine Stock</a></button>
                        <?php } else { ?> 
                            <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url();?>invantory/stock" class="text-white"><i class="" aria-hidden="true"></i> Add Medicine Stock</a></button>
                            
                            <?php } ?>                        
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url();?>invantory/Stock_out" class="text-white"><i class="" aria-hidden="true"></i> Out of Stock </a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url();?>invantory/Stock_expire_soon" class="text-white"><i class="" aria-hidden="true"></i> Soon Expire </a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url();?>invantory/Stock_expired" class="text-white"><i class="" aria-hidden="true"></i> Expired Medicine</a></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"> Stock Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Supplier Name</th>
                                                <th>Batch No.</th>
                                                <th>Stock</th>
                                                <th>Store</th>
                                                <!-- <th>Action</th> -->
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                         <?php 
                                           foreach($stock as $val){ 
                                            $store = $CI->get_store_name($val->store_id);
                                            $pro_name = $CI->get_pro_name($val->product_id);
                                            $supp_name = $CI->get_supplier_name($val->supplier_id);
                                           // print_r($pro_name[0]->product_name);
                                           
                                            ?>                                     
                                            <tr>
                                                <td> <?php echo $pro_name[0]->product_name ?></td>
                                                <td> <?php echo $supp_name[0]->s_name; ?></td>
                                                <td> <?php echo $val->Batch_Number; ?></td>
                                                <td> <?php echo $val->instock; ?></td>
                                                <td> <?php echo $store[0]->store_name; ?></td>
                                                <!-- <td class="jsgrid-align-center ">
                                                   <a target="_blank"href="<?php echo base_url(); ?>" id="invoId" title="View" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-history"></i></a> 
                                                </td> -->
                                            </tr>
                                            <?php }?>
                                           
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
         
<?php 

    $this->load->view('backend/footer');

?>