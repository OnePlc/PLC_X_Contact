--
-- Core Form - Contact Base Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'textarea', 'Description', 'description', 'contact-base', 'contact-single', 'col-md-12', '', '', 0, 1, 0, '', '', ''),
(NULL, 'text', 'Firstname', 'firstname', 'contact-base', 'contact-single', 'col-md-3', '/contact/view/##ID##', '', 0, 1, 0, '', '', ''),
(NULL, 'text', 'Lastname', 'lastname', 'contact-base', 'contact-single', 'col-md-3', '/contact/view/##ID##', '', 0, 1, 0, '', '', ''),
(NULL, 'email', 'E-Mail (business)', 'email_addr', 'contact-base', 'contact-single', 'col-md-3', '/contact/view/##ID##', '', 0, 1, 0, '', '', ''),
(NULL, 'text', 'Phone (business)', 'phone', 'contact-base', 'contact-single', 'col-md-3', '/contact/view/##ID##', '', 0, 1, 0, '', '', ''),
(NULL, 'featuredimage', 'Featured Image', 'featured_image', 'contact-base', 'contact-single', 'col-md-3', '', '', 0, 1, 0, '', '', ''),
(NULL, 'multiselect', 'Categories', 'category_idfs', 'contact-base', 'contact-single', 'col-md-3', '', '/tag/api/list/contact-single/category', 0, 1, 0, 'entitytag-single', 'OnePlace\\Tag\\Model\\EntityTagTable', 'add-OnePlace\\Contact\\Controller\\CategoryController'),
(NULL, 'select', 'Salutation', 'salutation_idfs', 'contact-base', 'contact-single', 'col-md-3', '', '/tag/api/list/contact-single/salutation', 0, 1, 0, 'entitytag-single', 'OnePlace\\Tag\\Model\\EntityTagTable', 'add-OnePlace\\Contact\\Controller\\SalutationController'),
(NULL, 'select', 'Title', 'title_idfs', 'contact-base', 'contact-single', 'col-md-3', '', '/tag/api/list/contact-single/title', 0, 1, 0, 'entitytag-single', 'OnePlace\\Tag\\Model\\EntityTagTable', 'add-OnePlace\\Contact\\Controller\\TitleController');


--
-- Permissions
--
INSERT IGNORE INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`) VALUES
('add', 'OnePlace\\Contact\\Controller\\CategoryController', 'Add Category', '', '', 0),
('add', 'OnePlace\\Contact\\Controller\\SalutationController', 'Add Salutation', '', '', 0),
('add', 'OnePlace\\Contact\\Controller\\TitleController', 'Add Title', '', '', 0);

--
-- Custom Tags
--
INSERT IGNORE INTO `core_tag` (`Tag_ID`, `tag_key`, `tag_label`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(NULL, 'salutation', 'Salutation', '1', '0000-00-00 00:00:00', '1', '0000-00-00 00:00:00'),
(NULL, 'title', 'Title', '1', '0000-00-00 00:00:00', '1', '0000-00-00 00:00:00');

--
-- Remove Label
--
DELETE FROM `core_form_field` WHERE `form` = 'contact-single' AND `type` = 'TEXT' AND `fieldkey` = 'label';