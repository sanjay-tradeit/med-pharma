<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
?>
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Transaction History</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item ">Transaction History</li>
                    </ol>
                </div>
            </div>
            <!-- Container fluid  -->
            <!-- ============================================================== -->
        
            <div class="container-fluid">

                <div class="row m-b-10"> 
                    <div class="col-12">
                        <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="#" class="text-white"><i class="" aria-hidden="true"></i> Add Purchase</a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url()?>purchase/purchase" class="text-white"><i class="" aria-hidden="true"></i> Manage Purchase </a></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Transaction History</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="example234" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
<!--                                                <th>ID </th>
                                                <th>Purchase ID</th>-->
                                                <th>Supplier </th>
                                                <th>Medicine </th>
                                                <th>Strength </th>
                                                <th>Batch no. </th>
                                                <th>Expire Date </th>
                                                <th>Quantity </th>
                                                <th>Return Quantity </th>
                                                <th>Instock </th>
                                                <th>Purchase Price </th>
                                                <th>MRP </th>
                                                <th>Discount </th>
                                                <th>Tax</th>
                                                <th>Total Amount </th>
                                                <th>Grand Total(With Dis)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php foreach($purchasehistory as $value): 
                                           //print_r($value);
                                           $totqty = $value->qty + $value->free_qty;
                                           $remaining = $totqty - $value->return_qnty;
                                           
                                            if(empty($value->discount))
                                            {
                                               $dis = 0;
                                            }else{
                                                $dis =  $value->discount ; 
                                            }
                                            $totamt = $value->total_amount + $value->tax;
                                            $dis1 = ($value->total_amount * $dis)/100;
                                            ?>
                                            <tr>
                                                <td><?php echo $value->s_name; ?></td>
                                                <td><?php echo $value->product_name; ?></td>
                                                <td><?php echo $value->strength; ?></td>
                                                <td><?php echo $value->Batch_Number; ?></td>
                                                <td><?php  echo ($value->expire_date)//echo date("d-m-Y", strtotime($value->expire_date))//date('d/M/Y',$value->expire_date);  ?></td>
                                                <td><?php echo $totqty; ?></td>
                                                <td><?php echo $value->return_qnty; ?></td>
                                                <td><?php echo $remaining; ?></td>
                                                <td><?php echo $value->supplier_price; ?></td>
                                                <td><?php echo $value->mrp; ?></td>
                                                <td><?php echo $dis; ?></td>
                                                <td><?php echo $value->tax; ?></td>
                                                <td><?php echo $value->total_amount ?></td>
                                                <td><?php echo ($value->tax + $value->total_amount); ?></td>
                                            </tr>
                                            <?php endforeach; ?>
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