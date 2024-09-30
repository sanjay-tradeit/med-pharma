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
button.btn.btn-sm.btn-info.waves-effect.waves-light {
    background-color: red;
}
    </style>
    <div class="container-fluid p-t-10">
        <div class="row m-b-10">
        <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url();?>Customer/import_manufac" class="text-white"><i class="" aria-hidden="true"></i> Import Manufacturer</a></button> 
        </div>
        <div class="flashmessage"></div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Manufacturer<span class="pull-right date-display"><?php date_default_timezone_set("Asia/Kolkata");
                                                                                                    echo date("l jS \of F Y h:i:s A") ?></span></h4>
                    </div>
                    <div class="card-body">
                        
                        <form action="" method="post" class="form-horizontal" id="formid" accept-charset="utf-8">
                        <div class="pur_inputs add-purchase">
                          
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">Manufacturer Name</label>
                                        <input  type="text" class="form-control hsn_num" name="m_name" id="m_name" onkeyup="checkmanuname()" placeholder="Manufacturer name"  autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-bottom: 15px">
                                        <label class="control-label">Note</label>
                                        <input  type="text" name="note" id="po_no" class="form-control igst" placeholder="Note" autocomplete="off">
                                    </div>
                                </div>
                              
                                        
                                            <div class=" col-md-3 mt-4 ">
                                            <div class="form-actions text-center">
                                                <div class="form-group text-center">
                                                <?php $permissions = explode(',', $permissions1);
                                                if (in_array(7, $permissions)) { ?>
                                                    <button type="submit" class="btn btn-info" id="submit_btn">ADD</button>
                                                    <?php } ?>
                                                
                                                </div>   
                                                
                                                
                                            </div>
                                        
                                    </div>
                            </div>
                        </div>
                        <table id="example45" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Manufacturer Id</th>
                                        <th>Manufacturer Name</th>
                                        <th>Note</th>                                       
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
 
                                    <!-- <?php print_r($manufacturerid[0]->manufacturer_id); ?> -->

                                    




                                    <?php foreach($manufacturerList as $value): ?>
                                        <tr>
                                            <td><?php echo $value->manufac_id; ?></td>
                                            <td><?php echo $value->m_name; ?></td>
                                            <td><?php echo $value->note; ?></td>
                                            
                                            <td class="jsgrid-align-center ">
                                            <?php $permissions = explode(',', $permissions1);
                                                if (in_array(8, $permissions)) { ?>
                                            <a href="" title="Edit" class="btn btn-sm btn-info waves-effect waves-light emmodalid" data-id="<?php echo $value->id; ?>" id="emmodalid"><i class="fa fa-pencil-square-o"></i></a>
                                            <?php } ?>
                                            <?php $permissions = explode(',', $permissions1);
                                                if (in_array(9, $permissions)) { ?>
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
                                        <a href="<?php echo base_url(); ?>Manufacturer/delete_manu/<?php echo $value->id; ?>"><button type="button" class="btn btn-danger">YES</button></a>
                                       
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
        <h5 class="modal-title" id="exampleModalLabel">Update Manufacturer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form  id="employeefORM" class="form-horizontal" enctype="multipart/form-data" accept-charset="utf-8">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Manufacturer Name</label>
                                                    <div class="col-md-9">
                                                        <input type="text" onkeyup="checkmanuname1()" name="m_name" id="mname" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        
                                        
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Note</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="note" id="note" class="form-control" >
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

    var mname = $("input[name='m_name']").val();
    var mnote = $("input[name='note']").val();

    if (mname.trim() === '') {
        return;
    }

    $.ajax({
        type: 'POST',
        url: "Savemanufacturer",
        dataType: 'json',
        cache: false,
        data: {
            m_name: mname,
            note: mnote,
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
});
function checkmanuname(){
            var manuname = $("#m_name").val();
           
            gdata ={m_name: manuname};

            $.ajax({
                type: "POST",
                dataType: 'html',
                url: "checkmanuname",
                data: gdata,
               
                
          success: function(response) {
              if(response == 'error') { 
                $("#m_name").css("border-color","#ff9797");
                $('#submit_btn').attr('disabled','disabled');
              
              } else if(response == 'success') {
                $("#m_name").css("border-color","#67757c");
                $('#submit_btn').removeAttr('disabled');
               
              }              
          },
          error: function(response) {
            console.error();
          }
            });


        }
        function checkmanuname1(){
            var manuname = $("#mname").val();
            
            gdata ={m_name: manuname};

            $.ajax({
                type: "POST",
                dataType: 'html',
                url: "checkmanuname",
                data: gdata,
               
                
          success: function(response) {
              if(response == 'error') { 
                $("#mname").css("border-color","#ff9797");
                $('#sbt_btn').attr('disabled','disabled');
              
              } else if(response == 'success') {
                $("#mname").css("border-color","#67757c");
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

        $(document).ready(function () {
        $(".emmodalid").click(function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        $('#employeefORM').trigger("reset");
        $('#employeeModal').modal('show');
        $.ajax({
            url: '<?php echo base_url();?>Manufacturer/GetmanufacturerBynum?id=' + id,
            method: 'GET',
            dataType: 'json',
        }).done(function (response) {
            console.log(response);
            $('#employeefORM').find('[name="m_name"]').val(response.m_name);
            $('#employeefORM').find('[name="note"]').val(response.note);

            $('#sbt_btn').attr('data-id', response.id);
        });
    });

    $("#sbt_btn").on("click", function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var id = $(this).attr('data-id');
        var mname = $('#mname').val();
        var note = $('#note').val();
        
        vdata = {m_name: mname, note: note};
        $.ajax({
            url: '<?php echo base_url();?>Manufacturer/update_manu?id=' + id,
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
$('#example45').dataTable( {
        "aaSorting": [[3,'desc']],
        "ordering": false,
            dom: 'Bfrtip',
            buttons: [
                            {
                                extend: 'copy',
                                title: 'Manufacturer List'
                            },
                            {
                                extend: 'excel',
                                title: 'Manufacturer List'
                            },
                            {
                                extend: 'pdf',
                                title: 'Manufacturer List'
                            },
                            {
                                extend: 'print',
                                title: 'Manufacturer List'
                            }
                        ]
    });
        });
</script>  
</div>
<?php
$this->load->view('backend/footer');
?>