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
            <h3 class="text-themecolor">HSN Number</h3>
        </div>
        <div class="flashmessage"></div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item ">HSN</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url();?>Hsn/Createhsn" class="text-white"><i class="" aria-hidden="true"></i> Add HSN</a></button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Manage HSN </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example89" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>HSN Number</th>
                                        <th>GST</th>
                                        <th>CGST</th>
                                        <th>SGST</th>
                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    foreach($hsnList as $value): ?>
                                        <tr>
                                            <td><?php echo $value->hsn_num; ?></td>
                                            <td><?php echo round($value->igst, 2); ?></td>
                                            <td><?php echo round($value->cgst, 2); ?></td>
                                            <td><?php echo round($value->sgst, 2); ?></td>
                                            
                                            <td class="jsgrid-align-center ">
                                            <?php $permissions = explode(',', $permissions1);
                                                if (in_array(12, $permissions)) { ?>
                                            <a href="" title="Edit" class="btn btn-sm btn-info waves-effect waves-light emmodalid" data-id="<?php echo $value->id; ?>" id="emmodalid"><i class="fa fa-pencil-square-o"></i></a>
                                            <?php } ?>
                                            <?php $permissions = explode(',', $permissions1);
                                                if (in_array(13, $permissions)) { ?>
                                                <button title="Delete" type="button" class="btn btn-sm btn-info waves-effect waves-light medicineid" data-toggle="modal" data-target="#delete_modal-<?php if (!empty($value->hsn_num)) { echo $value->hsn_num; } ?>"><i class="fa-solid fa fa-trash"></i></button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="delete_modal-<?php if (!empty($value->hsn_num)) { echo $value->hsn_num; } ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                        <a href="<?php echo base_url(); ?>Hsn/delete_hsn/<?php echo $value->hsn_num; ?>"><button type="button" class="btn btn-danger">YES</button></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach;?>
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

<!-- Modal -->
<div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update HSN</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form  id="employeefORM" class="form-horizontal" enctype="multipart/form-data" accept-charset="utf-8">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">HSN Number</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="hsn_num" id="hsn_num" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">

                                                <div class="form-group row">

                                                    <label class="control-label text-right col-md-3">GST</label>

                                                    <div class="col-md-9">

                                                        <input type="text" name="igst" id="igst" class="form-control"  >

                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-md-6">

                                                <div class="form-group row">

                                                    <label class="control-label text-right col-md-3">CGST</label>

                                                    <div class="col-md-9">

                                                        <input type="text" name="cgst" id="cgst" class="form-control" readonly >

                                                    </div>

                                                </div>

                                                </div>
                                            <div class="col-md-6">

                                                <div class="form-group row">

                                                    <label class="control-label text-right col-md-3">SGST </label>

                                                    <div class="col-md-9">

                                                    <input type="text" name="sgst" id="sgst" class="form-control" readonly >

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
        $(document).ready(function () {
    $(".emmodalid").click(function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        $('#employeefORM').trigger("reset");
        $('#employeeModal').modal('show');
        $.ajax({
            url: '<?php echo base_url();?>Hsn/GetHsnBynum?id=' + id,
            method: 'GET',
            dataType: 'json',
        }).done(function (response) {
            console.log(response);
            $('#employeefORM').find('[name="hsn_num"]').val(response.hsn_num);
            $('#employeefORM').find('[name="igst"]').val(response.igst);
            var halfGst = response.igst / 2;
            $('#employeefORM').find('[name="cgst"]').val(halfGst);
            $('#employeefORM').find('[name="sgst"]').val(halfGst);

            $('#sbt_btn').attr('data-id', response.id);
        });
    });

    $('#igst').on('input', function () {
        var igstValue = parseFloat($(this).val());
        if (!isNaN(igstValue)) {
            var halfGst = igstValue / 2;
            $('#cgst').val(halfGst);
            $('#sgst').val(halfGst);
        }
    });

    $("#sbt_btn").on("click", function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var id = $(this).attr('data-id');
        var hsn_num = $('#hsn_num').val();
        var igst = $('#igst').val();
        var sgst = $('#sgst').val();
        var cgst = $('#cgst').val();
        vdata = {hsn_num: hsn_num, igst: igst, sgst: sgst, cgst: cgst};
        $.ajax({
            url: '<?php echo base_url();?>Hsn/update_hsn?id=' + id,
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
$('#example89').dataTable( {
        "aaSorting": [[3,'desc']],
        "ordering": false,
            dom: 'Bfrtip',
            buttons: [
                            {
                                extend: 'copy',
                                title: 'HSN Numbers List'
                            },
                            {
                                extend: 'excel',
                                title: 'HSN Numbers List'
                            },
                            {
                                extend: 'pdf',
                                title: 'HSN Numbers List'
                            },
                            {
                                extend: 'print',
                                title: 'HSN Numbers List'
                            }
                        ]
    });
        });
</script> 

<?php 
$this->load->view('backend/footer');
?>