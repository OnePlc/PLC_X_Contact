ALTER TABLE `contact` ADD `description` TEXT NOT NULL DEFAULT '' AFTER `label`,
ADD `firstname` VARCHAR(255) NOT NULL DEFAULT '' AFTER `description`,
ADD `lastname` VARCHAR(255) NOT NULL DEFAULT '' AFTER `firstname`,
ADD `email_addr` VARCHAR(255) NOT NULL DEFAULT '' AFTER `lastname`,
ADD `phone` VARCHAR(20) NOT NULL DEFAULT '' AFTER `email_addr`,
ADD `featured_image` VARCHAR(255) NOT NULL DEFAULT '' AFTER `phone`,
ADD `salutation_idfs` INT(11) NOT NULL DEFAULT '0' AFTER `featured_image`,
ADD `title_idfs` INT(11) NOT NULL DEFAULT '0' AFTER `salutation_idfs`;