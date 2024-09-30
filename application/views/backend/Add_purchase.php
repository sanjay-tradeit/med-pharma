<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
?>
        <div class="page-wrapper">     
        <style>
           .table td, .table th {
    border-color: #f7f5f5;
}
            </style>
            <div class="container-fluid p-t-10">
                <div class="row m-b-10"> 
                    <div class="col-12">
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="purchase" class="text-white"><i class="" aria-hidden="true"></i> Manage Purchase </a></button>
                            <button type="button" class="btn btn-primary">
                            <a href="<?php echo base_url();?>Supplier/Create" class="text-white">Add Supplier</a>
                            </button>
                    </div>
                </div>
                   <div class="flashmessage"></div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">                     
                            <div class="card-header">                                
                                <h4 class="m-b-0 text-white">New Purchase <span class="pull-right date-display"><?php date_default_timezone_set("Asia/Kolkata"); echo date("l jS \of F Y h:i:s A") ?></span></h4>
                            </div>
                            <div class="card-body">

                                <div class="pur_inputs add-purchase">

                                    <form action="save_draft" method="post" class="form-horizontal" enctype="multipart/form-data" accept-charset="utf-8" id="purchaseForm"> 

                                        <div class="row">
                                            
                                        <div class="col-md-3">
                                                <div class="form-group" style="margin-bottom: 15px">
                                                <label class="control-label mb-2">Supplier Name</label>
                                                <select class="form-control select2 supplier" name="supplier_name" id="supplier_name" requird style="width:100%" autocomplete="off">
                                                          <option value="">Select Supplier</option>
                                                           <?php foreach($supplierList as $value): ?>
                                                            <option value="<?php echo $value->s_id; ?>"><?php echo $value->s_name; ?></option>
                                                            <?php endforeach; ?> 
                                                </select>
                                                        <!-- <input type="text" class="form-control supplier_name" name="supplier_name" placeholder="Company Name..."  id="supplier_name" autocomplete="off">  -->
                                                        <input type="hidden" class="form-control supplier" name="supplier"  id="supplier" autocomplete="off">  
                                                        <input type="hidden" class="form-control supplier" name="supplier1"  id="supplier1" autocomplete="off">                                                
                                                </div>
                                            </div> 
                                            

                                            <div class="col-md-3">
                                                <div class="form-group" style="margin-bottom: 15px">
                                                    <label class="control-label mb-2">Invoice No</label>
                                                    <input type="text" id="firstName" name="invoice" class="form-control" placeholder="Invoice No" value="" autocomplete="off" >
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group" style="margin-bottom: 15px">
                                                    <label class="control-label mb-2">Invoice Date</label>
                                                    <input type="text" id="datepicker" class="form-control datepicker" placeholder="" name="entrydate"  autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group" style="margin-bottom: 15px">
                                                    <label class="control-label mb-2">Note</label>
                                                    <textarea type="text" name="details" class="form-control" placeholder="Details"  rows="1" cols="8"></textarea>
                                                </div>
                                            </div> 
                                            
                                            
                                            
                                            
                                        </div>
                                        <div class="row">
                                        <div class="col-md-3">
                                                <div class="form-group" style="margin-bottom: 15px">
                                                    <label class="control-label mb-2">Medicine</label>
                                                    <a  style="font-size:20px;color: #1976d2;float: right;cursor: pointer;" onclick="refreshmedicines(0)"><i class="fa fa-refresh"></i></a>
                                                    
                                                    <select id="medicine_name" name="medicine_name" class="form-control" >
                                                          <option>Select  Medicine</option>
                                                         
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col-md-3">
                                                <div class="form-group" style="margin-bottom: 15px">
                                                    <label class="control-label mb-2">Delivery Time(Days)</label>
                                                    <input type="number"  name="delivery_time" class="form-control delivery_time" placeholder="Delivery time"  autocomplete="off" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group" style="margin-bottom: 15px">
                                                    <label class="control-label mb-2">Payment Time(Days)</label>
                                                    <input type="number" name="payment_time" class="form-control payment_time" placeholder="Payment time"  autocomplete="off" >
                                                </div>
                                            </div>

                                            
                                        </div>
                                        <!-- <input type = "button" value="Add"> -->
                                        <!-- <a id="add_btn">Add</a> -->
                                        <button  class="btn btn-info" id="add_btn">ADD</button>
                                    <table class="table table-bordered m-t-5 pos_table  purchase">

                                        <thead>
                                            <tr>
                                                <th style="width:15%">Medicine</th>
                                                <th>G.Name</th>
                                                <th>Form</th>
                                                <th>Unit</th>
                                                <th>Batch code</th>
                                                <th>Exp. Date</th>
                                                
                                                <th>Qty</th>
                                                <th>Free Qty</th>
                                                <th>Purchase Rate</th>
                                                <th>MRP</th>
                                                <!-- <th>MRP per Unit</th> -->
                                                <th>Disc.(%)</th>
                                                <th>Tax</th>
                                                <th>Total</th>
                                                <th></th>
                                                <th></th>
                                                <!-- <th>Add</th> -->
                                            </tr>
                                        </thead>
                                        <tbody id="addPurchaseItem">

                                        </tbody>
                                        <tfood> 
                                        <tr>
                                                <td class="text-right font-weight-bold" colspan=11>Total:</td>
                                                <td colspan="2"><input type="text" class="form-control sumAmount" name="sumAmount" placeholder="0.00" readonly="" value=""></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right font-weight-bold" colspan=11>Tax:</td>
                                                <td colspan="2"><input type="text" class="form-control sumTax" name="sumTax" placeholder="0.00" readonly="" value=""></td>
                                            </tr>
                                            <!-- <tr>
                                                <td class="text-right font-weight-bold" colspan=11>Discount:</td>
                                                <td colspan="2"><input type="text" class="form-control Discount" name="Discount" placeholder="0.00" readonly="" value=""></td>
                                            </tr> -->
                                            <tr>
                                                <td class="text-right font-weight-bold" colspan=11>Grand Total:</td>
                                                <td colspan="2"><input type="text" class="form-control gtotal" name="grandamount" placeholder="0.00" readonly="" value=""></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right font-weight-bold" colspan=11>Adjustment(+/-):</td>
                                                <td colspan="2"><input type="text" class="form-control adjustment" name="billadjustment" placeholder="0.00"  value=""></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right font-weight-bold" colspan=11>Total Paid:</td>
                                                <td colspan="2"><input type="text" class="form-control paid" name="paid" placeholder="0.00" value=""></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right font-weight-bold" colspan=11>Total Due:</td>
                                                <td colspan="2"><input type="text" class="form-control due" name="due" placeholder="0.00" readonly="" value=""></td>
                                            </tr>
                                            <tr id="payform">
                                                <td><select name="mtype" id="mtype" class="form-control" >
                                                            <option value="Cash">Cash</option>
                                                            <option value="UPI">UPI</option>
                                                            <option value="Card">Card</option>
                                                            <option value="Credit">Credit</option>
                                                            <option value="Cheque">Cheque</option>
                                                        </select></td>
                                                <td id="bankid"><select class="select2 form-control" name="bankid" style="width:100%" > 
                                                          <option value="">Select Bank..</option>
                                                           <?php foreach($bankinfo as $value): ?>
                                                            <option value="<?php echo $value->bank_id; ?>"><?php echo $value->bank_name; ?></option>
                                                            <?php endforeach; ?>       
                                                        </select></td>
                                                <td id="cheque"><input type="text" name="cheque"  class="form-control" placeholder="Cheque No..." ></td>
                                                <td id="issuedate"><input type="text" name="issuedate"  class="form-control datepicker" placeholder="Issue Date" value=""></td> 
                                                <td><input type="text" name="rname" id="rname" class="form-control" placeholder="Receiver Name" value=""></td> 
                                                <td><input type="number" name="rcontact" id="rcontact" class="form-control" placeholder="Receiver Contact" value=""></td>
                                                <td><input type="text" name="paydate" class="form-control datepicker" placeholder="Pay Date" value=""></td> 
                                                <td class="text-right" > <input type="submit" id="purchasesubmit" class="btn btn-primary btn-block" value="Review Order" style="color:white"> </td>                                                      
                                            </tr>
                                        </tfood>
                                    </table>
                                    <?php 
                                    $CI     = & get_instance();
                                    $last_id = $CI->get_lastid();
                                    
                                    
                                    if(!empty($last_id )){$last = $last_id->id;}else{$last =0; }
                                    $last_idd = $last + 1; 
                                    ?>
                                    <button class="btn btn-info float-right" type="submit"  id="save_draft">Save Draft</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
