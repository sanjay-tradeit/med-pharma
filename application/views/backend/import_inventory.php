<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
?>
<style>
    .file_prev img {height: 44px;width: auto;max-width: 100%;margin-bottom: 0px;margin-right: 0px;margin-top: 0px;}
    .w-p-5{width:5%!important;}
    .w-p-10{width:10%!important;}
    .w-p-15{width:15%!important;}
    .w-p-20{width:20%!important;}
    .w-p-80{width:80%!important;}
    .w-p-100{width:100%!important;}  
    p {
    color: red;
}  
</style>
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Inventory</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item ">Customer</li>
                    </ol>
                </div>
            </div>
            <div class="container-fluid">
            <div class="flashmessage"></div>


                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Import Inventory</h4>
                                 
                            </div>
                            <form action="" method="post" id="myform" enctype="multipart/form-data">
                                <div class="row m-3">
                                    <div class="col-6">
                                      <input type ="file" class="form-control" name="picture"/>
                                      <div class="text-center mt-3">
                                         <input type="submit" id="sbt_btn" class="bt btn-info" value="Upload">
                                      </div>
                                    </div>
                               </div>
				           </form>
                            <div class="card-body">
                                <div class="table-responsive ">
                              
                                            <div  id="append_tr">

                                             </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer"> © <?php echo date("Y");?> Med Jacket</footer>
        </div>
                             
     </div>
    </div>
</div>
              <div class="modal-footer">
               <input type="hidden" name="cid" value="">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info" id="update_sbt_btn">Submit</button>
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
<footer class="footer">  © <?php echo date("Y");?> Med Jacket</footer>
 </div> 
 <script>
$("form#myform").submit(function(){
    //alert("hello");
var formData = new FormData($(this)[0]);
$.ajax({
    url: "<?php echo base_url();?>Customer/read_excel",
    type: 'POST',
    data: formData,
    dataType: "json",
    async: false,
    success: function (data) {
        console.log(data);
          if(data.status=="success")
          {
            $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(data.message);
            // window.setTimeout(function() {
            //        window.location = data.curl;
            //    }, 2000);
          }
        $('#append_tr').html(data);
    },
    cache: false,
    contentType: false,
    processData: false
});
return false;
});
 </script>
<?php 
    $this->load->view('backend/footer');
?>