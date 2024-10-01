-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 24, 2024 at 02:00 PM
-- Server version: 10.6.18-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `med-pharma`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `amount` varchar(64) DEFAULT NULL,
  `due` varchar(64) DEFAULT NULL,
  `paid` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_report`
--

CREATE TABLE `accounts_report` (
  `id` int(11) NOT NULL,
  `transection_type` varchar(128) DEFAULT NULL,
  `transection_name` varchar(128) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  `mtype` varchar(128) DEFAULT NULL,
  `cheque` varchar(128) DEFAULT NULL,
  `issuedate` varchar(128) DEFAULT NULL,
  `bankid` varchar(128) DEFAULT NULL,
  `amount` varchar(128) DEFAULT NULL,
  `entry_id` varchar(128) DEFAULT NULL,
  `date` varchar(128) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `adjustment_tble`
--

CREATE TABLE `adjustment_tble` (
  `id` int(11) NOT NULL,
  `adjus_id` varchar(255) NOT NULL,
  `product_id` varchar(11) NOT NULL,
  `supplier_id` varchar(255) NOT NULL,
  `store_id` varchar(255) NOT NULL,
  `pre_instock` varchar(255) NOT NULL,
  `adjus_qty` varchar(255) NOT NULL,
  `generic_name` int(11) NOT NULL,
  `created_at` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ambulance`
--

