--
-- Core Form - Contact Base Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'textarea', 'Description', 'description', 'contact-base', 'contact-single', 'col-md-12', '', '', 0, 1, 0, '', '', ''),
(NULL, 'text', 'Firstname', 'firstname', 'contact-base', 'contact-single', 'col-md-3', '', '/contact/view/##ID##', 0, 1, 0, '', '', ''),
(NULL, 'text', 'Lastname', 'lastname', 'contact-base', 'contact-single', 'col-md-3', '', '/contact/view/##ID##', 0, 1, 0, '', '', ''),
(NULL, 'email', 'E-Mail (business)', 'email_addr', 'contact-base', 'contact-single', 'col-md-3', '', '/contact/view/##ID##', 0, 1, 0, '', '', ''),
(NULL, 'text', 'Phone (business)', 'phone', 'contact-base', 'contact-single', 'col-md-3', '', '/contact/view/##ID##', 0, 1, 0, '', '', ''),
(NULL, 'featuredimage', 'Featured Image', 'featured_image', 'contact-base', 'contact-single', 'col-md-3', '', '', 0, 1, 0, '', '', ''),
(NULL, 'multiselect', 'Categories', 'category_idfs', 'contact-base', 'contact-single', 'col-md-3', '', '/tag/api/list/contact-single/category', 0, 1, 0, 'entitytag-single', 'OnePlace\\Tag\\Model\\EntityTagTable', 'add-OnePlace\\Contact\\Controller\\CategoryController'),
(NULL, 'select', 'Salutation', 'salutation_idfs', 'contact-base', 'contact-single', 'col-md-3', '', '/tag/api/list/contact-single/salutation', 0, 1, 0, 'entitytag-single', 'OnePlace\\Tag\\Model\\EntityTagTable', 'add-OnePlace\\Contact\\Controller\\SalutationController'),
(NULL, 'select', 'Title', 'title_idfs', 'contact-base', 'contact-single', 'col-md-3', '', '/tag/api/list/contact-single/title', 0, 1, 0, 'entitytag-single', 'OnePlace\\Tag\\Model\\EntityTagTable', 'add-OnePlace\\Contact\\Controller\\TitleController');

--
-- Core Form - Contact History Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'partial', 'History', 'contact_history', 'contact-history', 'contact-single', 'col-md-12', '', '', 0, 1, 0, '', '', '');

--
-- Core Form - Contact Basket Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'partial', 'Basket', 'contact_basket', 'contact-basket', 'contact-single', 'col-md-12', '', '', 0, 1, 0, '', '', '');

--
-- Core Form - Contact Job Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'partial', 'Job', 'contact_job', 'contact-job', 'contact-single', 'col-md-12', '', '', 0, 1, 0, '', '', '');

--
-- Core Form - Contact Request Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'partial', 'Request', 'contact_request', 'contact-request', 'contact-single', 'col-md-12', '', '', 0, 1, 0, '', '', '');


--
-- Core Form  Tabs
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('contact-history', 'contact-single', 'History', '', 'fas fa-history', '', 1, '', ''),
('contact-basket', 'contact-single', 'Basket', '', 'fas fa-shopping-basket', '', 1, '', ''),
('contact-job', 'contact-single', 'Job', '', 'fas fa-book', '', 1, '', ''),
('contact-request', 'contact-single', 'Request', 'request', 'fas fa-envelop', '', 1, '', '');

--
-- Permissions
--
INSERT INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`) VALUES
('add', 'OnePlace\\Contact\\Controller\\CategoryController', 'Add Category', '', '', 0),
('add', 'OnePlace\\Contact\\Controller\\SalutationController', 'Add Salutation', '', '', 0),
('add', 'OnePlace\\Contact\\Controller\\TitleController', 'Add Title', '', '', 0);

--
-- Custom Tags
--
-- todo: add select before and check if tag exists
--
INSERT INTO `core_tag` (`Tag_ID`, `tag_key`, `tag_label`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(NULL, 'salutation', 'Salutation', '1', '0000-00-00 00:00:00', '1', '0000-00-00 00:00:00'),
(NULL, 'title', 'Title', '1', '0000-00-00 00:00:00', '1', '0000-00-00 00:00:00');

