<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
?>
        <div class="page-wrapper">

            <div class="container-fluid p-t-10">

             <div class="flashmessage"></div>

                <div class="row m-b-10"> 

                    <div class="col-12">

                        <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url('Medicine/Create');?>" class="text-white"><i class="" aria-hidden="true"></i> Add Medicine</a></button>

                    </div>

                </div>
<style>
    .w-p-5{width:5%!important;}
    .w-p-10{width:10%!important;}
    .w-p-15{width:15%!important;}
    .w-p-20{width:20%!important;}
    .file_prev img {height: 44px;width: auto;max-width: 100%;margin-bottom: 0px; margin-right: 0px;margin-top: 0px;}
    button.btn.btn-sm.btn-info.waves-effect.waves-light {
    background-color: red;
}
</style>

                <div class="row">

                    <div class="col-12">

                        <div class="card card-outline-info">

                            <div class="card-header">

                                <h4 class="m-b-0 text-white">Manage Medicine </h4>

                            </div>
                            
                            <div class="card-body">

                                <div class="table-responsive ">

                                    <table id="example77" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">

                                        <thead>

                                            <tr>
                                            <th class="w-p-20">Medicine Id</th>
                                                <th class="w-p-20">Product Name</th>
                                                <th class="w-p-15">Generic Name</th>
                                                <th class="w-p-20">Manufacturer</th>
                                                <th class="w-p-10">Form </th>
                                                
                                                <th class="w-p-5">Image</th>
                                                <th class="w-p-5">Action</th>
                                            </tr>

                                        </thead>
                    
                                        <tbody>

                                           <?php foreach($medicineList as $value): 
                                            $CI     = & get_instance();
                                            $result = $CI->getformbyid($value->form);
                                            if($result){
                                            $title = $result[0]->title;
                                            }
                                            else{
                                                $title = ' ';
                                            }
                                            ?> 
                                               
                                            <td><?php echo $value->product_id;?></td>    
                                            <td><?php echo $value->product_name;?>(<?php echo $value->strength ?>)</td>
                                                <td><?php echo $value->generic_name; ?></td>
                                                 <td> <?php echo $value->m_name;  ?></td>
                                                <td><?php echo $title; ?></td>
                                             
                                                <!-- <td><?php// echo $value->s_name?></td> -->
                                                <!-- <td> 
                                                <?php
                                                // date_default_timezone_set("Asia/Dhaka");
                                                // $today = strtotime(date('Y/m/d'));
                                                // $expire = strtotime($value->expire_date);
                                                // $date = str_replace('/', '-',$value->expire_date);
                                                // $expire = strtotime($date);
                                                // $a = date('Y/m/d',$expire);
                                                // $b = strtotime($a);
                                                //     if($today >= $b){
                                                //         echo "<span style='color:red'>".$value->expire_date."</span>";
                                                //     } else {
                                                //         echo $value->expire_date;
                                                //     }                                                    
                                                    ?></td> -->
                                                <!-- <td><?php// echo $value->Batch_Number?></td> -->
                                          
                                                <!-- <td><?php //echo $value->mrp; ?></td> -->
                                                <!-- <td><?php // echo $value->instock; ?></td> -->
                                              
                                                <td>
                                                    <?php if (empty($value->product_image)) {?>
                                                    <img src="<?php echo base_url();?>assets/images/capsules.png" alt="" height="25" class="img-rounded image_rounded">
                                                    <?php }else{?>
                                                    <img src="<?php echo base_url();?>assets/images/medicine/<?php echo $value->product_image ?>" alt="" height="25" class="img-rounded image_rounded">
                                                    <?php }?>
                                                </td>

                                                <td class="jsgrid-align-center ">

                                                    <!-- <a href="" title="Edit" class="btn btn-sm btn-info waves-effect waves-light medicineid"  data-id="<?php echo $value->product_id; ?>"><i class="fa fa-pencil-square-o"></i></a> -->
                                                    <?php $permissions = explode(',', $permissions1);
                                                if (in_array(20, $permissions)) { ?>
                                                <a href="<?php echo base_url();?>Medicine/edit_med?pid=<?php echo $value->product_id; ?>" target="blank" title="Edit" class="btn btn-sm btn-info waves-effect waves-light"  data-id="<?php echo $value->product_id; ?>"><i class="fa fa-pencil-square-o"></i></a>
                                                <?php } ?>
                                                    <a href="" data-target=".bs-example-modal-md" title="Print" data-toggle="modal" class="btn btn-sm btn-info waves-effect waves-light barcodegenerator"  data-id="<?php echo $value->product_id; ?>"><i class="fa fa-barcode"></i></a>
                                                    <?php $permissions = explode(',', $permissions1);
                                                if (in_array(21, $permissions)) { ?>
                                                    <?php if($value->instock > 0 or $value->sale_qty > 0){ 

                                                     }else{ ?>
                                                        <button type="button" class="btn btn-sm btn-info waves-effect waves-light " data-toggle="modal" data-target="#delete_modal-<?php echo $value->product_id; ?>"><i class="fa-solid fa fa-trash"></i></button>

                                                    <?php } }?>
                                                   
                                                    
                                                </td>
                                            </tr>
                                 <!-- Delete modal -->
                                  <div class="modal fade" id="delete_modal-<?php echo $value->product_id; ?>" tabindex="-1" role="dialog" aria-labelledby="delete_modal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="delete_modal">DELETE</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Do you want to delete this ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                                        <a href="<?php echo base_url(); ?>Medicine/delete_medicine/<?php echo $value->product_id; ?>"><button type="button" class="btn btn-danger">YES</button></a>
                                       
                                    </div>
                                    </div>
                                </div>
                                </div>
                                            <?php endforeach;?>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                        </div>

