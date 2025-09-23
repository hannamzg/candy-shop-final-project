-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 08, 2025 at 11:17 PM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u223857276_church`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_Id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_Id`, `username`, `password`, `created_at`) VALUES
(2, 'hannamzg', '$2y$10$hbwihVcjeM/07EKlsSL7XOWafPMcgJhdqKjB5HZYSh5IHKr0DQzyW', '2024-10-05 12:25:35');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `client_id`, `title`, `description`, `created_at`) VALUES
(3, 1, 'كتب روحية للقراءة', NULL, '2024-10-06 17:43:22'),
(4, 1, 'كتب لاهوت', NULL, '2024-10-18 07:42:42'),
(6, 1, 'كتب طقسية للخدمة', NULL, '2024-10-21 14:25:19'),
(13, 2, 'מטבחים שלנו', NULL, '2024-10-22 18:41:40'),
(14, 2, 'חדר שינה', NULL, '2024-10-22 23:50:11'),
(15, 2, 'אחר', NULL, '2024-10-25 18:49:36');

-- --------------------------------------------------------

--
-- Table structure for table `classpage`
--

CREATE TABLE `classpage` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `ClassID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `linkText` varchar(255) DEFAULT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classpage`
--

INSERT INTO `classpage` (`id`, `client_id`, `ClassID`, `title`, `content`, `img`, `link`, `linkText`, `priority`) VALUES
(34, 2, 13, 'מטבח כפרי', 'משתמש בחומרים טבעיים ובעל מראה חמים ומזמין. כולל ארונות מעוטרים, גימורים בהירים, ולעיתים פרטי נוי כמו סלסלות או כלי חרס.', '', '', 'עוד פריטים', 1),
(35, 2, 13, 'מטבח אינטגרלי', 'מחובר בצורה חלקה עם שאר הבית. שימוש בחומרים ורצפות אחידים ליצירת מראה אחיד. נועד להרגיש כחלק מהחלל הכללי ולא מנותק.', '', '', 'עוד פריטים', 10),
(37, 1, 4, 'المحاربات الروحية', '', 'غلاف-المحاربات-الروحية-لثيوفان-الناسك-الجزء-الأول-القمص-لوقا-سيداروس-221x300.jpg', 'https://acrobat.adobe.com/id/urn:aaid:sc:AP:a0f72ebe-fb43-4827-9319-9df7fcd5d8f9', 'تحميل الكتاب', 1),
(43, 1, 6, 'كتاب خدمة الكاهن', '', 'Screenshot 2024-10-25 213620.png', 'https://drive.google.com/file/d/19jTYWrnL5soXZGaulEJIC3EnfsLlgq9k/view?usp=sharing', 'تحميل الكتاب', 0),
(44, 1, 6, 'كتاب الإنجيل الشريف والرسائل', '', 'Screenshot 2024-10-25 214153.png', 'https://drive.google.com/file/d/1Fr0T_u6WcCJTFiVrUd53iAO_olRvlVL7/view?usp=drive_link', 'تحميل الكتاب', 0),
(45, 2, 13, 'מטבחים קלאסיים	', 'מטבח קלאסי מתוכנן ומעוצב בהשראה ויקטוריאנית, שבה הפרטים הקטנים, וביניהם הקישוטים, הגימורים והפיתוחים עשויים בעבודת יד אמן מוקפדת. במטבח זה העץ הכבד נותן את אותותיו, באופן שלא ניתן להתעלם ממנו או להתכחש אליו. פה עולים באף ניחוחות תבשילי קדרת הברזל היצוק, המתחממים לאיטם מעל האש המבערת, לקול פיצפוצי הגיצים העולם לאוויר ונעלמים לתוך הארובה	', '139781068_2819886844916274_9171180682271333363_n.jpg', '', 'עוד פריטים', 1),
(46, 2, 15, 'קיר מעוצב מעץ', '', '80001432_2468275273410768_3530089717150253056_n.jpg', '', 'עוד פריטים', 0),
(47, 2, 14, 'חדרי ילדים	', 'עיצוב מסורתי עם רהיטים מעץ מלא, גוונים חמים, וטקסטיל עשיר. כולל מיטה גדולה, שידות ליד המיטה וארון בגדים מעוטר.	', '2361db37-5033-4994-9206-4f5f1c77e416.jpg', '', 'עוד פריטים', 1),
(48, 1, 4, 'حرب المشغولية', '', 'كتاب-حرب-المشغولية-PDF.jpg', 'https://drive.google.com/file/d/1Bs--Q2k_wzkK0b2UQQ5Qk-yAxfApMaEI/view?usp=sharing', 'تحميل الكتاب', 1),
(50, 1, 4, 'سلسلة الحروب الروحية - جزء 2 ', '', '89d18167-3b76-444f-9c83-1b7cf6c78188.jpeg', 'https://drive.google.com/file/d/1BEvnjO-v1dx_jKFejir64uByJgEnivMx/view?usp=sharing', 'تحميل الكتاب', 0),
(51, 1, 3, 'ميامر وصلوات القديس إسحاق السرياني', '', '3c075a14-cddc-415f-abe2-4008b7a3e2aa.jpeg', 'https://drive.google.com/file/d/1EQd7XpR1cCWyxSPzCsdfInOq-V-3bdzS/view?usp=sharing', 'تحميل الكتاب', 0),
(53, 1, 3, 'حروب الشياطين - الحروب الروحية 1', '', '61a8e702-490d-4818-817c-ddadbe56b51f.jpeg', 'https://drive.google.com/file/d/1BMLknBiF7N-pIECfPBdreTtx_Dw8bAQY/view?usp=sharing', 'تحميل الكتاب', 0),
(55, 2, 13, 'מטבח מודרני', 'קווים נקיים ועיצובים מינימליסטיים. משתמש בחומרים כמו זכוכית, מתכת ועץ בגימור חלק. צבעים לרוב נייטרליים עם אלמנטים דומיננטיים כמו אי מרכזי.	', '27000012-e199-4e8b-88d5-e8ae6e74dec7.jpg', '', 'עוד פריטים', 0),
(56, 2, 15, 'בר מעץ', '', 'b49936ee-4249-4b3b-99e2-1c2cc43065f5.jpg', '', 'עוד פריטים', 0),
(57, 2, 15, 'חדרי כביסה', '', '5b309f55-bb01-4e91-a6d0-8f8823685373.jpg', '', 'עוד פריטים', 0),
(58, 2, 15, 'ארונות אמבטיה', '', 'fdfd8429-89f4-498f-909e-c0492a499523.jpg', '', 'עוד פריטים', 0);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `domin` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `domin`) VALUES
(1, 'abusnanchurch.com'),
(2, 'mzeget.site');

