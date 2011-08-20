<?php
/*
joomsport
*/
/*
http://BearDev.com
 */
//  global $database, $mainframe;
function com_install() {
$database =& JFactory::getDBO();
  $dirname = dirname(__FILE__);
	$dirnameExploded = explode(DIRECTORY_SEPARATOR, $dirname);
	$jBasePath = "";
	$omitLast = 3;
	for ($i = 0; $i < sizeof($dirnameExploded) - $omitLast; $i++) {
		$jBasePath .= $dirnameExploded[$i];
		if ($i < (sizeof($dirnameExploded) - ($omitLast +1)))
			$jBasePath .= DIRECTORY_SEPARATOR;
	}
	if (!@ defined('DS'))
		define('DS', DIRECTORY_SEPARATOR); 
	
	///joomla 1.6
	$version = new JVersion;
	$joomla_v = $version->getShortVersion();
	if(substr($joomla_v,0,3) == '1.6'){
		$query = "SELECT `extension_id` FROM #__extensions WHERE `element` = 'com_joomsport'";
		$database->setQuery( $query );
		$exid = $database->loadResult();
		
		$query = "UPDATE #__menu SET component_id = ".$exid." WHERE link LIKE 'index.php?option=com_joomsport%'";
		$database->setQuery( $query );
		$database->query();
		$query = "UPDATE #__extensions SET name='com_joomsport' WHERE `element` = 'com_joomsport'";
		$database->setQuery( $query );
		$database->query();
	}else{
		$query = "SELECT `id` FROM #__components WHERE `option` = 'com_joomsport'";
		$database->setQuery( $query );
		$id = $database->loadResult();
		$query = "UPDATE #__components SET name='JoomSport' WHERE name='COM_JOOMSPORT'";
		$database->setQuery( $query );
		$database->query();
		$query = "UPDATE #__menu SET componentid = {$id} WHERE link LIKE 'index.php?option=com_joomsport%'";
		$database->setQuery( $query );
		$database->query();
		$jlang =& JFactory::getLanguage();
		$path = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomsport';
		$jlang->load('com_joomsport.sys', $path, 'en-GB', true);
		$jlang->load('com_joomsport.sys', $path, $jlang->getDefault(), true);
		$jlang->load('com_joomsport.sys', $path, null, true); 
	}
	
	
  $adminDir = dirname(__FILE__);
	@mkdir($jBasePath .DS. "media".DS."bearleague");
	@chmod($jBasePath .DS. "media".DS."bearleague", 0777);
	@mkdir($jBasePath .DS. "media".DS."bearleague".DS."events");
	@chmod($jBasePath .DS. "media".DS."bearleague".DS."events", 0777);
	@mkdir($jBasePath .DS. "media".DS."bearleague".DS."languages");
	@chmod($jBasePath .DS. "media".DS."bearleague".DS."languages", 0777);
	@mkdir($jBasePath .DS. "media".DS."bearleague".DS."thumbs");
	@chmod($jBasePath .DS. "media".DS."bearleague".DS."thumbs", 0777);
	@copy( $adminDir. DS."bearleague".DS."events".DS."red_card.png", $jBasePath . DS."media".DS."bearleague".DS."events".DS."red_card.png");
	@copy( $adminDir. DS."bearleague".DS."events".DS."yellow_card.png", $jBasePath . DS."media".DS."bearleague".DS."events".DS."yellow_card.png"); 
  	@copy( $adminDir. DS."bearleague".DS."events".DS."yellow-red_card.png", $jBasePath . DS."media".DS."bearleague".DS."events".DS."yellow-red_card.png");
	@copy( $adminDir. DS."bearleague".DS."events".DS."boot.png", $jBasePath . DS."media".DS."bearleague".DS."events".DS."boot.png"); 
	@copy( $adminDir. DS."bearleague".DS."events".DS."ball.png", $jBasePath . DS."media".DS."bearleague".DS."events".DS."ball.png"); 
	@copy( $adminDir. DS."bearleague".DS."languages".DS."default.php", $jBasePath . DS."media".DS."bearleague".DS."languages".DS."default.php"); 
	@copy( $adminDir. DS."bearleague".DS."languages".DS."default.php", $jBasePath . DS."media".DS."bearleague".DS."languages".DS."italian.php"); 
	
  	@copy( $adminDir. DS."bearleague".DS."player_st.gif", $jBasePath . DS."media".DS."bearleague".DS."player_st.gif");
	@copy( $adminDir. DS."bearleague".DS."teams_st.gif", $jBasePath . DS."media".DS."bearleague".DS."teams_st.gif"); 
	
	
	$query = "SELECT `id` FROM #__components WHERE `option` = 'com_joomsport'";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$query = "UPDATE #__menu SET componentid = {$id} WHERE link LIKE 'index.php?option=com_joomsport%'";
	$database->setQuery( $query );
	$database->query();
	
    $sql = "UPDATE #__components SET admin_menu_img='../administrator/components/com_joomsport/img/beardev.gif' WHERE admin_menu_link LIKE '%option=com_joomsport'";
    $database->setQuery($sql);
    $database->query();
    $sql = "UPDATE #__components SET admin_menu_img='../administrator/components/com_joomsport/img/tourn16.png' WHERE admin_menu_link LIKE '%option=com_joomsport&task=tour_list'";
    $database->setQuery($sql);
    $database->query();
  
    $sql = "UPDATE #__components SET admin_menu_img='../administrator/components/com_joomsport/img/players16.png' WHERE admin_menu_link LIKE '%option=com_joomsport&task=player_list'";
    $database->setQuery($sql);
    $database->query();
    $sql = "UPDATE #__components SET admin_menu_img='../administrator/components/com_joomsport/img/players16.png' WHERE admin_menu_link LIKE '%option=com_joomsport&task=pos_list'";
    $database->setQuery($sql);
    $database->query();
  
    $sql = "UPDATE #__components SET admin_menu_img='../administrator/components/com_joomsport/img/match16.png' WHERE admin_menu_link LIKE '%option=com_joomsport&task=matchday_list'";
    $database->setQuery($sql);
    $database->query();
    $sql = "UPDATE #__components SET admin_menu_img='../administrator/components/com_joomsport/img/events16.png' WHERE admin_menu_link LIKE '%option=com_joomsport&task=event_list'";
    $database->setQuery($sql);
    $database->query();
    $sql = "UPDATE #__components SET admin_menu_img='../administrator/components/com_joomsport/img/team16.png' WHERE admin_menu_link LIKE '%option=com_joomsport&task=team_list'";
    $database->setQuery($sql);
    $database->query();
	
    $sql = "UPDATE #__components SET admin_menu_img='../administrator/components/com_joomsport/img/season16.png' WHERE admin_menu_link LIKE '%option=com_joomsport&task=season_list'";
    $database->setQuery($sql);
    $database->query();
	
    $sql = "UPDATE #__components SET admin_menu_img='../administrator/components/com_joomsport/img/group16.png' WHERE admin_menu_link LIKE '%option=com_joomsport&task=group_list'";
    $database->setQuery($sql);
    $database->query();
	
    $sql = "UPDATE #__components SET admin_menu_img='../administrator/components/com_joomsport/img/additional16.png' WHERE admin_menu_link LIKE '%option=com_joomsport&task=fields_list'";
    $database->setQuery($sql);
    $database->query();
    $sql = "UPDATE #__components SET admin_menu_img='../administrator/components/com_joomsport/img/config16.png' WHERE admin_menu_link LIKE '%option=com_joomsport&task=languages'";
    $database->setQuery($sql);
    $database->query();
	$sql = "UPDATE #__components SET admin_menu_img='../administrator/components/com_joomsport/img/moder16.png' WHERE admin_menu_link LIKE '%option=com_joomsport&task=moder_list'";
    $database->setQuery($sql);
    $database->query();
	
	$sql = "UPDATE #__components SET admin_menu_img='../administrator/components/com_joomsport/img/config16.png' WHERE admin_menu_link LIKE '%option=com_joomsport&task=config'";
	$database->setQuery($sql);
	$database->query();
    $database->setQuery("UPDATE #__components SET admin_menu_img='../administrator/components/com_joomsport/img/about16.png' WHERE admin_menu_link LIKE 'option=com_joomsport&task=help'");
	$database->query();
	
	$database->setQuery("UPDATE #__components SET admin_menu_img='../administrator/components/com_joomsport/img/about16.png' WHERE admin_menu_link LIKE 'option=com_joomsport&task=about'");
	$database->query();
	
	$database->setQuery("ALTER TABLE `#__bl_match` ADD `m_played` VARCHAR(1) DEFAULT '1' NOT NULL");
	$database->query();
	
	$database->setQuery("ALTER TABLE `#__bl_extra_filds` ADD `e_table_view` VARCHAR(1) DEFAULT '0' NOT NULL");
	$database->query();
//john changes
	$database->setQuery("ALTER TABLE `#__bl_match` ADD `m_date` date default '0000-00-00' NOT NULL");
	$database->query();
	$database->setQuery("ALTER TABLE `#__bl_match` ADD `m_time` varchar(10) default '' NOT NULL ");
	$database->query();
	$database->setQuery("ALTER TABLE `#__bl_seasons` ADD `s_win_away` int(11) default '0' NOT NULL");
	$database->query();
	$database->setQuery("ALTER TABLE `#__bl_seasons` ADD `s_draw_away` int(11) default '0' NOT NULL");
	$database->query();
	$database->setQuery("ALTER TABLE `#__bl_seasons` ADD `s_lost_away` int(11) default '0' NOT NULL ");
	$database->query();
	$database->setQuery("ALTER TABLE `#__bl_tblcolors` CHANGE `place` `place` VARCHAR( 35 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ");
	$database->query();
	
	$database->SetQuery("DELETE FROM `#__bl_languages`");
	$database->query();
	//insert data into 'languages' table
	$database->SetQuery("INSERT INTO `#__bl_languages` (id, lang_file, is_default) VALUES (1, 'default', 1)");
	$database->query();
//	$database->SetQuery("INSERT INTO `#__bl_languages` (id, lang_file, is_default) VALUES (2, 'italian', 0)");
//	$database->query();
//end of john changes 
/* 1.0.8 */
	$database->setQuery("ALTER TABLE `#__bl_match` ADD `m_location` VARCHAR( 255 ) NOT NULL");
	$database->query();
	$database->setQuery("ALTER TABLE `#__bl_match_events` ADD `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY");
	$database->query();
	
	$query = "SELECT cfg_value FROM `#__bl_config` WHERE cfg_name='date_format'";
	$database->setQuery($query);
	if(!$database->loadResult()){
		$database->SetQuery("INSERT INTO `#__bl_config` (cfg_name,cfg_value) VALUES ('date_format', 'd-m-Y H:i')");
		$database->query();
	}
	$query = "SELECT cfg_value FROM `#__bl_config` WHERE cfg_name='yteam_color'";
	$database->setQuery($query);
	if(!$database->loadResult()){
		$database->SetQuery("INSERT INTO `#__bl_config` (cfg_name,cfg_value) VALUES ('yteam_color', '#FFFFFF')");
		$database->query();
	}
	
	//----events patch-----//
	$query = "SELECT * FROM #__bl_match_events WHERE t_id=0";
	$database->setQuery($query);
	$t_ev = $database->LoadObjectList();
	
	for($z=0;$z<count($t_ev);$z++){
		$ev = $t_ev[$z];
		$query = "SELECT team_id FROM #__bl_players WHERE id=".$ev->player_id;
		$database->setQuery($query);
		$tid = $database->loadResult();
		
		if($tid){
			$query = "UPDATE #__bl_match_events SET t_id=".$tid." WHERE id=".$ev->id;
			$database->setQuery($query);
			$database->query();
			
		}
	}
	// version 1.0.10
	$database->setQuery("ALTER TABLE `#__bl_match` ADD `bonus1` int(11) default '0' NULL");
	$database->query();
	$database->setQuery("ALTER TABLE `#__bl_match` ADD `bonus2` int(11) default '0' NULL");
	$database->query();
	
	$database->setQuery("ALTER TABLE `#__bl_tournament` ADD `logo` VARCHAR(255) NOT NULL");
	$database->query();
	
	//
	$database->setQuery("ALTER TABLE `#__bl_season_teams` ADD `bonus_point` int(11) default '0' NULL");
	$database->query();
	$database->setQuery("ALTER TABLE `#__bl_groups` ADD `ordering` INT NOT NULL");
	$database->query();
	
	// To float value
	$database->setQuery("ALTER TABLE `#__bl_seasons` CHANGE `s_win_point` `s_win_point` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0'");
	$database->query();
	$database->setQuery("ALTER TABLE `#__bl_seasons` CHANGE `s_lost_point` `s_lost_point` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0'");
	$database->query();
	$database->setQuery("ALTER TABLE `#__bl_seasons` CHANGE `s_extra_lost` `s_extra_lost` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0'");
	$database->query();
	$database->setQuery("ALTER TABLE `#__bl_seasons` CHANGE `s_extra_win` `s_extra_win` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0'");
	$database->query();
	$database->setQuery("ALTER TABLE `#__bl_seasons` CHANGE `s_draw_point` `s_draw_point` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0'");
	$database->query();
	$database->setQuery("ALTER TABLE `#__bl_seasons` CHANGE `s_win_away` `s_win_away` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0'");
	$database->query();
	$database->setQuery("ALTER TABLE `#__bl_seasons` CHANGE `s_draw_away` `s_draw_away` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0'");
	$database->query();
	$database->setQuery("ALTER TABLE `#__bl_seasons` CHANGE `s_lost_away` `s_lost_away` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0'");
	$database->query();
	$database->setQuery("ALTER TABLE `#__bl_match` CHANGE `bonus1` `bonus1` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0'");
	$database->query();
	$database->setQuery("ALTER TABLE `#__bl_match` CHANGE `bonus2` `bonus2` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0'");
	$database->query();
	$database->setQuery("ALTER TABLE `#__bl_season_teams` CHANGE `bonus_point` `bonus_point` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0'");
	$database->query();
	
	//create thumbs
	ob_start();
	require_once($jBasePath.'/components/com_joomsport/includes/thumb.php');
	createThumbs($jBasePath."/media/bearleague/",$jBasePath."/media/bearleague/thumbs/",100);
	ob_clean();
	/*global $mainframe;
	$mailer =& JFactory::getMailer();
	

	$mailer->setSender(array($mainframe->getCfg('mailfrom'), $mainframe->getCfg('fromname')));
	$mailer->setSubject('joomsport was intalled on '.$_SERVER['HTTP_HOST']);
	$mailer->setBody('joomsport was intalled on '.$_SERVER['HTTP_HOST']);
	

	$mailer->addRecipient('bearleague@beardev.com');

	$rs	= @$mailer->Send(); */
include_once($adminDir.DS.'jbl_about.php');
}