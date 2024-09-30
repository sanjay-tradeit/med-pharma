<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
?>
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Return Stock</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item ">Return Stock</li>
                    </ol>
                </div>
            </div>
        
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Return Stock</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Request Id</th>                                                                                                                                       
                                                <th>Created At</th>                                               
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <?php 
                                               foreach($requestedstock as $val)
                                               {?>
                                            <tr>
                                               
                                                <td> <?php echo $val->request_id; ?> </td>
                                                <td> <?php echo date("Y-m-d",strtotime($val->created_at));?></td>                                                
                                               <td class="jsgrid-align-center ">
                                                   <a target="_blank"href="<?php echo base_url(); ?>Invantory/history_requestedstore?q=<?php echo base64_encode($val->request_id);?>" id="invoId" title="View" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-history"></i></a> 
                                                </td>
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