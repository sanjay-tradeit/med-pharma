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
                            <h4 class="m-b-0 ">Edit Role <span class="pull-right"><?php date_default_timezone_set("Asia/Kolkata");
                            echo date("l jS \of F Y h:i:s A") ?></span>
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="update_permissions" method="post" class="form-horizontal"
                                enctype="multipart/form-data" id="form" accept-charset="utf-8">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Role Name</label>
                                        <div class="col-md-9">
                                            <input type="text" name="emname" class="form-control" value="<?php echo $roledata[0]->title; ?>" placeholder="Role Name" required="">
                                        </div>
                                        <input type="hidden" name="emid" class="form-control" value="<?php echo $roledata[0]->id; ?>">
                                    </div>
                                </div>
                                <table id="permissions_table" class="table table-borderless " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Modules</th>
                                            <th>Available Permissions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $assigned_permissions = explode(',', $roledata[0]->permissions); 
                                        foreach($permissions_modules as $modules) { ?>
                                            <tr>
                                                <td style="font-weight:bold"><?php echo $modules->module;?></td>
                                                <td colspan="12" rowspan="1">
                                                    <?php 
                                                    $permissions = $CI->permissionsbymodulename($modules->module);
                                                    foreach($permissions as $permission) { 
                                                        $checked = in_array($permission->id, $assigned_permissions) ? 'checked' : '';
                                                        ?>
                                                        <input type="checkbox" id="<?php echo $permission->title;?>" name="permissionid[]" value="<?php echo $permission->id;?>" <?php echo $checked; ?>>
                                                        <label for="<?php echo $permission->title;?>" > <?php echo $permission->title;?> </label>&nbsp;&nbsp;
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <hr>
                                <div class="form-actions">
                                    <div class="row justify-content-md-center">
                                        <div class=" col-md-offset-2 col-md-4 text-center">
                                            <button type="submit" class="btn btn-info">Update</button>
                                            <button type="button" id="refresh" class="btn btn-inverse">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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