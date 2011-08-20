CREATE TABLE IF NOT EXISTS `#__bl_ranksort` (
  `seasonid` int(11) NOT NULL,
  `sort_field` varchar(255) NOT NULL,
  `sort_way` varchar(1) NOT NULL,
  `ordering` int(11) NOT NULL
)ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__bl_squard` (
  `match_id` int(11) NOT NULL default '0',
  `team_id` int(11) NOT NULL default '0',
  `player_id` int(11) NOT NULL default '0',
  `mainsquard` char(1) NOT NULL default '1',
  PRIMARY KEY  (`match_id`,`team_id`,`player_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__bl_moders` (
  `uid` int(11) NOT NULL default '0',
  `tid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`uid`,`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__bl_config` (
  `cfg_name` varchar(255) NOT NULL default '',
  `cfg_value` varchar(255) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__bl_feadmins` (
  `user_id` int(11) NOT NULL default '0',
  `season_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`season_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__bl_assign_photos` (
  `photo_id` int(11) NOT NULL default '0',
  `cat_id` int(11) NOT NULL default '0',
  `cat_type` int(11) NOT NULL default '0',
  PRIMARY KEY  (`photo_id`,`cat_id`,`cat_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__bl_events` (
  `id` int(11) NOT NULL auto_increment,
  `e_name` varchar(255) NOT NULL default '',
  `e_img` varchar(255) NOT NULL default '',
  `e_descr` text NOT NULL,
  `player_event` char(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;
CREATE TABLE IF NOT EXISTS `#__bl_extra_filds` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `published` char(1) NOT NULL default '1',
  `type` char(1) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);
CREATE TABLE IF NOT EXISTS `#__bl_extra_values` (
  `f_id` int(11) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0',
  `fvalue` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`f_id`,`uid`)
);
CREATE TABLE IF NOT EXISTS `#__bl_groups` (
  `id` int(11) NOT NULL auto_increment,
  `group_name` varchar(255) NOT NULL default '',
  `s_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;
CREATE TABLE IF NOT EXISTS `#__bl_grteams` (
  `g_id` int(11) NOT NULL default '0',
  `t_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`g_id`,`t_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__bl_languages` (
  `id` int(11) NOT NULL auto_increment,
  `lang_file` varchar(255) NOT NULL default '',
  `is_default` char(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;
CREATE TABLE IF NOT EXISTS `#__bl_match` (
  `id` int(11) NOT NULL auto_increment,
  `m_id` int(11) NOT NULL default '0',
  `team1_id` int(11) NOT NULL default '0',
  `team2_id` int(11) NOT NULL default '0',
  `score1` int(11) NOT NULL default '0',
  `score2` int(11) NOT NULL default '0',
  `match_descr` text NOT NULL,
  `published` char(1) NOT NULL default '0',
  `is_extra` char(1) NOT NULL default '0',
  `m_played` char(1) NOT NULL default '0',
  `m_date` date NOT NULL default '0000-00-00',
  `m_time` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;
CREATE TABLE IF NOT EXISTS `#__bl_match_events` (
  `e_id` int(11) NOT NULL default '0',
  `player_id` int(11) NOT NULL default '0',
  `match_id` int(11) NOT NULL default '0',
  `ecount` int(11) NOT NULL default '0',
  `minutes` varchar(255) NOT NULL default '',
  `t_id` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__bl_matchday` (
  `id` int(11) NOT NULL auto_increment,
  `m_name` varchar(255) NOT NULL default '',
  `m_descr` text NOT NULL,
  `s_id` int(11) NOT NULL default '0',
  `is_playoff` char(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `t_id` (`s_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__bl_photos` (
  `id` int(11) NOT NULL auto_increment,
  `ph_name` varchar(255) NOT NULL default '',
  `ph_filename` varchar(255) NOT NULL default '',
  `ph_descr` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;
CREATE TABLE IF NOT EXISTS `#__bl_players` (
  `id` int(11) NOT NULL auto_increment,
  `first_name` varchar(255) NOT NULL default '',
  `last_name` varchar(255) NOT NULL default '',
  `nick` varchar(255) NOT NULL default '',
  `about` text NOT NULL,
  `position_id` int(11) NOT NULL default '0',
  `def_img` int(11) NOT NULL default '0',
  `team_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;
CREATE TABLE IF NOT EXISTS `#__bl_positions` (
  `p_id` int(11) NOT NULL auto_increment,
  `p_name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`p_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
CREATE TABLE IF NOT EXISTS `#__bl_season_teams` (
  `season_id` int(11) NOT NULL default '0',
  `team_id` int(11) NOT NULL default '0',
  `bonus_point` int(11) NOT NULL default '0',
  PRIMARY KEY  (`season_id`,`team_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__bl_seasons` (
  `s_id` int(11) NOT NULL auto_increment,
  `s_name` varchar(255) NOT NULL default '',
  `s_descr` text NOT NULL,
  `s_rounds` int(11) NOT NULL default '1',
  `t_id` int(11) NOT NULL default '0',
  `published` char(1) NOT NULL default '0',
  `s_win_point` int(11) NOT NULL default '0',
  `s_lost_point` int(11) NOT NULL default '0',
  `s_enbl_extra` int(11) NOT NULL default '0',
  `s_extra_win` int(11) NOT NULL default '0',
  `s_extra_lost` int(11) NOT NULL default '0',
  `s_draw_point` int(11) NOT NULL default '0',
  `s_groups` int(11) NOT NULL default '0',
  `s_win_away` int(11) NOT NULL default '0',
  `s_draw_away` int(11) NOT NULL default '0',
  `s_lost_away` int(11) NOT NULL default '0',
  PRIMARY KEY  (`s_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;
CREATE TABLE IF NOT EXISTS `#__bl_tblcolors` (
  `s_id` int(11) NOT NULL default '0',
  `place` varchar(35) NOT NULL default '',
  `color` varchar(10) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__bl_teams` (
  `id` int(11) NOT NULL auto_increment,
  `t_name` varchar(255) NOT NULL default '',
  `t_descr` text NOT NULL,
  `t_yteam` char(1) NOT NULL default '0',
  `def_img` int(11) NOT NULL default '0',
  `t_emblem` varchar(255) NOT NULL default '',
  `t_city` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;
CREATE TABLE IF NOT EXISTS `#__bl_tournament` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `descr` text NOT NULL,
  `published` char(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;
CREATE TABLE IF NOT EXISTS `#__bl_season_option` (
  `s_id` int(11) NOT NULL default '0',
  `opt_name` varchar(255) NOT NULL default '',
  `opt_value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`s_id`,`opt_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;