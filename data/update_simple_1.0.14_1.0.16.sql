--
-- 1.0.15
--
ALTER TABLE `contact` ADD `skype` VARCHAR(255) NOT NULL DEFAULT '' AFTER `phone_private`;
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'text', 'Skype', 'skype', 'contact-base', 'contact-single', 'col-md-3', '/contact/view/##ID##', '', 0, 1, 0, '', '', '');

--
-- 1.0.16
--
ALTER TABLE `contact` DROP `skype`;
DELETE FROM `user_form_field` WHERE `field_idfs` = (select `Field_ID` from `core_tag` where `fieldkey`='skype' AND `form` = 'contact-single');
DELETE FROM `core_form_field` WHERE `core_form_field`.`fieldkey` = 'skype' AND `core_form_field`.`form` = 'contact-single';