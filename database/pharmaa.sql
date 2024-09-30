-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 16, 2024 at 06:52 AM
-- Server version: 10.11.7-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u584415195_gen_pharmacy`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(14) NOT NULL,
  `amount` varchar(64) DEFAULT NULL,
  `due` varchar(64) DEFAULT NULL,
  `paid` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_report`
--

CREATE TABLE `accounts_report` (
  `id` int(14) NOT NULL,
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
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `accounts_report`
--

INSERT INTO `accounts_report` (`id`, `transection_type`, `transection_name`, `description`, `mtype`, `cheque`, `issuedate`, `bankid`, `amount`, `entry_id`, `date`, `created_at`) VALUES
(1, 'Payment', 'Medjacket', 'Device', 'Bank', '', '', '2', '500000', 'U392', '04/05/2024', '2024-05-04 12:13:58');

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
  `adjus_qty` varchar(255) NOT NULL,
  `generic_name` int(11) NOT NULL
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

--
-- Dumping data for table `ambulance`
--

INSERT INTO `ambulance` (`id`, `name`, `email`, `contact`, `address`, `hospital_name`, `notes`) VALUES
(0, 'Alice', 'alice1998@yopmail.com', '08529637410', '510 Townsend St', 'KIIMS Hospital', '');

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `bank_id` int(14) NOT NULL,
  `bank_name` varchar(256) DEFAULT NULL,
  `account_name` varchar(256) DEFAULT NULL,
  `account_number` varchar(512) DEFAULT NULL,
  `branch` varchar(512) DEFAULT NULL,
  `signature` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`bank_id`, `bank_name`, `account_name`, `account_number`, `branch`, `signature`) VALUES
