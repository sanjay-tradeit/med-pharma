<?php
$this->load->view('backend/header');
$this->load->view('backend/sidebar');
?>
<div class="page-wrapper">

    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">Closing Stock Report</h3>

        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item ">Closing Stock Report</li>
            </ol>

        </div>

    </div>

    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="m-b-0 ">Closing Stock Report</h4>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <form action="" method="post" id="reportsales" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Date</label>
                                        <div class="col-md-7">
                                            <div class="input-daterange input-group" id="date-range">
                                                <!-- <input type="text" class="form-control start" name="start" /> -->
                                                <!-- 
                                                <span class="input-group-addon bg-info b-0 text-white">to</span> -->

                                                <input type="text" class="form-control end" name="end" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="submit" name="purchase" class="form-control reportsales" placeholder="" value="Submit">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive ">
                                <table id="myTable88" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Medicine Name</th>
                                            <th>Type</th>
                                            <th>Supplier ID</th>
                                            <th>Batch Number</th>
                                            <th>Product Id</th>
                                            <th>Expiry Date</th>
                                            <th>UNIT_MRP_SALE PRICE</th>
                                            <th>UNIT_PUR_ PRICE WITH TAX</th>
                                            <th>Stock</th>
                                            <th>Sale_Value</th>
                                            <th>Purchase_value</th>


                                        </tr>
                                    </thead>

                                    <tbody id="Salesreport">

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <footer class="footer"> © <?php echo date("Y"); ?> Med Jacket</footer>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".reportsales").on('click', function(event) {

                event.preventDefault();
                //     var start = $(".end").val();
                //    console.log(start);
                var formval = $('#reportsales')[0];
                var data = new FormData(formval);
                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: "<?php echo base_url(); ?>Invoice/GETStockclosingrePort",
                    dataType: 'html',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    success: function(data) {
                        // console.log(response);
                        $("#Salesreport").html(data);
                        if ($.fn.DataTable.isDataTable('#myTable88')) {
                            $('#myTable88').DataTable().destroy();
                        }
                        $('#myTable88').DataTable({

                            order:[[0,"desc"]],
                    "columnDefs": [
                        {
                            //"targets": [ 0 ],
                            "visible": false,
                            "searchable": false
                        }
                    ],
                            dom: 'Bfrtip',
                            buttons: [
                            {
                                extend: 'copy',
                                title: 'Closing Stock Report'
                            },
                            {
                                extend: 'csv',
                                title: 'Closing Stock Report'
                            },
                            {
                                extend: 'excel',
                                title: 'Closing Stock Report'
                            },
                            {
                                extend: 'pdf',
                                title: 'Closing Stock Report'
                            },
                            {
                                extend: 'print',
                                title: 'Closing Stock Report'
                            }
                        ]
                    });
                },
                    error: function(response) {
                        console.error();
                    }
                });

            });

        });
    </script>
    <?php
    $this->load->view('backend/footer');
    ?>