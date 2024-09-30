<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
?>
<style>
button.btn.btn-sm.btn-info.waves-effect.waves-light {
    background-color: red;
}
</style>
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Employee</h3>
                </div>
                <div class="flashmessage"></div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item ">Employee</li>
                    </ol>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row m-b-10"> 
                    <div class="col-12">
                        <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url();?>Employee/Create" class="text-white"><i class="" aria-hidden="true"></i> Add Employee</a></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Manage Employee </h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="example5533" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Employee ID </th>
                                                <th>Name</th>
                                                <th>Store Name</th>
                                                <th>Phone Number</th>
                                                <th>Address</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php 
                                                if ($_SESSION['em_type'] == 'admin') { ?>
                                        <tbody>
                                           <?php $CI  = & get_instance();
                                            foreach($userList as $value):
                                                $storename =   $CI->get_store_name($value->store);
                                                $getrolename = $CI->getrolename($value->em_role);
                                                if($getrolename == null)
                                                {
                                                    $rolename = '';
                                                }
                                                else {
                                                    $rolename = $getrolename->title;
                                                }
                                                // print_r($storename);
                                                if($storename == null)
                                                {
                                                    $strname = '';
                                                }
                                                else {
                                                    $strname = $storename[0]->store_name;
                                                }
                                            //$storename = $CI->get_store_name($value->store);
                                           // $name = $storename[0]->store_name; 
                                            // print_r($storename[0]->store_name); ?>
                                            <tr>
                                                <td><?php echo $value->em_id; ?></td>
                                                <td><?php echo $value->em_name; ?></td>
                                                <td><?php echo $strname; ?></td>
                                                <td><?php echo $value->em_contact; ?></td>
                                                <td><?php echo substr($value->em_address,0,25).'...'?></td>
                                                <td><?php echo $value->email; ?></td>
                                                <td><?php echo $rolename; ?></td>
                                                <td class="jsgrid-align-center ">
                                                <?php $permissions = explode(',', $permissions1);
                                                if (in_array(28, $permissions)) { ?>
                                                    <a href="" title="Edit" class="btn btn-sm btn-info waves-effect waves-light emmodalid" data-id="<?php echo $value->em_id; ?>" id="emmodalid"><i class="fa fa-pencil-square-o"></i></a>
                                                    <!--<a href="#" title="Delete" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i></a>-->
                                                    <?php } ?>    
                                                    <button type="button" class="button btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" data-target="#delete_modal-<?php echo $value->id; ?>"><i class="fa-solid fa fa-trash"></i></button>
                                                </td>
                                                <div class="modal fade" id="delete_modal-<?php echo $value->id; ?>" tabindex="-1" role="dialog" aria-labelledby="delete_modal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="delete_modal">DELETE</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        Do you want to delete this Employee ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                                        <a href="<?php echo base_url(); ?>Employee/delete_emp/<?php echo $value->id; ?>"><button type="button" class="btn btn-danger">YES</button></a>
                                       
                                    </div>
                                    </div>
                                </div>
                                </div>
                                                <?php endforeach; ?> 

                                            </tr>

                                        </tbody>
                                  <?php } ?>
                                  <?php 
                                                if ($_SESSION['em_type'] == 'substore') { ?>
                                        <tbody>
                                           <?php $CI  = & get_instance();
                                            foreach($userListspecific as $value):
                                                $storename =   $CI->get_store_name($value->store);
                                                $getrolename = $CI->getrolename($value->em_role);
                                                if($getrolename == null)
                                                {
                                                    $rolename = '';
                                                }
                                                else {
                                                    $rolename = $getrolename->title;
                                                }
                                                // print_r($storename);
                                                if($storename == null)
                                                {
                                                    $strname = '';
                                                }
                                                else {
                                                    $strname = $storename[0]->store_name;
                                                }
                                            //$storename = $CI->get_store_name($value->store);
                                           // $name = $storename[0]->store_name; 
                                            // print_r($storename[0]->store_name); ?>
                                            
                                            <tr>
                                                <td><?php echo $value->em_id; ?></td>
                                                <td><?php echo $value->em_name; ?></td>
                                                <td><?php echo $strname; ?></td>
                                                <td><?php echo $value->em_contact; ?></td>
                                                <td><?php echo substr($value->em_address,0,25).'...'?></td>
                                                <td><?php echo $value->email; ?></td>
                                                <td><?php echo $rolename; ?></td>
                                                <td class="jsgrid-align-center ">
                                                <?php $permissions = explode(',', $permissions1);
                                                if (in_array(99, $permissions)) { ?>
                                                    <a href="" title="Edit" class="btn btn-sm btn-info waves-effect waves-light emmodalid" data-id="<?php echo $value->em_id; ?>" id="emmodalid"><i class="fa fa-pencil-square-o"></i></a>
                                                    <!--<a href="#" title="Delete" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i></a>-->
                                                    <?php } ?>    
                                                    <button type="button" class="button btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" data-target="#delete_modal-<?php echo $value->id; ?>"><i class="fa-solid fa fa-trash"></i></button>
                                                </td>
                                                <div class="modal fade" id="delete_modal-<?php echo $value->id; ?>" tabindex="-1" role="dialog" aria-labelledby="delete_modal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="delete_modal">DELETE</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        Do you want to delete this Employee ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                                        <a href="<?php echo base_url(); ?>Employee/delete_emp/<?php echo $value->id; ?>"><button type="button" class="btn btn-danger">YES</button></a>
                                       
                                    </div>
                                    </div>
                                </div>
                                </div>
                                                <?php endforeach; ?> 

                                            </tr>

                                        </tbody>
                                  <?php } ?>
                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                        </div>

            <footer class="footer"> © <?php echo date("Y");?> Med Jacket</footer>