(2, 'ADB Bank', 'MEDJECKET', '5555555555', 'Hyderabad', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `closing`
--

CREATE TABLE `closing` (
  `id` int(14) NOT NULL,
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
  `id` int(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `supplier_id` varchar(255) NOT NULL,
  `batch_no` varchar(255) NOT NULL,
  `exp_date` varchar(255) NOT NULL,
  `unit_mrp` varchar(255) NOT NULL,
  `instock` int(255) NOT NULL,
  `purchase_rate` varchar(255) NOT NULL,
  `purchase_wid_tax` varchar(255) NOT NULL,
  `sale_price` varchar(255) NOT NULL,
  `sale_price_wid_tax` varchar(255) NOT NULL,
  `in_house_purchase_val` varchar(255) NOT NULL,
  `in_house_sale_val` varchar(255) NOT NULL,
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
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

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `status`) VALUES
(1, 'ACI', 'ACTIVE'),
(2, 'Aristopharma', 'ACTIVE'),
(3, 'Global', 'ACTIVE'),
(4, 'Beximco', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(14) NOT NULL,
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
  `regular_discount` varchar(64) DEFAULT NULL,
  `target_amount` varchar(64) DEFAULT NULL,
  `target_discount` varchar(64) DEFAULT NULL,
  `entrydate` varchar(64) DEFAULT NULL,
  `store_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `c_id`, `patient_id`, `c_name`, `pharmacy_name`, `c_email`, `c_type`, `barcode`, `cus_contact`, `c_address`, `c_note`, `c_img`, `regular_discount`, `target_amount`, `target_discount`, `entrydate`, `store_id`) VALUES
(1, 'C360033', '', 'Ravi', NULL, NULL, 'Walkin', NULL, '9876345210', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(2, 'C36377', '', 'Cash', NULL, NULL, 'Walkin', NULL, '6789065432', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(3, 'C969183', '', 'Cash', NULL, NULL, 'Walkin', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(4, 'C273800', '', 'Cash', NULL, NULL, 'Walkin', NULL, '9876543210', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(5, 'C337551', '', 'Cash', NULL, NULL, 'Walkin', NULL, '0987654300', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(6, 'C475688', '', 'Cash', NULL, NULL, 'Walkin', NULL, '987654000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(7, 'C15534664', '', 'Anu', '', 'anu@gmail.com', 'Regular', '4691975', '7489653210', 'BHEL', '', 'C15534664.png', '3', '5000', '5', '1715040000', 0),
(8, 'C14701813', '', 'Praveen', 'Praveen Pharmacy', 'praveen@gmail.com', 'Wholesale', '3184324', '9874563210', 'BHEL', '', 'C14701813.png', '', '', '', '1715040000', 0),
(9, 'C311543', '', 'pavan', NULL, NULL, 'Walkin', NULL, '6678901234', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(10, 'C142510', '', 'charan', NULL, NULL, 'Walkin', NULL, '2345689654', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(11, 'C517857', 'P1236789', 'Nitin Sharma', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 68),
(12, 'C419946', 'P123', 'Test Med', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 78);

-- --------------------------------------------------------

--
-- Table structure for table `customer_ledger`
--

CREATE TABLE `customer_ledger` (
  `id` int(14) NOT NULL,
  `customer_id` varchar(64) DEFAULT NULL,
  `total_balance` varchar(64) DEFAULT NULL,
  `total_paid` varchar(64) NOT NULL,
  `total_due` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `customer_ledger`
--

INSERT INTO `customer_ledger` (`id`, `customer_id`, `total_balance`, `total_paid`, `total_due`) VALUES
(1, 'C15534664', '0', '0', '0'),
(2, 'C14701813', '0', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `direct_approve`
--

CREATE TABLE `direct_approve` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `direct_approve`
--

INSERT INTO `direct_approve` (`id`, `name`) VALUES
(1, 'Goods Receipt notes(GRN)'),
(2, 'Goods Issue notes(GIN)'),
(3, 'Non returnable delivery challan(NRDC)'),
(4, 'Department adjustable note'),
(5, 'Returnable delivery challan(RDC)'),
(6, 'Returnable delivery challan Returns (RDR)'),
(7, 'Courier entry detail'),
(8, 'Purchase indent cancel '),
(9, 'Purchase orders(PO)'),
(10, 'Material return note(MRN)'),
(11, 'Nurse Requisition (NRQ)'),
(12, 'Material Requisition (MRQ)'),
(13, 'Scrap note(SCN)'),
(14, 'Patients return '),
(15, 'Material Requisitions cancel'),
(16, 'Purchase order cancel');

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

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `name`, `address`, `contact`, `email`) VALUES
(2, 'Ram Karri', 'Door No 25, 66; Plot-c, Ashok Nagar,', '9059973066', 'info@medjacket.com');

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

--
-- Dumping data for table `fire_service`
--

INSERT INTO `fire_service` (`id`, `name`, `email`, `contact`, `address`) VALUES
(0, 'prashanthi Macharla', 'krishna@gmail.com', '9701456225', 'Manovikas Nagar,old Bowenpally');

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

--
-- Dumping data for table `grn`
--

INSERT INTO `grn` (`id`, `grn_date`, `store_name`, `po_no`, `supplier_name`, `order_type`, `supplier_code`, `grn_no`, `dc_no`, `dc_date`, `bill_no`, `bill_date`, `bill_amt`, `product_name`, `generic_name`, `manf_date`, `sale_qty`, `unit_price`, `box_price`, `purchase`, `Sch_no`, `Sch_date`, `rec_qty`, `receivedamt`, `dues`) VALUES
(1, '2024-05-07', '', 'P4877398', 'Medmed', 'Telephonic', 'S43130', 'GRN4963636', '124324', '2024-05-22', '3786', '07-05-2024', '', 'Amoxicillin ', 'Amoxicillin', '', '', '', '', '', '', '', '', '', ''),
(2, '2024-05-07', '', 'P5178531', 'Clinc', 'Telephonic Order', 'S42177', 'GRN7221026', 'dc00', '2024-05-08', '7890011', '07-05-2024', '', 'Allegra', 'fexofenadine', '', '', '', '', '', '', '', '', '', ''),
(3, '2024-05-07', '', 'P5787600', 'Derma pharmacy', '', 'S54301', 'GRN5035815', '', '', '7700112200', '07-05-2024', '', 'Amoxicillin ', 'Amoxicillin', '', '', '', '', '', '', '', '', '', ''),
(4, '2024-05-07', '', 'P1194309', 'Raja Suppliers', '', 'S43280', 'GRN1650384', '', '', '8974500', '07-05-2024', '', 'Xanax', 'alprazolam', '', '', '', '', '', '', '', '', '', ''),
(5, '2024-05-16', '', 'P350391', 'Durga Suppliers', '', 'S32301', 'GRN7626204', '', '', '245', '16-05-2024', '', 'Lotrel', 'Amlodipine/Benazepril capsule', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `gst`
--

CREATE TABLE `gst` (
  `id` int(255) NOT NULL,
  `hsn_num` varchar(255) NOT NULL,
  `cgst` varchar(255) NOT NULL,
  `sgst` varchar(255) NOT NULL,
  `igst` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gst`
--

INSERT INTO `gst` (`id`, `hsn_num`, `cgst`, `sgst`, `igst`) VALUES
(26, '891011', '6', '6', '12'),
(27, '9101112', '9', '9', '18'),
(29, '86420', '8', '8', '16'),
(30, '121416', '6', '6', '12'),
(34, '951753', '6', '6', '12'),
(36, '34567', '6', '6', '12'),
(38, '30049099', '9', '9', '18'),
(39, '703206', '10', '10', '20'),
(40, '100100', '9', '9', '18'),
(41, '30597', '8', '8', '16');

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

--
-- Dumping data for table `hospital`
--

INSERT INTO `hospital` (`id`, `name`, `contact`, `email`, `address`) VALUES
(1, 'Lims hoapital', '0425210404', 'nhtaateam@gmail.com', '43 Nicholson St');

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `id` int(14) NOT NULL,
  `em_id` varchar(64) DEFAULT NULL,
  `date` varchar(128) DEFAULT NULL,
  `login` varchar(64) DEFAULT NULL,
  `logout` varchar(64) DEFAULT NULL,
  `counter` varchar(64) DEFAULT NULL,
  `status` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `login_history`
--

INSERT INTO `login_history` (`id`, `em_id`, `date`, `login`, `logout`, `counter`, `status`) VALUES
(1, 'U392', '2024/02/22', '1708581124', '1708581129', 'ADMIN', ''),
(2, 'U392', '2024/02/22', '1708581137', '1708586763', 'ADMIN', ''),
(3, 'U392', '2024/02/22', '1708581491', '1708581495', 'ADMIN', ''),
(4, 'U392', '2024/02/22', '1708581500', '1708581505', 'ADMIN', ''),
(5, 'U392', '2024/02/22', '1708581501', '1708608067', 'ADMIN', ''),
(6, 'U392', '2024/02/22', '1708581517', '0', 'ADMIN', '1'),
(7, 'E384', '2024/02/22', '1708582737', '1708582745', 'SALESMAN', ''),
(8, 'E384', '2024/02/22', '1708582755', '0', 'SALESMAN', '1'),
(9, 'U392', '2024/02/22', '1708582894', '1708587187', 'ADMIN', ''),
(10, 'E451', '2024/02/22', '1708586777', '1708598014', 'SALESMAN', ''),
(11, 'U392', '2024/02/22', '1708586835', '0', 'ADMIN', '1'),
(12, 'E451', '2024/02/22', '1708587210', '1708587865', 'SALESMAN', ''),
(13, 'U392', '2024/02/22', '1708587871', '1708588343', 'ADMIN', ''),
(14, 'E451', '2024/02/22', '1708588351', '1708588435', 'SALESMAN', ''),
(15, 'U392', '2024/02/22', '1708588440', '1708588743', 'ADMIN', ''),
(16, 'E451', '2024/02/22', '1708588776', '1708595156', 'SALESMAN', ''),
(17, 'U392', '2024/02/22', '1708589027', '0', 'ADMIN', '1'),
(18, 'E451', '2024/02/22', '1708595601', '1708598428', 'SALESMAN', ''),
(19, 'U392', '2024/02/22', '1708598020', '0', 'ADMIN', '1'),
(20, 'E451', '2024/02/22', '1708598439', '1708604159', 'SALESMAN', ''),
(21, 'U392', '2024/02/22', '1708604164', '0', 'ADMIN', '1'),
(22, 'U392', '2024/02/22', '1708608076', '0', 'ADMIN', '1'),
(23, 'U392', '2024/02/23', '1708662516', '0', 'ADMIN', '1'),
(24, 'U392', '2024/02/23', '1708662899', '1708674132', 'ADMIN', ''),
(25, 'E451', '2024/02/23', '1708663096', '0', 'SALESMAN', '1'),
(26, 'E451', '2024/02/23', '1708663768', '0', 'SALESMAN', '1'),
(27, 'U392', '2024/02/23', '1708663901', '0', 'ADMIN', '1'),
(28, 'U310', '2024/02/23', '1708674160', '1708674183', 'SALESMAN', ''),
(29, 'U392', '2024/02/23', '1708674190', '0', 'ADMIN', '1'),
(30, 'U310', '2024/02/23', '1708674283', '1708689017', 'SALESMAN', ''),
(31, 'E451', '2024/02/23', '1708682163', '0', 'SALESMAN', '1'),
(32, 'E451', '2024/02/23', '1708682733', '1708687464', 'SALESMAN', ''),
(33, 'U392', '2024/02/23', '1708682876', '0', 'ADMIN', '1'),
(34, 'E384', '2024/02/23', '1708687472', '0', 'SALESMAN', '1'),
(35, 'E451', '2024/02/23', '1708687845', '1708688047', 'SALESMAN', ''),
(36, 'E384', '2024/02/23', '1708688061', '1708692185', 'SALESMAN', ''),
(37, 'U310', '2024/02/23', '1708689027', '1708689235', 'SALESMAN', ''),
(38, 'U310', '2024/02/23', '1708689254', '0', 'SALESMAN', '1'),
(39, 'E451', '2024/02/23', '1708692206', '0', 'SALESMAN', '1'),
(40, 'U392', '2024/02/24', '1708748852', '0', 'ADMIN', '1'),
(41, 'U392', '2024/02/24', '1708751655', '1708761921', 'ADMIN', ''),
(42, 'U392', '2024/02/24', '1708753950', '0', 'ADMIN', '1'),
(43, 'E384', '2024/02/24', '1708755205', '0', 'SALESMAN', '1'),
(44, 'U392', '2024/02/24', '1708761927', '1708767031', 'ADMIN', ''),
(45, 'U392', '2024/02/24', '1708767038', '0', 'ADMIN', '1'),
(46, 'E384', '2024/02/24', '1708776906', '0', 'SALESMAN', '1'),
(47, 'U392', '2024/02/26', '1708921645', '1708953702', 'ADMIN', ''),
(48, 'U392', '2024/02/26', '1708921902', '0', 'ADMIN', '1'),
(49, 'U392', '2024/02/26', '1708922265', '0', 'ADMIN', '1'),
(50, 'E384', '2024/02/26', '1708922273', '0', 'SALESMAN', '1'),
(51, 'E451', '2024/02/26', '1708922376', '1708923813', 'SALESMAN', ''),
(52, 'U310', '2024/02/26', '1708923376', '0', 'SALESMAN', '1'),
(53, 'E384', '2024/02/26', '1708923818', '1708923843', 'SALESMAN', ''),
(54, 'E451', '2024/02/26', '1708923875', '1708923972', 'SALESMAN', ''),
(55, 'E384', '2024/02/26', '1708923988', '0', 'SALESMAN', '1'),
(56, 'U392', '2024/02/26', '1708924115', '0', 'ADMIN', '1'),
(57, 'E475', '2024/02/26', '1708925917', '0', 'SALESMAN', '1'),
(58, 'U392', '2024/02/26', '1708926059', '1708930519', 'ADMIN', ''),
(59, 'E305', '2024/02/26', '1708930521', '1708931499', 'SALESMAN', ''),
(60, 'U392', '2024/02/26', '1708931504', '1708931655', 'ADMIN', ''),
(61, 'E305', '2024/02/26', '1708931659', '1708931681', 'SALESMAN', ''),
(62, 'U392', '2024/02/26', '1708931684', '1708934625', 'ADMIN', ''),
(63, 'E305', '2024/02/26', '1708934635', '1708934718', 'SALESMAN', ''),
(64, 'U392', '2024/02/26', '1708934722', '1708934867', 'ADMIN', ''),
(65, 'E305', '2024/02/26', '1708934871', '1708934894', 'SALESMAN', ''),
(66, 'U392', '2024/02/26', '1708934901', '1708935042', 'ADMIN', ''),
(67, 'E449', '2024/02/26', '1708935050', '1708935060', 'SALESMAN', ''),
(68, 'U392', '2024/02/26', '1708935064', '0', 'ADMIN', '1'),
(69, 'U392', '2024/02/26', '1708953709', '0', 'ADMIN', '1'),
(70, 'U392', '2024/02/27', '1709008017', '0', 'ADMIN', '1'),
(71, 'U392', '2024/02/27', '1709008378', '0', 'ADMIN', '1'),
(72, 'E384', '2024/02/27', '1709009073', '0', 'SALESMAN', '1'),
(73, 'U392', '2024/02/27', '1709009230', '0', 'ADMIN', '1'),
(74, 'U310', '2024/02/27', '1709009272', '0', 'SALESMAN', '1'),
(75, 'U392', '2024/02/27', '1709009426', '0', 'ADMIN', '1'),
(76, 'U310', '2024/02/27', '1709009588', '0', 'SALESMAN', '1'),
(77, 'E451', '2024/02/27', '1709009961', '0', 'SALESMAN', '1'),
(78, 'E451', '2024/02/27', '1709011923', '0', 'SALESMAN', '1'),
(79, 'E384', '2024/02/27', '1709013253', '0', 'SALESMAN', '1'),
(80, 'U392', '2024/02/27', '1709013713', '1709014596', 'ADMIN', ''),
(81, 'U392', '2024/02/27', '1709015525', '1709015534', 'ADMIN', ''),
(82, 'E449', '2024/02/27', '1709015550', '1709015576', 'SALESMAN', ''),
(83, 'U392', '2024/02/27', '1709015580', '0', 'ADMIN', '1'),
(84, 'E451', '2024/02/27', '1709015900', '0', 'SALESMAN', '1'),
(85, 'E451', '2024/02/27', '1709021582', '0', 'SALESMAN', '1'),
(86, 'U310', '2024/02/27', '1709029162', '0', 'SALESMAN', '1'),
(87, 'U392', '2024/02/27', '1709030400', '0', 'ADMIN', '1'),
(88, 'E451', '2024/02/27', '1709038207', '1709039320', 'SALESMAN', ''),
(89, 'E384', '2024/02/27', '1709039115', '0', 'SALESMAN', '1'),
(90, 'E384', '2024/02/27', '1709039331', '0', 'SALESMAN', '1'),
(91, 'U392', '2024/02/28', '1709094174', '0', 'ADMIN', '1'),
(92, 'U392', '2024/02/28', '1709095837', '1709126999', 'ADMIN', ''),
(93, 'U310', '2024/02/28', '1709095881', '1709097999', 'SALESMAN', ''),
(94, 'E384', '2024/02/28', '1709096794', '0', 'SALESMAN', '1'),
(95, 'U392', '2024/02/28', '1709097510', '1709097797', 'ADMIN', ''),
(96, 'E384', '2024/02/28', '1709097724', '0', 'SALESMAN', '1'),
(97, 'E384', '2024/02/28', '1709097817', '1709105079', 'SALESMAN', ''),
(98, 'E384', '2024/02/28', '1709098014', '0', 'SALESMAN', '1'),
(99, 'U392', '2024/02/28', '1709100465', '0', 'ADMIN', '1'),
(100, 'U392', '2024/02/28', '1709100727', '0', 'ADMIN', '1'),
(101, 'E384', '2024/02/28', '1709102418', '0', 'SALESMAN', '1'),
(102, 'U392', '2024/02/28', '1709105088', '0', 'ADMIN', '1'),
(103, 'E384', '2024/02/28', '1709105668', '0', 'SALESMAN', '1'),
(104, 'E384', '2024/02/28', '1709115183', '0', 'SALESMAN', '1'),
(105, 'E384', '2024/02/28', '1709118331', '0', 'SALESMAN', '1'),
(106, 'E384', '2024/02/28', '1709119923', '0', 'SALESMAN', '1'),
(107, 'E384', '2024/02/28', '1709122060', '0', 'SALESMAN', '1'),
(108, 'U392', '2024/02/28', '1709127007', '0', 'ADMIN', '1'),
(109, 'U392', '2024/02/29', '1709180733', '0', 'ADMIN', '1'),
(110, 'U392', '2024/02/29', '1709183032', '0', 'ADMIN', '1'),
(111, 'U310', '2024/02/29', '1709183287', '1709183291', 'SALESMAN', ''),
(112, 'E384', '2024/02/29', '1709183305', '0', 'SALESMAN', '1'),
(113, 'U392', '2024/02/29', '1709183415', '1709183613', 'ADMIN', ''),
(114, 'E384', '2024/02/29', '1709183622', '1709195190', 'SALESMAN', ''),
(115, 'E384', '2024/02/29', '1709183763', '1709192931', 'SALESMAN', ''),
(116, 'U392', '2024/02/29', '1709183847', '0', 'ADMIN', '1'),
(117, 'U392', '2024/02/29', '1709189707', '0', 'ADMIN', '1'),
(118, 'E418', '2024/02/29', '1709192940', '1709192972', 'SALESMAN', ''),
(119, 'E418', '2024/02/29', '1709192981', '0', 'SALESMAN', '1'),
(120, 'U392', '2024/02/29', '1709195204', '0', 'ADMIN', '1'),
(121, 'U392', '2024/02/29', '1709196094', '1709197002', 'ADMIN', ''),
(122, 'U151', '2024/02/29', '1709197010', '1709197046', 'SALESMAN', ''),
(123, 'U392', '2024/02/29', '1709197050', '1709197293', 'ADMIN', ''),
(124, 'U151', '2024/02/29', '1709197297', '1709197312', 'SALESMAN', ''),
(125, 'U392', '2024/02/29', '1709197315', '1709197337', 'ADMIN', ''),
(126, 'U151', '2024/02/29', '1709197341', '1709197403', 'SALESMAN', ''),
(127, 'U392', '2024/02/29', '1709197406', '1709197696', 'ADMIN', ''),
(128, 'U151', '2024/02/29', '1709197698', '1709197772', 'SALESMAN', ''),
(129, 'U392', '2024/02/29', '1709197776', '1709197827', 'ADMIN', ''),
(130, 'U151', '2024/02/29', '1709197830', '1709197933', 'SALESMAN', ''),
(131, 'U392', '2024/02/29', '1709197936', '0', 'ADMIN', '1'),
(132, 'U392', '2024/02/29', '1709203488', '0', 'ADMIN', '1'),
(133, 'E384', '2024/02/29', '1709213257', '0', 'SALESMAN', '1'),
(134, 'U392', '2024/02/29', '1709216641', '0', 'ADMIN', '1'),
(135, 'U392', '2024/03/01', '1709267522', '0', 'ADMIN', '1'),
(136, 'U392', '2024/03/01', '1709268060', '0', 'ADMIN', '1'),
(137, 'U392', '2024/03/01', '1709270815', '0', 'ADMIN', '1'),
(138, 'E451', '2024/03/01', '1709271791', '1709271807', 'SALESMAN', ''),
(139, 'E384', '2024/03/01', '1709271818', '0', 'SALESMAN', '1'),
(140, 'U151', '2024/03/01', '1709274055', '1709280160', 'SALESMAN', ''),
(141, 'U392', '2024/03/01', '1709274287', '0', 'ADMIN', '1'),
(142, 'E384', '2024/03/01', '1709274928', '0', 'SALESMAN', '1'),
(143, 'U392', '2024/03/01', '1709280167', '0', 'ADMIN', '1'),
(144, 'U392', '2024/03/02', '1709354028', '0', 'ADMIN', '1'),
(145, 'U392', '2024/03/02', '1709355157', '1709371842', 'ADMIN', ''),
(146, 'U392', '2024/03/02', '1709355771', '0', 'ADMIN', '1'),
(147, 'E384', '2024/03/02', '1709355895', '0', 'SALESMAN', '1'),
(148, 'U392', '2024/03/02', '1709358842', '1709365056', 'ADMIN', ''),
(149, 'E384', '2024/03/02', '1709362519', '0', 'SALESMAN', '1'),
(150, 'E305', '2024/03/02', '1709365061', '0', 'SALESMAN', '1'),
(151, 'U392', '2024/03/02', '1709371848', '0', 'ADMIN', '1'),
(152, 'U392', '2024/03/02', '1709378153', '1709378368', 'ADMIN', ''),
(153, 'U151', '2024/03/02', '1709378405', '1709378729', 'SALESMAN', ''),
(154, 'U392', '2024/03/02', '1709378733', '1709378941', 'ADMIN', ''),
(155, 'U151', '2024/03/02', '1709378944', '1709378995', 'SALESMAN', ''),
(156, 'U392', '2024/03/02', '1709379000', '1709379067', 'ADMIN', ''),
(157, 'U151', '2024/03/02', '1709379071', '1709380564', 'SALESMAN', ''),
(158, 'U392', '2024/03/02', '1709380214', '0', 'ADMIN', '1'),
(159, 'U392', '2024/03/02', '1709380568', '1709380704', 'ADMIN', ''),
(160, 'U151', '2024/03/02', '1709380707', '1709380717', 'SALESMAN', ''),
(161, 'U458', '2024/03/02', '1709380729', '0', 'SALESMAN', '1'),
(162, 'U392', '2024/03/04', '1709526930', '0', 'ADMIN', '1'),
(163, 'U392', '2024/03/04', '1709528086', '0', 'ADMIN', '1'),
(164, 'U310', '2024/03/04', '1709528831', '0', 'SALESMAN', '1'),
(165, 'U392', '2024/03/04', '1709532020', '1709550866', 'ADMIN', ''),
(166, 'U392', '2024/03/04', '1709532633', '0', 'ADMIN', '1'),
(167, 'U392', '2024/03/04', '1709533060', '1709542564', 'ADMIN', ''),
(168, 'E384', '2024/03/04', '1709533435', '1709546885', 'SALESMAN', ''),
(169, 'U392', '2024/03/04', '1709539372', '0', 'ADMIN', '1'),
(170, 'U458', '2024/03/04', '1709542570', '1709542599', 'SALESMAN', ''),
(171, 'U392', '2024/03/04', '1709542603', '1709542745', 'ADMIN', ''),
(172, 'U458', '2024/03/04', '1709542749', '1709542779', 'SALESMAN', ''),
(173, 'U392', '2024/03/04', '1709542783', '0', 'ADMIN', '1'),
(174, 'U498', '2024/03/04', '1709546952', '1709554305', 'SALESMAN', ''),
(175, 'U392', '2024/03/04', '1709549675', '0', 'ADMIN', '1'),
(176, 'U498', '2024/03/04', '1709550939', '1709551130', 'SALESMAN', ''),
(177, 'U392', '2024/03/04', '1709551366', '1709551537', 'ADMIN', ''),
(178, 'U498', '2024/03/04', '1709551540', '1709551800', 'SALESMAN', ''),
(179, 'U392', '2024/03/04', '1709551802', '1709551947', 'ADMIN', ''),
(180, 'U498', '2024/03/04', '1709551950', '1709551994', 'SALESMAN', ''),
(181, 'U392', '2024/03/04', '1709551998', '1709552912', 'ADMIN', ''),
(182, 'U498', '2024/03/04', '1709552915', '1709553009', 'SALESMAN', ''),
(183, 'U392', '2024/03/04', '1709553015', '1709553308', 'ADMIN', ''),
(184, 'U498', '2024/03/04', '1709553311', '1709553384', 'SALESMAN', ''),
(185, 'U392', '2024/03/04', '1709553418', '1709554166', 'ADMIN', ''),
(186, 'E475', '2024/03/04', '1709553832', '0', 'SALESMAN', '1'),
(187, 'U498', '2024/03/04', '1709554169', '1709554204', 'SALESMAN', ''),
(188, 'U392', '2024/03/04', '1709554207', '1709559356', 'ADMIN', ''),
(189, 'E475', '2024/03/04', '1709554442', '0', 'SALESMAN', '1'),
(190, 'U392', '2024/03/05', '1709612669', '0', 'ADMIN', '1'),
(191, 'U392', '2024/03/05', '1709613540', '1709632175', 'ADMIN', ''),
(192, 'U392', '2024/03/05', '1709613807', '0', 'ADMIN', '1'),
(193, 'U392', '2024/03/05', '1709616500', '1709635221', 'ADMIN', ''),
(194, 'E384', '2024/03/05', '1709617782', '0', 'SALESMAN', '1'),
(195, 'U392', '2024/03/05', '1709618342', '1709642242', 'ADMIN', ''),
(196, 'U392', '2024/03/05', '1709620318', '0', 'ADMIN', '1'),
(197, 'E384', '2024/03/05', '1709622103', '0', 'SALESMAN', '1'),
(198, 'E475', '2024/03/05', '1709622154', '1709632870', 'SALESMAN', ''),
(199, 'E384', '2024/03/05', '1709625651', '0', 'SALESMAN', '1'),
(200, 'U392', '2024/03/05', '1709632189', '0', 'ADMIN', '1'),
(201, 'E384', '2024/03/05', '1709632878', '0', 'SALESMAN', '1'),
(202, 'E384', '2024/03/05', '1709635138', '0', 'SALESMAN', '1'),
(203, 'U498', '2024/03/05', '1709635224', '1709635245', 'SALESMAN', ''),
(204, 'U392', '2024/03/05', '1709635248', '1709635888', 'ADMIN', ''),
(205, 'U498', '2024/03/05', '1709635891', '1709635983', 'SALESMAN', ''),
(206, 'U392', '2024/03/05', '1709635986', '1709641843', 'ADMIN', ''),
(207, 'U392', '2024/03/05', '1709638620', '0', 'ADMIN', '1'),
(208, 'E384', '2024/03/05', '1709640728', '0', 'SALESMAN', '1'),
(209, 'E384', '2024/03/05', '1709641591', '0', 'SALESMAN', '1'),
(210, 'U498', '2024/03/05', '1709641846', '1709642096', 'SALESMAN', ''),
(211, 'E384', '2024/03/05', '1709642085', '0', 'SALESMAN', '1'),
(212, 'U392', '2024/03/05', '1709642099', '1709643097', 'ADMIN', ''),
(213, 'U458', '2024/03/05', '1709642246', '1709642265', 'SALESMAN', ''),
(214, 'U392', '2024/03/05', '1709642268', '1709645374', 'ADMIN', ''),
(215, 'U498', '2024/03/05', '1709643100', '1709643159', 'SALESMAN', ''),
(216, 'U392', '2024/03/05', '1709643169', '1709646260', 'ADMIN', ''),
(217, 'E384', '2024/03/05', '1709643276', '0', 'SALESMAN', '1'),
(218, 'U458', '2024/03/05', '1709645379', '1709645554', 'SALESMAN', ''),
(219, 'U392', '2024/03/05', '1709645558', '1709645606', 'ADMIN', ''),
(220, 'U458', '2024/03/05', '1709645610', '1709645702', 'SALESMAN', ''),
(221, 'U458', '2024/03/05', '1709645704', '1709645709', 'SALESMAN', ''),
(222, 'U392', '2024/03/05', '1709645712', '1709645856', 'ADMIN', ''),
(223, 'U458', '2024/03/05', '1709645859', '0', 'SALESMAN', '1'),
(224, 'U433', '2024/03/05', '1709646271', '1709646313', 'SALESMAN', ''),
(225, 'U392', '2024/03/05', '1709646316', '1709647902', 'ADMIN', ''),
(226, 'U392', '2024/03/06', '1709699725', '0', 'ADMIN', '1'),
(227, 'U392', '2024/03/06', '1709699873', '1709734108', 'ADMIN', ''),
(228, 'E384', '2024/03/06', '1709699926', '0', 'SALESMAN', '1'),
(229, 'E384', '2024/03/06', '1709703924', '0', 'SALESMAN', '1'),
(230, 'U392', '2024/03/06', '1709704025', '0', 'ADMIN', '1'),
(231, 'U392', '2024/03/06', '1709713009', '0', 'ADMIN', '1'),
(232, 'U392', '2024/03/06', '1709717200', '0', 'ADMIN', '1'),
(233, 'E318', '2024/03/06', '1709723004', '1709724297', 'SALESMAN', ''),
(234, 'U392', '2024/03/06', '1709724164', '1709725309', 'ADMIN', ''),
(235, 'E318', '2024/03/06', '1709724310', '0', 'SALESMAN', '1'),
(236, 'E318', '2024/03/06', '1709724376', '0', 'SALESMAN', '1'),
(237, 'E318', '2024/03/06', '1709725031', '0', 'SALESMAN', '1'),
(238, 'U498', '2024/03/06', '1709725314', '1709725465', 'SALESMAN', ''),
(239, 'U392', '2024/03/06', '1709725467', '1709726770', 'ADMIN', ''),
(240, 'E384', '2024/03/06', '1709726480', '0', 'SALESMAN', '1'),
(241, 'U498', '2024/03/06', '1709726773', '1709726832', 'SALESMAN', ''),
(242, 'U392', '2024/03/06', '1709726835', '1709726911', 'ADMIN', ''),
(243, 'U498', '2024/03/06', '1709726914', '1709726950', 'SALESMAN', ''),
(244, 'U392', '2024/03/06', '1709726953', '1709727588', 'ADMIN', ''),
(245, 'E384', '2024/03/06', '1709727548', '0', 'SALESMAN', '1'),
(246, 'U433', '2024/03/06', '1709727592', '1709732343', 'SALESMAN', ''),
(247, 'U392', '2024/03/06', '1709734118', '0', 'ADMIN', '1'),
(248, 'U392', '2024/03/07', '1709786350', '0', 'ADMIN', '1'),
(249, 'U392', '2024/03/07', '1709787376', '0', 'ADMIN', '1'),
(250, 'U392', '2024/03/07', '1709787702', '0', 'ADMIN', '1'),
(251, 'E318', '2024/03/07', '1709789647', '0', 'SALESMAN', '1'),
(252, 'E384', '2024/03/07', '1709790209', '0', 'SALESMAN', '1'),
(253, 'U392', '2024/03/07', '1709791895', '1709793309', 'ADMIN', ''),
(254, 'E384', '2024/03/07', '1709792345', '0', 'SALESMAN', '1'),
(255, 'U392', '2024/03/07', '1709793584', '1709811813', 'ADMIN', ''),
(256, 'U392', '2024/03/07', '1709797768', '1709799107', 'ADMIN', ''),
(257, 'U498', '2024/03/07', '1709799111', '1709799127', 'SALESMAN', ''),
(258, 'U392', '2024/03/07', '1709799132', '1709800837', 'ADMIN', ''),
(259, 'U498', '2024/03/07', '1709800840', '1709800940', 'SALESMAN', ''),
(260, 'U392', '2024/03/07', '1709801031', '0', 'ADMIN', '1'),
(261, 'U392', '2024/03/07', '1709801031', '0', 'ADMIN', '1'),
(262, 'U458', '2024/03/07', '1709811817', '1709811909', 'SALESMAN', ''),
(263, 'U392', '2024/03/07', '1709811913', '1709816581', 'ADMIN', ''),
(264, 'U458', '2024/03/07', '1709816754', '0', 'SALESMAN', '1'),
(265, 'U392', '2024/03/08', '1709872048', '0', 'ADMIN', '1'),
(266, 'U392', '2024/03/08', '1709872870', '0', 'ADMIN', '1'),
(267, 'E318', '2024/03/08', '1709873649', '0', 'SALESMAN', '1'),
(268, 'U392', '2024/03/08', '1709874747', '0', 'ADMIN', '1'),
(269, 'E384', '2024/03/08', '1709876700', '1709877961', 'SALESMAN', ''),
(270, 'E318', '2024/03/08', '1709877977', '0', 'SALESMAN', '1'),
(271, 'U392', '2024/03/08', '1709878558', '0', 'ADMIN', '1'),
(272, 'U458', '2024/03/09', '1709978555', '0', 'SALESMAN', '1'),
(273, 'U392', '2024/03/11', '1710131070', '0', 'ADMIN', '1'),
(274, 'U392', '2024/03/11', '1710132500', '0', 'ADMIN', '1'),
(275, 'U392', '2024/03/11', '1710136186', '0', 'ADMIN', '1'),
(276, 'U392', '2024/03/11', '1710143273', '0', 'ADMIN', '1'),
(277, 'E318', '2024/03/11', '1710149855', '0', 'SALESMAN', '1'),
(278, 'E318', '2024/03/11', '1710149894', '1710150257', 'SALESMAN', ''),
(279, 'E384', '2024/03/11', '1710149961', '0', 'SALESMAN', '1'),
(280, 'E384', '2024/03/11', '1710150268', '1710150279', 'SALESMAN', ''),
(281, 'E318', '2024/03/11', '1710150803', '0', 'SALESMAN', '1'),
(282, 'U392', '2024/03/11', '1710156593', '1710156648', 'ADMIN', ''),
(283, 'U392', '2024/03/11', '1710156596', '1710156857', 'ADMIN', ''),
(284, 'U458', '2024/03/11', '1710156664', '0', 'SALESMAN', '1'),
(285, 'U392', '2024/03/12', '1710217768', '0', 'ADMIN', '1'),
(286, 'U392', '2024/03/12', '1710217972', '0', 'ADMIN', '1'),
(287, 'U392', '2024/03/12', '1710219048', '1710242057', 'ADMIN', ''),
(288, 'U392', '2024/03/12', '1710224534', '0', 'ADMIN', '1'),
(289, 'E318', '2024/03/12', '1710229225', '0', 'SALESMAN', '1'),
(290, 'U392', '2024/03/12', '1710229297', '1710242409', 'ADMIN', ''),
(291, 'U392', '2024/03/12', '1710232639', '0', 'ADMIN', '1'),
(292, 'E318', '2024/03/12', '1710236159', '0', 'SALESMAN', '1'),
(293, 'E451', '2024/03/12', '1710236620', '1710237331', 'SALESMAN', ''),
(294, 'E451', '2024/03/12', '1710237335', '0', 'SALESMAN', '1'),
(295, 'E384', '2024/03/12', '1710237646', '1710238001', 'SALESMAN', ''),
(296, 'E451', '2024/03/12', '1710238008', '1710239934', 'SALESMAN', ''),
(297, 'E384', '2024/03/12', '1710238268', '0', 'SALESMAN', '1'),
(298, 'E384', '2024/03/12', '1710239946', '1710242048', 'SALESMAN', ''),
(299, 'E451', '2024/03/12', '1710242058', '1710243275', 'SALESMAN', ''),
(300, 'E318', '2024/03/12', '1710242071', '1710243468', 'SALESMAN', ''),
(301, 'E475', '2024/03/12', '1710242471', '1710251513', 'SALESMAN', ''),
(302, 'E305', '2024/03/12', '1710243331', '1710243585', 'SALESMAN', ''),
(303, 'E305', '2024/03/12', '1710243483', '1710243601', 'SALESMAN', ''),
(304, 'E318', '2024/03/12', '1710243604', '1710243755', 'SALESMAN', ''),
(305, 'E451', '2024/03/12', '1710243604', '1710243607', 'SALESMAN', ''),
(306, 'E305', '2024/03/12', '1710243622', '1710243684', 'SALESMAN', ''),
(307, 'E451', '2024/03/12', '1710243691', '1710243897', 'SALESMAN', ''),
(308, 'U392', '2024/03/12', '1710243759', '1710243901', 'ADMIN', ''),
(309, 'E305', '2024/03/12', '1710243911', '1710243938', 'SALESMAN', ''),
(310, 'E451', '2024/03/12', '1710243912', '1710243940', 'SALESMAN', ''),
(311, 'E318', '2024/03/12', '1710243946', '1710244398', 'SALESMAN', ''),
(312, 'E305', '2024/03/12', '1710243954', '1710252722', 'SALESMAN', ''),
(313, 'U392', '2024/03/12', '1710244406', '1710244525', 'ADMIN', ''),
(314, 'U392', '2024/03/12', '1710244529', '1710245080', 'ADMIN', ''),
(315, 'E318', '2024/03/12', '1710245086', '1710246109', 'SALESMAN', ''),
(316, 'U392', '2024/03/12', '1710246114', '1710246133', 'ADMIN', ''),
(317, 'E318', '2024/03/12', '1710246140', '1710253169', 'SALESMAN', ''),
(318, 'U392', '2024/03/12', '1710251518', '0', 'ADMIN', '1'),
(319, 'U498', '2024/03/12', '1710252727', '0', 'SALESMAN', '1'),
(320, 'U392', '2024/03/12', '1710253177', '0', 'ADMIN', '1'),
(321, 'U392', '2024/03/13', '1710303989', '0', 'ADMIN', '1'),
(322, 'E384', '2024/03/13', '1710304500', '1710307269', 'SALESMAN', ''),
(323, 'U392', '2024/03/13', '1710304534', '1710309389', 'ADMIN', ''),
(324, 'U392', '2024/03/13', '1710305683', '0', 'ADMIN', '1'),
(325, 'E451', '2024/03/13', '1710307276', '1710309440', 'SALESMAN', ''),
(326, 'E475', '2024/03/13', '1710309446', '1710309895', 'SALESMAN', ''),
(327, 'U392', '2024/03/13', '1710309492', '1710315375', 'ADMIN', ''),
(328, 'U392', '2024/03/13', '1710309650', '1710311588', 'ADMIN', ''),
(329, 'U392', '2024/03/13', '1710309722', '1710311031', 'ADMIN', ''),
(330, 'U151', '2024/03/13', '1710309902', '1710311242', 'SALESMAN', ''),
(331, 'U392', '2024/03/13', '1710311039', '1710311117', 'ADMIN', ''),
(332, 'U392', '2024/03/13', '1710311138', '1710311174', 'ADMIN', ''),
(333, 'U498', '2024/03/13', '1710311187', '1710311214', 'SALESMAN', ''),
(334, 'U498', '2024/03/13', '1710311216', '1710311221', 'SALESMAN', ''),
(335, 'U392', '2024/03/13', '1710311224', '1710313143', 'ADMIN', ''),
(336, 'E451', '2024/03/13', '1710311251', '1710317450', 'SALESMAN', ''),
(337, 'U458', '2024/03/13', '1710311592', '1710311660', 'SALESMAN', ''),
(338, 'U498', '2024/03/13', '1710311665', '1710311818', 'SALESMAN', ''),
(339, 'U392', '2024/03/13', '1710311829', '1710315081', 'ADMIN', ''),
(340, 'U498', '2024/03/13', '1710313146', '1710313197', 'SALESMAN', ''),
(341, 'U392', '2024/03/13', '1710313202', '1710314364', 'ADMIN', ''),
(342, 'U498', '2024/03/13', '1710314367', '1710317357', 'SALESMAN', ''),
(343, 'E384', '2024/03/13', '1710314780', '1710324252', 'SALESMAN', ''),
(344, 'U392', '2024/03/13', '1710315084', '1710315317', 'ADMIN', ''),
(345, 'U458', '2024/03/13', '1710315320', '1710315358', 'SALESMAN', ''),
(346, 'U392', '2024/03/13', '1710315362', '1710321284', 'ADMIN', ''),
(347, 'E451', '2024/03/13', '1710315383', '1710315604', 'SALESMAN', ''),
(348, 'E451', '2024/03/13', '1710315612', '1710315750', 'SALESMAN', ''),
(349, 'E451', '2024/03/13', '1710315759', '0', 'SALESMAN', '1'),
(350, 'U392', '2024/03/13', '1710316276', '0', 'ADMIN', '1'),
(351, 'U392', '2024/03/13', '1710316922', '0', 'ADMIN', '1'),
(352, 'U498', '2024/03/13', '1710317360', '1710320487', 'SALESMAN', ''),
(353, 'U392', '2024/03/13', '1710317459', '0', 'ADMIN', '1'),
(354, 'U392', '2024/03/13', '1710320491', '1710327790', 'ADMIN', ''),
(355, 'U458', '2024/03/13', '1710321288', '1710321351', 'SALESMAN', ''),
(356, 'U392', '2024/03/13', '1710321356', '1710321886', 'ADMIN', ''),
(357, 'U458', '2024/03/13', '1710321890', '1710322067', 'SALESMAN', ''),
(358, 'U392', '2024/03/13', '1710322071', '1710336523', 'ADMIN', ''),
(359, 'E451', '2024/03/13', '1710322758', '1710331263', 'SALESMAN', ''),
(360, 'U392', '2024/03/13', '1710324160', '0', 'ADMIN', '1'),
(361, 'E318', '2024/03/13', '1710324258', '1710330740', 'SALESMAN', ''),
(362, 'U498', '2024/03/13', '1710327793', '1710327807', 'SALESMAN', ''),
(363, 'U392', '2024/03/13', '1710327809', '1710330419', 'ADMIN', ''),
(364, 'U498', '2024/03/13', '1710330423', '1710331717', 'SALESMAN', ''),
(365, 'E384', '2024/03/13', '1710330815', '0', 'SALESMAN', '1'),
(366, 'E451', '2024/03/13', '1710331271', '1710332329', 'SALESMAN', ''),
(367, 'U392', '2024/03/13', '1710331720', '1710336866', 'ADMIN', ''),
(368, 'E451', '2024/03/13', '1710332338', '1710333559', 'SALESMAN', ''),
(369, 'E384', '2024/03/13', '1710333565', '1710334846', 'SALESMAN', ''),
(370, 'E305', '2024/03/13', '1710334857', '0', 'SALESMAN', '1'),
(371, 'U498', '2024/03/13', '1710336529', '1710337474', 'SALESMAN', ''),
(372, 'U392', '2024/03/13', '1710337480', '0', 'ADMIN', '1'),
(373, 'U392', '2024/03/14', '1710390422', '0', 'ADMIN', '1'),
(374, 'E451', '2024/03/14', '1710390810', '1710396091', 'SALESMAN', ''),
(375, 'U392', '2024/03/14', '1710391173', '0', 'ADMIN', '1'),
(376, 'U392', '2024/03/14', '1710391875', '1710399677', 'ADMIN', ''),
(377, 'U392', '2024/03/14', '1710394475', '1710395520', 'ADMIN', ''),
(378, 'U392', '2024/03/14', '1710395249', '1710397127', 'ADMIN', ''),
(379, 'U498', '2024/03/14', '1710395524', '1710411508', 'SALESMAN', ''),
(380, 'E318', '2024/03/14', '1710396068', '1710396284', 'SALESMAN', ''),
(381, 'E451', '2024/03/14', '1710396213', '1710396219', 'SALESMAN', ''),
(382, 'U498', '2024/03/14', '1710396377', '0', 'SALESMAN', '1'),
(383, 'U458', '2024/03/14', '1710397134', '1710397990', 'SALESMAN', ''),
(384, 'U392', '2024/03/14', '1710397994', '1710398335', 'ADMIN', ''),
(385, 'U392', '2024/03/14', '1710398338', '1710398697', 'ADMIN', ''),
(386, 'U392', '2024/03/14', '1710398700', '1710398727', 'ADMIN', ''),
(387, 'U498', '2024/03/14', '1710398731', '1710398738', 'SALESMAN', ''),
(388, 'U392', '2024/03/14', '1710398741', '1710398782', 'ADMIN', ''),
(389, 'U498', '2024/03/14', '1710398786', '1710398879', 'SALESMAN', ''),
(390, 'U392', '2024/03/14', '1710398883', '1710398930', 'ADMIN', ''),
(391, 'U498', '2024/03/14', '1710398936', '1710399228', 'SALESMAN', ''),
(392, 'U392', '2024/03/14', '1710399235', '0', 'ADMIN', '1'),
(393, 'U498', '2024/03/14', '1710399737', '1710411597', 'SALESMAN', ''),
(394, 'U392', '2024/03/14', '1710400240', '0', 'ADMIN', '1'),
(395, 'U392', '2024/03/14', '1710404733', '1710404988', 'ADMIN', ''),
(396, 'U498', '2024/03/14', '1710405010', '0', 'SALESMAN', '1'),
(397, 'U392', '2024/03/14', '1710411512', '1710423511', 'ADMIN', ''),
(398, 'U392', '2024/03/14', '1710411601', '0', 'ADMIN', '1'),
(399, 'U392', '2024/03/15', '1710476693', '0', 'ADMIN', '1'),
(400, 'U392', '2024/03/15', '1710477268', '1710479921', 'ADMIN', ''),
(401, 'U392', '2024/03/15', '1710478491', '0', 'ADMIN', '1'),
(402, 'U392', '2024/03/15', '1710479953', '0', 'ADMIN', '1'),
(403, 'U392', '2024/03/15', '1710480560', '0', 'ADMIN', '1'),
(404, 'U392', '2024/03/15', '1710484557', '0', 'ADMIN', '1'),
(405, 'U392', '2024/03/15', '1710484681', '0', 'ADMIN', '1'),
(406, 'U392', '2024/03/15', '1710489717', '0', 'ADMIN', '1'),
(407, 'E318', '2024/03/15', '1710489848', '0', 'SALESMAN', '1'),
(408, 'U392', '2024/03/15', '1710509940', '0', 'ADMIN', '1'),
(409, 'U392', '2024/03/16', '1710562510', '0', 'ADMIN', '1'),
(410, 'U392', '2024/03/16', '1710563135', '1710601003', 'ADMIN', ''),
(411, 'U392', '2024/03/16', '1710570953', '0', 'ADMIN', '1'),
(412, 'E318', '2024/03/16', '1710574716', '1710574951', 'SALESMAN', ''),
(413, 'E451', '2024/03/16', '1710574964', '1710584439', 'SALESMAN', ''),
(414, 'U392', '2024/03/16', '1710584340', '0', 'ADMIN', '1'),
(415, 'E318', '2024/03/16', '1710584458', '0', 'SALESMAN', '1'),
(416, 'U392', '2024/03/16', '1710601428', '0', 'ADMIN', '1'),
(417, 'U392', '2024/03/16', '1710601446', '0', 'ADMIN', '1'),
(418, 'U392', '2024/03/16', '1710601579', '0', 'ADMIN', '1'),
(419, 'U392', '2024/03/16', '1710601783', '0', 'ADMIN', '1'),
(420, 'U392', '2024/03/16', '1710601908', '0', 'ADMIN', '1'),
(421, 'U392', '2024/03/16', '1710601990', '0', 'ADMIN', '1'),
(422, 'U392', '2024/03/16', '1710602050', '0', 'ADMIN', '1'),
(423, 'U392', '2024/03/16', '1710602123', '0', 'ADMIN', '1'),
(424, 'U392', '2024/03/16', '1710602373', '0', 'ADMIN', '1'),
(425, 'U392', '2024/03/16', '1710602506', '0', 'ADMIN', '1'),
(426, 'U392', '2024/03/17', '1710648159', '0', 'ADMIN', '1'),
(427, 'U392', '2024/03/17', '1710648517', '0', 'ADMIN', '1'),
(428, 'U392', '2024/03/17', '1710648675', '0', 'ADMIN', '1'),
(429, 'U392', '2024/03/17', '1710648888', '0', 'ADMIN', '1'),
(430, 'U392', '2024/03/17', '1710649027', '0', 'ADMIN', '1'),
(431, 'U392', '2024/03/17', '1710649225', '0', 'ADMIN', '1'),
(432, 'U392', '2024/03/17', '1710649349', '0', 'ADMIN', '1'),
(433, 'U392', '2024/03/18', '1710736140', '0', 'ADMIN', '1'),
(434, 'U392', '2024/03/18', '1710738662', '0', 'ADMIN', '1'),
(435, 'U392', '2024/03/18', '1710739037', '0', 'ADMIN', '1'),
(436, 'U392', '2024/03/18', '1710739054', '0', 'ADMIN', '1'),
(437, 'U392', '2024/03/18', '1710739075', '0', 'ADMIN', '1'),
(438, 'U392', '2024/03/18', '1710739330', '0', 'ADMIN', '1'),
(439, 'U392', '2024/03/18', '1710740264', '0', 'ADMIN', '1'),
(440, 'U392', '2024/03/18', '1710740307', '0', 'ADMIN', '1'),
(441, 'U392', '2024/03/18', '1710740424', '0', 'ADMIN', '1'),
(442, 'U392', '2024/03/18', '1710740498', '0', 'ADMIN', '1'),
(443, 'U392', '2024/03/18', '1710740736', '0', 'ADMIN', '1'),
(444, 'U392', '2024/03/18', '1710740840', '0', 'ADMIN', '1'),
(445, 'U392', '2024/03/18', '1710740956', '0', 'ADMIN', '1'),
(446, 'U392', '2024/03/18', '1710741325', '0', 'ADMIN', '1'),
(447, 'U392', '2024/03/18', '1710741541', '0', 'ADMIN', '1'),
(448, 'U392', '2024/03/18', '1710741619', '0', 'ADMIN', '1'),
(449, 'U392', '2024/03/18', '1710742169', '0', 'ADMIN', '1'),
(450, 'U392', '2024/03/18', '1710742215', '0', 'ADMIN', '1'),
(451, 'U392', '2024/03/18', '1710742522', '0', 'ADMIN', '1'),
(452, 'U392', '2024/03/18', '1710742591', '0', 'ADMIN', '1'),
(453, 'U392', '2024/03/18', '1710742755', '0', 'ADMIN', '1'),
(454, 'U392', '2024/03/18', '1710742784', '0', 'ADMIN', '1'),
(455, 'U392', '2024/03/18', '1710742829', '0', 'ADMIN', '1'),
(456, 'U392', '2024/03/18', '1710742881', '0', 'ADMIN', '1'),
(457, 'U392', '2024/03/18', '1710742983', '0', 'ADMIN', '1'),
(458, 'U392', '2024/03/18', '1710743046', '0', 'ADMIN', '1'),
(459, 'U392', '2024/03/18', '1710743089', '0', 'ADMIN', '1'),
(460, 'U392', '2024/03/18', '1710743144', '0', 'ADMIN', '1'),
(461, 'U392', '2024/03/18', '1710743187', '0', 'ADMIN', '1'),
(462, 'U392', '2024/03/18', '1710743459', '0', 'ADMIN', '1'),
(463, 'U392', '2024/03/18', '1710743710', '0', 'ADMIN', '1'),
(464, 'U392', '2024/03/18', '1710743817', '0', 'ADMIN', '1'),
(465, 'U392', '2024/03/18', '1710743938', '0', 'ADMIN', '1'),
(466, 'U392', '2024/03/18', '1710743991', '0', 'ADMIN', '1'),
(467, 'U392', '2024/03/18', '1710744074', '0', 'ADMIN', '1'),
(468, 'U392', '2024/03/18', '1710744210', '0', 'ADMIN', '1'),
(469, 'U392', '2024/03/18', '1710744340', '0', 'ADMIN', '1'),
(470, 'U392', '2024/03/18', '1710744591', '0', 'ADMIN', '1'),
(471, 'U392', '2024/03/18', '1710744783', '0', 'ADMIN', '1'),
(472, 'U392', '2024/03/18', '1710745106', '0', 'ADMIN', '1'),
(473, 'U392', '2024/03/18', '1710745142', '0', 'ADMIN', '1'),
(474, 'U392', '2024/03/18', '1710745212', '0', 'ADMIN', '1'),
(475, 'U392', '2024/03/18', '1710745304', '0', 'ADMIN', '1'),
(476, 'U392', '2024/03/18', '1710745427', '0', 'ADMIN', '1'),
(477, 'U392', '2024/03/18', '1710745468', '0', 'ADMIN', '1'),
(478, 'U392', '2024/03/18', '1710745526', '0', 'ADMIN', '1'),
(479, 'U392', '2024/03/18', '1710745547', '0', 'ADMIN', '1'),
(480, 'U392', '2024/03/18', '1710745603', '0', 'ADMIN', '1'),
(481, 'U392', '2024/03/18', '1710745619', '0', 'ADMIN', '1'),
(482, 'U392', '2024/03/18', '1710745798', '0', 'ADMIN', '1'),
(483, 'U392', '2024/03/18', '1710745875', '0', 'ADMIN', '1'),
(484, 'U392', '2024/03/18', '1710746231', '0', 'ADMIN', '1'),
(485, 'U392', '2024/03/18', '1710746285', '0', 'ADMIN', '1'),
(486, 'U392', '2024/03/18', '1710746418', '0', 'ADMIN', '1'),
(487, 'U392', '2024/03/18', '1710746567', '0', 'ADMIN', '1'),
(488, 'E451', '2024/03/18', '1710747106', '1710747135', 'SALESMAN', ''),
(489, 'E318', '2024/03/18', '1710747142', '0', 'SALESMAN', '1'),
(490, 'U392', '2024/03/18', '1710749832', '0', 'ADMIN', '1'),
(491, 'U392', '2024/03/18', '1710754308', '0', 'ADMIN', '1'),
(492, 'U392', '2024/03/18', '1710754393', '0', 'ADMIN', '1'),
(493, 'U392', '2024/03/18', '1710754905', '0', 'ADMIN', '1'),
(494, 'U392', '2024/03/18', '1710759696', '0', 'ADMIN', '1'),
(495, 'U392', '2024/03/18', '1710759756', '0', 'ADMIN', '1'),
(496, 'U392', '2024/03/18', '1710759902', '0', 'ADMIN', '1'),
(497, 'U392', '2024/03/18', '1710759958', '0', 'ADMIN', '1'),
(498, 'U392', '2024/03/18', '1710760087', '0', 'ADMIN', '1'),
(499, 'U392', '2024/03/18', '1710760558', '0', 'ADMIN', '1'),
(500, 'U392', '2024/03/18', '1710761096', '0', 'ADMIN', '1'),
(501, 'U392', '2024/03/18', '1710761239', '0', 'ADMIN', '1'),
(502, 'U392', '2024/03/18', '1710761721', '0', 'ADMIN', '1'),
(503, 'U392', '2024/03/19', '1710815722', '0', 'ADMIN', '1'),
(504, 'U392', '2024/03/19', '1710815774', '0', 'ADMIN', '1'),
(505, 'U392', '2024/03/19', '1710815888', '0', 'ADMIN', '1'),
(506, 'U392', '2024/03/19', '1710815912', '0', 'ADMIN', '1'),
(507, 'U392', '2024/03/19', '1710816231', '0', 'ADMIN', '1'),
(508, 'U392', '2024/03/19', '1710816600', '0', 'ADMIN', '1'),
(509, 'U392', '2024/03/19', '1710816669', '0', 'ADMIN', '1'),
(510, 'U392', '2024/03/19', '1710816762', '0', 'ADMIN', '1'),
(511, 'U392', '2024/03/19', '1710816967', '0', 'ADMIN', '1'),
(512, 'U392', '2024/03/19', '1710817010', '0', 'ADMIN', '1'),
(513, 'U392', '2024/03/19', '1710817112', '0', 'ADMIN', '1'),
(514, 'U392', '2024/03/19', '1710817269', '0', 'ADMIN', '1'),
(515, 'U392', '2024/03/19', '1710817305', '0', 'ADMIN', '1'),
(516, 'U392', '2024/03/19', '1710822472', '0', 'ADMIN', '1'),
(517, 'U392', '2024/03/19', '1710822499', '0', 'ADMIN', '1'),
(518, 'U392', '2024/03/19', '1710824776', '0', 'ADMIN', '1'),
(519, 'U392', '2024/03/19', '1710831961', '0', 'ADMIN', '1'),
(520, 'U392', '2024/03/19', '1710832074', '0', 'ADMIN', '1'),
(521, 'U392', '2024/03/19', '1710832607', '0', 'ADMIN', '1'),
(522, 'U392', '2024/03/19', '1710832686', '0', 'ADMIN', '1'),
(523, 'U392', '2024/03/19', '1710832884', '0', 'ADMIN', '1'),
(524, 'U392', '2024/03/19', '1710833133', '0', 'ADMIN', '1'),
(525, 'E451', '2024/03/19', '1710835433', '0', 'SALESMAN', '1'),
(526, 'U392', '2024/03/19', '1710835882', '1710843998', 'ADMIN', ''),
(527, 'U392', '2024/03/19', '1710836471', '0', 'ADMIN', '1'),
(528, 'U392', '2024/03/19', '1710836660', '0', 'ADMIN', '1'),
(529, 'U392', '2024/03/19', '1710836943', '0', 'ADMIN', '1'),
(530, 'U392', '2024/03/19', '1710836989', '0', 'ADMIN', '1'),
(531, 'E451', '2024/03/19', '1710840529', '0', 'SALESMAN', '1'),
(532, 'U392', '2024/03/19', '1710840875', '0', 'ADMIN', '1'),
(533, 'U392', '2024/03/19', '1710840914', '0', 'ADMIN', '1'),
(534, 'E318', '2024/03/19', '1710844016', '1710844107', 'SALESMAN', ''),
(535, 'U392', '2024/03/19', '1710844117', '0', 'ADMIN', '1'),
(536, 'U392', '2024/03/19', '1710847173', '0', 'ADMIN', '1'),
(537, 'U392', '2024/03/19', '1710847238', '0', 'ADMIN', '1'),
(538, 'U392', '2024/03/19', '1710847327', '0', 'ADMIN', '1'),
(539, 'U392', '2024/03/19', '1710847395', '0', 'ADMIN', '1'),
(540, 'U392', '2024/03/19', '1710847476', '0', 'ADMIN', '1'),
(541, 'U392', '2024/03/19', '1710847698', '0', 'ADMIN', '1'),
(542, 'U392', '2024/03/19', '1710847872', '0', 'ADMIN', '1'),
(543, 'U392', '2024/03/19', '1710847924', '0', 'ADMIN', '1'),
(544, 'U392', '2024/03/19', '1710848072', '0', 'ADMIN', '1'),
(545, 'U392', '2024/03/19', '1710848146', '0', 'ADMIN', '1'),
(546, 'U392', '2024/03/19', '1710848264', '0', 'ADMIN', '1'),
(547, 'U392', '2024/03/19', '1710848351', '0', 'ADMIN', '1'),
(548, 'U392', '2024/03/19', '1710851442', '0', 'ADMIN', '1'),
(549, 'U392', '2024/03/19', '1710851470', '0', 'ADMIN', '1'),
(550, 'U392', '2024/03/19', '1710851498', '0', 'ADMIN', '1'),
(551, 'U392', '2024/03/19', '1710851577', '0', 'ADMIN', '1'),
(552, 'U392', '2024/03/19', '1710852253', '0', 'ADMIN', '1'),
(553, 'U392', '2024/03/19', '1710852697', '0', 'ADMIN', '1'),
(554, 'U392', '2024/03/19', '1710852846', '0', 'ADMIN', '1'),
(555, 'U392', '2024/03/19', '1710852920', '0', 'ADMIN', '1'),
(556, 'U392', '2024/03/19', '1710852976', '0', 'ADMIN', '1'),
(557, 'U392', '2024/03/19', '1710853111', '0', 'ADMIN', '1'),
(558, 'U392', '2024/03/19', '1710853158', '0', 'ADMIN', '1'),
(559, 'U392', '2024/03/19', '1710853199', '0', 'ADMIN', '1'),
(560, 'U392', '2024/03/20', '1710902627', '0', 'ADMIN', '1'),
(561, 'U392', '2024/03/20', '1710902863', '0', 'ADMIN', '1'),
(562, 'U392', '2024/03/20', '1710902936', '0', 'ADMIN', '1'),
(563, 'U392', '2024/03/20', '1710903130', '0', 'ADMIN', '1'),
(564, 'U392', '2024/03/20', '1710903397', '0', 'ADMIN', '1'),
(565, 'U392', '2024/03/20', '1710903483', '0', 'ADMIN', '1'),
(566, 'U392', '2024/03/20', '1710903523', '0', 'ADMIN', '1'),
(567, 'U392', '2024/03/20', '1710904067', '0', 'ADMIN', '1'),
(568, 'U392', '2024/03/20', '1710904088', '0', 'ADMIN', '1'),
(569, 'U392', '2024/03/20', '1710904220', '0', 'ADMIN', '1'),
(570, 'U392', '2024/03/20', '1710904516', '0', 'ADMIN', '1'),
(571, 'U392', '2024/03/20', '1710904583', '0', 'ADMIN', '1'),
(572, 'U392', '2024/03/20', '1710904643', '0', 'ADMIN', '1'),
(573, 'U392', '2024/03/20', '1710908755', '0', 'ADMIN', '1'),
(574, 'U392', '2024/03/20', '1710910528', '0', 'ADMIN', '1'),
(575, 'U392', '2024/03/20', '1710913744', '1710914894', 'ADMIN', ''),
(576, 'U392', '2024/03/20', '1710914021', '1710915061', 'ADMIN', ''),
(577, 'U498', '2024/03/20', '1710914905', '1710914983', 'SALESMAN', ''),
(578, 'U392', '2024/03/20', '1710914986', '1710915047', 'ADMIN', ''),
(579, 'U498', '2024/03/20', '1710915050', '1710915288', 'SALESMAN', ''),
(580, 'U498', '2024/03/20', '1710915070', '1710915103', 'SALESMAN', ''),
(581, 'U458', '2024/03/20', '1710915107', '1710915192', 'SALESMAN', ''),
(582, 'U392', '2024/03/20', '1710915203', '1710915227', 'ADMIN', ''),
(583, 'U392', '2024/03/20', '1710915207', '0', 'ADMIN', '1'),
(584, 'U458', '2024/03/20', '1710915231', '1710915360', 'SALESMAN', ''),
(585, 'U498', '2024/03/20', '1710915291', '1710915561', 'SALESMAN', ''),
(586, 'U392', '2024/03/20', '1710915345', '1710916021', 'ADMIN', ''),
(587, 'U458', '2024/03/20', '1710915369', '0', 'SALESMAN', '1'),
(588, 'U392', '2024/03/20', '1710915568', '1710923825', 'ADMIN', ''),
(589, 'U392', '2024/03/20', '1710915601', '0', 'ADMIN', '1'),
(590, 'U392', '2024/03/20', '1710915629', '0', 'ADMIN', '1'),
(591, 'U392', '2024/03/20', '1710915686', '0', 'ADMIN', '1'),
(592, 'U392', '2024/03/20', '1710915761', '0', 'ADMIN', '1'),
(593, 'U392', '2024/03/20', '1710915945', '0', 'ADMIN', '1'),
(594, 'U392', '2024/03/20', '1710916295', '0', 'ADMIN', '1'),
(595, 'U392', '2024/03/20', '1710916438', '0', 'ADMIN', '1'),
(596, 'U498', '2024/03/20', '1710916472', '1710920581', 'SALESMAN', ''),
(597, 'U392', '2024/03/20', '1710917090', '0', 'ADMIN', '1'),
(598, 'U392', '2024/03/20', '1710917137', '0', 'ADMIN', '1'),
(599, 'U392', '2024/03/20', '1710917365', '0', 'ADMIN', '1'),
(600, 'E318', '2024/03/20', '1710918299', '0', 'SALESMAN', '1'),
(601, 'U392', '2024/03/20', '1710918881', '0', 'ADMIN', '1'),
(602, 'U392', '2024/03/20', '1710918999', '0', 'ADMIN', '1'),
(603, 'U392', '2024/03/20', '1710919236', '0', 'ADMIN', '1'),
(604, 'U392', '2024/03/20', '1710919285', '0', 'ADMIN', '1'),
(605, 'U392', '2024/03/20', '1710919363', '0', 'ADMIN', '1'),
(606, 'U392', '2024/03/20', '1710919435', '0', 'ADMIN', '1'),
(607, 'U392', '2024/03/20', '1710919494', '0', 'ADMIN', '1'),
(608, 'U392', '2024/03/20', '1710919620', '0', 'ADMIN', '1'),
(609, 'U392', '2024/03/20', '1710919674', '0', 'ADMIN', '1'),
(610, 'U392', '2024/03/20', '1710919707', '0', 'ADMIN', '1'),
(611, 'U392', '2024/03/20', '1710919715', '0', 'ADMIN', '1'),
(612, 'U392', '2024/03/20', '1710920002', '0', 'ADMIN', '1'),
(613, 'U392', '2024/03/20', '1710920110', '0', 'ADMIN', '1'),
(614, 'U310', '2024/03/20', '1710920587', '0', 'SALESMAN', '1'),
(615, 'U310', '2024/03/20', '1710920609', '0', 'SALESMAN', '1'),
(616, 'U392', '2024/03/20', '1710920726', '0', 'ADMIN', '1'),
(617, 'U392', '2024/03/20', '1710921470', '0', 'ADMIN', '1'),
(618, 'U392', '2024/03/20', '1710921613', '0', 'ADMIN', '1'),
(619, 'U392', '2024/03/20', '1710921716', '0', 'ADMIN', '1'),
(620, 'U392', '2024/03/20', '1710921789', '0', 'ADMIN', '1'),
(621, 'U392', '2024/03/20', '1710922224', '0', 'ADMIN', '1'),
(622, 'U498', '2024/03/20', '1710923828', '1710924136', 'SALESMAN', ''),
(623, 'U392', '2024/03/20', '1710924139', '0', 'ADMIN', '1'),
(624, 'U392', '2024/03/20', '1710927806', '0', 'ADMIN', '1'),
(625, 'U310', '2024/03/20', '1710929894', '0', 'SALESMAN', '1'),
(626, 'U310', '2024/03/20', '1710938405', '0', 'SALESMAN', '1'),
(627, 'U392', '2024/03/21', '1710990686', '0', 'ADMIN', '1'),
(628, 'U392', '2024/03/21', '1710995217', '0', 'ADMIN', '1'),
(629, 'U392', '2024/03/21', '1710996016', '1710996367', 'ADMIN', ''),
(630, 'U392', '2024/03/21', '1710996377', '0', 'ADMIN', '1'),
(631, 'U392', '2024/03/21', '1711000227', '0', 'ADMIN', '1'),
(632, 'U310', '2024/03/21', '1711000898', '0', 'SALESMAN', '1'),
(633, 'U392', '2024/03/21', '1711001193', '0', 'ADMIN', '1'),
(634, 'U392', '2024/03/21', '1711002340', '1711007070', 'ADMIN', ''),
(635, 'U392', '2024/03/21', '1711002687', '0', 'ADMIN', '1'),
(636, 'U392', '2024/03/21', '1711003790', '0', 'ADMIN', '1'),
(637, 'U392', '2024/03/21', '1711004917', '0', 'ADMIN', '1'),
(638, 'U310', '2024/03/21', '1711007087', '1711020947', 'SALESMAN', ''),
(639, 'U392', '2024/03/21', '1711007089', '0', 'ADMIN', '1'),
(640, 'E318', '2024/03/21', '1711020956', '0', 'SALESMAN', '1'),
(641, 'U310', '2024/03/21', '1711021971', '0', 'SALESMAN', '1'),
(642, 'U392', '2024/03/22', '1711082094', '0', 'ADMIN', '1'),
(643, 'U392', '2024/03/22', '1711082984', '1711102127', 'ADMIN', ''),
(644, 'U310', '2024/03/22', '1711083013', '0', 'SALESMAN', '1'),
(645, 'U392', '2024/03/22', '1711086521', '1711087305', 'ADMIN', ''),
(646, 'U498', '2024/03/22', '1711087308', '1711087370', 'SALESMAN', ''),
(647, 'U392', '2024/03/22', '1711087373', '1711087453', 'ADMIN', ''),
(648, 'U498', '2024/03/22', '1711087456', '1711087595', 'SALESMAN', ''),
(649, 'U392', '2024/03/22', '1711089160', '1711090902', 'ADMIN', ''),
(650, 'E362', '2024/03/22', '1711090906', '1711090926', 'SALESMAN', ''),
(651, 'U392', '2024/03/22', '1711090929', '1711095831', 'ADMIN', ''),
(652, 'U498', '2024/03/22', '1711095834', '1711095852', 'SALESMAN', ''),
(653, 'U392', '2024/03/22', '1711095855', '0', 'ADMIN', '1'),
(654, 'U392', '2024/03/22', '1711102135', '0', 'ADMIN', '1'),
(655, 'U392', '2024/03/23', '1711167138', '0', 'ADMIN', '1'),
(656, 'U392', '2024/03/23', '1711167188', '0', 'ADMIN', '1'),
(657, 'U392', '2024/03/23', '1711168989', '0', 'ADMIN', '1'),
(658, 'U392', '2024/03/23', '1711192143', '0', 'ADMIN', '1'),
(659, 'U392', '2024/03/24', '1711272903', '0', 'ADMIN', '1'),
(660, 'U392', '2024/03/26', '1711427666', '0', 'ADMIN', '1'),
(661, 'U392', '2024/03/26', '1711430419', '0', 'ADMIN', '1'),
(662, 'U392', '2024/03/26', '1711434564', '0', 'ADMIN', '1'),
(663, 'U392', '2024/03/26', '1711442796', '0', 'ADMIN', '1'),
(664, 'U392', '2024/03/26', '1711450531', '0', 'ADMIN', '1'),
(665, 'U392', '2024/03/27', '1711514000', '0', 'ADMIN', '1'),
(666, 'U392', '2024/03/27', '1711515205', '0', 'ADMIN', '1'),
(667, 'U392', '2024/03/27', '1711521830', '0', 'ADMIN', '1'),
(668, 'U392', '2024/03/27', '1711522518', '1711535130', 'ADMIN', ''),
(669, 'U392', '2024/03/27', '1711523717', '0', 'ADMIN', '1'),
(670, 'U458', '2024/03/27', '1711535139', '1711535241', 'SALESMAN', ''),
(671, 'U392', '2024/03/27', '1711535252', '1711535289', 'ADMIN', ''),
(672, 'U458', '2024/03/27', '1711535293', '1711535309', 'SALESMAN', ''),
(673, 'U392', '2024/03/27', '1711535319', '1711537604', 'ADMIN', ''),
(674, 'U458', '2024/03/27', '1711537613', '1711537862', 'SALESMAN', ''),
(675, 'U392', '2024/03/27', '1711537874', '1711538259', 'ADMIN', ''),
(676, 'U392', '2024/03/27', '1711538276', '1711538317', 'ADMIN', ''),
(677, 'U498', '2024/03/27', '1711538323', '1711538465', 'SALESMAN', ''),
(678, 'U392', '2024/03/27', '1711538475', '0', 'ADMIN', '1'),
(679, 'U392', '2024/03/28', '1711599945', '0', 'ADMIN', '1'),
(680, 'U392', '2024/03/28', '1711601001', '0', 'ADMIN', '1'),
(681, 'U392', '2024/03/28', '1711608216', '0', 'ADMIN', '1'),
(682, 'U392', '2024/03/28', '1711612508', '0', 'ADMIN', '1'),
(683, 'U310', '2024/03/28', '1711627060', '1711627088', 'SALESMAN', ''),
(684, 'U498', '2024/03/28', '1711627105', '0', 'SALESMAN', '1'),
(685, 'U392', '2024/03/28', '1711630110', '1711630672', 'ADMIN', ''),
(686, 'U498', '2024/03/28', '1711630678', '1711630686', 'SALESMAN', ''),
(687, 'U392', '2024/03/28', '1711630690', '1711632475', 'ADMIN', ''),
(688, 'E362', '2024/03/28', '1711632489', '1711632500', 'SALESMAN', ''),
(689, 'U392', '2024/03/28', '1711632551', '0', 'ADMIN', '1'),
(690, 'U392', '2024/03/29', '1711693610', '0', 'ADMIN', '1'),
(691, 'U392', '2024/03/29', '1711693999', '0', 'ADMIN', '1'),
(692, 'U498', '2024/03/29', '1711720936', '0', 'SALESMAN', '1'),
(693, 'U498', '2024/03/29', '1711720942', '0', 'SALESMAN', '1'),
(694, 'U392', '2024/03/30', '1711783683', '0', 'ADMIN', '1'),
(695, 'U392', '2024/04/01', '1711957710', '0', 'ADMIN', '1'),
(696, 'U392', '2024/04/01', '1711971128', '1711977088', 'ADMIN', ''),
(697, 'U392', '2024/04/01', '1711971315', '1711972650', 'ADMIN', ''),
(698, 'U392', '2024/04/01', '1711971982', '0', 'ADMIN', '1'),
(699, 'U458', '2024/04/01', '1711972658', '1711972699', 'SALESMAN', ''),
(700, 'U392', '2024/04/01', '1711972704', '0', 'ADMIN', '1'),
(701, 'U392', '2024/04/02', '1712024293', '0', 'ADMIN', '1'),
(702, 'U392', '2024/04/02', '1712036658', '0', 'ADMIN', '1'),
(703, 'U392', '2024/04/02', '1712036787', '0', 'ADMIN', '1'),
(704, 'U392', '2024/04/02', '1712038659', '0', 'ADMIN', '1'),
(705, 'U392', '2024/04/02', '1712052617', '1712053303', 'ADMIN', ''),
(706, 'U392', '2024/04/02', '1712053634', '0', 'ADMIN', '1'),
(707, 'U392', '2024/04/02', '1712058089', '1712061388', 'ADMIN', ''),
(708, 'U392', '2024/04/02', '1712074958', '0', 'ADMIN', '1'),
(709, 'U392', '2024/04/03', '1712118779', '0', 'ADMIN', '1'),
(710, 'U392', '2024/04/03', '1712118834', '0', 'ADMIN', '1'),
(711, 'U392', '2024/04/03', '1712121388', '0', 'ADMIN', '1'),
(712, 'U392', '2024/04/03', '1712143491', '0', 'ADMIN', '1'),
(713, 'U392', '2024/04/04', '1712205093', '1712219418', 'ADMIN', ''),
(714, 'U392', '2024/04/04', '1712205710', '0', 'ADMIN', '1'),
(715, 'U392', '2024/04/04', '1712219425', '0', 'ADMIN', '1'),
(716, 'U392', '2024/04/04', '1712223321', '0', 'ADMIN', '1'),
(717, 'U392', '2024/04/05', '1712285117', '0', 'ADMIN', '1'),
(718, 'U392', '2024/04/05', '1712291825', '0', 'ADMIN', '1'),
(719, 'U392', '2024/04/05', '1712293401', '0', 'ADMIN', '1'),
(720, 'U392', '2024/04/05', '1712293477', '0', 'ADMIN', '1'),
(721, 'E318', '2024/04/05', '1712304470', '0', 'SALESMAN', '1'),
(722, 'U392', '2024/04/06', '1712410963', '0', 'ADMIN', '1'),
(723, 'U392', '2024/04/06', '1712420696', '0', 'ADMIN', '1'),
(724, 'U392', '2024/04/07', '1712457752', '0', 'ADMIN', '1'),
(725, 'U392', '2024/04/08', '1712550963', '1712555153', 'ADMIN', ''),
(726, 'U392', '2024/04/08', '1712551064', '0', 'ADMIN', '1'),
(727, 'U392', '2024/04/08', '1712555160', '0', 'ADMIN', '1'),
(728, 'U392', '2024/04/08', '1712573034', '1712573255', 'ADMIN', ''),
(729, 'E318', '2024/04/08', '1712573295', '1712582515', 'SALESMAN', ''),
(730, 'E318', '2024/04/08', '1712575450', '0', 'SALESMAN', '1'),
(731, 'U392', '2024/04/08', '1712582520', '0', 'ADMIN', '1'),
(732, 'U392', '2024/04/09', '1712637286', '0', 'ADMIN', '1'),
(733, 'U392', '2024/04/09', '1712637515', '0', 'ADMIN', '1'),
(734, 'U392', '2024/04/09', '1712641008', '0', 'ADMIN', '1'),
(735, 'U392', '2024/04/09', '1712660642', '0', 'ADMIN', '1'),
(736, 'U392', '2024/04/10', '1712723962', '0', 'ADMIN', '1'),
(737, 'U392', '2024/04/10', '1712724481', '0', 'ADMIN', '1'),
(738, 'U392', '2024/04/10', '1712738707', '0', 'ADMIN', '1'),
(739, 'U392', '2024/04/10', '1712738751', '0', 'ADMIN', '1'),
(740, 'U392', '2024/04/10', '1712740220', '0', 'ADMIN', '1'),
(741, 'U392', '2024/04/10', '1712744051', '0', 'ADMIN', '1'),
(742, 'U392', '2024/04/10', '1712749010', '0', 'ADMIN', '1'),
(743, 'E318', '2024/04/10', '1712749988', '0', 'SALESMAN', '1'),
(744, 'U392', '2024/04/10', '1712751164', '0', 'ADMIN', '1'),
(745, 'U392', '2024/04/11', '1712809298', '0', 'ADMIN', '1'),
(746, 'U392', '2024/04/12', '1712896174', '0', 'ADMIN', '1'),
(747, 'U392', '2024/04/12', '1712905193', '0', 'ADMIN', '1'),
(748, 'U392', '2024/04/12', '1712924463', '0', 'ADMIN', '1'),
(749, 'U392', '2024/04/13', '1712985532', '0', 'ADMIN', '1'),
(750, 'U392', '2024/04/13', '1713001902', '0', 'ADMIN', '1'),
(751, 'U392', '2024/04/13', '1713005868', '1713007101', 'ADMIN', ''),
(752, 'U392', '2024/04/13', '1713006266', '0', 'ADMIN', '1'),
(753, 'U458', '2024/04/13', '1713007106', '1713007119', 'SALESMAN', ''),
(754, 'U498', '2024/04/13', '1713007123', '1713007137', 'SALESMAN', ''),
(755, 'U433', '2024/04/13', '1713007166', '1713007185', 'SALESMAN', ''),
(756, 'U392', '2024/04/13', '1713007189', '0', 'ADMIN', '1'),
(757, 'U392', '2024/04/15', '1713160472', '1713164845', 'ADMIN', ''),
(758, 'U392', '2024/04/15', '1713160572', '1713168238', 'ADMIN', ''),
(759, 'U433', '2024/04/15', '1713164855', '1713164866', 'SALESMAN', ''),
(760, 'U458', '2024/04/15', '1713164870', '1713164880', 'SALESMAN', ''),
(761, 'U498', '2024/04/15', '1713164884', '1713164936', 'SALESMAN', ''),
(762, 'U392', '2024/04/15', '1713164940', '1713164975', 'ADMIN', ''),
(763, 'U498', '2024/04/15', '1713164979', '1713164994', 'SALESMAN', ''),
(764, 'U392', '2024/04/15', '1713164998', '0', 'ADMIN', '1'),
(765, 'U392', '2024/04/15', '1713168247', '0', 'ADMIN', '1'),
(766, 'U392', '2024/04/16', '1713242136', '1713247510', 'ADMIN', ''),
(767, 'U392', '2024/04/16', '1713242617', '0', 'ADMIN', '1'),
(768, 'U392', '2024/04/16', '1713246783', '0', 'ADMIN', '1'),
(769, 'U392', '2024/04/16', '1713247517', '1713250163', 'ADMIN', ''),
(770, 'U310', '2024/04/16', '1713250183', '1713250307', 'SALESMAN', ''),
(771, 'U498', '2024/04/16', '1713250319', '0', 'SALESMAN', '1'),
(772, 'U392', '2024/04/16', '1713264244', '0', 'ADMIN', '1'),
(773, 'U392', '2024/04/17', '1713328472', '0', 'ADMIN', '1'),
(774, 'U392', '2024/04/17', '1713333466', '0', 'ADMIN', '1'),
(775, 'U392', '2024/04/18', '1713431266', '0', 'ADMIN', '1'),
(776, 'U392', '2024/04/19', '1713508096', '0', 'ADMIN', '1'),
(777, 'U392', '2024/04/19', '1713508462', '0', 'ADMIN', '1'),
(778, 'U392', '2024/04/19', '1713519374', '0', 'ADMIN', '1'),
(779, 'U392', '2024/04/19', '1713523334', '0', 'ADMIN', '1'),
(780, 'U392', '2024/04/20', '1713595744', '0', 'ADMIN', '1'),
(781, 'U392', '2024/04/22', '1713761182', '0', 'ADMIN', '1');
INSERT INTO `login_history` (`id`, `em_id`, `date`, `login`, `logout`, `counter`, `status`) VALUES
(782, 'U392', '2024/04/23', '1713856031', '0', 'ADMIN', '1'),
(783, 'U392', '2024/04/23', '1713859117', '0', 'ADMIN', '1'),
(784, 'U392', '2024/04/25', '1714037151', '1714037669', 'ADMIN', ''),
(785, 'U498', '2024/04/25', '1714037697', '1714037744', 'SALESMAN', ''),
(786, 'U392', '2024/04/26', '1714138613', '0', 'ADMIN', '1'),
(787, 'U392', '2024/04/27', '1714196830', '0', 'ADMIN', '1'),
(788, 'U392', '2024/04/27', '1714221415', '0', 'ADMIN', '1'),
(789, 'U392', '2024/04/29', '1714365935', '0', 'ADMIN', '1'),
(790, 'U392', '2024/04/29', '1714372454', '1714384592', 'ADMIN', ''),
(791, 'U392', '2024/04/29', '1714374234', '1714393173', 'ADMIN', ''),
(792, 'U392', '2024/04/29', '1714384599', '0', 'ADMIN', '1'),
(793, 'U392', '2024/04/30', '1714451917', '0', 'ADMIN', '1'),
(794, 'U392', '2024/04/30', '1714455006', '0', 'ADMIN', '1'),
(795, 'U392', '2024/04/30', '1714457919', '0', 'ADMIN', '1'),
(796, 'U392', '2024/04/30', '1714458809', '1714471107', 'ADMIN', ''),
(797, 'U392', '2024/04/30', '1714475052', '0', 'ADMIN', '1'),
(798, 'U392', '2024/05/01', '1714541933', '0', 'ADMIN', '1'),
(799, 'U392', '2024/05/02', '1714623387', '0', 'ADMIN', '1'),
(800, 'U392', '2024/05/02', '1714646075', '0', 'ADMIN', '1'),
(801, 'U392', '2024/05/02', '1714651106', '0', 'ADMIN', '1'),
(802, 'U392', '2024/05/03', '1714708540', '0', 'ADMIN', '1'),
(803, 'U392', '2024/05/03', '1714713423', '0', 'ADMIN', '1'),
(804, 'U498', '2024/05/03', '1714721373', '0', 'SALESMAN', '1'),
(805, 'U392', '2024/05/03', '1714734150', '1714734957', 'ADMIN', ''),
(806, 'U392', '2024/05/03', '1714734787', '1714735196', 'ADMIN', ''),
(807, 'U498', '2024/05/03', '1714734962', '1714735098', 'SALESMAN', ''),
(808, 'U392', '2024/05/03', '1714735105', '1714735661', 'ADMIN', ''),
(809, 'U498', '2024/05/03', '1714735224', '1714735684', 'SALESMAN', ''),
(810, 'U498', '2024/05/03', '1714735665', '1714738168', 'SALESMAN', ''),
(811, 'U392', '2024/05/03', '1714735686', '0', 'ADMIN', '1'),
(812, 'U392', '2024/05/03', '1714736483', '0', 'ADMIN', '1'),
(813, 'U498', '2024/05/03', '1714737711', '1714737892', 'SALESMAN', ''),
(814, 'U498', '2024/05/03', '1714737920', '1714737924', 'SALESMAN', ''),
(815, 'U392', '2024/05/03', '1714738177', '1714738342', 'ADMIN', ''),
(816, 'U392', '2024/05/03', '1714738346', '1714739048', 'ADMIN', ''),
(817, 'U392', '2024/05/04', '1714801421', '1714806224', 'ADMIN', ''),
(818, 'U498', '2024/05/04', '1714806233', '1714806250', 'SALESMAN', ''),
(819, 'U392', '2024/05/04', '1714806262', '1714806337', 'ADMIN', ''),
(820, 'U498', '2024/05/04', '1714806346', '1714806361', 'SALESMAN', ''),
(821, 'U392', '2024/05/04', '1714806366', '0', 'ADMIN', '1'),
(822, 'U392', '2024/05/06', '1714970305', '1714990946', 'ADMIN', ''),
(823, 'U392', '2024/05/06', '1714970649', '0', 'ADMIN', '1'),
(824, 'U392', '2024/05/06', '1714972199', '0', 'ADMIN', '1'),
(825, 'E218', '2024/05/06', '1714973837', '1714981682', 'SALESMAN', ''),
(826, 'U392', '2024/05/06', '1714976204', '0', 'ADMIN', '1'),
(827, 'U392', '2024/05/06', '1714976418', '0', 'ADMIN', '1'),
(828, 'E418', '2024/05/06', '1714977905', '1714981792', 'SALESMAN', ''),
(829, 'E218', '2024/05/06', '1714981697', '1714983526', 'SALESMAN', ''),
(830, 'E218', '2024/05/06', '1714981808', '0', 'SALESMAN', '1'),
(831, 'E218', '2024/05/06', '1714983536', '0', 'SALESMAN', '1'),
(832, 'U392', '2024/05/06', '1714987489', '0', 'ADMIN', '1'),
(833, 'E418', '2024/05/06', '1714990956', '1714991064', 'SALESMAN', ''),
(834, 'E218', '2024/05/06', '1714991075', '1714991322', 'SALESMAN', ''),
(835, 'U392', '2024/05/06', '1714991328', '0', 'ADMIN', '1'),
(836, 'U392', '2024/05/07', '1715056322', '0', 'ADMIN', '1'),
(837, 'E218', '2024/05/07', '1715056345', '0', 'SALESMAN', '1'),
(838, 'U392', '2024/05/07', '1715056491', '1715060514', 'ADMIN', ''),
(839, 'U392', '2024/05/07', '1715057350', '0', 'ADMIN', '1'),
(840, 'U392', '2024/05/07', '1715058904', '0', 'ADMIN', '1'),
(841, 'U392', '2024/05/07', '1715060520', '1715077605', 'ADMIN', ''),
(842, 'U392', '2024/05/07', '1715064175', '1715073136', 'ADMIN', ''),
(843, 'U392', '2024/05/07', '1715065065', '1715081147', 'ADMIN', ''),
(844, 'U498', '2024/05/07', '1715073140', '1715073164', 'SALESMAN', ''),
(845, 'U392', '2024/05/07', '1715073167', '1715075693', 'ADMIN', ''),
(846, 'U498', '2024/05/07', '1715075701', '1715076845', 'SALESMAN', ''),
(847, 'U392', '2024/05/07', '1715076849', '1715076922', 'ADMIN', ''),
(848, 'U498', '2024/05/07', '1715076926', '1715076955', 'SALESMAN', ''),
(849, 'U392', '2024/05/07', '1715076958', '1715076991', 'ADMIN', ''),
(850, 'U498', '2024/05/07', '1715076994', '1715077076', 'SALESMAN', ''),
(851, 'U392', '2024/05/07', '1715077079', '0', 'ADMIN', '1'),
(852, 'U392', '2024/05/07', '1715077618', '0', 'ADMIN', '1'),
(853, 'U392', '2024/05/07', '1715081195', '1715081205', 'ADMIN', ''),
(854, 'U498', '2024/05/07', '1715081241', '1715083056', 'SALESMAN', ''),
(855, 'U392', '2024/05/07', '1715083062', '0', 'ADMIN', '1'),
(856, 'U392', '2024/05/07', '1715086914', '0', 'ADMIN', '1'),
(857, 'U392', '2024/05/08', '1715142540', '0', 'ADMIN', '1'),
(858, 'U392', '2024/05/08', '1715148399', '0', 'ADMIN', '1'),
(859, 'U392', '2024/05/08', '1715153346', '0', 'ADMIN', '1'),
(860, 'U392', '2024/05/09', '1715229665', '0', 'ADMIN', '1'),
(861, 'U392', '2024/05/09', '1715233966', '0', 'ADMIN', '1'),
(862, 'U392', '2024/05/09', '1715236829', '1715236848', 'ADMIN', ''),
(863, 'U458', '2024/05/09', '1715236852', '1715236997', 'SALESMAN', ''),
(864, 'U433', '2024/05/09', '1715237007', '1715237025', 'SALESMAN', ''),
(865, 'U498', '2024/05/09', '1715237034', '1715237042', 'SALESMAN', ''),
(866, 'U392', '2024/05/09', '1715237047', '0', 'ADMIN', '1'),
(867, 'U392', '2024/05/09', '1715255774', '0', 'ADMIN', '1'),
(868, 'U392', '2024/05/11', '1715403818', '0', 'ADMIN', '1'),
(869, 'U392', '2024/05/13', '1715574446', '0', 'ADMIN', '1'),
(870, 'U392', '2024/05/13', '1715575375', '0', 'ADMIN', '1'),
(871, 'U392', '2024/05/16', '1715834020', '0', 'ADMIN', '1'),
(872, 'U392', '2024/05/16', '1715837634', '0', 'ADMIN', '1'),
(873, 'U392', '2024/05/16', '1715839891', '0', 'ADMIN', '1');

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

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`id`, `manufac_id`, `m_name`, `note`) VALUES
(3, 'M46813', 'Sun Pharmaceutical Industries Ltd', 'Sun Pharmaceutical Industries Limited'),
(4, 'M10429', 'Zydus Lifesciences Ltd', 'Zydus Lifesciences Limited'),
(6, 'M27070', 'Emcure Pharma Ltd', 'Emcure Pharma Limited'),
(7, 'M29019', 'Micro Labs Ltd', 'Micro Labs Limited'),
(13, 'M32306', 'Natco Pharma Ltd', 'Hyderabad'),
(17, 'M15558', 'Reddy Labs', 'RC puram'),
(19, 'M10305', 'Ritesh Medical Industry', 'Delhi'),
(20, 'M14240', 'Arduion', 'Hyderbad'),
(21, 'M10789', 'Cipla', 'Cipla'),
(22, 'M34677', 'Aurbindo Labs', 'Hyderbad'),
(23, 'M23242', 'Infinite Labs', 'Hyderbad'),
(24, 'M10815', 'Realred', 'Hyderabad'),
(25, 'M21942', 'MahaManu', 'Hyderabad'),
(26, 'M11188', 'Alkem Laboratories Ltd', 'Pharmaceuticals and Healthcare'),
(27, 'M1017', 'classmate', 'Tab-book'),
(28, 'M32720', 'U.S PHARMA', 'PLOT NO-171, POCKET K. SECTPR-3 BAWANA DSIDC'),
(29, 'M38470', 'Ramya Pharmaceuticals', 'Hyderabad');

-- --------------------------------------------------------

--
-- Table structure for table `medication`
--

CREATE TABLE `medication` (
  `id` int(255) NOT NULL,
  `patient_id` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `referred_doctor` varchar(255) NOT NULL,
  `time` text NOT NULL,
  `prescription_date` date NOT NULL,
  `duration` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `branch` int(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
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
  `mrp` int(255) NOT NULL,
  `strength` varchar(64) DEFAULT NULL,
  `form` varchar(64) DEFAULT NULL,
  `subform` varchar(255) NOT NULL,
  `box_size` varchar(64) DEFAULT NULL,
  `unit_price` varchar(255) NOT NULL,
  `instock` int(128) DEFAULT 0,
  `short_stock` int(128) DEFAULT NULL,
  `storeshort_stock` int(255) NOT NULL,
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
  `min_orderqty` int(100) NOT NULL,
  `max_orderqty` int(100) NOT NULL,
  `reorder_qty` int(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`id`, `manufacturer_id`, `product_id`, `product_name`, `generic_name`, `Batch_Number123`, `manf_date`, `exp_date`, `quan_approve`, `purchase_rate`, `sale_rate`, `mrp`, `strength`, `form`, `subform`, `box_size`, `unit_price`, `instock`, `short_stock`, `storeshort_stock`, `side_effect`, `box_price`, `expire_date123`, `favourite`, `date`, `discount`, `hsn`, `cgst`, `sgst`, `Igst`, `product_image`, `sale_qty`, `stripe`, `unit`, `purchase`, `min_orderqty`, `max_orderqty`, `reorder_qty`, `status`) VALUES
(1, 'M32720', 'P44417', 'Amoxicillin ', 'Amoxicillin', NULL, '', '', '', '', '', 0, '500mg', '1', '1,2', NULL, '', 3436, 50, 25, 'Dizziness', NULL, NULL, '0', '1717545600', 'YES', '30597', '', '', '', 'amox.jpg', '84', '', '', '', 100, 200, 100, 0),
(2, 'M32720', 'P22083', 'Allegra', 'fexofenadine', NULL, '', '', '', '', '', 0, '180mg', '1', '1,2', NULL, '', 2142, 50, 25, 'No sideeffect', NULL, NULL, '0', '1717545600', 'YES', '30597', '', '', '', 'allerga.jpg', '80', '', '', '', 100, 200, 100, 0),
(3, 'M10789', 'P22739', 'cetirizine HCl tablet - OTC', 'Zyrtec OTC', NULL, '', '', '', '', '', 0, '10 mg', '2', '0', NULL, '', 0, 10, 5, '', NULL, NULL, '0', '1717545600', 'YES', '891011', '', '', '', '', '0', '', '', '', 20, 50, 10, 0),
(4, 'M29019', 'P8717', 'calpol', 'meds', NULL, '', '', '', '', '', 0, '500mg', '1', '1,2', NULL, '', 500, 50, 25, 'no side effects', NULL, NULL, '0', '1720137600', 'YES', '30597', '', '', '', '', '0', '', '', '', 100, 200, 100, 0),
(5, 'M38470', 'P48407', 'Xanax', 'alprazolam', NULL, '', '', '', '', '', 0, '10mg', '1', '1,2,3', NULL, '', 25, 20, 15, 'No side effects', NULL, NULL, '0', '1720137600', 'YES', '30597', '', '', '', '', '30', '', '', '', 100, 200, 150, 0),
(6, 'M46813', 'P25106', 'Lotrel', 'Amlodipine/Benazepril capsule', NULL, '', '', '', '', '', 0, '10', '1', '1,2,3,4', NULL, '', 30, 10, 20, 'no side effects', NULL, NULL, '0', '0', 'YES', '30597', '', '', '', '', '0', '', '', '', 50, 100, 50, 0);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_mata`
--

CREATE TABLE `medicine_mata` (
  `id` int(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `supplier_id` varchar(256) NOT NULL,
  `Batch_Number` varchar(255) NOT NULL,
  `manf_date` varchar(255) NOT NULL,
  `expire_date` varchar(255) NOT NULL,
  `purchase_rate` int(255) NOT NULL,
  `mrp` varchar(255) NOT NULL,
  `instock` int(255) NOT NULL,
  `sale_qty` int(11) NOT NULL,
  `discount` int(255) NOT NULL DEFAULT 0,
  `createdat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tax` int(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicine_mata`
--

INSERT INTO `medicine_mata` (`id`, `product_id`, `supplier_id`, `Batch_Number`, `manf_date`, `expire_date`, `purchase_rate`, `mrp`, `instock`, `sale_qty`, `discount`, `createdat`, `tax`, `status`) VALUES
(1, 'P22083', 'S8690', 'ALL 001', '', '2026-06-25', 40, '8', 3300, 0, 0, '2024-05-07 04:36:35', 0, 0),
(2, 'P44417', 'S8690', 'AMO 001', '', '2027-07-30', 60, '12', 4400, 0, 0, '2024-05-07 04:36:35', 0, 0),
(3, 'P22083', 'S54301', 'ALL 002', '', '2027-09-15', 50, '10', 2920, 80, 0, '2024-05-07 06:39:58', 0, 1),
(4, 'P44417', 'S54301', 'AMO 002', '', '2028-06-07', 100, '20', 3916, 84, 0, '2024-05-15 10:44:21', 0, 1),
(5, 'P22083', 'S33535', '464645', '', '2024-05-08', 67, '67', 200, 0, 0, '2024-05-07 04:49:53', 0, 0),
(6, 'P44417', 'S43130', '24', '', '2024-05-14', 60, '7.8', 3100, 0, 0, '2024-05-07 06:25:30', 0, 1),
(7, 'P22083', 'S43130', '465', '', '2024-05-15', 45, '5.6', 30, 0, 0, '2024-05-07 06:25:30', 0, 1),
(8, 'P22083', 'S54301', 'ALLE0098', '', '2027-11-25', 10, '1.5', 1100, 0, 0, '2024-05-07 06:19:18', 0, 0),
(9, 'P22083', 'S42177', 'we234', '', '2024-05-07', 1, '0.1', 10, 0, 0, '2024-05-07 06:28:43', 0, 0),
(10, 'P22083', 'S42177', 'All 003', '', '2026-08-07', 50, '10', 800, 0, 0, '2024-05-07 07:25:37', 0, 1),
(11, 'P8717', 'S54301', 'Cal 00', '', '2026-07-07', 20, '4', 5000, 0, 0, '2024-05-07 07:43:58', 0, 1),
(12, 'P48407', 'S43280', 'XA001', '', '2026-10-06', 50, '12', 625, 30, 0, '2024-05-07 12:05:07', 0, 1),
(13, 'P44417', 'S3787', '4545', '', '2024-05-15', 23, '3.4', 120, 0, 0, '2024-05-08 12:15:53', 0, 0),
(14, 'P22083', 'S54301', '656', '', '2024-05-29', 50, '7.8', 1000, 0, 0, '2024-05-08 12:22:29', 0, 0),
(15, 'P25106', 'S32301', '25424', '', '2026-03-01', 100, '12', 300, 0, 0, '2024-05-16 06:26:34', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `meta_grn`
--

CREATE TABLE `meta_grn` (
  `idd` int(255) NOT NULL,
  `grn_no` varchar(255) NOT NULL,
  `product_id` varchar(256) NOT NULL,
  `Batch_Number` varchar(255) NOT NULL,
  `instock` varchar(256) NOT NULL,
  `expire_date` varchar(255) NOT NULL,
  `Sch_no` varchar(255) NOT NULL,
  `Sch_date` varchar(255) NOT NULL,
  `rec_qty` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `unit_mrp` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`idd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meta_grn`
--

INSERT INTO `meta_grn` (`idd`, `grn_no`, `product_id`, `Batch_Number`, `instock`, `expire_date`, `Sch_no`, `Sch_date`, `rec_qty`, `price`, `unit_mrp`, `createdAt`) VALUES
(1, 'GRN2930514', 'P22083', 'ALL 002', '3000', '15-09-2027', 'sc99', '2024-05-07', '2000', 50, '10', '2024-05-07'),
(2, 'GRN2930514', 'P44417', 'AMO 002', '4000', '07-06-2028', 'sc99', '2024-05-07', '3000', 100, '20', '2024-05-07'),
(3, 'GRN4963636', 'P44417', '24', '1900', '14-05-2024', 'fsfsd4354', '2024-05-15', '100', 60, '7.8', '2024-05-07'),
(4, 'GRN4963636', 'P22083', '465', '18', '15-05-2024', '2433', '2024-05-14', '10', 45, '5.6', '2024-05-07'),
(5, 'GRN7221026', 'P22083', 'All 003', '1000', '07-08-2026', 'sc00', '2024-05-08', '1000', 50, '10', '2024-05-07'),
(6, 'GRN5035815', 'P8717', 'Cal 00', '5000', '07-07-2026', 'SCH123', '2024-05-07', '4000', 20, '4', '2024-05-07'),
(7, 'GRN1650384', 'P48407', 'XA001', '750', '06-10-2026', '', '', '750', 50, '12', '2024-05-07'),
(8, 'GRN7626204', 'P25106', '25424', '300', '01-03-2026', '', '', '300', 100, '12', '2024-05-16');

-- --------------------------------------------------------

--
-- Table structure for table `police`
--

CREATE TABLE `police` (
  `id` int(14) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `contact` varchar(256) DEFAULT NULL,
  `address` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `police`
--

INSERT INTO `police` (`id`, `name`, `email`, `contact`, `address`) VALUES
(1, 'Alagesh', 'Algaseh@gmail.com', '9701456220', 'Hyderbad');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id` int(14) NOT NULL,
  `p_id` varchar(64) DEFAULT NULL,
  `invoice_no` varchar(64) DEFAULT NULL,
  `sid` varchar(64) DEFAULT NULL,
  `pur_details` varchar(64) DEFAULT NULL,
  `store_id` varchar(255) NOT NULL,
  `pur_date` varchar(64) DEFAULT NULL,
  `total_discount` varchar(64) DEFAULT NULL,
  `tax` varchar(255) NOT NULL,
  `delivery_time` int(100) NOT NULL,
  `payment_time` int(100) NOT NULL,
  `gtotal_amount` varchar(64) DEFAULT NULL,
  `entry_date` varchar(64) DEFAULT NULL,
  `entry_id` varchar(128) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id`, `p_id`, `sid`, `store_id`, `invoice_no`, `pur_date`, `pur_details`, `total_discount`, `tax`, `delivery_time`, `payment_time`, `gtotal_amount`, `entry_date`, `entry_id`, `created_at`) VALUES
(1, 'P3417856', 'S8690', '', '998800', '07-05-2024', 'Meds Purchase from S.R Pharma', NULL, '5760', 10, 20, '41700', '07/05/2024', 'U392', '2024-05-07 04:36:03'),
(2, 'P8991577', 'S8690', '', '908070', '07-05-2024', 'Meds Purchase from S.R Pharma', NULL, '5760', 10, 20, '41700', '07/05/2024', 'U392', '2024-05-07 04:36:35'),
(3, 'P1897674', 'S54301', '', '523242', '07-05-2024', 'Meds Purchase From Derma pharmacy', NULL, '8800', 0, 0, '63800', '07/05/2024', 'U392', '2024-05-07 04:40:13'),
(4, 'P3327220', 'S33535', '', '666687', '07-05-2024', 'note', NULL, '1072', 1, 1, '7772', '07/05/2024', 'U392', '2024-05-07 04:48:15'),
(5, 'P9318953', 'S33535', '', '66668756', '07-05-2024', 'note', NULL, '1072', 1, 1, '7772', '07/05/2024', 'U392', '2024-05-07 04:49:53'),
(6, 'P2478648', 'S43130', '', '3232', '07-05-2024', '2', NULL, '960', 2, 2, '6960', '07/05/2024', 'U392', '2024-05-07 04:55:12'),
(7, 'P967872', 'S43130', '', '32324', '07-05-2024', '2', NULL, '1927', 2, 2, '7860', '07/05/2024', 'U392', '2024-05-07 04:56:03'),
(8, 'P9784772', 'S43130', '', '3232445', '07-05-2024', '2', NULL, '1927', 2, 2, '7860', '07/05/2024', 'U392', '2024-05-07 04:57:17'),
(9, 'P8301064', 'S43130', '', '32', '07-05-2024', '2', NULL, '1927', 2, 2, '7860', '07/05/2024', 'U392', '2024-05-07 05:21:08'),
(10, 'P6182437', 'S43130', '', '327', '07-05-2024', '2', NULL, '1927', 2, 2, '7860', '07/05/2024', 'U392', '2024-05-07 05:21:42'),
(11, 'P978192', 'S43130', '', '32756', '07-05-2024', '2', NULL, '1927', 2, 2, '7860', '07/05/2024', 'U392', '2024-05-07 05:22:22'),
(12, 'P1374242', 'S43130', '', '3275666', '07-05-2024', '2', NULL, '1927', 2, 2, '7860', '07/05/2024', 'U392', '2024-05-07 05:33:39'),
(13, 'P5655422', 'S43130', '', '37', '07-05-2024', '2', NULL, '1927', 2, 2, '7860', '07/05/2024', 'U392', '2024-05-07 05:38:33'),
(14, 'P6190768', 'S43130', '', '378', '07-05-2024', '2', NULL, '1927', 2, 2, '7860', '07/05/2024', 'U392', '2024-05-07 05:38:57'),
(15, 'P4877398', 'S43130', '', '3786', '07-05-2024', '2', NULL, '1927', 2, 2, '7860', '07/05/2024', 'U392', '2024-05-07 05:41:06'),
(16, 'P2288622', 'S43130', '', '3709', '07-05-2024', '2', NULL, '1927', 2, 2, '7860', '07/05/2024', 'U392', '2024-05-07 05:52:49'),
(17, 'P5563207', 'S43130', '', '3701', '07-05-2024', '2', NULL, '1927', 2, 2, '7860', '07/05/2024', 'U392', '2024-05-07 05:53:24'),
(18, 'P8047636', 'S43130', '', '3702', '07-05-2024', '2', NULL, '1927', 2, 2, '7860', '07/05/2024', 'U392', '2024-05-07 05:56:25'),
(19, 'P3934445', 'S43130', '', '37089', '07-05-2024', '2', NULL, '1927', 2, 2, '7860', '07/05/2024', 'U392', '2024-05-07 06:07:31'),
(20, 'P710629', 'S43130', '', '3708', '07-05-2024', '2', NULL, '1927', 2, 2, '7860', '07/05/2024', 'U392', '2024-05-07 06:08:39'),
(21, 'P7817428', 'S43130', '', '37088', '07-05-2024', '2', NULL, '1927', 2, 2, '7860', '07/05/2024', 'U392', '2024-05-07 06:13:28'),
(22, 'P6904578', 'S43130', '', '370886', '07-05-2024', '2', NULL, '1927', 2, 2, '7860', '07/05/2024', 'U392', '2024-05-07 06:15:38'),
(23, 'P110155', 'S43130', '', '3708866', '07-05-2024', '2', NULL, '1927', 2, 2, '7860', '07/05/2024', 'U392', '2024-05-07 06:16:18'),
(24, 'P6630607', 'S43130', '', '37088668', '07-05-2024', '2', NULL, '1927', 2, 2, '7860', '07/05/2024', 'U392', '2024-05-07 06:17:14'),
(25, 'P743696', 'S54301', '', '20240507123', '07-05-2024', 'test', NULL, '160', 21, 21, '1160', '07/05/2024', 'U392', '2024-05-07 06:18:32'),
(26, 'P4809561', 'S54301', '', '202405071239', '07-05-2024', 'test', NULL, '160', 21, 21, '1160', '07/05/2024', 'U392', '2024-05-07 06:19:18'),
(27, 'P1419876', 'S43130', '', '3708845', '07-05-2024', '2', NULL, '1927', 2, 2, '7860', '07/05/2024', 'U392', '2024-05-07 06:23:00'),
(28, 'P9551779', 'S43130', '', '370884567', '07-05-2024', '2', NULL, '1927', 2, 2, '7860', '07/05/2024', 'U392', '2024-05-07 06:25:15'),
(29, 'P2703998', 'S43130', '', '3708845674', '07-05-2024', '2', NULL, '1927', 2, 2, '7860', '07/05/2024', 'U392', '2024-05-07 06:25:30'),
(30, 'P629280', 'S42177', '', '232323232', '07-05-2024', '', NULL, '0', 21, 21, '1', '07/05/2024', 'U392', '2024-05-07 06:28:43'),
(31, 'P5178531', 'S42177', '', '7890011', '07-05-2024', 'meds purchase', NULL, '800', 3, 10, '3800', '07/05/2024', 'U392', '2024-05-07 06:34:11'),
(32, 'P5787600', 'S54301', '', '7700112200', '07-05-2024', 'meds purchgase from derma', NULL, '1600', 5, 10, '11600', '07/05/2024', 'U392', '2024-05-07 07:42:46'),
(33, 'P1194309', 'S43280', '', '8974500', '07-05-2024', 'Xanax', NULL, '1200', 5, 4, '7500', '07/05/2024', 'U392', '2024-05-07 09:06:40'),
(34, 'P1570540', 'S3787', '', '0001', '05/08/2024', '56', NULL, '44.16', 5, 5, '320', '08/05/2024', 'U392', '2024-05-08 12:15:53'),
(35, 'P1431402', 'S54301', '', '667', '05/08/2024', '67', NULL, '800', 6, 6, '5800', '08/05/2024', 'U392', '2024-05-08 12:22:29'),
(36, 'P350391', 'S32301', '', '245', '16-05-2024', '', NULL, '480', 5, 5, '3480', '16/05/2024', 'U392', '2024-05-16 06:25:18');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_history`
--

CREATE TABLE `purchase_history` (
  `ph_id` int(14) NOT NULL,
  `pur_id` varchar(128) DEFAULT NULL,
  `mid` varchar(128) DEFAULT NULL,
  `supp_id` varchar(64) DEFAULT NULL,
  `qty` varchar(128) DEFAULT NULL,
  `return_qnty` int(255) NOT NULL,
  `supplier_price` varchar(128) DEFAULT NULL,
  `unit_price` varchar(255) NOT NULL,
  `discount` varchar(128) DEFAULT NULL,
  `expire_date` varchar(128) DEFAULT NULL,
  `Batch_Number` varchar(255) NOT NULL,
  `delivery_time` int(100) NOT NULL,
  `payment_time` int(100) NOT NULL,
  `mrp` varchar(255) NOT NULL,
  `unit_mrp` varchar(255) NOT NULL,
  `total_amount` varchar(128) NOT NULL,
  `tax` int(155) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `purchase_history`
--

INSERT INTO `purchase_history` (`ph_id`, `pur_id`, `mid`, `supp_id`, `qty`, `return_qnty`, `supplier_price`, `unit_price`, `discount`, `expire_date`, `Batch_Number`, `delivery_time`, `payment_time`, `mrp`, `unit_mrp`, `total_amount`, `tax`) VALUES
(1, 'P3417856', 'P22083', 'S8690', '3000', 0, '40', '5', '30', '25-06-2026', 'ALL 001', 0, 0, '80', '8', '12000', 1920),
(2, 'P3417856', 'P44417', 'S8690', '4000', 0, '60', '6', '30', '30-07-2027', 'AMO 001', 0, 0, '120', '12', '24000', 3840),
(3, 'P8991577', 'P22083', 'S8690', '3000', 0, '40', '8', '30', '25-06-2026', 'ALL 001', 0, 0, '80', '8', '12000', 1920),
(4, 'P8991577', 'P44417', 'S8690', '4000', 0, '60', '7', '30', '30-07-2027', 'AMO 001', 0, 0, '120', '12', '24000', 3840),
(5, 'P1897674', 'P22083', 'S54301', '3000', 0, '50', '9', '0', '15-09-2027', 'ALL 002', 0, 0, '100', '10', '15000', 2400),
(6, 'P1897674', 'P44417', 'S54301', '4000', 0, '100', '', '0', '07-06-2028', 'AMO 002', 0, 0, '200', '20', '40000', 6400),
(7, 'P3327220', 'P22083', 'S33535', '100', 0, '67', '', '0', '08-05-2024', '464645', 0, 0, '67', '67', '6700', 1072),
(8, 'P9318953', 'P22083', 'S33535', '100', 0, '67', '', '0', '08-05-2024', '464645', 0, 0, '67', '67', '6700', 1072),
(9, 'P2478648', 'P44417', 'S43130', '1000', 0, '60', '', '0', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(10, 'P967872', 'P44417', 'S43130', '1000', 0, '60', '', '34', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(11, 'P967872', 'P22083', 'S43130', '10', 0, '45', '', '78', '15-05-2024', '465', 0, 0, '56', '5.6', '45', 7),
(12, 'P9784772', 'P44417', 'S43130', '1000', 0, '60', '', '34', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(13, 'P9784772', 'P22083', 'S43130', '10', 0, '45', '', '78', '15-05-2024', '465', 0, 0, '56', '5.6', '45', 7),
(14, 'P8301064', 'P44417', 'S43130', '1000', 0, '60', '', '34', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(15, 'P8301064', 'P22083', 'S43130', '10', 0, '45', '', '78', '15-05-2024', '465', 0, 0, '56', '5.6', '45', 7),
(16, 'P6182437', 'P44417', 'S43130', '1000', 0, '60', '', '34', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(17, 'P6182437', 'P22083', 'S43130', '10', 0, '45', '', '78', '15-05-2024', '465', 0, 0, '56', '5.6', '45', 7),
(18, 'P978192', 'P44417', 'S43130', '1000', 0, '60', '', '34', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(19, 'P978192', 'P22083', 'S43130', '10', 0, '45', '', '78', '15-05-2024', '465', 0, 0, '56', '5.6', '45', 7),
(20, 'P1374242', 'P44417', 'S43130', '1000', 0, '60', '', '34', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(21, 'P1374242', 'P22083', 'S43130', '10', 0, '45', '', '78', '15-05-2024', '465', 0, 0, '56', '5.6', '45', 7),
(22, 'P5655422', 'P44417', 'S43130', '1000', 0, '60', '', '34', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(23, 'P5655422', 'P22083', 'S43130', '10', 0, '45', '', '78', '15-05-2024', '465', 0, 0, '56', '5.6', '45', 7),
(24, 'P6190768', 'P44417', 'S43130', '1000', 0, '60', '', '34', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(25, 'P6190768', 'P22083', 'S43130', '10', 0, '45', '', '78', '15-05-2024', '465', 0, 0, '56', '5.6', '45', 7),
(26, 'P4877398', 'P44417', 'S43130', '1000', 0, '60', '', '34', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(27, 'P4877398', 'P22083', 'S43130', '10', 0, '45', '', '78', '15-05-2024', '465', 0, 0, '56', '5.6', '45', 7),
(28, 'P2288622', 'P44417', 'S43130', '1000', 0, '60', '', '34', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(29, 'P2288622', 'P22083', 'S43130', '10', 0, '45', '', '78', '15-05-2024', '465', 0, 0, '56', '5.6', '45', 7),
(30, 'P5563207', 'P44417', 'S43130', '1000', 0, '60', '', '34', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(31, 'P5563207', 'P22083', 'S43130', '10', 0, '45', '', '78', '15-05-2024', '465', 0, 0, '56', '5.6', '45', 7),
(32, 'P8047636', 'P44417', 'S43130', '1000', 0, '60', '', '34', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(33, 'P8047636', 'P22083', 'S43130', '10', 0, '45', '', '78', '15-05-2024', '465', 0, 0, '56', '5.6', '45', 7),
(34, 'P3934445', 'P44417', 'S43130', '1000', 0, '60', '', '34', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(35, 'P3934445', 'P22083', 'S43130', '10', 0, '45', '', '78', '15-05-2024', '465', 0, 0, '56', '5.6', '45', 7),
(36, 'P710629', 'P44417', 'S43130', '1000', 0, '60', '', '34', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(37, 'P710629', 'P22083', 'S43130', '10', 0, '45', '', '78', '15-05-2024', '465', 0, 0, '56', '5.6', '45', 7),
(38, 'P7817428', 'P44417', 'S43130', '1000', 0, '60', '', '34', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(39, 'P7817428', 'P22083', 'S43130', '10', 0, '45', '', '78', '15-05-2024', '465', 0, 0, '56', '5.6', '45', 7),
(40, 'P6904578', 'P44417', 'S43130', '1000', 0, '60', '', '34', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(41, 'P6904578', 'P22083', 'S43130', '10', 0, '45', '', '78', '15-05-2024', '465', 0, 0, '56', '5.6', '45', 7),
(42, 'P110155', 'P44417', 'S43130', '1000', 0, '60', '', '34', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(43, 'P110155', 'P22083', 'S43130', '10', 0, '45', '', '78', '15-05-2024', '465', 0, 0, '56', '5.6', '45', 7),
(44, 'P6630607', 'P44417', 'S43130', '1000', 0, '60', '', '34', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(45, 'P6630607', 'P22083', 'S43130', '10', 0, '45', '', '78', '15-05-2024', '465', 0, 0, '56', '5.6', '45', 7),
(46, 'P743696', 'P22083', 'S54301', '1000', 0, '10', '', '0', '25-11-2027', 'ALLE0098', 0, 0, '15', '1.5', '1000', 160),
(47, 'P4809561', 'P22083', 'S54301', '1000', 0, '10', '', '0', '25-11-2027', 'ALLE0098', 0, 0, '15', '1.5', '1000', 160),
(48, 'P1419876', 'P44417', 'S43130', '1000', 0, '60', '', '34', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(49, 'P1419876', 'P22083', 'S43130', '10', 0, '45', '', '78', '15-05-2024', '465', 0, 0, '56', '5.6', '45', 7),
(50, 'P9551779', 'P44417', 'S43130', '1000', 0, '60', '', '34', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(51, 'P9551779', 'P22083', 'S43130', '10', 0, '45', '', '78', '15-05-2024', '465', 0, 0, '56', '5.6', '45', 7),
(52, 'P2703998', 'P44417', 'S43130', '1000', 0, '60', '', '34', '14-05-2024', '24', 0, 0, '78', '7.8', '6000', 960),
(53, 'P2703998', 'P22083', 'S43130', '10', 0, '45', '', '78', '15-05-2024', '465', 0, 0, '56', '5.6', '45', 7),
(54, 'P629280', 'P22083', 'S42177', '10', 0, '1', '', '0', '07-05-2024', 'we234', 0, 0, '1', '0.1', '1', 0),
(55, 'P5178531', 'P22083', 'S42177', '1000', 200, '50', '', '0', '07-08-2026', 'All 003', 0, 0, '100', '10', '3000', 800),
(56, 'P5787600', 'P8717', 'S54301', '5000', 0, '20', '', '0', '07-07-2026', 'Cal 00', 0, 0, '40', '4', '10000', 1600),
(57, 'P1194309', 'P48407', 'S43280', '750', 100, '50', '', '0', '06-10-2026', 'XA001', 0, 0, '60', '12', '6300', 1200),
(58, 'P1570540', 'P44417', 'S3787', '120', 0, '23', '10', '0', '2024-05-15', '4545', 5, 5, '34', '3.4', '276', 44),
(59, 'P1431402', 'P22083', 'S54301', '1000', 0, '50', '5', '0', '2024-05-29', '656', 6, 6, '78', '7.8', '5000', 800),
(60, 'P350391', 'P25106', 'S32301', '300', 0, '100', '10', '0', '01-03-2026', '25424', 0, 0, '120', '12', '3000', 480);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return`
--

CREATE TABLE `purchase_return` (
  `id` int(14) NOT NULL,
  `r_id` varchar(64) DEFAULT NULL,
  `pur_id` varchar(64) DEFAULT NULL,
  `sid` varchar(64) DEFAULT NULL,
  `invoice_no` varchar(128) DEFAULT NULL,
  `return_date` varchar(128) DEFAULT NULL,
  `total_deduction` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `purchase_return`
--

INSERT INTO `purchase_return` (`id`, `r_id`, `pur_id`, `sid`, `invoice_no`, `return_date`, `total_deduction`) VALUES
(1, 'R189197', 'P5178531', 'S42177', '7890011', '05-07-2024', '2000'),
(2, 'R182899', 'P1194309', 'S43280', '8974500', '05-07-2024', '1200');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_details`
--

CREATE TABLE `purchase_return_details` (
  `id` int(14) NOT NULL,
  `r_id` varchar(128) DEFAULT NULL,
  `pur_id` varchar(128) DEFAULT NULL,
  `supp_id` varchar(64) DEFAULT NULL,
  `mid` varchar(128) DEFAULT NULL,
  `return_qty` varchar(64) DEFAULT NULL,
  `deduction_amount` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `purchase_return_details`
--

INSERT INTO `purchase_return_details` (`id`, `r_id`, `pur_id`, `supp_id`, `mid`, `return_qty`, `deduction_amount`) VALUES
(1, 'R189197', 'P5178531', 'S42177', 'P22083', '200', '2000'),
(2, 'R182899', 'P1194309', 'S43280', 'P48407', '100', '1200');

-- --------------------------------------------------------

--
-- Table structure for table `reverse_stock`
--

CREATE TABLE `reverse_stock` (
  `id` int(255) NOT NULL,
  `request_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `supplier_id` varchar(255) NOT NULL,
  `Batch_Number` varchar(255) NOT NULL,
  `expire_date` varchar(255) NOT NULL,
  `from_store_id` varchar(255) NOT NULL,
  `qty` int(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `rev_status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reverse_stock`
--

INSERT INTO `reverse_stock` (`id`, `request_id`, `product_id`, `supplier_id`, `Batch_Number`, `expire_date`, `from_store_id`, `qty`, `created_at`, `rev_status`) VALUES
(1, 'Req133294', 'P22083', 'S54301', 'ALL 002', '2027-09-15', '82', 100, '2024-05-07 04:58:40', 1),
(2, 'Req133294', 'P44417', 'S54301', 'AMO 002', '2028-06-07', '82', 100, '2024-05-07 04:58:40', 1),
(3, 'Req532943', 'P48407', 'S43280', 'XA001', '2026-10-06', '68', 10, '2024-05-07 10:16:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `store_id` varchar(255) NOT NULL,
  `id` int(14) NOT NULL,
  `walkin_cus_name` varchar(255) NOT NULL,
  `sale_id` varchar(64) DEFAULT NULL,
  `paid_amount` varchar(64) DEFAULT NULL,
  `cus_id` varchar(64) DEFAULT NULL,
  `walkin_phone` varchar(255) NOT NULL,
  `total_discount` varchar(64) DEFAULT NULL,
  `total_amount` varchar(64) DEFAULT NULL,
  `sales_time` varchar(255) DEFAULT NULL,
  `time_stamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `sale_id`, `store_id`, `cus_id`, `walkin_cus_name`, `walkin_phone`, `total_discount`, `total_amount`, `total_tax`, `paid_amount`, `due_amount`, `payment_mode`, `invoice_no`, `create_date`, `monthyear`, `entryid`, `counter`, `pay_status`, `sales_time`, `time_stamp`, `sale_date`) VALUES
(1, 'S3639639', '82', 'C360033', 'Ravi', '9876345210', '0', '348', '48', '348', '0', 'Cash', '30569990', '07/05/2024', '2024-05', 'E218', 'SALESMAN', 'Pay', '1715057747', '2024-05-07 04:55:47', '2024-05-07'),
(2, 'S7994577', '78', 'C36377', '', '', '464', '0', '64', '0', '0', 'Cash', '47784493', '07/05/2024', '2024-05', 'U392', 'ADMIN', 'Pay', '11:55:58', '2024-05-07 06:25:58', '2024-05-07'),
(3, 'S7652933', '78', 'C36377', '', '', '464', '0', '64', '0', '0', 'Cash', '11687781', '07/05/2024', '2024-05', 'U392', 'ADMIN', 'Pay', '11:56:18', '2024-05-07 06:26:18', '2024-05-07'),
(4, 'S7716519', '78', 'C969183', '', '', '0', '232', '32', '232', '0', 'Cash', '16612666', '07/05/2024', '2024-05', 'U392', 'ADMIN', 'Pay', '12:05:07', '2024-05-07 06:35:07', '2024-05-07'),
(5, 'S4201544', '78', 'C969183', 'Cash', '', '0', '232', '32', '232', '0', 'Cash', '26644749', '07/05/2024', '2024-05', 'U392', 'ADMIN', 'Pay', '1715063763', '2024-05-07 06:36:03', '2024-05-07'),
(6, 'S3942443', '78', 'C969183', '', '', '0', '116', '16', '116', '0', 'Cash', '14878821', '07/05/2024', '2024-05', 'U392', 'ADMIN', 'Pay', '12:06:39', '2024-05-07 06:36:39', '2024-05-07'),
(7, 'S8033840', '78', 'C273800', 'Cash', '9876543210', '0', '348', '48', '348', '0', 'Cash', '34373165', '07/05/2024', '2024-05', 'U392', 'ADMIN', 'Pay', '1715063943', '2024-05-07 06:39:03', '2024-05-07'),
(8, 'S1204826', '78', 'C337551', '', '', '0', '232', '32', '232', '0', 'Cash', '45827123', '07/05/2024', '2024-05', 'U392', 'ADMIN', 'Pay', '12:09:34', '2024-05-07 06:39:34', '2024-05-07'),
(9, 'S8637593', '78', 'C475688', '', '', '0', '116', '16', '116', '0', 'Cash', '44321451', '07/05/2024', '2024-05', 'U392', 'ADMIN', 'Pay', '12:09:58', '2024-05-07 06:39:58', '2024-05-07'),
(10, 'S3745660', '78', 'C311543', 'pavan', '6678901234', '10', '268', '38', '200', '68', 'Cash', '12608001', '07/05/2024', '2024-05', 'U392', 'ADMIN', 'Pay', '1715074284', '2024-05-07 09:31:24', '2024-05-07'),
(11, 'S1387561', '68', 'C142510', 'charan', '2345689654', '0', '139', '19', '139', '0', 'Cash', '46002186', '07/05/2024', '2024-05', 'U498', 'SALESMAN', 'Pay', '1715075917', '2024-05-07 09:58:37', '2024-05-07'),
(12, 'S7178860', '78', 'C419946', 'Test Med', '', '0', '12', '0', '0', '12', '', '22799882', '08/05/2024', '2024-05', 'API001', 'API', 'Hold', '1715149529', '2024-05-08 06:25:29', '2024-05-08'),
(13, 'S7178860', '78', 'C419946', 'Test Med', '', '0', '12', '0', '0', '12', '', '22799882', '08/05/2024', '2024-05', 'API001', 'API', 'Hold', '1715149529', '2024-05-08 06:25:29', '2024-05-08'),
(14, 'S4507791', '78', 'C419946', 'Test Med', '', '0', '12', '0', '0', '12', '', '43765598', '08/05/2024', '2024-05', 'API001', 'API', 'Hold', '1715149550', '2024-05-08 06:25:50', '2024-05-08'),
(15, 'S4507791', '78', 'C419946', 'Test Med', '', '0', '12', '0', '0', '12', '', '43765598', '08/05/2024', '2024-05', 'API001', 'API', 'Hold', '1715149550', '2024-05-08 06:25:50', '2024-05-08'),
(16, 'S4271076', '78', 'C419946', 'Test Med', '', '0', '84', '0', '0', '84', '', '26352350', '08/05/2024', '2024-05', 'API001', 'API', 'Hold', '1715152203', '2024-05-08 07:10:03', '2024-05-08'),
(17, 'S4271076', '78', 'C419946', 'Test Med', '', '0', '84', '0', '0', '84', '', '26352350', '08/05/2024', '2024-05', 'API001', 'API', 'Hold', '1715152203', '2024-05-08 07:10:03', '2024-05-08'),
(18, 'S2355128', '78', 'C419946', 'Test Med', '', '0', '162.4', '22.4', '0', '162.4', '', '38704810', '08/05/2024', '2024-05', 'API001', 'API', 'Hold', '1715153000', '2024-05-08 07:23:20', '2024-05-08'),
(19, 'S2355128', '78', 'C419946', 'Test Med', '', '0', '162.4', '22.4', '0', '162.4', '', '38704810', '08/05/2024', '2024-05', 'API001', 'API', 'Hold', '1715153000', '2024-05-08 07:23:20', '2024-05-08'),
(20, 'S4056990', '78', 'C419946', 'Test Med', '', '0', '162.4', '22.4', '0', '162.4', '', '34819715', '15/05/2024', '2024-05', 'API001', 'API', 'Hold', '1715769861', '2024-05-15 10:44:21', '2024-05-15'),
(21, 'S4056990', '78', 'C419946', 'Test Med', '', '0', '162.4', '22.4', '0', '162.4', '', '34819715', '15/05/2024', '2024-05', 'API001', 'API', 'Hold', '1715769861', '2024-05-15 10:44:21', '2024-05-15');

-- --------------------------------------------------------

--
-- Table structure for table `sales_details`
--

CREATE TABLE `sales_details` (
  `sd_id` int(14) NOT NULL,
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
  `grand_total` int(255) NOT NULL,
  `discount` varchar(128) DEFAULT NULL,
  `gdiscount` varchar(255) NOT NULL,
  `total_discount` varchar(64) DEFAULT NULL,
  `sale_date` date NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `sales_details`
--

INSERT INTO `sales_details` (`sd_id`, `sale_id`, `mid`, `supplier_id`, `Batch_Number`, `cartoon`, `qty`, `rate`, `supp_rate`, `total_price`, `total_tax`, `grand_total`, `discount`, `gdiscount`, `total_discount`, `sale_date`, `store_id`) VALUES
(1, 'S3639639', 'P44417', 'S54301', 'AMO 002', NULL, '10', '20', '', '200', '48', 348, '0', '0', NULL, '2024-05-07', 82),
(2, 'S3639639', 'P22083', 'S54301', 'ALL 002', NULL, '10', '10', '', '100', '48', 348, '0', '0', NULL, '2024-05-07', 82),
(3, 'S7994577', 'P22083', 'S54301', 'ALL 002', NULL, '10', '10', '', '100', '64', 0, '', '', NULL, '2024-05-07', 78),
(4, 'S7994577', 'P44417', 'S54301', 'AMO 002', NULL, '10', '20', '', '200', '64', 0, '', '', NULL, '2024-05-07', 78),
(5, 'S7994577', 'P22083', 'S54301', 'ALL 002', NULL, '10', '10', '', '100', '64', 0, '', '', NULL, '2024-05-07', 78),
(6, 'S7652933', 'P22083', 'S54301', 'ALL 002', NULL, '10', '10', '', '100', '64', 0, '', '', NULL, '2024-05-07', 78),
(7, 'S7652933', 'P44417', 'S54301', 'AMO 002', NULL, '10', '20', '', '200', '64', 0, '', '', NULL, '2024-05-07', 78),
(8, 'S7652933', 'P22083', 'S54301', 'ALL 002', NULL, '10', '10', '', '100', '64', 0, '', '', NULL, '2024-05-07', 78),
(9, 'S7716519', 'P44417', 'S54301', 'AMO 002', NULL, '10', '20', '', '200', '32', 232, '', '', NULL, '2024-05-07', 78),
(10, 'S4201544', 'P44417', 'S54301', 'AMO 002', NULL, '10', '20', '', '200', '32', 232, '0', '0', NULL, '2024-05-07', 78),
(11, 'S3942443', 'P22083', 'S54301', 'ALL 002', NULL, '10', '10', '', '100', '16', 116, '', '', NULL, '2024-05-07', 78),
(12, 'S8033840', 'P44417', 'S54301', 'AMO 002', NULL, '10', '20', '', '200', '48', 348, '0', '0', NULL, '2024-05-07', 78),
(13, 'S8033840', 'P22083', 'S54301', 'ALL 002', NULL, '10', '10', '', '100', '48', 348, '0', '0', NULL, '2024-05-07', 78),
(14, 'S1204826', 'P44417', 'S54301', 'AMO 002', NULL, '10', '20', '', '200', '32', 232, '', '', NULL, '2024-05-07', 78),
(15, 'S8637593', 'P22083', 'S54301', 'ALL 002', NULL, '10', '10', '', '100', '16', 116, '', '', NULL, '2024-05-07', 78),
(16, 'S3745660', 'P48407', 'S43280', 'XA001', NULL, '20', '12', '', '240', '38', 268, '0', '10', NULL, '2024-05-07', 78),
(17, 'S1387561', 'P48407', 'S43280', 'XA001', NULL, '10', '12', '', '120', '19', 139, '0', '0', NULL, '2024-05-07', 68),
(18, 'S7178860', 'P17404', 'S43280', 'XA001', NULL, '1', '12', '', '12', '0', 12, '0', '0', NULL, '2024-05-08', 78),
(19, 'S4507791', 'P17404', 'S43280', 'XA001', NULL, '1', '12', '', '12', '0', 12, '0', '0', NULL, '2024-05-08', 78),
(20, 'S4271076', 'P17404', 'S43280', 'XA001', NULL, '7', '12', '', '84', '0', 84, '0', '0', NULL, '2024-05-08', 78),
(21, 'S2355128', 'P44417', 'S54301', 'AMO 002', NULL, '7', '20', '', '140', '22.4', 162, '0', '0', NULL, '2024-05-08', 78),
(22, 'S4056990', 'P44417', 'S54301', 'AMO 002', NULL, '7', '20', '', '140', '22.4', 162, '0', '0', NULL, '2024-05-15', 78);

-- --------------------------------------------------------

--
-- Table structure for table `sales_return`
--

CREATE TABLE `sales_return` (
  `id` int(14) NOT NULL,
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
  `store_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `sales_return`
--

INSERT INTO `sales_return` (`id`, `sr_id`, `cus_id`, `sale_id`, `invoice_no`, `return_date`, `total_deduction`, `total_amount`, `entry_id`, `counter`, `tax`, `store_id`) VALUES
(1, 'SR1206476', 'C142510', 'S1387561', '4894368', '05-07-2024', '0', '60', 'U498', 'SALESMAN', '9.6', 68);

-- --------------------------------------------------------

--
-- Table structure for table `sales_return_details`
--

CREATE TABLE `sales_return_details` (
  `id` int(14) NOT NULL,
  `sr_id` varchar(128) DEFAULT NULL,
  `mid` varchar(128) DEFAULT NULL,
  `r_qty` varchar(128) DEFAULT NULL,
  `r_total` varchar(128) DEFAULT NULL,
  `r_deduction` varchar(128) DEFAULT NULL,
  `date` varchar(128) DEFAULT NULL,
  `store_id` int(255) NOT NULL,
  `tax` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `sales_return_details`
--

INSERT INTO `sales_return_details` (`id`, `sr_id`, `mid`, `r_qty`, `r_total`, `r_deduction`, `date`, `store_id`, `tax`) VALUES
(1, 'SR1206476', 'P48407', '5', '60', '0', '05-07-2024', 0, 0);

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
  `main_store_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `sitelogo`, `sitetitle`, `description`, `copyright`, `contact`, `currency`, `symbol`, `email`, `address`, `main_store_id`) VALUES
(1, 'LIMS Pharmacy ', 'WhatsApp_Image_2024-03-20_at_2_25_37_PM2.jpeg', 'Lims', 'ILLNESS TO WELLNESS', 'Genit Bangladesh', '7337333011', 'TK', 'TK', 'limspharma@mail.com', 'Ibrahimpatnam', 78);

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
  `full_fill_qty` int(255) NOT NULL,
  `store_id` varchar(11) NOT NULL,
  `mrp` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `createdat` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_request`
--

INSERT INTO `stock_request` (`id`, `request_id`, `product_id`, `Batch_Number`, `request_qty`, `full_fill_qty`, `store_id`, `mrp`, `status`, `createdat`) VALUES
(1, 'Req9447014', 'P22083', '', 100, 100, '82', 0, 'returned', '2024-05-07 10:26:49'),
(2, 'Req9447014', 'P44417', '', 100, 100, '82', 0, 'returned', '2024-05-07 10:26:49'),
(3, 'Req6207763', 'P48407', '', 5, 5, '68', 0, 'returned', '2024-05-07 15:43:50');

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer`
--

CREATE TABLE `stock_transfer` (
  `id` int(11) NOT NULL,
  `stock_transfer_id` varchar(255) NOT NULL,
  `store_id` int(255) NOT NULL,
  `net_amount` int(255) NOT NULL,
  `total_tax` int(255) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `createdAT` int(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_transfer`
--

INSERT INTO `stock_transfer` (`id`, `stock_transfer_id`, `store_id`, `net_amount`, `total_tax`, `total_amount`, `createdAT`, `date`) VALUES
(1, 'T5334669', 82, 6000, 960, 6960, 1715057652, '2024-05-07'),
(2, 'T3055346', 68, 600, 96, 696, 1715073104, '2024-05-07');

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer_history`
--

CREATE TABLE `stock_transfer_history` (
  `id` int(255) NOT NULL,
  `stock_transfer_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `supplier_id` varchar(255) NOT NULL,
  `Batch_Number` varchar(255) NOT NULL,
  `manf_date` varchar(255) NOT NULL,
  `expire_date` varchar(255) NOT NULL,
  `purchase_rate` int(255) NOT NULL,
  `mrp` int(255) NOT NULL,
  `instock` int(255) NOT NULL,
  `sale_qty` int(255) NOT NULL,
  `discount` int(255) NOT NULL,
  `tax` int(11) NOT NULL,
  `createdat` int(255) NOT NULL,
  `store_id` int(255) NOT NULL,
  `sum` int(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_transfer_history`
--

INSERT INTO `stock_transfer_history` (`id`, `stock_transfer_id`, `product_id`, `supplier_id`, `Batch_Number`, `manf_date`, `expire_date`, `purchase_rate`, `mrp`, `instock`, `sale_qty`, `discount`, `tax`, `createdat`, `store_id`, `sum`, `date`) VALUES
(1, 'T5334669', 'P22083', 'S54301', 'ALL 002', '', '2027-09-15', 50, 10, 200, 0, 0, 320, 1715057652, 82, 0, '0000-00-00'),
(2, 'T5334669', 'P44417', 'S54301', 'AMO 002', '', '2028-06-07', 100, 20, 200, 0, 0, 640, 1715057652, 82, 0, '0000-00-00'),
(3, 'T3055346', 'P48407', 'S43280', 'XA001', '', '2026-10-06', 50, 12, 50, 0, 0, 96, 1715073104, 68, 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `id` int(255) NOT NULL,
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
  `indent_setting_dept_val` int(255) NOT NULL,
  `dept_order` varchar(255) NOT NULL,
  `lock_indents` varchar(255) NOT NULL COMMENT '0->goods receipt, 1->goods issue,2->stock point,3->dept billing',
  `less_returns` int(255) NOT NULL COMMENT '0->yes, 1->no',
  `less_returns_if_yes` int(255) NOT NULL COMMENT '0->%, 1->cash',
  `less_returns_val` varchar(255) NOT NULL,
  `item_search` varchar(255) NOT NULL COMMENT '0->item cd, 1->item name',
  `mrq_indent` int(255) NOT NULL COMMENT '0->auto, 1->manual',
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
(67, 'CT10UZ', 'MICU', 'St1', '0', '1,2', '1', '0', '', '', '', '1', '', '10', '0', '', '', '', '0', '', '', '', '', '', '', '', '', '2,3,4,5,6,7', '', '', '', '', '', '1', '', '1', '1', 0, '1', '0,1,2,3', 1, 0, '', '0', 0, '', '', '', '', '', '', ''),
(68, 'PT101254', 'SICU', 'St2', '1', '2', '0', '2', '', '', '', '', '', '', '0', '', '', '', '0', '', '', '', '', '', '', '', '', '8,9,10,11,12,13,14,15', '', '', '', '', '', '1', '', '1', '1', 0, '1', '2,3', 1, 0, '', '0', 0, '3,4,5', '', '', '', '', '', ''),
(70, 'HER108', 'NICU', 'St3', '1', '0', '0', '1', '1', '0.50', '1', '', '5', '', '2', '', '5%', '5%', '0', '10', '10', '', '', '1', '', '5', '', '1,3,5,7,8,10,12,14', '', '8', '2', '', '', '', '', '', '1', 0, '', '0,3,4', 1, 0, '5', '1', 1, '1,5', '', '', '', '', '', ''),
(78, 'Main007', 'Main_store', 'ms007', '1', '', '0', '0', '', '', '', '', '', '', '0', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 1, 0, '', '0', 0, '', '', '', '', '', '', ''),
(81, 'EMG001', 'Emergency', 'ER', '0', '', '0', '0', '', '.025', '', '', '', '', '0', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 1, 0, '', '0', 0, '', '', '', '', '', '', ''),
(82, 'TRA00', 'Taruma', 'TRA00', '0', '', '0', '0', '', '.025', '', '', '', '', '0', '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 1, 0, '', '0', 0, '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `store_medicine_mata`
--

CREATE TABLE `store_medicine_mata` (
  `id` int(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `supplier_id` varchar(256) NOT NULL,
  `Batch_Number` varchar(255) NOT NULL,
  `manf_date` varchar(255) NOT NULL,
  `expire_date` varchar(255) NOT NULL,
  `purchase_rate` int(255) NOT NULL,
  `mrp` float NOT NULL,
  `unit_mrp` varchar(255) NOT NULL,
  `instock` int(255) NOT NULL,
  `sale_qty` int(11) NOT NULL,
  `discount` int(255) NOT NULL DEFAULT 0,
  `createdat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tax` int(255) NOT NULL,
  `store_id` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_medicine_mata`
--

INSERT INTO `store_medicine_mata` (`id`, `product_id`, `supplier_id`, `Batch_Number`, `manf_date`, `expire_date`, `purchase_rate`, `mrp`, `unit_mrp`, `instock`, `sale_qty`, `discount`, `createdat`, `tax`, `store_id`, `status`) VALUES
(1, 'P22083', 'S8690', 'ALL 001', '', '2026-06-25', 40, 8, '', 3300, 0, 0, '2024-05-07 04:36:35', 5760, '78', 0),
(2, 'P44417', 'S8690', 'AMO 001', '', '2027-07-30', 60, 12, '', 4400, 0, 0, '2024-05-07 04:36:35', 5760, '78', 0),
(3, 'P22083', 'S54301', 'ALL 002', '', '2027-09-15', 50, 10, '', 1730, 0, 0, '2024-05-07 06:39:58', 8800, '78', 1),
(4, 'P44417', 'S54301', 'AMO 002', '', '2028-06-07', 100, 20, '', 2726, 14, 0, '2024-05-15 10:44:21', 8800, '78', 1),
(5, 'P22083', 'S54301', 'ALL 002', '', '2027-09-15', 50, 10, '', 1800, 0, 0, '2024-05-07 05:00:04', 8800, '78', 0),
(6, 'P44417', 'S54301', 'AMO 002', '', '2028-06-07', 100, 20, '', 2800, 0, 0, '2024-05-07 04:59:58', 8800, '78', 0),
(7, 'P22083', 'S33535', '464645', '', '2024-05-08', 67, 67, '', 200, 0, 0, '2024-05-07 04:49:53', 1072, '78', 0),
(8, 'P22083', 'S54301', 'ALL 002', '', '2027-09-15', 50, 10, '', 190, 0, 0, '2024-05-07 05:00:04', 320, '82', 1),
(9, 'P44417', 'S54301', 'AMO 002', '', '2028-06-07', 100, 20, '', 190, 0, 0, '2024-05-07 04:59:58', 640, '82', 1),
(10, 'P44417', 'S43130', '24', '', '2024-05-14', 60, 7.8, '', 1300, 0, 0, '2024-05-07 06:25:30', 960, '78', 1),
(11, 'P22083', 'S43130', '465', '', '2024-05-15', 45, 5.6, '', 22, 10, 0, '2024-05-07 06:25:30', 1927, '78', 1),
(12, 'P44417', 'S43130', '24', '', '2024-05-14', 60, 7.8, '', 1300, 0, 0, '2024-05-07 06:25:30', 960, '78', 0),
(13, 'P22083', 'S43130', '465', '', '2024-05-15', 45, 5.6, '', 22, 10, 0, '2024-05-07 06:25:30', 1927, '78', 0),
(14, 'P22083', 'S54301', 'ALLE0098', '', '2027-11-25', 10, 1.5, '', 1100, 10, 0, '2024-05-07 06:19:18', 160, '78', 0),
(15, 'P22083', 'S42177', 'we234', '', '2024-05-07', 1, 0.1, '', 10, 50, 0, '2024-05-07 06:28:43', 0, '78', 0),
(16, 'P22083', 'S42177', 'All 003', '', '2026-08-07', 50, 10, '', 800, 50, 0, '2024-05-07 07:25:37', 800, '78', 1),
(17, 'P8717', 'S54301', 'Cal 00', '', '2026-07-07', 20, 4, '', 4000, 0, 0, '2024-05-07 07:43:58', 1600, '78', 1),
(18, 'P8717', 'S54301', 'Cal 00', '', '2026-07-07', 20, 4, '', 1000, 0, 0, '2024-05-07 07:43:58', 1600, '78', 0),
(19, 'P48407', 'S43280', 'XA001', '', '2026-10-06', 50, 12, '', 585, 0, 0, '2024-05-07 12:05:07', 1200, '78', 1),
(20, 'P17404', 'S43280', 'XA001', '', '2026-10-06', 50, 12, '', 31, 9, 0, '2024-05-08 07:10:03', 96, '78', 1),
(21, 'P44417', 'S3787', '4545', '', '2024-05-15', 23, 3.4, '', 120, 77, 0, '2024-05-08 12:15:53', 44, '78', 0),
(22, 'P22083', 'S54301', '656', '', '2024-05-29', 50, 7.8, '', 1000, 80, 0, '2024-05-08 12:22:29', 800, '78', 0),
(23, 'P25106', 'S32301', '25424', '', '2026-03-01', 100, 12, '', 300, 0, 0, '2024-05-16 06:26:34', 480, '78', 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(14) NOT NULL,
  `s_id` varchar(64) DEFAULT NULL,
  `s_name` varchar(256) DEFAULT NULL,
  `s_email` varchar(256) DEFAULT NULL,
  `s_note` varchar(512) DEFAULT NULL,
  `s_phone` varchar(128) DEFAULT NULL,
  `s_address` varchar(512) NOT NULL,
  `s_img` varchar(256) DEFAULT NULL,
  `entrydate` varchar(128) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `s_id`, `s_name`, `s_email`, `s_note`, `s_phone`, `s_address`, `s_img`, `entrydate`, `status`) VALUES
(2, 'S14685', 'TULASI AGENCIES', 'tulasi@gmail.com', '', '8654795610', ' E3, E3rustumjiapts#30norrisrdrichmondtw, Richmond Town', 'S14685.jpg', '02-09-2024', 'Active'),
(5, 'S54301', 'Derma pharmacy', 'derma@gmail.com', 'Nil', '6309315289', 'Hyderabad Gachibowli', 'S54301.jpg', '02-12-2024', 'Active'),
(6, 'S3787', 'DR.REDDYS', 'reddy@gmail.com', '', '8574632190', '3rd Fl,flat-15, Swastik Kutir Hsg Soc, Jamuna Bldg, Chembur', 'S3787.jpg', '02-12-2024', 'Active'),
(9, 'S8690', 'S.R.PHARMA', 'srpharma@gmail.com', 'sr pharma', '7896521460', '304, Govind Nagar, Jay Tower Apartment, Sonawala Lane, Borivali (west)', 'S8690.jpg', '02-19-2024', 'Active'),
(10, 'S43130', 'Medmed', 'medmed@gmail.com', 'Medical store', '8886979283', 'odf colony ammenpur', 'S43130.png', '02-26-2024', 'Active'),
(11, 'S28123', 'Medpluses', 'medpluse@gmail.com', 'Supplier', '9000090001', 'Hyderabad', 'S28123.png', '03-04-2024', 'Active'),
(12, 'S32301', 'Durga Suppliers', 'rtr@gmail.com', '', '9632105478', 'Frtyu', 'S32301.png', '03-04-2024', 'Active'),
(13, 'S42177', 'Clinc', 'clinc@gmail.com', 'Phaarma', '6230147890', 'Hyderabad', 'S42177.png', '03-05-2024', 'Active'),
(14, 'S45813', 'Srikanth', 'srikanth@gmail.com', 'Supplier', '6321478952', 'Hyderabad', 'S45813.png', '03-07-2024', 'Active'),
(15, 'S32353', 'MicroBL Pharma', 'micro@gmail.com', 'Pharma', '6320145987', 'Hyderabad', 'S32353.png', '03-16-2024', 'Active'),
(16, 'S30931', 'Realred supplier', 'realred@gmail.com', '', '7032061874', 'Hyderabad', 'S30931.png', '03-22-2024', 'Active'),
(17, 'S33535', 'MahaManu', 'maha@gmail.com', 'Test', '7032061871', 'Hyd', 'S33535.png', '04-01-2024', 'Active'),
(18, 'S18936', 'HealthCare', 'healthcare@gmail.com', 'Supplier', '7896541230', 'Mohali sector 77', 'S18936.jpg', '04-29-2024', 'Active'),
(19, 'S32335', 'Wildlife', 'wildlife@gmail.com', 'Hyd', '7878784545', 'Hyd', 'S32335.png', '04-30-2024', 'Active'),
(20, 'S9704', 'Vishal Pharmacy', 'vishal@gmail.com', 'New Supplier', '9829637410', 'Mohali sector 77', 'S9704.jpg', '05-06-2024', 'Active'),
(21, 'S43280', 'Raja Suppliers', 'raja@gmail.com', '', '7741025896', 'Hyderabad', 'S43280.png', '05-07-2024', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_ledger`
--

CREATE TABLE `supplier_ledger` (
  `id` int(14) NOT NULL,
  `supplier_id` varchar(256) DEFAULT NULL,
  `total_amount` varchar(256) DEFAULT NULL,
  `total_paid` varchar(256) DEFAULT NULL,
  `total_due` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `supplier_ledger`
--

INSERT INTO `supplier_ledger` (`id`, `supplier_id`, `total_amount`, `total_paid`, `total_due`) VALUES
(1, 'S14685', '0', '0', '0'),
(2, 'S54301', '83520', '83520', '0'),
(3, 'S3787', '320', '320', '0'),
(4, 'S8690', '83400', '83400', '0'),
(5, 'S43130', '172020', '172020', '0'),
(6, 'S28123', '0', '0', '0'),
(7, 'S32301', '3480', '3480', '0'),
(8, 'S42177', '5801', '5801', '0'),
(9, 'S45813', '0', '0', '0'),
(10, 'S32353', '0', '0', '0'),
(11, 'S30931', '0', '0', '0'),
(12, 'S33535', '15544', '15544', '0'),
(13, 'S18936', '0', '0', '0'),
(14, 'S32335', '0', '0', '0'),
(15, 'S9704', '0', '0', '0'),
(16, 'S43280', '8700', '8700', '0');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_product`
--

CREATE TABLE `supplier_product` (
  `sp_id` int(14) NOT NULL,
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
  `id` int(14) NOT NULL,
  `supplier_id` varchar(64) DEFAULT NULL,
  `pur_id` varchar(128) DEFAULT NULL,
  `total_amount` varchar(64) DEFAULT NULL,
  `paid_amount` varchar(64) DEFAULT NULL,
  `due_amount` varchar(256) DEFAULT NULL,
  `date` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `supp_account`
--

INSERT INTO `supp_account` (`id`, `supplier_id`, `pur_id`, `total_amount`, `paid_amount`, `due_amount`, `date`) VALUES
(1, 'S8690', 'P3417856', '41700', '41700', '0', '05/07/2024'),
(2, 'S8690', 'P8991577', '41700', '41700', '0', '05/07/2024'),
(3, 'S54301', 'P1897674', '63800', '63800', '0', '05/07/2024'),
(4, 'S33535', 'P3327220', '7772', '7772', '0', ''),
(5, 'S33535', 'P9318953', '7772', '7772', '0', ''),
(6, 'S43130', 'P2478648', '6960', '6960', '0', ''),
(7, 'S43130', 'P967872', '7860', '7860', '0', ''),
(8, 'S43130', 'P9784772', '7860', '7860', '0', ''),
(9, 'S43130', 'P8301064', '7860', '7860', '0', ''),
(10, 'S43130', 'P6182437', '7860', '7860', '0', ''),
(11, 'S43130', 'P978192', '7860', '7860', '0', ''),
(12, 'S43130', 'P1374242', '7860', '7860', '0', ''),
(13, 'S43130', 'P5655422', '7860', '7860', '0', ''),
(14, 'S43130', 'P6190768', '7860', '7860', '0', ''),
(15, 'S43130', 'P4877398', '7860', '7860', '0', ''),
(16, 'S43130', 'P2288622', '7860', '7860', '0', ''),
(17, 'S43130', 'P5563207', '7860', '7860', '0', ''),
(18, 'S43130', 'P8047636', '7860', '7860', '0', ''),
(19, 'S43130', 'P3934445', '7860', '7860', '0', ''),
(20, 'S43130', 'P710629', '7860', '7860', '0', ''),
(21, 'S43130', 'P7817428', '7860', '7860', '0', ''),
(22, 'S43130', 'P6904578', '7860', '7860', '0', ''),
(23, 'S43130', 'P110155', '7860', '7860', '0', ''),
(24, 'S43130', 'P6630607', '7860', '7860', '0', ''),
(25, 'S54301', 'P743696', '1160', '1160', '0', '05/07/2024'),
(26, 'S54301', 'P4809561', '1160', '1160', '0', '05/07/2024'),
(27, 'S43130', 'P1419876', '7860', '7860', '0', ''),
(28, 'S43130', 'P9551779', '7860', '7860', '0', ''),
(29, 'S43130', 'P2703998', '7860', '7860', '0', ''),
(30, 'S42177', 'P629280', '1', '1', '0', '05/01/2024'),
(31, 'S42177', 'P5178531', '5800', '5800', '0', '05/07/2024'),
(32, 'S54301', 'P5787600', '11600', '11600', '0', '05/07/2024'),
(33, 'S43280', 'P1194309', '8700', '8700', '0', '05/09/2024'),
(34, 'S3787', 'P1570540', '320', '320', '0', ''),
(35, 'S54301', 'P1431402', '5800', '5800', '0', '05/21/2024'),
(36, 'S32301', 'P350391', '3480', '3480', '0', '05/16/2024');

-- --------------------------------------------------------

--
-- Table structure for table `supp_payment`
--

CREATE TABLE `supp_payment` (
  `id` int(14) NOT NULL,
  `supp_id` varchar(64) DEFAULT NULL,
  `pur_id` varchar(64) DEFAULT NULL,
  `type` varchar(64) DEFAULT NULL,
  `bank_id` int(14) DEFAULT NULL,
  `cheque_no` varchar(128) DEFAULT NULL,
  `issue_date` varchar(64) DEFAULT NULL,
  `receiver_name` varchar(128) DEFAULT NULL,
  `receiver_contact` varchar(128) DEFAULT NULL,
  `paid_amount` varchar(64) DEFAULT NULL,
  `date` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `supp_payment`
--

INSERT INTO `supp_payment` (`id`, `supp_id`, `pur_id`, `type`, `bank_id`, `cheque_no`, `issue_date`, `receiver_name`, `receiver_contact`, `paid_amount`, `date`) VALUES
(1, 'S8690', 'P3417856', 'Cash', NULL, NULL, NULL, 'Riya', '9807654321', '41700', '05/07/2024'),
(2, 'S8690', 'P8991577', 'Cash', NULL, NULL, NULL, 'Riya', '9807654321', '41700', '05/07/2024'),
(3, 'S54301', 'P1897674', 'Cash', NULL, NULL, NULL, 'Harsh', '9876543210', '63800', '05/07/2024'),
(4, 'S33535', 'P3327220', 'Cash', NULL, NULL, NULL, '', '', '7772', ''),
(5, 'S33535', 'P9318953', 'Cash', NULL, NULL, NULL, '', '', '7772', ''),
(6, 'S43130', 'P2478648', 'Cash', NULL, NULL, NULL, '', '', '6960', ''),
(7, 'S43130', 'P967872', 'Cash', NULL, NULL, NULL, '', '', '7860', ''),
(8, 'S43130', 'P9784772', 'Cash', NULL, NULL, NULL, '', '', '7860', ''),
(9, 'S43130', 'P8301064', 'Cash', NULL, NULL, NULL, '', '', '7860', ''),
(10, 'S43130', 'P6182437', 'Cash', NULL, NULL, NULL, '', '', '7860', ''),
(11, 'S43130', 'P978192', 'Cash', NULL, NULL, NULL, '', '', '7860', ''),
(12, 'S43130', 'P1374242', 'Cash', NULL, NULL, NULL, '', '', '7860', ''),
(13, 'S43130', 'P5655422', 'Cash', NULL, NULL, NULL, '', '', '7860', ''),
(14, 'S43130', 'P6190768', 'Cash', NULL, NULL, NULL, '', '', '7860', ''),
(15, 'S43130', 'P4877398', 'Cash', NULL, NULL, NULL, '', '', '7860', ''),
(16, 'S43130', 'P2288622', 'Cash', NULL, NULL, NULL, '', '', '7860', ''),
(17, 'S43130', 'P5563207', 'Cash', NULL, NULL, NULL, '', '', '7860', ''),
(18, 'S43130', 'P8047636', 'Cash', NULL, NULL, NULL, '', '', '7860', ''),
(19, 'S43130', 'P3934445', 'Cash', NULL, NULL, NULL, '', '', '7860', ''),
(20, 'S43130', 'P710629', 'Cash', NULL, NULL, NULL, '', '', '7860', ''),
(21, 'S43130', 'P7817428', 'Cash', NULL, NULL, NULL, '', '', '7860', ''),
(22, 'S43130', 'P6904578', 'Cash', NULL, NULL, NULL, '', '', '7860', ''),
(23, 'S43130', 'P110155', 'Cash', NULL, NULL, NULL, '', '', '7860', ''),
(24, 'S43130', 'P6630607', 'Cash', NULL, NULL, NULL, '', '', '7860', ''),
(25, 'S54301', 'P743696', 'Cash', NULL, NULL, NULL, 'Test', '772197749749', '1160', '05/07/2024'),
(26, 'S54301', 'P4809561', 'Cash', NULL, NULL, NULL, 'Test', '772197749749', '1160', '05/07/2024'),
(27, 'S43130', 'P1419876', 'Cash', NULL, NULL, NULL, '', '', '7860', ''),
(28, 'S43130', 'P9551779', 'Cash', NULL, NULL, NULL, '', '', '7860', ''),
(29, 'S43130', 'P2703998', 'Cash', NULL, NULL, NULL, '', '', '7860', ''),
(30, 'S42177', 'P629280', 'Cash', NULL, NULL, NULL, 'sdsd', '02323232', '1', '05/01/2024'),
(31, 'S42177', 'P5178531', 'Cash', NULL, NULL, NULL, 'Dekila', '678901234', '5800', '05/07/2024'),
(32, 'S54301', 'P5787600', 'Cash', NULL, NULL, NULL, 'Riya', '0987654321', '11600', '05/07/2024'),
(33, 'S43280', 'P1194309', 'Cash', NULL, NULL, NULL, 'Siri', '8688484098', '8700', '05/09/2024'),
(34, 'S3787', 'P1570540', 'Cash', NULL, NULL, NULL, '', '', '320', ''),
(35, 'S54301', 'P1431402', 'Cash', NULL, NULL, NULL, 'test ', '7457575', '5800', '05/21/2024'),
(36, 'S32301', 'P350391', 'Cash', NULL, NULL, NULL, 'ravi', '445246543', '3480', '05/16/2024');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `form` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `note` varchar(1000) NOT NULL,
  `qnty` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `form`, `unit`, `note`, `qnty`) VALUES
(1, '1', 'Tab 10', '10 Tab in Strip', 10),
(2, '1', 'Tab 1', '1 Tab', 1),
(3, '1', '1:5', '5 Tablets in 1 Strip', 5),
(4, '1', '1:10', '10 tab in strip', 10);

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
(17, 'Eye Ointment');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(14) NOT NULL,
  `em_id` varchar(64) DEFAULT NULL,
  `em_name` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `em_role` enum('SALESMAN','ADMIN','MANAGER') NOT NULL DEFAULT 'SALESMAN',
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

INSERT INTO `user` (`id`, `em_id`, `em_name`, `email`, `password`, `em_role`, `em_contact`, `em_address`, `em_image`, `em_details`, `status`, `em_entrydate`, `em_ip`, `store`) VALUES
(24, 'U392', 'nawjesh', 'admin@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'ADMIN', '01723177901', 'egrvrevge rgret', 'U392.jpeg', 'erer treter r gefgfdfg dfs', 'ACTIVE', '0', '2406:b400:b1:924f:7c3f:57bf:7e54:601f', '78'),
(25, 'U134', 'Nawjesh', 'manager@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'MANAGER', '01723177901', 'Kolabagan', 'U134.jpg', 'Nawjesh jahan soyeb', 'ACTIVE', '0', '::1', '67'),
(26, 'U310', 'Nawjesh', 'salesman@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'SALESMAN', '01723177901', 'egrvrevge rgret', NULL, 'dfgfdgfdg fdg df', 'ACTIVE', '0', '27.147.206.105', '70'),
(29, 'U450', 'Sirisha', 'sirishatandra25@gmail.com', '79a7ee8717ed99779b4b8f1fd17901a7f5d8ac53', 'SALESMAN', '6309315928', 'odf colony', NULL, '', 'ACTIVE', '0', '2406:b400:d4:42eb:d414:8b8:5521:ddfa', '70'),
(31, 'U433', 'chandraMICU', 'chandra@gmail.com', '063262e2cc54e744ac02065457e908245e9def90', 'SALESMAN', '8888888888', 'chandanagar hyd', NULL, 'Nil', 'ACTIVE', '1727827200', '2406:b400:d4:fda4:e98e:8270:2752:cf29', '67'),
(32, 'U458', 'Harii NICU', 'hari@gmail.com', 'bf9eb3e86b45b7d91cb44a1b69185ab0e3819527', 'SALESMAN', '9999999999', 'sangareddy', NULL, 'Nil', 'ACTIVE', '1727827200', '61.1.246.194', '70'),
(34, 'U498', 'krishna SICU', 'krishna@gmail.com', 'd4b3e6686542176eec5966b37719decab1b9b4c4', 'SALESMAN', '7896547890', 'sangareddy', NULL, '', 'ACTIVE', '1727827200', '2406:b400:d4:6303:b1b6:298c:2460:7ff7', '68'),
(53, 'E418', 'Misha', 'misha@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'SALESMAN', '4545454545', '71/75, Mint Road,kumtha Street, Opp. Shiv Stationery, Fort', 'E418.jpg', '', 'ACTIVE', '1727827200', '103.123.38.55', '67'),
(56, 'E451', 'Nitin Sharma', 'nitin@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'SALESMAN', '1234567800', 'Mohali', NULL, 'New employee with store', 'ACTIVE', '0', '103.123.38.10', '67'),
(57, 'E475', 'michael', 'michael@gmail.com', '465f749d60513e51fe9fa610fe161e35e2e33aeb', 'SALESMAN', '1234567890', 'Mohali', NULL, 'note', 'ACTIVE', '0', '49.205.122.236', ''),
(58, 'E305', 'Sai', 'sai@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'SALESMAN', '8886979282', 'JBS bus stop', NULL, 'Employee ', 'ACTIVE', '0', '117.195.244.229', '70'),
(59, 'E449', 'kiran', 'kiran@gmail.com', '7a1315973796f3193f4862341739a83e1a0623dc', 'SALESMAN', '9440758221', 'Sweekaar', NULL, 'Employee ', 'ACTIVE', '0', '61.1.243.158', '70'),
(62, 'E276', 'Tnsae', 'tnsae@gmail.com', 'e8c03ae95813d79774421495c48c5962c836d48a', 'SALESMAN', '7896547896', 'sangareddy', NULL, 'NIL', 'ACTIVE', '0', '2406:b400:b1:12f3:3da4:4af2:3526:5af5', '81'),
(63, 'E413', 'Shweta', 'shweta@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'SALESMAN', '7896541230', '510 Townsend St', 'E413.jpg', '', 'ACTIVE', '0', '2401:4900:1c6e:5333:d819:8898:2ed0:b603', '70'),
(64, 'E218', 'Harsh', 'harsh@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'SALESMAN', '9517532840', 'Mohali sector 77', 'E218.jpg', 'Sales Man Active Employee', 'ACTIVE', '1717545600', '2401:4900:1c2b:ab17:c1ba:765d:37d6:534', '82');

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
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounts_report`
--
ALTER TABLE `accounts_report`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `adjustment_tble`
--
ALTER TABLE `adjustment_tble`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `bank_id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `closing`
--
ALTER TABLE `closing`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `closing_tble`
--
ALTER TABLE `closing_tble`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `customer_ledger`
--
ALTER TABLE `customer_ledger`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `direct_approve`
--
ALTER TABLE `direct_approve`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `grn`
--
ALTER TABLE `grn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `gst`
--
ALTER TABLE `gst`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `hospital`
--
ALTER TABLE `hospital`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=874;

--
-- AUTO_INCREMENT for table `manufacturer`
--
ALTER TABLE `manufacturer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `medication`
--
ALTER TABLE `medication`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine`
--
ALTER TABLE `medicine`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `medicine_mata`
--
ALTER TABLE `medicine_mata`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `meta_grn`
--
ALTER TABLE `meta_grn`
  MODIFY `idd` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `police`
--
ALTER TABLE `police`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `purchase_history`
--
ALTER TABLE `purchase_history`
  MODIFY `ph_id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `purchase_return`
--
ALTER TABLE `purchase_return`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reverse_stock`
--
ALTER TABLE `reverse_stock`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `sales_details`
--
ALTER TABLE `sales_details`
  MODIFY `sd_id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `sales_return`
--
ALTER TABLE `sales_return`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales_return_details`
--
ALTER TABLE `sales_return_details`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_request`
--
ALTER TABLE `stock_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stock_transfer`
--
ALTER TABLE `stock_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stock_transfer_history`
--
ALTER TABLE `stock_transfer_history`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `store_medicine_mata`
--
ALTER TABLE `store_medicine_mata`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `supplier_ledger`
--
ALTER TABLE `supplier_ledger`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `supplier_product`
--
ALTER TABLE `supplier_product`
  MODIFY `sp_id` int(14) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supp_account`
--
ALTER TABLE `supp_account`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `supp_payment`
--
ALTER TABLE `supp_payment`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `unit_form`
--
ALTER TABLE `unit_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
