-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2020 at 05:23 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chavan_motors_purchase_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_11_18_075517_create_permission_tables', 1),
(4, '2019_11_18_075531_create_products_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(11, 'App\\User', 8),
(12, 'App\\User', 9),
(12, 'App\\User', 10),
(13, 'App\\User', 11),
(14, 'App\\User', 12),
(14, 'App\\User', 13),
(14, 'App\\User', 14),
(14, 'App\\User', 15),
(14, 'App\\User', 16);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'role-list', 'web', '2019-11-18 02:44:33', '2019-11-18 02:44:33'),
(2, 'role-create', 'web', '2019-11-18 02:44:34', '2019-11-18 02:44:34'),
(3, 'role-edit', 'web', '2019-11-18 02:44:34', '2019-11-18 02:44:34'),
(4, 'role-delete', 'web', '2019-11-18 02:44:34', '2019-11-18 02:44:34'),
(5, 'product-list', 'web', '2019-11-18 02:44:34', '2019-11-18 02:44:34'),
(6, 'product-create', 'web', '2019-11-18 02:44:34', '2019-11-18 02:44:34'),
(7, 'product-edit', 'web', '2019-11-18 02:44:34', '2019-11-18 02:44:34'),
(8, 'product-delete', 'web', '2019-11-18 02:44:34', '2019-11-18 02:44:34'),
(9, 'user-list', 'web', '2019-11-18 02:44:34', '2019-11-18 02:44:34'),
(10, 'user-create', 'web', '2019-11-18 02:44:34', '2019-11-18 02:44:34'),
(11, 'user-edit', 'web', '2019-11-18 02:44:34', '2019-11-18 02:44:34'),
(12, 'user-delete', 'web', '2019-11-18 02:44:34', '2019-11-18 02:44:34'),
(13, 'add_product', 'web', NULL, NULL),
(14, 'product_list', 'web', NULL, NULL),
(15, 'add_vendor', 'web', NULL, NULL),
(16, 'add_item_form', 'web', NULL, NULL),
(17, 'order_form', 'web', NULL, NULL),
(18, 'nofi_page', 'web', NULL, NULL),
(19, 'order_list', 'web', NULL, NULL),
(20, 'create_purchase_form', 'web', NULL, NULL),
(21, 'item_list', 'web', NULL, NULL),
(22, 'order_tl_today_dm', 'web', NULL, NULL),
(23, 'order_tl_today_gm', 'web', NULL, NULL),
(24, 'order_list_to_tl', 'web', NULL, NULL),
(25, 'order_utilize_form', 'web', NULL, NULL),
(26, 'vendor_to_po_dept', 'web', NULL, NULL),
(27, 'storage_list', 'web', NULL, NULL),
(28, 'add_storage_location', 'web', NULL, NULL),
(29, 'storage_location', 'web', NULL, NULL),
(30, 'get_report', 'web', NULL, NULL),
(31, 'checker_list', 'web', NULL, NULL),
(32, 'enq_location_list', 'web', NULL, NULL),
(33, 'enq_location_add', 'web', NULL, NULL),
(34, 'enq-location-edit', 'web', NULL, NULL),
(35, 'list-department', 'web', NULL, NULL),
(36, 'add-department', 'web', NULL, NULL),
(37, 'edit-department', 'web', NULL, NULL),
(38, 'delete-department', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2019-11-18 02:48:21', '2019-11-18 02:48:21'),
(11, 'Purchase Department', 'web', NULL, NULL),
(12, 'General Manager', 'web', NULL, NULL),
(13, 'Department Manager', 'web', NULL, NULL),
(14, 'Team Leader', 'web', '2019-12-02 01:39:19', '2019-12-02 01:39:19');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(23, 12),
(22, 13),
(17, 14),
(24, 14),
(25, 14),
(1, 11),
(2, 11),
(3, 11),
(4, 11),
(5, 11),
(6, 11),
(7, 11),
(8, 11),
(9, 11),
(10, 11),
(11, 11),
(12, 11),
(13, 11),
(14, 11),
(15, 11),
(16, 11),
(17, 11),
(18, 11),
(19, 11),
(20, 11),
(21, 11),
(24, 11),
(25, 11),
(26, 11),
(27, 11),
(28, 11),
(29, 11),
(30, 11),
(31, 11),
(32, 11),
(33, 11),
(34, 11),
(35, 11),
(36, 11),
(37, 11),
(38, 11),
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_approved_order`
--

CREATE TABLE `tbl_approved_order` (
  `id` int(11) NOT NULL,
  `order_id` varchar(100) DEFAULT NULL,
  `item_no` varchar(100) DEFAULT NULL,
  `item_desc` varchar(100) DEFAULT NULL,
  `order_qty` varchar(100) DEFAULT NULL,
  `received_qty` varchar(100) DEFAULT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `branch_name` varchar(100) DEFAULT NULL,
  `depart_name` varchar(100) DEFAULT NULL,
  `received_date` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `given_quntity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_approved_order`
--

INSERT INTO `tbl_approved_order` (`id`, `order_id`, `item_no`, `item_desc`, `order_qty`, `received_qty`, `user_id`, `branch_name`, `depart_name`, `received_date`, `created_at`, `updated_at`, `given_quntity`) VALUES
(1, '1', '1', 'BALL PEN', '350', '350', '8', '', '', '2020-01-12', '2020-01-12 02:48:37', '2020-01-12 02:48:37', NULL),
(2, '1', '1', 'BALL PEN', '20', '20', '12', 'Akkalkot Road', 'Sales', '2020-01-12', '2020-01-12 08:19:24', '2020-01-12 08:19:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_branch`
--

CREATE TABLE `tbl_branch` (
  `branch_id` int(11) NOT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `loc_id` varchar(255) DEFAULT NULL,
  `brand_name` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(15) DEFAULT NULL,
  `brand_head_id` int(11) DEFAULT NULL,
  `branch_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_branch_details`
--

CREATE TABLE `tbl_branch_details` (
  `id` int(11) NOT NULL,
  `branch_name` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_branch_details`
--

INSERT INTO `tbl_branch_details` (`id`, `branch_name`, `created_at`, `updated_at`) VALUES
(1, 'Akkalkot Road', NULL, NULL),
(2, 'Hotgi Road', NULL, NULL),
(3, 'Barshi Road', NULL, NULL),
(4, 'All', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_checker`
--

CREATE TABLE `tbl_checker` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `approve_id` int(11) DEFAULT NULL,
  `tl_remark` varchar(255) DEFAULT NULL,
  `return_qty` varchar(50) DEFAULT NULL,
  `purches_status` int(11) DEFAULT NULL,
  `purches_remark` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tl_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_checker`
--

INSERT INTO `tbl_checker` (`id`, `order_id`, `approve_id`, `tl_remark`, `return_qty`, `purches_status`, `purches_remark`, `created_at`, `updated_at`, `tl_id`, `status`) VALUES
(1, 1, 2, 'Return 5 qty', '5', NULL, NULL, '2020-01-12 08:48:09', '2020-01-12 08:48:09', 12, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_depart_details`
--

CREATE TABLE `tbl_depart_details` (
  `id` int(11) NOT NULL,
  `depart_name` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_depart_details`
--

INSERT INTO `tbl_depart_details` (`id`, `depart_name`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 'Sales', NULL, NULL, 0),
(2, 'Service-Workshop', NULL, NULL, 0),
(3, 'Spare Parts', NULL, NULL, 0),
(4, 'Chavan-Karmala', '2020-01-10 01:22:42', '2020-01-10 01:22:42', 0),
(5, 'Sales', '2020-01-11 02:38:09', '2020-01-11 02:48:38', 1),
(6, 'Sales', '2020-01-11 02:38:33', '2020-01-11 02:48:24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ex`
--

CREATE TABLE `tbl_ex` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mg_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_item`
--

CREATE TABLE `tbl_item` (
  `id` int(11) NOT NULL,
  `prod_type` varchar(100) NOT NULL,
  `product_grp` varchar(100) NOT NULL,
  `price` varchar(200) NOT NULL,
  `item_no` varchar(100) NOT NULL,
  `item_desc` varchar(200) NOT NULL,
  `qty` varchar(100) NOT NULL,
  `threshold_qty` varchar(100) DEFAULT NULL,
  `branch_name` varchar(100) DEFAULT NULL,
  `depart_name` varchar(100) DEFAULT NULL,
  `user_id` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_item`
--

INSERT INTO `tbl_item` (`id`, `prod_type`, `product_grp`, `price`, `item_no`, `item_desc`, `qty`, `threshold_qty`, `branch_name`, `depart_name`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'CA', 'PEN', '25', '1', 'BALL PEN', '130', '50', NULL, NULL, '8', '2020-01-10 01:29:58', '2020-01-12 08:19:24'),
(2, 'CA', 'PEN', '25', '2', 'BALL PEN', '500', '50', NULL, NULL, '8', '2020-01-10 01:30:36', '2020-01-10 01:30:36');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items_storage_loc`
--

CREATE TABLE `tbl_items_storage_loc` (
  `id` int(11) NOT NULL,
  `sl_id` varchar(100) DEFAULT NULL,
  `item_no` varchar(100) DEFAULT NULL,
  `qty` varchar(100) DEFAULT NULL,
  `inserted_date` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_location`
--

CREATE TABLE `tbl_location` (
  `loc_id` int(11) NOT NULL,
  `loc_name` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_location`
--

INSERT INTO `tbl_location` (`loc_id`, `loc_name`, `user_id`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 'CHAVAN-KARMALA', 8, '2020-01-10 01:33:34', '2020-01-10 01:33:34', 0),
(2, 'CHAVAN-KARMALA', 8, '2020-01-10 01:34:46', '2020-01-10 01:34:46', 0),
(3, 'CHAVAN-KARMALA', 8, '2020-01-10 02:09:49', '2020-01-10 02:09:49', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_storage_loc`
--

CREATE TABLE `tbl_master_storage_loc` (
  `id` int(11) NOT NULL,
  `rank_no` int(50) NOT NULL,
  `section_no` int(50) NOT NULL,
  `location` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_master_storage_loc`
--

INSERT INTO `tbl_master_storage_loc` (`id`, `rank_no`, `section_no`, `location`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 1, 21, 1, '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(2, 2, 21, 1, '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(3, 3, 21, 1, '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(4, 4, 21, 1, '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(5, 5, 21, 1, '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(6, 6, 21, 1, '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(7, 7, 21, 1, '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(8, 8, 21, 1, '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(9, 9, 21, 1, '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(10, 10, 21, 1, '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(11, 1, 1, 0, '2020-01-11 13:09:18', '2020-01-11 13:09:18', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id` int(11) NOT NULL,
  `type` varchar(200) DEFAULT NULL,
  `product_grp` varchar(50) DEFAULT NULL,
  `item_name` varchar(500) DEFAULT NULL,
  `item_no` varchar(10) DEFAULT NULL,
  `qty` varchar(20) DEFAULT NULL,
  `remark` varchar(200) DEFAULT NULL,
  `branch_name` varchar(100) DEFAULT NULL,
  `depart_name` varchar(100) DEFAULT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `inserted_date` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status_approved_by_dm` varchar(11) DEFAULT '0',
  `status_remark_by_dm` varchar(500) DEFAULT NULL,
  `status_approved_by_gm` varchar(11) DEFAULT '0',
  `status_remark_by_gm` varchar(500) DEFAULT NULL,
  `purchase_status` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `given_quntity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`id`, `type`, `product_grp`, `item_name`, `item_no`, `qty`, `remark`, `branch_name`, `depart_name`, `user_id`, `inserted_date`, `created_at`, `updated_at`, `status_approved_by_dm`, `status_remark_by_dm`, `status_approved_by_gm`, `status_remark_by_gm`, `purchase_status`, `is_active`, `given_quntity`) VALUES
(1, 'CA', 'PEN', 'BALL PEN', '1', '20', 'Ok', 'Akkalkot Road', 'Sales', '12', '2020-01-12', '2020-01-12 08:03:45', '2020-01-12 08:19:24', '1', 'Approve', '1', 'Approve', 1, 0, 20);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_utilize`
--

CREATE TABLE `tbl_order_utilize` (
  `id` int(11) NOT NULL,
  `po_id` varchar(11) DEFAULT NULL,
  `order_id` varchar(11) DEFAULT NULL,
  `user_id` varchar(11) DEFAULT NULL,
  `item_no` varchar(11) DEFAULT NULL,
  `actual_qty` varchar(11) DEFAULT NULL,
  `stock_qty` varchar(11) DEFAULT NULL,
  `used_qty` varchar(11) DEFAULT NULL,
  `remark` varchar(1000) NOT NULL,
  `inserted_date` varchar(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_categ`
--

CREATE TABLE `tbl_product_categ` (
  `id` int(11) NOT NULL,
  `product_type` varchar(200) DEFAULT NULL,
  `product_name` varchar(100) NOT NULL,
  `branch_name` varchar(100) DEFAULT NULL,
  `depart_name` varchar(100) DEFAULT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_product_categ`
--

INSERT INTO `tbl_product_categ` (`id`, `product_type`, `product_name`, `branch_name`, `depart_name`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'CA', 'PEN', NULL, NULL, NULL, '2020-01-10 01:25:28', '2020-01-10 01:25:28'),
(2, 'CA', 'PEN DRIVE 5GB', NULL, NULL, NULL, '2020-01-10 01:25:56', '2020-01-10 01:25:56'),
(3, 'CA', 'PEN', NULL, NULL, NULL, '2020-01-10 01:26:15', '2020-01-10 01:26:15'),
(4, 'CA', 'PEN DRIVE 5GB', NULL, NULL, NULL, '2020-01-10 01:26:32', '2020-01-10 01:26:32'),
(5, 'CA', 'PEN', NULL, NULL, NULL, '2020-01-10 01:26:53', '2020-01-10 01:26:53');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_order`
--

CREATE TABLE `tbl_purchase_order` (
  `id` int(11) NOT NULL,
  `po_id` varchar(11) DEFAULT NULL,
  `type` varchar(100) NOT NULL,
  `product_grp` varchar(100) NOT NULL,
  `order_id` varchar(30) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `item_no` varchar(50) DEFAULT NULL,
  `item_desc` varchar(200) DEFAULT NULL,
  `price` varchar(11) DEFAULT NULL,
  `qty` varchar(11) DEFAULT NULL,
  `remark` varchar(1000) DEFAULT NULL,
  `tl_ids` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `maker_status` int(10) DEFAULT '0',
  `maker_date` varchar(10) DEFAULT NULL,
  `checker_status` int(11) NOT NULL DEFAULT '0',
  `checker_date` varchar(11) DEFAULT NULL,
  `inserted_date` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `received_qty` varchar(20) DEFAULT NULL,
  `received_date` date DEFAULT NULL,
  `received_remark` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_purchase_order`
--

INSERT INTO `tbl_purchase_order` (`id`, `po_id`, `type`, `product_grp`, `order_id`, `vendor_id`, `item_no`, `item_desc`, `price`, `qty`, `remark`, `tl_ids`, `user_id`, `maker_status`, `maker_date`, `checker_status`, `checker_date`, `inserted_date`, `created_at`, `updated_at`, `received_qty`, `received_date`, `received_remark`) VALUES
(1, NULL, '[\"CA\"]', '[\"PEN\"]', NULL, 1, NULL, '[\"BALL PEN\\/1\"]', '[\"10\"]', '[\"50\"]', '[\"Order given\"]', NULL, 1, 0, NULL, 0, NULL, '2020-01-12', '2020-01-12 16:18:41', '2020-01-12 10:48:41', '[\"50\"]', '2020-01-12', '[\"received\"]'),
(2, NULL, '[\"CA\",\"CA\"]', '[\"PEN\",\"PEN\"]', NULL, 1, NULL, '[\"BALL PEN\\/1\",\"BALL PEN\\/2\"]', '[\"10\",\"5\"]', '[\"50\",\"25\"]', '[\"Order given\",\"take order\"]', NULL, 1, 0, NULL, 0, NULL, '2020-01-12', '2020-01-12 16:11:35', '2020-01-12 10:41:35', '[\"50\",\"25\"]', '2020-01-12', '[\"Received\",\"Received\"]');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_storage_location`
--

CREATE TABLE `tbl_storage_location` (
  `id` int(11) NOT NULL,
  `master_id` int(11) NOT NULL,
  `item_no` varchar(500) DEFAULT NULL,
  `current_qty` varchar(500) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `inserted_date` varchar(50) DEFAULT NULL,
  `created_at` varchar(11) DEFAULT NULL,
  `updated_at` varchar(11) DEFAULT NULL,
  `location` varchar(500) DEFAULT NULL,
  `box_count` varchar(50) DEFAULT NULL,
  `section_no` int(50) DEFAULT NULL,
  `rank_no` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_storage_location`
--

INSERT INTO `tbl_storage_location` (`id`, `master_id`, `item_no`, `current_qty`, `status`, `inserted_date`, `created_at`, `updated_at`, `location`, `box_count`, `section_no`, `rank_no`) VALUES
(1, 2, '2', '400', 1, '2020-01-12', '2020-01-12 ', '2020-01-12 ', NULL, NULL, NULL, NULL),
(2, 2, '1', '30', 1, '2020-01-12', '2020-01-12 ', '2020-01-12 ', NULL, NULL, NULL, NULL),
(4, 3, '2', '300', 1, '2020-01-12', '2020-01-12 ', '2020-01-12 ', NULL, NULL, NULL, NULL),
(7, 2, '2', '20', 1, '2020-01-12', '2020-01-12 ', '2020-01-12 ', NULL, NULL, NULL, NULL),
(9, 3, '2', '50', 1, '2020-01-12', '2020-01-12 ', '2020-01-12 ', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_master_storage_location`
--

CREATE TABLE `tbl_sub_master_storage_location` (
  `id` int(11) NOT NULL,
  `master_id` int(11) DEFAULT NULL,
  `section_no` int(50) DEFAULT NULL,
  `inserted_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_sub_master_storage_location`
--

INSERT INTO `tbl_sub_master_storage_location` (`id`, `master_id`, `section_no`, `inserted_date`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 1, 1, '2020-01-10', '2020-01-10 01:42:58', '2020-01-12 07:50:54', 1),
(2, 1, 2, '2020-01-10', '2020-01-10 01:42:58', '2020-01-12 07:44:57', 1),
(3, 1, 3, '2020-01-10', '2020-01-10 01:42:58', '2020-01-12 07:49:58', 1),
(4, 1, 4, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(5, 1, 5, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(6, 1, 6, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(7, 1, 7, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(8, 1, 8, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(9, 1, 9, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(10, 1, 10, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(11, 1, 11, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(12, 1, 12, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(13, 1, 13, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(14, 1, 14, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(15, 1, 15, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(16, 1, 16, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(17, 1, 17, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(18, 1, 18, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(19, 1, 19, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(20, 1, 20, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(21, 1, 21, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(22, 2, 1, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(23, 2, 2, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(24, 2, 3, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(25, 2, 4, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(26, 2, 5, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(27, 2, 6, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(28, 2, 7, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(29, 2, 8, '2020-01-10', '2020-01-10 01:42:58', '2020-01-10 01:42:58', 0),
(30, 2, 9, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(31, 2, 10, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(32, 2, 11, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(33, 2, 12, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(34, 2, 13, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(35, 2, 14, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(36, 2, 15, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(37, 2, 16, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(38, 2, 17, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(39, 2, 18, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(40, 2, 19, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(41, 2, 20, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(42, 2, 21, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(43, 3, 1, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(44, 3, 2, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(45, 3, 3, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(46, 3, 4, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(47, 3, 5, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(48, 3, 6, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(49, 3, 7, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(50, 3, 8, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(51, 3, 9, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(52, 3, 10, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(53, 3, 11, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(54, 3, 12, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(55, 3, 13, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(56, 3, 14, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(57, 3, 15, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(58, 3, 16, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(59, 3, 17, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(60, 3, 18, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(61, 3, 19, '2020-01-10', '2020-01-10 01:42:59', '2020-01-10 01:42:59', 0),
(62, 3, 20, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(63, 3, 21, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(64, 4, 1, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(65, 4, 2, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(66, 4, 3, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(67, 4, 4, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(68, 4, 5, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(69, 4, 6, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(70, 4, 7, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(71, 4, 8, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(72, 4, 9, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(73, 4, 10, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(74, 4, 11, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(75, 4, 12, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(76, 4, 13, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(77, 4, 14, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(78, 4, 15, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(79, 4, 16, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(80, 4, 17, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(81, 4, 18, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(82, 4, 19, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(83, 4, 20, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(84, 4, 21, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(85, 5, 1, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(86, 5, 2, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(87, 5, 3, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(88, 5, 4, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(89, 5, 5, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(90, 5, 6, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(91, 5, 7, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(92, 5, 8, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(93, 5, 9, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(94, 5, 10, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(95, 5, 11, '2020-01-10', '2020-01-10 01:43:00', '2020-01-10 01:43:00', 0),
(96, 5, 12, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(97, 5, 13, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(98, 5, 14, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(99, 5, 15, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(100, 5, 16, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(101, 5, 17, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(102, 5, 18, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(103, 5, 19, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(104, 5, 20, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(105, 5, 21, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(106, 6, 1, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(107, 6, 2, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(108, 6, 3, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(109, 6, 4, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(110, 6, 5, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(111, 6, 6, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(112, 6, 7, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(113, 6, 8, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(114, 6, 9, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(115, 6, 10, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(116, 6, 11, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(117, 6, 12, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(118, 6, 13, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(119, 6, 14, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(120, 6, 15, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(121, 6, 16, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(122, 6, 17, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(123, 6, 18, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(124, 6, 19, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(125, 6, 20, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(126, 6, 21, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(127, 7, 1, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(128, 7, 2, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(129, 7, 3, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(130, 7, 4, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(131, 7, 5, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(132, 7, 6, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(133, 7, 7, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(134, 7, 8, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(135, 7, 9, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(136, 7, 10, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(137, 7, 11, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(138, 7, 12, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(139, 7, 13, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(140, 7, 14, '2020-01-10', '2020-01-10 01:43:01', '2020-01-10 01:43:01', 0),
(141, 7, 15, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(142, 7, 16, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(143, 7, 17, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(144, 7, 18, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(145, 7, 19, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(146, 7, 20, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(147, 7, 21, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(148, 8, 1, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(149, 8, 2, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(150, 8, 3, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(151, 8, 4, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(152, 8, 5, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(153, 8, 6, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(154, 8, 7, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(155, 8, 8, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(156, 8, 9, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(157, 8, 10, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(158, 8, 11, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(159, 8, 12, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(160, 8, 13, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(161, 8, 14, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(162, 8, 15, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(163, 8, 16, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(164, 8, 17, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(165, 8, 18, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(166, 8, 19, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(167, 8, 20, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(168, 8, 21, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(169, 9, 1, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(170, 9, 2, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(171, 9, 3, '2020-01-10', '2020-01-10 01:43:02', '2020-01-10 01:43:02', 0),
(172, 9, 4, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(173, 9, 5, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(174, 9, 6, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(175, 9, 7, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(176, 9, 8, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(177, 9, 9, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(178, 9, 10, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(179, 9, 11, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(180, 9, 12, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(181, 9, 13, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(182, 9, 14, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(183, 9, 15, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(184, 9, 16, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(185, 9, 17, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(186, 9, 18, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(187, 9, 19, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(188, 9, 20, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(189, 9, 21, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(190, 10, 1, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(191, 10, 2, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(192, 10, 3, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(193, 10, 4, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(194, 10, 5, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(195, 10, 6, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(196, 10, 7, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(197, 10, 8, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(198, 10, 9, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(199, 10, 10, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(200, 10, 11, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(201, 10, 12, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(202, 10, 13, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(203, 10, 14, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(204, 10, 15, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(205, 10, 16, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(206, 10, 17, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(207, 10, 18, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(208, 10, 19, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(209, 10, 20, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(210, 10, 21, '2020-01-10', '2020-01-10 01:43:03', '2020-01-10 01:43:03', 0),
(211, 11, 1, '2020-01-11', '2020-01-11 13:09:18', '2020-01-11 13:09:18', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vendor`
--

CREATE TABLE `tbl_vendor` (
  `id` int(11) NOT NULL,
  `vendor_name` varchar(100) DEFAULT NULL,
  `contact_name` varchar(200) DEFAULT NULL,
  `mob_no` varchar(50) NOT NULL,
  `pan_card_no` varchar(50) NOT NULL,
  `gst_no` varchar(100) NOT NULL,
  `address` varchar(500) NOT NULL,
  `product_type` varchar(500) NOT NULL,
  `inserted_date` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_vendor`
--

INSERT INTO `tbl_vendor` (`id`, `vendor_name`, `contact_name`, `mob_no`, `pan_card_no`, `gst_no`, `address`, `product_type`, `inserted_date`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Jayant & Co', 'Jayant', '9921558359', 'abkpp5620n', '1111111', 'Pune', '[\"Perishable Product\",\"Printing Products\",\"Stationery Products\"]', '2020-01-02', 8, '2020-01-02 01:12:16', '2020-01-02 01:12:16'),
(2, 'Shridhar & Co', 'Shridhar', '9921558359', 'abkpp5620n', '222222222222', 'Solapur', '[\"Perishable Product\"]', '2020-01-02', 8, '2020-01-02 01:14:18', '2020-01-02 01:14:18'),
(3, 'JAYANT & CO', '9921558359', '9923414393', 'ABKPP5621N', 'SD231Q3', 'PUNE', '[\"CA\"]', '2020-01-10', 8, '2020-01-10 01:32:19', '2020-01-10 01:32:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `depart_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mobile_no` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `branch_name`, `depart_name`, `remember_token`, `created_at`, `updated_at`, `mobile_no`, `is_active`) VALUES
(1, 'admin', 'admin@iping.in', NULL, '$2y$10$z09jVdIbEA9joLPlnhzQN.eWt7EZojGJpLIVWlKjR/rObo./USQ3W', '', '', NULL, '2019-11-20 04:19:21', '2019-11-20 04:20:45', NULL, 0),
(8, 'Purchase Depart', 'purchase@iping.in', NULL, '$2y$10$WNAvfK/evhYeWiaYZVtM6OXdr2wd3rTJyVMkLcg5dG0pEVyWB0/xu', '', '', NULL, '2019-11-30 03:15:00', '2019-11-30 03:15:00', '9011909411', 0),
(10, 'GM Sales', 'gm_sales@iping.in', NULL, '$2y$10$RBtQNDCtqgpHXK6UcTiJT.eYGKpkkEdWAm2XrZszhjJk1.YVj.qfu', 'All', 'Sales', NULL, '2019-12-02 02:08:19', '2019-12-02 02:08:19', '1234567890', 0),
(11, 'SM Manager', 'sm_sales@iping.in', NULL, '$2y$10$xGzqeHw7KoH7pwA2QhWDpOVcZ3rBxH2yHSGksoaKlyE9nbsXZIgiO', 'All', 'Sales', NULL, '2019-12-02 02:09:46', '2020-01-03 10:04:53', '1111111111', 1),
(12, 'Team Leader Sales', 'tl_sales@iping.in', NULL, '$2y$10$G.h3TOnNH1t9Q5L09KJ0X.xrw5geOyA84/lWCVqIEM6SrNGwJf.ze', 'Akkalkot Road', 'Sales', NULL, '2019-12-02 02:10:29', '2019-12-02 02:10:29', '2222222222', 0),
(13, 'Team Leader Sales 2', 'tl_sales2@iping.in', NULL, '$2y$10$ymduDZBS6AiBYwhCOY5RUennXaVjw9uYaQ4PhMx87ghxm8zXV/g1m', 'Hotgi Road', 'Sales', NULL, '2019-12-02 02:10:56', '2019-12-02 02:10:56', '3333333333', 0),
(14, 'Jayant Pathak-TL', 'jpathak66@gmail.com', NULL, '$2y$10$v.0Uhmk3Zodb6HUQwvisMOUFov1MyEzWwxLoZYacu/rTWGxhUYqny', 'Akkalkot Road', 'Sales', NULL, '2020-01-01 09:59:17', '2020-01-03 10:05:50', '9921558359', 1),
(15, 'Prasad Angal', 'prasad.angal@chavanmotors.in', NULL, '$2y$10$VVKJ58Ao3KEBeOmpZBAcK.yDv1OneNXm9M2yM9Ioou94uhpC8On..', 'All', 'Sales', NULL, '2020-01-01 22:54:26', '2020-01-08 04:37:39', NULL, 1),
(16, 'Rahul Mahajan', 'rahul.mahajan@chavanmotors.com', NULL, '$2y$10$NGY.4Mgpomp1kZbU/PRIHudCstYvd0tK024EFFJk.W/iY3x2Bb.ku', 'Akkalkot Road', 'Sales', NULL, '2020-01-08 04:38:57', '2020-01-08 04:38:57', '9999999999', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `email` (`email`(191));

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_approved_order`
--
ALTER TABLE `tbl_approved_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_branch`
--
ALTER TABLE `tbl_branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `tbl_branch_details`
--
ALTER TABLE `tbl_branch_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_checker`
--
ALTER TABLE `tbl_checker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_depart_details`
--
ALTER TABLE `tbl_depart_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_ex`
--
ALTER TABLE `tbl_ex`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_item`
--
ALTER TABLE `tbl_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_items_storage_loc`
--
ALTER TABLE `tbl_items_storage_loc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_location`
--
ALTER TABLE `tbl_location`
  ADD PRIMARY KEY (`loc_id`);

--
-- Indexes for table `tbl_master_storage_loc`
--
ALTER TABLE `tbl_master_storage_loc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order_utilize`
--
ALTER TABLE `tbl_order_utilize`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_product_categ`
--
ALTER TABLE `tbl_product_categ`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_purchase_order`
--
ALTER TABLE `tbl_purchase_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_storage_location`
--
ALTER TABLE `tbl_storage_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sub_master_storage_location`
--
ALTER TABLE `tbl_sub_master_storage_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_vendor`
--
ALTER TABLE `tbl_vendor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  MODIFY `permission_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_approved_order`
--
ALTER TABLE `tbl_approved_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_branch`
--
ALTER TABLE `tbl_branch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_branch_details`
--
ALTER TABLE `tbl_branch_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_checker`
--
ALTER TABLE `tbl_checker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_depart_details`
--
ALTER TABLE `tbl_depart_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_ex`
--
ALTER TABLE `tbl_ex`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_item`
--
ALTER TABLE `tbl_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_items_storage_loc`
--
ALTER TABLE `tbl_items_storage_loc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_location`
--
ALTER TABLE `tbl_location`
  MODIFY `loc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_master_storage_loc`
--
ALTER TABLE `tbl_master_storage_loc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_order_utilize`
--
ALTER TABLE `tbl_order_utilize`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_product_categ`
--
ALTER TABLE `tbl_product_categ`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_purchase_order`
--
ALTER TABLE `tbl_purchase_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_storage_location`
--
ALTER TABLE `tbl_storage_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_sub_master_storage_location`
--
ALTER TABLE `tbl_sub_master_storage_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `tbl_vendor`
--
ALTER TABLE `tbl_vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
