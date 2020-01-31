--
-- Base Table
--
CREATE TABLE `contact` (
  `Contact_ID` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `contact`
  ADD PRIMARY KEY (`Contact_ID`);

ALTER TABLE `contact`
  MODIFY `Contact_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Permissions
--
INSERT INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`) VALUES
('add', 'OnePlace\\Contact\\Controller\\ContactController', 'Add', '', '', 0),
('edit', 'OnePlace\\Contact\\Controller\\ContactController', 'Edit', '', '', 0),
('index', 'OnePlace\\Contact\\Controller\\ContactController', 'Index', 'Contacts', '/contact', 1),
('list', 'OnePlace\\Contact\\Controller\\ApiController', 'List', '', '', 1),
('view', 'OnePlace\\Contact\\Controller\\ContactController', 'View', '', '', 0),
('dump', 'OnePlace\\Contact\\Controller\\ExportController', 'Excel Dump', '', '', 0),
('index', 'OnePlace\\Contact\\Controller\\SearchController', 'Search', '', '', 0);

--
-- Form
--
INSERT INTO `core_form` (`form_key`, `label`, `entity_class`, `entity_tbl_class`) VALUES
('contact-single', 'Contact', 'OnePlace\\Contact\\Model\\Contact', 'OnePlace\\Contact\\Model\\ContactTable');

--
-- Index List
--
INSERT INTO `core_index_table` (`table_name`, `form`, `label`) VALUES
('contact-index', 'contact-single', 'Contact Index');

--
-- Tabs
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES ('contact-base', 'contact-single', 'Contact', 'Base', 'fas fa-cogs', '', '0', '', '');

--
-- Buttons
--
INSERT INTO `core_form_button` (`Button_ID`, `label`, `icon`, `title`, `href`, `class`, `append`, `form`, `mode`, `filter_check`, `filter_value`) VALUES
(NULL, 'Save Contact', 'fas fa-save', 'Save Contact', '#', 'primary saveForm', '', 'contact-single', 'link', '', ''),
(NULL, 'Edit Contact', 'fas fa-edit', 'Edit Contact', '/contact/edit/##ID##', 'primary', '', 'contact-view', 'link', '', ''),
(NULL, 'Add Contact', 'fas fa-plus', 'Add Contact', '/contact/add', 'primary', '', 'contact-index', 'link', '', ''),
(NULL, 'Export Contacts', 'fas fa-file-excel', 'Export Contacts', '/contact/export', 'primary', '', 'contact-index', 'link', '', ''),
(NULL, 'Find Contacts', 'fas fa-searh', 'Find Contacts', '/contact/search', 'primary', '', 'contact-index', 'link', '', ''),
(NULL, 'Export Contacts', 'fas fa-file-excel', 'Export Contacts', '#', 'primary initExcelDump', '', 'contact-search', 'link', '', ''),
(NULL, 'New Search', 'fas fa-searh', 'New Search', '/contact/search', 'primary', '', 'contact-search', 'link', '', '');

--
-- Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_ist`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'text', 'Name', 'label', 'contact-base', 'contact-single', 'col-md-3', '/contact/view/##ID##', '', 0, 1, 0, '', '', '');

--
-- Default Widgets
--
INSERT INTO `core_widget` (`Widget_ID`, `widget_name`, `label`, `permission`) VALUES
(NULL, 'contact_dailystats', 'Contact - Daily Stats', 'index-Contact\\Controller\\ContactController'),
(NULL, 'contact_taginfo', 'Contact - Tag Info', 'index-Contact\\Controller\\ContactController');

COMMIT;