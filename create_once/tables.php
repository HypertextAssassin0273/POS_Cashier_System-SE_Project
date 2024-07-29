<?php

/* NOTE: Only used once to create physical database schema */

// Connection req. fields
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "supermarketms";

// Create connection
$mysqli = new mysqli($servername, $username, $password, $db_name);

// Check connection
if ($mysqli->connect_errno) {
	die("Connection failed: " . mysqli_connect_error());
}
else {
	echo "Connected Successfully!\n";
}

// Run SQL DDL Commands
$sql ="
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
START TRANSACTION;
SET time_zone = '+00:00';


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `supermarketms`
--

-- --------------------------------------------------------

--
-- Table structure for table `carttable`
--

CREATE TABLE `carttable` (
  `transID` int(11) NOT NULL,
  `prodID` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `carttable`
--

INSERT INTO `carttable` (`transID`, `prodID`, `qty`) VALUES
(25, 4, 1),
(25, 1, 1),
(25, 3, 1),
(31, 1, 5),
(32, 1, 5),
(33, 4, 4),
(34, 3, 1),
(35, 1, 1),
(36, 3, 1),
(38, 3, 4),
(39, 3, 4),
(40, 3, 4),
(40, 4, 2),
(41, 3, 5),
(42, 3, 1),
(43, 3, 5),
(44, 3, 4),
(45, 1, 1),
(46, 1, 1),
(47, 4, 4),
(47, 3, 3),
(48, 3, 6),
(49, 2, 3),
(50, 2, 3),
(51, 1, 4),
(51, 7, 5),
(51, 3, 3),
(52, 3, 4),
(52, 7, 2),
(53, 1, 4),
(53, 3, 4),
(54, 1, 1),
(61, 3, 1),
(63, 3, 1),
(67, 3, 1),
(68, 3, 3),
(69, 1, 1),
(69, 11, 4),
(69, 16, 4);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `custID` int(11) NOT NULL,
  `custName` varchar(255) NOT NULL,
  `custNumber` varchar(255) NOT NULL,
  `amountSpend` varchar(255) NOT NULL,
  `loyal` tinyint(1) DEFAULT NULL,
  `lastTransaction` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`custID`, `custName`, `custNumber`, `amountSpend`, `loyal`, `lastTransaction`) VALUES
(1, 'zain ali', '03134567891', '10000', 0, '2024-12-02 21:08:31'),
(4, 'ali bhai', '03312790876', '1800', 0, '2024-12-03 07:06:09'),
(5, 'naureen', '03008903045', '247503', 1, '2024-12-04 02:17:02'),
(6, 'saleem farhan', '0331245899', '320600', 0, '2024-12-04 09:04:15'),
(7, 'arham ali khan', '0345678912', '326000', 0, '2024-12-06 04:22:13'),
(8, 'zain khan', '03302719746', '87500', 1, '2024-12-06 04:59:40'),
(9, 'a', 'a', '80000', 0, '2024-12-06 05:21:32'),
(10, 'after TimeZone', 'zzz', '80000', 0, '2024-12-06 05:23:00'),
(11, 'alina', '12908978', '600', 0, '2024-12-06 05:28:42'),
(12, 'alibhai', '12345678', '2336', 0, '2024-12-06 10:17:31');

--
-- Triggers `customer`
--
CREATE TRIGGER `update_loyalty_trigger` BEFORE UPDATE ON `customer` FOR EACH ROW BEGIN
  IF NEW.amountSpend > 10000 THEN
    SET NEW.loyal = true;
  END IF;
END;

-- --------------------------------------------------------

--
-- Table structure for table `deletedusers`
--

