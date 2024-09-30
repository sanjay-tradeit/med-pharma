<?php
$this->load->view('backend/header');
$this->load->view('backend/sidebar');
?>
<div class="page-wrapper">
    <style>
        .table td,
        .table th {
            border-color: #f7f5f5;
        }
        input.append-checkbox {
    position: unset !important;
    opacity: 1 !important;
}
    </style>
    <style>
button.btn.btn-sm.btn-info.waves-effect.waves-light {
    background-color: red;
}
</style>
    <div class="container-fluid p-t-10">
        <div class="row m-b-10">
            
        </div>
        <div class="flashmessage"></div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Unit of Measurement<span class="pull-right"><?php date_default_timezone_set("Asia/Kolkata");
                                                                                                    echo date("l jS \of F Y h:i:s A") ?></span></h4>
                    </div>
                    <div class="card-body">
                        
                        <form action="" method="post" class="form-horizontal" id="formid" accept-charset="utf-8">
                        <div class="pur_inputs add-purchase">
                          
                            <div class="row align-items-center">
                            <div class="col-md-3">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">Medicine Form</label>
                                        <select id="form" name="form" class="form-control">
                                        <?php foreach($UnitFormList as $form): ?>
                                        <option value="<?php echo $form->id; ?>"><?php echo $form->title; ?></option> 
                                        <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">UOM Code</label>
                                        <input  type="text" class="form-control hsn_num" name="unit"  placeholder="UOM code"  autocomplete="off" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">UOM Description</label>
                                        <input  type="text" name="note"  class="form-control igst" placeholder="UOM description" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">UOM Quantity</label>
                                        <input  type="text" name="qnty"  class="form-control igst" placeholder="Unit Quantity" autocomplete="off" required>
                                    </div>
                                </div>
                              
                                        
                                            <div class=" col-md-3 mt-4 ">
                                            <div class="form-actions text-center">
                                                <div class="form-group text-center">
                                                <?php $permissions = explode(',', $permissions1);
                                                if (in_array(15, $permissions)) { ?>
                                                    <button type="submit" class="btn btn-info" id="submit_btn">ADD</button>
                                                    <?php } ?>
                                                </div>   
                                                
                                                
                                            </div>
                                        
                                    </div>
                            </div>
                        </div>
                        <table id="example44" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>UOM FORM</th>
                                        <th>UOM Code</th>
                                        <th>UOM Description</th>
                                        <th>UOM Quantity</th>                                      
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
 
                                    <!-- <?php print_r($manufacturerid[0]->manufacturer_id); ?> -->

                                    



                                    
                                    <?php foreach($UnitList as $value):
                                    
                                            $CI     = & get_instance();
                                             $result = $CI->getformbyid($value->form);
                                             $title = $result[0]->title;
                                        ?>
                                        
                                        <tr>
                                              <td><?php echo $title; ?></td>
                                            <td><?php echo $value->unit; ?></td>
                                            
                                            <td><?php echo $value->note; ?></td>
                                            <td><?php echo $value->qnty; ?></td>
                                            <td class="jsgrid-align-center ">
                                            <?php $permissions = explode(',', $permissions1);
                                                if (in_array(16, $permissions)) { ?>
                                            <a href="" title="Edit" class="btn btn-sm btn-info waves-effect waves-light emmodalid" data-id="<?php echo $value->id; ?>" id="emmodalid"><i class="fa fa-pencil-square-o"></i></a>
                                            <?php } ?>
                                            <?php $permissions = explode(',', $permissions1);
                                                if (in_array(17, $permissions)) { ?>
                                                <button type="button" class="btn btn-sm btn-info waves-effect waves-light " data-toggle="modal" data-target="#delete_modal-<?php echo $value->id; ?>"><i class="fa-solid fa fa-trash"></i></button>
                                                <?php } ?>
                                                
                                        </td>
                                        </tr>
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
                                        Do you want to delete this ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                                        <a href="<?php echo base_url(); ?>Medicine/delete_unit/<?php echo $value->id; ?>"><button type="button" class="btn btn-danger">YES</button></a>
                                       
                                    </div>
                                    </div>
                                </div>
                                </div>
                                        <?php endforeach;?>
                                </tbody>
                            </table>

                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<footer class="footer"> © <?php echo date("Y");?> Med Jacket</footer>
