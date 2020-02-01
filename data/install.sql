--
-- Base Table
--
CREATE TABLE `article` (
  `Article_ID` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `article`
  ADD PRIMARY KEY (`Article_ID`);

ALTER TABLE `article`
  MODIFY `Article_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Permissions
--
INSERT INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`) VALUES
('add', 'OnePlace\\Article\\Controller\\ArticleController', 'Add', '', '', 0),
('edit', 'OnePlace\\Article\\Controller\\ArticleController', 'Edit', '', '', 0),
('index', 'OnePlace\\Article\\Controller\\ArticleController', 'Index', 'Articles', '/article', 1),
('list', 'OnePlace\\Article\\Controller\\ApiController', 'List', '', '', 1),
('view', 'OnePlace\\Article\\Controller\\ArticleController', 'View', '', '', 0),
('dump', 'OnePlace\\Article\\Controller\\ExportController', 'Excel Dump', '', '', 0),
('index', 'OnePlace\\Article\\Controller\\SearchController', 'Search', '', '', 0);

--
-- Form
--
INSERT INTO `core_form` (`form_key`, `label`, `entity_class`, `entity_tbl_class`) VALUES
('article-single', 'Article', 'OnePlace\\Article\\Model\\Article', 'OnePlace\\Article\\Model\\ArticleTable');

--
-- Index List
--
INSERT INTO `core_index_table` (`table_name`, `form`, `label`) VALUES
('article-index', 'article-single', 'Article Index');

--
-- Tabs
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES ('article-base', 'article-single', 'Article', 'Base', 'fas fa-cogs', '', '0', '', '');

--
-- Buttons
--
INSERT INTO `core_form_button` (`Button_ID`, `label`, `icon`, `title`, `href`, `class`, `append`, `form`, `mode`, `filter_check`, `filter_value`) VALUES
(NULL, 'Save Article', 'fas fa-save', 'Save Article', '#', 'primary saveForm', '', 'article-single', 'link', '', ''),
(NULL, 'Edit Article', 'fas fa-edit', 'Edit Article', '/article/edit/##ID##', 'primary', '', 'article-view', 'link', '', ''),
(NULL, 'Add Article', 'fas fa-plus', 'Add Article', '/article/add', 'primary', '', 'article-index', 'link', '', ''),
(NULL, 'Export Articles', 'fas fa-file-excel', 'Export Articles', '/article/export', 'primary', '', 'article-index', 'link', '', ''),
(NULL, 'Find Articles', 'fas fa-searh', 'Find Articles', '/article/search', 'primary', '', 'article-index', 'link', '', ''),
(NULL, 'Export Articles', 'fas fa-file-excel', 'Export Articles', '#', 'primary initExcelDump', '', 'article-search', 'link', '', ''),
(NULL, 'New Search', 'fas fa-searh', 'New Search', '/article/search', 'primary', '', 'article-search', 'link', '', '');

--
-- Fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'text', 'Name', 'label', 'article-base', 'article-single', 'col-md-3', '/article/view/##ID##', '', 0, 1, 0, '', '', '');

--
-- Default Widgets
--
INSERT INTO `core_widget` (`Widget_ID`, `widget_name`, `label`, `permission`) VALUES
(NULL, 'article_dailystats', 'Article - Daily Stats', 'index-Article\\Controller\\ArticleController'),
(NULL, 'article_taginfo', 'Article - Tag Info', 'index-Article\\Controller\\ArticleController');

COMMIT;