<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
?>
        <div class="page-wrapper">

            <div class="container-fluid p-t-10">

             <div class="flashmessage"></div>

                <div class="row m-b-10"> 

                    <div class="col-12">

                        <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url('accounts/Payment');?>" class="text-white"><i class="" aria-hidden="true"></i>Payment</a></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">All Payment </h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="example28801" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                            
                                                <th class="w-p-20">Name</th>
                                                <th class="w-p-15">Payment Type</th>
                                                <th class="w-p-10">Description </th>
                                                <th class="w-p-15">Amount</th>
                                                <th class="w-p-10">Date</th>                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($payment as $val){?>
                                               
                                                <td><?php echo $val->transection_name; ?></td>
                                                <td><?php echo $val->mtype ;?></td>
                                                <td><?php echo $val->description; ?></td>
                                                <td><?php echo $val->amount; ?></td>
                                                <td><?php if(!empty($val->date)){echo $val->date;}  ?> </td>
                                               
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


            </div>
      </form>
    </div>
  </div>
</div>

           
              
                                          
                
                           

            <footer class="footer"> © <?php echo date("Y");?> Med Jacket</footer>

       
        </div>
        <script>
    $(document).ready(function() {
$('#example28801').dataTable( {
        // "aaSorting": [[3,'desc']],
         //"ordering": false,
            dom: 'Bfrtip',
            buttons: [
                            {
                                extend: 'copy',
                                title: 'All Payment List'
                            },
                            {
                                extend: 'excel',
                                title: 'All Payment List'
                            },
                            {
                                extend: 'pdf',
                                title: 'All Payment List'
                            },
                            {
                                extend: 'print',
                                title: 'All Payment List'
                            }
                        ]
    });
        });
</script> 
<?php 
$this->load->view('backend/footer');
?>