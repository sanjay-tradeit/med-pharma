<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
?>
<link rel="stylesheet" type="text/css" href="https://rawgit.com/nobleclem/jQuery-MultiSelect/master/jquery.multiselect.css" />
<script src="https://rawgit.com/nobleclem/jQuery-MultiSelect/master/jquery.multiselect.js"></script>
        <div class="page-wrapper">
            <div class="row page-titles">
            <div class="container-fluid p-t-10">
                <div class="flashmessage"></div>
                <div class="row m-b-10"> 

                    <div class="col-12">
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url('Employee/View');?>" class="text-white"><i class="" aria-hidden="true"></i> Manage Employee </a></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                    <div class="card card-outline-info">
                            <div class="card-header">                                
                                <h4 class="m-b-0 ">New Employee <span class="pull-right"><?php date_default_timezone_set("Asia/Kolkata"); echo date("l jS \of F Y h:i:s A") ?></span></h4>
                            </div>
                            <div class="card-body">
                                <form action="Save" method="post" class="form-horizontal" enctype="multipart/form-data" id="form" accept-charset="utf-8"> 
                                    <div class="form-body">
                                        <hr class="m-t-0 m-b-40">
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
                                                if ($_SESSION['em_type'] == 'admin') { ?>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Store</label>
                                                    <div class="col-md-9">
                                                        <select class="form-control" name="store" >
                                                        <?php 
                                                            foreach($store as $row){?>
                                                             <option value="<?php echo $row->id; ?>"><?php echo $row->store_name; ?></option>
                                                           <?php  }
                                                        ?>
                                                            
                                                           
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php 
                                                if ($_SESSION['em_type'] == 'substore') { 
                                                    $CI  = & get_instance();
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
                                                        <select class="form-control" name="store" readonly>
                                                        
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
                                                        <input type="password" name="passone" class="form-control" placeholder="**********" minlength="6" required >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Confirm Password</label>
                                                    <div class="col-md-9">
                                                        <input type="password" name="passtwo" class="form-control" placeholder="**********" minlength="6"  required >
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
                                                        <select class="form-control" name="emtype" required readonly>
                                                            <option value="substore" selected>Substore</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Employee Role</label>
                                                    <div class="col-md-9">
                                                    <select id="form" name="emroll" class="form-control">
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
                                                    <label class="control-label text-right col-md-3">Image</label>
                                                    <div class="col-md-9">
                                                        <input type="file" name="img_url" class="form-control">
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
                                        <!--/row-->
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="row justify-content-md-center">
                                            <div class=" col-md-offset-2 col-md-4 ">
                                                <button type="submit" id="sbt_btn" class="btn btn-info" >Submit</button>
                                                <button type="button" class="btn btn-inverse">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer"> © <?php echo date("Y");?> Med Jacket</footer>

        </div>
<script>
    $(function() {
  // from http://stackoverflow.com/questions/45888/what-is-the-most-efficient-way-to-sort-an-html-selects-options-by-value-while
  var my_options = $('.facilities select option');
  var selected = $('.facilities').find('select').val();

  my_options.sort(function(a,b) {
    if (a.text > b.text) return 1;
    if (a.text < b.text) return -1;
    return 0
  })

  $('.facilities').find('select').empty().append( my_options );
  $('.facilities').find('select').val(selected);
  
  // set it to multiple
  $('.facilities').find('select').attr('multiple', true);
  
  // remove all option
  $('.facilities').find('select option[value=""]').remove();
  // add multiple select checkbox feature.
  $('.facilities').find('select').multiselect();
})
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
<?php 

    $this->load->view('backend/footer');

?>