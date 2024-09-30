<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
?>
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Stock</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item ">Stock</li>
                    </ol>
                </div>
            </div>
            <div class="container-fluid">

                <div class="row m-b-10"> 
                    <div class="col-12">
                    <?php if($this->session->userdata('user_type') =='SALESMAN'){ ?>
                        <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url();?>invantory/request" class="text-white"><i class="" aria-hidden="true"></i> Request Medicine Stock</a></button>
                        <?php } else { ?> 
                            <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url();?>purchase/create" class="text-white"><i class="" aria-hidden="true"></i> Add Medicine Stock</a></button>
                            
                            <?php } ?>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url();?>purchase/purchase" class="text-white"><i class="" aria-hidden="true"></i> Manage Medicine Stock </a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url();?>invantory/Stock_out" class="text-white"><i class="" aria-hidden="true"></i> Out of Stock </a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url();?>invantory/Stock_expire_soon" class="text-white"><i class="" aria-hidden="true"></i> Soon Expire </a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url();?>invantory/Stock_expired" class="text-white"><i class="" aria-hidden="true"></i> Expired Medicine</a></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Manage Medicine Stock </h4>
                                
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="example92" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Medicine Name</th>
                                                <th>Generic Name</th>
                                                <th>Supplier</th>
                                                <th>Batch No.</th>
                                                <th>Stock</th>
                                                <th>Sold</th>
                                                <th>Purchase Price</th>
                                                <th>MRP</th>
                                                <th>Expiry Date</th>
                                                <th>View Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php foreach($stock as $value):
                                        //    echo "<pre>";
                                        //    print_r($value);
                                            $CI     = & get_instance();
                                            $store_id = $this->session->userdata('store_id');
                                           $get_received = $CI->get_receivedAllInv($value->product_id, $value->supplier_id, $value->Batch_Number);
                                        //    echo "<pre>";
                                         //print_r($get_received[0]->instock);
                                            $mrp = $value->mrp;
                                            $mrp1  = round($mrp, 2);
                                            ?>
                                            <tr>
                                                <td><?php echo $value->product_name?><?php if(!empty($value->strength)){echo "(".$value->strength.")";}else {}?></td>
                                                <td><?php echo $value->generic_name;  ?></td>
                                                <td><?php echo $value->s_name;  ?></td>
                                                <td><?php echo $value->Batch_Number;  ?></td>
                                                <!-- <td><?php echo $value->instock;  ?></td> -->
                                                <td><?php echo $get_received[0]->instock;  ?></td>
                                                <td><?php echo $value->sale_qty;  ?></td>
                                                <td><?php echo $value->purchase_rate;  ?></td>
                                                <td><?php echo $mrp1;  ?></td>
                                                <td><?php echo $value->expire_date; //echo date("d-m-Y", strtotime($value->expire_date));  ?></td>
                                                <td class="jsgrid-align-center ">
                                                   <a target="_blank" href="<?php echo base_url(); ?>Invantory/view_all_stock/<?php echo $value->product_id;?>/<?php echo $value->supplier_id;?>/<?php echo str_replace(' ','_',$value->Batch_Number);  ?>" id="" title="View" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-history"></i></a> 
                                                </td>
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
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer"> © <?php echo date("Y");?> Med Jacket</footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>

        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->

        <script>
    $(document).ready(function() {
$('#example92').dataTable( {
        // "aaSorting": [[3,'desc']],
        //  "ordering": false,
            dom: 'Bfrtip',
            buttons: [
                            {
                                extend: 'copy',
                                title: 'Manage Stock (Main Store)'
                            },
                            {
                                extend: 'excel',
                                title: 'Manage Stock (Main Store)'
                            },
                            {
                                extend: 'pdf',
                                title: 'Manage Stock (Main Store)'
                            },
                            {
                                extend: 'print',
                                title: 'Manage Stock (Main Store)'
                            }
                        ]
    });
        });
</script> 
<?php 

    $this->load->view('backend/footer');

?>