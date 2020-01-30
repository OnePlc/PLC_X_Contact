--
-- Core Form - Contact Base Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'textarea', 'Description', 'description', 'contact-base', 'contact-single', 'col-md-12', '', '', '0', '1', '0', '', '', ''),
(NULL, 'text', 'Firstname', 'firstname', 'contact-base', 'contact-single', 'col-md-3', '', '/contact/view/##ID##', '0', '1', '0', '', '', ''),
(NULL, 'text', 'Lastname', 'lastname', 'contact-base', 'contact-single', 'col-md-3', '', '/contact/view/##ID##', '0', '1', '0', '', '', ''),
(NULL, 'email', 'E-Mail (business)', 'email_addr', 'contact-base', 'contact-single', 'col-md-3', '', '/contact/view/##ID##', '0', '1', '0', '', '', ''),
(NULL, 'text', 'Phone (business)', 'phone', 'contact-base', 'contact-single', 'col-md-3', '', '/contact/view/##ID##', '0', '1', '0', '', '', ''),
(NULL, 'featuredimage', 'Featured Image', 'featured_image', 'contact-base', 'contact-single', 'col-md-3', '', '', '0', '1', '0', '', '', ''),
(NULL, 'multiselect', 'Categories', 'category_idfs', 'contact-base', 'contact-single', 'col-md-3', '', '', 0, 1, 0, 'entitytag-single', 'OnePlace\\Tag\\Model\\EntityTagTable', 'add-OnePlace\\Tag\\Controller\\TagController'),
(NULL, 'select', 'Salution', 'salution_idfs', 'contact-base', 'contact-single', 'col-md-3', '', '', 0, 1, 0, 'entitytag-single', 'OnePlace\\Tag\\Model\\EntityTagTable', 'add-OnePlace\\Tag\\Controller\\TagController'),
(NULL, 'select', 'Title', 'title_idfs', 'contact-base', 'contact-single', 'col-md-3', '', '', 0, 1, 0, 'entitytag-single', 'OnePlace\\Tag\\Model\\EntityTagTable', 'add-OnePlace\\Tag\\Controller\\TagController');

--
-- Core Form - Contact History Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'partial', 'History', 'history', 'contact-history', 'contact-single', 'col-md-12', '', '', '0', '1', '0', '', '', '');

--
-- Core Form - Contact Basket Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'partial', 'Basket', 'basket', 'contact-basket', 'contact-single', 'col-md-12', '', '', '0', '1', '0', '', '', '');

--
-- Core Form - Contact Job Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'partial', 'Job', 'job', 'contact-job', 'contact-single', 'col-md-12', '', '', '0', '1', '0', '', '', '');

--
-- Core Form - Contact Shoprequest Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'partial', 'Shoprequest', 'shoprequest', 'contact-shoprequest', 'contact-single', 'col-md-12', '', '', '0', '1', '0', '', '', '');


--
-- book Form Tabs
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('contact-history', 'contact-single', 'History', '', 'fas fa-history', '', '1', '', ''),
('contact-basket', 'basket-single', 'Basket', '', 'fas fa-shopping-basket', '', '1', '', ''),
('contact-job', 'basket-single', 'Job', '', 'fas fa-job', '', '1', '', ''),
('contact-shoprequest', 'basket-single', 'Shop', 'request', 'fas fa-request', '', '1', '', '');

