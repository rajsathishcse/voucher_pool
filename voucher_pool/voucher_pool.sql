
--
-- Database: `voucher_pool`
--
CREATE DATABASE IF NOT EXISTS `voucher_pool` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `voucher_pool`;

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

DROP TABLE IF EXISTS `offers`;
CREATE TABLE `offers` (
  `offer_id` int(11) NOT NULL,
  `percentage` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`offer_id`, `percentage`, `created_at`) VALUES
(1, '5%', '2018-08-17 00:00:00'),
(2, '10%', '2018-08-17 00:00:00');

--
-- Table structure for table `vouchers`
--

DROP TABLE IF EXISTS `vouchers`;
CREATE TABLE `vouchers` (
  `id` int(10) NOT NULL,
  `code` varchar(8) NOT NULL,
  `offer_id` int(11) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `is_used` bit(1) NOT NULL DEFAULT b'0',
  `expired_at` date DEFAULT NULL,
  `voucher_url` text NOT NULL,
  `date_used` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `offer_id`, `user_email`, `is_used`, `expired_at`, `voucher_url`, `date_used`, `created_at`, `updated_at`) VALUES
(1, '7ee92e95', 1, 'rajsathishcse@gmail.com', b'1', '2018-08-18', 'localhost/slim_app/public/use_voucher_code/7ee92e95', '2018-08-18 01:14:03', '2018-08-17 23:03:42', '2018-08-17 17:33:42'),
(2, 'de92ae81', 2, 'rajsathishcse@gmail.com', b'0', '2018-08-24', 'localhost/slim_app/public/use_voucher_code/de92ae81', NULL, '2018-08-17 23:04:26', '2018-08-17 17:34:26'),
(3, 'c20cc752', 1, 'prkece@gmail.com', b'0', '2018-08-24', 'localhost/slim_app/public/use_voucher_code/c20cc752', NULL, '2018-08-17 23:05:29', '2018-08-17 17:35:29'),
(4, 'f4ab6633', NULL, NULL, b'0', NULL, '', NULL, '2018-08-17 23:05:54', '2018-08-17 17:35:54'),
(5, 'aaf7e841', NULL, NULL, b'0', NULL, '', NULL, '2018-08-17 23:05:56', '2018-08-17 17:35:56'),
(6, 'd664bc22', NULL, NULL, b'0', NULL, '', NULL, '2018-08-17 23:16:16', '2018-08-17 17:46:16'),
(7, '45ad1441', NULL, NULL, b'0', NULL, '', NULL, '2018-08-17 23:16:35', '2018-08-17 17:46:35'),
(8, '9cec5dd3', NULL, NULL, b'0', NULL, '', NULL, '2018-08-17 23:17:02', '2018-08-17 17:47:02'),
(9, 'e22c72be', NULL, NULL, b'0', NULL, '', NULL, '2018-08-17 23:25:40', '2018-08-17 17:55:40'),
(10, 'e5147cbf', NULL, NULL, b'0', NULL, '', NULL, '2018-08-17 23:26:07', '2018-08-17 17:56:07'),
(11, 'eb0ef064', NULL, NULL, b'0', NULL, '', NULL, '2018-08-17 23:26:22', '2018-08-17 17:56:22'),
(12, '0dbcca55', NULL, NULL, b'0', NULL, '', NULL, '2018-08-17 23:27:55', '2018-08-17 17:57:55'),
(13, 'a94fecdd', NULL, NULL, b'0', NULL, '', NULL, '2018-08-17 23:28:26', '2018-08-17 17:58:26'),
(14, 'f6469c23', NULL, NULL, b'0', NULL, '', NULL, '2018-08-18 01:20:57', '2018-08-17 19:50:57');

