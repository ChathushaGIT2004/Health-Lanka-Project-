-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 27, 2025 at 05:25 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dev`
--
CREATE DATABASE IF NOT EXISTS `dev` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `dev`;

-- --------------------------------------------------------

--
-- Table structure for table `allergy`
--

DROP TABLE IF EXISTS `allergy`;
CREATE TABLE IF NOT EXISTS `allergy` (
  `Allergy ID` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`Allergy ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `allergy`
--

INSERT INTO `allergy` (`Allergy ID`, `Name`, `Description`) VALUES
('1', 'Pollen', 'Allergic reaction to pollen, leading to hay fever or rhinitis.'),
('2', 'Dust Mites', 'Reaction to dust mites, causing sneezing, itching, and wheezing.'),
('3', 'Peanuts', 'Anaphylaxis or skin reactions due to peanut exposure.'),
('4', 'Shellfish', 'Allergic reaction to shellfish like shrimp, lobster, and crabs.'),
('5', 'Penicillin', 'An allergy to penicillin antibiotics that can cause skin rashes.'),
('6', 'Cat Dander', 'Allergic reactions to proteins found in cat saliva and skin.'),
('7', 'Dog Dander', 'Reaction to proteins in dog saliva and dander, causing asthma.'),
('8', 'Latex', 'Allergic reaction to latex products, such as gloves or balloons.'),
('9', 'Milk', 'Lactose intolerance or milk protein allergy causing digestive issues.'),
('10', 'Eggs', 'Allergic reactions due to egg whites or yolk proteins.'),
('11', 'Tree Nuts', 'Severe reactions from almonds, walnuts, or cashews.'),
('12', 'Soy', 'Allergy to soybeans or soy products, can cause skin rashes.'),
('13', 'Wheat', 'Wheat allergy, leading to digestive and skin problems.'),
('14', 'Fish (Cod)', 'Seafood allergy, especially to fish like cod, causing rashes or anaphylaxis.'),
('15', 'Mold', 'Allergic reactions from mold spores, leading to breathing issues.'),
('16', 'Insect Stings', 'Allergy to insect venom from bees, wasps, or hornets.'),
('17', 'Cigarette Smoke', 'Allergic response or irritation from inhaling smoke.'),
('18', 'Ragweed', 'Hay fever or allergic rhinitis triggered by ragweed pollen.'),
('19', 'Cockroach', 'Allergy due to cockroach droppings, leading to asthma and rhinitis.'),
('20', 'Garlic', 'Sensitivity to garlic, causing digestive discomfort or skin rash.');

-- --------------------------------------------------------

--
-- Table structure for table `dispence-medicine`
--