-- --------------------------------------------------------

--
-- Table structure for table `client_navbar`
--

CREATE TABLE `client_navbar` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `page_link` varchar(255) NOT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `show_item` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client_navbar`
--

INSERT INTO `client_navbar` (`id`, `client_id`, `page_name`, `page_link`, `display_order`, `show_item`) VALUES
(2, 2, 'ראשי', '/index.php', 1, 1),
(3, 2, 'גלריה', '/gallery.php', 3, 1),
(4, 2, 'שאלות נפוצות', '/services.php', 4, 1),
(5, 2, 'מי אנחנו', '/about.php', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `pageID` int(11) NOT NULL,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `content` text NOT NULL,
  `img` varchar(500) NOT NULL,
  `link` varchar(200) NOT NULL,
  `linkText` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `client_id`, `pageID`, `title`, `content`, `img`, `link`, `linkText`, `created_at`, `updated_at`) VALUES
(32, 1, 7, 'أطفال مدرسة الأحد أبوسنان ', 'قال الرب: \"دعوا الأولاد يأتون إلي ولا تمنعوهم\". من هنا تأتي أهمية التنشئة المسيحية بحسب الإيمان المستقيم. ضمن نشاطاتنا الرعوية المختلفة تقوم أسرة أبناء الملك باستقبال أطفال الرعية كل يوم أحد بعد خدمة القداس الإلهي في فعاليات متعددة تتمثل في قراءة إنجيل الأحد وشرحه، إضافةً إلى ترانيم روحية وفعاليات يدوية وترفيهية مختلفة.', '', '', '', '2024-10-11 22:12:13', '2024-10-27 16:33:53'),
(47, 1, 2, 'صور', '', '', '', '', '2024-10-19 17:30:36', '2024-10-22 14:48:39'),
(73, 2, 5, 'נגרייה אלי מזיגית', 'נגרייה אלי מזיגית מתמחה בעיצוב וביצור מטבחים ואורנות בהתאמה אישית. עם ניסיון של שנים רבות בתחום, אלי מציע פתרונות מותאמים אישית לכל לקוח, תוך דגש על איכות, פונקציונליות ועיצוב מודרני. בנגירייה, תהליך העבודה כולל תכנון מעמיק שמתחיל משלב הייעוץ ועד לביצוע הסופי, והכל תוך שיתוף פעולה הדוק עם הלקוחות. אלי וצוותו משתמשים בחומרים איכותיים וחדשניים, מה שמבטיח תוצאות שמחזיקות מעמד לאורך זמן. העיצובים של נגירייה אלי מזיגית הם שילוב של פרקטיות ואסתטיקה, עם תשומת לב לפרטים הקטנים. בין הפרויקטים המרשימים ניתן למצוא מטבחים מודרניים, ארונות קיר בעיצובים ייחודיים ורהיטים בהתאמה אישית לכל חלל. אם אתם מחפשים לשדרג את הבית שלכם עם מטבח או ריהוט איכותי, נגירייה אלי מזיגית היא הבחירה הנכונה.	', 'SAM_3804.jpg', '', '', '2024-10-22 18:34:10', '2024-10-22 18:40:09'),
(74, 2, 2, ' גלריה ', '', '', '', '', '2024-10-22 18:48:15', '2024-10-22 18:50:02'),
(78, 1, 6, 'عظة \"انتظر عمل الرب\" - عيد دخول السيد إلى الهيكل', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/ZMAC6oGWvRU?si=BIgunN7Ao1YyUb7T\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', '', '', '', '2024-10-23 18:16:14', '2025-02-21 09:57:52'),
(80, 1, 1, '', '', 'WhatsApp Image 2024-10-23 at 22.29.08_62d1d797.jpg', '', '', '2024-10-25 12:43:13', '2024-10-25 12:43:13'),
(85, 1, 5, 'كنيسة القديس جوارجيوس الأرثوذكسية في قرية أبوسنان', 'قرية أبوسنان هي قرية مختلطة في الجليل الغربي بالأراضي المقدسة. وغالبية المسيحيين فيها هم أبناء الرعية الأرثوذكسية التي يرعاها قدس الإيكونومس نيقولاوس موسى. يبلغ عدد أبناء الرعية المسيحية الأرثوذكس في قرية أبوسنان حوالي 2200 شخصًا وفيها كنيسة أرثوذكسية لخدمة الرعية وكنيسة أرثوذكسية أخرى تقع داخل المقبرة وهي كنيسة أثرية عمرها مئات السنين.	', 'WhatsApp Image 2024-10-25 at 18.38.16_9d02915c.jpg', '', '', '2024-10-26 18:54:16', '2024-10-26 18:54:16'),
(90, 1, 4, 'الشبيبة المسيحية', 'شبيبة القديس جوارجيوس الأرثوذكسية في أبوسنان هي شبيبة مسيحية تهدف إلى بناء شبيبة مؤمنة تسيبر بحسب وصايا الرب وتعاليم الإنجيل المقدس. تتميز شبيبتنا بالمحبة الأخوية بين أعضائها وبفعالياتها المنوعة ونشاطاتها المختلفة\r\n', '', '', '', '2024-10-26 22:52:36', '2024-10-26 22:52:36'),
(91, 1, 8, 'فعالية أبناء الملك عن مثل الزارع', '', 'WhatsApp Image 2024-10-27 at 13.47.49_add4b857.jpg', '', 'المزيد من الصور', '2024-10-27 13:42:51', '2024-10-27 13:43:27'),
(93, 1, 8, 'إخراج يسوع للشياطين', 'الرب يسوع المسيح صاحب السلطان', 'WhatsApp Image 2024-11-03 at 13.23.17_fe1f667f.jpg', '', 'المزيد من الصور', '2024-11-09 14:22:00', '2024-11-09 14:22:00'),
(94, 1, 3, 'عشاء الشبيبة', 'عشاء يجمع أفراد الشبيبة', 'WhatsApp Image 2024-10-27 at 01.42.02_43565db3.jpg', 'المزيد من الصور', 'المزيد من الصور', '2024-11-09 14:30:05', '2024-11-09 14:30:05'),
(95, 1, 8, 'معجزة السيد المسيح', 'قَالَ لَهَا: «يَا ابْنَةُ، إِيمَانُكِ قَدْ شَفَاكِ، اذْهَبِي بِسَلاَمٍ وَكُونِي صَحِيحَةً مِنْ دَائِكِ».\r\nمعجزة السيد المسيح في شفاء المرأة نازفة الدم، ومعجزة إقامة ابنة يايرُس من بين الأموات', '467458264_10226210374542683_8966177166604611414_n.jpg', '', 'المزيد من الصور', '2024-11-17 13:24:59', '2024-11-17 13:24:59'),
(96, 1, 3, 'فعالية أكمل الآية', '\"فَقَالَ لَهُ يَسُوعُ: «إِنْ كُنْتَ تَسْتَطِيعُ أَنْ تُؤْمِنَ. كُلُّ شَيْءٍ مُسْتَطَاعٌ لِلْمُؤْمِنِ».\"', 'A5FC47D3-F5E2-4898-A7EC-A6BF3AD48CB4.jpeg', '', 'المزيد من الصور', '2024-11-22 10:27:09', '2024-11-22 10:27:09'),
(99, 1, 8, 'مثل السامري الصالح', 'فعاليات الأحباء الصغار - مثل السامري الصالح', '097e5501-c7b4-4c02-a918-1c3f5ad03b67.jpeg', 'المزيد من الصور', 'المزيد من الصور', '2024-11-24 19:13:17', '2024-11-24 19:14:22'),
(100, 1, 8, 'الدعوة الى العرس السماوي', '', '32b54dbb-4775-4361-b144-095703a6bbe9.jpeg', 'المزيد من الصور', 'المزيد من الصور', '2025-01-27 11:36:12', '2025-01-27 11:36:12');

-- --------------------------------------------------------

--
-- Table structure for table `general_elements`
--

CREATE TABLE `general_elements` (
  `id` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `icon` varchar(3000) NOT NULL,
  `background_img1` varchar(255) DEFAULT NULL,
  `background_img2` varchar(255) DEFAULT NULL,
  `background_img3` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `title_page2` varchar(255) DEFAULT NULL,
  `title_page3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_elements`
--

INSERT INTO `general_elements` (`id`, `ClientID`, `client_name`, `phone`, `facebook`, `icon`, `background_img1`, `background_img2`, `background_img3`, `description`, `title_page2`, `title_page3`) VALUES
(5, 2, 'נגריית אלי מזיגית', '0525119685', '', '20241022155553_ICON1.png', '20241022153052_background new.jpg', '', '', 'נגריית אלי מזיגית מתמחה בעיצוב וביצור מטבחים ואורנות בהתאמה אישית. עם ניסיון של שנים רבות בתחום', 'test2', 'test3'),
(6, 1, 'كنيسة القديس جوارجيوس الارثوذكسية - أبوسنان', '0', '', '', '', '', '', 'كنيسة القديس جوارجيوس أبوسنان', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `attempts` int(11) NOT NULL DEFAULT 0,
  `last_attempt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mainsilderimg`
--

CREATE TABLE `mainsilderimg` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `page` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mainsilderimg`
--

