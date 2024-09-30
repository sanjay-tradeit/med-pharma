<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
?>
 <?php //echo date('Y-m-d H:i:s') ?>
        <div class="page-wrapper">

            <div class="row page-titles">

                <div class="col-md-5 align-self-center">

                    <h3 class="text-themecolor">Sales</h3>

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

                                <h4 class="m-b-0 text-white"> Sales Return Report</h4>

                            </div>

                            <div class="card-body">

                                <div class="table-responsive ">

                                    <table id="example28812" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">

                                        <thead>

                                            <tr>

                                                <th>Product Name</th>
                                                <th>Return Quantity</th>
                                                <th>Total Amount</th>
                                                <th>Deduction</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <!-- <tfoot>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Return Quantity</th>
                                                <th>Total Amount</th>
                                                <th>Deduction</th>
                                                <th>Date</th>
                                            </tr>
                                        </tfoot> -->
                                        <tbody>
                                           <?php foreach($returndetails as $value): ?>
                                            <tr>
                                                <td><?php echo $value->product_name ?></td>
                                                <td><?php echo $value->r_qty ?></td>
                                                <td>
                                                    <?php echo '₹ ' .$value->r_total; ?>
                                                </td>
                                                   <td>
                                                    <?php echo '₹ ' .$value->r_deduction; ?>
                                                </td>
                                                <td><?php echo $value->date;?></td>
                                            </tr>

                                            <?php endforeach; ?>

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
    $(document).ready(function() {
$('#example28812').dataTable( {
        // "aaSorting": [[3,'desc']],
         "ordering": false,
            dom: 'Bfrtip',
            buttons: [
                            {
                                extend: 'copy',
                                title: 'Sales Return Details'
                            },
                            {
                                extend: 'excel',
                                title: 'Sales Return Details'
                            },
                            {
                                extend: 'pdf',
                                title: 'Sales Return Details'
                            },
                            {
                                extend: 'print',
                                title: 'Sales Return Details'
                            }
                        ]
    });
        });
</script> 
<?php 

    $this->load->view('backend/footer');

?>