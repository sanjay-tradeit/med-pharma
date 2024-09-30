<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
?>
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Out Of Stock</h3>
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
                        <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url();?>Invantory/Request_stock" class="text-white"><i class="" aria-hidden="true"></i> Request Medicine Stock</a></button>
                        <?php } else { ?> 
                            <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url();?>purchase/create" class="text-white"><i class="" aria-hidden="true"></i> Add Medicine Stock</a></button>
                            
                            <?php } ?>                         
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url();?>invantory/Stock_expired" class="text-white"><i class="" aria-hidden="true"></i> Expired Medicine </a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url();?>invantory/Stock_short" class="text-white"><i class="" aria-hidden="true"></i> Short Stock </a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url();?>invantory/Stock_expire_soon" class="text-white"><i class="" aria-hidden="true"></i>Soon  Expire Medicine</a></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"> Out Of Stock</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="example28855" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
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
                                          
                                           <?php foreach($stockout as $value): ?>
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
$('#example28855').dataTable( {
        // "aaSorting": [[3,'desc']],
         //"ordering": false,
            dom: 'Bfrtip',
            buttons: [
                            {
                                extend: 'copy',
                                title: 'Stock Out Medicines'
                            },
                            {
                                extend: 'excel',
                                title: 'Stock Out Medicines'
                            },
                            {
                                extend: 'pdf',
                                title: 'Stock Out Medicines'
                            },
                            {
                                extend: 'print',
                                title: 'Stock Out Medicines'
                            }
                        ]
    });
        });
</script>   
<?php 

    $this->load->view('backend/footer');

?>