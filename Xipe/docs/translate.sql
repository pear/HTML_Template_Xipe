# phpMyAdmin MySQL-Dump
# version 2.2.1
# http://phpwizard.net/phpMyAdmin/
# http://phpmyadmin.sourceforge.net/ (download page)
#
# Host: ludwig
# Generation Time: Jan 15, 2002 at 11:32 AM
# Server version: 3.23.37
# PHP Version: 4.0.6
# Database : `test`
# --------------------------------------------------------

#
# Table structure for table `translate_de`
#

CREATE TABLE translate_de (
  id int(11) NOT NULL auto_increment,
  string varchar(255) NOT NULL default '',
  convertHtml enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table `translate_de`
#

INSERT INTO translate_de VALUES (1, 'hier zusätzlich benutzte Features:', '0');
INSERT INTO translate_de VALUES (2, 'Quellcode', '0');
INSERT INTO translate_de VALUES (3, 'englisch', '0');
INSERT INTO translate_de VALUES (4, 'deutsch', '0');
INSERT INTO translate_de VALUES (5, 'übersetzen (z.B. in $2 )', '0');
INSERT INTO translate_de VALUES (6, 'dann solltest Du SimpleTemplate ausprobieren.', '0');
INSERT INTO translate_de VALUES (7, 'nebenbei konvertiert translate auch alle Texte in korrektes HTML wenn Du magst, wobei in DB alles normal abgelegt ist', '0');
# --------------------------------------------------------

#
# Table structure for table `translate_en`
#

CREATE TABLE translate_en (
  id int(11) NOT NULL auto_increment,
  string varchar(255) NOT NULL default '',
  numSubPattern tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table `translate_en`
#

INSERT INTO translate_en VALUES (1, 'here additionally used Features:', 0);
INSERT INTO translate_en VALUES (2, 'source code', 0);
INSERT INTO translate_en VALUES (3, 'english', 0);
INSERT INTO translate_en VALUES (4, 'german', 0);
INSERT INTO translate_en VALUES (5, 'translate \\(i.e. into (.*)\\)', 1);
INSERT INTO translate_en VALUES (6, 'then you should try SimpleTemplate.', 0);
INSERT INTO translate_en VALUES (7, 'translate does by the way also convert everything to proper HTML if you want to, but you can maintain it without that in the DB', 0);