CREATE TABLE `deletedusers` (
  `userId` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Type` int(11) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `salary` varchar(255) NOT NULL,
  `transactionCount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deletedusers`
--

INSERT INTO `deletedusers` (`userId`, `name`, `userName`, `password`, `Type`, `isActive`, `salary`, `transactionCount`) VALUES
(6, 'alina', 'alina123', '4321', 1, 1, '', 0),
(5, 'naureen', 'kk', '12356', 2, 1, '7600', 0),
(7, 'arham ali  khan', 'aak', '789', 1, 1, '90000', 0),
(4, 'farah', 'nf12', '12', 3, 1, '3000', 0);

--
-- Triggers `deletedusers`
--
CREATE TRIGGER `rollback_employee` AFTER DELETE ON `deletedusers` FOR EACH ROW BEGIN

    INSERT INTO users (userid, name, userName, password, Type,isActive,salary,transactionCount)
    VALUES (OLD.userid, OLD.name, OLD.userName, OLD.password,OLD.Type,OLD.isActive,OLD.salary,OLD.transactionCount);
END;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` int(11) NOT NULL,
  `transID` int(11) DEFAULT NULL,
  `subTotal` varchar(255) DEFAULT NULL,
  `Total` varchar(255) DEFAULT NULL,
  `paymentDate` date DEFAULT current_timestamp(),
  `amountReceived` varchar(255) NOT NULL,
  `ChangeGiven` varchar(255) NOT NULL,
  `paymentType` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`paymentID`, `transID`, `subTotal`, `Total`, `paymentDate`, `amountReceived`, `ChangeGiven`, `paymentType`) VALUES
(1, 30, '781500', '80000', '2024-12-02', '80000', '0', 0),
(2, 31, '7500', '8475', '2024-12-02', '', '', 0),
(3, 32, '7500', '8475', '2024-12-02', '90000', '0', 0),
(4, 33, '2800000', '3164000', '2024-12-02', '90000', '0', 0),
(5, 34, '80000', '90400', '2024-12-02', '90000', '0', 0),
(6, 35, '1500', '1695', '2024-12-02', '90000', '0', 0),
(7, 36, '80000', '90400', '2024-12-02', '90000', '0', 0),
(8, 37, '0', '0', '2024-12-02', '90000', '0', 0),
(9, 38, '320000', '361600', '2024-12-02', '90000', '0', 0),
(10, 39, '320000', '361600', '2024-12-02', '90000', '0', 0),
(11, 40, '1720000', '1943600', '2024-12-02', '90000', '0', 0),
(12, 41, '400000', '452000', '2024-12-02', '90000', '0', 0),
(13, 42, '80000', '90400', '2024-12-02', '90000', '0', 0),
(14, 43, '400000', '452000', '2024-12-02', '90000', '0', 0),
(15, 44, '320000', '361600', '2024-12-02', '90000', '0', 0),
(16, 45, '1500', '1695', '2024-12-02', '90000', '0', 0),
(17, 46, '1500', '1695', '2024-12-02', '90000', '0', 0),
(18, 47, '3040000', '3435200', '2024-12-03', '90000', '0', 0),
(19, 48, '480000', '542400', '2024-12-03', '90000', '0', 0),
(20, 49, '1800', '2034', '2024-12-03', '90000', '0', 0),
(21, 50, '1800', '2034', '2024-12-03', '90000', '0', 2),
(22, 51, '247500', '279675', '2024-12-04', '90000', '0', 1),
(23, 52, '320600', '362278', '2024-12-04', '90000', '0', 1),
(24, 53, '326000', '368380', '2024-12-06', '90000', '0', 1),
(25, 0, '1500', '1695', '2024-12-06', '90000', '0', 1),
(26, 54, '1500', '1695', '2024-12-06', '90000', '0', 1),
(27, 61, '80000', '90400', '2024-12-06', '90000', '0', 1),
(28, 63, '80000', '90400', '2024-12-06', '90000', '0', 1),
(29, 67, '80000', '90400', '2024-12-06', '90000', '0', 1),
(30, 68, '240000', '271200', '2024-12-06', '90000', '0', 1),
(31, 69, '2336', '2639.68', '2024-12-06', '90000', '0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `prodID` int(11) NOT NULL,
  `prodName` varchar(100) DEFAULT NULL,
  `barcode` varchar(110) DEFAULT NULL,
  `price` varchar(100) DEFAULT NULL,
  `Description` varchar(110) NOT NULL,
  `dateCreated` date DEFAULT current_timestamp(),
  `stocks` int(11) DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL,
  `typeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prodID`, `prodName`, `barcode`, `price`, `Description`, `dateCreated`, `stocks`, `isActive`, `typeID`) VALUES
