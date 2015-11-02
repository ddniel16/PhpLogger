CREATE TABLE `PhpLogger` (
    `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `priority` varchar(55) DEFAULT NULL,
    `log` text,
    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;