CREATE TABLE `product_categories` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

UPDATE `business_settings` SET `value` = '7.9.1' WHERE `business_settings`.`type` = 'current_version';

COMMIT;