<!--Modal-->

                            <div class="modal fade" id="medicineModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg"   style="max-width:60%!important"  role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Update Medicine</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <form action="Update" method="post" id="medicinefORM" class="form-horizontal" enctype="multipart/form-data" accept-charset="utf-8">
                                        <div class="modal-body"><div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Manufacturer</label>
                                                    <div class="col-md-9">
                                                    
                                                        <select class="select2 " name="supplier_name" id="supplier" value="" style="width:100%">
                                                           <?php foreach($supplierList as $value): ?>
                                                            <option value="<?php echo $value->manufac_id; ?>"><?php echo $value->m_name; ?></option>
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

                                                        <input type="text" onkeyup="checkmedicinename()" id="proname" name="product_name" class="form-control" placeholder="Product name" minlength="1">

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Generic Name</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="generic_name" class="form-control" placeholder="Generic name">
                                                    </div>
                                                </div>
                                            </div>
                                           <!-- 
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Batch Number</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="Batch_Number" class="form-control" placeholder="Batch number">
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Manufacturing date</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="manf_date" class="form-control" placeholder="Manufacturing date">
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Expiry date</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="exp_date" class="form-control" placeholder="Expiry date">
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Quantity Approve</label>
                                                    <div class="col-md-9">
                                                        <input readonly type="text" name="quan_approve" class="form-control" placeholder="Quantity approve">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">M.R.P</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="mrp" id="mrp" class="form-control" placeholder="M.R.P">
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Purchase Rate</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="purchase" class="form-control" placeholder="Purchase rate">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Sale Rate</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="sale_rate" class="form-control" placeholder="Sale rate">
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="col-md-6">

                                                <div class="form-group row">

                                                    <label class="control-label text-right col-md-3">Strength</label>

                                                    <div class="col-md-9">

                                                        <input type="text" name="strength" class="form-control" placeholder="Strength">

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
                                                            <option value="<?php echo $form->id; ?>"><?php echo $form->title; ?></option> 
                                                            <?php endforeach;?>
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12" id="subform">
                                                        <ul id="medsubform"></ul>
                                                        
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Stripe count</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="stripe" class="form-control" placeholder="Stripe count">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Box size</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="box_size" id="boxsize" class="form-control" placeholder="Box size">
                                                    </div>
                                                </div>
                                            </div> -->

                                            <!-- <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Box Price</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="box_price" class="form-control mrp" id="totalboxprice" placeholder="Box Price">
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Unit Price</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="unit_price" class="form-control boxsize" placeholder="Unit price">
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Short Quantity</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="shortstock" class="form-control totalboxprice" placeholder="Short quantity" >
                                                    </div>
                                                </div>
                                            </div>
                                       
                            
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">HSN Number</label>
                                                    <div class="col-md-9">
                                                    
                                                        <select class="select2 " name="hsn" id="hsn" value="" style="width:100%">
                                                           <?php foreach($hsnList as $Value): ?>
                                                            <option value="<?php echo $Value->hsn_num; ?>"><?php echo $Value->hsn_num; ?></option>
                                                            <?php endforeach; ?>        
                                                        </select>
                                                        <input id="hsnId" type="hidden" name="hsn" value="">


                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Side Effect</label>
                                                    <div class="col-md-9">
                                                        <textarea rows="4" class="form-control side_effect" name="side_effect" id="side_effect" rows="1"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">CGST (%)</label>
                                                    <div class="col-md-9">
                                                        <textarea readonly class="form-control" name="cgst" rows="1"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">SGST (%)</label>
                                                    <div class="col-md-9">
                                                        <textarea readonly class="form-control" name="sgst" rows="1"></textarea>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">IGST (%)</label>
                                                    <div class="col-md-9">
                                                        <textarea readonly class="form-control" name="Igst" rows="1"></textarea>
                                                    </div>
                                                </div>
                                            </div> -->
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
                                                        <img src="" name="image" class="img-responsive postimg" id="image" height="35px" width="60px">
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>     
                                            
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Store Short Quantity</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="storeshort_stock" id="storeshort_stock" class="form-control totalboxprice" placeholder="Short quantity" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Minimum Order Quantity</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="min_orderqty" id="min_orderqty" class="form-control totalboxprice" placeholder="Short quantity" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Maximum Order Quantity</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="max_orderqty" id="max_orderqty"  class="form-control totalboxprice" placeholder="Short quantity" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Reorder Quantity</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="reorder_qty" id="reorder_qty" class="form-control totalboxprice" placeholder="Short quantity" >
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3"></label>
                                                    <div class="col-md-9">
                                                      <input type="checkbox" name="favourite" class="custom-control-input" id="favourite" value='1'  >
                                                      <label for="favourite">Add To Favourite</label>
                                                    </div>
                                                </div>
                                            </div>  -->
                                            <!-- <div class="col-md-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3 col-sm-12">Discount </label>
                                                    <div class="col-md-9 col-sm-12">
                                                        <input name="discount" class="custom-control-input" value="YES" type="radio" id="discount_yes">
                                                        <label for="discount_yes">Yes</label>
                                                        <input name="discount" class="custom-control-input" value="NO" type="radio" id="discount_no">
                                                        <label for="discount_no">No</label>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                        </div>
                                <div class="modal-footer text-center">
                                <input type="hidden" name="id" value="">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-info" id ="submit_btn">Submit</button>
                                </div>
                                </form>
                            </div>
                        </div>
                        </div>
