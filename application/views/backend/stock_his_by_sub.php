<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
?>
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Requested Stock History</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item ">Requested Stock History</li>
                    </ol>
                </div>
            </div>
        
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Requested Stock History</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Request Id</th>
                                                 <th>Product Name</th>
                                                 <th>Qty</th>
                                                 <th>Full Filled Qty</th>
                                                 <th>Action</th>
                                                  
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                         <?php 
                                            foreach($history as $row)
                                            
                                            {
                                                $CI     = & get_instance();
                                                $product = $CI->get_pro_name($row->product_id);
                                                $check_stock = $CI->check_status($row->request_id, $row->product_id);
                                                $status = $row->status;//$check_stock[0]->status;
                                               
                                          
                                         ?>
                                            <tr>
                                                <td> <?php echo $row->request_id; ?></td>
                                                <td> <?php echo $product[0]->product_name; ?></td>
                                                <td> <?php echo $row->request_qty; ?></td>
                                                <td> <?php echo $row->full_fill_qty; ?></td>
                                                <td>  <?php if($status == ''){ echo "Pending";  } else{ echo "Approved";} ?></td>
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