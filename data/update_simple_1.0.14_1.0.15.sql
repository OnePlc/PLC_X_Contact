ALTER TABLE `contact` ADD `skype` VARCHAR(255) NOT NULL DEFAULT '' AFTER `phone_private`;

INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'text', 'Skype', 'skype', 'contact-base', 'contact-single', 'col-md-3', '/contact/view/##ID##', '', 0, 1, 0, '', '', '');