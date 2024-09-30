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
                                <h4 class="m-b-0 ">Fast Moving Items Report</h4>
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
                                        <th>Product Name</th>
                                        <th>Product Id</th>
                                        <th>Initial Stock</th> 
                                        <th>Received Quantity</th>                                  
                                        <th>Dispensed stock</th>
                                        <th>Remaining Stock</th>
                                        <th>Turnover Rate</th>
                                        <th>Sale Value (INR)</th>                                          
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

                var uname = $('#uname').text().toUpperCase();



                var from = $('.start').val();

                var to = $('.end').val();

                var text = "Report generated by "+ uname + " for "  + from + " to " + to; 

           

                
                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: "GETfastmovingrePort",
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
                  order:[[4,"desc"]],
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
                                extend: 'copyHtml5',
                                title: 'Fast Moving Items Report',
                                messageTop: text

                            },
                            {
                                extend: 'excelHtml5',
                                title: 'Fast Moving Items Report',
                                text: 'Excel',
                                customize: function (xlsx) {
       
        var sheet = xlsx.xl.worksheets['sheet1.xml'];
        var downrows = 2;
        var clRow = $('row', sheet);
        //update Row
        clRow.each(function () {
            var attr = $(this).attr('r');
            var ind = parseInt(attr);
            ind = ind + downrows;
            $(this).attr("r",ind);
        });
 
        // Update  row > c
        $('row c ', sheet).each(function () {
            var attr = $(this).attr('r');
            var pre = attr.substring(0, 1);
            var ind = parseInt(attr.substring(1, attr.length));
            ind = ind + downrows;
            $(this).attr("r", pre + ind);
        });
 
        function Addrow(index,data) {
            if(index == 1){title = "Slow Moving Items Report";} else {title = text; }

            msg='<row r="'+index+'">'
            for(i=0;i<data.length;i++){
                var key=data[i].k;
                var value=data[i].v;
                msg += '<c t="inlineStr" r="' + key + index + '" s="42">';
                msg += '<is>';
                msg +=  '<t>'+title+'</t>';
                msg+=  '</is>';
                msg+='</c>';
            }
            msg += '</row>';
            return msg;
        }
 
        //insert
        var r1 = Addrow(1, [{ k: 'A', v: 'ColA' }]);
        var r2 = Addrow(2, [{ k: 'A', v: '' }]);
       // var r3 = Addrow(3, [{ k: 'A', v: '' }, { k: 'B', v: '' }, { k: 'C', v: 'ColC' }]);
        
        sheet.childNodes[0].childNodes[1].innerHTML = r1+ r2+ sheet.childNodes[0].childNodes[1].innerHTML;
    }
                               
                            },
                            {
                                extend: 'pdf',
                                title: 'Fast Moving Items Report', 
                                orientation : 'landscape'
                                
                            },
                            {
                                extend: 'print',
                                orientation: 'landscape',
                                title: 'Fast Moving Items Report',
                                customize: function ( win ) {
                                    $(win.document.body)
                                        .css( 'font-size', '14pt' )
                                        .prepend(
                                            '<p style="position:absolute; top:20; right:0;">'+ text +'</p>'
                                        );
                
                                    $(win.document.body).find( 'table' )
                                        .addClass( 'compact' )
                                        .css( 'font-size', 'inherit' );
                                }
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