<!--Modal-->
<div class="modal fade" id="reviewmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="width:1239px;margin-left: -197px">
      <div class="modal-header">
        <img src="<?php echo base_url(); ?>assets/images/invoiceimg.png" height="80" width="110" style="margin-left:330px" alt="homepage" class="dark-logo" />
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action='' method='post' class='form-horizontal' enctype='multipart/form-data' accept-charset='utf-8' id='ReviewForm'>
      <div class="modal-body" id="reviewDom">

      </div>
      <div class="modal-footer">
        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <input type="submit" name="submit" class="btn btn-info" id="FinalSubmitBar" value="Barcode"> -->
        <input type="submit" name="submit" class="btn btn-info" id="FinalSubmit" value="Submit">
        <input type="submit" name="submit" class="btn btn-info" id="FinalPrint" value="Print & Submit">
      </div>
        </form>
    </div>
  </div>
</div>
<!--Invoice and print view Modal-->
<div class="modal fade" id="invoicemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="75%" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <img src="<?php echo base_url(); ?>assets/images/invoiceimg.png" height="80" width="110" style="margin:auto" alt="homepage" class="dark-logo" />
        <button type="button" id="closebutton" class="" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="invoicedom">

      </div>
      <div class="modal-footer">
        <div class='text-right'>
            <input id='print' class='btn btn-default btn-outline print' type='submit' value='Print'>
        </div>
      </div>
    </div>
  </div>
