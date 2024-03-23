UPDATE `business_settings` SET lang='en' WHERE type IN ('home_slider_images','home_slider_links','home_banner1_images','home_banner1_links','home_banner2_images','home_banner2_links','home_banner3_images','home_banner3_links') AND lang is null;

UPDATE `business_settings` SET `value` = '8.3' WHERE `business_settings`.`type` = 'current_version';

COMMIT;