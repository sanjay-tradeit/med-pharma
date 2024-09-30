<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
    $CI     = & get_instance();
?>
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Return Stock History</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item ">Return Stock History</li>
                    </ol>
                </div>
            </div>
        
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Return Stock History</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="example2884" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Request Id</th>
                                                <th>Store Name</th>
                                                 <th>Created Date</th>
                                                  <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                          <?php 
                                            foreach($history as $row):
                                            $store = $CI->get_store_name($row->from_store_id);
                                            ?> 
                                            <tr>
                                                <td> <?php echo $row->request_id; ?></td>
                                                <td><?php echo $store[0]->store_name ; ?></td>
                                                <td><?php echo date("Y-m-d",strtotime($row->created_at));?> </td>
                                                
                                                <td class="jsgrid-align-center ">
                                                   <a target="_blank" href="<?php echo base_url();?>Invantory/admin_req_his/<?php echo $row->request_id; ?>" id="invoId" title="View" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-history"></i></a> 
                                                </td>
                                            </tr>
                                            <?php  endforeach; ?>
                                         
                                         
                                          
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
$('#example2884').dataTable( {
        // "aaSorting": [[3,'desc']],
         //"ordering": false,
            dom: 'Bfrtip',
            buttons: [
                            {
                                extend: 'copy',
                                title: 'Return Stock History'
                            },
                            {
                                extend: 'excel',
                                title: 'Return Stock History'
                            },
                            {
                                extend: 'pdf',
                                title: 'Return Stock History'
                            },
                            {
                                extend: 'print',
                                title: 'Return Stock History'
                            }
                        ]
    });
        });
</script> 
<?php 

    $this->load->view('backend/footer');

?>