(1, 'AX CHARGER', 'ZAK#123', '1500', 'TYPE C A QUALITY CHARGER', '0000-00-00', 501, 1, 1),
(2, 'SURF AXCEL', '#SF12', '600', 'SURF AXCEL 100G ', '2024-11-26', 1000, 0, 1),
(3, 'iphone11', '#zk124', '80000', 'new', '2024-11-26', 1000, 1, 1),
(4, 'ipone 15', '#123#', '700000', 'pta approved 1 tb', '2024-11-26', 123, 1, 1),
(5, 'choclate2', '#faraz2', '1001', 'dairymilk 150g', '2024-11-26', 11, 1, 1),
(6, 'sultan', '#45ahmed', '34', 'chichoora', '2024-11-27', 100, 1, 1),
(7, 'lux', '123321', '300', 'soap 100 g reuasableednqjo', '2024-11-30', 111, 1, 1),
(8, 'zk', '#faraz22', '300', 'jwqsjknwjknxjk', '2024-12-01', 100, 1, 1),
(9, 'zain khan', '#45622', '100', 'wscsacdf', '2024-12-03', 111, 1, 1),
(10, 'contoller', '12333333', '10000', 'ps5 wireless controller', '2024-12-03', 100, 1, 1),
(11, 'milk', '9099#', '109', 'dajkshxcasihdsiojhdi', '2024-12-04', 111, 1, 1),
(12, 'biryani', '90i90', '100', 'v good biryani\r\n', '2024-12-04', 1000, 1, 1),
(15, 'you choclate', '#1254', '300', 'anti yahoodi', '2024-12-04', 111, 1, 1),
(16, 'abcclothes', '9099#12', '100', 'v good', '2024-12-06', 900, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transID` int(11) NOT NULL,
  `EmpID` int(11) NOT NULL,
  `transNum` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `transDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transID`, `EmpID`, `transNum`, `total`, `transDate`) VALUES
(25, 1, '4082697580', '781500', '2024-12-01 18:17:53'),
(31, 1, '3617916158', '7500', '2024-12-02 17:45:08'),
(32, 1, '1745625938', '7500', '2024-12-02 17:50:10'),
(33, 1, '4619111837', '2800000', '2024-12-03 04:37:08'),
(34, 1, '7163970285', '80000', '2024-12-03 04:39:57'),
(35, 1, '9147242018', '1500', '2024-12-03 04:43:02'),
(36, 1, '160109312', '80000', '2024-12-03 04:51:44'),
(37, 1, '2944977898', '0', '2024-12-03 04:55:58'),
(38, 1, '174588912', '320000', '2024-12-03 05:23:50'),
(39, 1, '9720057518', '320000', '2024-12-03 05:25:38'),
(40, 1, '1637111242', '1720000', '2024-12-03 05:27:44'),
(41, 1, '2148823640', '400000', '2024-12-03 05:29:45'),
(42, 1, '4293150356', '80000', '2024-12-03 05:33:01'),
(43, 1, '1992823889', '400000', '2024-12-03 05:38:59'),
(44, 1, '8171128544', '320000', '2024-12-03 05:40:39'),
(45, 1, '1185781359', '1500', '2024-12-03 05:49:13'),
(46, 1, '4338030233', '1500', '2024-12-03 05:56:38'),
(47, 2, '6801100239', '3040000', '2024-12-03 09:57:06'),
(48, 1, '3010167659', '480000', '2024-12-03 10:17:11'),
(49, 1, '4698500014', '1800', '2024-12-03 10:18:32'),
(50, 1, '7327659266', '1800', '2024-12-03 15:06:09'),
(51, 1, '3031422721', '247500', '2024-12-04 10:17:02'),
(52, 1, '7347545305', '320600', '2024-12-04 17:04:15'),
(53, 2, '8709024435', '326000', '2024-12-06 12:22:13'),
(54, 1, '4100173949', '1500', '2024-12-06 13:16:38'),
(55, 1, '4192049926', '80000', '2024-12-06 13:17:22'),
(56, 1, '299451022', '1500', '2024-12-06 13:18:21'),
(57, 1, '3996120443', '1500', '2024-12-06 13:20:17'),
(58, 1, '2000557588', '80000', '2024-12-06 13:21:32'),
(59, 1, '2319949148', '80000', '2024-12-06 13:22:25'),
(60, 1, '1630858804', '80000', '2024-12-06 13:23:00'),
(61, 1, '9760743519', '80000', '2024-12-06 13:25:30'),
(62, 1, '5381733006', '80000', '2024-12-06 13:25:56'),
(63, 1, '318180887', '80000', '2024-12-06 13:27:07'),
(67, 1, '5688870034', '80000', '2024-12-06 13:32:51'),
(68, 3, '4631679783', '240000', '2024-12-06 14:29:36'),
(69, 8, '7560764477', '2336', '2024-12-06 18:17:31');

--
-- Triggers `transaction`
--
CREATE TRIGGER `update_transaction_count_trigger` AFTER INSERT ON `transaction` FOR EACH ROW BEGIN
  -- Assuming you have an 'employee_id' column in the transactions table
  -- representing the employee conducting the transaction
  UPDATE users
  SET transactionCount = transactionCount + 1
  WHERE userID = NEW.EmpID;
END;

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `typeID` int(11) NOT NULL,
  `typeName` varchar(255) NOT NULL,
  `typeDescription` varchar(255) NOT NULL,
  `prodCount` int(11) NOT NULL,
  `isActive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`typeID`, `typeName`, `typeDescription`, `prodCount`, `isActive`) VALUES