</div> 
<!--barcode view Modal-->
<div class="modal fade" id="barcodemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="75%" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="closel" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>      
      </div>
      <div class="modal-body">
        <div id="printArr2" >
            
        </div>
      </div>
      <div class="modal-footer">
        <div class='text-right'>
            <input id='bprint' class='btn btn-default btn-outline print' type='submit' value='Print'>
        </div>
      </div>
    </div>
  </div>
</div>        

   
    <script>
    $(document).on("click","#btn",function() {
      $(this).closest('tr').remove();
});
</script> 
        <!--Payment cash and bank control Info-->
       <script type="text/javascript">
            $(document).ready(function () {           
            $('#mtype').on('change', function(e) {

                e.preventDefault(e);

                // Get the record's ID via attribute  

                var type = $('#mtype').val();
              
                if(type =='Cheque'){
                
                    $('#cheque').show();
                    $('#issuedate').show();
                    $('#bankid').show();
                    $('#rnamr').show();
                    $('#rcontact').show();
                } 

                else if(type =='Cash'){
                    $('#rnamr').show();
                    $('#rcontact').show();
                    $('#cheque').hide();
                    $('#issuedate').hide();
                    $('#bankid').hide();  
                }

            });

                    $('#cheque').hide();
                    $('#issuedate').hide();
                    $('#bankid').hide();                
            });
        </script>                 
            <script>
            $('#purchasesubmit').hide();
                $('#payform').hide();
            </script>
    <!--Purchase calculation-->      
          <script type="text/javascript">
          $(document).ready(function () {
          $(document).on('keyup','.qty, .tradeprice, .mrp, .total, .wholesaler, .gtotal, .paid, .due, .adjustment',function() {
            
            var discountamount = 0;  
            //var total;  
            var adjustment = 0;

            $(".adjustment").each(function() {
            var value = $(this).val();
            var adjustmentValue = parseFloat(value || 0);
            adjustment += adjustmentValue;  
        });
            

            var gtotal = 0; 
            var rows = this.closest('#purchaseForm tr');
            var quantity = $(rows).find(".qty"); 
            var price = $(rows).find(".tradeprice"); 
            var hsn = $(rows).find(".hsn"); 
            var wholesaler = $(rows).find(".wholesaler"); 
            var mrp = $(rows).find(".mrp");
            
            var tax = parseFloat($(hsn).val()); 
            var qty = parseFloat($(quantity).val()); 
            var trade = parseFloat($(price).val()); 
            var dis = parseFloat($(wholesaler).val()); 
          
            
            var discount;
            
              if(isNaN(qty) == true){
                  
                  $('#purchasesubmit').hide();
                  $('#payform').hide();
              } else {
                  $('#purchasesubmit').show();
                  
              }
              var total = 0;
              if(isNaN(dis) == true){
                         
              dis = 0;
            }
            else{
              dis = ((trade * qty) * dis)/100;
            }
              if(isNaN(qty) == true){
                  total = 0;

             } else {
                  total = (qty * trade).toFixed(2) - dis; 
              }
            $(rows).find('[name="total[]"]').val(total);

           
            
            
            
           
            var finalDiscount = ((trade * qty) * dis)/100;
            
            tax = Math.abs((total * tax)/100).toFixed(2);
            $(rows).find('[name="tax[]"]').val(tax);
            $(rows).find('[name="discount[]"]').val(dis);
            
            
                    var sum = 0;
                    var dis = 0;

                    $(".total").each(function(index){
                           sum += parseFloat($(this).val()); 
                         
                    });
                    var sumtax = 0;
                    $(".tax").each(function(index){
                      sumtax += parseFloat($(this).val());  
                    });
         
                    $(".discount").each(function(index){
                      dis += parseFloat($(this).val()); 
                         
                    });
                   
             

              $(".sumAmount").val(sum);
              $(".sumTax").val((sumtax).toFixed(2));
              var finalAmount = sum + sumtax + adjustment;
              
              //finalAmount = (finalAmount - dis).toFixed(2);
              finalAmount = (finalAmount).toFixed(2);
              
              $(".gtotal").val(finalAmount);
            var paid = $(rows).find(".paid"); 
            var paidval = parseFloat($(paid).val());
            var gtotal = $(rows).find(".gtotal"); 
            var gtotalv = ($(".gtotal").val(finalAmount));
            var Discount = $(".Discount").val(dis);

           
            
              
              var dueval = 0;
              if(isNaN(paidval) == true){
                  dueval = 0;
                  $('#payform').hide();
             } else {
                 var dueval = finalAmount - paidval;
                 $('#purchasesubmit').show();
                 $('#payform').show();
              }              
              $(".due").val(dueval);
          });
        });

              
          </script> 
          
          <!--Review form calculation-->    
          <!-- <script type="text/javascript">
          $(document).ready(function () {
          $(document).on('keyup','.qtyval, .tardepriceval, .totalval, .tdiscountval, .rpaid, .rdue',function() {
            var discountamount = 0;  
            //var total;  
            var gtotal = 0; 
            var rows = this.closest('#ReviewForm tr');
            var quantity = $(rows).find(".qtyval");
            var hsn = $(rows).find(".hsn"); 
            var price = $(rows).find(".tardepriceval");  
            var qty = parseInt($(quantity).val());
            var tax = parseInt($(hsn).val()); 
            var trade = parseFloat($(price).val()); 
              var total = 0;
              if(isNaN(qty) == true){
                  total = 0;
              } else {
                  total =  Math.round(qty * trade);
                  
              }
            $(rows).find('[name="totalval[]"]').val(total);
            tax = Math.abs((total * tax)/100);
            $(rows).find('[name="tax[]"]').val(tax);
                    var sum = 0;
                    $(".totalval").each(function(index){
                           sum += parseFloat($(this).val());  
                    });
              $(".gtotalval").val(Math.round(sum));
            var rpaid = $(rows).find(".rpaid"); 
            var rpaidval = parseInt($(rpaid).val());
            var gtotal = $(rows).find(".gtotal"); 
            var gtotalv = parseInt($(".gtotal").val(sum));
            tax = Math.round((total * tax)/100);
                 
              console.log(sum);
              
            var rdueval = 0;
              if(isNaN(rpaidval) == true){
                  rdueval = 0;
             } else {
                 var rdueval = sum - rpaidval;
              }              
              $(".rdue").val(rdueval);              
          });
        }); 
          </script>-->
          <!--Add new purchase-->
        <script type="text/javascript">
                $(document).ready(function () {
                $(".additem").click(function (e) {
                e.preventDefault(e);
                // Get the record's ID via attribute
                    var t=$("tbody#addPurchaseItem tr:first-child").html();
                    $("tbody#addPurchaseItem").append("<tr>"+t+"</tr>");
                    /*$('.select2').select2();*/
                });
                });
