<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
?>

        <div class="page-wrapper">
<style>
.file_prev img {height: 44px;width: auto;max-width: 100%;margin-bottom: 0px;margin-right: 0px;margin-top: 0px;}
</style>

            <div class="container-fluid p-t-10">

            <div class="flashmessage"></div>

                <div class="row m-b-10"> 

                    <div class="col-12">

                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url('Medicine/View');?>" class="text-white"><i class="" aria-hidden="true"></i> Manage Medicine </a></button>

                    </div>

                </div>
                
                <div class="row">

                    <div class="col-lg-12">

                        <div class="card card-outline-info">
                            <div class="card-header">                                
                                <h4 class="m-b-0 text-white">New Medicine <span class="pull-right"><?php date_default_timezone_set("Asia/Kolkata"); echo date("l jS \of F Y h:i:s A") ?></span></h4>
                            </div>
                            <div class="card-body">
                                <form action="" method="post" class="form-horizontal" id="formid" enctype="multipart/form-data" accept-charset="utf-8">
                                    <div class="form-body">
                                        <span class="m-t-30 m-b-40"></span>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                <div class="col-md-3 col-sm-12 text-right"></div>
                                                    <div class="col-md-3 col-sm-12 ">
                                                    <input type="radio" id="batch" name="batch" value="batch" checked>
                                                    <label for="batch">Batch</label>
                                                    </div>
                                                    <div class="col-md-3 col-sm-12">
                                                    <input type="radio" id="nonbatch" name="batch" value="non-batch">
                                                    <label for="nonbatch">Non-Batch</label>

                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Manufacturer</label>
                                                    <div class="col-md-9 col-sm-12">  
                                                        <select id="append_supplier" name="supplier_name" class="form-control" >
                                                          <option>Select  Manufacturer</option>                                                         
                                                           </select>
                                                        <input type="hidden" class="form-control supplier" name="supplier"  id="supplier" autocomplete="off"> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <!-- <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Unit</label>
                                                    <div class="col-md-9 col-sm-12">  
                                                        <select id="append_unit" name="unit" class="form-control" >
                                                          <option>Select  Unit</option>                                                         
                                                           </select>
                                                        <input type="hidden" class="form-control unit" name="unit"  id="unit" autocomplete="off"> 
                                                    </div>
                                                </div> -->
                                            </div>
                                            <div class="col-md-6 col-sm-12">

                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Product Name</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="text" onkeyup="checkmedicinename()" name="product_name" id="proname" class="form-control product_name" placeholder="Product name" required minlength="1" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Generic Name</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="text" name="generic_name" class="form-control generic_name" placeholder="Generic name" >
                                                    </div>
                                                </div>
                                            </div>
                                          
                                            <!-- <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Batch Number</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="text" name="" class="form-control Batch_Number" placeholder="Batch number"  required>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Manufacturing date</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="date" name="manf_date" class="form-control manf_date" placeholder="Manufacturing date"  required>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Expiry date</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="date" name="exp_date" class="form-control exp_date" placeholder="Expiry date"  required>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Quantity Approve</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="text" name="" class="form-control quan_approve" placeholder="Quantity approve"  >
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">M.R.P</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="text" name="mrp" id="mrp" class="form-control mrp" placeholder="M.R.P"  >
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Purchase Rate</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="text" name="purchase" id="purchase" class="form-control purchase" placeholder="Purchase rate"  >
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Sale Rate</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="text" name="" class="form-control sale_rate" placeholder="Sale rate"  >
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Strength</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="text" name="strength" class="form-control strength" placeholder="Strength" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Form</label>
                                                    <div class="col-md-3 col-sm-12">
                                                        <select id="medform" name="formSelect" class="select2 formSelect" id="" style="width:100%" >
                                                        <option value="">Select Form</option>
                                                        <?php foreach($medforms as $form): ?>
                                                            <option value="<?php echo $form->id; ?>"><?php echo $form->title; ?></option> 
                                                            <?php endforeach;?>
                                                            
                                                            <!-- <option value="Capsules">Capsule</option>
                                                            <option value="Surgical">Surgical</option>
                                                            <option value="Syrup">Syrup</option>
                                                            <option value="Injection">Injection</option>
                                                            <option value="Eye Drop">Eye Drop</option>
                                                            <option value="Suspension">Suspension</option>
                                                            <option value="Cream">Cream</option>
                                                            <option value="Saline">Saline</option>
                                                            <option value="Inhaler">Inhaler</option>
                                                            <option value="Powder">Powder</option>
                                                            <option value="Spray">Spray</option>
                                                            <option value="Paediatric Drop">Paediatric Drop</option>
                                                            <option value="Nebuliser Solution">Nebuliser Solution</option>
                                                            <option value="Powder for Suspension">Powder for Suspension</option>
                                                            <option value="Nasal Drops">Nasal Drops</option>
                                                            <option value="Eye Ointment">Eye Ointment</option> -->
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12" id="subform" >
                                                        <ul id="medsubform"></ul>
                                                        
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Stripe count</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="number" name="" id="stripe" class="form-control stripe" placeholder="Stripe count" >
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Box size</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="number" name="boxsize" id="boxsize" class="form-control box_size" placeholder="Box size" >
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Box Price</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="number" name="totalboxprice" id="totalboxprice" class="form-control box_price" placeholder="Box price" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Unit Price</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="number" name="" class="form-control unit_price" placeholder="Unit price" >
                                                    </div>
                                                </div>
                                            </div> -->

                                        
                                            <!-- <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Expire Date</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="text" name="expire_date" class="form-control expire_date" placeholder="Expire Date" id="datepicker" required>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Short Quantity</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="number" name="shortstock" class="form-control shortstock" placeholder="Short quantity" id="shortstock" >
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">HSN Number</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="number" name="" class="form-control hsn"  id="hsn" >
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="col-md-6 col-sm-12">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3 col-sm-12">HSN Number</label>
                                                <div class="col-md-9 col-sm-12">
                                                    <select id="hsn_num" name="hsn" class="form-control" required>
                                                        
                                                        <option selected disabled>Select HSN number</option>
                                                    </select>
                                                    <input type="hidden" class="form-control hsn" name="hsn"  id="hsn" autocomplete="off"> 
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Store Short Quantity</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="number" name="storeshort_stock" class="form-control storeshortstock" placeholder="Store short quantity" id="storeshortstock" >
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                   
                                                    <label class="control-label text-right col-md-3 col-sm-3">Product Image</label>
                                                    <div class="col-md-9">
                                                        <input type="file" name="webcam" id="user_image" class="form-control" aria-describedby="fileHelp" value="">
                                                        <div class="file_prev " id="file_prev"></div>
                                                    </div>
                                                   
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Side Effect</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <textarea class="form-control side_effect" name="side_effect" rows="1" placeholder="Side effect"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Minimum Order Qty</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="text" name="min_orderqty" class="form-control minimum" id="minimum" placeholder="Minimum order qty" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Maximum Order Qty</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="text" name="max_orderqty" class="form-control maximum" id="maximum" placeholder="Maximum order qty" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Reorder Qty</label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="text" name="reorder_qty" class="form-control reorder"  id="reorder" placeholder="Reorder order qty" >
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="col-md-3 col-sm-12"></label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input name="favourite" class="custom-control-input favourite" value="1" type="checkbox" id="regular_customer">
                                                        <label for="regular_customer">Add To Favourite</label>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Discount </label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input type="radio" name="discount" class="custom-control-input discount" value="YES"  id="discount_yes" checked>
                                                        <label for="discount_yes">Yes</label>
                                                        <input type="radio" name="discount" class="custom-control-input discount" value="NO"  id="discount_no">
                                                        <label for="discount_no">No</label>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="col-md-6 col-sm-12" style="display:none;">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Take Photo </label>
                                                    <div class="col-md-9 col-sm-12">
                                                            <video id="video" style="border: 1px solid #eef3f3;" width="220" height="180" onclick="takePhoto()" autoplay></video>
                                                           <!-- <button id="btnSnap" onclick="takePhoto()">Snap Photo</button> -->
                                                     </div>
                                                </div>
                                            </div>                                            
                                            <div class="col-md-6 col-sm-12" style="display:none;">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Canvas Photo </label>
                                                    <div class="col-md-9 col-sm-12">  
                                                    <canvas style="border: 1px solid #eef3f3;float:left" id="canvas" width="220" height="180"></canvas> 
                                                    </div>
                                                </div> 
                                            </div>

                                        </div>

                                        

                                    </div>

                                    <hr>

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
            <footer class="footer"> © <?php echo date("Y");?> Med Jacket</footer>
        </div> 

        <script>
        $(document).ready(function(){
          $.ajax({
            url: "<?php echo base_url(); ?>purchase/manufacturer",
            dataType: "json",
            success:function(data){
            $.each(data, function(key, value) {  
            $('#append_supplier').append($("<option></option>").attr("value", value.manufac_id).text(value.m_name)); 
          });
            }
          });
        });
        </script>

