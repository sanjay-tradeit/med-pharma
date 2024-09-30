<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
    $CI     = & get_instance();
?>
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Requested Stock</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item ">Requested Stock</li>
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
                                <h4 class="m-b-0 text-white"> Requested Stock</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="example321" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Request Id</th>
                                                <th>Store Name</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                           <?php foreach($requestedstock as $value): 
                                          
                                            $store = $CI->get_store_name($value->store_id);
                                           
                                            ?>
                                            <tr>
                                                <td><?php echo $value->request_id; ?></td>
                                                <td><?php echo $store[0]->store_name ; ?></td>
                                                <td><?php echo date("Y-m-d",strtotime($value->createdat)); ;  ?></td>
                                                <td class="jsgrid-align-center ">
                                                   <a target="_blank"href="<?php echo base_url(); ?>Invantory/history_requested/<?php echo $value->request_id;?>" id="invoId" title="View" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-history"></i></a> 
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
                        <footer class="footer"> © <?php echo date("Y");?> Med Jacket</footer>
        </div>
        <script>
    $(document).ready(function() {
$('#example321').dataTable( {
        // "aaSorting": [[3,'desc']],
         //"ordering": false,
            dom: 'Bfrtip',
            buttons: [
                            {
                                extend: 'copy',
                                title: 'Requested Stock List'
                            },
                            {
                                extend: 'excel',
                                title: 'Requested Stock List'
                            },
                            {
                                extend: 'pdf',
                                title: 'Requested Stock List'
                            },
                            {
                                extend: 'print',
                                title: 'Requested Stock List'
                            }
                        ]
    });
        });
</script> 
<?php 

    $this->load->view('backend/footer');

?>