INSERT INTO `mainsilderimg` (`id`, `client_id`, `img`, `page`, `created_at`) VALUES
(20, 2, 'SAM_3804.jpg', 1, '2024-10-22 18:35:45'),
(33, 1, 'af0bd41a-e956-40cf-a2cc-4acb1888b908.jpeg', 1, '2024-10-25 18:24:07'),
(34, 1, 'd4d6ee2c-e8ac-4a98-b318-2163b1dda779.jpeg', 1, '2024-10-25 18:24:54'),
(35, 1, '81827793-daf7-46bd-b1bf-94bf140534ec.jpeg', 1, '2024-10-25 18:25:22'),
(36, 1, 'IMG_5529.jpeg', 1, '2024-10-25 18:26:02'),
(37, 1, 'IMG_5523.jpeg', 1, '2024-10-25 18:26:50'),
(38, 1, 'IMG_5524.jpeg', 1, '2024-10-25 18:27:21'),
(39, 1, 'IMG_5526.jpeg', 1, '2024-10-25 18:28:12'),
(42, 2, '139781068_2819886844916274_9171180682271333363_n.jpg', 45, '2024-10-25 18:59:07'),
(43, 2, '139458467_2819886834916275_850871242881701092_n.jpg', 45, '2024-10-25 19:01:55'),
(44, 2, '139781068_2819886844916274_9171180682271333363_n.jpg', 1, '2024-10-25 19:02:55'),
(45, 2, '80001432_2468275273410768_3530089717150253056_n.jpg', 1, '2024-10-25 19:03:44'),
(46, 2, '79278631_2468542390050723_8768341584946135040_n.jpg', 46, '2024-10-25 19:06:32'),
(47, 2, '80001432_2468275273410768_3530089717150253056_n.jpg', 46, '2024-10-25 19:07:04'),
(49, 2, '458476336_3775848119320137_4194093141021137689_n.jpg', 47, '2024-10-25 19:09:28'),
(51, 2, '458476336_3775848119320137_4194093141021137689_n.jpg', 1, '2024-10-25 19:10:05'),
(52, 2, '458692020_3775848255986790_7584708277185232989_n.jpg', 47, '2024-10-25 19:10:54'),
(53, 1, 'MainWhatsApp Image 2024-10-25 at 18.38.16_077c629a.jpg', 86, '2024-10-26 20:59:52'),
(54, 1, 'WhatsApp Image 2024-10-18 at 10.33.57_7ab4a48a.jpg', 86, '2024-10-26 21:03:30'),
(56, 1, '1e798661-a327-48f5-9695-a6786876f9df.jpeg', 88, '2024-10-26 22:47:01'),
(58, 1, '91d2cc33-8348-4b8e-a3d5-b5589fe04814.jpeg', 88, '2024-10-26 22:47:36'),
(59, 1, 'd6989e30-8970-4e86-ad66-1bd53b802911.jpeg', 88, '2024-10-26 22:47:57'),
(60, 1, 'f90cf273-1eaa-4f78-9a22-3ab7b5a14c4f.jpeg', 88, '2024-10-26 22:48:14'),
(61, 1, 'WhatsApp Image 2024-10-27 at 13.47.49_57c4258f.jpg', 91, '2024-10-27 13:43:46'),
(63, 1, 'WhatsApp Image 2024-10-27 at 13.47.49_add4b857.jpg', 91, '2024-10-27 13:44:03'),
(64, 1, 'WhatsApp Image 2024-10-27 at 13.47.50_1e421a1c.jpg', 91, '2024-10-27 13:44:09'),
(65, 1, 'WhatsApp Image 2024-10-27 at 13.47.50_55762546.jpg', 91, '2024-10-27 13:44:17'),
(66, 1, 'WhatsApp Image 2024-10-27 at 13.47.50_b08406f8.jpg', 91, '2024-10-27 13:44:24'),
(67, 1, 'WhatsApp Image 2024-10-27 at 13.47.50_d8b93f61.jpg', 91, '2024-10-27 13:44:30'),
(68, 1, 'WhatsApp Image 2024-10-27 at 13.47.51_84469017.jpg', 91, '2024-10-27 13:44:36'),
(84, 2, '12d28fa7-d693-4c43-b814-70e81bb2013f.jpg', 47, '2024-11-07 16:56:24'),
(85, 2, 'b2a80a55-e3b1-402b-b799-bcd3e231dc15.jpg', 46, '2024-11-07 16:56:54'),
(86, 2, 'd04b0c93-e4de-402c-bb5e-14e5fd9970d5.jpg', 45, '2024-11-07 16:57:40'),
(87, 2, '27000012-e199-4e8b-88d5-e8ae6e74dec7.jpg', 55, '2024-11-07 16:59:49'),
(88, 2, '5b309f55-bb01-4e91-a6d0-8f8823685373.jpg', 57, '2024-11-07 17:04:29'),
(90, 2, 'fdfd8429-89f4-498f-909e-c0492a499523.jpg', 58, '2024-11-07 17:53:00'),
(91, 2, '2361db37-5033-4994-9206-4f5f1c77e416.jpg', 47, '2024-11-07 17:54:14'),
(92, 2, 'd2b0b21d-5300-4a4c-9c28-0526f4bdf9dc.jpg', 45, '2024-11-07 17:59:54'),
(93, 2, 'd04b0c93-e4de-402c-bb5e-14e5fd9970d5.jpg', 45, '2024-11-07 18:02:07'),
(94, 2, '6f566845-accc-4a1b-94d2-bf5e5a145da2.jpg', 58, '2024-11-07 18:02:56'),
(95, 2, '5017d09e-3dba-48e7-8e95-27291f4dd469.jpg', 45, '2024-11-07 18:04:04'),
(96, 2, 'ae042cd1-aa78-44ab-aeec-6ac8af412f7a.jpg', 45, '2024-11-07 18:04:13'),
(97, 2, '3f4e1591-3a3f-411b-96e7-8dd72cad9a90.jpg', 45, '2024-11-07 18:04:21'),
(98, 1, 'WhatsApp Image 2024-11-03 at 13.23.17_a12aabfb.jpg', 93, '2024-11-09 14:22:40'),
(99, 1, 'WhatsApp Image 2024-11-03 at 13.23.17_eabf19c3.jpg', 93, '2024-11-09 14:22:58'),
(100, 1, 'WhatsApp Image 2024-11-03 at 13.23.17_8c053897.jpg', 93, '2024-11-09 14:23:19'),
(101, 1, 'WhatsApp Image 2024-11-03 at 13.23.17_029dffdb.jpg', 93, '2024-11-09 14:23:48'),
(102, 1, 'WhatsApp Image 2024-11-03 at 13.23.18_135730ae.jpg', 93, '2024-11-09 14:24:11'),
(103, 1, 'WhatsApp Image 2024-11-03 at 13.23.18_e31f2dcc.jpg', 93, '2024-11-09 14:24:17'),
(104, 1, 'WhatsApp Image 2024-11-03 at 13.23.17_fe1f667f.jpg', 93, '2024-11-09 14:24:40'),
(105, 1, 'WhatsApp Image 2024-10-27 at 01.42.02_43565db3.jpg', 94, '2024-11-09 14:30:42'),
(106, 1, '338c469d-0179-4942-b267-2d7e39eea6bd.jpeg', 94, '2024-11-09 14:33:05'),
(107, 1, '91d2cc33-8348-4b8e-a3d5-b5589fe04814.jpeg', 94, '2024-11-09 14:33:14'),
(109, 1, 'd6989e30-8970-4e86-ad66-1bd53b802911.jpeg', 94, '2024-11-09 14:33:31'),
(110, 1, '2776f287-74ad-4b22-be9a-0fa92dcf786c.jpeg', 94, '2024-11-09 14:33:43'),
(111, 1, '70b334c0-2838-4e1f-bfe6-2da78ec51efc.jpeg', 95, '2024-11-17 13:26:25'),
(112, 1, '759eaa00-be00-40c7-9da1-68b38139b132.jpeg', 95, '2024-11-17 13:26:37'),
(113, 1, '0f79d7e1-67e5-4c8d-805f-d0ae07c63902.jpeg', 95, '2024-11-17 13:26:46'),
(114, 1, 'ab8de9dc-49d4-4b54-b87f-947ce9b17d00.jpeg', 95, '2024-11-17 13:26:53'),
(115, 1, '01e7cf4b-bc55-4175-bd94-b2b8e5be093d.jpeg', 95, '2024-11-17 13:27:02'),
(117, 1, '3a1deed2-13cf-4815-ba0c-1fa81e907475.jpeg', 95, '2024-11-17 13:27:19'),
(118, 1, '3d72a1a4-b090-4d69-804f-32ee5d26792f.jpeg', 95, '2024-11-17 13:27:26'),
(120, 1, '5F3B054E-8E1F-40A5-9AFE-9B5048D549C6.jpeg', 96, '2024-11-22 10:28:45'),
(122, 1, '8DFBC858-9EC3-43C0-A19C-9F5BFE443618.jpeg', 96, '2024-11-22 10:29:51'),
(123, 1, 'C8954C1A-3300-46A3-97A9-70DB2FB26E02.jpeg', 96, '2024-11-22 10:30:08'),
(124, 1, 'A5FC47D3-F5E2-4898-A7EC-A6BF3AD48CB4.jpeg', 96, '2024-11-22 10:30:32'),
(125, 1, 'ae8ebb1b-eab5-49b8-889e-f32b035f54ad.jpeg', 99, '2024-11-24 19:15:13'),
(126, 1, '4e6f7b40-a74e-4440-9223-f8a1a3b81bb5.jpeg', 99, '2024-11-24 19:15:22'),
(127, 1, 'd1a6c5de-e5ae-4baf-9562-cabbf69877b9.jpeg', 99, '2024-11-24 19:15:34'),
(128, 1, '6ffaa586-52df-4ce7-ae04-3ef64a93b891.jpeg', 99, '2024-11-24 19:15:44'),
(129, 1, '0080da2f-6ea8-44ef-b44b-7fb97efe2c06.jpeg', 99, '2024-11-24 19:15:54'),
(130, 1, 'fcc14ad6-487e-40e8-a2c2-ec50fca2cb0c.jpeg', 99, '2024-11-24 19:16:03'),
(131, 1, '6c9c5330-19b1-47ae-9cd7-360a692ec273.jpeg', 99, '2024-11-24 19:16:12'),
(132, 1, '80fb08ab-197d-4e4d-8a0b-9d0945ca720a.jpeg', 99, '2024-11-24 19:16:22'),
(133, 1, 'fc834ba7-b94e-4138-aa2f-607ce35b5b3a.jpeg', 99, '2024-11-24 19:16:31'),
(134, 1, '097e5501-c7b4-4c02-a918-1c3f5ad03b67.jpeg', 99, '2024-11-24 19:16:52'),
(135, 1, '14ffc034-6708-47b7-b2a3-68b4e049d12d.jpeg', 100, '2025-01-27 11:36:36'),
(136, 1, 'a87a642c-0615-49ae-b7e2-b92f04011515.jpeg', 100, '2025-01-27 11:36:46'),
(137, 1, 'b9ef94c0-fbd4-4b4e-bc4e-62cb80bc5ef4.jpeg', 100, '2025-01-27 11:36:54'),
(138, 1, '34b9d467-69e4-4f9a-8a3f-fe6563c95339.jpeg', 100, '2025-01-27 11:37:06');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `pageName` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `pageName`) VALUES
(5, 'الصفحة الرئيسية,main page'),
(1, 'صفحه رقم2,second page'),
(3, 'events,فعاليات'),
(2, ' صفحه الصور,photo page'),
(6, 'فيسبوك,facebook'),
(4, 'مربعات'),
(7, 'الصفحه 3 ,page 3'),
(8, 'فعاليات الصفحه3,events page3');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `option1` varchar(255) NOT NULL,
  `option2` varchar(255) NOT NULL,
  `option3` varchar(255) NOT NULL,
  `correct_option` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `client_id`, `question_text`, `option1`, `option2`, `option3`, `correct_option`, `created_at`) VALUES