<script>
        $(document).ready(function(){
          $.ajax({
            url: "<?php echo base_url(); ?>Medicine/get_units",
            dataType: "json",
            success:function(data){
            $.each(data, function(key, value) {  
            $('#append_unit').append($("<option></option>").attr("value", value.unit).text(value.unit)); 
          });
            }
          });
        });
        </script>


 
        <!-- <script>
        $(document).ready(function(){
          $.ajax({
            url: "<?php //echo base_url(); ?>purchase/supplier_name",
            dataType: "json",
            success:function(data){
            $.each(data, function(key, value) {  
            $('#append_supplier').append($("<option></option>").attr("value", value.s_id).text(value.s_name)); 
          });
            }
          });
        });
        </script> -->

        <script>
         $('#append_supplier').on("change", function(){
            var s_id =  this.value;
            $('#supplier').val(s_id);

         });
        </script>
        <script>
         $('#append_unit').on("change", function(){
            var unit =  this.value;
            $('#unit').val(unit);

         });
        </script>
<script>
$( function() {
$(this.target).find('input').autocomplete();
 $( "#supplier_name" ).autocomplete({
  source: function( request, response ) {
   // Fetch data
   $.ajax({
    url: "<?php echo base_url() ?>purchase/GetSupplierByid",
    type: 'post',
    dataType: "json",
    data: {
     search: request.term
    },
    success: function(data) {
     response(data);
     console.log(data);
    }
   });
  },
  select: function (event, ui) {
   // Set selection
   
   $('#supplier_name').val(ui.item.label); // display the selected text
   $('#supplier').val(ui.item.value); // display the selected text
    $("#supplier_name").autocomplete('close');
   return false;
  },
 });
 });
