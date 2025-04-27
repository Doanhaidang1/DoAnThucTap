-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 17, 2022 at 08:18 AM
-- Server version: 8.0.17
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vpdt`
--

-- --------------------------------------------------------

--
-- Table structure for table `chucnang`
--

CREATE TABLE `chucnang` (
  `maChucNang` int(11) NOT NULL,
  `tenChucNang` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `parent` int(11) NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `logo` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `parentQuyen` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `tenChucNangCon` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `urlChucNangCon` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `order` int(11) NOT NULL,
  `level` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `chucnang`
--

INSERT INTO `chucnang` (`maChucNang`, `tenChucNang`, `parent`, `url`, `logo`, `parentQuyen`, `tenChucNangCon`, `urlChucNangCon`, `order`, `level`) VALUES
(1, 'HỆ THỐNG', 0, '', '', 'hethong', '', '', 64, 0),
(2, 'Người dùng', 1, 'user', 'fa fa-user', '', 'Xem,Thêm/Sửa,Xóa,Phân quyền', 'user,user.saveUser,user.deleteUser,user.phanquyen', 66, 1),
(3, 'Backup - Restore', 1, 'backup', 'fa fa-suitcase', '', '', '', 69, 1),
(4, 'Xem Log', 1, 'log', 'fa fa-street-view', '', 'Xem,Xóa', 'log,log.deleteLog', 70, 1),
(68, 'Nhóm quyền', 1, 'nhomquyen', 'fa fa-group', '', 'Xem,Thêm/Sửa,Xóa,Phân quyền', 'nhomquyen,nhomquyen.save,nhomquyen.delete,nhomquyen.phanquyen', 66, 1),
(84, 'Tạo menu', 83, 'taomenu', 'fa fa-group', '', 'Xem,Thêm/Sửa,Xóa', 'taomenu,taomenu.save,taomenu.delete', 68, 2),
(83, 'Chức năng', 1, '', 'fa fa-group', '', '', '', 67, 1);

-- --------------------------------------------------------

--
-- Table structure for table `codemaster`
--

CREATE TABLE `codemaster` (
  `id` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `year` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `curvalue` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='luu so nhay cua cac phieu';

--
-- Dumping data for table `codemaster`
--

INSERT INTO `codemaster` (`id`, `year`, `curvalue`, `active`, `description`) VALUES
('PCK', '20', 9, 1, ''),
('DDH', '20', 21, 1, ''),
('PGC', '20', 5, 1, ''),
('PX', '20', 52, 1, ''),
('PN', '20', 16, 1, ''),
('HS', '20', 8, 1, ''),
('GH', '20', 3, 1, ''),
('DH', '20', 25, 1, ''),
('HD', '20', 30, 1, ''),
('pn', '20', 2, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `logID` int(11) NOT NULL,
  `ngay` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ten` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `chucnang` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `noidung` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `noidungcu` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`logID`, `ngay`, `ten`, `chucnang`, `noidung`, `noidungcu`) VALUES
(213, '03/06/2022 10:48:33 AM', 'vietkhoi', 'Sửa nhóm quyền', 'tenNQ =Administrator', 'tenNQ =dsgyduf');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `ip` varchar(20) NOT NULL,
  `attempts` int(11) DEFAULT '0',
  `lastlogin` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nhomquyen`
--

CREATE TABLE `nhomquyen` (
  `maNQ` int(11) NOT NULL,
  `tenNQ` varchar(255) NOT NULL,
  `quyen` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nhomquyen`
--

INSERT INTO `nhomquyen` (`maNQ`, `tenNQ`, `quyen`) VALUES
(1, 'Quản kho', 'nghiepvu,khohang,phieuxuatnhap,phieuchuyenkho,kiemtrakho,kiemtrakho,kiemtrakho.kiemtra,dieuchinhkho,dieuchinhkho,dieuchinhkho.dieuchinh,xemkho,lichsukhohang'),
(2, 'Kinh doanh', ''),
(3, 'Kế toán', ''),
(4, 'Lãnh đạo', ''),
(5, 'Administrator', 'hethong,user,user,user.saveUser,user.deleteUser,user.phanquyen,nhomquyen,nhomquyen,nhomquyen.save,nhomquyen.delete,nhomquyen.phanquyen,backup,log,log,log.deleteLog');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `hoTen` varchar(255) NOT NULL,
  `diaChi` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dienThoai` varchar(100) NOT NULL,
  `adminType` varchar(10) NOT NULL DEFAULT '0',
  `quyen` text,
  `maNQ` int(11) NOT NULL,
  `nd_block` tinyint(4) NOT NULL DEFAULT '0',
  `token` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `hoTen`, `diaChi`, `email`, `dienThoai`, `adminType`, `quyen`, `maNQ`, `nd_block`, `token`) VALUES
(4, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'Administrator', '', '', '', '1', '', 0, 0, ''),
(11, 'vietkhoi', '25f9e794323b453885f5181f1b624d0b', 'Viết Khôi', '', '', '', '1', '', 0, 0, '0dIWVf8CE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chucnang`
--
ALTER TABLE `chucnang`
  ADD PRIMARY KEY (`maChucNang`);

--
-- Indexes for table `codemaster`
--
ALTER TABLE `codemaster`
  ADD PRIMARY KEY (`id`,`year`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`logID`);

--
-- Indexes for table `nhomquyen`
--
ALTER TABLE `nhomquyen`
  ADD PRIMARY KEY (`maNQ`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chucnang`
--
ALTER TABLE `chucnang`
  MODIFY `maChucNang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `logID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `nhomquyen`
--
ALTER TABLE `nhomquyen`
  MODIFY `maNQ` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
