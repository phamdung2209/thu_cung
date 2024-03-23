ALTER TABLE `orders` ADD `order_from` VARCHAR(20) NOT NULL DEFAULT 'web' AFTER `shipping_type`;

UPDATE `business_settings` SET `value` = '7.4.0' WHERE `business_settings`.`type` = 'current_version';

COMMIT;