</div>
<!-- Modal -->
<div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Unit of Measurement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form  id="employeefORM" class="form-horizontal" enctype="multipart/form-data" accept-charset="utf-8">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">UOM Code</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="unit" id="m_name" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">UOM Form</label>
                                                    <div class="col-md-9">
                                                    <select name="form" class="select2" id="form12" value="" style="width:100%">
                                                        <?php foreach($medforms as $form): ?>
                                                            
                                                            
                                                            
                                                            <option value="<?php echo $form->id; ?>"><?php echo $form->title; ?></option> 
                                                            <?php endforeach;?>
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">UOM Description</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="note" id="note" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">UOM Quantity</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="qnty" id="qnty" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
      <div class="modal-footer">

       <!-- <input type="hidden" name="eid" value=""> -->

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

        <button type="submit"  id="sbt_btn" class="btn btn-info">Submit</button>

      </div>

      </form>

    </div>

  </div>

</div>
        </div>





<script>
$('#formid').on('submit', function(e) {
    e.preventDefault();

    var munit = $("input[name='unit']").val();
    var mnote = $("input[name='note']").val();
    var qnty = $("input[name='qnty']").val();
    var form = $("#form option:selected").val();

    
    
    if (munit.trim() === '' || qnty.trim() === '') {
        return;
    }

    $.ajax({
        type: 'POST',
        url: "Saveunit",
        dataType: 'json',
        cache: false,
        data: {
            unit: munit,
            note: mnote,
            qnty: qnty,
            form: form,
            
        },
        success: function(response) {
            console.log(response.status);
            if (response.status === "success") {
                $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);
                window.setTimeout(function() {
                    window.location = response.curl;
                }, 1000);
               
                $("#submit_btn").attr("disabled", true);
            }
        }
    });
    $('#form12').change(function() {    
                        var item = $(this);
                      
                       $('#form12').val(item.val());
                        
                    });
});
</script>


<script>

        $(document).ready(function () {
        $(".emmodalid").click(function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        $('#employeefORM').trigger("reset");
        $('#employeeModal').modal('show');
        $.ajax({
            url: '<?php echo base_url();?>Medicine/GetunitBynum?id=' + id,
            method: 'GET',
            dataType: 'json',
        }).done(function (response) {
            console.log(response);
            $('#employeefORM').find('[name="unit"]').val(response.unit);
            $('#employeefORM').find('[name="note"]').val(response.note);
            $('#employeefORM').find('[name="form"]').val(response.form);
            $('#employeefORM').find('[name="qnty"]').val(response.qnty);
            $('#sbt_btn').attr('data-id', response.id);
        });
    });

    $("#sbt_btn").on("click", function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var id = $(this).attr('data-id');
        var munit = $('#m_name').val();
        var mnote = $('#note').val();
        var form = $('#form12').val();
        var qnty = $('#qnty').val();
        console.log(form);
        vdata = {unit: munit, note: mnote, form: form, qnty: qnty};
        $.ajax({
            url: '<?php echo base_url();?>Medicine/update_unit?id=' + id,
            method: 'POST',
            data: vdata,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status == "success") {
                    window.setTimeout(function () {
                        window.location = response.curl;
                    }, 1000);
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
            }
        });
    });
});
</script>
<script>
    $(document).ready(function() {
$('#example44').dataTable( {
        "aaSorting": [[3,'desc']],
        "ordering": false,
            dom: 'Bfrtip',
            buttons: [
                            {
                                extend: 'copy',
                                title: 'Units List'
                            },
                            {
                                extend: 'excel',
                                title: 'Units List'
                            },
                            {
                                extend: 'pdf',
                                title: 'Units List'
                            },
                            {
                                extend: 'print',
                                title: 'Units List'
                            }
                        ]
    });
        });
</script>  
</div>
<?php
$this->load->view('backend/footer');
?>