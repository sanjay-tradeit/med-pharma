<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
    $CI     = & get_instance();
?>
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Reverse Requested Stock</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item ">Reverse Requested Stock</li>
                    </ol>
                </div>
            </div>
        
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Reverse Requested Stock</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Request Id</th>
                                                 <th>Product Name</th>
                                                 <th>Supplier Name</th>
                                                 <th>Batch No.</th>
                                                 <th>Expire Date</th>
                                                 <th>Qty</th>
                                                 <th>Store Name</th>
                                                 <th>Status</th>
                                                 
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                          <?php 
                                            foreach($history as $row) {
                                                
                                                $store = $CI->get_store_name($row->from_store_id);
                                                $product = $CI->get_prduct_name($row->product_id);
                                                $supplier = $CI->supplier_name($row->supplier_id);
                                               
                                            
                                            ?> 
                                            <tr>
                                                
                                                <td> <?php echo $row->request_id; ?></td>
                                                <td> <?php echo $product[0]->product_name ?> </td>
                                                <td> <?php echo $supplier[0]->s_name; ?></td>
                                                <td> <?php echo $row->Batch_Number; ?> </td>
                                                <td> <?php echo $row->expire_date; ?></td>
                                                <td> <?php echo $row->qty; ?></td>
                                                <td> <?php echo $store[0]->store_name; ?> </td>  
                                                <td> <?php  if($row->rev_status == 1)
                                                {
                                                echo "Approved";
                                                }
                                                else{
                                                    echo "Pending";
                                                }
                                                ; ?> 
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
         
<?php 

    $this->load->view('backend/footer');

?>