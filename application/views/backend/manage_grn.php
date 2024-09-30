<?php
$this->load->view('backend/header');
$this->load->view('backend/sidebar');
?>
<style>
    button.btn.btn-sm.btn-info.waves-effect.waves-light.medicineid {
        background: red;
    }

</style>

<div class="page-wrapper">
    <div class="container-fluid p-t-10">
        <div class="flashmessage"></div>
        <div class="row m-b-10">
            <div class="col-12">
                <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>purchase/add_grn" class="text-white"><i class="" aria-hidden="true"></i> Add GRN</a></button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Manage GRN </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="example288" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="w-p-20">GRN No.</th>
                                        <th class="w-p-15">Supplier Code</th>
                                        <th class="w-p-10">Supplier Name</th>
                                        <th class="w-p-10">Bill No.</th>
                                        <th class="w-p-5">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($grn as $val) { ?>
                                        <td><?php if (!empty($val->grn_no)) {
                                                echo $val->grn_no;
                                            } ?></td>
                                        <td><?php if (!empty($val->supplier_code)) {
                                                echo $val->supplier_code;
                                            } ?></td>
                                        <td><?php if (!empty($val->supplier_name)) {
                                                echo $val->supplier_name;
                                            } ?></td>
                                        <td><?php if (!empty($val->bill_no)) {
                                                echo $val->bill_no;
                                            } ?></td>
                                        <td class="jsgrid-align-center ">
                                            
                                            <a target="_blank" href="<?php echo base_url(); ?>purchase/view_grn/<?php echo $val->grn_no; ?>" id="invoId" title="View" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-history"></i></a>
                                            
                                        </td>
                                        </tr>
                                              <!-- Delete modal -->
                                <div class="modal fade" id="delete_modal-<?php if (!empty($val->grn_no)) { echo $val->grn_no; } ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">DELETE</h5>
                                               
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Do you want to delete this ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                                                <a href="<?php echo base_url(); ?>Purchase/delete_grn/<?php echo $val->grn_no; ?>"><button type="button" class="btn btn-danger">YES</button></a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
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
<script>
    $(document).ready(function() {
$('#example288').dataTable( {
        // "aaSorting": [[3,'desc']],
         "ordering": false,
            dom: 'Bfrtip',
            buttons: [
                            {
                                extend: 'copy',
                                title: 'GRN List'
                            },
                            {
                                extend: 'excel',
                                title: 'GRN List'
                            },
                            {
                                extend: 'pdf',
                                title: 'GRN List'
                            },
                            {
                                extend: 'print',
                                title: 'GRN List'
                            }
                        ]
    });
        });
</script> 
<?php
$this->load->view('backend/footer');
?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->