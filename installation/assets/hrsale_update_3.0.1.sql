ALTER TABLE `ci_erp_settings` ADD `enable_sms_notification` INT(11) NOT NULL AFTER `invoice_terms_condition`, ADD `sms_from` VARCHAR(200) NOT NULL AFTER `enable_sms_notification`, ADD `sms_service_plan_id` TEXT NULL DEFAULT NULL AFTER `sms_from`, ADD `sms_bearer_token` TEXT NULL DEFAULT NULL AFTER `sms_service_plan_id`;
ALTER TABLE `ci_erp_users_details` ADD `leave_categories` VARCHAR(255) NOT NULL DEFAULT 'all' AFTER `salay_type`;

ALTER TABLE `ci_erp_company_settings` ADD `setup_modules` TEXT NOT NULL AFTER `invoice_terms_condition`, ADD `header_background` VARCHAR(100) NOT NULL DEFAULT 'bg-dark' AFTER `setup_modules`, ADD `calendar_locale` VARCHAR(100) NOT NULL DEFAULT 'en' AFTER `header_background`, ADD `datepicker_locale` VARCHAR(100) NOT NULL DEFAULT 'en' AFTER `calendar_locale`;
ALTER TABLE `ci_erp_company_settings` ADD `login_page` INT(11) NOT NULL DEFAULT '1' AFTER `datepicker_locale`, ADD `login_page_text` TEXT NULL AFTER `login_page`;
--
-- Table structure for table `ci_sms_template`
--

