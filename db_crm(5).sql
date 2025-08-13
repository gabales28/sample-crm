-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2025 at 09:44 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbdeals`
--

CREATE TABLE `tbdeals` (
  `lead_id` int(250) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `title` varchar(250) NOT NULL,
  `labels` varchar(250) NOT NULL,
  `value` varchar(250) NOT NULL,
  `customer` varchar(250) NOT NULL,
  `organization` varchar(250) NOT NULL,
  `contact_person` varchar(250) NOT NULL,
  `owner` varchar(250) NOT NULL,
  `action` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tblactivity`
--

CREATE TABLE `tblactivity` (
  `activity_id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `leadgent_user_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_charge` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `unread_admin` int(11) NOT NULL,
  `unread_leadgent` int(11) NOT NULL,
  `unread_agent` int(11) NOT NULL,
  `status_activity` int(11) NOT NULL,
  `date_added` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblactivity`
--

INSERT INTO `tblactivity` (`activity_id`, `lead_id`, `admin_id`, `leadgent_user_id`, `user_id`, `user_charge`, `remarks`, `unread_admin`, `unread_leadgent`, `unread_agent`, `status_activity`, `date_added`) VALUES
(1, 0, 0, 2, 0, 'Admin Nimbus', 'You have been given the task of 7 leads.', 0, 0, 0, 2, '2025-05-09 00:06:31'),
(2, 0, 1, 0, 3, 'Jessica Dahkno', 'Agent have been given the task of 5 leads.', 0, 0, 0, 2, '2025-05-09 00:07:06'),
(3, 0, 1, 0, 0, 'Kim  Brown', 'was logged in on CRM.', 0, 0, 0, 3, '2025-05-09 00:07:34'),
(4, 1, 1, 0, 0, 'Kim  Brown', 'Updated Lead Task', 0, 0, 0, 0, '2025-05-09 00:08:21'),
(5, 0, 1, 0, 0, 'Catalea Collins', 'was logged in on CRM.', 0, 0, 0, 3, '2025-05-09 00:09:58'),
(6, 6, 1, 0, 0, 'Jessica Dahkno', 'Updated Lead', 0, 0, 0, 0, '2025-05-09 00:10:23'),
(7, 5, 1, 0, 0, 'Jessica Dahkno', 'Updated Lead', 0, 0, 0, 0, '2025-05-09 00:10:38'),
(8, 0, 1, 0, 4, 'Jessica Dahkno', 'Agent have been given the task of 2 leads.', 0, 0, 1, 2, '2025-05-09 00:10:57'),
(9, 5, 1, 0, 0, 'Catalea Collins', 'Updated Lead Task', 0, 0, 0, 0, '2025-05-09 00:11:50'),
(10, 5, 1, 0, 0, 'Jessica Dahkno', 'Pipe and Sold Recyled Leads', 0, 0, 0, 6, '2025-05-09 00:13:03'),
(11, 0, 1, 0, 4, 'Jessica Dahkno', 'Agent have been given the task of 4 leads.', 0, 0, 1, 2, '2025-05-09 00:51:27'),
(12, 0, 1, 0, 0, 'Kim  Brown', 'was logged in on CRM.', 0, 0, 0, 3, '2025-05-09 16:25:20'),
(13, 7, 1, 0, 0, 'Kim  Brown', 'Updated Lead Task', 0, 0, 0, 0, '2025-05-09 16:51:42'),
(14, 7, 1, 0, 0, 'Kim  Brown', 'Updated Lead Task', 0, 0, 0, 0, '2025-05-09 17:20:21'),
(15, 7, 1, 2, 0, 'Kim  Brown', 'Added Remark', 0, 0, 0, 0, '2025-05-09 17:21:34'),
(16, 0, 1, 0, 0, 'Jessica Dahkno', 'was logged in on CRM.', 0, 0, 0, 3, '2025-05-09 17:30:37'),
(17, 8, 1, 0, 0, 'Jessica Dahkno', 'Added Lead', 0, 0, 0, 0, '2025-05-09 17:31:05'),
(18, 8, 1, 0, 0, 'Jessica Dahkno', 'Updated Lead', 0, 0, 0, 0, '2025-05-09 17:31:20'),
(19, 0, 1, 0, 3, 'Jessica Dahkno', 'Agent have been given the task of 1 leads.', 0, 0, 0, 2, '2025-05-09 17:31:37'),
(20, 7, 1, 0, 0, 'Kim  Brown', 'Updated Lead Task', 0, 0, 0, 0, '2025-05-09 17:34:04'),
(21, 8, 1, 0, 0, 'Kim  Brown', 'Updated Lead Task', 0, 0, 0, 0, '2025-05-09 17:34:32'),
(22, 0, 1, 0, 0, 'Kim  Brown', 'was logged in on CRM.', 0, 0, 0, 3, '2025-05-09 17:42:29'),
(23, 7, 1, 0, 0, 'Kim  Brown', 'Updated Lead Task', 0, 0, 0, 0, '2025-05-09 17:45:04'),
(24, 1, 1, 0, 0, 'Jessica Dahkno', 'Updated Lead', 0, 0, 0, 0, '2025-05-09 18:12:07'),
(25, 7, 0, 0, 3, 'Admin Nimbus', 'Updated Payment', 0, 0, 0, 0, '2025-05-09 18:32:01'),
(26, 7, 0, 0, 3, 'Admin Nimbus', 'Updated Payment', 0, 0, 0, 0, '2025-05-09 18:32:31'),
(27, 7, 0, 0, 3, 'Admin Nimbus', 'Updated Payment', 0, 0, 0, 0, '2025-05-09 18:32:43'),
(28, 8, 1, 0, 0, 'Kim  Brown', 'Updated Lead Task', 0, 0, 0, 0, '2025-05-09 18:35:56'),
(29, 8, 0, 0, 3, 'Admin Nimbus', 'Updated Payment', 0, 0, 0, 0, '2025-05-09 18:36:43'),
(30, 0, 1, 0, 0, 'Jessica Dahkno', 'was logged in on CRM.', 0, 0, 0, 3, '2025-05-09 18:39:40'),
(31, 8, 1, 2, 0, 'Kim  Brown', 'Added Remark', 0, 1, 0, 0, '2025-05-09 19:32:02'),
(32, 7, 0, 2, 3, 'Admin Nimbus', 'Updated Lead', 0, 1, 1, 0, '2025-05-09 19:37:42'),
(33, 7, 0, 2, 3, 'Admin Nimbus', 'Updated Lead', 0, 1, 1, 0, '2025-05-09 19:41:10');

-- --------------------------------------------------------

--
-- Table structure for table `tblappointment`
--

CREATE TABLE `tblappointment` (
  `appointment_id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `appointment_status` varchar(255) NOT NULL,
  `appointment_remarks` varchar(255) NOT NULL,
  `appointment_schedule` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tblassign_agent`
--

CREATE TABLE `tblassign_agent` (
  `agent_task_id` int(11) NOT NULL,
  `leadgent_task_id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `leadgent_user_id` int(11) NOT NULL,
  `priority` varchar(255) NOT NULL,
  `agent_lead_status` varchar(255) NOT NULL,
  `status_assign` varchar(255) NOT NULL,
  `remarks_agent` text NOT NULL,
  `agent_date_assigned` timestamp NULL DEFAULT NULL,
  `date_closed` timestamp NOT NULL DEFAULT current_timestamp(),
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `services_status` varchar(255) NOT NULL,
  `service_purchased` varchar(255) NOT NULL,
  `agent_remarks` varchar(255) NOT NULL,
  `agent_priority` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL,
  `additional_book` varchar(255) NOT NULL,
  `pitched_price` varchar(255) NOT NULL,
  `pitched_price_marketing` varchar(255) NOT NULL,
  `pitched_price_packages` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `recording` varchar(255) NOT NULL,
  `lead_assign` int(11) NOT NULL,
  `agent_trash_lead` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblassign_agent`
--

INSERT INTO `tblassign_agent` (`agent_task_id`, `leadgent_task_id`, `lead_id`, `user_id`, `leadgent_user_id`, `priority`, `agent_lead_status`, `status_assign`, `remarks_agent`, `agent_date_assigned`, `date_closed`, `date`, `services_status`, `service_purchased`, `agent_remarks`, `agent_priority`, `note`, `additional_book`, `pitched_price`, `pitched_price_marketing`, `pitched_price_packages`, `amount`, `payment_status`, `file_name`, `recording`, `lead_assign`, `agent_trash_lead`) VALUES
(1, 1, 1, 3, 2, 'Pending', '', 'Not yet open', '', '2025-05-09 00:07:05', '2025-05-09 00:07:05', '2025-05-09 00:07:05', 'Publishing', 'Pawn', 'Completed', 'Closed', '', '', '6', '0', '0', '55', 'Initial payment', '', 'test', 0, 2),
(2, 2, 2, 3, 2, 'Pending', '', 'Not yet open', '', '2025-05-09 00:07:05', '2025-05-09 00:07:05', '2025-05-09 00:07:05', '', '', '', '', '', '', '0', '0', '0', '', '', '', '', 0, 2),
(3, 3, 3, 3, 2, 'Pending', '', 'Not yet open', '', '2025-05-09 00:07:05', '2025-05-09 00:07:05', '2025-05-09 00:07:05', '', '', '', '', '', '', '0', '0', '0', '', '', '', '', 0, 2),
(4, 4, 4, 3, 2, 'Pending', '', 'Not yet open', '', '2025-05-09 00:07:05', '2025-05-09 00:07:05', '2025-05-09 00:07:05', '', '', '', '', '', '', '0', '0', '0', '', '', '', '', 0, 2),
(5, 7, 7, 3, 2, 'Pending', '', 'Not yet open', '', '2025-05-09 00:07:05', '2025-05-09 00:07:05', '2025-05-09 00:07:05', 'Publishing', 'test', 'Completed', 'Closed', '', '', '13', '0', '0', '22', 'Initial payment', '', 'test', 0, 0),
(6, 5, 5, 4, 2, 'Pending', '', 'Not yet open', '', '2025-05-09 00:10:57', '2025-05-09 00:10:57', '2025-05-09 00:10:57', 'Publishing', 'test', 'Completed', 'Closed', '', '', '2452', '0', '0', '2452.00', 'Full payment', '', 'tes', 2, 0),
(7, 6, 6, 4, 2, 'Pending', '', 'Not yet open', '', '2025-05-09 00:10:57', '2025-05-09 00:10:57', '2025-05-09 00:10:57', '', '', '', '', '', '', '0', '0', '0', '', '', '', '', 0, 0),
(8, 1, 1, 4, 2, 'Pending', '', 'Not yet open', '', '2025-05-09 00:51:27', '2025-05-09 00:51:27', '2025-05-09 00:51:27', 'Publishing', 'Pawn', 'Completed', 'Closed', '', '', '6', '0', '0', '55', 'Initial payment', '', 'test', 0, 0),
(9, 2, 2, 4, 2, 'Pending', '', 'Not yet open', '', '2025-05-09 00:51:27', '2025-05-09 00:51:27', '2025-05-09 00:51:27', '', '', '', '', '', '', '0', '0', '0', '', '', '', '', 0, 0),
(10, 3, 3, 4, 2, 'Pending', '', 'Not yet open', '', '2025-05-09 00:51:27', '2025-05-09 00:51:27', '2025-05-09 00:51:27', '', '', '', '', '', '', '0', '0', '0', '', '', '', '', 0, 0),
(11, 4, 4, 4, 2, 'Pending', '', 'Not yet open', '', '2025-05-09 00:51:27', '2025-05-09 00:51:27', '2025-05-09 00:51:27', '', '', '', '', '', '', '0', '0', '0', '', '', '', '', 0, 0),
(12, 8, 8, 3, 2, 'Pending', '', 'Not yet open', '', '2025-05-09 17:31:37', '2025-05-09 17:31:37', '2025-05-09 17:31:37', 'Marketing', 'test', 'Completed', 'Closed', '', '', '444', '0', '0', '444', 'Initial payment', '', 'test', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblassign_agent_leadgent`
--

CREATE TABLE `tblassign_agent_leadgent` (
  `agent_leadgent_id` int(11) NOT NULL,
  `agent_user_id` varchar(255) NOT NULL,
  `leadgent_user_id` varchar(255) NOT NULL,
  `date_assigned` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblassign_agent_leadgent`
--

INSERT INTO `tblassign_agent_leadgent` (`agent_leadgent_id`, `agent_user_id`, `leadgent_user_id`, `date_assigned`) VALUES
(1, '3', '2', '2025-04-11 18:09:31'),
(2, '4', '2', '2025-04-11 18:09:31'),
(3, '5', '2', '2025-05-06 16:45:42');

-- --------------------------------------------------------

--
-- Table structure for table `tblassign_leadgent`
--

CREATE TABLE `tblassign_leadgent` (
  `leadgent_task_id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `leadgent_user_id` int(11) NOT NULL,
  `status_assign` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `date_assigned` timestamp NULL DEFAULT NULL,
  `date_closed` timestamp NULL DEFAULT NULL,
  `lead_status_leadgent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblassign_leadgent`
--

INSERT INTO `tblassign_leadgent` (`leadgent_task_id`, `lead_id`, `leadgent_user_id`, `status_assign`, `remarks`, `date_assigned`, `date_closed`, `lead_status_leadgent`) VALUES
(1, 1, 2, 'Not yet open', '', '2025-05-09 00:06:31', NULL, 0),
(2, 2, 2, 'Not yet open', '', '2025-05-09 00:06:31', NULL, 0),
(3, 3, 2, 'Not yet open', '', '2025-05-09 00:06:31', NULL, 0),
(4, 4, 2, 'Not yet open', '', '2025-05-09 00:06:31', NULL, 0),
(5, 5, 2, 'Not yet open', '', '2025-05-09 00:06:31', NULL, 2),
(6, 6, 2, 'Not yet open', '', '2025-05-09 00:06:31', NULL, 0),
(7, 7, 2, 'Not yet open', '', '2025-05-09 00:06:31', NULL, 0),
(8, 8, 2, 'Not yet open', '', '2025-05-09 17:31:05', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblleads`
--

CREATE TABLE `tblleads` (
  `lead_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_created` timestamp NULL DEFAULT NULL,
  `brand_name` varchar(255) NOT NULL,
  `title` varchar(250) NOT NULL,
  `customer_name` varchar(250) NOT NULL,
  `customer_email` text NOT NULL,
  `book_link` text NOT NULL,
  `source` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `lead_value` varchar(250) NOT NULL,
  `customer_address` text NOT NULL,
  `customer_contact` text NOT NULL,
  `owner` varchar(250) NOT NULL,
  `lead_status` varchar(255) NOT NULL,
  `sales_remarks` varchar(255) NOT NULL,
  `lead_status_assign` int(11) NOT NULL,
  `lead_status_assign_leadgent` int(11) NOT NULL,
  `recycle_status` int(11) NOT NULL,
  `is_duplicate` tinyint(1) NOT NULL,
  `sold_author_status` int(11) NOT NULL,
  `return_to_lead_control` int(11) NOT NULL,
  `trash` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblleads`
--

INSERT INTO `tblleads` (`lead_id`, `user_id`, `date_created`, `brand_name`, `title`, `customer_name`, `customer_email`, `book_link`, `source`, `description`, `lead_value`, `customer_address`, `customer_contact`, `owner`, `lead_status`, `sales_remarks`, `lead_status_assign`, `lead_status_assign_leadgent`, `recycle_status`, `is_duplicate`, `sold_author_status`, `return_to_lead_control`, `trash`) VALUES
(1, 0, '2025-05-09 00:06:05', 'QQ Brand', 'Los Angeles Book', 'Steven', 'cherie@artisticview.net', 'https://www.amazon.com/Hero-Gray-Cherie-Braham/dp/194793841X', 'Website', '', '', '', '(780) 871-4210', '', 'Special Leads', 'test', 1, 1, 0, 0, 0, 0, 0),
(2, 0, '2025-05-09 00:06:06', 'QQ Brand', 'Los Angeles Book', 'Michelle Fuller', 'michellefuller8562@gmail.com', 'https://www.amazon.com/-/es/F-Michelle-Fuller-ebook/dp/B01N7SV1UX/ref=sr_1_4?__mk_es_US=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=2X50OETPZO980&keywords=Michelle+Fuller&qid=1672780898&s=books&sprefix=michelle+fuller%2Cstripbooks-intl-ship%2C310&sr=1-4', 'Website', '', '', '', '(706) 582-3206', '', 'Active Leads', '', 1, 1, 0, 0, 0, 0, 0),
(3, 0, '2025-05-09 00:06:06', 'QQ Brand', 'Los Angeles Book', 'Gunnar Sevelius', 'gsevelius@mac.com', 'https://www.amazon.com/Nine-Pillars-History-Personal-Perspective/dp/1524601845', 'Website', '', '', '', '(650) 366-4141', '', 'Active Leads', '', 1, 1, 0, 0, 0, 0, 0),
(4, 0, '2025-05-09 00:06:06', 'QQ Brand', 'Los Angeles Book', 'Anne Cattaruzza', 'anne.cattaruzza@gmail.com', 'https://www.amazon.com/Searching-Sheida/dp/1512757225', 'Website', '', '', '', '(450) 332-6850', '', 'Active Leads', '', 1, 1, 0, 0, 0, 0, 0),
(5, 0, '2025-05-09 00:06:06', '', '', 'c', '', '', '', '', '', '', '123', '', 'Active Leads', '', 0, 0, 1, 0, 0, 0, 0),
(6, 0, '2025-05-09 00:06:06', '', '', 'ee', 'ee@gmail.com', '', '', '', '', '', '', '', 'Active Leads', '', 1, 1, 0, 0, 0, 0, 0),
(7, 0, '2025-05-09 00:06:06', 'QQ Brand', 'Los Angeles Book', 'Anne Cattaruzza', 'ane.cattaruzza@gmail.com', 'https://www.amazon.com/Searching-Sheida/dp/1512757225', 'Website', '', '', '', '(450) 32-6850', '', 'Active Leads', '255 characters', 1, 1, 0, 0, 1, 0, 0),
(8, 0, '2025-05-09 17:31:05', '', '', 'test', 'test@gmail.com', '', 'Jessica Dahkno', '', '', 'test', '5555', '', 'Active Leads', '', 1, 1, 0, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblpayment_transaction_history`
--

CREATE TABLE `tblpayment_transaction_history` (
  `payment_id` int(11) NOT NULL,
  `agent_user_id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `agent_task_id` int(11) NOT NULL,
  `pitched_price` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `total_payment` varchar(255) NOT NULL,
  `balance` decimal(10,0) NOT NULL,
  `date_paid` timestamp NULL DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `additional_book` varchar(255) NOT NULL,
  `services_status` varchar(255) NOT NULL,
  `service_purchased` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `recording` varchar(255) NOT NULL,
  `agent_remarks` varchar(255) NOT NULL,
  `agent_priority` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblpayment_transaction_history`
--

INSERT INTO `tblpayment_transaction_history` (`payment_id`, `agent_user_id`, `lead_id`, `agent_task_id`, `pitched_price`, `amount`, `total_payment`, `balance`, `date_paid`, `date`, `additional_book`, `services_status`, `service_purchased`, `payment_status`, `recording`, `agent_remarks`, `agent_priority`) VALUES
(1, 3, 1, 1, '6', '55', '55', '0', NULL, '2025-05-09 00:08:21', 'test', 'Publishing', 'Pawn', 'Initial payment', 'test', 'Completed', 'Closed'),
(2, 4, 5, 6, '2452', '2452.00', '', '0', NULL, '2025-05-09 00:11:50', 'test', 'Publishing', 'test', 'Full payment', 'tes', 'Completed', 'Closed'),
(3, 3, 7, 5, '13', '22', '22', '0', '2025-05-09 18:32:43', '2025-05-09 16:51:42', 'test', 'Publishing', 'tae', 'Initial payment', 'ss', 'On Process', 'Closed'),
(4, 3, 7, 5, '555', '555', '', '0', '2025-05-09 18:32:31', '2025-05-09 17:20:21', 'tes', 'Marketing', 'test', 'Full payment', 'test', 'Completed', 'Closed'),
(5, 3, 7, 5, '1445', '55', '55', '1390', '2025-05-09 18:32:01', '2025-05-09 17:45:04', 'test', 'Marketing', 'test', 'Initial payment', 'test', 'Completed', 'Closed'),
(6, 3, 8, 12, '444', '444', '444', '0', '2025-05-09 18:36:43', '2025-05-09 18:35:56', 'test', 'Marketing', 'test', 'Initial payment', 'test', 'Completed', 'Closed');

-- --------------------------------------------------------

--
-- Table structure for table `tblrecycle_history`
--

CREATE TABLE `tblrecycle_history` (
  `recycle_id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `leadgent_user_id` int(11) NOT NULL,
  `agent_task_id` int(11) NOT NULL,
  `previous_agent` varchar(255) NOT NULL,
  `lead_gen_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `date_recycle` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblrecycle_history`
--

INSERT INTO `tblrecycle_history` (`recycle_id`, `lead_id`, `leadgent_user_id`, `agent_task_id`, `previous_agent`, `lead_gen_name`, `status`, `date_recycle`) VALUES
(1, 5, 2, 6, 'Catalea Collins', 'Jessica Dahkno', 'Park', '2025-05-09 00:13:03');

-- --------------------------------------------------------

--
-- Table structure for table `tblremarks`
--

CREATE TABLE `tblremarks` (
  `remark_id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `remark_tasks` text NOT NULL,
  `user_charge` varchar(255) NOT NULL,
  `date_remark` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblremarks`
--

INSERT INTO `tblremarks` (`remark_id`, `lead_id`, `user_id`, `remark_tasks`, `user_charge`, `date_remark`) VALUES
(1, 7, 0, 'test', 'Kim  Brown', '2025-05-09 17:21:34'),
(2, 8, 0, 'test', 'Kim  Brown', '2025-05-09 19:32:02');

-- --------------------------------------------------------

--
-- Table structure for table `tblreturn_to_lead_control`
--

CREATE TABLE `tblreturn_to_lead_control` (
  `return_to_lead_control_id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `agent_task_id` int(11) NOT NULL,
  `leadgent_user_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `previous_agent` varchar(255) NOT NULL,
  `lead_gen_name` varchar(255) NOT NULL,
  `return_status` varchar(255) NOT NULL,
  `date_return_to_lead_control` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tblsold_author`
--

CREATE TABLE `tblsold_author` (
  `sold_author_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_contact` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbltasks`
--

CREATE TABLE `tbltasks` (
  `task_id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `leadgent_user_id` int(11) NOT NULL,
  `priority` varchar(255) NOT NULL,
  `lead_status` varchar(255) NOT NULL,
  `status_assign` int(11) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `date_assigned` timestamp NULL DEFAULT NULL,
  `date_closed` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbltransaction_history`
--

CREATE TABLE `tbltransaction_history` (
  `transaction_id` int(11) NOT NULL,
  `agent_user_id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `agent_task_id` int(11) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `total_payment` varchar(255) NOT NULL,
  `last_payment` varchar(255) NOT NULL,
  `balance` decimal(10,0) NOT NULL,
  `date_paid` timestamp NULL DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `pitched_price` varchar(255) NOT NULL,
  `additional_book` varchar(255) NOT NULL,
  `recording` varchar(255) NOT NULL,
  `services_status` text NOT NULL,
  `service_purchased` varchar(255) NOT NULL,
  `agent_remarks` text NOT NULL,
  `agent_priority` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbltransaction_history`
--

INSERT INTO `tbltransaction_history` (`transaction_id`, `agent_user_id`, `lead_id`, `agent_task_id`, `payment_status`, `amount`, `total_payment`, `last_payment`, `balance`, `date_paid`, `date`, `pitched_price`, `additional_book`, `recording`, `services_status`, `service_purchased`, `agent_remarks`, `agent_priority`) VALUES
(1, 3, 1, 1, 'Initial payment', '55', '55', '', '0', NULL, '2025-05-09 00:08:21', '6', 'test', 'test', 'Publishing', 'Pawn', 'Completed', 'Closed'),
(2, 4, 5, 6, 'Full payment', '2452.00', '', '', '0', NULL, '2025-05-09 00:11:50', '2452', 'test', 'tes', 'Publishing', 'test', 'Completed', 'Closed'),
(3, 3, 7, 5, 'Initial payment', '22', '22', '', '0', NULL, '2025-05-09 16:51:42', '13', 'test', 'ss', 'Publishing', 'tae', 'On Process', 'Closed'),
(4, 3, 7, 5, 'Full payment', '555.00', '', '', '0', NULL, '2025-05-09 17:20:21', '555', 'tes', 'test', 'Marketing', 'test', 'Completed', 'Closed'),
(5, 3, 7, 5, 'Initial payment', '55', '55', '', '1390', NULL, '2025-05-09 17:45:04', '1445', 'test', 'test', 'Marketing', 'test', 'Completed', 'Closed'),
(6, 3, 8, 12, 'Initial payment', '444', '444', '', '0', NULL, '2025-05-09 18:35:56', '444', 'test', 'test', 'Marketing', 'test', 'Completed', 'Closed');

-- --------------------------------------------------------

--
-- Table structure for table `tbltrash_leads`
--

CREATE TABLE `tbltrash_leads` (
  `trash_id` int(11) NOT NULL,
  `user_remove_leads_id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `user_removed_leads` varchar(255) NOT NULL,
  `remove_date` timestamp NULL DEFAULT NULL,
  `trash_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbltrash_leads`
--

INSERT INTO `tbltrash_leads` (`trash_id`, `user_remove_leads_id`, `lead_id`, `user_removed_leads`, `remove_date`, `trash_status`) VALUES
(1, 2, 1, 'Jessica Dahkno', '2025-05-09 00:50:47', 'Restored'),
(2, 2, 2, 'Jessica Dahkno', '2025-05-09 00:50:49', 'Restored'),
(3, 2, 3, 'Jessica Dahkno', '2025-05-09 00:50:51', 'Restored'),
(4, 2, 4, 'Jessica Dahkno', '2025-05-09 00:50:54', 'Restored');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `email_add` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `quota` varchar(255) NOT NULL DEFAULT '0',
  `login_status` varchar(255) NOT NULL,
  `is_online` tinyint(1) NOT NULL DEFAULT 0,
  `attempt` int(11) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` timestamp NULL DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_login` timestamp NOT NULL DEFAULT current_timestamp(),
  `phonenumber` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`user_id`, `fname`, `lname`, `contact`, `email_add`, `username`, `password`, `usertype`, `address`, `status`, `quota`, `login_status`, `is_online`, `attempt`, `password_reset_token`, `token_expiry`, `date_created`, `date_login`, `phonenumber`) VALUES
(1, 'Admin', 'Nimbus', '(302) 551-6748', 'admin@nimbusdigitalmarketing.com', 'Nimbus', '30638fbb167fb283f0fd1faddd92029c', 'Admin', '300 Delaware Ave.\r\nSuite 210 #451', 'Active', '', '', 1, -3, NULL, NULL, '2025-05-09 18:42:39', '2025-05-09 18:42:39', '0922219661'),
(2, 'Jessica', 'Dahkno', '09222169261', 'jessicadahkno@gmail.com', 'HR Lyka', '21c7e98d240b9180f8a9b5923280740c', 'Lead Gen.', '300 Delaware Ave.\r\nSuite 210 #451', 'Active', '', '', 0, -6, NULL, NULL, '2025-05-09 18:42:33', '2025-05-09 18:39:40', '3025516748'),
(3, 'Kim ', 'Brown', '(302) 551-2884', 'kimbrown@thequippyquill.com', 'Mikey', 'ed63fc91500594c3086714f86b3001e4', 'Sales Tier 2', 'Cebu City', 'Active', '7000', '', 1, -2, 'bea87104f4ded8965ce2bc216fb2fc00380edcb9378bb0af7a20fd4332cff0b6c042bff509928e54c2a40d5062f339609acb', '2025-04-29 17:29:47', '2025-05-09 17:42:29', '2025-05-09 17:42:29', '3025512884'),
(4, 'Catalea', 'Collins', '(302) 551-2884', 'cataleacollins@thequippyquill.com', 'Teofisto', '43d3fab02bc348e1d75070c98be1efe4', 'Sales Tier 2', 'Lapu-Lapu City', 'Active', '7000', '', 1, 0, NULL, NULL, '2025-05-09 00:09:58', '2025-05-09 00:09:58', '3025512884'),
(5, 'Olivia', 'Bennett', '(302) 295-0099', 'oliviabennett@thequippyquill.com', 'Natalie', '96a349fa5e3141731d7638ac2226468b', 'Sales Trainee', 'Tipolo Mandaue City', 'Active', '3000', '', 0, 0, NULL, NULL, '2025-05-08 19:17:43', '2025-05-08 19:17:39', '3022950099'),
(6, 'Ethan', 'Carter', '(302) 295-0903', 'ethancarter@thequippyquill.com', 'Lynfel', '24770abfae60fdd99ec0cd4dfc3c1704', 'Sales Trainee', 'Cebu City', 'Active', '3000', '', 0, 0, NULL, NULL, '2025-04-04 20:48:10', '2025-04-04 18:30:17', '3022950903'),
(7, 'Zenon', 'Maru', '09222169621', 'zenonmaru@nimbusdigitalmarketing.com', 'Zen', 'bbdafa9eeaab72eb2890273eb3e3a4d1', 'Sales Trainee', 'tett', 'Active', '3500', '', 0, 0, '5247ec79fd8b879895095db4fb79426949f3efc5c9acbe8b7749a1fc5c1e4c8ef0cb5bd721cc4516d517b7f8eb6e02651deb', '2025-05-05 22:32:50', '2025-05-05 21:32:50', '2025-05-05 21:19:38', '09222169621');

-- --------------------------------------------------------

--
-- Table structure for table `tbluserlog`
--

CREATE TABLE `tbluserlog` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbluserlog`
--

INSERT INTO `tbluserlog` (`log_id`, `user_id`, `ip_address`, `log_date`) VALUES
(1, 1, '127.0.0.1', '2025-05-09 00:05:33'),
(2, 3, '127.0.0.1', '2025-05-09 00:07:34'),
(3, 4, '127.0.0.1', '2025-05-09 00:09:58'),
(4, 3, '127.0.0.1', '2025-05-09 16:25:20'),
(5, 1, '127.0.0.1', '2025-05-09 16:37:17'),
(6, 2, '127.0.0.1', '2025-05-09 17:30:37'),
(7, 3, '127.0.0.1', '2025-05-09 17:42:29'),
(8, 1, '127.0.0.1', '2025-05-09 18:14:00'),
(9, 2, '127.0.0.1', '2025-05-09 18:39:40'),
(10, 1, '127.0.0.1', '2025-05-09 18:42:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbdeals`
--
ALTER TABLE `tbdeals`
  ADD PRIMARY KEY (`lead_id`);

--
-- Indexes for table `tblactivity`
--
ALTER TABLE `tblactivity`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `tblappointment`
--
ALTER TABLE `tblappointment`
  ADD PRIMARY KEY (`appointment_id`);

--
-- Indexes for table `tblassign_agent`
--
ALTER TABLE `tblassign_agent`
  ADD PRIMARY KEY (`agent_task_id`);

--
-- Indexes for table `tblassign_agent_leadgent`
--
ALTER TABLE `tblassign_agent_leadgent`
  ADD PRIMARY KEY (`agent_leadgent_id`);

--
-- Indexes for table `tblassign_leadgent`
--
ALTER TABLE `tblassign_leadgent`
  ADD PRIMARY KEY (`leadgent_task_id`);

--
-- Indexes for table `tblleads`
--
ALTER TABLE `tblleads`
  ADD PRIMARY KEY (`lead_id`);

--
-- Indexes for table `tblpayment_transaction_history`
--
ALTER TABLE `tblpayment_transaction_history`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `tblrecycle_history`
--
ALTER TABLE `tblrecycle_history`
  ADD PRIMARY KEY (`recycle_id`);

--
-- Indexes for table `tblremarks`
--
ALTER TABLE `tblremarks`
  ADD PRIMARY KEY (`remark_id`);

--
-- Indexes for table `tblreturn_to_lead_control`
--
ALTER TABLE `tblreturn_to_lead_control`
  ADD PRIMARY KEY (`return_to_lead_control_id`);

--
-- Indexes for table `tblsold_author`
--
ALTER TABLE `tblsold_author`
  ADD PRIMARY KEY (`sold_author_id`);

--
-- Indexes for table `tbltasks`
--
ALTER TABLE `tbltasks`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `tbltransaction_history`
--
ALTER TABLE `tbltransaction_history`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `tbltrash_leads`
--
ALTER TABLE `tbltrash_leads`
  ADD PRIMARY KEY (`trash_id`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbluserlog`
--
ALTER TABLE `tbluserlog`
  ADD PRIMARY KEY (`log_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbdeals`
--
ALTER TABLE `tbdeals`
  MODIFY `lead_id` int(250) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblactivity`
--
ALTER TABLE `tblactivity`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tblappointment`
--
ALTER TABLE `tblappointment`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblassign_agent`
--
ALTER TABLE `tblassign_agent`
  MODIFY `agent_task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tblassign_agent_leadgent`
--
ALTER TABLE `tblassign_agent_leadgent`
  MODIFY `agent_leadgent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblassign_leadgent`
--
ALTER TABLE `tblassign_leadgent`
  MODIFY `leadgent_task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblleads`
--
ALTER TABLE `tblleads`
  MODIFY `lead_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblpayment_transaction_history`
--
ALTER TABLE `tblpayment_transaction_history`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblrecycle_history`
--
ALTER TABLE `tblrecycle_history`
  MODIFY `recycle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblremarks`
--
ALTER TABLE `tblremarks`
  MODIFY `remark_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblreturn_to_lead_control`
--
ALTER TABLE `tblreturn_to_lead_control`
  MODIFY `return_to_lead_control_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblsold_author`
--
ALTER TABLE `tblsold_author`
  MODIFY `sold_author_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbltasks`
--
ALTER TABLE `tbltasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbltransaction_history`
--
ALTER TABLE `tbltransaction_history`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbltrash_leads`
--
ALTER TABLE `tbltrash_leads`
  MODIFY `trash_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbluserlog`
--
ALTER TABLE `tbluserlog`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
