<?php
$this->load->view('backend/header');
$this->load->view('backend/sidebar');
$CI =& get_instance();
?>
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="container-fluid p-t-10">
            <div class="flashmessage"></div>
            <div class="row m-b-10">

                <!-- <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a
                            href="<?php echo base_url('Employee/View'); ?>" class="text-white"><i class=""
                                aria-hidden="true"></i> Manage Employee </a></button>
                </div> -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 ">Add Roles <span class="pull-right"><?php date_default_timezone_set("Asia/Kolkata");
                            echo date("l jS \of F Y h:i:s A") ?></span>
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="save_permissions" method="post" class="form-horizontal"
                                enctype="multipart/form-data" id="form" accept-charset="utf-8">
                                <div class="col-md-4">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Role Name</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="emname" class="form-control" placeholder="Role Name" required="">
                                                    </div>
                                                </div>
                                            </div>                                           
                                        <table class="table table-borderless " style="width:100%">
                                           <thead>
                                                <tr>
                                                    <th>Modules</th>
                                                    <th>Available Permissions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach($permissions_modules as $modules) { 
                                                    $module_id = str_replace(' ', '_', $modules->module);
                                                ?>
                                                <tr>
                                                    <td style="font-weight:bold"><?php echo $modules->module; ?></td>
                                                    <td colspan="12" rowspan="1">
                                                        <input type="checkbox" id="select_all_<?php echo $module_id; ?>" class="select_all" data-module="<?php echo $module_id; ?>">
                                                        <label for="select_all_<?php echo $module_id; ?>"> Select All </label>&nbsp;&nbsp;
                                                        <?php 
                                                        $permissions = $CI->permissionsbymodulename($modules->module);
                                                        foreach($permissions as $permission) {
                                                            $permission_id = str_replace(' ', '_', $permission->title);
                                                        ?>
                                                            <input type="checkbox" id="<?php echo $permission_id; ?>" name="permissionid[]" class="permissionid <?php echo $module_id; ?>" value="<?php echo $permission->id; ?>">
                                                            <label for="<?php echo $permission_id; ?>"> <?php echo $permission->title; ?> </label>&nbsp;&nbsp;
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>                               
                                <div class="form-actions">
                                    <div class="row justify-content-md-center">
                                        <div class=" col-md-offset-2 col-md-4 text-center">
                                            <button type="submit" class="btn btn-info">Submit</button>
                                            <button type="button" id="refresh" class="btn btn-inverse">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        
                    </div>
                    <table id="example11" class="display nowrap table table-hover table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Roles</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($rolelist as $role): ?>
        <tr>
            <td style="font-weight:bold"><?php echo $role->title; ?></td>
            <td>
                <a href="<?php echo base_url(); ?>Employee/edit_role?pid=<?php echo $role->id; ?>" target="_blank" title="Edit" class="btn btn-sm btn-info waves-effect waves-light" data-id="<?php echo $role->id; ?>">
                    <i class="fa fa-pencil-square-o"></i>
                </a>
                <!-- <button type="button" class="btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" data-target="#delete_modal-<?php echo $role->id; ?>">
                    <i class="fa fa-trash"></i>
                </button> -->
            </td>
        </tr>
        <!-- Modal -->
        <div class="modal fade" id="delete_modal-<?php echo $role->id; ?>" tabindex="-1" role="dialog" aria-labelledby="delete_modal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="delete_modal">DELETE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Do you want to delete this Employee?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                        <a href="<?php echo base_url(); ?>Employee/delete_role/<?php echo $role->id; ?>" class="btn btn-danger">YES</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </tbody>
</table>
                </div>
                <hr>
                
                        

            </div>
            
        </div>
        
        <footer class="footer"> © <?php echo date("Y"); ?> Med Jacket</footer>

    </div>

    <?php

    $this->load->view('backend/footer');

    ?>



<script>
$('#refresh').click(function() {
    location.reload();
});
</script>
<script>
    $(document).ready(function() {
        $('.select_all').on('change', function() {
            var module = $(this).data('module');
            $('.' + module).prop('checked', $(this).is(':checked'));
        });
    });
</script>
<script>
    $(document).ready(function() {
$('#example11').dataTable( {
        // "aaSorting": [[3,'desc']],
        // "ordering": false,
            dom: 'Bfrtip',
            buttons: [
                            {
                                extend: 'copy',
                                title: 'Roles List'
                            },
                            {
                                extend: 'excel',
                                title: 'Roles List'
                            },
                            {
                                extend: 'pdf',
                                title: 'Roles List'
                            },
                            {
                                extend: 'print',
                                title: 'Roles List'
                            }
                        ]
    });
        });
</script>  