<!--Modal-->

<div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
  <div class="flashmessage"></div>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
                                    <form action="Update" method="post" id="employeefORM" class="form-horizontal" enctype="multipart/form-data" accept-charset="utf-8">
                                         <div class="modal-body">
                                           <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Employee Name</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="emname" onkeyup="checkempname()" id="em_name" class="form-control" placeholder="" required >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Phone Number</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="emphone" class="form-control" minlength="10" maxlength="13" placeholder="" required >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Email </label>
                                                    <div class="col-md-9">
                                                        <input type="email" name="ememail" class="form-control" placeholder="" minlength="6" maxlength="256" required >
                                                    </div>
                                                </div>
                                            </div>
                                            <?php 
                                              $CI     = & get_instance();
                                             $getstore = $CI->get_all_stores();
                                            
                                              
                                              
                                            ?>
                                             <?php 
                                                if ($_SESSION['em_type'] == 'admin') { ?>
                                             <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Store</label>
                                                    <div class="col-md-9">
                                                        <select class="form-control" name="store" id="stors">
                                                        <!-- <?php 
                                                            foreach($getstore as $row){?>
                                                             <option value="<?php echo $row->id; ?>"><?php echo $row->store_name; ?></option>
                                                           <?php  }
                                                        ?> -->
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php 
                                                if ($_SESSION['em_type'] == 'substore') { 
                                                    $storename =   $CI->get_store_name($_SESSION['store_id']);    
                                                    if($storename == null)
                                                {
                                                    $strname = '';
                                                }
                                                else {
                                                    $strname = $storename[0]->store_name;
                                                }
                                                    ?>
                                             <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Store</label>
                                                    <div class="col-md-9">
                                                        <select class="form-control" name="store">
                                                       
                                                            
                                                             <option value="<?php echo $_SESSION['store_id']; ?>"><?php echo $strname; ?></option>
                                                          
                                                       
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Address</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="emaddress" class="form-control" placeholder="Address..." >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">

                                                <div class="form-group row">

                                                    <label class="control-label text-right col-md-3">Password</label>

                                                    <div class="col-md-9">

                                                        <input type="text" name="passone" class="form-control" minlength="6"  placeholder="**********" >

                                                    </div>

                                                </div>

                                            </div>
                                            <?php 
                                                if ($_SESSION['em_type'] == 'admin') { ?>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">User Type</label>
                                                    <div class="col-md-9">
                                                        <select class="form-control" name="emtype" required>
                                                            <option>Select User Type</option>
                                                            <option value="admin">Admin</option>
                                                            <option value="substore">Substore</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php 
                                                if ($_SESSION['em_type'] == 'substore') { ?>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">User Type</label>
                                                    <div class="col-md-9">
                                                        <select class="form-control" name="emtype" required>
                                                            <option value="substore">Substore</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div class="col-md-6">

                                                <div class="form-group row">

                                                    <label class="control-label text-right col-md-3">Employee Role</label>

                                                    <div class="col-md-9">

                                                    <select id="emroll" name="emroll" class="form-control">
                                        <?php foreach($rolelist as $role): ?>
                                        <option value="<?php echo $role->id; ?>"><?php echo $role->title; ?></option> 
                                        <?php endforeach;?>
                                        </select>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Employee Status</label>
                                                    <div class="col-md-9">
                                                        <select class="form-control" name="emstatus" required>
                                                            <option>Select User Status</option>
                                                            <option value="ACTIVE">ACTIVE</option>
                                                            <option value="INACTIVE">INACTIVE</option>
                                                        </select>

                                                    </div>

                                                </div>

                                            </div>
                                            

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Product Image</label>
                                                    <div class="col-md-9">
                                                        <input type="file" name="img_url" id="img_url" class="form-control">
                                                        <div class="file_prev">
                                                        <img src="" name="image" class="img-responsive postimg" id="image" height="35px" width="60px">
                                                    </div>
                                                    </div>
                                                   
                                                </div>
                                            </div>  

                                            <div class="col-md-6">

                                                <div class="form-group row">

                                                    <label class="control-label text-right col-md-3">Note</label>

                                                    <div class="col-md-9">

                                                        <textarea class="form-control" name="emnote" rows="3"></textarea>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>
            </div>
      <div class="modal-footer">

       <input type="hidden" name="eid" value="">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

        <button type="submit" id="sbt_btn" class="btn btn-info">Submit</button>

      </div>

      </form>

    </div>

  </div>

</div>
        </div>

           <script type="text/javascript">
                $(document).ready(function () {
                    $(".emmodalid").click(function (e) {
                        e.preventDefault(e);
                        // Get the record's ID via attribute  
                        var iid = $(this).attr('data-id');
                        //console.log(iid);
                         $('#employeefORM').trigger("reset");
                         $('#employeeModal').modal('show'); 
                        $.ajax({
                            url: '<?php echo base_url();?>employee/GetEmployeeById?id=' + iid,
                            method: 'GET',
                            data: '',
                            dataType: 'json',
                        }).done(function (response) {
                            console.log(response);
                            // Populate the form fields with the data returned from server
                            $('#employeefORM').find('[name="eid"]').val(response.employee.em_id).end();
                            $('#employeefORM').find('[name="emname"]').val(response.employee.em_name).end();
                            $('#employeefORM').find('[name="emphone"]').val(response.employee.em_contact).end();
                            $('#employeefORM').find('[name="ememail"]').val(response.employee.email).end();
                            $('#employeefORM').find('[name="emaddress"]').val(response.employee.em_address).end();
                            $('#employeefORM').find('[name="emroll"]').val(response.employee.em_role).end();
                            $('#employeefORM').find('[name="emstatus"]').val(response.employee.status).end();
                            $('#employeefORM').find('[name="emtype"]').val(response.employee.em_type).end();
                            $('#employeefORM').find('[name="emnote"]').val(response.employee.em_details).end();
                            //$('#employeefORM').find('[name="store"]').val(response.employee.store).end();
                            $('#image').attr('src','<?php echo base_url()?>assets/images/users/'+response.employee.em_image);
                            $('#stores').val(response.employee.store);
                            

                            $.each(response.allStores, function(key, value) {  
                                
                                if(response.employee.store == key){
                                    $('#employeefORM').find('[id="stors"]').append($("<option selected></option>").attr("value", key).text(value));
                                }else {
                                
                                $('#employeefORM').find('[id="stors"]').append($("<option></option>").attr("value", key).text(value));
                            }
                                });
        				});
                    });
                });  
                function checkempname(){
            var supname = $("#em_name").val();
            
            gdata ={emname: supname};
            $.ajax({
                type: "POST",
                dataType: 'html',
                url: "checkempname",
                data: gdata,
               
                
          success: function(response) {
              if(response == 'error') { 
                $("#em_name").css("border-color","#ff9797");
                $('#sbt_btn').attr('disabled','disabled');
              
              } else if(response == 'success') {
                $("#em_name").css("border-color","#67757c");
                $('#sbt_btn').removeAttr('disabled');
               
              }              
          },
          error: function(response) {
            console.error();
          }
            });


        }             
            </script>
<script>
$("#img_url").on("change", function() {
    if (typeof FileReader == "undefined") {
        alert("Your browser doesn't support HTML5, Please upgrade your browser");
    } else {
        var container = $(".file_prev");
        //remove all previous selected files
        container.empty();

        //create instance of FileReader
        var reader = new FileReader();
        reader.onload = function(e) {
            $("<img />", {
                src: e.target.result
            }).appendTo(container);
        };
        reader.readAsDataURL($(this)[0].files[0]);
    }
});
    </script>   
     <script>
    $(document).ready(function() {
$('#example5533').dataTable( {
        //"aaSorting": [[3,'desc']],
        //"ordering": false,
            dom: 'Bfrtip',
            buttons: [
                            {
                                extend: 'copy',
                                title: 'Employee List'
                            },
                            {
                                extend: 'excel',
                                title: 'Employee List'
                            },
                            {
                                extend: 'pdf',
                                title: 'Employee List',
                                orientation : 'landscape',
                                pageSize : 'LEGAL',
                            },
                            {
                                extend: 'print',
                                title: 'Employee List'
                            }
                        ]
                        
    });
        });
</script>            
<?php 

    $this->load->view('backend/footer');

?>