</script>
<script>
        function Geeks() {
            document.getElementById("row1").remove();
        }
    </script>
<script>
      $("#supplier_name").on("change", function() {
        var id = this.value;
        $('#supplier1').val(id);

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
                   $("#addPurchaseItem").append(response);
                    });
                    return false;
              });
              </script>

             
<script type="text/javascript">
$(document).ready(function () {
$(document).on('change', ".medicine", function (e) {
e.preventDefault(e);
var parentTR = this.closest('#purchaseForm tr'); 
var iid = +this.value;
$( "#purchaseForm" ).change();
            $.ajax({
             url: 'medicineInfoByMedicineID?id=' + this.value,
             method: 'GET',
             data: '',
            dataType: 'json',
             }).done(function (response) {
          
            $(parentTR).find('[name="strenth[]"]').val(response.medicinevalue.strength).end();
            $(parentTR).find('[name="stock[]"]').val(response.medicinevalue.instock).end();
            $(parentTR).find('[name="tradeprice[]"]').val(response.medicinevalue.purchase_price).end();
            $(parentTR).find('[name="mrp[]"]').val(response.medicinevalue.mrp).end();
			});
      });
    });
</script> 

       <script type="text/javascript">
        $(document).ready(function () {
        $("#purchasesubmit").click(function (event) {
            event.preventDefault();
            var formval = $('#purchaseForm')[0];
            
            var data = new FormData(formval);
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "Purchase_Review",
                dataType: 'html',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
          success: function(response) {
              if(response.status == 'error') { 
              $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);
              } else {
            
            $("#reviewDom").empty();
            $("#reviewDom").append(response);
            $("#ReviewForm").trigger("reset");
            $("#reviewmodal").modal("show");
              }              
          },
          error: function(response) {
            console.error();
          }
            });

        });

    });
    </script>
      <!-- Print and Submit-->           
       <script type="text/javascript">
        $(document).ready(function () {
        $("#FinalPrint").on('click',function (event) {
            event.preventDefault();    
            var formval = $('#ReviewForm')[0];
            var data = new FormData(formval);
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "Save_Purchase_Invoice",
                dataType: 'html',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 2000,
               success: function(response){
                //console.log(response);
                $("#invoicedom").html(response);
                $('#ReviewForm').modal('hide');
                $(this).hide();
                $("#invoicemodal").modal("show");             
          },
          error: function(response){
            console.error();
          }
        });
        });

    });
    </script>            
       <script type="text/javascript">
        $(document).ready(function () {
        $("#FinalSubmitBar").on('click',function (event) {
            event.preventDefault();    
            var formval = $('#ReviewForm')[0];
            var data = new FormData(formval);
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "Save_Purchase_Bar",
                dataType: 'html',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function(response){
                
                $("#printArr2").html(response);
                $('#ReviewForm').modal('hide');
                $(this).hide();
                $("#barcodemodal").modal("show");             
          },
          error: function(response){
            console.error();
          }
        });
        });

    });
    </script> 
              
       <script type="text/javascript">
        $(document).ready(function () {

        $("#FinalSubmit").on('click',function (event) {
            event.preventDefault();
          //  var storeid = $('#delivery').val();
            var formval = $('#ReviewForm')[0];
            var sumtax = $('.sumTax').val();
            var delivery_time = $('.delivery_time').val();
            var payment_time = $('.payment_time').val();
            var freeqty = $('.freeqty').val();

            var data = new FormData(formval);
            data.append('sumtax',sumtax);
            
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "Save_Purchase",
                dataType: 'json',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
            success: function(response) {
              
            
              if(response.status == 'error') { 
              $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);
              } else if(response.status == 'success'){
                  $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);
                    window.setTimeout(function() {
                    window.location = response.curl;
                }, 2000);
              }              
          },
          error: function(response) {
            console.error();
          }
            });
            });

    });
    </script> 
    <script>
      $('#FinalSubmit').on("click", function(){
        
        var invoice = $('#firstName').val();
        if(invoice== '')
        {
          
          
        }else{
          
           
        }
        
      });
      </script>
            <footer class="footer"> © <?php echo date("Y");?> Med Jacket</footer>

        </div>
