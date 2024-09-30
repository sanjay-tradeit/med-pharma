<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Sales Summary</title>

    <!-- Ensure you have included these libraries elsewhere in your project -->
    <!-- DataTables CSS -->
    <!-- <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet" /> -->
    <!-- Buttons CSS -->
    <!-- <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet" /> -->

    <!-- jQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    
    <!-- DataTables JS -->
    <!-- <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> -->
    
    <!-- Buttons JS -->
    <!-- <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script> -->
</head>
<body>

    <?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar');
    ?>

    <div class="page-wrapper">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Department Sales Summary</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item">Department Sales Summary</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row m-b-10"> 
                <div class="col-12"></div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="m-b-0">Department Sales Summary</h4>
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
                                                <input type="submit" name="purchase" class="form-control reportsales" value="Submit">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="example283333" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Sr. No</th>
                                                <th>Department Name</th>
                                                <th>GIN Pur Value</th>
                                                <th>GIN Sales Value</th>
                                            </tr>
                                        </thead>
                                        <tbody id="Salesreport">
                                            <!-- Data will be dynamically inserted here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer"> © <?php echo date("Y"); ?> Med Jacket</footer>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            // Initialize DataTable
            var table = $('#example283333').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', title: 'Department Sale Report' },
                    { extend: 'excel', title: 'Department Sale Report' },
                    { extend: 'pdf', title: 'Department Sale Report' },
                    { extend: 'print', title: 'Department Sale Report' }
                ]
            });

            // Handle form submission
            $(".reportsales").on('click', function(event) {
                event.preventDefault();
                var formval = $('#reportsales')[0];
                var data = new FormData(formval);
                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: "Department",
                    dataType: 'html',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    success: function(response) {
                        // Clear existing data
                        table.clear().draw();
                        
                        // Insert new data
                        $('#Salesreport').html(response);

                        // Add new data to DataTable
                        table.rows.add($('#Salesreport').find('tr')).draw();
                    },
                    error: function(response) {
                        console.error('Error:', response);
                    }
                });
            });
        });
    </script>
    
    <?php $this->load->view('backend/footer'); ?>
</body>
</html>
