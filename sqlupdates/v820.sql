ALTER TABLE `coupons` CHANGE `start_date` `start_date` INT(15) NULL, CHANGE `end_date` `end_date` INT(15) NULL;
ALTER TABLE `coupons` ADD `status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `end_date`;

CREATE TABLE `user_coupons` (
  `user_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `coupon_code` varchar(255) NOT NULL,
  `min_buy` double(20,2) NOT NULL,
  `validation_days` int(11) NOT NULL,
  `discount` double(20,2) NOT NULL,
  `discount_type` varchar(20) NOT NULL,
  `expiry_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `business_settings` (`id`, `type`, `value`, `lang`, `created_at`, `updated_at`) 
  VALUES (NULL, 'admin_login_page_image', NULL, NULL, current_timestamp(), current_timestamp()),
        (NULL, 'customer_login_page_image', NULL, NULL, current_timestamp(), current_timestamp()),
        (NULL, 'customer_register_page_image', NULL, NULL, current_timestamp(), current_timestamp()),
        (NULL, 'seller_login_page_image', NULL, NULL, current_timestamp(), current_timestamp()),
        (NULL, 'seller_register_page_image', NULL, NULL, current_timestamp(), current_timestamp()),
        (NULL, 'delivery_boy_login_page_image', NULL, NULL, current_timestamp(), current_timestamp()),
        (NULL, 'forgot_password_page_image', NULL, NULL, current_timestamp(), current_timestamp()),
        (NULL, 'password_reset_page_image', NULL, NULL, current_timestamp(), current_timestamp()),
        (NULL, 'phone_number_verify_page_image', NULL, NULL, current_timestamp(), current_timestamp()),
        (NULL, 'authentication_layout_select', 'boxed', NULL, current_timestamp(), current_timestamp()),
        (NULL, 'flash_deal_card_bg_image', NULL, 'en', current_timestamp(), current_timestamp()),
        (NULL, 'flash_deal_card_bg_title', NULL, 'en', current_timestamp(), current_timestamp()),
        (NULL, 'flash_deal_card_bg_subtitle', NULL, 'en', current_timestamp(), current_timestamp()),
        (NULL, 'flash_deal_card_text', NULL, NULL, current_timestamp(), current_timestamp()),
        (NULL, 'todays_deal_card_bg_image', NULL, 'en', current_timestamp(), current_timestamp()),
        (NULL, 'todays_deal_card_bg_title', NULL, 'en', current_timestamp(), current_timestamp()),
        (NULL, 'todays_deal_card_bg_subtitle', NULL, 'en', current_timestamp(), current_timestamp()),
        (NULL, 'todays_deal_card_text', NULL, NULL, current_timestamp(), current_timestamp()),
        (NULL, 'new_product_card_bg_image', NULL, 'en', current_timestamp(), current_timestamp()),
        (NULL, 'new_product_card_bg_title', NULL, 'en', current_timestamp(), current_timestamp()),
        (NULL, 'new_product_card_bg_subtitle', NULL, 'en', current_timestamp(), current_timestamp()),
        (NULL, 'new_product_card_text', NULL, NULL, current_timestamp(), current_timestamp()),
        (NULL, 'featured_categories_text', 'dark', NULL, current_timestamp(), current_timestamp());

INSERT INTO `permissions` (`id`, `name`, `section`, `guard_name`, `created_at`, `updated_at`)
  VALUES (NULL, 'view_size_charts', 'size_guide', 'web', current_timestamp(), current_timestamp()),
        (NULL, 'add_size_charts', 'size_guide', 'web', current_timestamp(), current_timestamp()),
        (NULL, 'edit_size_charts', 'size_guide', 'web', current_timestamp(), current_timestamp()),
        (NULL, 'delete_size_charts', 'size_guide', 'web', current_timestamp(), current_timestamp()),
        (NULL, 'view_measurement_points', 'size_guide', 'web', current_timestamp(), current_timestamp()),
        (NULL, 'add_measurement_points', 'size_guide', 'web', current_timestamp(), current_timestamp()),
        (NULL, 'edit_measurement_points', 'size_guide', 'web', current_timestamp(), current_timestamp()),
        (NULL, 'delete_measurement_points', 'size_guide', 'web', current_timestamp(), current_timestamp()),
        (NULL, 'authentication_layout_settings', 'website_setup', 'web', current_timestamp(), current_timestamp());

CREATE TABLE `measurement_points` (
  `id` int(20) NOT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `measurement_points`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `measurement_points`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

CREATE TABLE `size_charts` (
  `id` int(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `fit_type` varchar(191) DEFAULT NULL,
  `stretch_type` varchar(191) DEFAULT NULL,
  `photos` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `measurement_points` varchar(255) NOT NULL,
  `size_options` varchar(255) NOT NULL,
  `measurement_option` varchar(191) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `size_charts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_id` (`category_id`);
  
ALTER TABLE `size_charts`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

CREATE TABLE `size_chart_details` (
  `id` int(20) UNSIGNED NOT NULL,
  `size_chart_id` int(20) NOT NULL,
  `measurement_point_id` int(20) NOT NULL,
  `attribute_value_id` int(20) NOT NULL,
  `inch_value` varchar(191) DEFAULT NULL,
  `cen_value` varchar(191) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `size_chart_details`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `size_chart_details`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

UPDATE `business_settings` SET `value` = '8.2' WHERE `business_settings`.`type` = 'current_version';

COMMIT;