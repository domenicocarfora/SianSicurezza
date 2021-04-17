CREATE TABLE IF NOT EXISTS `#__download_area` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`state` TINYINT(1)  NOT NULL  DEFAULT 1,
`nome` VARCHAR(255)  NOT NULL ,
`file` TEXT NOT NULL ,
`registered` TINYINT(1)  NOT NULL  DEFAULT 1,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;


INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `field_mappings`, `content_history_options`, `rules`)
SELECT * FROM ( SELECT 'Area','com_download_area.area','{"special":{"dbtable":"#__download_area","key":"id","type":"Area","prefix":"Download_areaTable"}}', CASE 
                                    WHEN 'field_mappings' is null THEN ''
                                    ELSE ''
                                    END as field_mappings, '{"formFile":"administrator\/components\/com_download_area\/models\/forms\/area.xml", "hideFields":["checked_out","checked_out_time","params","language" ,"file"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}', " ") AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_download_area.area')
) LIMIT 1;
