ALTER TABLE `contact` ADD `description` TEXT NOT NULL DEFAULT '' AFTER `label`,
ADD `firstname` TEXT NOT NULL DEFAULT '' AFTER `description`,
ADD `lastname` TEXT NOT NULL DEFAULT '' AFTER `firstname`,
ADD `email_addr` TEXT NOT NULL DEFAULT '' AFTER `lastname`,
ADD `phone` TEXT NOT NULL DEFAULT '' AFTER `email_addr`,
ADD `featured_image` VARCHAR(255) NOT NULL DEFAULT '' AFTER `phone`;