DROP TABLE IF EXISTS `dispence-medicine`;
CREATE TABLE IF NOT EXISTS `dispence-medicine` (
  `MeetUp ID` int NOT NULL,
  `Medicine ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `times` int NOT NULL,
  `per time` int NOT NULL,
  `Notes` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dispence-medicine`
--

INSERT INTO `dispence-medicine` (`MeetUp ID`, `Medicine ID`, `times`, `per time`, `Notes`) VALUES
(1, '2', 1, 1, '1'),
(2, '1', 1, 1, '1'),
(11, '1', 3, 1, '1'),
(11, '2', 3, 2, 'just frink'),
(12, '1', 6187, 6178, '6187'),
(27, 'Simv000000', 10, 10, '01'),
(28, 'Amox000000', 1, 1, '1'),
(29, 'Par0000001', 12, 2112, '2116817'),
(29, 'Levo000000', 157, 176, '671'),
(30, 'Par0000001', 2, 1, '1'),
(30, 'Lisi000000', 1, 12, '1'),
(32, 'Par0000001', 317, 13783, '138');

-- --------------------------------------------------------

--
-- Table structure for table `doctor-hospital`
--

DROP TABLE IF EXISTS `doctor-hospital`;
CREATE TABLE IF NOT EXISTS `doctor-hospital` (
  `Doctor  ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Hospital ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Signed date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor-hospital`
--

INSERT INTO `doctor-hospital` (`Doctor  ID`, `Hospital ID`, `Signed date`) VALUES
('10326', 'H001', '2024-11-27'),
('12356', '[value-2]', '0000-00-00'),
('[value-1]', '[value-2]', '0000-00-00'),
('12356', '1', '2024-11-29'),
('12356', 'HOSP003', '2024-10-30'),
('12786', '1', '2024-11-29'),
('12786', 'HOSP002', '2024-11-29'),
('12786', 'HOSP008', '2024-11-14');

-- --------------------------------------------------------

--
-- Table structure for table `doctor-specialization`
--

DROP TABLE IF EXISTS `doctor-specialization`;
CREATE TABLE IF NOT EXISTS `doctor-specialization` (
  `Doctor  ID` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Specilization ID` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Proof` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor-specialization`
--

INSERT INTO `doctor-specialization` (`Doctor  ID`, `Specilization ID`, `Proof`) VALUES
('10326', '0', 'C:\\wamp64\\www\\Dev\\Doctor/Doctor Spec/10326_.jpg'),
('10326', '0', 'C:\\wamp64\\www\\Dev\\Doctor/Doctor Spec/10326_.jpg'),
('10326', '0', 'C:\\wamp64\\www\\Dev\\Doctor/Doctor Spec/10326_.jpg'),
('10326', '0', 'C:\\wamp64\\www\\Dev\\Doctor/Doctor Spec/10326_.jpg'),
('10326', '0', ''),
('10326', '0', ''),
('10326', '0', 'C:\\wamp64\\www\\Dev\\Doctor/Doctor Spec/10326_SPEC001.png'),
('10326', 'SPEC001', 'C:\\wamp64\\www\\Dev\\Doctor/Doctor Spec/10326_SPEC001.png'),
('10326', 'SPEC014', 'C:\\wamp64\\www\\Dev\\Doctor../Doctor/Doctor Spec10326_SPEC014.jpg'),
('10326', 'SPEC015', 'C:\\wamp64\\www\\Dev\\Doctor../Doctor/Doctor Spec10326_SPEC015.jpg'),
('10326', 'SPEC015', 'C:\\wamp64\\www\\Dev\\Doctor../Doctor/Doctor Spec10326_SPEC015.jpg'),
('10326', 'SPEC015', 'C:\\wamp64\\www\\Dev\\Doctor../Doctor/Doctor Spec10326_SPEC015.jpg'),
('10326', 'SPEC014', 'C:\\wamp64\\www\\Dev\\Doctor../Doctor/Doctor Spec10326_SPEC014.avif'),
('10326', 'SPEC020', 'C:\\wamp64\\www\\Dev\\Doctor../Doctor/Doctor Spec10326_SPEC020.jpg'),
('10326', 'SPEC020', 'C:\\wamp64\\www\\Dev\\Doctor../Doctor/Doctor Spec10326_SPEC020.jpg'),
('10326', 'SPEC020', 'C:\\wamp64\\www\\Dev\\Doctor../Doctor/Doctor Spec10326_SPEC020.jpg'),
('10289', 'SPEC001', ''),
('12356\r\n', 'SPEC002', ''),
('23456', 'SPEC003\r\n', ''),
('12786', 'SPEC004', ''),
('58243', 'SPEC005', ''),
('12678', 'SPEC006', ''),
('10325', 'SPEC007', ''),
('21456', 'SPEC008', ''),
('16578', 'SPEC009', ''),
('73156', 'SPEC010', ''),
('96428', 'SPEC011', ''),
('75394', 'SPEC012', ''),
('49281', 'SPEC013', ''),
('16237', 'SPEC014', ''),
('84509', 'SPEC015', ''),
('83921', 'SPEC016', ''),
('71029', 'SPEC017', ''),
('62417', 'SPEC018', ''),
('43120', 'SPEC019', '');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

DROP TABLE IF EXISTS `doctors`;
CREATE TABLE IF NOT EXISTS `doctors` (
  `DoctorID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `FirstName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `LastName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ContactNo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`DoctorID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`DoctorID`, `FirstName`, `LastName`, `ContactNo`, `Email`, `Password`, `Image`) VALUES
('12786', 'Chamari ', 'Silva', '0767390095', 'ChamariSilva@gmail.com', '1234', '../DOC Images/2.jpg'),
('58243', 'Dilshan ', 'Fernando', '0767390095', 'DilshanFernando@gmail.com', '1234', '../DOC Images/2.jpg'),
('12678', 'Chamiru', 'Thinoda', '0717101852', 'malithsiriwardhana072@gmail.com', '1234', '../DOC Images/2.jpg'),
('10326', 'Nithika', 'Dilen', '0767390095', 'admin@admin.com', '0805', '../DOC Images/2.jpg'),
('16578', 'Sanjeewa ', 'Wickramasinghe', '0879823456', 'SanjeewaWickramasinghe@gmail.com', '1234', '../DOC Images/2.jpg'),
('96428', 'Anjali', 'DeSilva', '0712345678', 'AnjaliDeSilva@gmail.com', '1234', '../DOC Images/2.jpg'),
('75394', 'Lakshmi ', 'Fernando', '0719876543', 'lakshmi.fernando@gmail.com', '1234', '../DOC Images/2.jpg'),
('49281', 'Ishara ', 'Nunes', '0721234567', 'ishara.nunes@gmail.com', '1234', '../DOC Images/2.jpg'),
('16237', 'Tharindu', 'Gamage', '0799012345', 'tharindu.gamage@gmail.com', '1234', '../DOC Images/2.jpg'),
('84509', 'Liyanage', 'Kanishka', '0758901234', 'kanishka.liyanage@gmail.com', '1234', '../DOC Images/2.jpg'),
('83921', 'Ruwan', 'Perera', '0782233445', 'ruwan.perera@gmail.com', '1234', '../DOC Images/2.jpg'),
('71029', 'Madusha', 'Silva', '0723344556', 'madusha.silva@gmail.com', '1234', '../DOC Images/2.jpg'),
('62417', 'Pradeep', 'Wijesinghe', '0764455667', 'pradeep.wijesinghe@gmail.com', '1234', '../DOC Images/2.jpg'),
('43120', 'Shalini', 'Kumar', '0775566778', 'shalini.kumar@gmail.com', '1234', '../DOC Images/2.jpg'),
('01057', 'Chathusha', 'Dewmith', '0767390095', 'Chathushadewmin@gmail.com', '1234', '../DOC Images/01057.jpg'),
('10328', 'Chathusha', 'Dewmith', '0767390095', 'Chathushadewmin@gmail.com', '1234', '../DOC Images/10328.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `hospital`
--

DROP TABLE IF EXISTS `hospital`;
CREATE TABLE IF NOT EXISTS `hospital` (
  `Hospital ID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Name` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Address` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sector` enum('Goverment','Private') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Grade` enum('Base Hospitals (Grade A)','District General Hospitals (Grade B)','Teaching Hospitals (Grade C)','National Hospitals (Grade D)') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Image` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`Hospital ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hospital`
--

INSERT INTO `hospital` (`Hospital ID`, `Name`, `Address`, `sector`, `Grade`, `Image`) VALUES
('1', 'ANgoda', 'angoda', 'Goverment', 'Base Hospitals (Grade A)', '../HOSPITAL/hos1.jpg'),
('H001', 'Angoda Central ', 'Idilanda galpatha ', 'Goverment', 'Base Hospitals (Grade A)', '../HOSPITAL/hos2.jpg\r\n'),
('HOSP001', 'Colombo General Hospital', 'No. 123, Colombo 8, Sri Lanka', '', 'Base Hospitals (Grade A)', '../HOSPITAL/hos2.jpg'),
('HOSP002', 'Kandy Teaching Hospital', '10, Kandy, Central Province, Sri Lanka', '', '', '../HOSPITAL/hos2.jpg'),
('HOSP003', 'Galle District Hospital', '5, Galle, Southern Province, Sri Lanka', '', '', '../HOSPITAL/hos1.jpg'),
('HOSP004', 'Jaffna Teaching Hospital', 'Jaffna, Northern Province, Sri Lanka', '', 'Base Hospitals (Grade A)', '../HOSPITAL/hos2.jpg'),
('HOSP005', 'Nuwara Eliya District Hospital', 'Nuwara Eliya, Central Province, Sri Lanka', '', '', '../HOSPITAL/hos2.jpg'),
('HOSP006', 'Mount Lavinia Hospital', '45, Mount Lavinia, Western Province, Sri Lanka', 'Private', '', '../HOSPITAL/hos1.jpg'),
('HOSP007', 'Gampaha District Hospital', 'Gampaha, Western Province, Sri Lanka', '', '', '../HOSPITAL/hos1.jpg'),
('HOSP008', 'Anuradhapura General Hospital', 'Anuradhapura, North Central Province, Sri Lanka', '', 'Base Hospitals (Grade A)', '../HOSPITAL/hos1.jpg'),
('HOSP009', 'Ratnapura District Hospital', 'Ratnapura, Sabaragamuwa Province, Sri Lanka', '', '', '../HOSPITAL/hos2.jpg'),
('HOSP010', 'Maharagama Cancer Hospital', 'Maharagama, Western Province, Sri Lanka', '', 'Base Hospitals (Grade A)', '../HOSPITAL/hos1.jpg'),
('HOSP011', 'Negombo District Hospital', 'Negombo, Western Province, Sri Lanka', '', '', '../HOSPITAL/hos2.jpg'),
('HOSP012', 'Badulla General Hospital', 'Badulla, Uva Province, Sri Lanka', '', 'Base Hospitals (Grade A)', '../HOSPITAL/hos1.jpg'),
('HOSP013', 'Kalutara District Hospital', 'Kalutara, Western Province, Sri Lanka', '', '', '../HOSPITAL/hos2.jpg'),
('HOSP014', 'Colombo South Teaching Hospital', '80, Dehiwala, Colombo, Sri Lanka', '', 'Base Hospitals (Grade A)', '../HOSPITAL/hos1.jpg'),
('HOSP015', 'Batticaloa District Hospital', 'Batticaloa, Eastern Province, Sri Lanka', '', '', '../HOSPITAL/hos1.jpg'),
('HOSP016', 'Kurunegala Teaching Hospital', 'Kurunegala, North Western Province, Sri Lanka', '', 'Base Hospitals (Grade A)', '../HOSPITAL/hos2.jpg'),
('HOSP017', 'Sri Jayawardenepura Hospital', '100, Kotte, Western Province, Sri Lanka', 'Private', '', '../HOSPITAL/hos1.jpg'),
('HOSP018', 'Matara District Hospital', 'Matara, Southern Province, Sri Lanka', '', '', '../HOSPITAL/hos1.jpg'),
('HOSP019', 'Vavuniya District Hospital', 'Vavuniya, Northern Province, Sri Lanka', '', '', '../HOSPITAL/hos2.jpg'),
('HOSP020', 'Polonnaruwa District Hospital', 'Polonnaruwa, North Central Province, Sri Lanka', '', '', '../HOSPITAL/hos1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `hospital-users`
--

DROP TABLE IF EXISTS `hospital-users`;
CREATE TABLE IF NOT EXISTS `hospital-users` (
  `UserID` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Hospital ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Location` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Contact No` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hospital-users`
--

INSERT INTO `hospital-users` (`UserID`, `Name`, `Hospital ID`, `Type`, `Location`, `Contact No`, `Password`) VALUES
('P001', 'Pharmacist 1', '', '', 'Colombo 7;', '0767390095', ''),
('P002', 'Pharmacist 2', '', '', 'Colombo 7;', '0767390095', '$2y$10$qviOgRZE8ro2tEaG4wT5KuDhrQ.yzGzkL8yn/LGk3WT4mvGo8THFS'),
('1', '10', '', 'Pharmacist', '10', '10', '$2y$10$AllP.qi0pGyGw/w8yhQBWuMwAU/VTVELdrESMYU/KWCmNbWtk4.9i'),
('5', '10', '1', 'Pharmacist', '10', '10', '$2y$10$Mc6qjAo6.h8IdtyzPc9z9u2z584/Xvid3Q.8PsSgT1oUiA45/gdVK'),
('1', 'Chathusha', '1', 'Labrotary', 'idilanda ', '0767390095', '$2y$10$NPzlA6gpOKMT0p7yaG.Qke/Tb1mn.RbJSDElMa6mdrPlmDSuiSSGS'),
('10', 'Oshan Nethsara', '1', 'Pharmacist', 'idilanda ', '0767390095', ''),
('11', 'Chathusha', '1', 'Labrotary', 'idilanda ', '0767390095', ''),
('13', 'Chathusha', '1', 'Labrotary', 'idilanda ', '0767390095', ''),
('14', 'Chathusha', '1', 'Pharmacist', 'idilanda ', '0767390095', ''),
('15', 'Chathusha', '1', 'Pharmacist', 'idilanda ', '0767390095', ''),
('16', 'Chathusha', '1', 'Pharmacist', 'idilanda ', '0767390095', ''),
('16', 'Chathusha', '1', 'Pharmacist', 'idilanda ', '0767390095', ''),
('18', 'Chathusha', 'HOSP002', 'Labrotary', 'idilanda ', '0767390095', ''),
('19', 'Chathusha', 'H001', 'Pharmacist', 'idilanda ', '0767390095', ''),
('0805', 'cj', 'H001', 'Pharmacist', '12', '12', '$2y$10$AGTNVTe8IbYugtYPHC1jTuo7fw6JtSkvi5/CK5Z3tts7lZGAV8ZEC'),
('22', 'cj', 'H001', 'Labotary', '12', '12', '1234'),
('10', 'oshan', '1005', 'Pharmacist\r\n', ' 7o8nf', 'ifn', 'nf876'),
('50', '12o;y', 'ont', 'Pharmacist', 'ntuoi', 'noruonr', '0805');

-- --------------------------------------------------------

--
-- Table structure for table `medicalreports`
--

DROP TABLE IF EXISTS `medicalreports`;
CREATE TABLE IF NOT EXISTS `medicalreports` (
  `PatientID` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ReportID` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ReportType` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DateChecked` date NOT NULL,
  `Result` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CheckedDoctorName` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DoctorsNote` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PictureOfReport` varbinary(500) NOT NULL,
  `LastUpdatedDate` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicinedetails`
--

DROP TABLE IF EXISTS `medicinedetails`;
CREATE TABLE IF NOT EXISTS `medicinedetails` (
  `MedicineName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `MedicineID` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `UsageOfMedicine` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CategoryOfMedicine` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `PictureOfMedicine` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`MedicineID`),
  UNIQUE KEY `MedicineName` (`MedicineName`),
  UNIQUE KEY `MedicineName_2` (`MedicineName`),
  UNIQUE KEY `MedicineName_3` (`MedicineName`),
  KEY `MedicineName_4` (`MedicineName`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicinedetails`
--

INSERT INTO `medicinedetails` (`MedicineName`, `MedicineID`, `UsageOfMedicine`, `CategoryOfMedicine`, `PictureOfMedicine`) VALUES
('Paracetamol 500mg', 'Par0000001', 'Used to treat fever and mild pain such as headaches, muscle pain, or back pain.', 'Pain Reliever', '../Medicine Images/1.jpg'),
('Ibuprofen 200mg', 'Ibu0000002', 'Used to reduce fever, pain, and inflammation.', 'Anti-inflammatory', '../Medicine Images/Ibuprofen 200mg.jpg'),
('Amoxicillin 250mg', 'Amox000000', 'An antibiotic used to treat a variety of bacterial infections.', 'Antibiotic', '../Medicine Images/Amoxicillin 250mg.jpg'),
('Aspirin 81mg', 'Aspi000000', 'Used to reduce pain, fever, and inflammation, and is also used to prevent heart attacks.', 'Pain Reliever', '../Medicine Images/Aspirin 81mg.jpg'),
('Metformin 500mg', 'Metf000000', 'Used to control blood sugar in type 2 diabetes.', 'Diabetes Medication', '../Medicine Images/500mgMetformin.jpg'),
('Lisinopril 10mg', 'Lisi000000', 'Used to treat high blood pressure and heart failure.', 'Blood Pressure Medication', '../Medicine Images/Lisinopril 10mg.jpg'),
('Simvastatin 10mg', 'Simv000000', 'Used to lower cholesterol and reduce the risk of cardiovascular disease.', 'Cholesterol Medication', '../Medicine Images/Simvastatin 10mg.jpg'),
('Levothyroxine 25mcg', 'Levo000000', 'Used to treat hypothyroidism (underactive thyroid).', 'Hormone Replacement', '../Medicine Images/Levothyroxine 25mcg.jpg'),
('Omeprazole 10mg', 'Ome0000009', 'Used to treat gastroesophageal reflux disease (GERD) and ulcers.', 'Antacid', '../Medicine Images/Omeprazole 10mg.jpg'),
('Lorazepam 1mg', 'Lora000001', 'Used to treat anxiety disorders and provide sedation for surgery.', 'Anxiolytic', '../Medicine Images/Lorazepam 1mg.jpg'),
('Atorvastatin 10mg', 'Ato0000001', 'Used to lower cholesterol and reduce the risk of heart disease.', 'Cholesterol Medication', '../Medicine Images/Atorvastatin 10mg.jpg'),
('Hydrochlorothiazide 12.5mg', 'Hydr000000', 'Used to treat high blood pressure and fluid retention caused by heart failure or kidney disease.', 'Diuretic', '../Medicine Images/Hydrochlorothiazide 12.5mg.jpg'),
('Albuterol 90mcg', 'Albe000000', 'Used to treat or prevent bronchospasm in asthma and chronic obstructive pulmonary disease (COPD).', 'Bronchodilator', '../Medicine Images/Albuterol 90mcg.jpg'),
('Clopidogrel 75mg', 'Clop000000', 'Used to prevent blood clots in people with heart disease or stroke.', 'Blood Thinner', '../Medicine Images/Clopidogrel 75mg.jpg'),
('Prednisone 5mg', 'Pred000000', 'Used to treat inflammation and a variety of conditions like allergies, arthritis, and autoimmune diseases.', 'Corticosteroid', '../Medicine Images/Prednisone 5mg.jpg'),
('Gabapentin 100mg', 'Gaba000000', 'Used to treat seizures and nerve pain caused by shingles.', 'Anticonvulsant', '../Medicine Images/Gabapentin 100mg.jpg'),
('Furosemide 20mg', 'Furo000000', 'Used to treat fluid retention and swelling caused by heart failure, liver disease, or kidney disease.', 'Diuretic', '../Medicine Images/Furosemide 20mg.jpg'),
('Citalopram 10mg', 'Cita000000', 'Used to treat depression, anxiety, panic attacks, and OCD.', 'Antidepressant', '../Medicine Images/Citalopram 10mg.jpg'),
('Fluoxetine 10mg', 'Fluo000000', 'Used to treat depression, obsessive-compulsive disorder (OCD), and panic attacks.', 'Antidepressant', '../Medicine Images/Fluoxetine 10mg.jpg'),
('Tamsulosin 0.4mg', 'Tams000000', 'Used to treat enlarged prostate (benign prostatic hyperplasia).', 'Prostate Medication', '../Medicine Images/Tamsulosin 0.4mg.jpg'),
('Amlodipine 5mg', 'Amlo000000', 'Used to treat high blood pressure and chest pain (angina).', 'Blood Pressure Medication', '../Medicine Images/Amlodipine 5mg.jpg'),
('Losartan 50mg', 'Los0000002', 'Used to treat high blood pressure and protect the kidneys from damage due to diabetes.', 'Blood Pressure Medication', '../Medicine Images/Losartan 50mg.jpg'),
('Doxycycline 100mg', 'Doxy000000', 'An antibiotic used to treat a wide variety of bacterial infections.', 'Antibiotic', '../Medicine Images/Diazepam 5mg.jpg'),
('Diazepam 5mg', 'Diaz000000', 'Used to relieve anxiety, muscle spasms, and seizures, and to treat alcohol withdrawal.', 'Benzodiazepine', '../Medicine Images/Diazepam 5mg.jpg'),
('Carvedilol 6.25mg', 'Carv000000', 'Used to treat heart failure, hypertension, and after heart attack.', 'Beta-Blocker', '../Medicine Images/Carvedilol 6.25mg.jpg'),
('Zolpidem 5mg', 'Zolp000000', 'Used for short-term treatment of sleep problems (insomnia).', 'Sedative', 'Medicine Images/Zolp00000026.jpg'),
('Meloxicam 7.5mg', 'Melo000000', 'Used to treat pain and inflammation in conditions like arthritis.', 'Anti-inflammatory', 'Medicine Images/Melo00000027.jpg'),
('Nitroglycerin 0.3mg', 'Nitr000000', 'Used to relieve chest pain (angina) in people with heart conditions.', 'Vasodilator', 'Medicine Images/Nitr00000028.jpg'),
('Trazodone 50mg', 'Traz000000', 'Used to treat depression and insomnia.', 'Antidepressant', 'Medicine Images/Traz00000029.jpg'),
('Bupropion 150mg', 'Bup0000003', 'Used to treat depression, anxiety, and to help people stop smoking.', 'Antidepressant', 'Medicine Images/Bup00000030.jpg'),
('Ranitidine 150mg', 'Rani000000', 'Used to treat ulcers and heartburn by reducing stomach acid.', 'Antacid', 'Medicine Images/Rani00000031.jpg'),
('Methylprednisolone 4mg', 'Metho00000', 'Used to treat inflammation and allergies, and to manage autoimmune diseases.', 'Corticosteroid', 'Medicine Images/Metho00000032.jpg'),
('Diphenhydramine 25mg', 'Diph000000', 'Used to treat allergy symptoms, hay fever, and cold symptoms.', 'Antihistamine', 'Medicine Images/Diph00000033.jpg'),
('Fexofenadine 180mg', 'Fexo000000', 'Used to treat allergy symptoms such as runny nose, sneezing, and itchy eyes.', 'Antihistamine', 'Medicine Images/Fexo00000034.jpg'),
('Mupirocin 2% Ointment', 'Mupi000000', 'Used to treat bacterial skin infections, including impetigo.', 'Antibiotic', 'Medicine Images/Mupi00000035.jpg'),
('Ketoconazole 2% Cream', 'Keto000000', 'Used to treat fungal infections of the skin, including athlete’s foot and ringworm.', 'Antifungal', 'Medicine Images/Keto00000036.jpg'),
('12', '', '15', '120', 'uploads/15.png');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `Patient_Id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `First_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Last_Name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Gender` enum('Male','Female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `Date of birth` date NOT NULL,
  `Contact_No` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Address` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Emergency_Contact` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Blood_Type` enum('A+','A-','B+','B+','AB+','AB-','O+','O-') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Diabetic_Type` enum('None','Type 1','Type 2','Gestational') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Diabetic_level(Mg/DL)` double NOT NULL,
  `Cholosterol_Level(Mg/DL)` double NOT NULL,
  `Blood_Presure` double NOT NULL,
  `Password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Login_Count` int NOT NULL,
  `Image` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`Patient_Id`, `First_name`, `Last_Name`, `Gender`, `Date of birth`, `Contact_No`, `Email`, `Address`, `Emergency_Contact`, `Blood_Type`, `Diabetic_Type`, `Diabetic_level(Mg/DL)`, `Cholosterol_Level(Mg/DL)`, `Blood_Presure`, `Password`, `Login_Count`, `Image`) VALUES
('200421801205', 'Chathusha', 'Jayodaya', 'Male', '2004-08-05', '0760739009', 'Chathushadewmin@gmail.com', 'Idilanda,Galpatha,Kaluthara', '0717101852', 'O+', 'None', 98, 98, 98, '0805', 98, '../Patient Images/2.jpg'),
('200421801208', 'Nithika', 'Dilen', 'Male', '2024-11-06', '0767390095', 'dewminpulasinghe@gmail.com', 'indilanda', '0717101852', 'A+', 'None', 100, 100, 70, '1234', 0, '../Patient Images/200421801208.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `patient-allergy`
--

DROP TABLE IF EXISTS `patient-allergy`;
CREATE TABLE IF NOT EXISTS `patient-allergy` (
  `Patient ID` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Allergy ID` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient-allergy`
--

INSERT INTO `patient-allergy` (`Patient ID`, `Allergy ID`) VALUES
('200421801205', '1'),
('200421801205', '5');

-- --------------------------------------------------------

--
-- Table structure for table `patient-blood-pressure`
--

DROP TABLE IF EXISTS `patient-blood-pressure`;
CREATE TABLE IF NOT EXISTS `patient-blood-pressure` (
  `Patient ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Date` date NOT NULL,
  `Systolic` double NOT NULL,
  `Diastolic` double NOT NULL,
  `Report` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient-blood-pressure`
--

INSERT INTO `patient-blood-pressure` (`Patient ID`, `Date`, `Systolic`, `Diastolic`, `Report`) VALUES
('200421801208', '2024-11-26', 72, 0, ''),
('200421801205', '2024-11-26', 72, 0, ''),
('200421801205', '2024-11-17', 85, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `patient-cholesterol`
--

DROP TABLE IF EXISTS `patient-cholesterol`;
CREATE TABLE IF NOT EXISTS `patient-cholesterol` (
  `Patient ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Date` date NOT NULL,
  `Cholesterol Level` double NOT NULL,
  `Report` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient-cholesterol`
--

INSERT INTO `patient-cholesterol` (`Patient ID`, `Date`, `Cholesterol Level`, `Report`) VALUES
('200421801205', '2024-11-28', 100, 'patient-cholesterol-report-2024-11-28-200421801205.pdf'),
('200421801205', '2024-11-28', 100, 'patient-cholesterol-report-2024-11-28-200421801205.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `patient-diabetic`
--

DROP TABLE IF EXISTS `patient-diabetic`;
CREATE TABLE IF NOT EXISTS `patient-diabetic` (
  `Patient ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Diabetic Level` double NOT NULL,
  `Date` date NOT NULL,
  `Report` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient-diabetic`
--

INSERT INTO `patient-diabetic` (`Patient ID`, `Diabetic Level`, `Date`, `Report`) VALUES
('200421801205', 101, '0000-00-00', ''),
('200421801205', 101, '0000-00-00', ''),
('200421801205', 75, '2024-11-15', ''),
('200421801205', 110, '2024-11-19', ''),
('200421801205', 90, '2024-10-23', ''),
('200421801205', 110, '2024-11-01', ''),
('200421801205', 90, '2024-11-27', '../Patients/Diabetic_reports/DiabeticAnalyze.php'),
('', 110, '2024-11-01', ''),
('200421801205', 100, '2024-11-28', 'patient-report-2024-11-28-200421801205.pdf'),
('200421801205', 100, '2024-11-28', 'patient-report-2024-11-28-200421801205.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `patient-doctor meetups`
--

DROP TABLE IF EXISTS `patient-doctor meetups`;
CREATE TABLE IF NOT EXISTS `patient-doctor meetups` (
  `MeetUp ID` int NOT NULL AUTO_INCREMENT,
  `Patient ID` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Doctor ID` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Host` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Date` date NOT NULL,
  `Diagnoze Name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Diagnoze Description` varchar(3000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Treatment Description` varchar(3000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Important Notes` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Rate` double NOT NULL,
  PRIMARY KEY (`MeetUp ID`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient-doctor meetups`
--

INSERT INTO `patient-doctor meetups` (`MeetUp ID`, `Patient ID`, `Doctor ID`, `Host`, `Date`, `Diagnoze Name`, `Diagnoze Description`, `Treatment Description`, `Important Notes`, `Rate`) VALUES
(1, '200421801205', '10326', '', '2024-11-25', '1', '1', '1', '1', 4.9),
(2, '200421801205', '10326', '', '2024-11-25', 'dew', 'dewmin', 'dewmin', 'dewmin123', 3.5),
(3, '200421801205', '10326', '', '2024-11-26', '1212', '516', '5134', '3154', 4),
(4, '200421801205', '10326', '', '2024-11-26', '1212', '516', '5134', '3154', 5),
(5, '200421801205', '10326', '', '2024-11-26', '1212', '516', '5134', '3154', 4),
(6, '200421801205', '10326', '', '2024-11-26', '1212', '10', '10', '10', 4),
(7, '200421801205', '10326', '', '2024-11-26', '1212', '12', '12', '12', 0),
(8, '200421801205', '10326', '', '2024-11-26', '1212', '12', '12', '12', 0),
(9, '200421801205', '10326', '', '2024-11-26', '', '', '', '', 0),
(10, '200421801205', '10326', '', '2024-11-26', 'fever', 'rftjgngn', 'fhmhmgh', 'fgnfgmgfm', 0),
(11, '200421801205', '10326', '', '2024-11-26', 'fever', 'rftjgngn', 'fhmhmgh', 'fgnfgmgfm', 0),
(12, '200421801205', '10326', '', '2024-11-26', '18', '1+786', '614', '3145', 0),
(13, '200421801205', '10326', 'private', '2024-11-28', 'Diagnoze 1', 'diagnoze 2', '9+176', '971+', 0),
(14, '200421801205', '10326', 'private', '2024-11-28', 'Diagnoze 1', 'diagnoze 2', '9+176', '971+', 0),
(15, '200421801205', '10326', 'private', '2024-11-28', 'Diagnoze 1', 'diagnoze 2', '9+176', '971+', 0),
(16, '200421801205', '10326', 'private', '2024-11-28', 'Diagnoze 1', 'diagnoze 2', '9+176', '971+', 0),
(17, '200421801205', '10326', 'private', '2024-11-28', 'Diagnoze 1', 'diagnoze 2', '9+176', '971+', 0),
(18, '200421801205', '10326', 'private', '2024-11-28', 'Diagnoze 1', 'diagnoze 2', '9+176', '971+', 0),
(19, '200421801205', '10326', 'private', '2024-11-28', '', '', '', '', 0),
(20, '200421801205', '10289', 'private', '2024-11-28', '', '', '', '', 0),
(21, '200421801205', '12786', 'HOSP008', '2024-11-29', '', '', '', '', 0),
(22, '200421801205', '12786', 'HOSP008', '2024-11-29', '', '', '', '', 0),
(23, '200421801205', '12786', 'HOSP008', '2024-11-29', '', '', '', '', 0),
(24, '200421801205', '12786', 'HOSP008', '2024-11-29', '', '', '', '', 0),
(25, '200421801205', '12786', 'HOSP008', '2024-11-29', 'fever ', '', '', '', 0),
(26, '200421801205', '12786', 'HOSP008', '2024-11-29', 'abc', '', '', '', 0),
(27, '200421801205', '12786', 'HOSP008', '2024-11-29', '8787', '', '', '', 0),
(28, '200421801205', '12786', 'HOSP008', '2024-11-29', 'fever ', 'nigy', 'infy', 'infy', 0),
(29, '200421801205', '12786', 'HOSP008', '2024-11-29', 'fever ', '21', '21', '21', 0),
(30, '200421801205', '12786', 'HOSP008', '2024-11-29', 'fever ', '', '', '', 0),
(31, '200421801205', '12786', 'HOSP008', '2024-11-29', '', '', '', '', 0),
(32, '200421801205', '12786', 'HOSP008', '2024-11-29', 'fever ', '210', '', '', 0),
(33, '200421801205', '12786', 'HOSP008', '2024-11-29', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `patient-report`
--

DROP TABLE IF EXISTS `patient-report`;
CREATE TABLE IF NOT EXISTS `patient-report` (
  `Patient ID` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Issued By` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Report Name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Report Descrtiotion` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Date` date NOT NULL,
  `Report File` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient-report`
--

INSERT INTO `patient-report` (`Patient ID`, `Issued By`, `Report Name`, `Report Descrtiotion`, `Date`, `Report File`) VALUES
('200421801205', 'HealthLAnka', '1', '12', '2024-11-26', '../dewminffvb.jpg'),
('200421801205', '', '5', '', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `specialization`
--

DROP TABLE IF EXISTS `specialization`;
CREATE TABLE IF NOT EXISTS `specialization` (
  `Specilizaton ID` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Description` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `specialization`
--

INSERT INTO `specialization` (`Specilizaton ID`, `Name`, `Description`) VALUES
('SPEC001', 'Cardiology', 'Focuses on diagnosing and treating heart disorders.'),
('SPEC002', 'Dermatology', 'Specializes in skin, hair, and nail conditions.'),
('SPEC003', 'Neurology', 'Deals with disorders of the nervous system.'),
('SPEC004', 'Orthopedics', 'Focuses on the musculoskeletal system, including bones and joints.'),
('SPEC005', 'Pediatrics', 'Provides medical care for infants, children, and adolescents.'),
('SPEC006', 'Oncology', 'Specializes in the diagnosis and treatment of cancer.'),
('SPEC007', 'Gynecology', 'Focuses on women’s reproductive health.'),
('SPEC008', 'Psychiatry', 'Deals with mental health, including emotional and behavioral disorders.'),
('SPEC009', 'Ophthalmology', 'Focuses on eye care and vision correction.'),
('SPEC010', 'Endocrinology', 'Specializes in hormonal and metabolic disorders.'),
('SPEC011', 'Gastroenterology', 'Deals with disorders of the digestive system.'),
('SPEC012', 'Pulmonology', 'Focuses on respiratory system disorders, including the lungs.'),
('SPEC013', 'Nephrology', 'Specializes in kidney health and treatment of kidney diseases.'),
('SPEC014', 'Rheumatology', 'Deals with arthritis and autoimmune diseases affecting joints.'),
('SPEC015', 'Radiology', 'Focuses on imaging techniques such as X-rays, MRIs, and CT scans.'),
('SPEC016', 'Hematology', 'Specializes in blood disorders and diseases.'),
('SPEC017', 'Anesthesiology', 'Focuses on pain management and anesthesia during surgeries.'),
('SPEC018', 'Urology', 'Deals with urinary tract and male reproductive system disorders.'),
('SPEC019', 'Emergency Medicine', 'Provides immediate care for acute illnesses and injuries.'),
('SPEC020', 'Plastic Surgery', 'Specializes in reconstructive and cosmetic surgical procedures.');

-- --------------------------------------------------------

--
-- Table structure for table `username`
--

DROP TABLE IF EXISTS `username`;
CREATE TABLE IF NOT EXISTS `username` (
  `UserID` int NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Sale` int NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `username`
--

INSERT INTO `username` (`UserID`, `UserName`, `password`, `Sale`) VALUES
(1, 'Admin', 'Admin123', 1000);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
