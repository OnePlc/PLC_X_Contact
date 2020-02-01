--
-- Base Table
--
CREATE TABLE `skeleton` (
  `Skeleton_ID` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `skeleton`
  ADD PRIMARY KEY (`Skeleton_ID`);

ALTER TABLE `skeleton`
  MODIFY `Skeleton_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Permissions
--
INSERT INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`) VALUES
('add', 'OnePlace\\Skeleton\\Controller\\SkeletonController', 'Add', '', '', 0),
('edit', 'OnePlace\\Skeleton\\Controller\\SkeletonController', 'Edit', '', '', 0),
('index', 'OnePlace\\Skeleton\\Controller\\SkeletonController', 'Index', 'Skeletons', '/skeleton', 1),
('list', 'OnePlace\\Skeleton\\Controller\\ApiController', 'List', '', '', 1),
('view', 'OnePlace\\Skeleton\\Controller\\SkeletonController', 'View', '', '', 0),
('dump', 'OnePlace\\Skeleton\\Controller\\ExportController', 'Excel Dump', '', '', 0),
('index', 'OnePlace\\Skeleton\\Controller\\SearchController', 'Search', '', '', 0);

--
-- Form
--
INSERT INTO `core_form` (`form_key`, `label`, `entity_class`, `entity_tbl_class`) VALUES
('skeleton-single', 'Skeleton', 'OnePlace\\Skeleton\\Model\\Skeleton', 'OnePlace\\Skeleton\\Model\\SkeletonTable');

--
-- Index List
--
INSERT INTO `core_index_table` (`table_name`, `form`, `label`) VALUES
('skeleton-index', 'skeleton-single', 'Skeleton Index');

--
-- Tabs
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES ('skeleton-base', 'skeleton-single', 'Skeleton', 'Base', 'fas fa-cogs', '', '0', '', '');

--
-- Buttons
--
INSERT INTO `core_form_button` (`Button_ID`, `label`, `icon`, `title`, `href`, `class`, `append`, `form`, `mode`, `filter_check`, `filter_value`) VALUES
(NULL, 'Save Skeleton', 'fas fa-save', 'Save Skeleton', '#', 'primary saveForm', '', 'skeleton-single', 'link', '', ''),
(NULL, 'Edit Skeleton', 'fas fa-edit', 'Edit Skeleton', '/skeleton/edit/##ID##', 'primary', '', 'skeleton-view', 'link', '', ''),
(NULL, 'Add Skeleton', 'fas fa-plus', 'Add Skeleton', '/skeleton/add', 'primary', '', 'skeleton-index', 'link', '', ''),
(NULL, 'Export Skeletons', 'fas fa-file-excel', 'Export Skeletons', '/skeleton/export', 'primary', '', 'skeleton-index', 'link', '', ''),
(NULL, 'Find Skeletons', 'fas fa-searh', 'Find Skeletons', '/skeleton/search', 'primary', '', 'skeleton-index', 'link', '', ''),
(NULL, 'Export Skeletons', 'fas fa-file-excel', 'Export Skeletons', '#', 'primary initExcelDump', '', 'skeleton-search', 'link', '', ''),
(NULL, 'New Search', 'fas fa-searh', 'New Search', '/skeleton/search', 'primary', '', 'skeleton-search', 'link', '', '');

--
-- Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'text', 'Name', 'label', 'skeleton-base', 'skeleton-single', 'col-md-3', '/skeleton/view/##ID##', '', 0, 1, 0, '', '', '');

--
-- Default Widgets
--
INSERT INTO `core_widget` (`Widget_ID`, `widget_name`, `label`, `permission`) VALUES
(NULL, 'skeleton_dailystats', 'Skeleton - Daily Stats', 'index-Skeleton\\Controller\\SkeletonController'),
(NULL, 'skeleton_taginfo', 'Skeleton - Tag Info', 'index-Skeleton\\Controller\\SkeletonController');

COMMIT;