(6, 2, 'למה לבחור בנו?', 'אנחנו הנגרייה המובילה בארץ עם מעל 30 שנות ניסיון. מה שמייחד אותנו זה המקצועיות שלנו, העמידה בזמנים, והמחירים האטרקטיביים. בנוסף, השירות שלנו הוא באיכות גבוהה, ואנו מחויבים לספק לכל לקוח חווית עבודה יוצאת דופן.', '', '', '', '2024-10-22 23:35:28'),
(7, 2, 'אילו סוגי פרויקטים אתם מתמחים בהם?', 'אנו מתמחים במגוון רחב של פרויקטים, כולל רהיטים מותאמים אישית, פתרונות אחסון, דלתות וחלונות, כמו גם עבודות עץ מיוחדות. כל פרויקט מותאם אישית לצרכי הלקוח.', '', '', '', '2024-10-22 23:40:43'),
(8, 2, 'איך אתם מבטיחים שהעבודה תתנהל בזמן?', 'אנחנו מתכננים כל פרויקט בקפידה ומבצעים מעקב שוטף על התקדמות העבודה. הצוות שלנו מחויב לעמידה בזמנים, ואנחנו מקפידים לעדכן את הלקוחות על כל התקדמות.', '', '', '', '2024-10-22 23:41:06'),
(9, 2, 'האם יש לכם המלצות מלקוחות קודמים?', 'בהחלט! אנו גאים בהמלצות רבות מלקוחות מרוצים. ניתן למצוא חוות דעת באתר שלנו או לקבל המלצות ישירות מלקוחות שלנו.', '', '', '', '2024-10-22 23:41:30'),
(10, 2, 'איך אתם מתמודדים עם אתגרים במהלך הפרויקט?', 'במהלך הפרויקט, אנו מקפידים על תקשורת פתוחה עם הלקוח. אם מתעורר אתגר, אנו מנתחים אותו ומציעים פתרונות מהירים ויעילים, תוך שמירה על איכות העבודה.', '', '', '', '2024-10-22 23:41:46'),
(11, 2, 'מהם חומרי הגלם שבהם אתם משתמשים? ', 'אנחנו משתמשים בחומרי גלם איכותיים בלבד, כולל עץ טבעי, MDF וחומרים נוספים שמתאימים לצרכי הלקוח. כל חומר עובר בקרת איכות קפדנית לפני השימוש.', '', '', '', '2024-10-22 23:41:59'),
(14, 1, 'من كتب سفر المزامير؟', 'النبي داوود', '', '', '', '2024-10-26 22:27:26'),
(15, 1, 'من هو الشهيد الاول في المسيحية؟', 'استفانوس أول الشمامسة', '', '', '', '2024-10-26 22:28:36'),
(16, 1, 'كم هو عدد الأعياد السيدية الكبرى؟', 'سبعة أعياد وهم : البشارة، الميلاد، الغطاس، الشعانين، الفصح ،الصعود والعنصرة', '', '', '', '2024-10-26 22:31:01'),
(17, 1, 'من هو الشخص الذي سمح له الرب أن يمشي على المياه؟', 'بطرس', '', '', '', '2024-10-26 22:32:56'),
(18, 1, 'كم شخص أطعم السيد المسيح عنا كان هنالك سمكتين وخمس خبزات ؟', 'خمسة آلاف شخص', '', '', '', '2024-10-26 22:33:38'),
(19, 1, 'من أول شخص راى السيد المسيح بعد قيامته؟', 'مريم المجدلية', '', '', '', '2024-10-26 22:34:26'),
(20, 1, 'من هو الشخص الذي صعد الى شجرة الجميزة لكي يرى يسوع؟', 'زكا رئيس العشارين', '', '', '', '2024-10-26 22:35:36'),
(21, 1, 'من هو التلميذ الذي انتُخب بدلا من يهوذا الإسخريوطي؟', 'متياس', '', '', '', '2024-10-26 22:37:06'),
(22, 1, 'من هي التي دهنت قدمي السيد المسيح بالطيب؟', 'مريم أخت مرثا ولعازر', '', '', '', '2024-10-26 22:37:58');

