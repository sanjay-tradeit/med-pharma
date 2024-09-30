        <aside class="left-sidebar">
            <?php
            $storeID = $this->session->userdata('store_id');
            $stockout = $this->medicine_model->GetStockOutproduct();
            $sortstock = $this->medicine_model->Getshortproduct();
            $storestockout = $this->medicine_model->GetStockOutstoreproduct();
            $storesortstock = $this->medicine_model->getstoreShortProduct($storeID);
            $permissions = $this->medicine_model->GetpermissionsByid1($_SESSION['user_type']);
            ?>

            <!-- Sidebar scroll-->

            <div class="scroll-sidebar">

                <nav class="sidebar-nav">

                    <ul id="sidebarnav">

                        <li class="nav-devider"></li>
                        <?php if($this->session->userdata('em_type') =='substore'){ ?>
                            <li> <a href="<?php echo base_url(); ?>dashboard/Dashboard" ><i class="fa fa-dashboard"></i><span class="hide-menu">Dashboard </span></a></li>

                        <li>
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-bar-chart-o"></i><span class="hide-menu">POS </span></a>
                        <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo base_url();?>invoice/Pos_Create55" ><span class="hide-menu">POS <span class="hide-menu"></a>  </li>     
                        <li><a href="<?php echo base_url();?>invoice/manage_Invoice" ><span class="hide-menu">Manage POS<span class="hide-menu"></a> </li>
                            </ul>
                        </li>
                 
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-bank"></i><span class="hide-menu">Store Inventory </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>Invantory/StoreStock">Manage Stock </a></li>
                                <li><a href="<?php echo base_url();?>Invantory/Stock_shortstock">Short Stock <span class="label label-rouded label-info pull-right"><?php echo count($storesortstock); ?></span></a></li>
                                <li><a href="<?php echo base_url();?>Invantory/Store_Stockout">Out of Stock <span class="label label-rouded label-danger pull-right"><?php echo count($storestockout); ?></span></a></li>
                                <li><a href="<?php echo base_url();?>Invantory/Stock_expire_storesoon"> Soon Expiring</a></li>
                                <li><a href="<?php echo base_url();?>Invantory/Stock_storeexpired">Expired Medicine</a></li>
                                <li> <a href="<?php echo base_url();?>Invantory/Request_stock" >Request Stock</a></li>
                                <li> <a href="<?php echo base_url();?>Invantory/Request_stock_his" >Request Stock History</a></li>
                                <li> <a href="<?php echo base_url();?>Invantory/reverse_request_store" >Return Stock </a></li>
                                
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-bar-chart-o"></i><span class="hide-menu">Report </span></a>

                            <ul aria-expanded="false" class="collapse">

                                <li><a href="<?php echo base_url();?>Sales/Today_counter_report">Today's Report </a></li>
                                <li><a href="<?php echo base_url();?>Sales/Sales_report">Sales Report</a></li>
                                <li><a href="<?php echo base_url();?>Sales/item_comsumtion">Item Consumption Report</a></li>
                                <li><a href="<?php echo base_url();?>Sales/Sales_Return_Report">Sales Return Report</a></li>

                            </ul>

                        </li> 
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-adjust"></i><span class="hide-menu">Return </span></a>
                        <ul aria-expanded="false" class="collapse">
                            
                            <li> <a  href="<?php echo base_url();?>sales/Sales_Return" >Sales Return </a></li>
                        </ul> 
                        </li>  
                        <?php $permissions = explode(',', $permissions[0]->permissions);
                                                if (in_array(97, $permissions)) { ?>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">Employee </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>Employee/Create">Add Employee </a></li>
                                <li><a href="<?php echo base_url();?>Employee/View">Manage Employee</a></li>
                            </ul>
                        </li>    
                        <?php } ?>                                                                                      
                        <?php } elseif($this->session->userdata('em_type') =='admin') {?>
                        
                        <li> <a href="<?php echo base_url(); ?>dashboard/Dashboard" ><i class="fa fa-dashboard"></i><span class="hide-menu">Dashboard </span></a></li>

                        <li>
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-bar-chart-o"></i><span class="hide-menu">POS </span></a>
                        <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo base_url();?>invoice/Pos_Create55" ><span class="hide-menu">POS <span class="hide-menu"></a>  </li>     
                        <li><a href="<?php echo base_url();?>invoice/manage_Invoice" ><span class="hide-menu">Manage POS<span class="hide-menu"></a> </li>
                            </ul>
                        </li>

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Customer </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>Customer/Create">Add Customer </a></li>
                                <!-- <li><a href="<?php echo base_url();?>Customer/View">Manage Customer</a></li> -->
                                <li><a href="<?php echo base_url();?>Customer/Regular">Regular Customer</a></li>
                                <li><a href="<?php echo base_url();?>Customer/Wholesale">Wholesale Customer</a></li>
                                <li><a href="<?php echo base_url();?>Customer/Walkin">Walk In Customer</a></li>
                            </ul>
                        </li>

                        <li> <a href="<?php echo base_url();?>Manufacturer/manufacturer"><i class="fa fa-industry" aria-hidden="true"></i><span class="hide-menu">Manufacturer </span></a></li>

                        <li> <a href="#" class="has-arrow waves-effect waves-dark"><i class="fa fa-calculator" aria-hidden="true"></i><span class="hide-menu">HSN </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>Hsn/Createhsn">Add HSN </a></li>
                                <li><a href="<?php echo base_url();?>Hsn/Viewhsn">Manage HSN</a></li>
                            </ul>
                            </li>

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-medkit"></i><span class="hide-menu">Medicine </span></a>

                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>Medicine/Measurementcreate">Unit of Measurement </a></li>
                                <li><a href="<?php echo base_url();?>Medicine/Create">Add Medicine </a></li>
                                <li><a href="<?php echo base_url();?>Medicine/View">Manage Medicine</a></li>
<!--                                <li><a href="<?php echo base_url();?>Medicine/Barcode">Barcode Print</a></li>-->
                            </ul>
                        </li>

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-hospital-o"></i><span class="hide-menu">Store </span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="<?php echo base_url();?>Store/add_store">Add Store </a></li>
                            <li><a href="<?php echo base_url();?>Store/manage_stores">Manage Store </a></li>
                        </ul>
                        </li>

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">Employee </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>Employee/Create">Add Employee </a></li>
                                <li><a href="<?php echo base_url();?>Employee/View">Manage Employee</a></li>
                                <li><a href="<?php echo base_url();?>Employee/permissions">Add Roles</a></li>
                                
                            </ul>
                        </li>

                        
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-handshake-o"></i><span class="hide-menu">Supplier </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>Supplier/Create">Add Supplier </a></li>
                                <li><a href="<?php echo base_url();?>Supplier/View">Manage Supplier</a></li>
                                <li><a href="<?php echo base_url();?>Supplier/Balance">Supplier Balance</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-shopping-cart"></i><span class="hide-menu">Purchase </span></a>

                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>Purchase/Create">Add Purchase </a></li>
                                <li><a href="<?php echo base_url()?>purchase/purchase">Manage Purchase</a></li>
                                <li><a href="<?php echo base_url()?>purchase/add_grn">Add GRN</a></li>
                                <li><a href="<?php echo base_url()?>purchase/manage_grn">Manage GRN</a></li>
                                <li><a href="<?php echo base_url()?>purchase/purchase_draftview">Purchase Draft History</a></li>

                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-building-o"></i><span class="hide-menu">All Inventory </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>Invantory/Stock">Manage Stock </a></li>
                                <li><a href="<?php echo base_url();?>Invantory/Stock_short">Short Stock <span class="label label-rouded label-info pull-right"><?php echo count($sortstock); ?></span></a></li>
                                <li><a href="<?php echo base_url();?>Invantory/Stock_out">Out of Stock <span class="label label-rouded label-danger pull-right"><?php echo count($stockout); ?></span></a></li>
                                <li><a href="<?php echo base_url();?>Invantory/Stock_expire_soon"> Soon Expiring</a></li>
                                <li><a href="<?php echo base_url();?>Invantory/Stock_expired">Expired Medicine</a></li>
                                <li> <a href="<?php echo base_url();?>Invantory/import_inventory">Import Inventory</a></li>
                                <li> <a href="<?php echo base_url(); ?>Invantory/transfer_inventory" >Transfer Inventory</a></li>
                                <li> <a href="<?php echo base_url(); ?>Invantory/manage_inventory" >Manage Transfer Inventory</a></li>
                                <li> <a href="<?php echo base_url(); ?>Invantory/requested_stock" >Requested Stock</a></li>
                                <li> <a href="<?php echo base_url(); ?>Invantory/reverse_request" >Return Stock</a></li>
                                <li> <a href="<?php echo base_url();?>Invantory/Request_stock_history" >Return Stock History</a></li>
                                <li> <a href="<?php echo base_url();?>Invantory/stock_adjus" >Stock Adjustment</a></li>
                                <li> <a href="<?php echo base_url();?>Invantory/stock_adjushis" >Stock Adjustment History</a></li>
                            </ul>
                        </li>

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-bank"></i><span class="hide-menu">Store Inventory </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>Invantory/StoreStock">Manage Stock </a></li>
                                <li><a href="<?php echo base_url();?>Invantory/Stock_shortstock">Short Stock <span class="label label-rouded label-info pull-right"><?php echo count($storesortstock); ?></span></a></li>
                                <li><a href="<?php echo base_url();?>Invantory/Store_Stockout">Out of Stock <span class="label label-rouded label-danger pull-right"><?php echo count($storestockout); ?></span></a></li>
                                <li><a href="<?php echo base_url();?>Invantory/Stock_expire_storesoon"> Soon Expiring</a></li>
                                <li><a href="<?php echo base_url();?>Invantory/Stock_storeexpired">Expired Medicine</a></li>
                                
                            </ul>
                        </li>
                        <li> <a href="<?php echo base_url();?>Sales/Department_summary"><i class="fa fa-building" aria-hidden="true"></i><span class="hide-menu">Department Summary </span></a></li>
                        
                        
                        <li> <a href="<?php echo base_url();?>Sales/Product_Ledger"><i class="fa fa-file-text" aria-hidden="true"></i><span class="hide-menu">Product Ledger</span></a></li>
                        
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-bar-chart-o"></i><span class="hide-menu">Report </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>Sales/Today_report">Today's Report </a></li>

                                <li><a href="<?php echo base_url();?>Sales/Sales_report">Sales Report</a></li>
                                <li><a href="<?php echo base_url();?>Sales/item_comsumtion">Item Consumption Report</a></li>
                                
                                <li><a href="<?php echo base_url();?>Sales/Sales_Return_Report">Sales Return Report</a></li>
                                <li><a href="<?php echo base_url();?>Sales/Purchase_report">Purchase Report</a></li>
                                <li><a href="<?php echo base_url();?>Sales/Purchase_Return_report">Purchase Return Report</a></li>
                                <li><a href="<?php echo base_url();?>Sales/Closing_Stock_report">Closing Stock Report</a></li>
                                <li><a href="<?php echo base_url();?>Sales/Current_Stock_report">Current Stock Report</a></li>
                                <li><a href="<?php echo base_url();?>Sales/Fast_Moving_report">Fast Moving Items Report</a></li>
                                <li><a href="<?php echo base_url();?>Sales/Slow_Moving_report">Slow Moving Items Report</a></li>
                                <li><a href="<?php echo base_url();?>Sales/Profit_report">Profit Report</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-adjust"></i><span class="hide-menu">Return </span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li> <a  href="<?php echo base_url();?>sales/Purchase_Return" >Purchase Return </a></li>
                            <li> <a  href="<?php echo base_url();?>sales/Sales_Return" >Sales Return </a></li>
                        </ul>
                        </li>
                       
                        

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-money"></i><span class="hide-menu">Accounts </span></a>

                            <ul aria-expanded="false" class="collapse">

                                <li><a href="<?php echo base_url();?>Customer/Balance">Customer Balance</a></li>
                                <!-- <li><a href="<?php echo base_url();?>Supplier/Balance">Supplier Balance</a></li> -->

<!--                                 <li><a href="#">Accounts Summary</a></li> -->

                                <li><a href="<?php echo base_url()?>accounts/Payment">Payment</a></li>
                                <li><a href="<?php echo base_url()?>accounts/all_payment">All Payment</a></li>

<!--                                 <li><a href="#">Cheque manager</a></li> -->

                               <li><a href="<?php echo base_url()?>accounts/closing">Closing</a></li>

                                <!-- <li><a href="<?php echo base_url()?>accounts/Report"> Closing Report</a></li> -->

                                <li><a href="<?php echo base_url()?>accounts/bank">Manage Bank</a></li>

                            </ul>

                        </li>
                        
                        

                       

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="	fa fa-child"></i><span class="hide-menu">Help </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url()?>help/phone_book">Phone Book </a></li>
                                <li><a href="<?php echo base_url()?>help/doctor">Doctor </a></li>
                                <li><a href="<?php echo base_url()?>help/hospital">Hospital </a></li>
                                <li><a href="<?php echo base_url()?>help/ambulance">Ambulance </a></li>
                                <li><a href="<?php echo base_url()?>help/fire_service">Fire Serivce</a></li>
                                <li><a href="<?php echo base_url()?>help/police">Police</a></li>
                            </ul>
                        </li>
                            <li> <a href="<?php echo base_url();?>Configuration/Settings"><i class="fa fa-gear"></i><span class="hide-menu">Settings </span></a></li>
                            
                            
                        <?php } ?>
                       
                    </ul>

                </nav>

                <!-- End Sidebar navigation -->

            </div>

            <!-- End Sidebar scroll-->

        </aside>

