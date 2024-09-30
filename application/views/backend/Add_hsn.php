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
    <div class="container-fluid p-t-10">
        <div class="row m-b-10">
            <div class="col-12">
                <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Hsn/Viewhsn" class="text-white"><i class="" aria-hidden="true"></i> Manage HSN </a></button>
              
            </div>
        </div>
        <div class="flashmessage"></div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">New HSN <span class="pull-right"><?php date_default_timezone_set("Asia/Kolkata");
                                                                                                    echo date("l jS \of F Y h:i:s A") ?></span></h4>

                                                                                                    
                    </div>
                    <div class="card-body">
                        
                        <form action="" method="post" class="form-horizontal" id="formid" accept-charset="utf-8">
                        <div class="pur_inputs add-purchase">
                          
                        <div class="row">
                        <div class="col-md-3">
                            <div class="form-group" style="margin-bottom: 15px">
                                <label class="control-label">HSN Number</label>
                                <input  type="text" class="form-control hsn_num" name="hsn_num" placeholder="HSN number" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" style="margin-bottom: 15px">
                                <label class="control-label">GST </label>
                                <input  type="text" name="igst" id="po_no" class="form-control igst" placeholder="GST" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" style="margin-bottom: 15px">
                                <label class="control-label">CGST</label>
                                <input class="form-control cgst" placeholder="CGST" name="cgst" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" style="margin-bottom: 15px">
                                <label class="control-label">SGST</label>
                                <input class="form-control sgst" placeholder="SGST" name="sgst" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>

                        </div>
                        <div class="form-actions text-center">
                                        <div class="row">
                                            <div class=" col-md-12 ">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-info" id="submit_btn">Submit</button>
                                                <button type="button" class="btn btn-inverse">Cancel</button> 
                                                </div>   
                                                <br>
                                                <br>
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
$(document).ready(function() {
    $(".igst").on('input', function() {
        var igstValue = parseFloat($(this).val());

        if (!isNaN(igstValue)) {
            var halfIgst = igstValue / 2;

            $(".cgst").val(halfIgst);
            $(".sgst").val(halfIgst);
        }
    });

    $('#formid').on('submit', function(e) {
        e.preventDefault();

        var hsn = $(".hsn_num").val();
        var igst = $(".igst").val();
        var cgst = $(".cgst").val();
        var sgst = $(".sgst").val();

        var errorMessage = '';

        if (hsn.trim() === '' || igst.trim() === '' || cgst.trim() === '' || sgst.trim() === '') {
            errorMessage = "All fields are required.";
        } else if (hsn.indexOf(' ') >= 0) {
            errorMessage = "HSN code should not contain spaces.";
        }

        if (errorMessage) {
            $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(errorMessage);
            return;
        }

        $.ajax({
            type: 'POST',
            enctype: "multipart/form-data",
            url: "Savehsn",
            dataType: 'json',
            cache: false,
            data: {
                hsn_num: hsn,
                igst: igst,
                cgst: cgst,
                sgst: sgst
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
});

</script>




<?php
$this->load->view('backend/footer');
?>
