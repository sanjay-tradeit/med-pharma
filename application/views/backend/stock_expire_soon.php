<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
?>
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Expire Soon</h3>
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
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url();?>invantory/Stock_out" class="text-white"><i class="" aria-hidden="true"></i> Out of Stock </a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url();?>invantory/Stock_short" class="text-white"><i class="" aria-hidden="true"></i> Short Stock </a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url();?>invantory/Stock_expired" class="text-white"><i class="" aria-hidden="true"></i> Expired Medicine</a></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Expire Soon</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="example3434" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Medicine Name</th>
                                                <th>Generic Name</th>
                                                <th>Supplier</th>
                                                <th>Strength</th>
                                                <th>Stock</th>
                                                <th>Batch No.</th>
                                                <th>Expiry Date</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                
                                           <?php foreach($expiresoonmedicine as $value):?>
                                            <tr>
                                                <td><?php echo $value->product_name?><?php if(!empty($value->strength)){echo "(".$value->strength.")";}else {}?></td>
                                                <td><?php echo $value->generic_name;  ?></td>
                                                <td><?php echo $value->s_name;  ?></td>
                                                <td><?php echo $value->strength;  ?></td>
                                                <td><?php echo $value->instock;  ?></td>
                                                <td><?php echo $value->Batch_Number;  ?></td>
                                                <td><?php echo date("d-m-Y", strtotime($value->expire_date));  ?></td>
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
        <script>
    $(document).ready(function() {
$('#example3434').dataTable( {
        // "aaSorting": [[3,'desc']],
         "ordering": false,
            dom: 'Bfrtip',
            buttons: [
                            {
                                extend: 'copy',
                                title: 'Stock Expire Soon Medicine List (Main Store)'
                            },
                            {
                                extend: 'excel',
                                title: 'Stock Expire Soon Medicine List (Main Store)'
                            },
                            {
                                extend: 'pdf',
                                title: 'Stock Expire Soon Medicine List (Main Store)'
                            },
                            {
                                extend: 'print',
                                title: 'Stock Expire Soon Medicine List (Main Store)'
                            }
                        ]
    });
        });
</script> 
<?php 

    $this->load->view('backend/footer');

?>