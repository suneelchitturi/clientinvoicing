-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2024 at 07:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `client_invoicing`
--

-- --------------------------------------------------------

--
-- Table structure for table `clientemployeestate`
--

CREATE TABLE `clientemployeestate` (
  `ClientEmployeeStateId` int(11) NOT NULL,
  `ClientId` int(11) NOT NULL,
  `EmployeeStateId` int(11) NOT NULL,
  `StartDate` date NOT NULL,
  `Status` enum('Active','Closed','','') NOT NULL DEFAULT 'Active',
  `Rate` decimal(9,2) NOT NULL,
  `DueDays` tinyint(4) NOT NULL DEFAULT 14,
  `EndDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clientinvoice`
--

CREATE TABLE `clientinvoice` (
  `InvoiceId` int(11) NOT NULL,
  `ClientId` int(11) NOT NULL,
  `InvoiceDate` date NOT NULL,
  `DueDate` date NOT NULL,
  `Status` enum('FullDue','PartialPaid','Closed','') NOT NULL DEFAULT 'FullDue',
  `BillAmount` decimal(13,2) NOT NULL,
  `Discounts` decimal(13,2) NOT NULL,
  `TotalPaid` decimal(13,2) NOT NULL,
  `PaymentDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clientinvoicedetails`
--

CREATE TABLE `clientinvoicedetails` (
  `InvoiceId` int(11) NOT NULL,
  `ClientEmployeeStateId` int(11) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `Hours` float NOT NULL,
  `TotalAmount` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clientpayments`
--

CREATE TABLE `clientpayments` (
  `InvoiceId` int(11) NOT NULL,
  `PaymentDate` date NOT NULL,
  `PaymentAmount` decimal(13,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `ClientId` int(11) NOT NULL,
  `ClientName` varchar(256) NOT NULL,
  `Phone` int(11) NOT NULL,
  `EmailId` varchar(256) NOT NULL,
  `Country` varchar(256) NOT NULL,
  `Addr1` varchar(256) NOT NULL,
  `Addr2` varchar(256) NOT NULL,
  `Addr3` varchar(256) NOT NULL,
  `City` varchar(256) NOT NULL,
  `State` varchar(256) NOT NULL,
  `Zip` varchar(18) NOT NULL,
  `EIN` decimal(9,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employeestate`
--

CREATE TABLE `employeestate` (
  `EmployeeStateId` int(11) NOT NULL,
  `EmployeeName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clientemployeestate`
--
ALTER TABLE `clientemployeestate`
  ADD PRIMARY KEY (`ClientEmployeeStateId`),
  ADD KEY `ClientId` (`ClientId`),
  ADD KEY `EmployeeStateId` (`EmployeeStateId`);

--
-- Indexes for table `clientinvoice`
--
ALTER TABLE `clientinvoice`
  ADD PRIMARY KEY (`InvoiceId`),
  ADD KEY `ClientId` (`ClientId`);

--
-- Indexes for table `clientinvoicedetails`
--
ALTER TABLE `clientinvoicedetails`
  ADD PRIMARY KEY (`InvoiceId`,`ClientEmployeeStateId`);

--
-- Indexes for table `clientpayments`
--
ALTER TABLE `clientpayments`
  ADD PRIMARY KEY (`InvoiceId`,`PaymentDate`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`ClientId`);

--
-- Indexes for table `employeestate`
--
ALTER TABLE `employeestate`
  ADD PRIMARY KEY (`EmployeeStateId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clientemployeestate`
--
ALTER TABLE `clientemployeestate`
  MODIFY `ClientEmployeeStateId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clientinvoice`
--
ALTER TABLE `clientinvoice`
  MODIFY `InvoiceId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `ClientId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employeestate`
--
ALTER TABLE `employeestate`
  MODIFY `EmployeeStateId` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clientemployeestate`
--
ALTER TABLE `clientemployeestate`
  ADD CONSTRAINT `clientemployeestate_ibfk_1` FOREIGN KEY (`ClientId`) REFERENCES `clients` (`ClientId`),
  ADD CONSTRAINT `clientemployeestate_ibfk_2` FOREIGN KEY (`EmployeeStateId`) REFERENCES `employeestate` (`EmployeeStateId`);

--
-- Constraints for table `clientinvoice`
--
ALTER TABLE `clientinvoice`
  ADD CONSTRAINT `clientinvoice_ibfk_1` FOREIGN KEY (`ClientId`) REFERENCES `clients` (`ClientId`);

--
-- Constraints for table `clientinvoicedetails`
--
ALTER TABLE `clientinvoicedetails`
  ADD CONSTRAINT `clientinvoicedetails_ibfk_1` FOREIGN KEY (`InvoiceId`) REFERENCES `clientinvoice` (`InvoiceId`);

--
-- Constraints for table `clientpayments`
--
ALTER TABLE `clientpayments`
  ADD CONSTRAINT `clientpayments_ibfk_1` FOREIGN KEY (`InvoiceId`) REFERENCES `clientinvoice` (`InvoiceId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
