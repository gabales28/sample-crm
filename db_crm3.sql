-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2025 at 03:02 AM
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
(1, 0, 0, 2, 0, 'Admin Nimbus', 'You have been given the task of 10 leads.', 0, 1, 0, 2, '2025-05-03 00:40:59'),
(2, 0, 1, 0, 3, 'Jessica Dahkno', 'Agent have been given the task of 5 leads.', 1, 0, 1, 2, '2025-05-03 00:41:16'),
(3, 1, 1, 0, 0, 'Kim  Brown', 'Updated Lead Task', 1, 0, 0, 0, '2025-05-03 00:41:43'),
(4, 2, 1, 0, 0, 'Kim  Brown', 'Updated Lead Task', 1, 0, 0, 0, '2025-05-03 00:43:11'),
(5, 3, 1, 0, 0, 'Kim  Brown', 'Updated Lead Task', 1, 0, 0, 0, '2025-05-03 00:44:07'),
(6, 4, 1, 0, 0, 'Kim  Brown', 'Updated Lead Task', 1, 0, 0, 0, '2025-05-03 00:46:05'),
(7, 0, 1, 0, 3, 'Jessica Dahkno', 'Agent have been given the task of 5 leads.', 1, 0, 1, 2, '2025-05-03 00:50:18'),
(8, 6, 1, 0, 0, 'Kim  Brown', 'Updated Lead Task', 1, 0, 0, 0, '2025-05-03 00:50:46'),
(9, 7, 1, 0, 0, 'Kim  Brown', 'Updated Lead Task', 1, 0, 0, 0, '2025-05-03 00:53:46'),
(10, 8, 1, 0, 0, 'Kim  Brown', 'Updated Lead Task', 1, 0, 0, 0, '2025-05-03 00:57:28'),
(11, 9, 1, 0, 0, 'Kim  Brown', 'Updated Lead Task', 1, 0, 0, 0, '2025-05-03 00:59:04');

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

INSERT INTO `tblassign_agent` (`agent_task_id`, `leadgent_task_id`, `lead_id`, `user_id`, `leadgent_user_id`, `priority`, `agent_lead_status`, `status_assign`, `remarks_agent`, `agent_date_assigned`, `date_closed`, `date`, `services_status`, `service_purchased`, `agent_remarks`, `agent_priority`, `note`, `pitched_price`, `pitched_price_marketing`, `pitched_price_packages`, `amount`, `payment_status`, `file_name`, `recording`, `lead_assign`, `agent_trash_lead`) VALUES
(1, 1, 1, 3, 2, 'Pending', '', 'Not yet open', '', '2025-05-03 00:41:15', '2025-05-03 00:41:16', '2025-05-03 00:41:16', '', '', '', 'Closed', '', '0.00', '0', '0', '', '', '', '', 0, 0),
(2, 2, 2, 3, 2, 'Pending', '', 'Not yet open', '', '2025-05-03 00:41:16', '2025-05-03 00:41:16', '2025-05-03 00:41:16', '', '', '', 'Closed', '', '0.00', '0', '0', '', '', '', '', 0, 0),
(3, 3, 3, 3, 2, 'Pending', '', 'Not yet open', '', '2025-05-03 00:41:16', '2025-05-03 00:41:16', '2025-05-03 00:41:16', '', '', '', 'Closed', '', '0.00', '0', '0', '', '', '', '', 0, 0),
(4, 4, 4, 3, 2, 'Pending', '', 'Not yet open', '', '2025-05-03 00:41:16', '2025-05-03 00:41:16', '2025-05-03 00:41:16', '', '', '', 'Closed', '', '0.00', '0', '0', '', '', '', '', 0, 0),
(5, 5, 5, 3, 2, 'Pending', '', 'Not yet open', '', '2025-05-03 00:41:16', '2025-05-03 00:41:16', '2025-05-03 00:41:16', '', '', '', 'Closed', '', '0.00', '0', '0', '', '', '', '', 0, 0),
(6, 6, 6, 3, 2, 'Pending', '', 'Not yet open', '', '2025-05-03 00:50:18', '2025-05-03 00:50:18', '2025-05-03 00:50:18', '', '', '', 'Closed', '', '0.00', '0', '0', '', '', '', '', 0, 0),
(7, 7, 7, 3, 2, 'Pending', '', 'Not yet open', '', '2025-05-03 00:50:18', '2025-05-03 00:50:18', '2025-05-03 00:50:18', '', '', '', 'Closed', '', '0.00', '0', '0', '', '', '', '', 0, 0),
(8, 8, 8, 3, 2, 'Pending', '', 'Not yet open', '', '2025-05-03 00:50:18', '2025-05-03 00:50:18', '2025-05-03 00:50:18', 'Package', 'tedst', '', 'Closed', '', '5000', '0', '0', '5000', 'Initial payment', '', 'test', 0, 0),
(9, 9, 9, 3, 2, 'Pending', '', 'Not yet open', '', '2025-05-03 00:50:18', '2025-05-03 00:50:18', '2025-05-03 00:50:18', 'Publishing', 'rfsdgdsg', 'On Process', 'Closed', '', '3000', '0', '0', '1000', 'Initial payment', '', 'test', 0, 0),
(10, 10, 10, 3, 2, 'Pending', '', 'Not yet open', '', '2025-05-03 00:50:18', '2025-05-03 00:50:18', '2025-05-03 00:50:18', '', '', '', '', '', '0', '0', '0', '', '', '', '', 0, 0);

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
(2, '4', '2', '2025-04-11 18:09:31');

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
(1, 1, 2, 'Not yet open', '', '2025-05-03 00:40:59', NULL, 0),
(2, 2, 2, 'Not yet open', '', '2025-05-03 00:40:59', NULL, 0),
(3, 3, 2, 'Not yet open', '', '2025-05-03 00:40:59', NULL, 0),
(4, 4, 2, 'Not yet open', '', '2025-05-03 00:40:59', NULL, 0),
(5, 5, 2, 'Not yet open', '', '2025-05-03 00:40:59', NULL, 0),
(6, 6, 2, 'Not yet open', '', '2025-05-03 00:40:59', NULL, 0),
(7, 7, 2, 'Not yet open', '', '2025-05-03 00:40:59', NULL, 0),
(8, 8, 2, 'Not yet open', '', '2025-05-03 00:40:59', NULL, 0),
(9, 9, 2, 'Not yet open', '', '2025-05-03 00:40:59', NULL, 0),
(10, 10, 2, 'Not yet open', '', '2025-05-03 00:40:59', NULL, 0);

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

