<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('mticketing_answers')};
CREATE TABLE IF NOT EXISTS {$this->getTable('mticketing_answers')} (
  `ID` int(7) NOT NULL auto_increment,
  `ticket` int(6) default '0',
  `message` text collate utf8_turkish_ci,
  `rep` int(5) NOT NULL default '0',
  `reference` int(7) default NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`),
  KEY `ticket` (`ticket`),
  KEY `timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci COMMENT='1.7.3' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS {$this->getTable('mticketing_attachments')};
CREATE TABLE IF NOT EXISTS {$this->getTable('mticketing_attachments')} (
  `ID` int(7) NOT NULL auto_increment,
  `ticket` int(6) NOT NULL default '0',
  `ref` int(7) NOT NULL default '0',
  `filename` varchar(100) collate utf8_turkish_ci NOT NULL default '',
  `type` varchar(15) collate utf8_turkish_ci NOT NULL default '',
  PRIMARY KEY  (`ID`),
  KEY `ticket` (`ticket`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci COMMENT='1.7.3' AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS {$this->getTable('mticketing_categories')};
CREATE TABLE IF NOT EXISTS {$this->getTable('mticketing_categories')} (
  `ID` int(5) NOT NULL auto_increment,
  `name` varchar(100) collate utf8_turkish_ci NOT NULL default '',
  `email` varchar(200) collate utf8_turkish_ci NOT NULL default '',
  `signature` text collate utf8_turkish_ci NOT NULL,
  `hidden` int(1) NOT NULL default '0',
  `reply_method` varchar(7) collate utf8_turkish_ci NOT NULL default 'url',
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci COMMENT='1.7.3' AUTO_INCREMENT=7 ;


INSERT INTO {$this->getTable('mticketing_categories')} (`ID`, `name`, `email`, `signature`, `hidden`, `reply_method`) VALUES
(1, 'Support', 'localhost', '', 0, 'url');


DROP TABLE IF EXISTS {$this->getTable('mticketing_messages')};
CREATE TABLE IF NOT EXISTS {$this->getTable('mticketing_messages')} (
  `ID` int(7) NOT NULL auto_increment,
  `ticket` int(6) NOT NULL default '0',
  `message` text collate utf8_turkish_ci,
  `headers` text collate utf8_turkish_ci,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`),
  KEY `ticket` (`ticket`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci COMMENT='1.7.3' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS {$this->getTable('mticketing_settings')};
CREATE TABLE IF NOT EXISTS {$this->getTable('mticketing_settings')} (
  `ID` int(5) NOT NULL auto_increment,
  `group` varchar(255) collate utf8_turkish_ci default NULL,
  `key` varchar(255) collate utf8_turkish_ci NOT NULL,
  `value` text collate utf8_turkish_ci NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `GROUP` (`group`),
  KEY `VALUE` (`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci COMMENT='1.7.3' AUTO_INCREMENT=85 ;


INSERT INTO {$this->getTable('mticketing_settings')} (`ID`, `group`, `key`, `value`) VALUES
(1, NULL, 'theme', 'eticket'),
(2, NULL, 'site_title', ''),
(3, NULL, 'charset', 'UTF-8'),
(4, NULL, 'presig', '\n\n'),
(5, NULL, 'short_date_format', 'm/d/Y'),
(6, NULL, 'answer_subj', '[#%ticket] %subject'),
(7, NULL, 'answer_msg', '%answer'),
(8, 'pri', '0', '1'),
(9, 'pri', '1', '2'),
(10, 'pri', '2', '3'),
(11, 'pri_text', '0', 'Low'),
(12, 'pri_text', '1', 'Normal'),
(13, 'pri_text', '2', 'High'),
(14, 'pri_style', '0', 'class=\"priLow\"'),
(15, 'pri_style', '1', 'class=\"priNormal\"'),
(16, 'pri_style', '2', 'class=\"priHigh\"'),
(17, NULL, 'rep_trans_response', '1'),
(18, NULL, 'rep_trans_subj', '[#%ticket] Representative Transfer'),
(19, NULL, 'rep_trans_msg', 'Ticket was transferred to representative %rep_name.'),
(20, NULL, 'nosubject', '[No Subject]'),
(21, NULL, 'ticket_format', '\\[#([0-9]{6})\\]'),
(22, NULL, 'subject_re', 'Re|Antw'),
(23, NULL, 'spamword', '[SPAM]'),
(24, NULL, 'flood_msg_rate', '10'),
(25, NULL, 'antispam_magicword', 'ANTI_SPAM_MAGICWORD'),
(26, NULL, 'antispam_subj', 'Ticked Rejected: Mail detected as SPAM'),
(27, NULL, 'antispam_msg', 'Your email was detected as spam and has been rejected. If your email was not spam, please re-send your email, including the word \"{MAGICWORD}\" in the body of the email.'),
(28, NULL, 'antispam_email', ''),
(29, NULL, 'accept_attachments', '0'),
(30, NULL, 'attachment_size', '1048576'),
(31, NULL, 'attachment_dir', ''),
(32, NULL, 'attachment_url', 'attachments.php'),
(33, NULL, 'search_disp', '1'),
(34, NULL, 'save_headers', '1'),
(35, NULL, 'time_format', 'l, F j Y g:ia'),
(36, NULL, 'min_interval', '60'),
(37, NULL, 'ticket_max', '10'),
(38, NULL, 'remove_original', '1'),
(39, NULL, 'remove_tag', '--please do not reply below this line--'),
(40, NULL, 'ticket_response', '1'),
(41, NULL, 'ticket_msg', 'A support ticket has been created (#%ticket). We will get back to you shortly.\r\n\r\nYou can view this ticket progress online here: %url/edit/id/%ticket\r\n\r\nNOTE: If you wish to send additional information regarding this ticket, please do not send another email. Instead, reply to this ticket.'),
(42, NULL, 'ticket_subj', '[#%ticket] Support Ticket Opened'),
(43, NULL, 'limit_response', '1'),
(44, NULL, 'limit_email', ''),
(45, NULL, 'limit_subj', 'Ticket Denied'),
(46, NULL, 'limit_msg', 'Ticket was not created for the email sent to %local_email from %user_email because there is a limit of %ticket_max open tickets per email address at any one time.\r\n\r\nTo be able to open another ticket, you must close one of your previous tickets first here:\r\n%url'),
(47, NULL, 'alert_new', '0'),
(48, NULL, 'alert_email', ''),
(49, NULL, 'alert_user', ''),
(50, NULL, 'alert_subj', '[#%ticket] New Message Alert'),
(51, NULL, 'alert_msg', 'There is a new message for ticket %ticket\r\n\r\nFrom: %email\r\n\r\n%url/edit/id/%ticket'),
(52, NULL, 'message_response', '1'),
(53, NULL, 'message_subj', '[#%ticket] Message Added'),
(54, NULL, 'message_msg', 'Your reply to support ticket #%ticket has been noted.\r\n\r\nYou can view this ticket progress online here: %url/edit/id/%ticket'),
(55, NULL, 'trans_response', '1'),
(56, NULL, 'trans_subj', '[#%ticket] Department Transfer'),
(57, NULL, 'trans_msg', 'Your ticket was transferred to the %cat_name department for further review.\r\n\r\n%trans_msg'),
(58, NULL, 'timezone', '0'),
(59, NULL, 'tickets_per_page', '10'),
(60, NULL, 'root_url', 'http://www.yourwebsitename.com/index.php/ticketsystem/index'),
(61, NULL, 'filetypes', '.jpg;.gif;.png;.pdf;.xls;.txt;.doc;.eml;.zip;.mp3;'),
(62, NULL, 'captcha_file', 'captcha.php'),
(63, NULL, 'accept_captcha', '0'),
(64, NULL, 'force_category', '0'),
(65, NULL, 'default_category', '1'),
(66, NULL, 'mail_method', 'mail'),
(67, NULL, 'smtp_host', 'localhost'),
(68, NULL, 'smtp_port', '25'),
(69, NULL, 'smtp_auth', '0'),
(70, NULL, 'smtp_user', 'user'),
(71, NULL, 'smtp_pass', 'pass'),
(72, NULL, 'show_badge', '1'),
(73, NULL, 'upgrade_check', '0'),
(74, NULL, 'last_check', '2009-01-01'),
(75, NULL, 'last_result', ''),
(76, NULL, 'activation_key', ''),
(77, NULL, 'sendmail_path', '/usr/sbin/sendmail'),
(78, NULL, '', ''),
(79, NULL, '', ''),
(80, NULL, '', ''),
(81, NULL, '', ''),
(82, NULL, '', ''),
(83, NULL, '', ''),
(84, NULL, '', '');

DROP TABLE IF EXISTS {$this->getTable('mticketing_tickets')};
CREATE TABLE IF NOT EXISTS {$this->getTable('mticketing_tickets')} (
  `subject` varchar(255) collate utf8_turkish_ci NOT NULL default '[No Subject]',
  `name` varchar(255) collate utf8_turkish_ci NOT NULL default '',
  `email` varchar(255) collate utf8_turkish_ci NOT NULL default '',
  `orders` varchar(255) collate utf8_turkish_ci default NULL,
  `phone` varchar(20) collate utf8_turkish_ci default NULL,
  `status` enum('new','onhold','custreplied','awaitingcustomer','reopened','closed') collate utf8_turkish_ci NOT NULL default 'new',
  `ID` int(6) NOT NULL default '0',
  `cat` int(5) NOT NULL default '0',
  `priority` tinyint(1) NOT NULL default '2',
  `ip` varchar(255) collate utf8_turkish_ci NOT NULL default '',
  `trans_msg` varchar(255) collate utf8_turkish_ci NOT NULL default '',
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`),
  KEY `timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci COMMENT='1.7.3';


");

$installer->endSetup();

