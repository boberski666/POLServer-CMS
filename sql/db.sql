CREATE TABLE `characters` (
  `char_id` int(12) UNSIGNED DEFAULT NULL,
  `char_name` varchar(150) DEFAULT NULL,
  `char_title` varchar(150) DEFAULT NULL,
  `char_race` varchar(150) DEFAULT NULL,
  `char_body` varchar(10) NOT NULL,
  `char_female` int(2) UNSIGNED DEFAULT NULL,
  `char_bodyhue` int(3) UNSIGNED DEFAULT NULL,
  `char_public` int(1) UNSIGNED DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `characters_layers` (
  `char_id` int(12) UNSIGNED DEFAULT NULL,
  `layer_id` int(3) UNSIGNED DEFAULT NULL,
  `item_id` int(12) UNSIGNED DEFAULT NULL,
  `item_hue` int(3) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `characters_online` (
  `char_id` int(11) NOT NULL,
  `char_name` varchar(255) NOT NULL,
  `login_time` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;