<style type="text/css">
    .card-no-border .card{
        width:100%!important;
    }
</style>

                <!-- <script type="text/javascript">
                    $('.boxsize , .mrp').on('input', function() {
                        var boxprice = parseInt($('.boxsize').val());
                        var mrp = parseInt($('.mrp').val());
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
                                <div class="modal fade bs-example-modal-md" id="" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog" style="">

                                        <div class='modal-content' style="width: 352px;">
                                            <!-- <span aria-hidden="true" class="modal_close">&times;</span> -->
                                            <div id="printa"></div>
                                            <!-- /.modal-content -->
                                            <button type='submit' class='btn btn-info' id='print'>print</button>
                                            
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                          </div>
                                        </div>
                                    
                                    </div>
                                    
                                </div>                
           <script type="text/javascript">
                $(document).ready(function () {
                    $(".medicineid").click(function (e) {
                        e.preventDefault(e);
                        // Get the record's ID via attribute  
                        var iid = $(this).attr('data-id');
                        //console.log(iid);
                         $('#medicinefORM').trigger("reset");
                         $('#medicineModal').modal('show'); 
                        $.ajax({
                            url: '<?php echo base_url();?>Medicine/GetMedicineById?id=' + iid,
                            method: 'GET',
                            data: '',
                            dataType: 'json',
                        }).done(function (response) {
                            console.log(response);
                            console.log(response.mvalue.form);
                            
                            // Populate the form fields with the data returned from server
                            $('#medicinefORM').find('[name="id"]').val(response.mvalue.product_id).end();
                            $('#medicinefORM').find('[id="supplier"]').val(response.mvalue.manufacturer_id).end();                           
                            $('#medicinefORM').find('[id="supplierId"]').val(response.mvalue.manufacturer_id).end();

                            $('#medicinefORM').find('[id="hsn"]').val(response.mvalue.hsn).end();
                            $('#medicinefORM').find('[id="hsnId"]').val(response.mvalue.hsn).end();
                            
                            $('#medicinefORM').find('[id="storeshort_stock"]').val(response.mvalue.storeshort_stock).end();
                            $('#medicinefORM').find('[id="min_orderqty"]').val(response.mvalue.min_orderqty).end();
                            $('#medicinefORM').find('[id="max_orderqty"]').val(response.mvalue.max_orderqty).end();
                            $('#medicinefORM').find('[id="reorder_qty"]').val(response.mvalue.reorder_qty).end();

                            $('#medicinefORM').find('[id="unit"]').val(response.mvalue.unit).end();                           
                            $('#medicinefORM').find('[id="unitId"]').val(response.mvalue.unit).end();



                            $('#medicinefORM').find('[name="product_name"]').val(response.mvalue.product_name).end();
                            $('#medicinefORM').find('[name="manf_date"]').val(response.mvalue.manf_date).end();
                            $('#medicinefORM').find('[name="exp_date"]').val(response.mvalue.expire_date).end();
                            $('#medicinefORM').find('[name="quan_approve"]').val(response.mvalue.quan_approve).end();
                            $('#medicinefORM').find('[name="quan_approve"]').val(response.mvalue.instock).end();
                            $('#medicinefORM').find('[name="sale_rate"]').val(response.mvalue.sale_rate).end();
                            $('#medicinefORM').find('[name="box_price"]').val(response.mvalue.box_price).end();
                            $('#medicinefORM').find('[name="unit_price"]').val(response.mvalue.unit_price).end();
                            $('#medicinefORM').find('[name="purchase_rate"]').val(response.mvalue.purchase_rate).end();
                            $('#medicinefORM').find('[name="hsn"]').val(response.mvalue.hsn).end();
                            $('#medicinefORM').find('[name="cgst"]').val(response.mvalue.cgst).end();
                            $('#medicinefORM').find('[name="sgst"]').val(response.mvalue.sgst).end();
                            $('#medicinefORM').find('[name="Igst"]').val(response.mvalue.Igst).end();
                            $('#medicinefORM').find('[name="Batch_Number"]').val(response.mvalue.Batch_Number).end();
                            $('#medicinefORM').find('[name="generic_name"]').val(response.mvalue.generic_name).end();
                            $('#medicinefORM').find('[name="strength"]').val(response.mvalue.strength).end();
                            $('#medicinefORM').find('[name="form"]').val(response.mvalue.form).end();
                            
                            $('#medicinefORM').find('[name="box_size"]').val(response.mvalue.box_size).end();
                            $('#medicinefORM').find('[name="expire_date"]').val(response.mvalue.expire_date).end();
                            $('#medicinefORM').find('[name="trade_price"]').val(response.mvalue.trade_price).end();
                            $('#medicinefORM').find('[name="mrp"]').val(response.mvalue.mrp).end();
                            $('#medicinefORM').find('[name="box_price"]').val(response.mvalue.box_price).end();
                            $('#medicinefORM').find('[name="side_effect"]').val(response.mvalue.side_effect).end();
                            $('#medicinefORM').find('[name="shortstock"]').val(response.mvalue.short_stock).end();
                            $('#medicinefORM').find('[name="barcode"]').val(response.mvalue.batch_no).end();
                            $('#medicinefORM').find('[name="stripe"]').val(response.mvalue.stripe).end();
                            $('#medicinefORM').find('[name="purchase"]').val(response.mvalue.purchase).end();
                           // $('#medicinefORM').find('[name="image_name"]').val(response.mvalue.product_image).end();
                            // $('#image_name').html(response.mvalue.product_image);
                            document.querySelector("#image_name").textContent = response.mvalue.product_image;
                          //  console.log(response.mvalue.product_image);
                              if(response.mvalue.product_image==''){
                                $('#image').attr('src','<?php echo base_url()?>assets/images/capsules.png');
                              }else{
                                $('#image').attr('src','<?php echo base_url()?>assets/images/medicine/'+response.mvalue.product_image);
                              }
                         
                        if(response.mvalue.favourite == "1") {
                        $( "input[type='checkbox']" ).prop( "checked", true );
                        } else {
                        $( "input[type='checkbox']" ).prop( "checked",false);
                        } 
                        if(response.mvalue.discount == "YES") {
                        $('#medicinefORM').find(':radio[id=discount_yes][value="YES"]').prop('checked', true).end();
                        } else if(response.mvalue.discount == "NO") {
                        $('#medicinefORM').find(':radio[id=discount_no][value="NO"]').prop('checked', true).end();
                        }   
                        $('.select2').select2();
                        
        				});
                         
                    });

                    $('#supplier').change(function() {    
                        var item = $(this);
                      
                       $('#supplierId').val(item.val());
                        
                    });
                    $('#hsn').change(function() {    
                        var item = $(this);
                      
                       $('#hsnId').val(item.val());
                        
                    });
                    $('#unit').change(function() {    
                        var item = $(this);
                      
                       $('#unitId').val(item.val());
                        
                    });
                    $('#form12').change(function() {    
                        var item = $(this);
                      
                       $('#form12').val(item.val());
                        
                    });

                    
                });
                
                
            </script>                  
           <script type="text/javascript">
                $(document).ready(function () {
                    $(".barcodegenerator").click(function (e) {
                        e.preventDefault(e);
                        // Get the record's ID via attribute  
                        var iid = $(this).attr('data-id');
                        //console.log(iid);
                         
                        $.ajax({
                            url: '<?php echo base_url();?>Medicine/GetBarcodeDom?id=' + iid,
                            method: 'GET',
                            data: '',
                            dataType: 'html',
                        }).done(function (response) {
                            console.log(response);
                            $('#printa').html(response);
                          //$('.bs-example-modal-md').modal('show'); 
                                     
        				});
                    });

                    $("#print").click(function (e) {
                        var mode = 'iframe'; //popup
            var close = mode == "popup";
                        var options = {
                mode: mode,
                popClose: close
            };
                        $("div#printa").printArea(options);  
                    });
                    
                });               
            </script>                        

            <footer class="footer"> © <?php echo date("Y");?> Med Jacket</footer>
<script>
$("#product_image").on("change", function() {
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
              
              } else if(response == 'success') {
                $("#proname").css("border-color","#67757c");
               
              }              
          },
          error: function(response) {
            console.error();
          }
            });


        }
    </script>            
    <!--<script>
    $(document).ready(function() {
        $(".barcodegenerator").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div#printArr").printArea(options);
        });
    });
    </script>-->
    
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
  alert(formID);
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
<!-- <script>
$(document).on("click", "#submit_btn", function(){
              window.setTimeout(function() {
                    window.location = "<?php echo base_url(); ?>Medicine/View";
                }, 2000);
});
        </script> -->
       
        <script>
    $(document).ready(function() {
$('#example77').dataTable( {
        "aaSorting": [[3,'desc']],
        "ordering": false,
            dom: 'Bfrtip',
            buttons: [
                            {
                                extend: 'copy',
                                title: 'Medicines List'
                            },
                            {
                                extend: 'excel',
                                title: 'Medicines List'
                            },
                            {
                                extend: 'pdf',
                                title: 'Medicines List'
                            },
                            {
                                extend: 'print',
                                title: 'Medicines List'
                            }
                        ]
    });
        });
</script>  

<?php 
$this->load->view('backend/footer');
?>