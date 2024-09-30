<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
?>
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Stock Adjustment History</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item ">Stock Adjustment History</li>
                    </ol>
                </div>
            </div>
        
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Stock Adjustment History</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Request Id</th>
                                                 <th>Product Name</th>
                                                 <th>Adjusted Qty</th>
                                                 <th>Instock</th>
                                                 
                                                  
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                         <?php 
                                            foreach($history as $row)
                                            
                                            {
                                                $CI     = & get_instance();
                                                $product = $CI->get_pro_name($row->product_id);
                                                $totinstock = $row->adjus_qty + $row->pre_instock;
                                               
                                          
                                         ?>
                                            <tr>
                                                <td> <?php echo $row->adjus_id; ?></td>
                                                <td> <?php echo $product[0]->product_name; ?></td>
                                                <td> <?php echo $row->adjus_qty; ?></td>
                                                <td> <?php echo $totinstock; ?></td>
                                                
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
         
<?php 

    $this->load->view('backend/footer');

?>