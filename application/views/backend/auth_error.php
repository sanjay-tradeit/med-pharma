<?php
    $this->load->view('backend/header');
    $this->load->view('backend/sidebar'); 
?>
        


            <div class="container-fluid">

            <div class="w3-display-middle" style="
    text-align: center;
    margin-top: 300px;
">
        <h1 class="w3-jumbo w3-animate-top w3-center"><code>Access Denied</code></h1>
        
        <h3 class="w3-center w3-animate-right">You don't have permission to view this page contact to Admin.</h3>
        <h3 class="w3-center w3-animate-zoom">🚫🚫🚫🚫</h3>
        
        </div>
           </div>

            <footer class="footer"> © <?php echo date("Y");?> Med Jacket</footer>

        

<?php 

    $this->load->view('backend/footer');

?>