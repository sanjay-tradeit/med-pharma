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
                                <h4 class="m-b-0 ">Sales Report</h4>
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
                                                <input type="text" class="form-control start"  name="start" value ="<?php echo $this->input->get('from', TRUE);?>"/>

                                                <span class="input-group-addon bg-info b-0 text-white">to</span>

                                                <input type="text" class="form-control end" name="end" value ="<?php echo $this->input->get('to', TRUE);?>"/>
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
                                        <th>Invoice Date</th>
                                        <th>Invoice Number</th>
                                        <th>Customer Name</th>                                        
                                        <th>Total Amount (INR)</th>
                                        <th>Paid Amount (INR)</th>
                                        <th>Due Amount (INR)</th>
                                        <th>Note</th>                                            
                                        </tr>
                                    </thead>
                                    
                                    <tbody id="Salesreport"> 
                                    <?php

                                // $start = $this->input->get('from', TRUE);
                                // $end = $this->input->get('to', TRUE);
                                // if($start != '' && $end !=''){
                                //     $medicine_quantities = array();
                                //     foreach($invoice_details as $value):
                                        
                                //         $get_cus_name = $this->purchase_model->get_cus_name($value->c_id);
                                //         $cus = $get_cus_name[0]->c_name;
                                //         $get_medicine_name = $this->purchase_model->get_medicine_name($value->mid);
                                //         $med_name = ($get_medicine_name[0]->product_name);
                                //         $generic_name = $get_medicine_name[0]->generic_name;
                                //         $form = $get_medicine_name[0]->form;
                                    

                                //         $create =  $value->create_date;
                                //         $dateObj = date_create_from_format('d/m/Y',$create);
                                //         $datae = date_format($dateObj,'d/m/Y');
                                //         $add_quanty = $this->purchase_model->add_quanty($value->mid, $value->supplier_id, $value->Batch_Number, $start5,$END5);
                                //         $qty = ($add_quanty[0]->qty);
                            
                                //     echo"<tr>
                                //         <td>$datae</td>
                                //         <td>$value->mid</td>
                                //         <td>$med_name</td>
                                //         <td>$form</td>
                                //         <td>$cus</td>                                                                              
                                //     </tr>";
                                //     endforeach; }?>
                        

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
                    url: "GETSALESrePort",
                    dataType: 'html',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    success: function(data) {
                        // console.log(response);
                        $("#Salesreport").html(data);
                        //$('#myTable').DataTable();
                        if ($.fn.DataTable.isDataTable('#myTable55')) {
                            
                            $('#myTable55').DataTable().destroy();
                        }
                        $('#myTable55').DataTable( {
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
                                title: 'Sales Report'
                            },
                            {
                                extend: 'excel',
                                title: 'Sales Report'
                            },
                            {
                                extend: 'pdf',
                                title: 'Sales Report'
                            },
                            {
                                extend: 'print',
                                title: 'Sales Report'
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
        function refreshTable() {

}
    </script>

    <?php
    $this->load->view('backend/footer');
    ?>