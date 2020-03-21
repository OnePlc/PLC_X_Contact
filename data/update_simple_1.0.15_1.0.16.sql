ALTER TABLE `contact` DROP `skype`;
DELETE FROM `user_form_field` WHERE `field_idfs` = (select `Field_ID` from `core_form_field` where `fieldkey`='skype' AND `form` = 'contact-single');
DELETE FROM `core_form_field` WHERE `core_form_field`.`fieldkey` = 'skype' AND `core_form_field`.`form` = 'contact-single';