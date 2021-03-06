--
-- Base Table
--
CREATE TABLE `contact` (
  `Contact_ID` int(11) NOT NULL,
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
INSERT INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`, `needs_globaladmin`) VALUES
('add', 'OnePlace\\Contact\\Controller\\ContactController', 'Add', '', '', 0, 0),
('edit', 'OnePlace\\Contact\\Controller\\ContactController', 'Edit', '', '', 0, 0),
('index', 'OnePlace\\Contact\\Controller\\ContactController', 'Index', 'Contacts', '/contact', 1, 0),
('list', 'OnePlace\\Contact\\Controller\\ApiController', 'List', '', '', 1, 0),
('view', 'OnePlace\\Contact\\Controller\\ContactController', 'View', '', '', 0, 0),
('dump', 'OnePlace\\Contact\\Controller\\ExportController', 'Excel Dump', '', '', 0, 0),
('index', 'OnePlace\\Contact\\Controller\\SearchController', 'Search', '', '', 0, 0),
('save', 'OnePlace\\Contact\\Controller\\SearchController', 'Save Search', '', '', 0, 0);

--
-- Form
--
  INSERT INTO `core_form` (`form_key`, `label`, `entity_class`, `entity_tbl_class`) VALUES
('contact-single', 'Contact', 'OnePlace\\Contact\\Model\\Contact', 'OnePlace\\Contact\\Model\\ContactTable'),
('company-single', 'Company', 'OnePlace\\Contact\\Model\\Contact', 'OnePlace\\Contact\\Model\\ContactTable');

--
-- Index List
--
INSERT INTO `core_index_table` (`table_name`, `form`, `label`) VALUES
('contact-index', 'contact-single', 'Contact Index');

--
-- Tabs
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('contact-base', 'contact-single', 'Contact', 'Base', 'fas fa-cogs', '', '0', '', ''),
('company-base', 'company-single', 'Company', 'Base', 'fas fa-cogs', '', '0', '', '');

--
-- Buttons
--
INSERT INTO `core_form_button` (`Button_ID`, `label`, `icon`, `title`, `href`, `class`, `append`, `form`, `mode`, `filter_check`, `filter_value`) VALUES
(NULL, 'Save Contact', 'fas fa-save', 'Save Contact', '#', 'primary saveForm', '', 'contact-single', 'link', '', ''),
(NULL, 'Edit Contact', 'fas fa-edit', 'Edit Contact', '/contact/edit/##ID##', 'primary', '', 'contact-view', 'link', '', ''),
(NULL, 'Add Contact', 'fas fa-plus', 'Add Contact', '/contact/add', 'primary', '', 'contact-index', 'link', '', ''),
(NULL, 'Export Contacts', 'fas fa-file-excel', 'Export Contacts', '/contact/export', 'primary', '', 'contact-index', 'link', '', ''),
(NULL, 'Find Contacts', 'fas fa-search', 'Find Contacts', '/contact/search', 'primary', '', 'contact-index', 'link', '', ''),
(NULL, 'Export Contacts', 'fas fa-file-excel', 'Export Contacts', '#', 'primary initExcelDump', '', 'contact-search', 'link', '', ''),
(NULL, 'New Search', 'fas fa-search', 'New Search', '/contact/search', 'primary', '', 'contact-search', 'link', '', ''),
(NULL, 'Add Company', 'fas fa-plus', 'Add Company', '/contact/add/company', 'primary', '', 'contact-index', 'link', '', ''),
(NULL, 'Save Company', 'fas fa-save', 'Save Company', '#', 'primary saveForm', '', 'company-single', 'link', '', ''),
(NULL, 'Edit Company', 'fas fa-edit', 'Edit Company', '/contact/edit/##ID##', 'primary', '', 'company-view', 'link', '', '');

--
-- User XP Activity
--
INSERT INTO `user_xp_activity` (`Activity_ID`, `xp_key`, `label`, `xp_base`) VALUES
(NULL, 'contact-add', 'Add New Contact', '50'),
(NULL, 'contact-edit', 'Edit Contact', '5'),
(NULL, 'contact-export', 'Edit Contact', '5');

--
-- icon
--
INSERT INTO `settings` (`settings_key`, `settings_value`) VALUES ('contact-icon', 'fas fa-users');

--
-- quickseach fix
--
INSERT INTO `settings` (`settings_key`, `settings_value`) VALUES ('quicksearch-contact-customlabel', 'lastname');

COMMIT;