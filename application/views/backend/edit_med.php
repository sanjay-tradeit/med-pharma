<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar');
    $CI =& get_instance(); 
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
                                <h4 class="m-b-0 text-white">Edit Medicine <span class="pull-right"><?php date_default_timezone_set("Asia/Kolkata"); echo date("l jS \of F Y h:i:s A") ?></span></h4>
                            </div>
                           
                            <div class="card-body">
                            <form action="Update" method="post" id="medicinefORM" class="form-horizontal" enctype="multipart/form-data" accept-charset="utf-8">
                                        <div class="modal-body"><div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Manufacturer</label>
                                                    <div class="col-md-9">
                                                    
                                                        <select class="select2 " name="supplier_name" id="supplier" value="" style="width:100%">
                                                        
                                                           <?php foreach($supplierList as $value): ?>
                                                            <option <?php if($value->manufac_id == $mvalue->manufacturer_id){echo "selected";}else{} ?> value="<?php echo $value->manufac_id; ?>"><?php echo $value->m_name; ?></option>
                                                            <?php endforeach; ?>        
                                                        </select>
                                                        <input id="supplierId" type="hidden" name="supplier" value="">


                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-md-6" style="display:none;">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Unit</label>
                                                    <div class="col-md-9">
                                                    
                                                        <select class="select2 " name="unit" id="unit" value="" style="width:100%">
                                                           <?php foreach($unitList as $value): ?>
                                                            <option value="<?php echo $value->unit; ?>"><?php echo $value->unit; ?></option>
                                                            <?php endforeach; ?>        
                                                        </select>
                                                        <input id="unitId" type="hidden" name="unit" value="">


                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-md-6">

                                                <div class="form-group row">

                                                    <label class="control-label text-right col-md-3">Product Name</label>

                                                    <div class="col-md-9">

                                                        <input type="text" name="product_name" onkeyup="checkmedicinename()" id="proname" class="form-control" placeholder="Product name" value="<?php echo $mvalue->product_name;?>" minlength="1">

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Generic Name</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="generic_name" class="form-control" placeholder="Generic name" value="<?php echo $mvalue->generic_name;?>">
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            <div class="col-md-6">

                                                <div class="form-group row">

                                                    <label class="control-label text-right col-md-3">Strength</label>

                                                    <div class="col-md-9">

                                                        <input type="text" name="strength" class="form-control" placeholder="Strength" value="<?php echo $mvalue->strength;?>">

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Form</label>
                                                    <div class="col-md-3 col-sm-12">
                                                        <select id="medform" name="formSelect" class="select2 formSelect"  style="width:100%" >
                                                        <option value="">Select Form</option>
                                                        <?php foreach($medforms as $form): ?>
                                                            <option <?php if($form->id == $mvalue->form){echo "selected";}else{} ?> value="<?php echo $form->id; ?>"><?php echo $form->title; ?></option>

                                                            <?php endforeach;?>
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12" id="subform">
                                                    <ul id="medsubform">
                                                        <?php $subForms = $CI->getAllunitsFormID($mvalue->form);
                                                        
                                                                $SubFormArray = explode(',',$mvalue->subform);
                                                               
                                                                
                                                            foreach($subForms as $subF){ ?>
                                                                <li><input <?php if (in_array($subF->id, $SubFormArray))
  {
  echo "checked";
  }else{} ?> name="medSUBforms[]" type="checkbox" value="<?php echo $subF->id;?>" class="ckkBox val"><span><?php echo $subF->unit;?></span></li>
                                                          <?php  }
                                                        ?>
                                                        
                                                    </ul>
                                                        
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Short Quantity</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="shortstock" class="form-control totalboxprice" placeholder="Short quantity" value="<?php echo $mvalue->short_stock;?>" >
                                                    </div>
                                                </div>
                                            </div>
                                       
                            
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">HSN Number</label>
                                                    <div class="col-md-9">
                                                    
                                                        <select class="select2 " name="hsn" id="hsn" value="" style="width:100%">
                                                        <?php foreach($hsnList as $Value): ?>
                                                            <option <?php if($Value->hsn_num == $mvalue->hsn){echo "selected";}else{} ?> value="<?php echo $Value->hsn_num; ?>"><?php echo $Value->hsn_num; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <!-- <input id="hsnId" type="hidden" name="hsn" value=""> -->


                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Side Effect</label>
                                                    <div class="col-md-9">
                                                        <textarea rows="4" class="form-control side_effect" name="side_effect" id="side_effect" rows="1"><?php echo $mvalue->side_effect;?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Product Image</label>
                                                    <div class="col-md-9">
                                                        <!-- <input type="file" name="product_image" id="product_image" class="form-control">
                                                        <span id="image_name"></span> -->
                                                        <div class="width:100% type-input-box">
                                                        <label for="product_image" class="w-100">  <input type="file" name="product_image" id="product_image" style="display:none;"/>
                                                        <a >Upload</a><span id="image_name"></span>
                                                        </div></label> 

                                                        <!-- <input type="file" name="product_image" id="product_image" style="display:none;"/>
                                                         <label for="product_image"><a>Upload</a></label>  <span id="image_name"></span> -->
                                                   
                                                  
                                                    <div class="file_prev">
                                                        <?php if (empty($mvalue->product_image)) {?>
                                                    <img src="<?php echo base_url();?>assets/images/capsules.png" alt="" name="image" class="img-responsive postimg" id="image" height="35px" width="60px">
                                                    <?php }else{?>
                                                    <img src="<?php echo base_url();?>assets/images/medicine/<?php echo $mvalue->product_image ?>" alt="" name="image" class="img-responsive postimg" id="image" height="35px" width="60px">
                                                    <?php }?>
                                                        <img src="" name="image" class="img-responsive postimg" id="image" height="35px" width="60px">
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>     
                                            
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Store Short Quantity</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="storeshort_stock" id="storeshort_stock" class="form-control totalboxprice" placeholder="Short quantity" value="<?php echo $mvalue->storeshort_stock;?>" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Minimum Order Quantity</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="min_orderqty" id="min_orderqty" class="form-control totalboxprice" placeholder="Short quantity" value="<?php echo $mvalue->min_orderqty;?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Maximum Order Quantity</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="max_orderqty" id="max_orderqty"  class="form-control totalboxprice" placeholder="Short quantity" value="<?php echo $mvalue->max_orderqty;?>" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Reorder Quantity</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="reorder_qty" id="reorder_qty" class="form-control totalboxprice" placeholder="Short quantity" value="<?php echo $mvalue->reorder_qty;?>" >
                                                    </div>
                                                </div>
                                            </div>


                                          
                                        </div>
                                        </div>
                                <div class="modal-footer text-center">
                                <input type="hidden" name="id" value="<?php echo $_GET['pid'];?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-info" id ="submit_btn">Submit</button>
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
        //   document.querySelector("#image_name").textContent = response.mvalue.product_image;
        //                   //  console.log(response.mvalue.product_image);
        //                       if(response.mvalue.product_image==''){
        //                         $('#image').attr('src','<?php echo base_url()?>assets/images/capsules.png');
        //                       }else{
        //                         $('#image').attr('src','<?php echo base_url()?>assets/images/medicine/'+response.mvalue.product_image);
        //                       }
        // });
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

                    
                    
                    alert(subformSelect);

                 
                // var exp_date = $(".exp_date").val();
                 var generic_name = $(".generic_name").val();
                 var strength = $(".strength").val();
                 var formSelect = $(".formSelect").val();
                 //alert(subformSelect);
                
                 
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


});
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

