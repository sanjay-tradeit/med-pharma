<?php
$this->load->view('backend/header');
$this->load->view('backend/sidebar');
?>
<style>
    b {
        font-weight: 500;

    }
</style>
<div class="page-wrapper">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Report</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item ">Report</li>
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
                                <h4 class="m-b-0 ">Purchase Return Report</h4>
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
                                                <input type="text" class="form-control start" name="start" />

                                                <span class="input-group-addon bg-info b-0 text-white">to</span>

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
                            <div class="table-responsive">
                                <table id="myTable55" class="display nowrap table table-hover table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%">
                                <thead>

                                            <tr>
                                                <th>Invoice No</th>
                                                <th>Supplier Name</th>
                                                <th>Return Date</th>
                                                <th>Total Amount (INR)</th>
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
                var formval = $('#reportsales')[0];
                var data = new FormData(formval);
                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: "GETPurchaseReturnrePort1",
                    dataType: 'html',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    success: function(data) {
                        // console.log(response);
                        
                        $("#Salesreport").html(data);
                        if ($.fn.DataTable.isDataTable('#myTable55')) {
                            $('#myTable55').DataTable().destroy();
                        }
                        $('#myTable55').DataTable( {
                  order:[[0,"desc"]],
                    "columnDefs": [
                        {
                            // "targets": [ 0 ],
                            "visible": false,
                            "searchable": false
                        }
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                            {
                                extend: 'copy',
                                title: 'Purchase Return Report'
                            },
                            {
                                extend: 'excel',
                                title: 'Purchase Return Report'
                            },
                            {
                                extend: 'pdf',
                                title: 'Purchase Return Report',
                                
                            },
                            {
                                extend: 'print',
                                title: 'Purchase Return Report'
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