-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 25, 2018 at 09:19 PM
-- Server version: 5.7.22-0ubuntu0.16.04.1
-- PHP Version: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `superiorf`
--

-- --------------------------------------------------------

--
-- Table structure for table `admincenter`
--

CREATE TABLE `admincenter` (
  `id` int(11) NOT NULL,
  `user_admin` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `confg`
--

CREATE TABLE `confg` (
  `id_confg` int(11) NOT NULL,
  `action` varchar(100) NOT NULL,
  `value` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `integrated` varchar(106) NOT NULL,
  `payment_id` varchar(16) NOT NULL,
  `block` int(11) DEFAULT NULL,
  `hyperlink` varchar(200) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `donor_id` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `get_donor_list`
--

CREATE TABLE `get_donor_list` (
  `id_donor` int(11) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sup` int(11) NOT NULL,
  `txs` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `get_tx_in`
--

CREATE TABLE `get_tx_in` (
  `id_tx` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `block` int(11) NOT NULL,
  `date_tx` datetime NOT NULL,
  `log_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `tx_hash` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `get_tx_log`
--

CREATE TABLE `get_tx_log` (
  `id_log` int(11) NOT NULL,
  `block` int(11) NOT NULL,
  `txs` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `date_run` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `next_run_block` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `user_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_pw` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_address` varchar(95) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vf_payments`
--

CREATE TABLE `vf_payments` (
  `id_payments` int(11) NOT NULL,
  `payments_balance` int(11) NOT NULL,
  `payments_status` varchar(10) NOT NULL,
  `payments_wallet` varchar(106) NOT NULL,
  `payments_date` date NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vf_payments_error`
--

CREATE TABLE `vf_payments_error` (
  `id_error` int(11) NOT NULL,
  `payments_balance` int(11) NOT NULL,
  `payments_status` varchar(20) NOT NULL,
  `payments_wallet` varchar(106) NOT NULL,
  `payments_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vf_payments_succes`
--

CREATE TABLE `vf_payments_succes` (
  `id_succes` int(11) NOT NULL,
  `payments_balance` int(11) NOT NULL,
  `payments_status` varchar(20) NOT NULL,
  `payments_wallet` varchar(106) NOT NULL,
  `payments_hash` varchar(64) NOT NULL,
  `payments_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE `wallet` (
  `id_wallet` int(11) NOT NULL,
  `wallet_balance` int(11) NOT NULL,
  `wallet_unlock` int(11) NOT NULL,
  `wallet_withdraws` int(11) NOT NULL,
  `wallet_paids` int(11) NOT NULL,
  `wallet_claims` int(11) NOT NULL,
  `paids_update` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admincenter`
--
ALTER TABLE `admincenter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `confg`
--
ALTER TABLE `confg`
  ADD PRIMARY KEY (`id_confg`);

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `get_donor_list`
--
ALTER TABLE `get_donor_list`
  ADD PRIMARY KEY (`id_donor`);

--
-- Indexes for table `get_tx_in`
--
ALTER TABLE `get_tx_in`
  ADD PRIMARY KEY (`id_tx`);

--
-- Indexes for table `get_tx_log`
--
ALTER TABLE `get_tx_log`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `vf_payments`
--
ALTER TABLE `vf_payments`
  ADD PRIMARY KEY (`id_payments`);

--
-- Indexes for table `vf_payments_error`
--
ALTER TABLE `vf_payments_error`
  ADD PRIMARY KEY (`id_error`);

--
-- Indexes for table `vf_payments_succes`
--
ALTER TABLE `vf_payments_succes`
  ADD PRIMARY KEY (`id_succes`);

--
-- Indexes for table `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`id_wallet`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admincenter`
--
ALTER TABLE `admincenter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `confg`
--
ALTER TABLE `confg`
  MODIFY `id_confg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `get_donor_list`
--
ALTER TABLE `get_donor_list`
  MODIFY `id_donor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `get_tx_in`
--
ALTER TABLE `get_tx_in`
  MODIFY `id_tx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `get_tx_log`
--
ALTER TABLE `get_tx_log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=785;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `vf_payments`
--
ALTER TABLE `vf_payments`
  MODIFY `id_payments` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT for table `vf_payments_error`
--
ALTER TABLE `vf_payments_error`
  MODIFY `id_error` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `vf_payments_succes`
--
ALTER TABLE `vf_payments_succes`
  MODIFY `id_succes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `wallet`
--
ALTER TABLE `wallet`
  MODIFY `id_wallet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
