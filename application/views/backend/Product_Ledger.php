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
                                <h4 class="m-b-0 ">Product Ledger Report</h4>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <form action="" method="post" id="reportsales" enctype="multipart/form-data">
                                    <div class="form-group row align-items-end">
                                    <div class="col-md-3">
                                                <div class="form-group mb-0" >
                                                    <label class="control-label mb-2">Select Medicine</label>
                                                    <select id="medicine_name" name="medicine_name" class="form-control" >
                                                          <option>Select  Medicine</option>
                                                         
                                                    </select>
                                                </div>
                                        </div>
                                        
                                        <div class="col-md-7">
                                        <label class="control-label text-right col-md-3">Date</label>
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

                                    <th>Sr. No</th>

                                    <th>In</th>
                                            
                                    <th>Out</th>
                                    <th>Balance</th>
                                    <th>Patient Name</th>
                                    <th>Batch Number</th>

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
                    url: "GETProductLedgerPort",
                    dataType: 'html',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    success: function(data) {
                        // console.log(response);
                        if ($.fn.DataTable.isDataTable('#myTable55')) {
                            $('#myTable55').DataTable().destroy();
                        }
                        $("#Salesreport").html(data);
                        
                        $('#myTable55').DataTable( {
                  order:[[0,"asc"]],
                    "columnDefs": [
                        {
                            "targets": [ 0 ],
                            "visible": false,
                            "searchable": false
                        }
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                            {
                                extend: 'copy',
                                title: 'Product Ledger Report'
                            },
                            {
                                extend: 'excel',
                                title: 'Product Ledger Report'
                            },
                            {
                                extend: 'pdf',
                                title: 'Product Ledger Report'
                            },
                            {
                                extend: 'print',
                                title: 'Product Ledger Report'
                            }
                        ]
                } );
                        


                    },
                    error: function(response) {
                        console.error();
                    }
                });

            });

        });
    </script>
    <script>
$("#medicine_name").on("change", function() {
  var id = this.value;
  $('#supplier').val(id);

});
          </script>

          <script>
       $(document).ready(function(){
          $.ajax({
            url: "<?php echo base_url(); ?>purchase/get_medicine",
            dataType: "json",
            success:function(data){
            $.each(data, function(key, value) {  
            $('#medicine_name').append($("<option></option>").attr("value", value.product_id).text(value.product_name)); 
          });
            }
          });
        });
            </script>

            <script>
              $('#add_btn').on("click", function(e){
                e.preventDefault();
                
                
                 var m_id = $('#supplier').val();
                 $.ajax({
                url: 'medicinebysupplierId?id=' + m_id,
                method: 'GET',
                data: '',
                }).done(function (response) {
                 // console.log(response);
                  //   var rows = $('table').find("#medicine");
                  $("#Salesreport").html(data);
                    });
                    return false;
              });
              </script>
              
    <?php
    $this->load->view('backend/footer');
    ?>