</script> 
        
    <script>
        var canvas, context, video, videoObj;

        $(function () {
            canvas = document.getElementById("canvas");
            context = canvas.getContext("2d");
            video = document.getElementById("video");

            // different browsers provide getUserMedia() in differnt ways, so we need to consolidate 
            navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia ||  navigator.mozGetUserMedia;

            if (navigator.getUserMedia) {
                navigator.getUserMedia(
                   { video : true }, // which media
                   function (stream) {   // success function
                       video.src = window.URL.createObjectURL(stream);
                       video.onloadedmetadata = function (e) {
                           video.play();
                       };
                   },
                   function (err) {  // error function 
                       console.log("The following error occured: " + err.name);
                   }
              );
            } 
            else {
                console.log("getUserMedia not supported");
            }
        });

        function takePhoto() {
            context.drawImage(video, 0, 0, 220, 180);
        }
        
            $('#formid').bind('submit',function(e){
                e.preventDefault();
                var dataURL = canvas.toDataURL();
                var img =$('#user_image').val();  
                var img =img.slice(12);  
                var supplier = $(".supplier").val();
                 var product_name = $(".product_name").val();
                 var storeshortstock = $(".storeshortstock").val();
                 var min_orderqty = $(".minimum").val();
                 var max_orderqty = $(".maximum").val();
                 var reorder_qty = $(".reorder").val();
                 var unit = $(".unit").val();



                 let subformSelect = "";
                
                 $("input:checkbox[name=medSUBforms]:checked").each(function () {
                    let text2 = $(this).val();
                       // alert($(this).val());
                        subformSelect = subformSelect.concat(",", text2);

                    });

                    
                    
                    //alert(subformSelect);

                 
                // var exp_date = $(".exp_date").val();
                 var generic_name = $(".generic_name").val();
                 var strength = $(".strength").val();
                 var formSelect = $(".formSelect").val();

                
                 
                 var shortstock = $(".shortstock").val();
                 var hsn = $(".hsn").val();
                 var side_effect = $(".side_effect").val();
              
                if(img.trim() === '')
                {
                    var image_name = ''; 
                }
                else{
                    var timestamp = new Date().getTime();
                 var image_name = timestamp + '.jpg'; 
                }
               if (supplier.trim() === '')
                    {
                        return;
                    }else{
                        
                  $.ajax({
                  type: 'POST',
                  enctype: "multipart/form-data",
                  url: "Save_Canvas",
                  dataType:'json',    
                  cache: false,
                  data: {
                    dataURL: dataURL,
                     supplier: supplier,
                     unit: unit,
                     product_name: product_name,
                     generic_name: generic_name,
                      strength: strength,
                    formSelect: formSelect,
                    subformSelect: subformSelect,
                    shortstock: shortstock,
                    storeshort_stock: storeshortstock,
                    min_orderqty: min_orderqty,
                    max_orderqty: max_orderqty, 
                    reorder_qty: reorder_qty, 
                     hsn: hsn,
                     side_effect: side_effect,
                     product_image: img,
                    // exp_date:exp_date
                  },
                  success: function(response){
                    console.log(response);
              if(response.status == 'error') { 
             // $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);
                  
              } else if(response.status == 'success') {
                 $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);
                 window.location = response.curl;
                //  console.log(response);
                window.setTimeout(function() {
                   window.location = "<?php echo base_url(); ?>Medicine/View";
               }, 2000);
                
              $("#submit_btn").attr("disabled", true);

              }
                  }
                });
                if(img.trim() === '')
                {

                }else{
                    image_upload(img);
                }
                
                 }
            });

    </script>
        <script>
        function image_upload(image_name)
        {
        
        var file_data = $('#user_image').prop('files')[0]; 
        var formData = new FormData();
        formData.append('webcam', file_data, image_name);   
        
        $.ajax({
            url: "image_upload",
            type: "post",
            processData: false,
            contentType: false, 
            data: formData,
            dataType: 'json',
            success: function(msg) {
                alert(msg);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
        }
        function checkmedicinename(){
            var productname = $("#proname").val();
            
            gdata ={product_name: productname};
            $.ajax({
                type: "POST",
                dataType: 'html',
                url: "checkmedicinename",
                data: gdata,
               
                
          success: function(response) {
              if(response == 'error') { 
                $("#proname").css("border-color","#ff9797");
                $('#submit_btn').attr('disabled','disabled');
              
              } else if(response == 'success') {
                $("#proname").css("border-color","#67757c");
                $('#submit_btn').removeAttr('disabled');
               
              }              
          },
          error: function(response) {
            console.error();
          }
            });


        }
   
     </script>
               <!-- <script type="text/javascript">
                    $('.boxsize , .mrp').on('input', function() {
                        var boxprice = $('.boxsize').val();
                        var mrp = $('.mrp').val();
                        console.log('mrp');
                        $('.totalboxprice').val((boxprice * mrp ? boxprice * mrp : 0).toFixed(2));
        
                    });
                </script> -->
                <script>
                    $("#boxsize, #mrp").keyup(function () {
                        var boxsize = $('#boxsize').val();
                        var mrp = $('#mrp').val() ? $('#mrp').val() : 0;
                    var total = boxsize * mrp;
                        $('#totalboxprice').val(total);
                        

                    });
                    </script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.select2').select2();
	$(".js-supplier-data-ajax").select2({

	    ajax: {
	        url: "<?php echo base_url(); ?>purchase/GetSupplierByid",
	        dataType: 'json',
	        type: "GET",
	        data: function (term) {
	            return {
	                param: term.term
	            };
	        },
	        processResults: function (data) {
	            return {
		            results: $.map(data, function (item) {
		                return {
		                    text: item.s_name,
		                    id: item.s_id
		                };
		            })
		        };
	        },
	    }
	});
	});
</script>
<script>
$("#user_image").on("change", function() {
    if (typeof FileReader == "undefined") {
        alert("Your browser doesn't support HTML5, Please upgrade your browser");
    } else {
        var container = $(".file_prev");
        //remove all previous selected files
        container.empty();

        //create instance of FileReader
        var reader = new FileReader();
        reader.onload = function(e) {
            $("<img />", {
                src: e.target.result
            }).appendTo(container);
        };
        reader.readAsDataURL($(this)[0].files[0]);
    }
});
    </script>

    <script>
  $("#hsn").keyup(function () {
    var hsn = $('#hsn').val();
    vdata = {hsn: hsn};
     $.ajax({
        url: "post_hsn",
        type:"POST",
        data:vdata,
        dataType: 'json',
        success:function(data){
            $.each(data, function(index, val) {
               $('#cgst').val(val.cgst);
               $('#sgst').val(val.sgst);
               $('#Igst').val(val.igst);
            });
        }
     });
  });
        </script>
<script>
$(document).ready(function() {
    $.ajax({
        url: "<?php echo base_url(); ?>Hsn/get_hsnnumber",
        dataType: "json",
        success: function(data) {
            if (data) {
                $.each(data, function(key, value) {
                    $('#hsn_num').append($("<option></option>").attr("value", value.hsn).text(value.hsn_num));
                });
            } else {
                console.error('Error: Unable to fetch HSN numbers.');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }
    });

    $('#hsn_num').on("change", function() {
        var s_id = this.value;
        console.log('Selected HSN:', s_id);
        $('#hsn').val(s_id);
    });

    $('#hsn').attr('required', true);
    $('#hsn').attr('aria-required', true);

});
</script>

<script>
$(document).ready(function() {
    $.ajax({
        url: "<?php echo base_url(); ?>Medicine/get_units",
        dataType: "json",
        success: function(data) {
            if (data) {
                $.each(data, function(key, value) {
                    $('#unit').append($("<option></option>").attr("value", value.unit).text(value.unit));
                });
            } else {
                console.error('Error: Unable to fetch units.');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }
    });

    $('#unit').on("change", function() {
        var unit = this.value;
        console.log('Selected Unit:', unit);
        $('#unit').val(unit);
    });
    

    $('#unit').attr('required', true);
    $('#unit').attr('aria-required', true);




//Append subform of med.
$('#medform').on('change', function() {
  var formID = this.value;
  vdata = {form: formID};
  $.ajax({
   
        type:"POST",
        data:vdata,
        dataType: 'json',
        url: "<?php echo base_url(); ?>Medicine/GetsubunitBynum",
        dataType: "json",
        success: function(data) {
            if (data) {
                $('#medsubform').empty();
                $.each(data, function(key, value) {
                    var text = "<li><input name='medSUBforms' type='checkbox' value='"+value.id+"' class='ckkBox val' /><span>"+value.unit+"</span></li>";
                    $('#medsubform').append(text);
                    
                });
            } else {
                console.error('Error: Unable to fetch units.');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }
    });

    $("#subform").css('height',"100px");
    $("#subform").css('background',"#efefef");


});
});
</script>
<script>
    $("div #subform").click( function( e ){
        $("#subform").css('height',"100px");
        $("#subform").css('background',"#efefef");
        
        
    e.stopPropagation();
});
</script>
<style>
    #medsubform input[type=checkbox] {
    position: unset;
    opacity: 1;
    margin-right: 10px;
}

#subform {
    position: absolute;
    right: 12px;
    top: 0px;
    z-index: 9;
    height: 37px;
    overflow-y: scroll;
    border: 1px solid #ccc;
}
#medsubform {
    padding: 0px;
}
#medsubform li{
    list-style-type: none;
}
</style>
<?php 
    $this->load->view('backend/footer');
?>

