<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
?>
        <div class="page-wrapper">

            <div class="row page-titles">

                <div class="col-md-5 align-self-center">

                    <h3 class="text-themecolor">Report</h3>

                </div>

                <div class="col-md-7 align-self-center">

                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>

                        <li class="breadcrumb-item ">Report</li>

                    </ol>

                </div>

            </div>

            <div class="container-fluid">



                <div class="row m-b-10"> 

                    <div class="col-12">

                    </div>

                </div>

                <div class="row">

                    <div class="col-12">

                        <div class="card card-outline-info">

                            <div class="card-header">

                                <h4 class="m-b-0 text-white">  Invoice Details</h4>

                            </div>

                            <div class="card-body">

                                <div class="table-responsive ">

                                    <table id="" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">

                                        <thead>

                                            <tr>
                                                <th>Medicine Name</th>
                                                <th>QTY</th>
                                                <!-- <th>Total Price</th> -->
                                                <th>Purchase Price</th>
                                                <th>Sale Price</th>
                                                <th>Profit</th>

                                            </tr>

                                        </thead>

                                        <!-- <tfoot>

                                            <tr>

                                                <th>Medicine Name</th>

                                                <th>QTY</th>
                                                <th>Total Price</th>
                                                <th>Discount</th>
                                            </tr>

                                        </tfoot> -->

                                        <tbody>
                                            <?php $totalprofit = 0; ?>
                                           <?php foreach($invoice_details as $value): 
                                           
                                            $CI     = & get_instance();
                                            $result = $CI->Getperunitpur($value->mid,$value->Batch_Number);
                                            $result1 = $CI->Getmedname($value->mid);
                                            $productname = $result1[0]->product_name;
                                            if($result){
                                            $perunit = $result[0]->actual_purrate;
                                            }
                                            else{
                                                $perunit = ' ';
                                            }
                                            $totpurprice = $value->qty * $perunit; 
                                            $totprofit = $value->total_amount - $totpurprice;
                                            $totalprofit += $totprofit;
                                            ?>
                                             
                                            <tr>

                                                <td><?php echo $productname; ?></td>

                                                <td><?php echo $value->qty; ?></td>
                                                <!-- <td><?php echo $value->total_amount; ?></td> -->
                                                <td><?php echo $totpurprice; ?></td>
                                                <td><?php echo $value->total_amount; ?></td>
                                                <td><?php echo $totprofit; ?></td>

                                            </tr>

                                            <?php endforeach; ?>
                                            <tr>
                                             <td></td>
                                             
                                             <td></td>
                                             <td></td>
                                             <td><b>Grand Total</b></td>
                                             <td><b><?php echo $totalprofit; ?></b></td>                                           
                                          </tr>
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