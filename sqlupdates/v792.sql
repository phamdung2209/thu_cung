INSERT INTO `business_settings` (`id`, `type`, `value`, `lang`, `created_at`, `updated_at`) VALUES (NULL, 'aamarpay_sandbox', '0', NULL, '2022-06-05 07:17:14', '2022-06-05 07:17:14');

UPDATE `business_settings` SET `value` = '7.9.2' WHERE `business_settings`.`type` = 'current_version';

COMMIT;