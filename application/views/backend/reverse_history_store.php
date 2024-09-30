<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
?>
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Reverse Requested Stock History</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item ">Reverse Requested Stock History</li>
                    </ol>
                </div>
            </div>
        
            <div class="container-fluid">
            <div class="flashmessage"></div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Reverse Requested Stock History</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Request Id</th>
                                                <th>Product Name</th>
                                                <th>Generic Name</th>
                                                <th>Batch No.</th>
                                                <th>Expire Date</th>
                                                
                                                <th>Requested Qty</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <?php 
                                               foreach($reversehistory as $val)
                                               { ?>
                                            <tr>
                                                
                                                <td> <?php echo $val->request_id; ?> </td>
                                                <td><?php echo $val->product_name;?>(<?php echo $val->strength ?>)</td>
                                                <td> <?php echo $val->generic_name;  ?></td>
                                                <td> <?php echo $val->Batch_Number; ?></td>
                                                <td> <?php echo $val->expire_date; ?></td>
                                                
                                                <td> <?php echo $val->qty; ?></td>
                                                
                                                <td class="jsgrid-align-center ">

                                                <?php if($val->rev_status == 0){ ?>
                                                   <a data-med-batch="<?php echo $val->Batch_Number; ?>" data-supp-id="<?php echo $val->supplier_id; ?>" data-med-qnty="<?php echo $val->qty; ?>" data-med-id="<?php echo $val->product_id; ?>" data-req-id="<?php echo $val->request_id; ?>" target="_blank" href="" id="approveMed" title="Approve" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-check"></i></a> 

                                                   <?php } else echo "Returned"; ?>
                                                </td>
                                            </tr>
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
    $(document).on("click", '#approveMed', function(e) {
        e.preventDefault();

        var reqID = $(this).data('req-id');
        var supID = $(this).data('supp-id');
        var medID = $(this).data('med-id');
        var medQty = $(this).data('med-qnty');
        var medBth = $(this).data('med-batch');

        rdata = { reqID: reqID, supID: supID, medID: medID, medQty: medQty, medBth: medBth };
       
        $.ajax({
            url: "<?php echo base_url(); ?>Invantory/stock_return_update",
            type: "POST",
            dataType: 'json',
            data: rdata,
            success: function(response) {


                if (response.status == 'success') {
                   
                        $(".flashmessage").fadeIn('fast').delay(2000).fadeOut('fast').html(response.message);
                        window.setTimeout(function() {
                            window.location = response.curl;
                        }, 2000);
                       
                    }
                //alert(response);

            },
            error: function(response) {
                console.error();
            }
        });
    });
</script>        
         
<?php 

    $this->load->view('backend/footer');

?>