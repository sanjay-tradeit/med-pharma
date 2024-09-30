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
                <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url('Store/add_store'); ?>" class="text-white"><i class="" aria-hidden="true"></i> Add Store</a></button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Manage Store </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive ">
                        <table id="myTable5512" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="w-p-20">Store-Id</th>
            <th class="w-p-15">Store Name</th>
            <th class="w-p-10">Store Alias</th>
            <th class="w-p-5">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($get_stores as $val) { ?>
            <tr>
                <td><?php echo !empty($val->store_id) ? $val->store_id : ''; ?></td>
                <td><?php echo !empty($val->store_name) ? $val->store_name : ''; ?></td>
                <td><?php echo !empty($val->store_alias) ? $val->store_alias : ''; ?></td>
                <td class="jsgrid-align-center">
                    <?php $permissions = explode(',', $permissions1);
                    if (in_array(24, $permissions)) { ?>
                        <a href="<?php echo base_url(); ?>Store/edit_store/<?php echo $val->id; ?>" title="Edit" class="btn btn-sm btn-info waves-effect waves-light medicineid" data-id="<?php echo !empty($val->store_id) ? $val->store_id : ''; ?>"><i class="fa fa-pencil-square-o"></i></a>
                    <?php } ?>
                    <?php if (in_array(25, $permissions)) { ?>
                        <button type="button" class="btn btn-sm btn-info waves-effect waves-light medicineid" data-toggle="modal" data-target="#delete_modal-<?php echo $val->id; ?>"><i class="fa-solid fa fa-trash"></i></button>
                    <?php } ?>
                </td>
            </tr>

            <!-- Delete modal -->
            <div class="modal fade" id="delete_modal-<?php echo $val->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">DELETE</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Do you want to delete this?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                            <a href="<?php echo base_url(); ?>Store/delete_store/<?php echo $val->id; ?>"><button type="button" class="btn btn-danger">YES</button></a>
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

<?php
$this->load->view('backend/footer');
?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->

<script>
    $('#myTable5512').DataTable({
        "columnDefs": [
            {
                "visible": false,
                "searchable": true
            }
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copy',
                title: 'Store List'
            },
            {
                extend: 'excel',
                title: 'Store List'
            },
            {
                extend: 'pdf',
                title: 'Store List'
            },
            {
                extend: 'print',
                title: 'Store List'
            }
        ]
    });
</script>  