<?php 

    $this->load->view('backend/footer');

?>
<script>
    $(document).ready(function() {
        $("#print").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div#invoicedom").printArea(options);
        });
    });
    </script>
<script>
    $(document).ready(function() {
        $(".close").click(function() {
            location.reload()
        });
    });
    </script>
    
<script>
    $(document).ready(function() {
        $("#bprint").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
           
            $("div#printArr").printArea(options);
            
        });
    });
    </script>
    <script>
$(document).on("click", "#appended_check", function(){
   var id = $(this).data("id")

  $.ajax({
            url: "<?php echo base_url(); ?>Purchase/append_checkbox_data",
            type: "post",
            data: { id: id },
            dataType: 'html',
            success: function(data) {
                
                $('#addPurchaseItem').append(data);
            }
        });
});
</script>
<script>
    $(document).ready(function() {
        $("#closebutton").click(function() {
            location.reload()
        });

        
});
    </script>
    <script>
      function refreshmedicines() {
         
            $.ajax({
            url: "<?php echo base_url(); ?>Medicine/Getallmeds",
            type: "get",
            //data: { id: id },
            dataType: 'html',
            success: function(data) {
              //console.log(data);
                
                //$('#medicine_name').text(data);
                //$("#medicine_name").empty().append(data);

                var $el = $("#medicine_name");
                    $el.empty(); // remove old options
                    $.each(JSON.parse(data), function(key,value) {
                      $el.append($("<option></option>")
                        .attr("value", value).text(key));
                    });
            }
        });
            
        } 


        //function refreshunits() {
          $(document).on("click","#refresh",function(){
          

          var value = $(this).data('pid');

          var target = 'units'+value

          
        
         $.ajax({
         url: "<?php echo base_url(); ?>Medicine/Getallunitbyform",
         type: "post",
         data: { medid: value },
         dataType: 'html',
         success: function(data) {
           //console.log(data);
             
             

             var $el = $("#" +target);
                 $el.empty(); // remove old options
                 $.each(JSON.parse(data), function(key,value) {
                   $el.append($("<option></option>")
                     .attr("value", value).text(key));
                 });
         }
     });
         
     }); 
    </script>

    