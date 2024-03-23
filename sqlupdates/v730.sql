ALTER TABLE `tickets` CHANGE `code` `code` BIGINT(23) NOT NULL;

UPDATE `business_settings` SET `value` = '7.3.0' WHERE `business_settings`.`type` = 'current_version';

COMMIT;