INSERT INTO `tblleads` (`lead_id`, `user_id`, `date_created`, `brand_name`, `title`, `customer_name`, `customer_email`, `book_link`, `source`, `description`, `lead_value`, `customer_address`, `customer_contact`, `owner`, `lead_status`, `lead_status_assign`, `lead_status_assign_leadgent`, `recycle_status`, `is_duplicate`, `sold_author_status`, `return_to_lead_control`, `trash`) VALUES
(1, 0, '2025-05-03 00:40:45', 'QQ Brand', 'Los Angeles Book', 'Steven', 'cherie@artisticview.net', 'https://www.amazon.com/Hero-Gray-Cherie-Braham/dp/194793841X', 'Website', '', '', '', '(780) 871-4210', '', 'Active Leads', 1, 1, 0, 0, 0, 0, 0),
(2, 0, '2025-05-03 00:40:45', 'QQ Brand', 'Los Angeles Book', 'Michelle Fuller', 'michellefuller8562@gmail.com', 'https://www.amazon.com/-/es/F-Michelle-Fuller-ebook/dp/B01N7SV1UX/ref=sr_1_4?__mk_es_US=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=2X50OETPZO980&keywords=Michelle+Fuller&qid=1672780898&s=books&sprefix=michelle+fuller%2Cstripbooks-intl-ship%2C310&sr=1-4', 'Website', '', '', '', '(706) 582-3206', '', 'Active Leads', 1, 1, 0, 0, 0, 0, 0),
(3, 0, '2025-05-03 00:40:45', 'QQ Brand', 'Los Angeles Book', 'Gunnar Sevelius', 'gsevelius@mac.com', 'https://www.amazon.com/Nine-Pillars-History-Personal-Perspective/dp/1524601845', 'Website', '', '', '', '(650) 366-4141', '', 'Active Leads', 1, 1, 0, 0, 0, 0, 0),
(4, 0, '2025-05-03 00:40:45', 'QQ Brand', 'Los Angeles Book', 'Anne Cattaruzza', 'anne.cattaruzza@gmail.com', 'https://www.amazon.com/Searching-Sheida/dp/1512757225', 'Website', '', '', '', '(450) 332-6850', '', 'Active Leads', 1, 1, 0, 0, 0, 0, 0),
(5, 0, '2025-05-03 00:40:45', '', '', 'David Holcombe', 'daniho402@gmail.com', 'https://www.amazon.in/Why-All-Way-Fulton-Louisiana/dp/1524617776', '', '', '', '', '218 542 9790', '', 'Active Leads', 1, 1, 0, 0, 0, 0, 0),
(6, 0, '2025-05-03 00:40:45', '', '', 'LaKeatha Hooker', 'lthooker0004@gmail.com', 'https://www.amazon.com/Bio-Emotions-LaKeatha-Hooker/dp/1524603511', '', '', '', '', '(806) 300-2253', '', 'Active Leads', 1, 1, 0, 0, 0, 0, 0),
(7, 0, '2025-05-03 00:40:45', '', '', 'Cherie Braham', 'cherie@artisticview.net', 'https://www.amazon.com/Hero-Gray-Cherie-Braham/dp/194793841X', '', '', '', '', '(780) 871-4210', '', 'Active Leads', 1, 1, 0, 0, 0, 0, 0),
(8, 0, '2025-05-03 00:40:45', '', '', 'Ellen Weinstein', 'weinsteinellen@yahoo.com', 'https://www.amazon.co.uk/Mom-Just-Shut-Watch-Game-ebook/dp/B07958SYQZ/ref=sr_1_1?crid=2SJ0KJ04COUYU&keywords=Ellen+Weinstein&qid=1672779580&s=digital-text&sprefix=ellen+weinstein%2Cdigital-text%2C639&sr=1-1', '', '', '', '', '(631) 277-1235', '', 'Active Leads', 1, 1, 0, 0, 0, 0, 0),
(9, 0, '2025-05-03 00:40:45', '', '', 'William Faulhaber', 'billfaulhabersr@bellsouth.net', 'https://www.amazon.com/Unconventional-Lifetime-Journey-Bill-Faulhaber/dp/1532002645', '', '', '', '', '(561) 848-7416', '', 'Active Leads', 1, 1, 0, 0, 0, 0, 0),
(10, 0, '2025-05-03 00:40:45', '', '', 'Lewis Pope', 'jamaal2133@gmail.com', 'https://www.amazon.com/YOUNG-BLACK-DANGEROUS-LEWIS-POPE/dp/1491796308', '', '', '', '', '(786) 970-1222', '', 'Active Leads', 1, 1, 0, 0, 0, 0, 0),
(11, 0, '2025-05-03 00:40:45', '', '', 'Oscar Avant', 'oavant@verizon.net', 'https://www.amazon.com/Lee-Street-School-Community-1925/dp/1512740756', '', '', '', '', '(301) 421-1331', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(12, 0, '2025-05-03 00:40:45', '', '', 'Yury Vasiliev', 'yurvas2907@gmail.com', 'https://www.amazon.com/Saga-Carus-Yury-Vasiliev/dp/1490771425', '', '', '', '', '(902) 497-3082', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(13, 0, '2025-05-03 00:40:46', '', '', 'Jane G. Knight', 'jgkconsult@aol.com', 'https://www.amazon.com/Clarity-over-Coffee-Jake-Knight/dp/1512762199', '', '', '', '', '(256) 350-2643', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(14, 0, '2025-05-03 00:40:46', '', '', 'Vicky Lyn Ashby', 'vldashby@gmail.com', 'https://www.amazon.com/Colors-Heart-Vicky-Lyn-Ashby/dp/1524607754', '', '', '', '', '1 340-692-2573', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(15, 0, '2025-05-03 00:40:46', '', '', 'Yvonne Lee Wilson', 'drywilson@gmail.com', 'https://www.amazon.com/Rise-Fall-Women-Ministry-Journal/dp/1504985427', '', '', '', '', '(312) 882-3180', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(16, 0, '2025-05-03 00:40:46', '', '', 'Queen Hayes', 'queenhayes@rocketmail.com', 'https://www.amazon.com/Abused-But-Broken-Queen-Hayes/dp/1732490546', '', '', '', '', '(478) 228-3714', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(17, 0, '2025-05-03 00:40:46', '', '', 'Patty Stansell', 'patty_stansell@aol.com', 'https://www.amazon.com/Ladies-Lancaster-County-Patty-Stansell/dp/1512750573', '', '', '', '', '(541) 791-7766', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(18, 0, '2025-05-03 00:40:46', '', '', 'Kim A. March', 'kimamarch94@gmail.com', 'https://www.amazon.com/Love-Comes-Full-Circle-March-ebook/dp/B07ZSJ1KXH/ref=sr_1_1?crid=2QK0PYH9MERQX&keywords=Love+Comes+Full+Circle&qid=1673645575&sprefix=love+comes+full+circle%2Caps%2C292&sr=8-1', '', '', '', '', '(843) 802-4348, (843) 715-3140, (843) 341-2824, (334) 758-3238, (617) 447-8650', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(19, 0, '2025-05-03 00:40:46', '', '', 'Geraldine P. Davis', 'gdavis8080@gmail.com', 'https://www.amazon.com/Spite-Color-Plantations-White-House/dp/1462720722', '', '', '', '', '(478) 302-5068', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(20, 0, '2025-05-03 00:40:46', '', '', 'Sherry Keeling-Greene', 'sherryjerrygreene@gmail.com', 'https://www.amazon.com/Mr-Walrus-Sherry-Keeling-Greene/dp/1524612448', '', '', '', '', '(775) 538-7372', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(21, 0, '2025-05-03 00:40:46', '', '', 'Angela Hopkins', 'angeldove4321@yahoo.com', 'https://www.amazon.com/Angela-M-Hopkins-Luna-MD-ebook/dp/B00OJ9LZS4?ref_=ast_sto_dp', '', '', '', '', '(443) 910-4751', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(22, 0, '2025-05-03 00:40:46', '', '', 'Mark Farina', 'farinadogs@sbcglobal.net', 'https://www.amazon.com/Casey-Flying-Fortress-Mark-Farina/dp/1524638331', '', '', '', '', '(708) 854-6105', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(23, 0, '2025-05-03 00:40:46', '', '', 'Eva Schmidt', 'schmidt.eva1@gmail.com', 'https://www.amazon.com/Grace-Tomorrow-Eva-Schmidt/dp/1512750166', '', '', '', '', '780-928-2574', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(24, 0, '2025-05-03 00:40:46', '', '', 'Cheryl Green', 'cagreen2271@sbcglobal.net', 'https://www.amazon.com/I-Hurt-Cry-Cheryl-Green/dp/1512756652', '', '', '', '', '203-215-6966', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(25, 0, '2025-05-03 00:40:46', '', '', 'Robert Littke', 'boblittke@yahoo.com', 'https://www.amazon.com/My-Own-Miracle-Robert-Littke/dp/1512750131', '', '', '', '', '(269) 382-0515', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(26, 0, '2025-05-03 00:40:46', '', '', 'Marjory Skidmore', 'marjoryrose@yahoo.com', 'https://www.amazon.com/Cauliflower-Denney-Boy-Marjory-Lack-Skidmore/dp/1512752460', '', '', '', '', '(816) 217-1741', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(27, 0, '2025-05-03 00:40:46', '', '', 'Clifford \"Kip\" Kolson', 'kipkolson@yahoo.com', 'https://www.amazon.com/-/es/Kip-Kolson/dp/1512755176/ref=sr_1_2?qid=1672848569&refinements=p_27%3AKip+Kolson&s=books&sr=1-2', '', '', '', '', '(949) 468-2000', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(28, 0, '2025-05-03 00:40:47', '', '', 'William Madison Jr', 'turnupyourpraiseministry@gmail.com', 'https://www.amazon.com/Stop-Dont-Buy-This-Book/dp/1524609366', '', '', '', '', '(773) 563-5880', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(29, 0, '2025-05-03 00:40:47', '', '', 'Don Xavier', 'dxavier@donxavier.com', 'https://www.amazon.com/how-Remove-Your-Success-Blockers/dp/1491795301', '', '', '', '', '(416) 626-5044', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(30, 0, '2025-05-03 00:40:47', '', '', 'Susan Essary', 'daisy_may21@hotmail.com', 'https://www.amazon.com/God-Gives-Things-Proper-Time/dp/1512777943', '', '', '', '', '(740) 393-5413', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(31, 0, '2025-05-03 00:40:47', '', '', 'Donald Knoepfle', 'dknoepfle@earthlink.net', 'https://www.amazon.com/Caribe-Dreamer-Donald-Knoepfle/dp/1524605069', '', '', '', '', '(941) 505-5712', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(32, 0, '2025-05-03 00:40:47', '', '', 'Stan Berg', 'dfamberg@gmail.com', 'https://www.amazon.com/Brandys-Unicorn-Stan-C-Berg/dp/1524609897', '', '', '', '', '(480) 940-6140', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(33, 0, '2025-05-03 00:40:47', '', '', 'Queen Lacey', 'qelblessed7@yahoo.com', 'https://www.amazon.com/Sexually-Driven-II-Queen-Lacey/dp/1524605115', '', '', '', '', '(480) 778-6877', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(34, 0, '2025-05-03 00:40:47', '', '', 'Becky Yandell', 'becky.yandell@gmail.com', 'https://www.amazon.com/WALK-THROUGH-VALLEY-Yandell-Williams/dp/1524605158', '', '', '', '', '(479) 739-7145', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(35, 0, '2025-05-03 00:40:47', '', '', 'Sheila Milam', 'smilam640@gmail.com', 'https://www.amazon.com/Redemption-Madelyne-Sheila-K-Milam/dp/1512754285', '', '', '', '', '(208) 682-2399', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(36, 0, '2025-05-03 00:40:47', '', '', 'John LaFaver SR', 'ubapreacher2@rcn.com', 'https://www.amazon.com/135-Reasons-Gods-Bible-Written/dp/1524619825', '', '', '', '', '(610) 419-8032', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(37, 0, '2025-05-03 00:40:47', '', '', 'Sue A. McLaughlin', 'sumac4676@gmail.com', 'https://www.amazon.com/High-Life-Sue-McLaughlin/dp/1491796510', '', '', '', '', '(727) 488-9655', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(38, 0, '2025-05-03 00:40:47', '', '', 'Andrew Zubinas', 'nejmazubinas@gmail.com', 'https://www.amazon.com/Forest-Lungs-Andrew-G-Zubinas/dp/1947620150', '', '', '', '', '(630) 796-5526', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(39, 0, '2025-05-03 00:40:47', '', '', 'Chuck Custer', 'chuckcuster1777@gmail.com', 'https://www.amazon.com/Now-Time/dp/1512757799', '', '', '', '', '(740) 252-9021', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(40, 0, '2025-05-03 00:40:47', '', '', 'Jerome Lucido', 'giralmo@yahoo.com', 'https://www.amazon.com/Remember-Jerome-Lucido/dp/1512749605', '', '', '', '', '(610) 435-2520', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(41, 0, '2025-05-03 00:40:47', '', '', 'Lauren Fleming', 'mafleming@suncor.com', 'https://www.amazon.com/Squirrel-Adventures-Lauren-Fleming/dp/1524650285', '', '', '', '', '(403) 813-3255', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(42, 0, '2025-05-03 00:40:47', '', '', 'Gardenia Gresham', 'jesuschrist.040@cox.net', 'https://www.amazon.com/Tavie-Goes-Kindergarten-GG-ebook/dp/B07964SWYG', '', '', '', '', '(619) 475-0277', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(43, 0, '2025-05-03 00:40:47', '', '', 'Cassandra French', 'cassandra.n.french@gmail.com', 'https://www.amazon.com/Edwina-Exquisite-Cassandra-French/dp/1512754714', '', '', '', '', '(717) 383-7801', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(44, 0, '2025-05-03 00:40:47', '', '', 'Matthew Theisen', 'mjtheim@yahoo.com', 'https://www.amazon.com/Games-Dead-Matthew-Theisen/dp/1491799951', '', '', '', '', '(605) 335-4193', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(45, 0, '2025-05-03 00:40:47', '', '', 'Gerald Jones', 'gurujones99@hotmail.com', 'https://www.amazon.com/Masquerade-Ball-Life-Therapeutic-Interactions/dp/1524614998', '', '', '', '', '(951) 788-8364', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(46, 0, '2025-05-03 00:40:47', '', '', 'Michael Loehrer', 'mloehrer@verizon.net', 'https://www.amazon.com/Hebrews-Companion-Michael-Cannon-Loehrer/dp/1512756849', '', '', '', '', '(661) 821-0183', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(47, 0, '2025-05-03 00:40:47', '', '', 'Suzanne Peters', 'suzpeters@aol.com', 'https://www.amazon.com/Sssammy-Snake-Suzanne-Peters/dp/1524621188', '', '', '', '', '(904) 940-9184', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(48, 0, '2025-05-03 00:40:47', '', '', 'Janice La Boone', 'janice.la.boone@att.net', 'https://www.amazon.com/Imperfect-Journey-Perfect-Life-Womans/dp/1532003064', '', '', '', '', '(912) 268-4013', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(49, 0, '2025-05-03 00:40:47', '', '', 'Luis Passalacqua', 'luisfpassalacqua@gmail.com', 'https://www.amazon.com/Ilumina-Te-2-Despertando-Spanish/dp/1524691003', '', '', '', '', '(787) 340-3024', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(50, 0, '2025-05-03 00:40:47', '', '', 'Thomas Faile', 'daverevelations@yahoo.com', 'https://www.amazon.com/Revelation-Faith-Thomas-David-Faile/dp/1512769711', '', '', '', '', '(980) 328-3449', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(51, 0, '2025-05-03 00:40:47', '', '', 'jimmie johnson', 'jimmiejohnson578@gmail.com', 'https://www.amazon.com/There-Some-Us-All-Collection/dp/1524619434', '', '', '', '', '(313) 629-5122', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(52, 0, '2025-05-03 00:40:47', '', '', 'Patricia Loder', 'prn6@aol.com', 'https://www.amazon.com/Journey-Begins-Hollys-Story-P-Loder/dp/1524641537', '', '', '', '', '(863) 324-7136', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(53, 0, '2025-05-03 00:40:48', '', '', 'Cynthia Hammer', 'hammercynthia42@gmail.com', 'https://www.amazon.com/Good-Case-Cynthia-W-Hammer/dp/1524642010', '', '', '', '', '(818) 307-7176', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(54, 0, '2025-05-03 00:40:48', '', '', 'Mary G. Sontag Revocable Trust', 'sontag@noemail.com', 'https://www.amazon.com/Mary-G-Sontag-ebook/dp/B07964HF1Y/ref=sr_1_1?qid=1673036468&refinements=p_27%3AMary+G.+Sontag&s=books&sr=1-1', '', '', '', '', '3157697875', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(55, 0, '2025-05-03 00:40:48', '', '', 'Mila Rechcigl', 'svu.one@gmail.com', 'https://www.amazon.com/Encyclopedia-Bohemian-Czech-American-Biography-Miloslav/dp/1524619884', '', '', '', '', '(301) 881-7222', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(56, 0, '2025-05-03 00:40:48', '', '', 'Derek Graham', 'gderek545@gmail.com', 'https://www.amazon.com/Run-Tell-Someone/dp/1524625841', '', '', '', '', '(857) 492-7684', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(57, 0, '2025-05-03 00:40:48', '', '', 'Julie Young (Bella Louise Allen)', 'julieyoung57@yahoo.com', 'https://www.amazon.com/Love-Letters-Bella-Louise-Allen/dp/1524625213', '', '', '', '', '(207) 944-7013', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(58, 0, '2025-05-03 00:40:48', '', '', 'George Evans', 'georgeevq@gmail.com', 'https://www.amazon.com/Wringles-Sniggles-Discover-George-Evans/dp/152463803X', '', '', '', '', '(707) 526-5898', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(59, 0, '2025-05-03 00:40:48', '', '', 'Rick Paulsen', 'rickpaulsen1943@gmail.com', 'https://www.amazon.com/Poems-Rick-Paulsen/dp/149077727X', '', '', '', '', '1 815-469-2071', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(60, 0, '2025-05-03 00:40:48', '', '', 'Hattie Gregory', 'genieann2@verizon.net', 'https://www.amazon.com/Love-Yourself-Before-Destroy-Blessings/dp/152464188X', '', '', '', '', '(804) 994-2721', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(61, 0, '2025-05-03 00:40:48', '', '', 'Adam Bourget', 'achampagne@nmhhss.ca', 'https://www.amazon.com/Biohazard-Lizard-Mars-Atrocious-Horrorshow/dp/1546244131', '', '', '', '', '(705) 476-4088', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(62, 0, '2025-05-03 00:40:48', '', '', 'M. Leanne Todd', 'mleannetodd@yahoo.com', 'https://www.amazon.com/Make-Way-Baby-Leanne-Todd/dp/1512768871', '', '', '', '', '409-519-0417', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(63, 0, '2025-05-03 00:40:48', '', '', 'Bruce Drake', 'rabcecjm@gmail.com', 'https://www.amazon.com/English-Bruce-Drake/dp/1524643009', '', '', '', '', '(989) 235-4480', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(64, 0, '2025-05-03 00:40:48', '', '', 'Lancelot Larsen', 'lancelot1789@yahoo.com', 'https://www.amazon.com/Sons-America-Vol-Lancelot-Larsen/dp/1532010044', '', '', '', '', '(702) 625-6785', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(65, 0, '2025-05-03 00:40:48', '', '', 'Pamela J. Patterson | Rita J. Ray', 'pamelajeanartist@yahoo.com', 'https://www.amazon.com/Color-My-Thoughts-Pamela-Patterson/dp/1524654353', '', '', '', '', '(714) 560-3367', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(66, 0, '2025-05-03 00:40:48', '', '', 'Andre Gilchrist', 'andregilchrist13@earthlink.net', 'https://www.amazon.com/Addiction-Its-Effect-Family-Unit/dp/1496965345', '', '', '', '', '(908) 685-3664', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(67, 0, '2025-05-03 00:40:48', '', '', 'Heather Hope Johnson', 'hopejohnson71@yahoo.com', 'https://www.amazon.com/Gods-Amazing-Everlasting-Love-Forgiveness/dp/1496966481', '', '', '', '', '(917) 937-6731', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(68, 0, '2025-05-03 00:40:48', '', '', 'Lisa Kopel', 'lrktangostales@gmail.com', 'https://www.amazon.com/Tangos-Tales-Lisa-Kopel-ebook/dp/B0793P98P6/ref=sr_1_1?keywords=Tango%27s+Tales+Lisa+Kopel&qid=1675898894&sr=8-1', '', '', '', '', '(978) 880-2091', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(69, 0, '2025-05-03 00:40:48', '', '', 'Juan Nabong Jr.', 'johnnynabong@yahoo.com', 'https://www.amazon.com/Starved-Delirious-Poems-Stray-Manila-ebook/dp/B0793PV25G/ref=sr_1_1?keywords=Love+Starved+Delirious+Poems+Stray+in+Manila+Juan+Nabong+Jr.&qid=1675978210&sr=8-1', '', '', '', '', '(407) 380-3059', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(70, 0, '2025-05-03 00:40:48', '', '', 'Evelyn Ryan', 'emr1160@yahoo.com', 'https://www.amazon.com/Take-Your-Power-Back-Survivors-ebook/dp/B0793P43LP/ref=sr_1_1?keywords=Take+Your+Power+Back+Evelyn+Ryan&qid=1675989194&sr=8-1', '', '', '', '', '(209) 957-9246', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(71, 0, '2025-05-03 00:40:48', '', '', 'Rod Hunt', 'hunt3607@gmail.com', 'https://www.amazon.com/Past-Forward-Faith-Love-Hunt-ebook/dp/B0793Q1CD1/ref=sr_1_1?keywords=Past+Forward+to+Faith+and+Love+Rod+Hunt&qid=1676053988&sr=8-1', '', '', '', '', '(912) 256-3607', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(72, 0, '2025-05-03 00:40:48', '', '', 'Donna Miller', 'dmiller061@columbus.rr.com', 'https://www.amazon.com/No-Math-All-Donna-Miller-ebook/dp/B0793QLN61/ref=sr_1_1?crid=9FQZNOPKXTRT&keywords=No+Math+At+All+Donna+Miller&qid=1676071235&sprefix=no+math+at+all+donna+miller%2Caps%2C726&sr=8-1', '', '', '', '', '(937) 407-7585', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(73, 0, '2025-05-03 00:40:48', '', '', 'Teresa Page', 'teresakpage@hotmail.com', 'https://www.amazon.com/My-Journey-Wholeness-Sojourn-Continues-ebook/dp/B0793PD7PV/ref=sr_1_1?crid=2IBS8FGVO2IHC&keywords=My+Journey+to+Wholeness+Teresa+Page&qid=1676309600&sprefix=my+journey+to+wholeness+teresa+page%2Caps%2C272&sr=8-1', '', '', '', '', '(910) 995-6743', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(74, 0, '2025-05-03 00:40:48', '', '', 'Pat Kennedy', 'pkennedy@kennedytank.com', 'https://www.amazon.com/Official-Indy-500-Trivia-Book/dp/1496972384/ref=sr_1_1?crid=1MIEEX9LL8DCB&keywords=The+Official+Indy+500+Trivia+Book+Pat+Kennedy&qid=1676331010&sprefix=the+official+indy+500+trivia+book+pat+kennedy%2Caps%2C281&sr=8-1', '', '', '', '', '(317) 780-3502', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(75, 0, '2025-05-03 00:40:48', '', '', 'Wayne Pope', 'waynepope35@yahoo.com', 'https://www.amazon.com/Earth-Invasion-Sgt-Wayne-Anthony-ebook/dp/B0793QGYSX/ref=sr_1_1?crid=1XUMR5VV6U8G9&keywords=Earth+Invasion+Wayne+Pope&qid=1676332225&sprefix=earth+invasion+wayne+pope%2Caps%2C279&sr=8-1', '', '', '', '', '(760) 996-0064', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(76, 0, '2025-05-03 00:40:48', '', '', 'Deloris Jones', 'deloris0002@comcast.net', 'https://www.amazon.com/My-Brother-Job-Deloris-Jones/dp/1955459274/ref=sr_1_1?crid=LUYKZXHEUKEW&keywords=My+Brother+Job+Deloris+Jones&qid=1676331815&sprefix=my+brother+job+deloris+jones%2Caps%2C290&sr=8-1', '', '', '', '', '901-751-1287', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(77, 0, '2025-05-03 00:40:48', '', '', 'William Pittard', 'pittardw@musc.edu', 'https://www.amazon.com/Well-Child-Care-Infancy-Promoting-Readiness-ebook/dp/B0793QWSZS/ref=sr_1_1?crid=1G31YTMO7VLOS&keywords=Well-Child+Care+in+Infancy+William+Pittard&qid=1676392972&sprefix=perils+of+ms.+apple+justin+jones%2Caps%2C288&sr=8-1', '', '', '', '', '(843) 766-2382', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(78, 0, '2025-05-03 00:40:48', '', '', 'Ronald Greer', 'txlottoman@gmail.com', 'https://www.amazon.com/Only-Look-Historical-Roberta-Illinois/dp/1512708976/ref=sr_1_1?crid=39RIRME77I4KI&keywords=Only+a+Look+Ronald+Greer&qid=1676422279&sprefix=only+a+look+ronald+greer%2Caps%2C279&sr=8-1', '', '', '', '', '(979) 943-1185', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(79, 0, '2025-05-03 00:40:48', '', '', 'Melinda Abersold', 'melindajabersold@gmail.com', 'https://www.amazon.com/Whispers-Night-Melinda-J-Abersold-ebook/dp/B0793QBQ92/ref=sr_1_1?keywords=Whispers+in+the+Night+Melinda+Abersold&qid=1677171302&sr=8-1', '', '', '', '', '(334) 393-2079', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(80, 0, '2025-05-03 00:40:49', '', '', 'Andrew Kovel', 'kovelandrew@yahoo.com', 'https://www.iuniverse.com/en/bookstore/bookdetails/708250-The-Dark-of-Time', '', '', '', '', '(716) 837-1590', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(81, 0, '2025-05-03 00:40:49', '', '', 'Marshall Jackson', 'marshalljackson51@hotmail.com', 'https://www.amazon.com/Long-Tragic-Journey-Intense-Prison-ebook/dp/B0793NQJMV/ref=sr_1_4?crid=1RJNVFP3ILSIY&keywords=Marshall+Jackson&qid=1689706564&s=books&sprefix=marshall+jackson%2Cstripbooks-intl-ship%2C308&sr=1-4', '', '', '', '', '(765) 617-1329', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(82, 0, '2025-05-03 00:40:49', '', '', 'Roderick Scurlock', 'rhscurlock@yahoo.com', 'https://www.authorhouse.com/en/bookstore/bookdetails/708304-Indian-Agent', '', '', '', '', '2083624447', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(83, 0, '2025-05-03 00:40:49', '', '', 'KC Duenas', 'kcers02@live.com', 'https://www.authorhouse.com/en/bookstore/bookdetails/708367-My-Mommy-Wears-Combat-Boots', '', '', '', '', '(619) 876-0038', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(84, 0, '2025-05-03 00:40:49', '', '', 'Angelo Kaltsos', 'ajkaltsos@yahoo.com', 'https://www.amazon.com/Music-You-Will-Never-Hear/dp/1491795999/ref=sr_1_5?crid=1LL2QGUCAKKEM&keywords=Angelo+Kaltsos&qid=1689708651&s=books&sprefix=angelo+kaltsos%2Cstripbooks-intl-ship%2C309&sr=1-5', '', '', '', '', '(207) 357-3094', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(85, 0, '2025-05-03 00:40:49', '', '', 'Jo Amdahl', 'crashingone55016@yahoo.com', 'https://www.amazon.com/Empire-Gold-Jeremiah-Emperor-Babylonia-ebook/dp/B08PRY6SNZ/ref=sr_1_3?keywords=Jo+Amdahl&qid=1689709649&s=books&sr=1-3', '', '', '', '', '(307) 254-5481', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(86, 0, '2025-05-03 00:40:49', '', '', 'Melvin Adams', 'melmoid@aol.com', 'https://www.authorhouse.com/en/bookstore/bookdetails/603691-Topography-of-Light', '', '', '', '', '(509) 943-1758', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(87, 0, '2025-05-03 00:40:49', '', '', 'Zain Naqvi', 'naqvinida@gmail.com', 'https://www.trafford.com/en/bookstore/bookdetails/708767-Healthy-Snacks-for-Snack-Lovers', '', '', '', '', '(289) 597-1019', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(88, 0, '2025-05-03 00:40:49', '', '', 'Prof. Donald F. Megnin PhD', 'dmegdonjul@aol.com', 'https://www.amazon.com/Sermons-Separated-Donald-F-Megnin-ebook/dp/B0793NZZR7/ref=sr_1_8?crid=4QJZZQTR0X0E&keywords=Donald+F.+Megnin&qid=1689785837&sprefix=donald+f.+megnin+%2Caps%2C360&sr=8-8', '', '', '', '', '315-396-0080', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(89, 0, '2025-05-03 00:40:49', '', '', 'Selma Calnan', 'selmablanchecalnan@yahoo.com', 'https://www.iuniverse.com/en/bookstore/bookdetails/708823-A-Water-War-in-California', '', '', '', '', '4065630009', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(90, 0, '2025-05-03 00:40:49', '', '', 'Mike Benson', 'mike@theconquerors.net', 'https://www.amazon.com/More-Than-Conqueror-Conquering-Your-ebook/dp/B0793PHT7P/ref=sr_1_2?crid=3AVA8ZZABJ1DD&keywords=Mike+Benson&qid=1689789538&sprefix=mike+benton%2Caps%2C288&sr=8-2', '', '', '', '', '(616) 299-0843', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(91, 0, '2025-05-03 00:40:49', '', '', 'Nathan Webster', 'nathan.webster@dreambigcc.org', 'https://www.amazon.com/Scared-Be-Me-Nathan-Webster-ebook/dp/B0793Q5LGC/ref=sr_1_6?crid=91LPOS75279N&keywords=Nathan+Webster&qid=1689791336&sprefix=nathan+webster%2Caps%2C295&sr=8-6', '', '', '', '', '(360) 448-7439', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(92, 0, '2025-05-03 00:40:49', '', '', 'Gloria Stark', 'snoopy@homesc.com', 'https://www.westbowpress.com/en/bookstore/bookdetails/709906-Beyond-the-Clouds', '', '', '', '', '(843) 753-3733', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(93, 0, '2025-05-03 00:40:49', '', '', 'Jerald Harmon', 'jerryh@toposandtepees.com', 'https://www.amazon.com/Days-Ages-Genesis-Question-Creations-ebook/dp/B0793P29D6/ref=sr_1_1?crid=1BGM5JGFVACX7&keywords=Days%3F+or+Ages%3F+The+Genesis+Question&qid=1689795879&sprefix=days+or+ages+the+genesis+question%2Caps%2C284&sr=8-1', '', '', '', '', '(864) 350-1131', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(94, 0, '2025-05-03 00:40:49', '', '', 'Greg Wadleigh', 'revwad@yahoo.com', 'https://www.authorhouse.com/en/bookstore/bookdetails/710032-Cleaning-the-Mirror', '', '', '', '', '(815) 319-0898', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(95, 0, '2025-05-03 00:40:49', '', '', 'Abol Danesh', 'silvergold278@gmail.com', 'https://www.trafford.com/en/bookstore/bookdetails/710108-Stars-Light-Eighth-Volume', '', '', '', '', '(401) 294-3793', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(96, 0, '2025-05-03 00:40:49', '', '', 'Natalie Mahne', 'kmahne63@gmail.com', 'https://www.westbowpress.com/en/bookstore/bookdetails/710225-Prayers-of-a-Child', '', '', '', '', '(678) 548-7938', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(97, 0, '2025-05-03 00:40:49', '', '', 'Timothy Bartlett', 'ussmanko7@gmail.com', 'https://www.amazon.com/Game-Master-Trilogy-Games-People/dp/1491870672/ref=sr_1_2?crid=28G0GYFHOZSNK&keywords=The+Game+Master+Trilogy&qid=1689872565&sprefix=the+game+master+trilogy%2Caps%2C294&sr=8-2', '', '', '', '', '(306) 782-5074', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(98, 0, '2025-05-03 00:40:49', '', '', 'Curtis Nail', 'curtn75@gmail.com', 'https://www.amazon.com/Expressions-Acorn-Curt-Nail-ebook/dp/B0793P33FM/ref=sr_1_1?crid=12SMAZWS4MDBP&keywords=Expressions+of+an+Acorn&qid=1689872877&sprefix=expressions+of+an+acorn%2Caps%2C277&sr=8-1', '', '', '', '', '(256) 774-3128', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0),
(99, 0, '2025-05-03 00:40:49', '', '', 'Gary Hood', 'brogarylh60@gmail.com', 'https://www.amazon.com/Divorce-Hurts-God-Heals-Serious-ebook/dp/B0793QYXHY/ref=sr_1_1?crid=320N1EUEKHK7R&keywords=Divorce+Hurts%2C+God+Heals&qid=1689874768&s=books&sprefix=divorce+hurts%2C+god+heals%2Cstripbooks-intl-ship%2C282&sr=1-1', '', '', '', '', '2565041103', '', 'Active Leads', 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblpitched_price`
--

CREATE TABLE `tblpitched_price` (
  `pitched_id` int(11) NOT NULL,
  `agent_user_id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `agent_task_id` int(11) NOT NULL,
  `pitched_price` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1, 'Admin', 'Nimbus', '(302) 551-6748', 'admin@nimbusdigitalmarketing.com', 'Nimbus', '30638fbb167fb283f0fd1faddd92029c', 'Admin', '300 Delaware Ave.\r\nSuite 210 #451', 'Active', '', '', 1, -3, NULL, NULL, '2025-05-02 19:31:08', '2025-05-02 19:31:08', '0922219661'),
(2, 'Jessica', 'Dahkno', '09222169261', 'jessicadahkno@gmail.com', 'HR Lyka', '21c7e98d240b9180f8a9b5923280740c', 'Lead Gen.', '300 Delaware Ave.\r\nSuite 210 #451', 'Active', '', '', 1, -6, NULL, NULL, '2025-05-02 19:34:13', '2025-05-02 19:34:13', '3025516748'),
(3, 'Kim ', 'Brown', '09222169661', 'kimbrown@thequippyquill.com', 'Mickey', 'ed63fc91500594c3086714f86b3001e4', 'Sales Tier 2', 'Cebu City', 'Active', '7000', '', 1, -1, 'bea87104f4ded8965ce2bc216fb2fc00380edcb9378bb0af7a20fd4332cff0b6c042bff509928e54c2a40d5062f339609acb', '2025-04-29 17:29:47', '2025-05-03 00:01:56', '2025-05-03 00:01:56', '09222169661'),
(4, 'Catalea', 'Collins', '(302) 551-2884', 'cataleacollins@thequippyquill.com', 'Teofisto', '43d3fab02bc348e1d75070c98be1efe4', 'Sales Tier 2', 'Lapu-Lapu City', 'Active', '7000', '', 0, 0, NULL, NULL, '2025-05-02 23:43:50', '2025-05-02 23:40:32', '3025512884'),
(5, 'Olivia', 'Bennett', '(302) 295-0099', 'oliviabennett@thequippyquill.com', 'Natalie', '96a349fa5e3141731d7638ac2226468b', 'Sales Trainee', 'Tipolo Mandaue City', 'Active', '3000', '', 0, 0, NULL, NULL, '2025-04-10 21:32:10', '2025-04-10 21:28:00', '3022950099'),
(6, 'Ethan', 'Carter', '(302) 295-0903', 'ethancarter@thequippyquill.com', 'Lynfel', '24770abfae60fdd99ec0cd4dfc3c1704', 'Sales Trainee', 'Cebu City', 'Active', '3000', '', 0, 0, NULL, NULL, '2025-04-04 20:48:10', '2025-04-04 18:30:17', '3022950903');

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
(1, 2, '127.0.0.1', '2025-04-28 16:32:29'),
(2, 3, '127.0.0.1', '2025-04-28 16:33:49'),
(3, 2, '127.0.0.1', '2025-04-28 19:44:30'),
(4, 3, '127.0.0.1', '2025-04-28 19:45:38'),
(5, 2, '127.0.0.1', '2025-04-28 21:06:14'),
(6, 3, '127.0.0.1', '2025-04-28 21:07:29'),
(7, 2, '127.0.0.1', '2025-04-28 21:44:33'),
(8, 2, '127.0.0.1', '2025-04-29 00:17:42'),
(9, 3, '127.0.0.1', '2025-04-29 00:18:34'),
(10, 1, '::1', '2025-04-29 16:28:15'),
(11, 3, '127.0.0.1', '2025-04-29 16:33:24'),
(12, 1, '::1', '2025-04-29 18:19:48'),
(13, 2, '127.0.0.1', '2025-04-29 18:47:48'),
(14, 3, '127.0.0.1', '2025-04-30 16:19:04'),
(15, 1, '::1', '2025-04-30 16:19:25'),
(16, 2, '127.0.0.1', '2025-04-30 16:50:56'),
(17, 1, '127.0.0.1', '2025-04-30 22:10:43'),
(18, 3, '::1', '2025-04-30 22:12:11'),
(19, 3, '127.0.0.1', '2025-04-30 22:12:39'),
(20, 2, '127.0.0.1', '2025-04-30 22:14:46'),
(21, 1, '127.0.0.1', '2025-04-30 22:18:42'),
(22, 4, '127.0.0.1', '2025-04-30 22:20:21'),
(23, 1, '127.0.0.1', '2025-04-30 22:21:37'),
(24, 1, '127.0.0.1', '2025-04-30 22:23:51'),
(25, 4, '127.0.0.1', '2025-04-30 22:23:59'),
(26, 3, '127.0.0.1', '2025-04-30 23:29:20'),
(27, 3, '127.0.0.1', '2025-04-30 23:53:56'),
(28, 1, '::1', '2025-05-01 00:16:19'),
(29, 1, '::1', '2025-05-01 15:50:45'),
(30, 3, '127.0.0.1', '2025-05-01 15:51:11'),
(31, 3, '127.0.0.1', '2025-05-01 15:51:12'),
(32, 2, '127.0.0.1', '2025-05-01 16:07:55'),
(33, 4, '127.0.0.1', '2025-05-01 16:09:44'),
(34, 3, '127.0.0.1', '2025-05-01 16:20:45'),
(35, 1, '127.0.0.1', '2025-05-01 19:30:01'),
(36, 3, '127.0.0.1', '2025-05-01 19:31:37'),
(37, 1, '::1', '2025-05-01 20:37:10'),
(38, 1, '::1', '2025-05-02 15:53:21'),
(39, 3, '127.0.0.1', '2025-05-02 15:56:35'),
(40, 1, '::1', '2025-05-02 19:31:08'),
(41, 2, '127.0.0.1', '2025-05-02 19:34:12'),
(42, 4, '127.0.0.1', '2025-05-02 23:40:32'),
(43, 3, '127.0.0.1', '2025-05-03 00:01:56');

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
-- Indexes for table `tblpitched_price`
--
ALTER TABLE `tblpitched_price`
  ADD PRIMARY KEY (`pitched_id`);

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
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblappointment`
--
ALTER TABLE `tblappointment`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblassign_agent`
--
ALTER TABLE `tblassign_agent`
  MODIFY `agent_task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblassign_agent_leadgent`
--
ALTER TABLE `tblassign_agent_leadgent`
  MODIFY `agent_leadgent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblassign_leadgent`
--
ALTER TABLE `tblassign_leadgent`
  MODIFY `leadgent_task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblleads`
--
ALTER TABLE `tblleads`
  MODIFY `lead_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `tblpitched_price`
--
ALTER TABLE `tblpitched_price`
  MODIFY `pitched_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblrecycle_history`
--
ALTER TABLE `tblrecycle_history`
  MODIFY `recycle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblremarks`
--
ALTER TABLE `tblremarks`
  MODIFY `remark_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbltrash_leads`
--
ALTER TABLE `tbltrash_leads`
  MODIFY `trash_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbluserlog`
--
ALTER TABLE `tbluserlog`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
