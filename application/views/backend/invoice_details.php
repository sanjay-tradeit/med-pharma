<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar');

        $createdate = $invoice->create_date;
        $createtime = $invoice->sales_time;
        $customer = $invoice->c_name;
        $invoiceno = $invoice->invoice_no;
        $phone = $customerphone[0]->cus_contact;
        $cusid = $customerphone[0]->c_id;
        $tax = 0;
        $discount = $invoice->total_discount;
        $cTime = $createtime;//date("d-m-Y h:i:sa",$createtime);
?>
<style>
.pos_receipt {
    font-family: "Poppins", "sans-serif" !important;
}
  </style>
    <div class="page-wrapper">

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Invoice Detail</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item ">Report</li>
        </ol>
    </div>
</div>

<div id='printa'><div class='card-body pos_receipt'>
        <div class='receipt_header'>
          <div class='row'>
          
          <div class='col-md-12'>
          <p class='customer-details;margin-bottom:5px;'>
            <span style='font-size: 20px;font-weight: 600;color: #000'>Name: <?php echo $customer ;?></span>
            <br><span style='font-size: 20px;font-weight: 600;color: #000'>ID: <?php echo $cusid;?></span>
            <br><span style='font-size: 20px;font-weight: 600;color: #000'>Invoice: <?php echo $invoiceno; ?></span>
            <br><span style='font-size: 20px;font-weight: 600;color: #000'>Phone Number: <?php echo $phone;?></span>
          </p>
          </div>
          </div>
        </div>
        <div class='receipt_body'>
          <table style='font-size:8px'>
          <thead>
            <th style='right;font-size: 18px;font-weight: 600;color: #000'>SL</th>
            <th style='right;font-size: 18px;font-weight: 600;color: #000'>Item/Desc</th>
            <th style='right;font-size: 18px;font-weight: 600;color: #000'>Qty.</th>
            <th style='text-align:right;right;font-size: 18px;font-weight: 600;color: #000'>Amount</th>
          </thead> 
          <tbody>
          <?php $id = 0;
                $tot_totalAM = 0;
        foreach($invoice_details as $value):
                $id +=1;

             $totalAM =    $value->qty * $value->rate;
             $tot_totalAM += $totalAM;
             $withtax = $tot_totalAM + $tax;
             $dis = $withtax - $invoice->total_amount;
             $dis1 = round($dis, 2);
             $tax1 = 0;
             $totalam1 = round($totalAM, 2);
             $perunitprice = round($value->rate, 2);
             $string = str_replace('-', ' ', $dis1);
             ?>
            <tr>
            <td style='right;font-size: 16px;font-weight: 600;color: #000'><?php echo $id;?></td>
              <td class='medicine_name' style='right;font-size: 16px;font-weight: 600;color: #000'>
                <?php echo $value->product_name; ?>
              </td>
              <td  style='right;font-size: 16px;font-weight: 600;color: #000'><?php echo $value->qty?> * <?php echo $perunitprice ?></td>
              <td style='right;font-size: 16px;font-weight: 600;color: #000'>₹ <?php echo $totalam1;?>

</td>              
            </tr>
                <?php
                endforeach; ?>
         </tbody>
         <tr>
            <td></td>
            <td></td>
            
              <td>

</td>
            </tr>
            <tr>
            <td></td>
            <td></td>
            
              <td colspan='1' style='right;font-size: 16px;font-weight: 600;color: #000'>Discount</td>
              <td style='right;font-size: 16px;font-weight: 600;color: #000'> ₹ <?php echo $string; ?>

</td>
            </tr> 
          <tr>
            <td></td>
            <td></td>
            
              <td colspan='1' style='right;font-size: 16px;font-weight: 600;color: #000'>Net Due</td>
              <td style='right;font-size: 16px;font-weight: 600;color: #000'> ₹ <?php echo $invoice->due_amount; ?>

</td>
            </tr>
            <tr>
            <td></td>
            <td></td>
              <td colspan='1' style='right;font-size: 16px;font-weight: 600;color: #000'>Paid</td>
              <td style='right;font-size: 16px;font-weight: 600;color: #000'>₹ <?php echo $invoice->paid_amount;?> 

</td>
            </tr>
            <tr>
            <td></td>
            <td></td>
              <td colspan='1' style='right;font-size: 16px;font-weight: 600;color: #000'>Total Amount</td>
              <td style='right;font-size: 16px;font-weight: 600;color: #000'>₹ <?php echo $invoice->total_amount;?>

</td>
            </tr>
          </table>
        </div>
<hr/>
        <div class='col-md-12'>
            <h3>Notes</h3>
            <?php foreach ($nots as $not){

                echo "<h5 style='right;font-size: 16px;font-weight: 600;color: #000'>$not->created_at:    $not->note</h5>";

            }?>
        </div>


        <div class='col-md-6'>
            <h3>Add Note</h3>
            <form action="" id="formid" accept-charset="utf-8">
            <input type="hidden" name="invoiceno" value="<?php echo $invoice->invoice_no; ?>">
            <textarea name="note" class="form-control due">
            
            </textarea>
            <input class="btn btn-sm btn-info" type="submit" value="Submit"/>

            </form>
        </div>





    </div>


<script>
$('#formid').on('submit', function(e) {
    e.preventDefault();

    var mnote = $("textarea[name='note']").val(); 
    var minvoiceno = $("input[name='invoiceno']").val(); 
    $.ajax({
        type: 'POST',
        url: "Savenote",
        dataType: 'json',
        cache: false,
        data: {
            note: mnote,
            invoiceno: minvoiceno
        },
        success: function(response) {
            console.log(response.status);
            if (response.status === "success") {
                $(".flashmessage").fadeIn('fast').delay(3000).fadeOut('fast').html(response.message);
                window.location.reload(); 
            }
        }
    });
});
</script>

  
 <?php 

    $this->load->view('backend/footer');

?>