CREATE TABLE `ambulance` (
  `id` int(11) NOT NULL,
  `name` varchar(333) NOT NULL,
  `email` varchar(333) NOT NULL,
  `contact` varchar(333) NOT NULL,
  `address` varchar(333) NOT NULL,
  `hospital_name` varchar(333) NOT NULL,
  `notes` varchar(333) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `bank_id` int(11) NOT NULL,
  `bank_name` varchar(256) DEFAULT NULL,
  `account_name` varchar(256) DEFAULT NULL,
  `account_number` varchar(512) DEFAULT NULL,
  `branch` varchar(512) DEFAULT NULL,
  `signature` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `closing`
--

CREATE TABLE `closing` (
  `id` int(11) NOT NULL,
  `date` varchar(128) DEFAULT NULL,
  `opening_balance` varchar(128) DEFAULT NULL,
  `cash_in` varchar(128) DEFAULT NULL,
  `cash_out` varchar(128) DEFAULT NULL,
  `cash_in_hand` varchar(128) DEFAULT NULL,
  `closing_balance` varchar(128) DEFAULT NULL,
  `adjustment` varchar(128) DEFAULT NULL,
  `entry_id` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `closing_tble`
--

CREATE TABLE `closing_tble` (
  `id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `supplier_id` varchar(255) NOT NULL,
  `batch_no` varchar(255) NOT NULL,
  `exp_date` varchar(255) NOT NULL,
  `unit_mrp` varchar(255) NOT NULL,
  `instock` int(11) NOT NULL,
  `purchase_rate` varchar(255) NOT NULL,
  `purchase_wid_tax` varchar(255) NOT NULL,
  `sale_price` varchar(255) NOT NULL,
  `sale_price_wid_tax` varchar(255) NOT NULL,
  `in_house_purchase_val` varchar(255) NOT NULL,
  `in_house_sale_val` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `company_name` varchar(128) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `current_stock`
--

CREATE TABLE `current_stock` (
  `id` int(11) NOT NULL,
  `product_id` varchar(128) NOT NULL,
  `Batch_Number` varchar(128) NOT NULL,
  `Supplier_id` varchar(128) NOT NULL,
  `stock` varchar(128) NOT NULL,
  `date` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `c_id` varchar(64) DEFAULT NULL,
  `patient_id` varchar(255) NOT NULL,
  `c_name` varchar(256) DEFAULT NULL,
  `pharmacy_name` varchar(256) DEFAULT NULL,
  `c_email` varchar(256) DEFAULT NULL,
  `c_type` enum('Walkin','Regular','Wholesale','Impatient') NOT NULL DEFAULT 'Regular',
  `barcode` varchar(512) DEFAULT NULL,
  `cus_contact` varchar(64) DEFAULT NULL,
  `c_address` varchar(512) DEFAULT NULL,
  `c_note` varchar(512) DEFAULT NULL,
  `c_img` varchar(128) DEFAULT NULL,
  `regular_discount` varchar(64) DEFAULT '0',
  `target_amount` varchar(64) DEFAULT NULL,
  `target_discount` varchar(64) DEFAULT NULL,
  `entrydate` varchar(64) DEFAULT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_ledger`
--

CREATE TABLE `customer_ledger` (
  `id` int(11) NOT NULL,
  `customer_id` varchar(64) DEFAULT NULL,
  `total_balance` varchar(64) DEFAULT NULL,
  `total_paid` varchar(64) NOT NULL,
  `total_due` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `direct_approve`
--

CREATE TABLE `direct_approve` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `address` varchar(512) DEFAULT NULL,
  `contact` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fire_service`
--

CREATE TABLE `fire_service` (
  `id` int(11) NOT NULL,
  `name` varchar(223) NOT NULL,
  `email` varchar(223) NOT NULL,
  `contact` varchar(223) NOT NULL,
  `address` varchar(223) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grn`
--

CREATE TABLE `grn` (
  `id` int(11) NOT NULL,
  `grn_date` date NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `po_no` varchar(255) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `order_type` varchar(255) NOT NULL,
  `supplier_code` varchar(255) NOT NULL,
  `grn_no` varchar(255) NOT NULL,
  `dc_no` varchar(255) NOT NULL,
  `dc_date` varchar(255) NOT NULL,
  `bill_no` varchar(255) NOT NULL,
  `bill_date` varchar(255) NOT NULL,
  `bill_amt` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `generic_name` varchar(255) NOT NULL,
  `manf_date` varchar(255) NOT NULL,
  `sale_qty` varchar(255) NOT NULL,
  `unit_price` varchar(255) NOT NULL,
  `box_price` varchar(255) NOT NULL,
  `purchase` varchar(255) NOT NULL,
  `Sch_no` varchar(200) NOT NULL,
  `Sch_date` varchar(255) NOT NULL,
  `rec_qty` varchar(255) NOT NULL,
  `receivedamt` varchar(255) NOT NULL,
  `dues` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gst`
--

CREATE TABLE `gst` (
  `id` int(11) NOT NULL,
  `hsn_num` varchar(255) NOT NULL,
  `cgst` varchar(255) NOT NULL,
  `sgst` varchar(255) NOT NULL,
  `igst` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hospital`
--

CREATE TABLE `hospital` (
  `id` int(11) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `contact` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `address` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_notes`
--

CREATE TABLE `invoice_notes` (
  `id` int(11) NOT NULL,
  `note` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `invoice_no` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `id` int(11) NOT NULL,
  `em_id` varchar(64) DEFAULT NULL,
  `date` varchar(128) DEFAULT NULL,
  `login` varchar(64) DEFAULT NULL,
  `logout` varchar(64) DEFAULT NULL,
  `counter` varchar(64) DEFAULT NULL,
  `status` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

CREATE TABLE `manufacturer` (
  `id` int(11) NOT NULL,
  `manufac_id` varchar(255) NOT NULL,
  `m_name` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medication`
--

CREATE TABLE `medication` (
  `id` int(11) NOT NULL,
  `patient_id` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `referred_doctor` varchar(255) NOT NULL,
  `time` text NOT NULL,
  `prescription_date` date NOT NULL,
  `duration` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `branch` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `id` bigint(20) NOT NULL,
  `manufacturer_id` varchar(64) DEFAULT NULL,
  `product_id` varchar(64) DEFAULT NULL,
  `product_name` varchar(64) DEFAULT NULL,
  `generic_name` varchar(64) DEFAULT NULL,
  `Batch_Number123` varchar(256) DEFAULT NULL,
  `manf_date` varchar(255) NOT NULL,
  `exp_date` varchar(255) NOT NULL,
  `quan_approve` varchar(255) NOT NULL,
  `purchase_rate` varchar(255) NOT NULL,
  `sale_rate` varchar(255) NOT NULL,
  `mrp` int(11) NOT NULL,
  `strength` varchar(64) DEFAULT NULL,
  `form` varchar(64) DEFAULT NULL,
  `subform` varchar(255) NOT NULL,
  `box_size` varchar(64) DEFAULT NULL,
  `unit_price` varchar(255) NOT NULL,
  `instock` int(11) DEFAULT 0,
  `short_stock` int(11) DEFAULT NULL,
  `storeshort_stock` int(11) NOT NULL,
  `side_effect` varchar(255) NOT NULL,
  `box_price` varchar(64) DEFAULT NULL,
  `expire_date123` varchar(256) DEFAULT NULL,
  `favourite` enum('1','0') NOT NULL DEFAULT '0',
  `date` varchar(256) DEFAULT NULL,
  `discount` enum('YES','NO') NOT NULL DEFAULT 'YES',
  `hsn` varchar(255) NOT NULL,
  `cgst` varchar(255) NOT NULL,
  `sgst` varchar(255) NOT NULL,
  `Igst` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `sale_qty` varchar(255) NOT NULL DEFAULT '0',
  `stripe` varchar(255) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `purchase` varchar(255) NOT NULL,
  `min_orderqty` int(11) NOT NULL,
  `max_orderqty` int(11) NOT NULL,
  `reorder_qty` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_mata`
--

CREATE TABLE `medicine_mata` (
  `id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `supplier_id` varchar(256) NOT NULL,
  `Batch_Number` varchar(255) NOT NULL,
  `manf_date` varchar(255) NOT NULL,
  `expire_date` varchar(255) NOT NULL,
  `purchase_rate` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mrp` varchar(255) NOT NULL,
  `instock` int(11) NOT NULL,
  `sale_qty` int(11) NOT NULL,
  `discount` int(11) NOT NULL DEFAULT 0,
  `createdat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tax` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meta_grn`
--

CREATE TABLE `meta_grn` (
  `idd` int(11) NOT NULL,
  `grn_no` varchar(255) NOT NULL,
  `product_id` varchar(256) NOT NULL,
  `Batch_Number` varchar(255) NOT NULL,
  `instock` varchar(256) NOT NULL,
  `expire_date` varchar(255) NOT NULL,
  `Sch_no` varchar(255) NOT NULL,
  `Sch_date` varchar(255) NOT NULL,
  `rec_qty` varchar(255) NOT NULL,
  `price` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `unit_mrp` varchar(255) NOT NULL,
  `createdAt` date NOT NULL,
  `made_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `police`
--

CREATE TABLE `police` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `contact` varchar(256) DEFAULT NULL,
  `address` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `p_id` varchar(64) DEFAULT NULL,
  `invoice_no` varchar(64) DEFAULT NULL,
  `sid` varchar(64) DEFAULT NULL,
  `pur_details` varchar(64) DEFAULT NULL,
  `store_id` varchar(255) NOT NULL,
  `pur_date` varchar(64) DEFAULT NULL,
  `total_discount` varchar(64) DEFAULT NULL,
  `tax` varchar(255) NOT NULL,
  `delivery_time` int(11) NOT NULL,
  `payment_time` int(11) NOT NULL,
  `gtotal_amount` varchar(64) DEFAULT NULL,
  `adjustment` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `entry_date` varchar(64) DEFAULT NULL,
  `entry_id` varchar(128) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_draft`
--

CREATE TABLE `purchase_draft` (
  `id` int(11) NOT NULL,
  `supplier_id` varchar(255) NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `invoice_date` date NOT NULL,
  `note` text NOT NULL,
  `delivery_time` int(11) NOT NULL,
  `payment_time` int(11) NOT NULL,
  `total` varchar(255) NOT NULL DEFAULT '0',
  `tax` varchar(255) NOT NULL DEFAULT '0',
  `totaldiscount` varchar(255) NOT NULL DEFAULT '0',
  `grandTotal` varchar(255) NOT NULL DEFAULT '0',
  `adjustment` varchar(255) NOT NULL DEFAULT '0',
  `paid` varchar(255) NOT NULL DEFAULT '0',
  `due` varchar(255) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_draft_meta`
--

CREATE TABLE `purchase_draft_meta` (
  `id` int(11) NOT NULL,
  `draft_id` int(11) NOT NULL,
  `medicine_id` varchar(255) NOT NULL,
  `batch` varchar(255) NOT NULL,
  `exp_date` date NOT NULL,
  `qnty` int(11) NOT NULL,
  `free_qnty` int(11) NOT NULL,
  `purchase_rate` int(11) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `mrp` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_history`
--

CREATE TABLE `purchase_history` (
  `ph_id` int(11) NOT NULL,
  `pur_id` varchar(128) DEFAULT NULL,
  `mid` varchar(128) DEFAULT NULL,
  `supp_id` varchar(64) DEFAULT NULL,
  `qty` varchar(128) DEFAULT NULL,
  `unit` varchar(255) NOT NULL,
  `free_qty` varchar(128) DEFAULT NULL,
  `return_qnty` int(11) NOT NULL,
  `supplier_price` varchar(128) DEFAULT NULL,
  `unit_price` varchar(255) NOT NULL,
  `discount` varchar(128) DEFAULT NULL,
  `expire_date` varchar(128) DEFAULT NULL,
  `Batch_Number` varchar(255) NOT NULL,
  `delivery_time` int(11) NOT NULL,
  `actual_purrate` varchar(255) NOT NULL,
  `payment_time` int(11) NOT NULL,
  `mrp` varchar(255) NOT NULL,
  `unit_mrp` varchar(255) NOT NULL,
  `total_amount` varchar(128) NOT NULL,
  `tax` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return`
--

CREATE TABLE `purchase_return` (
  `id` int(11) NOT NULL,
  `r_id` varchar(64) DEFAULT NULL,
  `pur_id` varchar(64) DEFAULT NULL,
  `sid` varchar(64) DEFAULT NULL,
  `invoice_no` varchar(128) DEFAULT NULL,
  `return_date` varchar(128) DEFAULT NULL,
  `total_deduction` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_details`
--

CREATE TABLE `purchase_return_details` (
  `id` int(11) NOT NULL,
  `r_id` varchar(128) DEFAULT NULL,
  `pur_id` varchar(128) DEFAULT NULL,
  `supp_id` varchar(64) DEFAULT NULL,
  `mid` varchar(128) DEFAULT NULL,
  `return_qty` varchar(64) DEFAULT NULL,
  `deduction_amount` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reverse_stock`
--

CREATE TABLE `reverse_stock` (
  `id` int(11) NOT NULL,
  `request_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `supplier_id` varchar(255) NOT NULL,
  `Batch_Number` varchar(255) NOT NULL,
  `expire_date` varchar(255) NOT NULL,
  `from_store_id` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `rev_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `permissions` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `permissions`) VALUES
(32, 'Super', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,88,89,90,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,102,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,101,67,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,91,97,99,100'),
(33, 'Sales person', '1,2,6,7,8,10,11,12,13,14,15,16,18,19,20,22,88,89,90,26,29,30,31,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,102,50,51,52,53,54,55,56,57,60,61,63,64,67,91'),
(34, 'Store manager', '1,2,88,89,90,50,51,52,53,54,57,58,59,60,91,97,99,100');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `module` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `title`, `module`) VALUES
(1, 'pos_add', 'POS'),
(2, 'pos_edit', 'POS'),
(3, 'customer_view_admin', 'Customer'),
(4, 'customer_add_admin', 'Customer'),
(5, 'customer_edit_admin', 'Customer'),
(6, 'manufacturer_view_admin', 'Manufacturer'),
(7, 'manufacturer_add_admin', 'Manufacturer'),
(8, 'manufacturer_edit_admin', 'Manufacturer'),
(9, 'manufacturer_delete_admin', 'Manufacturer'),
(10, 'hsn_view_admin', 'HSN'),
(11, 'hsn_add_admin', 'HSN'),
(12, 'hsn_edit_admin', 'HSN'),
(13, 'hsn_delete_admin', 'HSN'),
(14, 'medicineuom_view_admin', 'UOM'),
(15, 'medicineuom_add_admin', 'UOM'),
(16, 'medicineuom_edit_admin', 'UOM'),
(17, 'medicineuom_delete_admin', 'UOM'),
(18, 'medicine_view', 'Medicine'),
(19, 'medicine_add', 'Medicine'),
(20, 'medicine_edit', 'Medicine'),
(21, 'medicine_delete', 'Medicine'),
(22, 'store_view_admin', 'Store'),
(23, 'store_add_admin', 'Store'),
(24, 'store_edit_admin', 'Store'),
(25, 'store_delete_admin', 'Store'),
(26, 'employee_view', 'Employee'),
(27, 'employee_add', 'Employee'),
(28, 'employee_edit', 'Employee'),
(29, 'supplier_view', 'Supplier'),
(30, 'supplier_add', 'Supplier'),
(31, 'supplier_edit', 'Supplier'),
(32, 'supplierbal_view', 'Supplier'),
(33, 'purchase_view', 'Purchase'),
(34, 'purchase_add', 'Purchase'),
(35, 'purchase_edit', 'Purchase'),
(36, 'grn_view', 'GRN'),
(37, 'grn_add', 'GRN'),
(38, 'all_manage_stockview', 'All Inventory'),
(39, 'all_short_stockview', 'All Inventory'),
(40, 'all_outofstock_stockview', 'All Inventory'),
(41, 'all_soonexp_stockview', 'All Inventory'),
(42, 'all_exp_stockview', 'All Inventory'),
(43, 'all_impstock_stockadd', 'All Inventory'),
(44, 'all_transinv_view', 'All Inventory'),
(45, 'all_transinv_add', 'All Inventory'),
(46, 'all_reqstock_view', 'All Inventory'),
(47, 'all_returnstock_view', 'All Inventory'),
(48, 'all_returnstock_add', 'All Inventory'),
(49, 'all_stockadj_add', 'All Inventory'),
(50, 'store_managestock_view', 'Store Inventory'),
(51, 'store_shortstock_view', 'Store Inventory'),
(52, 'store_outofstock_view', 'Store Inventory'),
(53, 'store_soonexp_view', 'Store Inventory'),
(54, 'store_exp_view', 'Store Inventory'),
(55, 'dep_summ_view', 'Department Summary'),
(56, 'product_led_view', 'Product Ledger'),
(57, 'reports_today_view', 'Report'),
(58, 'reports_sales_view', 'Report'),
(59, 'reports_itemcon_view', 'Report'),
(60, 'reports_salesret_view', 'Report'),
(61, 'reports_purchase_view', 'Report'),
(62, 'reports_purreturn_view', 'Report'),
(63, 'reports_closingstock_view', 'Report'),
(64, 'reports_currstock_view', 'Report'),
(65, 'reports_fastmoving_view', 'Report'),
(66, 'reports_slowmoving_view', 'Report'),
(67, 'return_purret_add', 'Return'),
(69, 'acc_cusbal_view', 'Accounts'),
(70, 'acc_suppbal_view', 'Accounts'),
(71, 'acc_payments_view', 'Accounts'),
(72, 'acc_payments_add', 'Accounts'),
(73, 'acc_closing_add', 'Accounts'),
(74, 'acc_managebank_view', 'Accounts'),
(75, 'acc_managebank_add', 'Accounts'),
(76, 'help_phnbook_view', 'Help'),
(77, 'help_doctor_view', 'Help'),
(78, 'help_doctor_add', 'Help'),
(79, 'help_hospital_view', 'Help'),
(80, 'help_hospital_add', 'Help'),
(81, 'help_ambulance_view', 'Help'),
(82, 'help_ambulance_add', 'Help'),
(83, 'help_fire_view', 'Help'),
(84, 'help_fire_add', 'Help'),
(85, 'help_police_view', 'Help'),
(86, 'help_police_add', 'Help'),
(87, 'setting_add', 'Setting'),
(88, 'Store_reqstock', 'Store'),
(89, 'Store_reqhistory', 'Store'),
(90, 'store_returnstock', 'Store'),
(91, 'sales_return', 'Sales'),
(97, 'add_employee_store', 'Store Manager'),
(99, 'edit_employee_store', 'Store Manager'),
(100, 'view_employee_store', 'Store Manager'),
(101, 'profit_report', 'Report'),
(102, 'all_stockadj_his', 'All Inventory');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `store_id` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `walkin_cus_name` varchar(255) NOT NULL,
  `sale_id` varchar(64) DEFAULT NULL,
  `doctor_name` text NOT NULL,
  `paid_amount` varchar(64) DEFAULT NULL,
  `cus_id` varchar(64) DEFAULT NULL,
  `walkin_phone` varchar(255) NOT NULL,
  `total_discount` varchar(64) DEFAULT NULL,
  `discount_type` varchar(64) NOT NULL,
  `total_amount` varchar(64) DEFAULT NULL,
  `sales_time` varchar(255) DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_tax` varchar(255) NOT NULL,
  `due_amount` varchar(64) DEFAULT NULL,
  `payment_mode` varchar(255) NOT NULL,
  `invoice_no` varchar(128) DEFAULT NULL,
  `create_date` varchar(128) DEFAULT NULL,
  `monthyear` varchar(64) DEFAULT NULL,
  `entryid` varchar(64) DEFAULT NULL,
  `counter` varchar(64) DEFAULT NULL,
  `pay_status` enum('Hold','Pay') NOT NULL DEFAULT 'Pay',
  `sale_date` date NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_details`
--

CREATE TABLE `sales_details` (
  `sd_id` int(11) NOT NULL,
  `sale_id` varchar(128) DEFAULT NULL,
  `mid` varchar(128) DEFAULT NULL,
  `supplier_id` varchar(255) NOT NULL,
  `Batch_Number` varchar(255) NOT NULL,
  `cartoon` varchar(128) DEFAULT NULL,
  `qty` varchar(128) DEFAULT NULL,
  `rate` varchar(128) DEFAULT NULL,
  `supp_rate` varchar(128) NOT NULL,
  `total_price` varchar(128) DEFAULT NULL,
  `total_tax` varchar(255) NOT NULL,
  `initial_stock` varchar(128) NOT NULL,
  `perunit_profit` varchar(255) NOT NULL,
  `grand_total` int(11) NOT NULL,
  `discount` varchar(128) DEFAULT NULL,
  `gdiscount` varchar(255) NOT NULL,
  `total_discount` varchar(64) DEFAULT NULL,
  `sale_date` date NOT NULL,
  `store_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_return`
--

CREATE TABLE `sales_return` (
  `id` int(11) NOT NULL,
  `sr_id` varchar(128) DEFAULT NULL,
  `cus_id` varchar(128) DEFAULT NULL,
  `sale_id` varchar(128) DEFAULT NULL,
  `invoice_no` varchar(256) DEFAULT NULL,
  `return_date` varchar(128) DEFAULT NULL,
  `total_deduction` varchar(128) DEFAULT NULL,
  `total_amount` varchar(128) DEFAULT NULL,
  `entry_id` varchar(128) DEFAULT NULL,
  `counter` varchar(128) DEFAULT NULL,
  `tax` varchar(255) NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_return_details`
--

CREATE TABLE `sales_return_details` (
  `id` int(11) NOT NULL,
  `sr_id` varchar(128) DEFAULT NULL,
  `mid` varchar(128) DEFAULT NULL,
  `r_qty` varchar(128) DEFAULT NULL,
  `r_total` varchar(128) DEFAULT NULL,
  `r_deduction` varchar(128) DEFAULT NULL,
  `date` varchar(128) DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  `tax` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `sales_return_details`
--

INSERT INTO `sales_return_details` (`id`, `sr_id`, `mid`, `r_qty`, `r_total`, `r_deduction`, `date`, `store_id`, `tax`) VALUES
(18, 'SR2860613', 'P36581', '2', '20', '0', '08-24-2024', 0, 0),
(19, 'SR4810471', 'P19291', '2', '39.2', '0', '09-09-2024', 0, 0),
(20, 'SR3941923', 'P25253', '5', '495', '0', '09-17-2024', 0, 0),
(21, 'SR4853314', 'P25253', '1', '100', '0', '09-17-2024', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `sitelogo` varchar(128) DEFAULT NULL,
  `sitetitle` varchar(256) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `copyright` varchar(128) DEFAULT NULL,
  `contact` varchar(128) DEFAULT NULL,
  `currency` varchar(128) DEFAULT NULL,
  `symbol` varchar(64) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `main_store_id` int(11) NOT NULL,
  `gst` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `sitelogo`, `sitetitle`, `description`, `copyright`, `contact`, `currency`, `symbol`, `email`, `address`, `main_store_id`, `gst`) VALUES
(1, 'Med Jacket', '1.PNG', 'Lims', '', '', '', '', '', '', '', 78, '');

-- --------------------------------------------------------

--
-- Table structure for table `stock_request`
--

CREATE TABLE `stock_request` (
  `id` int(11) NOT NULL,
  `request_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `Batch_Number` varchar(255) NOT NULL,
  `request_qty` int(11) NOT NULL,
  `full_fill_qty` int(11) NOT NULL,
  `store_id` varchar(11) NOT NULL,
  `mrp` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `createdat` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_request`
--

INSERT INTO `stock_request` (`id`, `request_id`, `product_id`, `Batch_Number`, `request_qty`, `full_fill_qty`, `store_id`, `mrp`, `status`, `createdat`) VALUES
(16, 'Req6935468', 'P25253', '', 10, 10, '116', 0, 'returned', '2024-09-17 13:16:40');

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer`
--

CREATE TABLE `stock_transfer` (
  `id` int(11) NOT NULL,
  `stock_transfer_id` varchar(255) NOT NULL,
  `store_id` int(11) NOT NULL,
  `net_amount` int(11) NOT NULL,
  `total_tax` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `createdAT` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_transfer`
--

INSERT INTO `stock_transfer` (`id`, `stock_transfer_id`, `store_id`, `net_amount`, `total_tax`, `total_amount`, `createdAT`, `date`) VALUES
(21, 'T7379296', 111, 168, 20, 188, 1724505445, '2024-08-24'),
(22, 'T6974108', 112, 162, 19, 182, 1725361189, '2024-09-03'),
(23, 'T1289623', 111, 17, 2, 19, 1725972218, '2024-09-10'),
(24, 'T9800803', 111, 101, 12, 113, 1726035329, '2024-09-11'),
(25, 'T3182672', 114, 193, 23, 216, 1726215335, '2024-09-13'),
(26, 'T4495843', 112, 5, 1, 5, 1726312675, '2024-09-14'),
(27, 'T2859031', 116, 896, 108, 1004, 1726556793, '2024-09-17'),
(28, 'T6965331', 116, 978, 117, 1095, 1726557320, '2024-09-17'),
(29, 'T3213605', 116, 110, 13, 123, 1726567219, '2024-09-17');

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer_history`
--

CREATE TABLE `stock_transfer_history` (
  `id` int(11) NOT NULL,
  `stock_transfer_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `supplier_id` varchar(255) NOT NULL,
  `Batch_Number` varchar(255) NOT NULL,
  `manf_date` varchar(255) NOT NULL,
  `expire_date` varchar(255) NOT NULL,
  `purchase_rate` int(11) NOT NULL,
  `mrp` int(11) NOT NULL,
  `instock` int(11) NOT NULL,
  `sale_qty` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `tax` int(11) NOT NULL,
  `createdat` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `sum` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `id` int(11) NOT NULL,
  `store_id` varchar(255) NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `store_alias` varchar(255) NOT NULL,
  `store_point_type` varchar(255) NOT NULL COMMENT '0=main\r\n1=sub',
  `transaction_type` varchar(255) NOT NULL COMMENT '0->op,\r\n1->ip,\r\n2->ot',
  `medical_type` varchar(255) NOT NULL COMMENT '0->medical,\r\n1->non-medical',
  `payment_type` varchar(255) NOT NULL COMMENT '0->cash,\r\n1->credit,\r\n2->both',
  `rounding_value` varchar(255) NOT NULL COMMENT '0->.25,\r\n1->.50,\r\n2->1.00',
  `round` varchar(255) NOT NULL,
  `discount_facility_discount` varchar(255) NOT NULL COMMENT '0->yes,\r\n1->no',
  `discount_facility_doc_dis` varchar(255) NOT NULL,
  `discount_facility_dis_val` varchar(255) NOT NULL,
  `discount_facility_doc_dis_val` varchar(255) NOT NULL,
  `ip_tax_applicable` varchar(255) NOT NULL COMMENT '0->no,\r\n1->ward group wise tax',
  `ip_tax_all_ward_flat` varchar(255) NOT NULL,
  `ot_tax_applicable` varchar(255) NOT NULL,
  `op_tax_applicable` varchar(255) NOT NULL,
  `returns_applicable` varchar(255) NOT NULL COMMENT '0->yes,\r\n1->no',
  `returns_applicable_days` varchar(255) NOT NULL,
  `returns_applicable_contract_days` varchar(255) NOT NULL,
  `returns_applicable_view_ledger` varchar(255) NOT NULL,
  `gst_not_applicable` varchar(255) NOT NULL COMMENT '0->uncheck,\r\n1->checked',
  `req_for_discharge` varchar(255) NOT NULL COMMENT '0->unchecked,\r\n1->checked',
  `item_code_editable` varchar(255) NOT NULL COMMENT '0->unchecked,\r\n1->checked',
  `dm_discount` varchar(255) NOT NULL,
  `is_remark` varchar(255) NOT NULL COMMENT '0->unchecked,\r\n1->checked',
  `direct_approve` varchar(255) NOT NULL,
  `look_indents` varchar(255) NOT NULL COMMENT '0->good receipt note,\r\n1->stock_point billing, \r\n2->material return',
  `look_indents_val` varchar(255) NOT NULL,
  `by_default_active` varchar(255) NOT NULL COMMENT '0->items masters, 1->manufacturer masters, 2->item expiry',
  `indent_setting` varchar(255) NOT NULL COMMENT '0->nurse indent,\r\n1->purchase order,\r\n2->dept indent,3->casuality',
  `indent_setting_nurse_val` varchar(255) NOT NULL,
  `nurse_indent` varchar(255) NOT NULL,
  `indent_setting_purchase_val` varchar(11) NOT NULL,
  `casulality` varchar(255) NOT NULL,
  `purchase_order` varchar(255) NOT NULL,
  `indent_setting_dept_val` int(11) NOT NULL,
  `dept_order` varchar(255) NOT NULL,
  `lock_indents` varchar(255) NOT NULL COMMENT '0->goods receipt, 1->goods issue,2->stock point,3->dept billing',
  `less_returns` int(11) NOT NULL COMMENT '0->yes, 1->no',
  `less_returns_if_yes` int(11) NOT NULL COMMENT '0->%, 1->cash',
  `less_returns_val` varchar(255) NOT NULL,
  `item_search` varchar(255) NOT NULL COMMENT '0->item cd, 1->item name',
  `mrq_indent` int(11) NOT NULL COMMENT '0->auto, 1->manual',
  `mandatory_field` varchar(255) NOT NULL,
  `bar_code` varchar(255) NOT NULL COMMENT '0->bar_code,1->wireless',
  `bar_code_val` varchar(255) NOT NULL,
  `barcode_label` varchar(255) NOT NULL,
  `barcode_label_val` varchar(255) NOT NULL,
  `wireless_device` varchar(255) NOT NULL,
  `wireless_device_val` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`id`, `store_id`, `store_name`, `store_alias`, `store_point_type`, `transaction_type`, `medical_type`, `payment_type`, `rounding_value`, `round`, `discount_facility_discount`, `discount_facility_doc_dis`, `discount_facility_dis_val`, `discount_facility_doc_dis_val`, `ip_tax_applicable`, `ip_tax_all_ward_flat`, `ot_tax_applicable`, `op_tax_applicable`, `returns_applicable`, `returns_applicable_days`, `returns_applicable_contract_days`, `returns_applicable_view_ledger`, `gst_not_applicable`, `req_for_discharge`, `item_code_editable`, `dm_discount`, `is_remark`, `direct_approve`, `look_indents`, `look_indents_val`, `by_default_active`, `indent_setting`, `indent_setting_nurse_val`, `nurse_indent`, `indent_setting_purchase_val`, `casulality`, `purchase_order`, `indent_setting_dept_val`, `dept_order`, `lock_indents`, `less_returns`, `less_returns_if_yes`, `less_returns_val`, `item_search`, `mrq_indent`, `mandatory_field`, `bar_code`, `bar_code_val`, `barcode_label`, `barcode_label_val`, `wireless_device`, `wireless_device_val`) VALUES
(78, 'Main001', 'Main_store', 'ms001', '0', '', '0', '0', '', '', '', '', '', '', '0', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 1, 0, '', '0', 0, '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `store_medicine_mata`
--

CREATE TABLE `store_medicine_mata` (
  `id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `supplier_id` varchar(256) NOT NULL,
  `Batch_Number` varchar(255) NOT NULL,
  `manf_date` varchar(255) NOT NULL,
  `expire_date` varchar(255) NOT NULL,
  `purchase_rate` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mrp` float NOT NULL,
  `unit_mrp` varchar(255) NOT NULL,
  `instock` int(11) NOT NULL,
  `sale_qty` int(11) NOT NULL,
  `discount` int(11) NOT NULL DEFAULT 0,
  `createdat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tax` int(11) NOT NULL,
  `store_id` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `s_id` varchar(64) DEFAULT NULL,
  `s_name` varchar(256) DEFAULT NULL,
  `s_email` varchar(256) DEFAULT NULL,
  `s_note` varchar(512) DEFAULT NULL,
  `s_phone` varchar(128) DEFAULT NULL,
  `s_address` varchar(512) DEFAULT NULL,
  `s_img` varchar(256) DEFAULT NULL,
  `entrydate` varchar(128) DEFAULT NULL,
  `s_gst` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_ledger`
--

CREATE TABLE `supplier_ledger` (
  `id` int(11) NOT NULL,
  `supplier_id` varchar(256) DEFAULT NULL,
  `total_amount` varchar(256) DEFAULT NULL,
  `total_paid` varchar(256) DEFAULT NULL,
  `total_due` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_product`
--

CREATE TABLE `supplier_product` (
  `sp_id` int(11) NOT NULL,
  `pro_id` varchar(64) DEFAULT NULL,
  `sup_id` varchar(64) DEFAULT NULL,
  `sup_price` varchar(64) DEFAULT NULL,
  `sup_date` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supp_account`
--

CREATE TABLE `supp_account` (
  `id` int(11) NOT NULL,
  `supplier_id` varchar(64) DEFAULT NULL,
  `pur_id` varchar(128) DEFAULT NULL,
  `total_amount` varchar(64) DEFAULT NULL,
  `paid_amount` varchar(64) DEFAULT NULL,
  `due_amount` varchar(256) DEFAULT NULL,
  `from` varchar(128) DEFAULT NULL,
  `date` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supp_payment`
--

CREATE TABLE `supp_payment` (
  `id` int(11) NOT NULL,
  `supp_id` varchar(64) DEFAULT NULL,
  `pur_id` varchar(64) DEFAULT NULL,
  `type` varchar(64) DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `cheque_no` varchar(128) DEFAULT NULL,
  `issue_date` varchar(64) DEFAULT NULL,
  `receiver_name` varchar(128) DEFAULT NULL,
  `receiver_contact` varchar(128) DEFAULT NULL,
  `from` varchar(128) DEFAULT NULL,
  `paid_amount` varchar(64) DEFAULT NULL,
  `date` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `form` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `note` varchar(1000) NOT NULL,
  `qnty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `form`, `unit`, `note`, `qnty`) VALUES
(87, '1', '1:1', '1 in 1', 1),
(88, '24', '1:1', '1 in 1', 1),
(89, '2', '1:1', '1 in 1', 1),
(90, '7', '1:1 ', '1 in 1', 1),
(91, '2', '1:10', '10 capsules in 1 packet', 10);

-- --------------------------------------------------------

--
-- Table structure for table `unit_form`
--

CREATE TABLE `unit_form` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unit_form`
--

INSERT INTO `unit_form` (`id`, `title`) VALUES
(1, 'Tablet'),
(2, 'Capsule'),
(3, 'Syring'),
(4, 'Injection'),
(5, 'Eye Drop'),
(6, 'Suspension'),
(7, 'Cream'),
(8, 'Saline'),
(9, 'Inhaler'),
(10, 'Syrup'),
(11, 'Powder'),
(12, 'Spray'),
(13, 'Paediatric Drop'),
(14, 'Nebuliser Solution'),
(15, 'Powder for Suspension'),
(16, 'Nasal Drops'),
(17, 'Eye Ointment'),
(18, 'Infusion Liquid'),
(19, 'Bandage'),
(20, 'Oral drops'),
(21, 'Lotion'),
(22, 'Ointment Fluid'),
(23, 'soap'),
(24, 'Abdominal belt'),
(25, 'Bandage Roll'),
(26, 'Cannula Fixer'),
(27, 'Calvice Brace'),
(28, 'Ear Drop'),
(29, 'Enema'),
(30, 'IV Cannula'),
(31, 'IV Fluid'),
(32, 'Jelly'),
(33, 'Liquid'),
(34, 'Oral Suspension'),
(35, 'Sachet'),
(36, 'Solution'),
(37, 'Surgical'),
(38, 'Urine Bag'),
(39, 'IV Set'),
(40, 'Swabs'),
(41, 'Mask'),
(42, 'Drops'),
(43, 'Oral Solution'),
(44, 'Kit');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `em_id` varchar(64) DEFAULT NULL,
  `em_name` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `em_role` varchar(256) NOT NULL DEFAULT 'SALESMAN',
  `em_type` varchar(256) NOT NULL,
  `em_contact` varchar(128) DEFAULT NULL,
  `em_address` varchar(512) DEFAULT NULL,
  `em_image` varchar(256) DEFAULT NULL,
  `em_details` varchar(512) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `em_entrydate` varchar(64) DEFAULT NULL,
  `em_ip` varchar(64) DEFAULT NULL,
  `store` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `em_id`, `em_name`, `email`, `password`, `em_role`, `em_type`, `em_contact`, `em_address`, `em_image`, `em_details`, `status`, `em_entrydate`, `em_ip`, `store`) VALUES
(24, 'U392', 'Nishant', 'nishant123@gmail.com', 'f63036841208c85f367cbb2680dea8125d001372', '32', 'admin', '9014393264', 'Kothuru', 'U392.jpeg', 'Pharmacy', 'ACTIVE', '0', '192.168.152.1', '78');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts_report`
--
ALTER TABLE `accounts_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adjustment_tble`
--
ALTER TABLE `adjustment_tble`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ambulance`
--
ALTER TABLE `ambulance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `closing`
--
ALTER TABLE `closing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `closing_tble`
--
ALTER TABLE `closing_tble`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `current_stock`
--
ALTER TABLE `current_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_ledger`
--
ALTER TABLE `customer_ledger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `direct_approve`
--
ALTER TABLE `direct_approve`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fire_service`
--
ALTER TABLE `fire_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grn`
--
ALTER TABLE `grn`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gst`
--
ALTER TABLE `gst`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_notes`
--
ALTER TABLE `invoice_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_history`
--
ALTER TABLE `login_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manufacturer`
--
ALTER TABLE `manufacturer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medication`
--
ALTER TABLE `medication`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine`
--
ALTER TABLE `medicine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_mata`
--
ALTER TABLE `medicine_mata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meta_grn`
--
ALTER TABLE `meta_grn`
  ADD PRIMARY KEY (`idd`);

--
-- Indexes for table `police`
--
ALTER TABLE `police`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_draft`
--
ALTER TABLE `purchase_draft`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_draft_meta`
--
ALTER TABLE `purchase_draft_meta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD PRIMARY KEY (`ph_id`);

--
-- Indexes for table `purchase_return`
--
ALTER TABLE `purchase_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reverse_stock`
--
ALTER TABLE `reverse_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_details`
--
ALTER TABLE `sales_details`
  ADD PRIMARY KEY (`sd_id`);

--
-- Indexes for table `sales_return`
--
ALTER TABLE `sales_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_return_details`
--
ALTER TABLE `sales_return_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_request`
--
ALTER TABLE `stock_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_transfer`
--
ALTER TABLE `stock_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_transfer_history`
--
ALTER TABLE `stock_transfer_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_medicine_mata`
--
ALTER TABLE `store_medicine_mata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_ledger`
--
ALTER TABLE `supplier_ledger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_product`
--
ALTER TABLE `supplier_product`
  ADD PRIMARY KEY (`sp_id`);

--
-- Indexes for table `supp_account`
--
ALTER TABLE `supp_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supp_payment`
--
ALTER TABLE `supp_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_form`
--
ALTER TABLE `unit_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounts_report`
--
ALTER TABLE `accounts_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adjustment_tble`
--
ALTER TABLE `adjustment_tble`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ambulance`
--
ALTER TABLE `ambulance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `closing`
--
ALTER TABLE `closing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `closing_tble`
--
ALTER TABLE `closing_tble`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `current_stock`
--
ALTER TABLE `current_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_ledger`
--
ALTER TABLE `customer_ledger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `direct_approve`
--
ALTER TABLE `direct_approve`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fire_service`
--
ALTER TABLE `fire_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grn`
--
ALTER TABLE `grn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gst`
--
ALTER TABLE `gst`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hospital`
--
ALTER TABLE `hospital`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_notes`
--
ALTER TABLE `invoice_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manufacturer`
--
ALTER TABLE `manufacturer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medication`
--
ALTER TABLE `medication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine`
--
ALTER TABLE `medicine`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_mata`
--
ALTER TABLE `medicine_mata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meta_grn`
--
ALTER TABLE `meta_grn`
  MODIFY `idd` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `police`
--
ALTER TABLE `police`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_draft`
--
ALTER TABLE `purchase_draft`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_draft_meta`
--
ALTER TABLE `purchase_draft_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_history`
--
ALTER TABLE `purchase_history`
  MODIFY `ph_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_return`
--
ALTER TABLE `purchase_return`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reverse_stock`
--
ALTER TABLE `reverse_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_details`
--
ALTER TABLE `sales_details`
  MODIFY `sd_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_return`
--
ALTER TABLE `sales_return`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_return_details`
--
ALTER TABLE `sales_return_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_request`
--
ALTER TABLE `stock_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `stock_transfer`
--
ALTER TABLE `stock_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `stock_transfer_history`
--
ALTER TABLE `stock_transfer_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `store_medicine_mata`
--
ALTER TABLE `store_medicine_mata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_ledger`
--
ALTER TABLE `supplier_ledger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_product`
--
ALTER TABLE `supplier_product`
  MODIFY `sp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supp_account`
--
ALTER TABLE `supp_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supp_payment`
--
ALTER TABLE `supp_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `unit_form`
--
ALTER TABLE `unit_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
