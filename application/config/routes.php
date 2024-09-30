<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'login';
$route['manage_store'] = 'Store/manage_stores';
$route['manage_medicine'] = 'Medicine/Create';
$route['manage_View'] = 'Medicine/View';
$route['save_grn'] = 'Purchase/save_grn';
$route['edit_grn'] = 'Purchase/edit_grn_data';
$route['add_grn'] = 'Purchase/add_grn';
$route['all_payment'] = 'Accounts/all_payment';
$route['all_cus'] = 'Customer/View';
$route['regular_cus'] = 'Customer/Regular';
$route['transfer'] = 'Invantory/transfer';
$route['manage_inventory'] = 'Invantory/manage_inventory';
$route['submit_stock_transfer'] = 'Invantory/submit_stock_transfer';
// API
$route['inpatient/allmedicine'] = 'Invoice/allmedicine';
$route['api/pharmacy/inpatient/medication'] = 'Invoice/medication';
$route['api/pharmacy/inpatient/save_medication'] = 'Invoice/Save_medication';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

?>
