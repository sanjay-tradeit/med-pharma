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
                                                 <th>Created Date</th>
                                                  <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
            

                                         <?php 
                                            foreach($stock_his as $row)
                                            {

                                          
                                         ?>

                                            <tr>
                                                <td> <?php echo $row->request_id; ?></td>
                                                <td> <?php echo $row->createdat; ?></td>
                                                <td class="jsgrid-align-center ">
                                                   <a target="_blank"href="<?php echo base_url(); ?>Invantory/stock_his_by_sub/<?php echo $row->request_id; ?>" id="invoId" title="View" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-history"></i></a> 
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