CREATE TABLE `ci_sms_template` (
  `template_id` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_sms_template`
--

INSERT INTO `ci_sms_template` (`template_id`, `subject`, `message`, `created_at`) VALUES
(1, 'New Project Assigned', 'Hello {firstname}, you have been assigned a new project {project_name}', '2021-07-01'),
(2, 'New Task Assigned', 'Hello {firstname}, you have been assigned a new task {task_name}', '2021-07-01'),
(3, 'New Award', 'Hello {firstname}, you have been awarded with {award_name}', '2021-07-01'),
(4, 'Leave Approved', 'Hello {firstname}, you leave has been approved {leave_name}', '2021-07-01'),
(5, 'Leave Rejected', 'Hello {firstname}, you leave has been rejected {leave_name}', '2021-07-01'),
(6, 'Payslip Created', 'Hello {firstname}, your salary has been paid. Amount {salary_amount}', '2021-07-01');

-- --------------------------------------------------------

--
-- Table structure for table `ci_stock_orders`
--

CREATE TABLE `ci_stock_orders` (
  `order_id` int(111) NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `company_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `invoice_month` varchar(255) DEFAULT NULL,
  `invoice_date` varchar(255) NOT NULL,
  `invoice_due_date` varchar(255) NOT NULL,
  `sub_total_amount` decimal(65,2) NOT NULL DEFAULT 0.00,
  `discount_type` varchar(11) NOT NULL,
  `discount_figure` decimal(65,2) NOT NULL DEFAULT 0.00,
  `total_tax` decimal(65,2) NOT NULL DEFAULT 0.00,
  `tax_type` varchar(100) DEFAULT NULL,
  `total_discount` decimal(65,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(65,2) NOT NULL DEFAULT 0.00,
  `invoice_note` mediumtext NOT NULL,
  `status` tinyint(1) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `ci_stock_order_items`
--

CREATE TABLE `ci_stock_order_items` (
  `order_item_id` int(111) NOT NULL,
  `order_id` int(111) NOT NULL,
  `item_id` varchar(255) NOT NULL,
  `item_qty` varchar(255) NOT NULL,
  `item_unit_price` decimal(65,2) NOT NULL DEFAULT 0.00,
  `item_sub_total` decimal(65,2) NOT NULL DEFAULT 0.00,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `ci_stock_order_quotes`
--

CREATE TABLE `ci_stock_order_quotes` (
  `quote_id` int(111) NOT NULL,
  `quote_number` varchar(255) NOT NULL,
  `company_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `quote_month` varchar(255) DEFAULT NULL,
  `quote_date` varchar(255) NOT NULL,
  `quote_due_date` varchar(255) NOT NULL,
  `sub_total_amount` decimal(65,2) NOT NULL DEFAULT 0.00,
  `discount_type` varchar(11) NOT NULL,
  `discount_figure` decimal(65,2) NOT NULL DEFAULT 0.00,
  `total_tax` decimal(65,2) NOT NULL DEFAULT 0.00,
  `tax_type` varchar(100) DEFAULT NULL,
  `total_discount` decimal(65,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(65,2) NOT NULL DEFAULT 0.00,
  `quote_note` mediumtext NOT NULL,
  `status` tinyint(1) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `ci_stock_order_quote_items`
--

CREATE TABLE `ci_stock_order_quote_items` (
  `quote_item_id` int(111) NOT NULL,
  `quote_id` int(111) NOT NULL,
  `item_id` varchar(255) NOT NULL,
  `item_qty` varchar(255) NOT NULL,
  `item_unit_price` decimal(65,2) NOT NULL DEFAULT 0.00,
  `item_sub_total` decimal(65,2) NOT NULL DEFAULT 0.00,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `ci_stock_products`
--

CREATE TABLE `ci_stock_products` (
  `product_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_qty` int(11) NOT NULL,
  `reorder_stock` int(11) NOT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `barcode_type` varchar(255) DEFAULT NULL,
  `warehouse_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_sku` varchar(255) DEFAULT NULL,
  `product_serial_number` varchar(255) DEFAULT NULL,
  `purchase_price` decimal(65,2) NOT NULL,
  `retail_price` decimal(65,2) NOT NULL,
  `expiration_date` varchar(255) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_description` longtext DEFAULT NULL,
  `product_rating` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `ci_stock_purchases`
--

CREATE TABLE `ci_stock_purchases` (
  `purchase_id` int(111) NOT NULL,
  `purchase_number` varchar(255) NOT NULL,
  `company_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `purchase_month` varchar(255) DEFAULT NULL,
  `purchase_date` varchar(255) NOT NULL,
  `sub_total_amount` decimal(65,2) NOT NULL DEFAULT 0.00,
  `discount_type` varchar(11) NOT NULL,
  `discount_figure` decimal(65,2) NOT NULL DEFAULT 0.00,
  `total_tax` decimal(65,2) NOT NULL DEFAULT 0.00,
  `tax_type` varchar(100) DEFAULT NULL,
  `total_discount` decimal(65,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(65,2) NOT NULL DEFAULT 0.00,
  `purchase_note` mediumtext NOT NULL,
  `status` tinyint(1) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `ci_stock_purchase_items`
--

CREATE TABLE `ci_stock_purchase_items` (
  `purchase_item_id` int(111) NOT NULL,
  `purchase_id` int(111) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_qty` varchar(255) NOT NULL,
  `item_unit_price` decimal(65,2) NOT NULL DEFAULT 0.00,
  `item_sub_total` decimal(65,2) NOT NULL DEFAULT 0.00,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- Table structure for table `ci_stock_suppliers`
--

CREATE TABLE `ci_stock_suppliers` (
  `supplier_id` int(111) NOT NULL,
  `company_id` int(11) NOT NULL,
  `supplier_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `registration_no` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `contact_number` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `address_1` text CHARACTER SET utf8 DEFAULT NULL,
  `address_2` text CHARACTER SET utf8 DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `zipcode` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `country` int(111) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `ci_stock_warehouses`
--

CREATE TABLE `ci_stock_warehouses` (
  `warehouse_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `warehouse_name` varchar(200) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `pickup_location` tinyint(1) NOT NULL,
  `address_1` text DEFAULT NULL,
  `address_2` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zipcode` varchar(255) DEFAULT NULL,
  `country` int(111) NOT NULL,
  `added_by` int(111) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_stock_orders`
--
ALTER TABLE `ci_stock_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `ci_stock_order_items`
--
ALTER TABLE `ci_stock_order_items`
  ADD PRIMARY KEY (`order_item_id`);

--
-- Indexes for table `ci_stock_order_quotes`
--
ALTER TABLE `ci_stock_order_quotes`
  ADD PRIMARY KEY (`quote_id`);

--
-- Indexes for table `ci_stock_order_quote_items`
--
ALTER TABLE `ci_stock_order_quote_items`
  ADD PRIMARY KEY (`quote_item_id`);

--
-- Indexes for table `ci_stock_products`
--
ALTER TABLE `ci_stock_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `ci_stock_purchases`
--
ALTER TABLE `ci_stock_purchases`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `ci_stock_purchase_items`
--
ALTER TABLE `ci_stock_purchase_items`
  ADD PRIMARY KEY (`purchase_item_id`);

--
-- Indexes for table `ci_stock_suppliers`
--
ALTER TABLE `ci_stock_suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `ci_stock_warehouses`
--
ALTER TABLE `ci_stock_warehouses`
  ADD PRIMARY KEY (`warehouse_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ci_stock_orders`
--
ALTER TABLE `ci_stock_orders`
  MODIFY `order_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ci_stock_order_items`
--
ALTER TABLE `ci_stock_order_items`
  MODIFY `order_item_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ci_stock_order_quotes`
--
ALTER TABLE `ci_stock_order_quotes`
  MODIFY `quote_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ci_stock_order_quote_items`
--
ALTER TABLE `ci_stock_order_quote_items`
  MODIFY `quote_item_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `ci_stock_products`
--
ALTER TABLE `ci_stock_products`
  MODIFY `product_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ci_stock_purchases`
--
ALTER TABLE `ci_stock_purchases`
  MODIFY `purchase_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ci_stock_purchase_items`
--
ALTER TABLE `ci_stock_purchase_items`
  MODIFY `purchase_item_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `ci_stock_suppliers`
--
ALTER TABLE `ci_stock_suppliers`
  MODIFY `supplier_id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ci_stock_warehouses`
--
ALTER TABLE `ci_stock_warehouses`
  MODIFY `warehouse_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

-- --------------------------------------------------------

--
-- Table structure for table `ci_module_attributes`
--

CREATE TABLE `ci_module_attributes` (
  `custom_field_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `attribute` varchar(255) NOT NULL,
  `attribute_label` varchar(255) NOT NULL,
  `attribute_type` varchar(255) NOT NULL,
  `col_width` varchar(100) DEFAULT NULL,
  `validation` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_module_attributes_select_value`
--

CREATE TABLE `ci_module_attributes_select_value` (
  `attributes_select_value_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `custom_field_id` int(11) NOT NULL,
  `select_label` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_module_attributes_values`
--

CREATE TABLE `ci_module_attributes_values` (
  `attributes_value_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `module_attributes_id` int(11) NOT NULL,
  `attribute_value` text DEFAULT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_module_attributes`
--
ALTER TABLE `ci_module_attributes`
  ADD PRIMARY KEY (`custom_field_id`);

--
-- Indexes for table `ci_module_attributes_select_value`
--
ALTER TABLE `ci_module_attributes_select_value`
  ADD PRIMARY KEY (`attributes_select_value_id`);

--
-- Indexes for table `ci_module_attributes_values`
--
ALTER TABLE `ci_module_attributes_values`
  ADD PRIMARY KEY (`attributes_value_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ci_module_attributes`
--
ALTER TABLE `ci_module_attributes`
  MODIFY `custom_field_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_module_attributes_select_value`
--
ALTER TABLE `ci_module_attributes_select_value`
  MODIFY `attributes_select_value_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_module_attributes_values`
--
ALTER TABLE `ci_module_attributes_values`
  MODIFY `attributes_value_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

--
-- Table structure for table `ci_currencies`
--

CREATE TABLE `ci_currencies` (
  `currency_id` int(11) NOT NULL,
  `country_name` varchar(150) NOT NULL,
  `currency_name` varchar(20) NOT NULL,
  `currency_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_currencies`
--

INSERT INTO `ci_currencies` (`currency_id`, `country_name`, `currency_name`, `currency_code`) VALUES
(1, 'Afghanistan', 'Afghan afghani', 'AFN'),
(2, 'Albania', 'Albanian lek', 'ALL'),
(3, 'Algeria', 'Algerian dinar', 'DZD'),
(6, 'Angola', 'Angolan kwanza', 'AOA'),
(10, 'Argentina', 'Argentine peso', 'ARS'),
(11, 'Armenia', 'Armenian dram', 'AMD'),
(12, 'Aruba', 'Aruban florin', 'AWG'),
(13, 'Australia', 'Australian dollar', 'AUD'),
(15, 'Azerbaijan', 'Azerbaijani manat', 'AZN'),
(16, 'Bahamas', 'Bahamian dollar', 'BSD'),
(17, 'Bahrain', 'Bahraini dinar', 'BHD'),
(18, 'Bangladesh', 'Bangladeshi taka', 'BDT'),
(19, 'Barbados', 'Barbadian dollar', 'BBD'),
(20, 'Belarus', 'Belarusian ruble', 'BYR'),
(22, 'Belize', 'Belize dollar', 'BZD'),
(24, 'Bermuda', 'Bermudian dollar', 'BMD'),
(25, 'Bhutan', 'Bhutanese ngultrum', 'BTN'),
(26, 'Bolivia', 'Bolivian boliviano', 'BOB'),
(27, 'Bosnia and Herzegovina', 'Bosnia and Herzegovi', 'BAM'),
(30, 'Brazil', 'Brazilian real', 'BRL'),
(33, 'Bulgaria', 'Bulgarian lev', 'BGN'),
(35, 'Burundi', 'Burundian franc', 'BIF'),
(36, 'Cambodia', 'Cambodian riel', 'KHR'),
(38, 'Canada', 'Canadian dollar', 'CAD'),
(39, 'Cape Verde', 'Cape Verdean escudo', 'CVE'),
(40, 'Cayman Islands', 'Cayman Islands dolla', 'KYD'),
(43, 'Chile', 'Chilean peso', 'CLP'),
(44, 'China', 'Chinese yuan', 'CNY'),
(47, 'Colombia', 'Colombian peso', 'COP'),
(48, 'Comoros', 'Comorian franc', 'KMF'),
(49, 'Congo', 'Congolese franc', 'CDF'),
(52, 'Costa Rica', 'Costa Rican', 'CRC'),
(54, 'Croatia (Hrvatska)', 'Croatian kuna', 'HRK'),
(55, 'Cuba', 'Cuban convertible pe', 'CUC'),
(57, 'Czech Republic', 'Czech koruna', 'CZK'),
(58, 'Denmark', 'Danish krone', 'DKK'),
(59, 'Djibouti', 'Djiboutian franc', 'DJF'),
(60, 'Dominica', 'East Caribbean dolla', 'XCD'),
(61, 'Dominican Republic', 'Dominican peso', 'DOP'),
(64, 'Egypt', 'Egyptian pound', 'EGP'),
(67, 'Eritrea', 'Eritrean nakfa', 'ERN'),
(69, 'Ethiopia', 'Ethiopian birr', 'ETB'),
(71, 'Falkland Islands', 'Falkland Islands pou', 'FKP'),
(73, 'Fiji Islands', 'Fiji Dollars', 'FJD'),
(79, 'Gabon', 'Central African CFA ', 'XAF'),
(80, 'Gambia The', 'Gambian dalasi', 'GMD'),
(81, 'Georgia', 'Georgian lari', 'GEL'),
(83, 'Ghana', 'Ghana cedi', 'GHS'),
(84, 'Gibraltar', 'Gibraltar pound', 'GIP'),
(90, 'Guatemala', 'Guatemalan quetzal', 'GTQ'),
(92, 'Guinea', 'Guinean franc', 'GNF'),
(94, 'Guyana', 'Guyanese dollar', 'GYD'),
(95, 'Haiti', 'Haitian gourde', 'HTG'),
(97, 'Honduras', 'Honduran lempira', 'HNL'),
(98, 'Hong Kong S.A.R.', 'Hong Kong dollar', 'HKD'),
(99, 'Hungary', 'Hungarian forint', 'HUF'),
(100, 'Iceland', 'Icelandic króna\n', 'ISK'),
(101, 'India', 'Indian rupee', 'INR'),
(102, 'Indonesia', 'Indonesian rupiah', 'IDR'),
(103, 'Iran', 'Iranian rial', 'IRR'),
(104, 'Iraq', 'Iraqi dinar', 'IQD'),
(106, 'Israel', 'Israeli new shekel', 'ILS'),
(108, 'Jamaica', 'Jamaican dollar', 'JMD'),
(109, 'Japan', 'Japanese yen', 'JPY'),
(111, 'Jordan', 'Jordanian dinar', 'JOD'),
(112, 'Kazakhstan', 'Kazakhstani tenge', 'KZT'),
(113, 'Kenya', 'Kenyan shilling', 'KES'),
(115, 'Korea North', 'North Korean won', 'KPW'),
(116, 'Korea South', 'Korea (South) Won', 'KRW'),
(117, 'Kuwait', 'Kuwaiti dinar', 'KWD'),
(118, 'Kyrgyzstan', 'Kyrgyzstani som', 'KGS'),
(119, 'Laos', 'Lao kip', 'LAK'),
(121, 'Lebanon', 'Lebanese pound', 'LBP'),
(122, 'Lesotho', 'Lesotho loti', 'LSL'),
(123, 'Liberia', 'Liberian dollar', 'LRD'),
(124, 'Libya', 'Libyan dinar', 'LYD'),
(128, 'Macau S.A.R.', 'Macanese pataca', 'MOP'),
(129, 'Macedonia', 'Macedonian denar', 'MKD'),
(130, 'Madagascar', 'Malagasy ariary', 'MGA'),
(131, 'Malawi', 'Malawian kwacha', 'MWK'),
(132, 'Malaysia', 'Malaysian ringgit', 'MYR'),
(133, 'Maldives', 'Maldivian rufiyaa', 'MVR'),
(134, 'Mali', 'West African CFA fra', 'XOF'),
(136, 'Man (Isle of)', 'Manx pound', 'IMP'),
(139, 'Mauritania', 'Mauritanian ouguiya', 'MRO'),
(140, 'Mauritius', 'Mauritian rupee', 'MUR'),
(142, 'Mexico', 'Mexican peso', 'MXN'),
(144, 'Moldova', 'Moldovan leu', 'MDL'),
(146, 'Mongolia', 'Mongolian tögrög', 'MNT'),
(148, 'Morocco', 'Moroccan dirham', 'MAD'),
(149, 'Mozambique', 'Mozambican metical', 'MZN'),
(150, 'Myanmar', 'Burmese kyat', 'MMK'),
(151, 'Namibia', 'Namibian dollar', 'NAD'),
(153, 'Nepal', 'Nepalese rupee', 'NPR'),
(154, 'Netherlands Antilles', 'Dutch Guilder', 'ANG'),
(157, 'New Zealand', 'New Zealand dollar', 'NZD'),
(158, 'Nicaragua', 'Nicaraguan córdoba', 'NIO'),
(160, 'Nigeria', 'Nigerian naira', 'NGN'),
(164, 'Norway', 'Norwegian krone', 'NOK'),
(165, 'Oman', 'Omani rial', 'OMR'),
(166, 'Pakistan', 'Pakistani rupee', 'PKR'),
(169, 'Panama', 'Panamanian balboa', 'PAB'),
(170, 'Papua new Guinea', 'Papua New Guinean ki', 'PGK'),
(171, 'Paraguay', 'Paraguayan guaraní\n', 'PYG'),
(172, 'Peru', 'Peruvian nuevo sol', 'PEN'),
(173, 'Philippines', 'Philippine peso', 'PHP'),
(175, 'Poland', 'Polish z?oty\n', 'PLN'),
(178, 'Qatar', 'Qatari riyal', 'QAR'),
(180, 'Romania', 'Romanian leu', 'RON'),
(181, 'Russia', 'Russian ruble', 'RUB'),
(182, 'Rwanda', 'Rwandan franc', 'RWF'),
(183, 'Saint Helena', 'Saint Helena pound', 'SHP'),
(188, 'Samoa', 'Samoan t?l?\n', 'WST'),
(191, 'Saudi Arabia', 'Saudi riyal', 'SAR'),
(193, 'Serbia', 'Serbian dinar', 'RSD'),
(194, 'Seychelles', 'Seychellois rupee', 'SCR'),
(195, 'Sierra Leone', 'Sierra Leonean leone', 'SLL'),
(196, 'Singapore', 'Singapore dollar\n', 'SGD'),
(200, 'Solomon Islands', 'Solomon Islands doll', 'SBD'),
(201, 'Somalia', 'Somali shilling', 'SOS'),
(202, 'South Africa', 'South African rand', 'ZAR'),
(204, 'South Sudan', 'South Sudanese pound', 'SSP'),
(205, 'Spain', 'Euro', 'EUR'),
(206, 'Sri Lanka', 'Sri Lankan rupee', 'LKR'),
(207, 'Sudan', 'Sudanese pound', 'SDG'),
(208, 'Suriname', 'Surinamese dollar', 'SRD'),
(210, 'Swaziland', 'Swazi lilangeni', 'SZL'),
(211, 'Sweden', 'Swedish krona', 'SEK'),
(212, 'Switzerland', 'Swiss franc', 'CHF'),
(213, 'Syria', 'Syrian pound', 'SYP'),
(214, 'Taiwan', 'New Taiwan dollar', 'TWD'),
(215, 'Tajikistan', 'Tajikistani somoni', 'TJS'),
(216, 'Tanzania', 'Tanzanian shilling', 'TZS'),
(217, 'Thailand', 'Thai baht', 'THB'),
(220, 'Tonga', 'Tongan pa?anga\n', 'TOP'),
(221, 'Trinidad And Tobago', 'Trinidad and Tobago ', 'TTD'),
(222, 'Tunisia', 'Tunisian dinar', 'TND'),
(223, 'Turkey', 'Turkish lira', 'TRY'),
(224, 'Turkmenistan', 'Turkmenistan manat', 'TMT'),
(227, 'Uganda', 'Ugandan shilling', 'UGX'),
(228, 'Ukraine', 'Ukrainian hryvnia', 'UAH'),
(229, 'United Arab Emirates', 'United Arab Emirates', 'AED'),
(230, 'United Kingdom', 'British pound', 'GBP'),
(231, 'United States', 'United States Dollar', 'USD'),
(233, 'Uruguay', 'Uruguayan peso', 'UYU'),
(234, 'Uzbekistan', 'Uzbekistani som', 'UZS'),
(235, 'Vanuatu', 'Vanuatu vatu', 'VUV'),
(237, 'Venezuela', 'Venezuelan bolívar\n', 'VEF'),
(238, 'Vietnam', 'Vietnamese dong\n', 'VND'),
(241, 'Wallis And Futuna Islands', 'CFP franc', 'XPF'),
(243, 'Yemen', 'Yemeni rial', 'YER'),
(244, 'Yugoslavia', 'Yugoslav dinar', 'YUM'),
(245, 'Zambia', 'Zambian kwacha', 'ZMW'),
(246, 'Zimbabwe', 'Botswana pula', 'BWP');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_currencies`
--
ALTER TABLE `ci_currencies`
  ADD PRIMARY KEY (`currency_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ci_currencies`
--
ALTER TABLE `ci_currencies`
  MODIFY `currency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;
COMMIT;