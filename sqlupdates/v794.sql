INSERT INTO `permissions` (`id`, `name`, `section`, `guard_name`, `created_at`, `updated_at`) 
    VALUES (null, 'select_homepage', 'website_setup', 'web', current_timestamp(), current_timestamp());

INSERT INTO `business_settings` (`id`, `type`, `value`, `lang`, `created_at`, `updated_at`) 
    VALUES (NULL, 'secondary_base_color', '#13814C', NULL, current_timestamp(), current_timestamp()),
        (NULL, 'secondary_base_hov_color', '#0f6f41', NULL, current_timestamp(), current_timestamp()),
        (NULL, 'header_nav_menu_text', 'light', NULL, current_timestamp(), current_timestamp()),
        (NULL, 'homepage_select', 'classic', NULL, current_timestamp(), current_timestamp()),
        (NULL, 'todays_deal_section_bg', '0', NULL, current_timestamp(), current_timestamp()),
        (NULL, 'todays_deal_section_bg_color', '#3d4666', NULL, current_timestamp(), current_timestamp()),
        (NULL, 'flash_deal_bg_color', '#d33533', NULL, current_timestamp(), current_timestamp()),
        (NULL, 'flash_deal_bg_full_width', '0', NULL, current_timestamp(), current_timestamp()),
        (NULL, 'flash_deal_banner_menu_text', 'light', NULL, current_timestamp(), current_timestamp()),
        (NULL, 'todays_deal_banner_text_color', 'light', NULL, current_timestamp(), current_timestamp()),
        (NULL, 'coupon_background_image', NULL, NULL, current_timestamp(), current_timestamp());

COMMIT;

UPDATE `business_settings` SET `value` = '7.9.4' WHERE `business_settings`.`type` = 'current_version';

COMMIT;