(1, 'electronic', 'electric aceesories 9', 0, 1),
(2, 'sweet', 'v good sweet', 0, 1),
(4, 'shan masala ', 'shan masla v good', 0, 1),
(5, 'fashion', 'v good fashion', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `updatelog`
--

CREATE TABLE `updatelog` (
  `userId` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Type` int(11) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `salary` int(255) NOT NULL,
  `transactionCount` int(11) NOT NULL,
  `updateTime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `updatelog`
--

INSERT INTO `updatelog` (`userId`, `name`, `userName`, `password`, `Type`, `isActive`, `salary`, `transactionCount`, `updateTime`) VALUES
(1, 'zain khan', 'zk', '123', 1, 1, 200, 1, '2024-12-06 06:06:57'),
(2, 'faraz sohail', 'DefaultBrain', '12312', 2, 1, 90000, 0, '2024-12-06 06:06:57'),
(1, 'zain khan', 'zk', '123', 1, 1, 3100, 1, '2024-12-06 06:06:57'),
(1, 'zain khan', 'zk', '123', 1, 1, 3100, 2, '2024-12-06 06:06:57'),
(1, 'zain khan', 'zk', '123', 1, 1, 3100, 3, '2024-12-06 06:06:57'),
(1, 'zain khan', 'zk', '123', 1, 1, 3100, 4, '2024-12-06 06:06:57'),
(1, 'zain khan', 'zk', '123', 1, 1, 3100, 5, '2024-12-06 06:06:57'),
(1, 'zain khan', 'zk', '123', 1, 1, 3100, 6, '2024-12-06 06:06:57'),
(1, 'zain khan', 'zk', '123', 1, 1, 3100, 7, '2024-12-06 06:06:57'),
(1, 'zain khan', 'zk', '123', 1, 1, 3100, 8, '2024-12-06 06:06:57'),
(1, 'zain khan', 'zk', '123', 1, 1, 3100, 9, '2024-12-06 06:06:57'),
(1, 'zain khan', 'zk', '123', 1, 1, 3100, 10, '2024-12-06 06:06:57'),
(1, 'zain khan', 'zk', '123', 1, 1, 3720, 11, '2024-12-06 06:06:57'),
(1, 'zain khan', 'zk', '123', 1, 1, 4464, 12, '2024-12-06 06:17:27'),
(3, 'ahmed sultan', 'master', '123', 3, 1, 98078, 0, '2024-12-06 06:29:36'),
(8, 'ahmed sultan', 'master', '12', 3, 1, 0, 0, '2024-12-06 08:57:39'),
(8, 'ahmed sultan', 'master', '12', 3, 1, 10000, 0, '2024-12-06 08:58:23'),
(9, 'alina', 'ak', '123', 1, 1, 345, 0, '2024-12-06 08:59:05'),
(10, 'shohaib raza', 'dbms', '12343', 3, 1, 190000, 0, '2024-12-06 10:14:42'),
(10, 'shohaib raza', 'dbms', '12343', 3, 1, 200, 0, '2024-12-06 10:15:12'),
(8, 'ahmed sultan', 'master', '12', 3, 1, 10000, 0, '2024-12-06 10:17:31'),
(11, 'ali kerio', 'ak47', '12', 4, 1, 200, 0, '2024-12-06 20:43:47'),
(1, 'zain khan', 'zk', '123', 1, 1, 108000, 12, '2024-12-06 21:13:05'),
(2, 'faraz sohail', 'DefaultBrain', '12312', 2, 1, 90000, 1, '2024-12-06 22:46:35'),
(12, 'sir shakir', 'sk', '12', 1, 1, 900000, 0, '2024-12-06 22:55:35');

--
-- Triggers `updatelog`
--
CREATE TRIGGER `rollbackEdit` AFTER DELETE ON `updatelog` FOR EACH ROW BEGIN
    UPDATE users
    
    SET
        /* Update the columns in users table based on your requirements */
        name = OLD.name,
        userName= OLD.userName,
        password=OLD.password,
        Type=OLD.Type,
        salary=OLD.salary
    WHERE
        userId = OLD.userId;
END;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Type` int(11) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `salary` varchar(255) NOT NULL,
  `transactionCount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `name`, `userName`, `password`, `Type`, `isActive`, `salary`, `transactionCount`) VALUES
(1, 'zain khan', 'zk', '123', 1, 1, '2000', 12),
(2, 'faraz sohail', 'DefaultBrain', '12312', 2, 1, '100', 1),
(3, 'ahmed sultan', 'master', '123', 3, 1, '98078', 1),
(8, 'ahmed sultan', 'master', '12', 3, 1, '10000', 1),
(11, 'ali kerio', 'ak47', '12', 1, 1, '1400', 0),
(12, 'sir shakir', 'sk', '12', 1, 1, '	90000999', 0);

--
-- Triggers `users`
--
CREATE TRIGGER `before_delete_employee` BEFORE DELETE ON `users` FOR EACH ROW BEGIN
    -- Insert the deleted employee record into deletedusers table
    INSERT INTO deletedusers (userid, name, userName, password, Type,isActive,salary,transactionCount)
    VALUES (OLD.userid, OLD.name, OLD.userName, OLD.password,OLD.Type,OLD.isActive,OLD.salary,OLD.transactionCount);
END;

CREATE TRIGGER `before_update_user` BEFORE UPDATE ON `users` FOR EACH ROW BEGIN
  
     INSERT INTO updatelog (userid, name, userName, password, Type,isActive,salary,transactionCount,updateTime)
    VALUES (NEW.userid, NEW.name, NEW.userName, NEW.password,NEW.Type,NEW.isActive,NEW.salary,NEW.transactionCount,NOW());
    
END;

CREATE TRIGGER `increment_salary_trigger` BEFORE UPDATE ON `users` FOR EACH ROW BEGIN
  IF NEW.transactionCount =10 THEN
    SET NEW.salary = NEW.salary * 1.2; -- 20% increment
  END IF;
END;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carttable`
--
ALTER TABLE `carttable`
  ADD KEY `transID` (`transID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`custID`),
  ADD UNIQUE KEY `custNumber` (`custNumber`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prodID`),
  ADD UNIQUE KEY `barcode` (`barcode`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transID`),
  ADD KEY `transaction_ibfk_1` (`EmpID`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`typeID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);


--
-- AUTO_INCREMENT for dumped tables: 
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `custID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prodID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `typeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables:
--

--
-- Constraints for table `carttable`
--
ALTER TABLE `carttable`
  ADD CONSTRAINT `carttable_ibfk_1` FOREIGN KEY (`transID`) REFERENCES `transaction` (`transID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
";

/* use it for dropping all tables in proper sequence */
//$sql = "DROP TABLE ??, contains; DROP TABLE ??; ...";

// Check query
if ($mysqli->multi_query($sql)) {
	echo "Tables created successfully";
}
else {
	echo "Error!: " . $mysqli->error;
}

$mysqli->close();
?>