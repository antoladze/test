CREATE TABLE IF NOT EXISTS `book` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `create` timestamp NULL DEFAULT NULL,
  `update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `search` (`title`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `author` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `create` timestamp NULL DEFAULT NULL,
  `update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `search` (`name`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `reader` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `create` timestamp NULL DEFAULT NULL,
  `update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `book_author` (
  `book_id` int(11) unsigned NOT NULL,
  `author_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`book_id`,`author_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `book_reader` (
  `book_id` int(11) unsigned NOT NULL,
  `reader_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`book_id`,`reader_id`)
) ENGINE=InnoDB;