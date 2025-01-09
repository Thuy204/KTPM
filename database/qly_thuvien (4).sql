-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2025 at 04:29 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qly_thuvien`
--

-- --------------------------------------------------------

--
-- Table structure for table `cosovatchat`
--

CREATE TABLE `cosovatchat` (
  `csvc_id` int(10) NOT NULL,
  `ten_csvc` varchar(250) NOT NULL,
  `soluong_csvc` int(50) NOT NULL,
  `tinhtrang_csvc` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cosovatchat`
--

INSERT INTO `cosovatchat` (`csvc_id`, `ten_csvc`, `soluong_csvc`, `tinhtrang_csvc`) VALUES
(3, 'Máy in', 2, 0),
(4, 'Quạt trần', 10, 1),
(7, 'Tủ sách', 2, 1),
(10, 'Bình nước', 15, 1),
(12, 'Đèn', 5, 1),
(15, 'Điều hòa', 5, 0),
(16, 'Kệ sách', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `docgia`
--

CREATE TABLE `docgia` (
  `docgia_id` int(10) NOT NULL,
  `ten_docgia` varchar(250) NOT NULL,
  `tuoi_docgia` int(5) NOT NULL,
  `gioitinh_docgia` int(3) NOT NULL,
  `sdt_docgia` int(11) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `docgia`
--

INSERT INTO `docgia` (`docgia_id`, `ten_docgia`, `tuoi_docgia`, `gioitinh_docgia`, `sdt_docgia`, `email`) VALUES
(4, 'Hoàng Thu Hường ', 19, 1, 2147483647, 'hihi@gmail.com'),
(6, 'Lã Thị Hoa', 21, 1, 362847372, 'Thuthuy8104@gmail.com'),
(26, 'hhihihi', 3232, 1, 323123, '1@gmail.com'),
(27, 'hahah', 32312, 0, 3213, 'hdhah@gmail.com'),
(28, '12123', 32323, 1, 4324, 'dbasg@gmail.com'),
(29, 'hhihihi', -2, 1, 3213, 'dbasg@gmail.com'),
(30, '4', 43, 0, 353, ''),
(31, '534', 54355, 1, 53453, ''),
(32, 'Nguyễn Văn A', 25, 0, 123456789, ''),
(33, '2', 3, 0, 4241, '');

-- --------------------------------------------------------

--
-- Table structure for table `muon_tra`
--

CREATE TABLE `muon_tra` (
  `muontra_id` int(11) NOT NULL,
  `docgia_id` int(11) NOT NULL,
  `sach_id` int(11) NOT NULL,
  `soluong` int(11) NOT NULL,
  `ngaymuon` date NOT NULL,
  `hantra` date NOT NULL,
  `ngaytra` date DEFAULT NULL,
  `trang_thai` enum('Đang mượn','Đã trả','Quá hạn') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `muon_tra`
--

INSERT INTO `muon_tra` (`muontra_id`, `docgia_id`, `sach_id`, `soluong`, `ngaymuon`, `hantra`, `ngaytra`, `trang_thai`) VALUES
(30, 4, 2, 1, '2025-01-01', '2025-01-15', '2025-01-07', 'Đã trả'),
(34, 4, 3, 3, '2024-12-31', '2025-01-13', '2025-01-31', 'Quá hạn'),
(35, 4, 3, 3, '2025-01-15', '2025-01-22', '2025-01-13', 'Đã trả'),
(36, 6, 3, 10, '2025-01-08', '2025-01-17', '2025-01-07', 'Đã trả'),
(41, 32, 5, 10, '2025-01-05', '2025-01-06', '2025-01-07', 'Quá hạn'),
(44, 4, 6, 35, '2025-01-07', '2025-01-08', '2025-01-09', 'Quá hạn'),
(45, 32, 7, 1, '2025-01-07', '2025-01-23', NULL, 'Đang mượn'),
(46, 32, 7, 1, '2025-01-07', '2025-01-31', NULL, 'Đang mượn'),
(47, 32, 7, 1, '2025-01-08', '2025-01-30', NULL, 'Đang mượn'),
(48, 32, 7, 2, '2025-01-08', '2025-01-23', NULL, 'Đang mượn'),
(49, 32, 7, 1, '2025-01-17', '2025-01-31', NULL, 'Đang mượn'),
(50, 32, 7, 1, '2025-01-09', '2025-01-25', NULL, 'Đang mượn'),
(51, 32, 7, 1, '2025-01-09', '2025-01-30', NULL, 'Đang mượn'),
(52, 32, 7, 1, '2025-01-09', '2025-01-23', NULL, 'Đang mượn'),
(53, 32, 7, 1, '2025-01-15', '2025-01-31', NULL, 'Đang mượn'),
(54, 32, 7, 1, '2025-01-11', '2025-01-31', NULL, 'Đang mượn'),
(55, 32, 7, 1, '2025-01-09', '2025-01-16', NULL, 'Đang mượn'),
(56, 32, 7, 1, '2025-01-09', '2025-01-23', NULL, 'Đang mượn'),
(57, 32, 7, 1, '2025-01-09', '2025-01-17', '2025-01-09', 'Đã trả'),
(59, 4, 7, 2, '2025-01-09', '2025-01-24', '2025-01-15', 'Đã trả');

-- --------------------------------------------------------

--
-- Table structure for table `nguoidung`
--

CREATE TABLE `nguoidung` (
  `id_nguoidung` int(11) NOT NULL,
  `ten_nguoidung` varchar(255) NOT NULL,
  `email_nguoidung` varchar(255) NOT NULL,
  `matkhau_nguoidung` varchar(255) NOT NULL,
  `vaitro_nguoidung` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `nguoidung`
--

INSERT INTO `nguoidung` (`id_nguoidung`, `ten_nguoidung`, `email_nguoidung`, `matkhau_nguoidung`, `vaitro_nguoidung`) VALUES
(1, 'Nam', 'NamPhung30@gmail.com', '123456', 'nhan vien'),
(2, 'Thu', 'Thunguyen15@gmail.com', '555555', 'nhan vien'),
(3, 'Thuy', 'Thuthuy123@gmail.com', '3', 'nhan vien\r\n'),
(4, 'Nhung', 'hongnhung456@gmail.com', '444444444', 'nhanvien\r\n'),
(19, 'TT', 'tt@gmail.com', '11', 'nhân viên'),
(30, 'Thuy', 'tt1@gmail.com', '12', 'nhân viên'),
(31, 'nhung', 'nhung@gmail.com', '123456', 'nhân viên'),
(32, 'tt', '1@gmail.com', '33', 'nhân viên'),
(33, 'ttthuyyuy', 'dbasg@gmail.com', 'tt', 'nhân viên'),
(34, '1', '2@gmail.xom', '1', 'Nhân viên'),
(35, 'ttthuyyuy', 'dbasg@gmail.com', '4242', 'nhân viên'),
(36, '1', '2@gmail.xom', '3', 'Nhân viên');

-- --------------------------------------------------------

--
-- Table structure for table `nhaxuatban`
--

CREATE TABLE `nhaxuatban` (
  `nxb_id` int(11) NOT NULL,
  `ten_nxb` varchar(100) NOT NULL,
  `thongtin_nxb` text DEFAULT NULL,
  `hinhanh_nxb` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `nhaxuatban`
--

INSERT INTO `nhaxuatban` (`nxb_id`, `ten_nxb`, `thongtin_nxb`, `hinhanh_nxb`) VALUES
(2, 'NXB Kim Đồng', 'Nhà xuất bản Kim Đồng\r\n', ''),
(6, 'Báo thiếu nhi', 'báo thiếu nhi\r\n', ''),
(7, 'Tuổi trẻ', 'nhà xuất bản tuổi trẻ\r\n', ''),
(9, 'Báo nhân dân', 'nxb ah', ''),
(10, 'Nhã Nam', 'hihiHIHIHIH', '');

-- --------------------------------------------------------

--
-- Table structure for table `sach`
--

CREATE TABLE `sach` (
  `sach_id` int(11) NOT NULL,
  `tacgia_id` int(11) DEFAULT NULL,
  `theloai_id` int(11) DEFAULT NULL,
  `nxb_id` int(11) DEFAULT NULL,
  `mota_sach` text DEFAULT NULL,
  `ten_sach` varchar(255) NOT NULL,
  `soluong_tonkho` int(11) DEFAULT NULL,
  `ngaytao` date DEFAULT NULL,
  `hinhanh_sach` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sach`
--

INSERT INTO `sach` (`sach_id`, `tacgia_id`, `theloai_id`, `nxb_id`, `mota_sach`, `ten_sach`, `soluong_tonkho`, `ngaytao`, `hinhanh_sach`) VALUES
(1, 9, 11, 10, 'Mo ta ve sach 1', 'Sach 1', 0, '2024-01-01', 'sach1.jpg'),
(2, 100, 99, 10, 'Mo ta ve sach 2', 'Sach 2', 0, '2024-01-02', 'sach2.jpg'),
(3, 1001, 11, 6, 'Mo ta ve sach 3', 'Sach 3', 1, '2024-01-03', 'sach3.jpg'),
(4, 9, 11, 7, 'Mo ta ve sach 4', 'Sach 4', 25, '2024-01-04', 'sach4.jpg'),
(5, 1001, 99, 2, 'Mo ta ve sach 5', 'Sach 5', 0, '2024-01-05', 'sach5.jpg'),
(6, 9, 99, 6, 'Mo ta ve sach 6', 'Sach 6', 0, '2024-01-06', 'sach6.jpg'),
(7, 1001, 11, 10, 'Mo ta ve sach 7', 'Sach 7', 26, '2024-01-07', 'sach7.jpg'),
(8, 9, 11, 6, 'Mo ta ve sach 8', 'Sach 8', 45, '2024-01-08', 'sach8.jpg'),
(9, 9, 99, 7, 'Mo ta ve sach 9', 'Sach 9', 50, '2024-01-09', 'sach9.jpg'),
(10, 9, 99, 10, 'Mo ta ve sach 10', 'Sach 10', 55, '2024-01-10', 'sach10.jpg'),
(11, 9, 11, 2, 'okila', 'Sách 100', 13, '2024-07-09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tacgia`
--

CREATE TABLE `tacgia` (
  `tacgia_id` int(10) NOT NULL,
  `ten_tacgia` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gioitinh_tacgia` int(3) NOT NULL,
  `thongtin_tacgia` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `hinhanh_tacgia` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tacgia`
--

INSERT INTO `tacgia` (`tacgia_id`, `ten_tacgia`, `gioitinh_tacgia`, `thongtin_tacgia`, `hinhanh_tacgia`) VALUES
(9, '                        Nguyễn Nhật Ánh', 1, '                        Được xem là một trong những nhà văn hiện đại xuất sắc nhất Việt Nam hiện nay, ông được biết đến qua nhiều tác phẩm văn học về đề tài tuổi trẻ. Nhiều tác phẩm của ông được độc g', 'tacgia1.jpg'),
(100, '                                    Nguyễn Khoa Điềm', 1, 'Là một nhà thơ, nhà chính trị Việt Nam. Ông nguyên là Ủy viên Bộ Chính trị, Bí thư Trung ương Đảng khóa IX, Trưởng ban Tư tưởng – Văn hóa Trung ương; Đại biểu Quốc hội Việt Nam khóa X, Bộ trưởng Bộ Vă', 'tacgia2.jpg'),
(1001, '                        Xuân Quỳnh', 1, '            Tên đầy đủ là Nguyễn Thị Xuân Quỳnh, là một nữ nhà thơ người Việt Nam. Bà nổi tiếng với nhiều bài thơ được nhiều người biết đến như Thuyền và biển, Sóng, Thơ tình cuối mùa thu, Tiếng gà tr', 'tacgia2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `theloai`
--

CREATE TABLE `theloai` (
  `theloai_id` int(10) NOT NULL,
  `ten_theloai` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `thongtin_theloai` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `theloai`
--

INSERT INTO `theloai` (`theloai_id`, `ten_theloai`, `thongtin_theloai`) VALUES
(9, 'Truyện cổ tích', 'trẻ em'),
(10, 'Truyện ngôn tình', 'rất hay'),
(11, 'Truyện tranh giải trí', 'Trẻ em '),
(12, 'Sách lịch sử', 'Yêu nước'),
(99, 'Sách Giáo Khoa', 'Cấp Tiểu Họcc');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cosovatchat`
--
ALTER TABLE `cosovatchat`
  ADD PRIMARY KEY (`csvc_id`);

--
-- Indexes for table `docgia`
--
ALTER TABLE `docgia`
  ADD PRIMARY KEY (`docgia_id`);

--
-- Indexes for table `muon_tra`
--
ALTER TABLE `muon_tra`
  ADD PRIMARY KEY (`muontra_id`),
  ADD KEY `docgia_id` (`docgia_id`),
  ADD KEY `sach_id` (`sach_id`);

--
-- Indexes for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`id_nguoidung`);

--
-- Indexes for table `nhaxuatban`
--
ALTER TABLE `nhaxuatban`
  ADD PRIMARY KEY (`nxb_id`);

--
-- Indexes for table `sach`
--
ALTER TABLE `sach`
  ADD PRIMARY KEY (`sach_id`),
  ADD KEY `tacgia_id` (`tacgia_id`),
  ADD KEY `theloai_id` (`theloai_id`),
  ADD KEY `nxb_id` (`nxb_id`);

--
-- Indexes for table `tacgia`
--
ALTER TABLE `tacgia`
  ADD PRIMARY KEY (`tacgia_id`);

--
-- Indexes for table `theloai`
--
ALTER TABLE `theloai`
  ADD PRIMARY KEY (`theloai_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cosovatchat`
--
ALTER TABLE `cosovatchat`
  MODIFY `csvc_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `docgia`
--
ALTER TABLE `docgia`
  MODIFY `docgia_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `muon_tra`
--
ALTER TABLE `muon_tra`
  MODIFY `muontra_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `id_nguoidung` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `nhaxuatban`
--
ALTER TABLE `nhaxuatban`
  MODIFY `nxb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sach`
--
ALTER TABLE `sach`
  MODIFY `sach_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tacgia`
--
ALTER TABLE `tacgia`
  MODIFY `tacgia_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1003;

--
-- AUTO_INCREMENT for table `theloai`
--
ALTER TABLE `theloai`
  MODIFY `theloai_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `muon_tra`
--
ALTER TABLE `muon_tra`
  ADD CONSTRAINT `muon_tra_ibfk_1` FOREIGN KEY (`docgia_id`) REFERENCES `docgia` (`docgia_id`),
  ADD CONSTRAINT `muon_tra_ibfk_2` FOREIGN KEY (`sach_id`) REFERENCES `sach` (`sach_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