-- --------------------------------------------------------

--
-- Table structure for table `weekly_program`
--

CREATE TABLE `weekly_program` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `weekly_program`
--

INSERT INTO `weekly_program` (`id`, `title`, `description`, `date`, `time`, `location`, `created_at`) VALUES
(5, 'صلاة السحر', 'الأحد', '2024-10-26', '08:30:00', '', '2024-10-26 18:59:50'),
(6, 'القداس الإلهي', 'الأحد', '2024-10-26', '09:30:00', '', '2024-10-26 19:01:28'),
(7, 'مدرسة الأحد أبناء الملك', 'الأحد', '2024-10-26', '11:00:00', '', '2024-10-26 19:02:12'),
(8, 'اللقاء الروحي لدراسة الكتاب المقدس', 'الثلاثاء', '2024-10-26', '18:00:00', '', '2024-10-26 19:51:28'),
(10, 'لقاء أخوية القديس جوارجيوس', 'الخميس', '2024-10-27', '17:00:00', '', '2024-10-26 19:54:06'),
(12, 'لقاء الشبيبة المسيحية', 'الجمعة', '2024-10-28', '17:30:00', '', '2024-10-26 19:55:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_Id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classpage`
--
ALTER TABLE `classpage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ClassID` (`ClassID`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_navbar`
--
ALTER TABLE `client_navbar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_elements`
--
ALTER TABLE `general_elements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `mainsilderimg`
--
ALTER TABLE `mainsilderimg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `weekly_program`
--
ALTER TABLE `weekly_program`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `classpage`
--
ALTER TABLE `classpage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `client_navbar`
--
ALTER TABLE `client_navbar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `general_elements`
--
ALTER TABLE `general_elements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mainsilderimg`
--
ALTER TABLE `mainsilderimg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `weekly_program`
--
ALTER TABLE `weekly_program`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classpage`
--
ALTER TABLE `classpage`
  ADD CONSTRAINT `classpage_ibfk_1` FOREIGN KEY (`ClassID`) REFERENCES `class` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `client_navbar`
--
ALTER TABLE `client_navbar`
  ADD CONSTRAINT `client_navbar_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
