<?php
/*
BearDev.com
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once( JApplicationHelper::getPath( 'admin_html' ) );
require_once (JPATH_COMPONENT.DS.'admin.joomsport.class.php' );
$section 	= JRequest::getCmd( 'section', 'com_content' );
$cid 		= JRequest::getVar( 'cid', array(0), '', 'array' );
JArrayHelper::toInteger($cid, array(0));


// Load the submenu.
addSubmenu(JRequest::getCmd('task', 'joomsport'));
function addSubmenu($vName)
	{
		JSubMenuHelper::addEntry(
			JText::_('BLBE_TOURNAMENT'),
			'index.php?option=com_joomsport&task=tourn_list',
			$vName == 'tourn_list' || $vName == 'tour_edit' || $vName == ''
		);

		JSubMenuHelper::addEntry(
			JText::_('BLBE_SEASON'),
			'index.php?option=com_joomsport&task=season_list',
			$vName == 'season_list' || $vName == 'season_edit'
		);
		JSubMenuHelper::addEntry(
			JText::_('BLBE_MENTEAMS'),
			'index.php?option=com_joomsport&task=team_list',
			$vName == 'team_list' || $vName == 'team_edit'
		);
		JSubMenuHelper::addEntry(
			JText::_('BLBE_MENMD'),
			'index.php?option=com_joomsport&task=matchday_list',
			$vName == 'matchday_list' || $vName == 'matchday_edit' || $vName == 'match_edit'
		);
		JSubMenuHelper::addEntry(
			JText::_('BLBE_MENPL'),
			'index.php?option=com_joomsport&task=player_list',
			$vName == 'player_list' || $vName == 'player_edit'
		);
		JSubMenuHelper::addEntry(
			JText::_('BLBE_POSITION'),
			'index.php?option=com_joomsport&task=pos_list',
			$vName == 'pos_list' || $vName == 'pos_edit'
		);
		JSubMenuHelper::addEntry(
			JText::_('BLBE_MENEV'),
			'index.php?option=com_joomsport&task=event_list',
			$vName == 'event_list' || $vName == 'event_edit'
		);
		JSubMenuHelper::addEntry(
			JText::_('BLBE_MENGROUPS'),
			'index.php?option=com_joomsport&task=group_list',
			$vName == 'group_list' || $vName == 'group_edit'
		);
		JSubMenuHelper::addEntry(
			JText::_('BLBE_MODERATORS'),
			'index.php?option=com_joomsport&task=moder_list',
			$vName == 'moder_list' || $vName == 'moder_edit'
		);
		JSubMenuHelper::addEntry(
			JText::_('BLBE_MENAF'),
			'index.php?option=com_joomsport&task=fields_list',
			$vName == 'fields_list' || $vName == 'fields_edit'
		);
		JSubMenuHelper::addEntry(
			JText::_('BLBE_MENLANG'),
			'index.php?option=com_joomsport&task=languages',
			$vName == 'languages' || $vName == 'edit_lang'
		);
		JSubMenuHelper::addEntry(
			JText::_('BLBE_MENCONF'),
			'index.php?option=com_joomsport&task=config',
			$vName == 'config'
		);
		JSubMenuHelper::addEntry(
			JText::_('BLBE_MENAB'),
			'index.php?option=com_joomsport&task=about',
			$vName == 'about'
		);
		
		
	}

switch (JRequest::getCmd('task'))
{
	//-----Tournament---//
	case 'tour_list' :			BL_TourList($option);					break;
	case 'tour_add' :			BL_TourEdit(0, $option);				break;
	case 'tour_edit' :			BL_TourEdit($cid[0], $option);			break;
	case 'tour_publ' :			BL_TourPubl($cid,1,$option);			break;
	case 'tour_unpubl' :		BL_TourPubl($cid,0,$option);			break;
	case 'tour_apply':
	case 'tour_save' :			BL_TourSave($option);					break;
	case 'tour_del' :			BL_TourDel($cid, $option);				break;
	
	//-----Seasons---//
	case 'season_cancel':
	case 'season_list' :		BL_SeasonList($option);					break;
	case 'season_add' :			BL_SeasonEdit(0, $option);				break;
	case 'season_edit' :		BL_SeasonEdit($cid[0], $option);		break;
	case 'season_publ' :		BL_SeasonPubl($cid,1,$option);			break;
	case 'season_unpubl' :		BL_SeasonPubl($cid,0,$option);			break;
	case 'season_apply' :
	case 'season_save' :		BL_SeasonSave($option);					break;
	case 'season_del' :			BL_SeasonDel($cid, $option);			break;
	
	//-------Teams------------//
	case 'team_cancel':
	case 'team_list' :			BL_TeamList($option);					break;
	case 'team_add' :			BL_TeamEdit(0, $option);				break;
	case 'team_edit' :			BL_TeamEdit($cid[0], $option);			break;
	case 'team_apply' :
	case 'team_save' :			BL_TeamSave($option);					break;
	case 'team_del' :			BL_TeamDel($cid, $option);				break;
	
	//-------Position------------//
	case 'pos_cancel':
	case 'pos_list' :			BL_PosList($option);					break;
	case 'pos_add' :			BL_PosEdit(0, $option);					break;
	case 'pos_edit' :			BL_PosEdit($cid[0], $option);			break;
	case 'pos_save' :			BL_PosSave($option);					break;
	case 'pos_del' :			BL_PosDel($cid, $option);				break;
	
	//-------Player------------//
	case 'player_cancel':
	case 'player_list' :		BL_PlayerList($option);					break;
	case 'player_add' :			BL_PlayerEdit(0, $option);				break;
	case 'player_edit' :		BL_PlayerEdit($cid[0], $option);		break;
	case 'player_apply':
	case 'player_save' :		BL_PlayerSave($option);					break;
	case 'player_del' :			BL_PlayerDel($cid, $option);			break;
	
	//-------match day------------//
	case 'matchday_cancel':
	case 'matchday_list' :		BL_MdayList($option);					break;
	case 'matchday_add' :		BL_MdayEdit(0, $option);				break;
	case 'matchday_edit' :		BL_MdayEdit($cid[0], $option);			break;
	case 'matchday_apply' :
	case 'matchday_save' :		BL_MdaySave($option);					break;
	case 'matchday_del' :		BL_MdayDel($cid, $option);				break;
	
	//-------match ------------//
	case 'match_cancel':
	case 'match_list' :			BL_MatchList($option);					break;
	case 'match_add' :			BL_MatchEdit(0, $option);				break;
	case 'match_edit' :			BL_MatchEdit($cid[0], $option);			break;
	case 'match_apply' :
	case 'match_save' :			BL_MatchSave($option);					break;
	case 'match_del' :			BL_MatchDel($cid, $option);				break;
	
	//-------events ------------//
	case 'event_cancel':
	case 'event_list' :			BL_EventList($option);					break;
	case 'event_add' :			BL_EventEdit(0, $option);				break;
	case 'event_edit' :			BL_EventEdit($cid[0], $option);			break;
	case 'event_apply' :
	case 'event_save' :			BL_EventSave($option);					break;
	case 'event_del' :			BL_EventDel($cid, $option);				break;
	
	//-------groups ------------//
	case 'group_cancel':
	case 'group_list' :			BL_GroupList($option);					break;
	case 'group_add' :			BL_GroupEdit(0, $option);				break;
	case 'group_edit' :			BL_GroupEdit($cid[0], $option);			break;
	case 'group_apply' :
	case 'group_save' :			BL_GroupSave($option);					break;
	case 'group_del' :			BL_GroupDel($cid, $option);				break;
	case 'group_ordering':		BL_SaveOrderGr($option);				break;
	
	//----------new fields--------------//
	case 'fields_cancel':
	case 'fields_list':			BL_FieldsList($option,0);					break;
	case 'fields_add' :			BL_FieldsEdit(0, $option,0);				break;
	case 'fields_edit' :		BL_FieldsEdit($cid[0], $option,0);		break;
	case 'fields_apply' :
	case 'fields_save' :		BL_FieldsSave($option,0);					break;
	case 'fields_del' :			BL_FieldsDel($cid, $option,0);			break;
	case 'fields_publ' :		BL_FieldsPubl($cid,1,$option,0);			break;
	case 'fields_unpubl' :		BL_FieldsPubl($cid,0,$option,0);			break;
	case 'saveorder':			BL_SaveOrder($option);					break;
	# ---	LANGUAGES	--- #
	case 'languages':		BL_ViewLanguages( $option );						break;
	case 'del_lang':		BL_removeLanguage( $cid, $option);					break;
	case 'add_lang':		BL_editLanguage( '0', $option );					break;
	case 'edit_lang':		BL_editLanguage( intval( $cid[0] ), $option );		break;
	case 'editA_lang':		BL_editLanguage( intval( $cid[0] ), $option );					break;
	case 'cancel_lang':		BL_cancelLanguage( $option );						break;
	case 'apply_lang':
	case 'save_lang':		BL_saveLanguage( $option );							break;
	case 'default_lang':	BL_doDefaultLanguage( intval( $cid[0] ), $option );	break;
	//------modersreak;-------------///
	case 'moder_list':			BL_ModerList($option);					break;
	case 'moder_new':			BL_ModerEdit(0,$option);				break;
	case 'moder_edit':			BL_ModerEdit(intval( $cid[0] ),$option);break;
	case 'moder_delete':		BL_ModerDel($cid,$option);				break;
	case 'moder_apply':
	case 'moder_save':			BL_ModerSave($option);					break;
	
	//---menu-------------//
	case 'season_menu':			BL_Season_Menu($option);				break;
	case 'team_menu':			BL_TeamMenu($option);					break;
	
	case 'match_menu':			BL_MatchMenu($option);					break;
	
	case 'matchday_menu':		BL_MatchdayMenu($option);				break;
	
	case 'player_menu':			BL_PlayerMenu($option);					break;
	case 'group_menu':			BL_Group_Menu($option);					break;
	
	case 'help':				joomsport_html::BL_Help();				break;
	case 'about':				joomsport_html::BL_About();			break;
	//-------cfg---------//
	
	case 'config':				BL_Config($option);						break;
	
	case 'save_config':			BL_ConfigSave($option);					break;
	
	default:					BL_TourList($option);					break;
}	

//-------moderator-------//
function BL_ModerList($option){
	$mainframe = JFactory::getApplication();
	$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	$db			=& JFactory::getDBO();
	$query = "SELECT COUNT(DISTINCT(uid)) FROM #__bl_moders";
	$db->setQuery($query);
	$total = $db->loadResult();
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	$query = "SELECT u.*  FROM #__bl_moders as m,#__users as u WHERE u.id=m.uid GROUP BY m.uid";
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
	$rows = $db->loadObjectList();
	
		for($z=0;$z<count($rows);$z++){
			$query = "SELECT t.t_name  FROM #__bl_moders as m,#__bl_teams as t WHERE t.id=m.tid AND m.uid=".$rows[$z]->id;
			$db->setQuery($query);
			$rows[$z]->teams = $db->loadResultArray();
		}
	//var_dump($rows);
	joomsport_html::ModerList($rows, $pageNav, $option);
}
function BL_ModerEdit($is_id, $option){
	$db			=& JFactory::getDBO();
	
	$query = "SELECT * FROM #__users ORDER BY username";
	$db->setQuery($query);
	$moder = $db->loadObjectList();
	
	$lists['moder'] = @JHTML::_('select.genericlist',   $moder, 'moder_id', 'class="inputbox" size="1"', 'id', 'username', $is_id );
	$query = "SELECT * FROM #__bl_teams ORDER BY t_name";
	$db->setQuery($query);
	$teams = $db->loadObjectList();
	$lists['teams'] = @JHTML::_('select.genericlist',   $teams, 'teams_id', 'class="inputbox" size="10" multiple', 'id', 't_name', 0 );
	
	$query = "SELECT t.* FROM #__bl_teams as t, #__bl_moders as m WHERE m.tid=t.id AND m.uid=".$is_id." ORDER BY t.t_name";
	$db->setQuery($query);
	$teams_season = $db->loadObjectList();
	
	$lists['teams2'] = @JHTML::_('select.genericlist',   $teams_season, 'teams_season[]', 'class="inputbox" size="10" multiple', 'id', 't_name', 0 );
	joomsport_html::bl_editModer($lists, $option);
}
function BL_ModerSave($option){
	$mainframe = JFactory::getApplication();
	$db			=& JFactory::getDBO();
	
	$moder_id = intval(JRequest::getVar( 'moder_id', '0', 'post', 'int' ));
	
	$query = "DELETE FROM #__bl_moders WHERE uid = ".$moder_id;
	$db->setQuery($query);
	$db->query();
	$teams_season 		= JRequest::getVar( 'teams_season', array(0), '', 'array' );
	JArrayHelper::toInteger($teams_season, array(0));
	if(count($teams_season)){
		foreach($teams_season as $teams){
			$query = "INSERT INTO #__bl_moders(uid,tid) VALUES(".$moder_id.",".$teams.")";
			$db->setQuery($query);
			$db->query();
		}
	}
	if (JRequest::getCmd('task') == 'moder_apply') {
		$mainframe->redirect( 'index.php?option='.$option.'&task=moder_edit&cid[]='.$moder_id);
	}else{
		$mainframe->redirect( 'index.php?option='.$option.'&task=moder_list');
	}	
}	
function BL_ModerDel($cid, $option){
	$mainframe = JFactory::getApplication();
	$db			=& JFactory::getDBO();
	if(count($cid)){
		$cids = implode(',',$cid);
		$db->setQuery("DELETE FROM #__bl_moders WHERE uid IN (".$cids.")");
		$db->query();
	}
	$mainframe->redirect( 'index.php?option='.$option.'&task=moder_list');
}
	
///----------CFG-------------------///
function BL_Config($option){
	
	$db			=& JFactory::getDBO();
	
	$lists = array();
	
	$query = "SELECT cfg_value FROM #__bl_config WHERE cfg_name='date_format'";
	$db->setQuery($query);
	$lists['date_format'] = $db->loadResult();
	
	$is_data = array();
	
	$is_data[] = JHTML::_('select.option',  "d-m-Y H:i", "d-m-Y H:i", 'id', 'name' ); 
	$is_data[] = JHTML::_('select.option',  "m-d-Y g:i A", "m-d-Y g:i A", 'id', 'name' );
	$is_data[] = JHTML::_('select.option',  "j F, Y H:i", "j F, Y H:i", 'id', 'name' );
	$is_data[] = JHTML::_('select.option',  "j F, Y g:i A", "j F, Y g:i A", 'id', 'name' );
	$is_data[] = JHTML::_('select.option',  "d-m-Y", "d-m-Y", 'id', 'name' ); 
	$is_data[] = JHTML::_('select.option',  "l d F, Y H:i", "l d F, Y H:i", 'id', 'name' ); 
	$lists['data_sel'] = @JHTML::_('select.genericlist',   $is_data, 'date_format', 'class="inputbox" size="1"', 'id', 'name', $lists['date_format'] );
	
	$query = "SELECT cfg_value FROM #__bl_config WHERE cfg_name='yteam_color'";
	$db->setQuery($query);
	$lists['yteam_color'] = $db->loadResult();
	
	joomsport_html::bl_Config($lists, $option);
	
}
function BL_ConfigSave($option){
	
	$db			=& JFactory::getDBO();
	$mainframe = JFactory::getApplication();
	
	$date_format = JRequest::getVar( 'date_format', '', 'post', 'string' );
	$yteam_color = JRequest::getVar( 'yteam_color', '', 'post', 'string' );
	
	$query = "UPDATE #__bl_config SET cfg_value='".$date_format."' WHERE cfg_name='date_format'";
	$db->setquery($query);
	$db->query();
	
	$query = "UPDATE #__bl_config SET cfg_value='".$yteam_color."' WHERE cfg_name='yteam_color'";
	$db->setquery($query);
	$db->query();
	
	$mainframe->redirect( 'index.php?option='.$option.'&task=config');
	
}
///--------tournament------------////
function BL_TourList($option){
	$mainframe = JFactory::getApplication();
	$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	$db			=& JFactory::getDBO();
	$query = "SELECT COUNT(*) FROM #__bl_tournament ORDER BY name";
	$db->setQuery($query);
	$total = $db->loadResult();
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	$query = "SELECT * FROM #__bl_tournament ORDER BY name";
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
	$rows = $db->loadObjectList();
	joomsport_html::bl_TournList($rows, $pageNav, $option);
}
function BL_TourEdit($is_id, $option){
	$db			=& JFactory::getDBO();
	$row 	= new JTableTourn( $db);
	$row->load($is_id);
	$published = ($row->id) ? $row->published : 1;
	$lists['published'] 		= JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $published );
	joomsport_html::bl_editTourn($row, $lists, $option);
}
function BL_TourSave($option){
	$mainframe = JFactory::getApplication();
	
	$db			=& JFactory::getDBO();
	
	$post		= JRequest::get( 'post' );
	$post['descr'] = JRequest::getVar( 'descr', '', 'post', 'string', JREQUEST_ALLOWRAW );
	$istlogo = JRequest::getVar( 'istlogo', 0, 'post', 'int' );
	$row 	= new JTableTourn($db);
	if(!$istlogo){
		$post['logo'] = '';
	}
	if(isset($_FILES['t_logo']['name']) && $_FILES['t_logo']['tmp_name'] != '' && isset($_FILES['t_logo']['tmp_name'])){
		$bl_filename = strtolower($_FILES['t_logo']['name']);
		$bl_filename = "bl".time().rand(0,3000);
		$bl_filename = str_replace(" ","",$bl_filename);
		//echo $bl_filename;
		 if(uploadFile($_FILES['t_logo']['tmp_name'], $bl_filename)){
		 	$post['logo'] = $bl_filename;
		 }
	}
	
	if (!$row->bind( $post )) {
		JError::raiseError(500, $row->getError() );
	}
	
	if (!$row->check()) {
		JError::raiseError(500, $row->getError() );
	}
	// if new item order last in appropriate group
	
	if (!$row->store()) {
		JError::raiseError(500, $row->getError() );
	}
	$row->checkin();
	if (JRequest::getCmd('task') == 'tour_apply') {
		$mainframe->redirect( 'index.php?option='.$option.'&task=tour_edit&cid[]='.$row->id);
	}else{
		$mainframe->redirect( 'index.php?option='.$option);
	}
}
function BL_TourPubl($cid, $pb, $option){
	$mainframe = JFactory::getApplication();
	$db			=& JFactory::getDBO();
	
	if(count($cid)){
		$cids = implode(',',$cid);
		$query = "UPDATE #__bl_tournament SET published = ".$pb." WHERE id IN (".$cids.")";
		$db->setQuery($query);
		$db->query();
	}	
	$mainframe->redirect( 'index.php?option='.$option);
	
}
function BL_TourDel($cid, $option){
	$mainframe = JFactory::getApplication();
	$db			=& JFactory::getDBO();
	if(count($cid)){
		$cids = implode(',',$cid);
		$db->setQuery("DELETE FROM #__bl_tournament WHERE id IN (".$cids.")");
		$db->query();
	}
	$mainframe->redirect( 'index.php?option='.$option);
}
//------------seasons------------------//
function BL_SeasonList($option){
	$mainframe = JFactory::getApplication();
	
	$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	
	$db			=& JFactory::getDBO();
	$query = "SELECT COUNT(*) FROM #__bl_seasons as s LEFT JOIN #__bl_tournament as t ON t.id = s.t_id";
	$db->setQuery($query);
	$total = $db->loadResult();
	
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	
	$query = "SELECT s.*,s.s_id as id,t.name FROM #__bl_seasons as s LEFT JOIN #__bl_tournament as t ON t.id = s.t_id  ORDER BY s.s_name";
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
	$rows = $db->loadObjectList();
	
	joomsport_html::bl_SeasonList($rows, $pageNav, $option);
	
}
function BL_SeasonEdit($is_id, $option){
	$db			=& JFactory::getDBO();
	$row 	= new JTableSeason($db);
	$row->load($is_id);
	
	$published = ($row->s_id) ? $row->published : 1;
	$lists['published'] 		= JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $published );
	$is_tourn = array();
	$query = "SELECT * FROM #__bl_tournament ORDER BY name";
	$db->setQuery($query);
	$tourn = $db->loadObjectList();
	$is_tourn[] = JHTML::_('select.option',  0, JText::_('BLBE_SELTOURNAMENT'), 'id', 'name' ); 
	$tourn_is = array_merge($is_tourn,$tourn);
	$lists['tourn'] = JHTML::_('select.genericlist',   $tourn_is, 't_id', 'class="inputbox" size="1"', 'id', 'name', $row->t_id );
	
	$query = "SELECT * FROM #__bl_teams ORDER BY t_name";
	$db->setQuery($query);
	$teams = $db->loadObjectList();
	$lists['teams'] = @JHTML::_('select.genericlist',   $teams, 'teams_id', 'class="inputbox" size="10" multiple', 'id', 't_name', 0 );
	
	$query = "SELECT t.id as id, t.t_name as t_name FROM #__bl_season_teams as st, #__bl_teams as t WHERE st.season_id = ".$row->s_id." AND t.id = st.team_id ORDER BY t.t_name";
	$db->setQuery($query);
	$teams_season = $db->loadObjectList();
	$lists['teams2'] = @JHTML::_('select.genericlist',   $teams_season, 'teams_season[]', 'class="inputbox" size="10" multiple', 'id', 't_name', 0 );
	$lists['s_groups'] 		= @JHTML::_('select.booleanlist',  's_groups', 'class="inputbox"', $row->s_groups );
	
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='win_chk'";
	$db->setQuery($query);
	$lists['win_chk'] = $db->loadResult();
	
	
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='lost_chk'";
	$db->setQuery($query);
	$lists['lost_chk'] = $db->loadResult();
	
	
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='draw_chk'";
	$db->setQuery($query);
	$lists['draw_chk'] = $db->loadResult();
	
	
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='otwin_chk'";
	$db->setQuery($query);
	$lists['otwin_chk'] = $db->loadResult();
	
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='otlost_chk'";
	$db->setQuery($query);
	$lists['otlost_chk'] = $db->loadResult();
	
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='diff_chk'";
	$db->setQuery($query);
	$lists['diff_chk'] = $db->loadResult();
	
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='gd_chk'";
	$db->setQuery($query);
	$lists['gd_chk'] = $db->loadResult();
	
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='point_chk'";
	$db->setQuery($query);
	$lists['point_chk'] = $db->loadResult();
	
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='percent_chk'";
	$db->setQuery($query);
	$lists['percent_chk'] = $db->loadResult();
	
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='played_chk'";
	$db->setQuery($query);
	$lists['played_chk'] = $db->loadResult();
	
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='emblem_chk'";
	$db->setQuery($query);
	$lists['emblem_chk'] = $db->loadResult();
	
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='goalscore_chk'";
	$db->setQuery($query);
	$lists['goalscore_chk'] = $db->loadResult();
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='goalconc_chk'";
	$db->setQuery($query);
	$lists['goalconc_chk'] = $db->loadResult();
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='winhome_chk'";
	$db->setQuery($query);
	$lists['winhome_chk'] = $db->loadResult();
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='winaway_chk'";
	$db->setQuery($query);
	$lists['winaway_chk'] = $db->loadResult();
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='drawhome_chk'";
	$db->setQuery($query);
	$lists['drawhome_chk'] = $db->loadResult();
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='drawaway_chk'";
	$db->setQuery($query);
	$lists['drawaway_chk'] = $db->loadResult();
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='losthome_chk'";
	$db->setQuery($query);
	$lists['losthome_chk'] = $db->loadResult();
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='lostaway_chk'";
	$db->setQuery($query);
	$lists['lostaway_chk'] = $db->loadResult();
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='pointshome_chk'";
	$db->setQuery($query);
	$lists['pointshome_chk'] = $db->loadResult();
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='pointsaway_chk'";
	$db->setQuery($query);
	$lists['pointsaway_chk'] = $db->loadResult();
	//----colors----//
	$query = "SELECT * FROM #__bl_tblcolors WHERE s_id=".$row->s_id." ORDER BY place";
	$db->setQuery($query);
	$lists['colors'] = $db->loadObjectList();
	//===access====//
	$query = "SELECT * FROM #__users ORDER BY username";
	$db->setQuery($query);
	$f_users = $db->loadObjectList();
	$lists['usrlist'] = @JHTML::_('select.genericlist',   $f_users, 'usracc_id', 'class="inputbox" size="10" multiple', 'id', 'username', 0 );
	
	$query = "SELECT u.id as id, u.username as t_name FROM #__users as u, #__bl_feadmins as f WHERE f.user_id = u.id AND f.season_id=".$row->s_id." ORDER BY u.username";
	$db->setQuery($query);
	$f_admins = $db->loadObjectList();
	$lists['usrlist_vyb'] = @JHTML::_('select.genericlist',   $f_admins, 'usr_admins[]', 'class="inputbox" size="10" multiple', 'id', 't_name', 0 );
	
	///----list of ranking criteria----///
	$sortway = array();
	$sortway[] = JHTML::_('select.option',  0, JText::_('desc'), 'id', 'name' );
	$sortway[] = JHTML::_('select.option',  1, JText::_('asc'), 'id', 'name' ); 
	 
	
	$lists['sortway'] = $sortway;//JHTML::_('select.genericlist',   $sortway, 'sortway[]', 'class="inputbox"', 'id', 'name', 0 );
	
	$sortfield[] = JHTML::_('select.option',  0, JText::_('No'), 'id', 'name' ); 
	$sortfield[] = JHTML::_('select.option',  1, JText::_('BLBE_SELPOINTS'), 'id', 'name' ); 
	$sortfield[] = JHTML::_('select.option',  2, JText::_('BLBE_SELWPC'), 'id', 'name' ); 
	//$sortfield[] = JHTML::_('select.option',  3, JText::_('If equal points/win percent games between teams'), 'id', 'name' ); 
	$sortfield[] = JHTML::_('select.option',  4, JText::_('BLBE_SELGD'), 'id', 'name' );
	$sortfield[] = JHTML::_('select.option',  5, JText::_('BLBE_SELGS'), 'id', 'name' ); 
	
	$lists['sortfield'] = $sortfield;//JHTML::_('select.genericlist',   $sortfield, 'sortfield[]', 'class="inputbox"', 'id', 'name', 0 );
	
	$query = "SELECT * FROM #__bl_ranksort WHERE seasonid=".$row->s_id." ORDER BY ordering";
	$db->setQuery($query);
	$lists['savedsort'] = $db->loadObjectList();
	
	$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$row->s_id." AND opt_name='equalpts_chk'";
	$db->setQuery($query);
	$lists['equalpts_chk'] = $db->loadResult();
	
	joomsport_html::bl_editSeason($row, $lists, $option);
}
function BL_SeasonSave($option){
	$mainframe = JFactory::getApplication();
	
	$db			=& JFactory::getDBO();
	
	$post		= JRequest::get( 'post' );
	$post['s_enbl_extra'] = JRequest::getVar( 's_enbl_extra', 0, 'post', 'int' );
	$post['s_descr'] = JRequest::getVar( 's_descr', '', 'post', 'string', JREQUEST_ALLOWRAW );
	$row 	= new JTableSeason($db);
	$win_chk = JRequest::getVar( 'win_chk', 0, 'post', 'int' );
	$lost_chk = JRequest::getVar( 'lost_chk', 0, 'post', 'int' );
	$draw_chk = JRequest::getVar( 'draw_chk', 0, 'post', 'int' );
	$otwin_chk = JRequest::getVar( 'otwin_chk', 0, 'post', 'int' );
	$otlost_chk = JRequest::getVar( 'otlost_chk', 0, 'post', 'int' );
	$diff_chk = JRequest::getVar( 'diff_chk', 0, 'post', 'int' );
	$gd_chk = JRequest::getVar( 'gd_chk', 0, 'post', 'int' );
	$point_chk = JRequest::getVar( 'point_chk', 0, 'post', 'int' );
	$percent_chk = JRequest::getVar( 'percent_chk', 0, 'post', 'int' );
	$equalpts_chk = JRequest::getVar( 'equalpts_chk', 0, 'post', 'int' );
	$played_chk = JRequest::getVar( 'played_chk', 0, 'post', 'int' );
	$emblem_chk = JRequest::getVar( 'emblem_chk', 0, 'post', 'int' );
	$goalscore_chk = JRequest::getVar( 'goalscore_chk', 0, 'post', 'int' );
	$goalconc_chk = JRequest::getVar( 'goalconc_chk', 0, 'post', 'int' );
	$winhome_chk = JRequest::getVar( 'winhome_chk', 0, 'post', 'int' );
	$winaway_chk = JRequest::getVar( 'winaway_chk', 0, 'post', 'int' );
	$drawhome_chk = JRequest::getVar( 'drawhome_chk', 0, 'post', 'int' );
	$drawaway_chk = JRequest::getVar( 'drawaway_chk', 0, 'post', 'int' );
	$losthome_chk = JRequest::getVar( 'losthome_chk', 0, 'post', 'int' );
	$lostaway_chk = JRequest::getVar( 'lostaway_chk', 0, 'post', 'int' );
	$pointshome_chk = JRequest::getVar( 'pointshome_chk', 0, 'post', 'int' );
	$pointsaway_chk = JRequest::getVar( 'pointsaway_chk', 0, 'post', 'int' );
	
	if (!$row->bind( $post )) {
		JError::raiseError(500, $row->getError() );
	}
	if (!$row->check()) {
		JError::raiseError(500, $row->getError() );
	}
	// if new item order last in appropriate group
	
	if (!$row->store()) {
		JError::raiseError(500, $row->getError() );
	}
	$row->checkin();
	
	$query = "DELETE FROM #__bl_season_teams WHERE season_id = ".$row->s_id;
	$db->setQuery($query);
	$db->query();
	
	$teams_season 		= JRequest::getVar( 'teams_season', array(0), '', 'array' );
	JArrayHelper::toInteger($teams_season, array(0));
	if(count($teams_season)){
		foreach($teams_season as $teams){
			$query = "INSERT INTO #__bl_season_teams(season_id,team_id) VALUES(".$row->s_id.",".$teams.")";
			$db->setQuery($query);
			$db->query();
		}
	}
///------------access---
	$query = "DELETE FROM #__bl_feadmins WHERE season_id = ".$row->s_id;
	$db->setQuery($query);
	$db->query();
	
	$usr_admins 		= JRequest::getVar( 'usr_admins', array(0), '', 'array' );
	JArrayHelper::toInteger($usr_admins, array(0));
	if(count($usr_admins)){
		foreach($usr_admins as $usrz){
			$query = "INSERT INTO #__bl_feadmins(season_id,user_id) VALUES(".$row->s_id.",".$usrz.")";
			$db->setQuery($query);
			$db->query();
		}
	}		
	
	//season params
	
	$query = "DELETE FROM #__bl_season_option WHERE s_id = ".$row->s_id;
	$db->setQuery($query);
	$db->query();
	
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'win_chk','".$win_chk."')";
	$db->setQuery($query);
	$db->query();
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'lost_chk','".$lost_chk."')";
	$db->setQuery($query);
	$db->query();
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'draw_chk','".$draw_chk."')";
	$db->setQuery($query);
	$db->query();
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'otwin_chk','".$otwin_chk."')";
	$db->setQuery($query);
	$db->query();
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'otlost_chk','".$otlost_chk."')";
	$db->setQuery($query);
	$db->query();
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'diff_chk','".$diff_chk."')";
	$db->setQuery($query);
	$db->query();
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'gd_chk','".$gd_chk."')";
	$db->setQuery($query);
	$db->query();
	
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'point_chk','".$point_chk."')";
	$db->setQuery($query);
	$db->query();
	
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'percent_chk','".$percent_chk."')";
	$db->setQuery($query);
	$db->query();
	
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'equalpts_chk','".$equalpts_chk."')";
	$db->setQuery($query);
	$db->query();
	
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'played_chk','".$played_chk."')";
	$db->setQuery($query);
	$db->query();
	
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'emblem_chk','".$emblem_chk."')";
	$db->setQuery($query);
	$db->query();
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'goalscore_chk','".$goalscore_chk."')";
	$db->setQuery($query);
	$db->query();
	//2.0.7
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'goalconc_chk','".$goalconc_chk."')";
	$db->setQuery($query);
	$db->query();
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'winhome_chk','".$winhome_chk."')";
	$db->setQuery($query);
	$db->query();
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'winaway_chk','".$winaway_chk."')";
	$db->setQuery($query);
	$db->query();
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'drawhome_chk','".$drawhome_chk."')";
	$db->setQuery($query);
	$db->query();
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'drawaway_chk','".$drawaway_chk."')";
	$db->setQuery($query);
	$db->query();
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'losthome_chk','".$losthome_chk."')";
	$db->setQuery($query);
	$db->query();
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'lostaway_chk','".$lostaway_chk."')";
	$db->setQuery($query);
	$db->query();
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'pointshome_chk','".$pointshome_chk."')";
	$db->setQuery($query);
	$db->query();
	$query = "INSERT INTO #__bl_season_option(s_id,opt_name,opt_value) VALUES($row->s_id,'pointsaway_chk','".$pointsaway_chk."')";
	$db->setQuery($query);
	$db->query();
	///-------------colors---------//
	
	$query = "DELETE FROM #__bl_tblcolors WHERE s_id=".$row->s_id;
	$db->setQuery($query);
	$db->query();
	
	$rowcount = JRequest::getVar( 'col_count', 0, 'post', 'int' );
	for($z=1;$z<$rowcount+1;$z++){
		if($_POST['place_'.$z] && $_POST['input_field_'.$z]){
			$query = "INSERT INTO #__bl_tblcolors(s_id,place,color) VALUES(".$row->s_id.",'".$_POST['place_'.$z]."','".$_POST['input_field_'.$z]."')";
			$db->setQuery($query);
			$db->query();
		}
	}
	
	///--------------Ranking sort---------------////
	$query = "DELETE FROM #__bl_ranksort WHERE seasonid = ".$row->s_id;
	$db->setQuery($query);
	$db->query();
	$i=0;
	$sortfield 		= JRequest::getVar( 'sortfield', array(0), '', 'array' );
	JArrayHelper::toInteger($sortfield, array(0));
	if(count($sortfield)){
		foreach($sortfield as $usrz){
			if($usrz){
				$query = "INSERT INTO #__bl_ranksort(seasonid,sort_field,sort_way,ordering) VALUES(".$row->s_id.",'".$usrz."','".intval($_POST['sortway'][$i])."',".$i.")";
				$db->setQuery($query);
				$db->query();
				$i++;
			}
		}
	}
	
	
	if(JRequest::getCmd('task') == "season_apply"){
		$mainframe->redirect( 'index.php?option='.$option."&task=season_edit&cid[]=".$row->s_id);
	}else{
		$mainframe->redirect( 'index.php?option='.$option.'&task=season_list');
	}
	
}
function BL_SeasonPubl($cid, $pb, $option){
	$mainframe = JFactory::getApplication();
	$db			=& JFactory::getDBO();
	
	if(count($cid)){
		$cids = implode(',',$cid);
		$query = "UPDATE #__bl_seasons SET published = ".$pb." WHERE s_id IN (".$cids.")";
		$db->setQuery($query);
		$db->query();
	}	
	$mainframe->redirect( 'index.php?option='.$option.'&task=season_list');
	
}
function BL_SeasonDel($cid, $option){
	$mainframe = JFactory::getApplication();
	$db			=& JFactory::getDBO();
	if(count($cid)){
		$cids = implode(',',$cid);
		$db->setQuery("DELETE FROM #__bl_seasons WHERE s_id IN (".$cids.")");
		$db->query();
	}
	$mainframe->redirect( 'index.php?option='.$option.'&task=season_list');
}
///--------Teams------------////
function BL_TeamList($option){
	$mainframe = JFactory::getApplication();
	
	$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	
	$db			=& JFactory::getDBO();
	$query = "SELECT COUNT(*) FROM #__bl_teams ORDER BY t_name";
	$db->setQuery($query);
	$total = $db->loadResult();
	
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	
	$query = "SELECT * FROM #__bl_teams ORDER BY t_name";
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
	$rows = $db->loadObjectList();
	
	joomsport_html::bl_TeamList($rows, $pageNav, $option);
	
}
function BL_TeamEdit($is_id, $option){
	$db			=& JFactory::getDBO();
	$row 	= new JTableTeams($db);
	$row->load($is_id);
	
	$query = "SELECT p.ph_name as name,p.id as id,p.ph_filename as filename FROM #__bl_assign_photos as ap, #__bl_photos as p WHERE ap.photo_id = p.id AND cat_type = 2 AND cat_id = ".$row->id."";
	$db->setQuery($query);
	$lists['photos'] = $db->loadObjectList();
	
	$query = "SELECT ef.*,ev.fvalue as fvalue FROM #__bl_extra_filds as ef LEFT JOIN #__bl_extra_values as ev ON ef.id=ev.f_id AND ev.uid=".$row->id." WHERE ef.published=1 AND ef.type='1' ORDER BY ef.ordering";
	$db->setQuery($query);
	$lists['ext_fields'] = $db->loadObjectList();
	
	$query = "SELECT st.*,CONCAT(t.name,' ',s.s_name) as name FROM  #__bl_seasons as s LEFT JOIN #__bl_tournament as t ON t.id = s.t_id, #__bl_season_teams as st WHERE s.s_id = st.season_id AND st.team_id=".$row->id;
	$db->setQuery($query);
	$lists["bonuses"] = $db->loadObjectList();
	
	joomsport_html::bl_editTeam($row, $lists, $option);
}
function BL_TeamSave($option){
	$mainframe = JFactory::getApplication();
	
	$db			=& JFactory::getDBO();
	
	$post		= JRequest::get( 'post' );
	$post['t_descr'] = JRequest::getVar( 't_descr', '', 'post', 'string', JREQUEST_ALLOWRAW );
	$post['def_img'] = JRequest::getVar( 'ph_default', 0, 'post', 'int' );
	$post['t_yteam'] = JRequest::getVar( 't_yteam', 0, 'post', 'int' );
	$row 	= new JTableTeams($db);
	$istlogo = JRequest::getVar( 'istlogo', 0, 'post', 'int' );
	
	if(!$istlogo){
		$post['t_emblem'] = '';
	}
        
	if(isset($_FILES['t_logo']['name']) && $_FILES['t_logo']['tmp_name'] != '' && isset($_FILES['t_logo']['tmp_name'])){
		$bl_filename = strtolower($_FILES['t_logo']['name']);
		$ext = pathinfo($_FILES['t_logo']['name']);
		$bl_filename = "bl".time().rand(0,3000).'.'.$ext['extension'];
		$bl_filename = str_replace(" ","",$bl_filename);
                
		//echo $bl_filename;
		 if(uploadFile($_FILES['t_logo']['tmp_name'], $bl_filename)){
		 	$post['t_emblem'] = $bl_filename;
		 }
	}
	if (!$row->bind( $post )) {
		JError::raiseError(500, $row->getError() );
	}
	if (!$row->check()) {
		JError::raiseError(500, $row->getError() );
	}
	// if new item order last in appropriate group
	
	if (!$row->store()) {
		JError::raiseError(500, $row->getError() );
	}
	$row->checkin();

	$query = "DELETE FROM #__bl_assign_photos WHERE cat_type = 2 AND cat_id = ".$row->id;
	$db->setQuery($query);
	$db->query();
	if(isset($_POST['photos_id']) && count($_POST['photos_id'])){
		for($i = 0; $i < count($_POST['photos_id']); $i++){
			$photo_id = intval($_POST['photos_id'][$i]);
			$photo_name = addslashes(strval($_POST['ph_names'][$i]));
			$query = "INSERT INTO #__bl_assign_photos(photo_id,cat_id,cat_type) VALUES(".$photo_id.",".$row->id.",2)";
		 	$db->setQuery($query);
			$db->query();
			
			$query = "UPDATE #__bl_photos SET ph_name = '".($photo_name)."' WHERE id = ".$photo_id;
			$db->setQuery($query);
			$db->query();
		}
	}

	if(isset($_FILES['player_photo_1']['name']) && $_FILES['player_photo_1']['tmp_name'] != '' && isset($_FILES['player_photo_1']['tmp_name'])){
		$bl_filename = strtolower($_FILES['player_photo_1']['name']);
		$ext = pathinfo($_FILES['player_photo_1']['name']);
		$bl_filename = "bl".time().rand(0,3000).'.'.$ext['extension'];
		$bl_filename = str_replace(" ","",$bl_filename);
		//echo $bl_filename;
		 if(uploadFile($_FILES['player_photo_1']['tmp_name'], $bl_filename)){
		 	$post1['ph_filename'] = $bl_filename;
			
			$img1 = new JTablePhotos($db);
			$img1->id = 0;
			if (!$img1->bind( $post1 )) {
				JError::raiseError(500, $img1->getError() );
			}
			if (!$img1->check()) {
				JError::raiseError(500, $img1->getError() );
			}
			// if new item order last in appropriate group
			
			if (!$img1->store()) {
				JError::raiseError(500, $img1->getError() );
			}
			$img1->checkin();
			
			$query = "INSERT INTO #__bl_assign_photos(photo_id,cat_id,cat_type) VALUES(".$img1->id.",".$row->id.",2)";
		 	$db->setQuery($query);
			$db->query();
		 }
	}

	if(isset($_FILES['player_photo_2']['name']) && $_FILES['player_photo_2']['tmp_name'] != ''  && isset($_FILES['player_photo_2']['tmp_name'])){
		 $bl_filename = strtolower($_FILES['player_photo_2']['name']);
		$ext = pathinfo($_FILES['player_photo_2']['name']);
		$bl_filename = "bl".time().rand(0,3000).'.'.$ext['extension'];
		$bl_filename = str_replace(" ","",$bl_filename);
		 if(uploadFile($_FILES['player_photo_2']['tmp_name'], $bl_filename)){
		 	$post2['ph_filename'] = $bl_filename;
			
			$img2 = new JTablePhotos($db);
			$img2->id = 0;
			if (!$img2->bind( $post2 )) {
				JError::raiseError(500, $img2->getError() );
			}
			if (!$img2->check()) {
				JError::raiseError(500, $img2->getError() );
			}
			// if new item order last in appropriate group
			
			if (!$img2->store()) {
				JError::raiseError(500, $img2->getError() );
			}
			$img2->checkin();
			
			$query = "INSERT INTO #__bl_assign_photos(photo_id,cat_id,cat_type) VALUES(".$img2->id.",".$row->id.",2)";
		 	$db->setQuery($query);
			$db->query();
		 }
	}

	//-------extra fields-----------//
	if(isset($_POST['extraf']) && count($_POST['extraf'])){
		for($p=0;$p<count($_POST['extraf']);$p++){
			$query = "DELETE FROM #__bl_extra_values WHERE f_id = ".$_POST['extra_id'][$p]." AND uid = ".$row->id;
			$db->setQuery($query);
			$db->query();
			$query = "INSERT INTO #__bl_extra_values(f_id,uid,fvalue) VALUES(".$_POST['extra_id'][$p].",".$row->id.",'".$_POST['extraf'][$p]."')";
			$db->setQuery($query);
			$db->query();
		}
	}
	
	//-------Bonuses points----//
	if(isset($_POST['sids']) && count($_POST['sids'])){
		for($p=0;$p<count($_POST['sids']);$p++){
			$query = "UPDATE #__bl_season_teams SET bonus_point = ".($_POST['bonuses'][$p])." WHERE season_id=".$_POST['sids'][$p]." AND team_id=".$row->id;
			$db->setQuery($query);
			$db->query();
		}
	}

	if(JRequest::getCmd('task') == "team_apply"){
		$mainframe->redirect( 'index.php?option='.$option."&task=team_edit&cid[]=".$row->id);
	}else{
		$mainframe->redirect( 'index.php?option='.$option."&task=team_list");
	}
	
}
function BL_TeamDel($cid, $option){
	$mainframe = JFactory::getApplication();
	$db			=& JFactory::getDBO();
	if(count($cid)){
		$cids = implode(',',$cid);
		$db->setQuery("DELETE FROM #__bl_teams WHERE id IN (".$cids.")");
		$db->query();
	}
	$mainframe->redirect( 'index.php?option='.$option.'&task=team_list');
}
///--------Position------------////
function BL_PosList($option){
	$mainframe = JFactory::getApplication();
	
	$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	
	$db			=& JFactory::getDBO();
	$query = "SELECT COUNT(*) FROM #__bl_positions ORDER BY p_name";
	$db->setQuery($query);
	$total = $db->loadResult();
	
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	
	$query = "SELECT *,p_id as id FROM #__bl_positions ORDER BY p_name";
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
	$rows = $db->loadObjectList();
	
	joomsport_html::bl_PosList($rows, $pageNav, $option);
	
}
function BL_PosEdit($is_id, $option){
  $lists = array();
	$db			=& JFactory::getDBO();
	$row 	= new JTablePos($db);
	$row->load($is_id);
	
	
	joomsport_html::bl_editPos($row, $lists, $option);
}
function BL_PosSave($option){
	$mainframe = JFactory::getApplication();
	
	$db			=& JFactory::getDBO();
	
	$post		= JRequest::get( 'post' );
	
	$row 	= new JTablePos($db);
	if (!$row->bind( $post )) {
		JError::raiseError(500, $row->getError() );
	}
	if (!$row->check()) {
		JError::raiseError(500, $row->getError() );
	}
	// if new item order last in appropriate group
	
	if (!$row->store()) {
		JError::raiseError(500, $row->getError() );
	}
	$row->checkin();
	
	$mainframe->redirect( 'index.php?option='.$option."&task=pos_list");
}
function BL_PosDel($cid, $option){
	$mainframe = JFactory::getApplication();
	$db			=& JFactory::getDBO();
	if(count($cid)){
		$cids = implode(',',$cid);
		$db->setQuery("DELETE FROM #__bl_positions WHERE p_id IN (".$cids.")");
		$db->query();
	}
	$mainframe->redirect( 'index.php?option='.$option.'&task=pos_list');
}
///--------Player------------////
function BL_PlayerList($option){
	$mainframe = JFactory::getApplication();
	
	$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	$f_team		= $mainframe->getUserStateFromRequest( $option.'.filter_team', 'f_team', 0, 'int' );
	$f_pos		= $mainframe->getUserStateFromRequest( $option.'.filter_pos', 'f_pos', 0, 'int' );
	
	$db			=& JFactory::getDBO();
	$query = "SELECT COUNT(*) FROM #__bl_players as p LEFT JOIN #__bl_positions as bp ON bp.p_id=p.position_id, #__bl_teams as t WHERE p.team_id = t.id ".($f_team?" AND t.id =".$f_team:"").($f_pos?" AND bp.p_id =".$f_pos:"")." ";
	$db->setQuery($query);
	$total = $db->loadResult();
	
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	
	$query = "SELECT p.*,t.t_name,bp.p_name FROM #__bl_players as p LEFT JOIN #__bl_positions as bp ON bp.p_id=p.position_id, #__bl_teams as t WHERE p.team_id = t.id ".($f_team?" AND t.id =".$f_team:"").($f_pos?" AND bp.p_id =".$f_pos:"")."  ORDER BY p.first_name,p.last_name";
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
	$rows = $db->loadObjectList();
	
	$javascript = 'onchange = "document.adminForm.submit();"';
		
	$pos = array();
	$query = "SELECT * FROM #__bl_positions ORDER BY p_name";
	$db->setQuery($query);
	$tourn = $db->loadObjectList();
	$pos[] = JHTML::_('select.option',  0, JText::_('BLBE_SELPOSITION'), 'p_id', 'p_name' ); 
	$positions = array_merge($pos,$tourn);
	$lists['pos'] = JHTML::_('select.genericlist',   $positions, 'f_pos', 'class="inputbox" size="1"'.$javascript, 'p_id', 'p_name', $f_pos );
	
	$is_team = array();
	$query = "SELECT t.id as id,t.t_name FROM #__bl_teams as t ORDER BY t.t_name";
	$db->setQuery($query);
	$team = $db->loadObjectList();
	$is_team[] = JHTML::_('select.option',  0, JText::_('BLBE_SELTEAM'), 'id', 't_name' ); 
	$teamis = array_merge($is_team,$team);
	$lists['teams1'] = JHTML::_('select.genericlist',   $teamis, 'f_team', 'class="inputbox" size="1"'.$javascript, 'id', 't_name', $f_team);
	
	
	joomsport_html::bl_PlayerList($rows, $pageNav, $lists, $option);
	
}
function BL_PlayerEdit($is_id, $option){
	$db			=& JFactory::getDBO();
	$row 	= new JTablePlayer($db);
	$row->load($is_id);
	
	$pos = array();
	$query = "SELECT * FROM #__bl_positions ORDER BY p_name";
	$db->setQuery($query);
	$tourn = $db->loadObjectList();
	$pos[] = JHTML::_('select.option',  0, JText::_('BLBE_SELPOSITION'), 'p_id', 'p_name' ); 
	$positions = array_merge($pos,$tourn);
	$lists['pos'] = JHTML::_('select.genericlist',   $positions, 'position_id', 'class="inputbox" size="1"', 'p_id', 'p_name', $row->position_id );
	
	
	$query = "SELECT * FROM #__bl_teams ORDER BY t_name";
	$db->setQuery($query);
	$teams = $db->loadObjectList();
	
	$lists['teams'] = JHTML::_('select.genericlist',   $teams, 'team_id', 'class="inputbox" size="1"', 'id', 't_name', $row->team_id );
	
	$query = "SELECT p.ph_name as name,p.id as id,p.ph_filename as filename FROM #__bl_assign_photos as ap, #__bl_photos as p WHERE ap.photo_id = p.id AND cat_type = 1 AND cat_id = ".$row->id."";
	$db->setQuery($query);
	$lists['photos'] = $db->loadObjectList();
	
	$query = "SELECT ef.*,ev.fvalue as fvalue FROM #__bl_extra_filds as ef LEFT JOIN #__bl_extra_values as ev ON ef.id=ev.f_id AND ev.uid=".$row->id." WHERE ef.published=1 AND ef.type='0' ORDER BY ef.ordering";
	$db->setQuery($query);
	$lists['ext_fields'] = $db->loadObjectList();
	joomsport_html::bl_editPlayer($row, $lists, $option);
}
function BL_PlayerSave($option){
	$mainframe = JFactory::getApplication();
	
	$db			=& JFactory::getDBO();
	
	$post		= JRequest::get( 'post' );
	$post['about'] = JRequest::getVar( 'about', '', 'post', 'string', JREQUEST_ALLOWRAW );
	$post['def_img'] = JRequest::getVar( 'ph_default', 0, 'post', 'int' ); 
	$row 	= new JTablePlayer($db);
	if (!$row->bind( $post )) {
		JError::raiseError(500, $row->getError() );
	}
	if (!$row->check()) {
		JError::raiseError(500, $row->getError() );
	}
	// if new item order last in appropriate group
	
	if (!$row->store()) {
		JError::raiseError(500, $row->getError() );
	}
	$row->checkin();
	
	$query = "DELETE FROM #__bl_assign_photos WHERE cat_type = 1 AND cat_id = ".$row->id;
	$db->setQuery($query);
	$db->query();
	if(isset($_POST['photos_id']) && count($_POST['photos_id'])){
		for($i = 0; $i < count($_POST['photos_id']); $i++){
			$photo_id = intval($_POST['photos_id'][$i]);
			$photo_name = addslashes(strval($_POST['ph_names'][$i]));
			$query = "INSERT INTO #__bl_assign_photos(photo_id,cat_id,cat_type) VALUES(".$photo_id.",".$row->id.",1)";
		 	$db->setQuery($query);
			$db->query();
			
			$query = "UPDATE #__bl_photos SET ph_name = '".($photo_name)."' WHERE id = ".$photo_id;
			$db->setQuery($query);
			$db->query();
		}
	}
	if(isset($_FILES['player_photo_1']['name']) && $_FILES['player_photo_1']['tmp_name'] != '' && isset($_FILES['player_photo_1']['tmp_name'])){
		$bl_filename = strtolower($_FILES['player_photo_1']['name']);
		$ext = pathinfo($_FILES['player_photo_1']['name']);
		$bl_filename = "bl".time().rand(0,3000).'.'.$ext['extension'];
		$bl_filename = str_replace(" ","",$bl_filename);
		//echo $bl_filename;
		 if(uploadFile($_FILES['player_photo_1']['tmp_name'], $bl_filename)){
		 	$post1['ph_filename'] = $bl_filename;
			
			$img1 = new JTablePhotos($db);
			$img1->id = 0;
			if (!$img1->bind( $post1 )) {
				JError::raiseError(500, $img1->getError() );
			}
			if (!$img1->check()) {
				JError::raiseError(500, $img1->getError() );
			}
			// if new item order last in appropriate group
			
			if (!$img1->store()) {
				JError::raiseError(500, $img1->getError() );
			}
			$img1->checkin();
			
			$query = "INSERT INTO #__bl_assign_photos(photo_id,cat_id,cat_type) VALUES(".$img1->id.",".$row->id.",1)";
		 	$db->setQuery($query);
			$db->query();
		 }
	}
	if(isset($_FILES['player_photo_2']['name']) && $_FILES['player_photo_2']['tmp_name'] != ''  && isset($_FILES['player_photo_2']['tmp_name'])){
		 $bl_filename = strtolower($_FILES['player_photo_2']['name']);
		$ext = pathinfo($_FILES['player_photo_2']['name']);
		$bl_filename = "bl".time().rand(0,3000).'.'.$ext['extension'];
		$bl_filename = str_replace(" ","",$bl_filename);
		 if(uploadFile($_FILES['player_photo_2']['tmp_name'], $bl_filename)){
		 	$post2['ph_filename'] = $bl_filename;
			
			$img2 = new JTablePhotos($db);
			$img2->id = 0;
			if (!$img2->bind( $post2 )) {
				JError::raiseError(500, $img2->getError() );
			}
			if (!$img2->check()) {
				JError::raiseError(500, $img2->getError() );
			}
			// if new item order last in appropriate group
			
			if (!$img2->store()) {
				JError::raiseError(500, $img2->getError() );
			}
			$img2->checkin();
			
			$query = "INSERT INTO #__bl_assign_photos(photo_id,cat_id,cat_type) VALUES(".$img2->id.",".$row->id.",1)";
		 	$db->setQuery($query);
			$db->query();
		 }
	}
	//-------extra fields-----------//
	if(isset($_POST['extraf']) && count($_POST['extraf'])){
		for($p=0;$p<count($_POST['extraf']);$p++){
			$query = "DELETE FROM #__bl_extra_values WHERE f_id = ".$_POST['extra_id'][$p]." AND uid = ".$row->id;
			$db->setQuery($query);
			$db->query();
			$query = "INSERT INTO #__bl_extra_values(f_id,uid,fvalue) VALUES(".$_POST['extra_id'][$p].",".$row->id.",'".$_POST['extraf'][$p]."')";
			$db->setQuery($query);
			$db->query();
		}
	}
	
	if(JRequest::getCmd('task') == "player_apply"){
		$mainframe->redirect( 'index.php?option='.$option."&task=player_edit&cid[]=".$row->id);
	}else{
		$mainframe->redirect( 'index.php?option='.$option."&task=player_list");
	}
}
function BL_PlayerDel($cid, $option){
	$mainframe = JFactory::getApplication();
	$db			=& JFactory::getDBO();
	if(count($cid)){
		$cids = implode(',',$cid);
		$db->setQuery("DELETE FROM #__bl_players WHERE id IN (".$cids.")");
		$db->query();
	}
	$mainframe->redirect( 'index.php?option='.$option.'&task=player_list');
}
///--------Match Day------------////
function BL_MdayList($option){
	$mainframe = JFactory::getApplication();
	
	$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	$season_id	= $mainframe->getUserStateFromRequest( $option.'.s_id', 's_id', 0, 'int' );
	
	$db			=& JFactory::getDBO();
	$is_tourn = array();
	$javascript = 'onchange = "document.adminForm.submit();"';
	$query = "SELECT s.s_id as id, CONCAT(t.name,' ',s.s_name) as name FROM #__bl_tournament as t, #__bl_seasons as s WHERE s.t_id = t.id ORDER BY t.name, s.s_name";
	$db->setQuery($query);
	$tourn = $db->loadObjectList();
	$is_tourn[] = JHTML::_('select.option',  0, JText::_('BLBE_SELTOURNAMENT'), 'id', 'name' ); 
	$tourn_is = array_merge($is_tourn,$tourn);
	$lists['tourn'] = JHTML::_('select.genericlist',   $tourn_is, 's_id', 'class="inputbox" size="1" '.$javascript, 'id', 'name', $season_id );
	
	
	$query = "SELECT COUNT(*) FROM #__bl_matchday as m , #__bl_tournament as t LEFT JOIN #__bl_seasons as s ON s.t_id = t.id WHERE m.s_id = s.s_id ".($season_id?" AND s.s_id=".$season_id:"")." ORDER BY m.m_name";
	$db->setQuery($query);
	$total = $db->loadResult();
	
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	
	$query = "SELECT m.*, CONCAT(t.name,' ',s.s_name) as tourn FROM #__bl_matchday as m , #__bl_tournament as t LEFT JOIN #__bl_seasons as s ON s.t_id = t.id WHERE m.s_id = s.s_id ".($season_id?" AND s.s_id=".$season_id:"")." ORDER BY m.m_name";
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
	$rows = $db->loadObjectList();
	
	joomsport_html::bl_MdayList($rows, $pageNav, $lists, $option);
	
}
function BL_MdayEdit($is_id, $option){
$mainframe = JFactory::getApplication();
	$season_id	= $mainframe->getUserStateFromRequest( $option.'.s_id', 's_id', 0, 'int' );
	
	$db			=& JFactory::getDBO();
	$row 	= new JTableMday($db);
	$row->load($is_id);
	
	$lists = array();	
	
	$query = "SELECT s.s_id as id, CONCAT(t.name,' ',s.s_name) as name FROM #__bl_tournament as t, #__bl_seasons as s WHERE s.s_id = ".($row->s_id?$row->s_id:$season_id)." AND s.t_id = t.id ORDER BY t.name, s.s_name";
	$db->setQuery($query);
	$tourn = $db->loadObjectList();
	//$lists['tourn'] = JHTML::_('select.genericlist',   $tourn, 's_id', 'class="inputbox" size="1"', 'id', 'name', $row->s_id?$row->s_id:$season_id );
	$lists['tourn'] = $tourn[0]->name;
	
	$query = "SELECT m.*,t.t_name as home_team, t2.t_name as away_team FROM #__bl_match as m, #__bl_teams as t, #__bl_teams as t2  WHERE m.m_id = ".$row->id." AND t.id = m.team1_id AND t2.id = m.team2_id  ORDER BY m.id";
	$db->setQuery($query);
	$match = $db->loadObjectList();
	
	$is_team = array();
	$query = "SELECT * FROM #__bl_teams as t , #__bl_season_teams as st WHERE st.team_id = t.id AND st.season_id = ".($row->s_id?$row->s_id:$season_id)." ORDER BY t.t_name";
	$db->setQuery($query);
	$team = $db->loadObjectList();
	$is_team[] = JHTML::_('select.option',  0, JText::_('BLBE_SELTEAM'), 'id', 't_name' ); 
	$teamis = array_merge($is_team,$team);
	$lists['teams1'] = JHTML::_('select.genericlist',   $teamis, 'teams1', 'class="inputbox" size="1" id="teams1"', 'id', 't_name', 0 );
	$lists['teams2'] = JHTML::_('select.genericlist',   $teamis, 'teams2', 'class="inputbox" size="1" id="teams2"', 'id', 't_name', 0 );
	
	$lists['is_playoff'] 		= JHTML::_('select.booleanlist',  'is_playoff', 'class="inputbox"', $row->is_playoff );
	
	$s_id = $row->s_id?$row->s_id:$season_id;
	
	
	joomsport_html::bl_editMday($row, $lists, $match, $s_id, $option);
}
function BL_MdaySave($option){
	$mainframe = JFactory::getApplication();
	
	$db			=& JFactory::getDBO();
	
	$post		= JRequest::get( 'post' );
	$post['m_descr'] = JRequest::getVar( 'm_descr', '', 'post', 'string', JREQUEST_ALLOWRAW );
	$row 	= new JTableMday($db);
	if (!$row->bind( $post )) {
		JError::raiseError(500, $row->getError() );
	}
	if (!$row->check()) {
		JError::raiseError(500, $row->getError() );
	}
	// if new item order last in appropriate group
	
	if (!$row->store()) {
		JError::raiseError(500, $row->getError() );
	}
	$row->checkin();
	
	// save match
	$mj = 0;
	$arr_match = array();
	if(isset($_POST['home_team']) && count($_POST['home_team'])){
		foreach($_POST['home_team'] as $home_team){
			$match 	= new JTableMatch($db);
			$match->load($_POST['match_id'][$mj]);
			$match->m_id = $row->id;
			$match->team1_id = intval($home_team);
			$match->team2_id = intval($_POST['away_team'][$mj]);
			$match->score1 = intval($_POST['home_score'][$mj]);
			$match->score2 = intval($_POST['away_score'][$mj]);
			$match->is_extra = intval($_POST['extra_time'][$mj]);
			$match->published = 1;
			$match->m_played = intval($_POST['match_played'][$mj]);
			
			$match->m_date = strval($_POST['match_data'][$mj]);
			$match->m_time = strval($_POST['match_time'][$mj]);
			
			if (!$match->check()) {
				JError::raiseError(500, $match->getError() );
			}
			
			if (!$match->store()) {
				JError::raiseError(500, $match->getError() );
			}
			$match->checkin();
			$arr_match[] = $match->id;
			$mj++;
		}
		
		$db->setQuery("DELETE FROM #__bl_match WHERE id NOT IN (".implode(',',$arr_match).") AND m_id = ".$row->id);
		$db->query();
	}else{
		$db->setQuery("DELETE FROM #__bl_match WHERE m_id = ".$row->id);
		$db->query();
	}
	
	
	if(JRequest::getCmd('task') == "matchday_apply"){
		$mainframe->redirect( 'index.php?option='.$option."&task=matchday_edit&cid[]=".$row->id);
	}else{
		$mainframe->redirect( 'index.php?option='.$option."&task=matchday_list");
	}
	
	
}
function BL_MdayDel($cid, $option){
	$mainframe = JFactory::getApplication();
	$db			=& JFactory::getDBO();
	if(count($cid)){
		$cids = implode(',',$cid);
		$db->setQuery("DELETE FROM #__bl_matchday WHERE id IN (".$cids.")");
		$db->query();
	}
	$mainframe->redirect( 'index.php?option='.$option.'&task=matchday_list');
}
///--------Match------------////
function BL_MatchList($option){
	$mainframe = JFactory::getApplication();
	
	$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	
	$db			=& JFactory::getDBO();
	$query = "SELECT COUNT(*) FROM #__bl_matchday as md , #__bl_match as m WHERE m.m_id = md.id";
	$db->setQuery($query);
	$total = $db->loadResult();
	
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	
	$query = "SELECT * FROM #__bl_matchday as md , #__bl_match as m WHERE m.m_id = md.id ORDER BY m.m_id";
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
	$rows = $db->loadObjectList();
	
	joomsport_html::bl_MatchList($rows, $pageNav, $option);
	
}
function BL_MatchEdit($is_id, $option){
	$db			=& JFactory::getDBO();
	$row 	= new JTableMatch($db);
	$row->load($is_id);
	
	$lists = array();	
	
	/*$is_team = array();
	$query = "SELECT t.id as id,t.t_name FROM #__bl_teams as t , #__bl_season_teams as st, #__bl_matchday as md WHERE st.team_id = t.id AND st.season_id = md.s_id AND md.id = ".$row->m_id." ORDER BY t.t_name";
	$db->setQuery($query);
	$team = $db->loadObjectList();
	$is_team[] = JHTML::_('select.option',  0, JText::_('BLBE_SELTEAM'), 'id', 't_name' ); 
	$teamis = array_merge($is_team,$team);
	
	$query = "SELECT t.t_name FROM #__bl_teams as t , #__bl_season_teams as st, #__bl_matchday as md WHERE st.team_id = t.id AND st.season_id = md.s_id AND md.id = ".$row->m_id." AND t.id=".$row->team1_id;
	$db->setQuery($query);
	$team_home = $db->loadResult();
	$query = "SELECT t.t_name FROM #__bl_teams as t , #__bl_season_teams as st, #__bl_matchday as md WHERE st.team_id = t.id AND st.season_id = md.s_id AND md.id = ".$row->m_id." AND t.id=".$row->team2_id;
	$db->setQuery($query);
	$team_away = $db->loadResult();
	
	$lists['teams1'] = $team_home;//JHTML::_('select.genericlist',   $teamis, 'team1_id', 'class="inputbox" size="1" id="team1_id"', 'id', 't_name', $row->team1_id);
	$lists['teams2'] = $team_away;//JHTML::_('select.genericlist',   $teamis, 'team2_id', 'class="inputbox" size="1" id="team2_id"', 'id', 't_name', $row->team2_id );
	*/
	$query = "SELECT s_id FROM #__bl_matchday  WHERE id = ".$row->m_id;
	$db->setQuery($query);
	$season_id = $db->loadResult();
	
	$is_matchday = array();
	$query = "SELECT * FROM #__bl_matchday  WHERE s_id = ".$season_id." ORDER BY m_name";
	$db->setQuery($query);
	$mday = $db->loadObjectList();
	$is_matchday[] = JHTML::_('select.option',  0, JText::_('BLBE_SELMD'), 'id', 'm_name' ); 
	$mdayis = array_merge($is_matchday,$mday);
	$lists['mday'] = JHTML::_('select.genericlist',   $mdayis, 'm_id', 'class="inputbox" size="1"', 'id', 'm_name', $row->m_id);
	
	$is_event = array();
	$query = "SELECT * FROM #__bl_events WHERE player_event = '1' ORDER BY e_name";
	$db->setQuery($query);
	$events = $db->loadObjectList();
	$is_event[] = JHTML::_('select.option',  0, JText::_('BLBE_SELEVENT'), 'id', 'e_name' ); 
	$ev_pl = array_merge($is_event,$events);
	$lists['events'] = JHTML::_('select.genericlist',   $ev_pl, 'event_id', 'class="inputbox" size="1"', 'id', 'e_name', 0);
	
	$is_event = array();
	$query = "SELECT * FROM #__bl_events WHERE player_event = '0' ORDER BY e_name";
	$db->setQuery($query);
	$events = $db->loadObjectList();
	$is_event[] = JHTML::_('select.option',  0, JText::_('BLBE_SELEVENT'), 'id', 'e_name' ); 

	$ev_pl = array_merge($is_event,$events);
	$lists['team_events'] = JHTML::_('select.genericlist',   $ev_pl, 'tevent_id', 'class="inputbox" size="1"', 'id', 'e_name', 0);
	$query = "SELECT t_name FROM #__bl_teams WHERE id= ".$row->team1_id;
	$db->setQuery($query);
	$team_1 = $db->loadResult();
	$query = "SELECT t_name FROM #__bl_teams WHERE id= ".$row->team2_id;
	$db->setQuery($query);
	$team_2 = $db->loadResult();
	
	$lists['teams1'] = $team_1;
	$lists['teams2'] = $team_2;
	
	$is_player = array();
	$query = "SELECT id,CONCAT(first_name,' ',last_name) as p_name FROM #__bl_players WHERE team_id = ".$row->team1_id." ORDER BY first_name,last_name";
	$db->setQuery($query) ;
	$players_1 = $db->loadObjectList();
	$query = "SELECT id,CONCAT(first_name,' ',last_name) as p_name FROM #__bl_players WHERE team_id = ".$row->team2_id." ORDER BY first_name,last_name";
	$db->setQuery($query) ;
	$players_2 = $db->loadObjectList();
	$is_player[] = JHTML::_('select.option',  0, JText::_('BLBE_SELPLAYER'), 'id', 'p_name' ); 
	$is_player[] = JHTML::_('select.optgroup',  $team_1, 'id', 'p_name' ); 
	$is_player2[] = JHTML::_('select.optgroup',  $team_2, 'id', 'p_name' ); 
	//$is2_player[] = '</optgroup>';$lists['players']
	//$ev_pl = array_merge($is_player,$players_1,$is_player2,$players_2);
	$jqre = '<select name="playerz_id" id="playerz_id" class="inputbox" size="1">';
		$jqre .= '<option value="">'.JText::_('BLBE_SELPLAYER').'</option>';
		$jqre .= '<optgroup label="'.$team_1.'">';
		for($g=0;$g<count($players_1);$g++){
			$jqre .= '<option value="'.$players_1[$g]->id.'">'.$players_1[$g]->p_name.'</option>';
		}
		$jqre .= '</optgroup>';
		$jqre .= '<optgroup label="'.$team_2.'">';
		for($g=0;$g<count($players_2);$g++){
			$jqre .= '<option value="'.$players_2[$g]->id.'">'.$players_2[$g]->p_name.'</option>';
		}
		$jqre .= '</optgroup>';
		$jqre .= '</select>';
		
		$lists['players'] = $jqre;
	//$lists['players'] = JHTML::_('select.genericlist',   $ev_pl, 'playerz_id', 'class="inputbox" size="1"', 'id', 'p_name', 0);
	
	$is_player_sq[] = JHTML::_('select.option',  0, JText::_('BLBE_SELPLAYER'), 'id', 'p_name' ); 
	$ev_pl = array_merge($is_player_sq,$players_1);
	$lists['players_team1'] = JHTML::_('select.genericlist',   $ev_pl, 'playersq1_id', 'class="inputbox" size="1"', 'id', 'p_name', 0);
	$lists['players_team1_res'] = JHTML::_('select.genericlist',   $ev_pl, 'playersq1_id_res', 'class="inputbox" size="1"', 'id', 'p_name', 0);
	$ev_pl = array_merge($is_player_sq,$players_2);
	$lists['players_team2'] = JHTML::_('select.genericlist',   $ev_pl, 'playersq2_id', 'class="inputbox" size="1"', 'id', 'p_name', 0);
	$lists['players_team2_res'] = JHTML::_('select.genericlist',   $ev_pl, 'playersq2_id_res', 'class="inputbox" size="1"', 'id', 'p_name', 0);
	
	$is_team[] = JHTML::_('select.option',  0, JText::_('BLBE_SELTEAM'), 'id', 'p_name' ); 
	$is_team[] = JHTML::_('select.option', $row->team1_id, $team_1, 'id', 'p_name' ); 
	$is_team[] = JHTML::_('select.option', $row->team2_id, $team_2, 'id', 'p_name' ); 
	//$is2_player[] = '</optgroup>';$lists['players']
	$lists['sel_team'] = JHTML::_('select.genericlist',   $is_team, 'teamz_id', 'class="inputbox" size="1"', 'id', 'p_name', 0);
	
	$lists['extra'] 		= JHTML::_('select.booleanlist',  'is_extra', 'class="inputbox"', $row->is_extra );
	$lists['m_played'] 		= JHTML::_('select.booleanlist',  'm_played', 'class="inputbox"', $row->m_played );
	
	$query = "SELECT me.*,ev.e_name,CONCAT(p.first_name,' ',p.last_name) as p_name FROM  #__bl_events as ev , #__bl_players as p, #__bl_match_events as me WHERE me.player_id = p.id AND ev.player_event = '1' AND  me.e_id = ev.id AND me.match_id = ".$row->id." ORDER BY CAST(me.minutes AS UNSIGNED),p.first_name,p.last_name";
	$db->setQuery($query);
	//echo mysql_error();die();
	$lists['m_events'] = $db->loadObjectList();
	
	$query = "SELECT me.*,ev.e_name,p.t_name as p_name,p.id as pid FROM  #__bl_events as ev, #__bl_teams as p , #__bl_match_events as me WHERE me.t_id = p.id AND ev.player_event = '0' AND  me.e_id = ev.id AND me.match_id = ".$row->id." ORDER BY p.t_name";
	$db->setQuery($query);
	//echo mysql_error();die();
	$lists['t_events'] = $db->loadObjectList();
	
	$query = "SELECT p.ph_name as name,p.id as id,p.ph_filename as filename FROM #__bl_assign_photos as ap, #__bl_photos as p WHERE ap.photo_id = p.id AND cat_type = 3 AND cat_id = ".$row->id."";
	$db->setQuery($query);
	$lists['photos'] = $db->loadObjectList();
	
	$query = "SELECT ef.*,ev.fvalue as fvalue FROM #__bl_extra_filds as ef LEFT JOIN #__bl_extra_values as ev ON ef.id=ev.f_id AND ev.uid=".$row->id." WHERE ef.published=1 AND ef.type='2' ORDER BY ef.ordering";
	$db->setQuery($query);
	$lists['ext_fields'] = $db->loadObjectList();
	
	//----squard----//
	$query = "SELECT p.id,CONCAT(p.first_name,' ',p.last_name) as name FROM #__bl_players as p, #__bl_squard as s WHERE p.id=s.player_id AND s.match_id=".$row->id." AND s.team_id={$row->team1_id} AND s.mainsquard = '1'";
	$db->setQuery($query);
	$lists['squard1'] = $db->loadObjectList();
	$query = "SELECT p.id,CONCAT(p.first_name,' ',p.last_name) as name FROM #__bl_players as p, #__bl_squard as s WHERE p.id=s.player_id AND s.match_id=".$row->id." AND s.team_id={$row->team2_id} AND s.mainsquard = '1'";
	$db->setQuery($query);
	$lists['squard2'] = $db->loadObjectList();
	$query = "SELECT p.id,CONCAT(p.first_name,' ',p.last_name) as name FROM #__bl_players as p, #__bl_squard as s WHERE p.id=s.player_id AND s.match_id=".$row->id." AND s.team_id={$row->team1_id} AND s.mainsquard = '0'";
	$db->setQuery($query);
	$lists['squard1_res'] = $db->loadObjectList();
	$query = "SELECT p.id,CONCAT(p.first_name,' ',p.last_name) as name FROM #__bl_players as p, #__bl_squard as s WHERE p.id=s.player_id AND s.match_id=".$row->id." AND s.team_id={$row->team2_id} AND s.mainsquard = '0'";
	$db->setQuery($query);
	$lists['squard2_res'] = $db->loadObjectList();
	
	joomsport_html::bl_editMatch($row, $lists, $option);
}
function BL_MatchSave($option){
	$mainframe = JFactory::getApplication();
	
	$db			=& JFactory::getDBO();
	
	$post		= JRequest::get( 'post' );
	$post['match_descr'] = JRequest::getVar( 'match_descr', '', 'post', 'string', JREQUEST_ALLOWRAW );
	
	$row 	= new JTableMatch($db);
	$row->m_date = JRequest::getVar( 'm_date', '', 'post', 'string', JREQUEST_ALLOWRAW );
	$row->m_time = JRequest::getVar( 'd_time', '', 'post', 'string', JREQUEST_ALLOWRAW );
				
	if (!$row->bind( $post )) {
		JError::raiseError(500, $row->getError() );
	}
	if (!$row->check()) {
		JError::raiseError(500, $row->getError() );
	}
	// if new item order last in appropriate group
	
	if (!$row->store()) {
		JError::raiseError(500, $row->getError() );
	}
	$row->checkin();
	
	/*$query = "DELETE FROM #__bl_match_events WHERE match_id = ".$row->id;
	$db->setQuery($query);
	$db->query();
	*/
	$me_arr = array();
	
	if(isset($_POST['new_eventid']) && count($_POST['new_eventid'])){
		for ($i=0; $i< count($_POST['new_eventid']); $i++){
			if(!intval($_POST['em_id'][$i])){
	
				$new_event = $_POST['new_eventid'][$i];
				
				
				$query = "SELECT team_id FROM #__bl_players WHERE id=".intval($_POST['new_player'][$i]);
				$db->setQuery($query);
				$teamid = $db->loadResult();
				
	
				$query = "INSERT INTO #__bl_match_events(e_id,player_id,match_id,ecount,minutes,t_id) VALUES(".$new_event.",".$_POST['new_player'][$i].",".$row->id.",".intval($_POST['e_countval'][$i]).",".intval($_POST['e_minuteval'][$i]).",".intval($teamid).")";
				$db->setQuery($query);
				$db->query();
				
				$me_arr[] = $db->insertid();
			}else{
				$query = "SELECT * FROM #__bl_match_events WHERE id=".intval($_POST['em_id'][$i]);
				$db->setQuery($query);
				$event_bl = $db->loadObjectList();
				
				if(count($event_bl)){
					$query = "UPDATE #__bl_match_events SET minutes=".intval($_POST['e_minuteval'][$i]).",ecount=".intval($_POST['e_countval'][$i])." WHERE id=".intval($_POST['em_id'][$i]);
					$db->setQuery($query);
					$db->query();
					
					$me_arr[] = intval($_POST['em_id'][$i]);
				}
			}
		}
		$query = "DELETE FROM #__bl_match_events WHERE match_id = ".$row->id." AND id NOT IN (".implode(',',$me_arr).")";
		$db->setQuery($query);
		$db->query();
		
	
	}
$query = "DELETE me.* FROM #__bl_match_events as me,#__bl_events as e WHERE me.match_id = ".$row->id." AND me.e_id=e.id AND player_event=0";
		$db->setQuery($query);
		$db->query();
	if(isset($_POST['new_teventid']) && count($_POST['new_teventid'])){
		for ($i=0; $i< count($_POST['new_teventid']); $i++){
			$new_event = $_POST['new_teventid'][$i];
			$query = "INSERT INTO #__bl_match_events(e_id,t_id,match_id,ecount,minutes) VALUES(".$new_event.",".$_POST['new_tplayer'][$i].",".$row->id.",".intval($_POST['et_countval'][$i]).",'0')";
			$db->setQuery($query);
			$db->query();
		}
	}
	
		$query = "DELETE FROM #__bl_assign_photos WHERE cat_type = 3 AND cat_id = ".$row->id;
	$db->setQuery($query);
	$db->query();
	if(isset($_POST['photos_id']) && count($_POST['photos_id'])){
		for($i = 0; $i < count($_POST['photos_id']); $i++){
			$photo_id = intval($_POST['photos_id'][$i]);
			$photo_name = addslashes(strval($_POST['ph_names'][$i]));
			$query = "INSERT INTO #__bl_assign_photos(photo_id,cat_id,cat_type) VALUES(".$photo_id.",".$row->id.",3)";
		 	$db->setQuery($query);
			$db->query();
			
			$query = "UPDATE #__bl_photos SET ph_name = '".($photo_name)."' WHERE id = ".$photo_id;
			$db->setQuery($query);
			$db->query();
		}
	}
	if(isset($_FILES['player_photo_1']['name']) && $_FILES['player_photo_1']['tmp_name'] != '' && isset($_FILES['player_photo_1']['tmp_name'])){
		$bl_filename = strtolower($_FILES['player_photo_1']['name']);
		$ext = pathinfo($_FILES['player_photo_1']['name']);
		$bl_filename = "bl".time().rand(0,3000).'.'.$ext['extension'];
		$bl_filename = str_replace(" ","",$bl_filename);
		//echo $bl_filename;
		 if(uploadFile($_FILES['player_photo_1']['tmp_name'], $bl_filename)){
		 	$post1['ph_filename'] = $bl_filename;
			
			$img1 = new JTablePhotos($db);
			$img1->id = 0;
			if (!$img1->bind( $post1 )) {
				JError::raiseError(500, $img1->getError() );
			}
			if (!$img1->check()) {
				JError::raiseError(500, $img1->getError() );
			}
			// if new item order last in appropriate group
			
			if (!$img1->store()) {
				JError::raiseError(500, $img1->getError() );
			}
			$img1->checkin();
			
			$query = "INSERT INTO #__bl_assign_photos(photo_id,cat_id,cat_type) VALUES(".$img1->id.",".$row->id.",3)";
		 	$db->setQuery($query);
			$db->query();
		 }
	}
	if(isset($_FILES['player_photo_2']['name']) && $_FILES['player_photo_2']['tmp_name'] != ''  && isset($_FILES['player_photo_2']['tmp_name'])){
		 $bl_filename = strtolower($_FILES['player_photo_2']['name']);
		$ext = pathinfo($_FILES['player_photo_2']['name']);
		$bl_filename = "bl".time().rand(0,3000).'.'.$ext['extension'];
		$bl_filename = str_replace(" ","",$bl_filename);
		 if(uploadFile($_FILES['player_photo_2']['tmp_name'], $bl_filename)){
		 	$post2['ph_filename'] = $bl_filename;
			
			$img2 = new JTablePhotos($db);
			$img2->id = 0;
			if (!$img2->bind( $post2 )) {
				JError::raiseError(500, $img2->getError() );
			}
			if (!$img2->check()) {
				JError::raiseError(500, $img2->getError() );
			}
			// if new item order last in appropriate group
			
			if (!$img2->store()) {
				JError::raiseError(500, $img2->getError() );
			}
			$img2->checkin();
			
			$query = "INSERT INTO #__bl_assign_photos(photo_id,cat_id,cat_type) VALUES(".$img2->id.",".$row->id.",3)";
		 	$db->setQuery($query);
			$db->query();
		 }
	}
	
	//-------extra fields-----------//
	if(isset($_POST['extraf']) && count($_POST['extraf'])){
		for($p=0;$p<count($_POST['extraf']);$p++){
			$query = "DELETE FROM #__bl_extra_values WHERE f_id = ".$_POST['extra_id'][$p]." AND uid = ".$row->id;
			$db->setQuery($query);
			$db->query();
			$query = "INSERT INTO #__bl_extra_values(f_id,uid,fvalue) VALUES(".$_POST['extra_id'][$p].",".$row->id.",'".$_POST['extraf'][$p]."')";
			$db->setQuery($query);
			$db->query();
		}
	}
	//-----SQUARD--------///
	$query = "DELETE FROM #__bl_squard WHERE match_id = ".$row->id;
		$db->setQuery($query);
		$db->query();
	if(isset($_POST['t1_squard']) && count($_POST['t1_squard'])){
		for ($i=0; $i< count($_POST['t1_squard']); $i++){
			$new_event = $_POST['t1_squard'][$i];
			$query = "INSERT INTO #__bl_squard(match_id,team_id,player_id,mainsquard) VALUES(".$row->id.",".$row->team1_id.",".$new_event.",'1')";
			$db->setQuery($query);
			$db->query();
		}
	}
	
	if(isset($_POST['t2_squard']) && count($_POST['t2_squard'])){
		for ($i=0; $i< count($_POST['t2_squard']); $i++){
			$new_event = $_POST['t2_squard'][$i];
			$query = "INSERT INTO #__bl_squard(match_id,team_id,player_id,mainsquard) VALUES(".$row->id.",".$row->team2_id.",".$new_event.",'1')";
			$db->setQuery($query);
			$db->query();
		}
	}
	if(isset($_POST['t1_squard_res']) && count($_POST['t1_squard_res'])){
		for ($i=0; $i< count($_POST['t1_squard_res']); $i++){
			$new_event = $_POST['t1_squard_res'][$i];
			$query = "INSERT INTO #__bl_squard(match_id,team_id,player_id,mainsquard) VALUES(".$row->id.",".$row->team1_id.",".$new_event.",'0')";
			$db->setQuery($query);
			$db->query();
		}
	}
	if(isset($_POST['t2_squard_res']) && count($_POST['t2_squard_res'])){
		for ($i=0; $i< count($_POST['t2_squard_res']); $i++){
			$new_event = $_POST['t2_squard_res'][$i];
			$query = "INSERT INTO #__bl_squard(match_id,team_id,player_id,mainsquard) VALUES(".$row->id.",".$row->team2_id.",".$new_event.",'0')";
			$db->setQuery($query);
			$db->query();
		}
	}
	
	if(JRequest::getCmd('task') == 'match_apply'){
		$mainframe->redirect( 'index.php?option='.$option."&task=match_edit&cid=".$row->id);
	}else{
		$mainframe->redirect( 'index.php?option='.$option."&task=matchday_edit&cid=".$row->m_id);
	}
	
}
function BL_MatchDel($cid, $option){
	$mainframe = JFactory::getApplication();
	$db			=& JFactory::getDBO();
	if(count($cid)){
		$cids = implode(',',$cid);
		$db->setQuery("DELETE FROM #__bl_match WHERE id IN (".$cids.")");
		$db->query();
	}
	$mainframe->redirect( 'index.php?option='.$option.'&task=match_list');
}
///--------Events------------////
function BL_EventList($option){
	$mainframe = JFactory::getApplication();
	
	$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	
	$db			=& JFactory::getDBO();
	$query = "SELECT COUNT(*) FROM #__bl_events";
	$db->setQuery($query);
	$total = $db->loadResult();
	
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	
	$query = "SELECT * FROM #__bl_events ORDER BY e_name";
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
	$rows = $db->loadObjectList();
	
	joomsport_html::bl_EventList($rows, $pageNav, $option);
	
}
function BL_EventEdit($is_id, $option){
	$db			=& JFactory::getDBO();
	$row 	= new JTableEvents($db);
	$row->load($is_id);
	
	$lists = array();	
	
	$javascript = 'onChange = "View_eventimg();"';
	
	$lists['image'] = JHTML::_('list.images',  'e_img', $row->e_img,$javascript,'media/bearleague/events' );
	
	$lists['player_event'] 		= JHTML::_('select.booleanlist',  'player_event', 'class="inputbox"', $row->player_event );
	
	
	
	joomsport_html::bl_editEvent($row, $lists, $option);
}
function BL_EventSave($option){
	$mainframe = JFactory::getApplication();
	
	$db			=& JFactory::getDBO();
	
	$post		= JRequest::get( 'post' );
	$post['e_descr'] = JRequest::getVar( 'e_descr', '', 'post', 'string', JREQUEST_ALLOWRAW );
	$row 	= new JTableEvents($db);
	if(isset($_FILES['new_event_img']['name']) && $_FILES['new_event_img']['tmp_name'] != '' && isset($_FILES['new_event_img']['tmp_name'])){
		$ext = pathinfo($_FILES['new_event_img']['name']);
		$bl_filename = "bl".time().rand(0,3000).'.'.$ext['extension'];
		$bl_filename = str_replace(" ","",$bl_filename);
		//echo $bl_filename;
		$baseDir =  JPATH_ROOT . '/media/bearleague/events/' ;
		 if(uploadFile($_FILES['new_event_img']['tmp_name'], $bl_filename, $baseDir)){
		 
			$post['e_img'] = $bl_filename;
		 
		 }
		 	
	}
	
	
	if (!$row->bind( $post )) {
		JError::raiseError(500, $row->getError() );
	}
	if (!$row->check()) {
		JError::raiseError(500, $row->getError() );
	}
	// if new item order last in appropriate group
	
	if (!$row->store()) {
		JError::raiseError(500, $row->getError() );
	}
	$row->checkin();
	if(JRequest::getCmd('task') == "event_apply"){
		$mainframe->redirect( 'index.php?option='.$option."&task=event_edit&cid[]=".$row->id);
	}else{
		$mainframe->redirect( 'index.php?option='.$option."&task=event_list");
	}
	
}
function BL_EventDel($cid, $option){
	$mainframe = JFactory::getApplication();
	$db			=& JFactory::getDBO();
	if(count($cid)){
		$cids = implode(',',$cid);
		$db->setQuery("DELETE FROM #__bl_events WHERE id IN (".$cids.")");
		$db->query();
	}
	$mainframe->redirect( 'index.php?option='.$option.'&task=event_list');
}
///--------Groups------------////
function BL_GroupList($option){
	$mainframe = JFactory::getApplication();
	
	$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	
	$db			=& JFactory::getDBO();
	$query = "SELECT COUNT(*) FROM #__bl_groups";
	$db->setQuery($query);
	$total = $db->loadResult();
	
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	
	$query = "SELECT * FROM #__bl_groups ORDER BY ordering";
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
	$rows = $db->loadObjectList();
	
	joomsport_html::bl_GroupList($rows, $pageNav, $option);
	
}
function BL_GroupEdit($is_id, $option){
	$db			=& JFactory::getDBO();
	$row 	= new JTableGroups($db);
	$row->load($is_id);
	
	$lists = array();	
	
	$is_tourn = array();
	$query = "SELECT s.s_id as id, CONCAT(t.name,' ',s.s_name) as name FROM #__bl_tournament as t, #__bl_seasons as s WHERE s.s_groups = '1' AND s.t_id = t.id ORDER BY t.name, s.s_name";$db->setQuery($query);
	$tourn = $db->loadObjectList();
	$is_tourn[] = JHTML::_('select.option',  0, JText::_('BLBE_SELTOURNAMENT'), 'id', 'name' ); 
	$tourn_is = array_merge($is_tourn,$tourn);
	$lists['tourn'] = JHTML::_('select.genericlist',   $tourn_is, 's_id', 'class="inputbox" size="1"', 'id', 'name', $row->s_id );
	
	if($is_id){
		$query = "SELECT * FROM #__bl_teams as t, #__bl_season_teams as st WHERE st.season_id = ".$row->s_id." AND t.id = st.team_id ORDER BY t.t_name";
		$db->setQuery($query);
		$teams = $db->loadObjectList();
		$lists['teams'] = @JHTML::_('select.genericlist',   $teams, 'teams_id', 'class="inputbox" size="10" multiple', 'id', 't_name', 0 );
		
		$query = "SELECT t.id as id, t.t_name as t_name FROM #__bl_season_teams as st, #__bl_teams as t, #__bl_grteams as gr WHERE gr.t_id = t.id AND gr.g_id = ".$row->id." AND st.season_id = ".$row->s_id." AND t.id = st.team_id ORDER BY t.t_name";
		$db->setQuery($query);
		$teams_season = $db->loadObjectList();
	
		$lists['teams2'] = @JHTML::_('select.genericlist',   $teams_season, 'teams_seasons[]', 'class="inputbox" size="10" multiple', 'id', 't_name', 0 );
	}
	
	joomsport_html::bl_editGroup($row, $lists, $option);
}
function BL_GroupSave($option){
	$mainframe = JFactory::getApplication();
	
	$db			=& JFactory::getDBO();
	
	$post		= JRequest::get( 'post' );
	
	$row 	= new JTableGroups($db);
	
	if (!$row->bind( $post )) {
		JError::raiseError(500, $row->getError() );
	}
	if (!$row->check()) {
		JError::raiseError(500, $row->getError() );
	}
	// if new item order last in appropriate group
	
	if (!$row->store()) {
		JError::raiseError(500, $row->getError() );
	}
	$row->checkin();
	
	$query = "DELETE FROM #__bl_grteams WHERE g_id = ".$row->id;
			$db->setQuery($query);
			$db->query();
	
	$teams_season 		= JRequest::getVar( 'teams_seasons', array(0), '', 'array' );
	
	JArrayHelper::toInteger($teams_season, '');
	if(count($teams_season)){
		foreach($teams_season as $teams){
			$query = "INSERT INTO #__bl_grteams(g_id,t_id) VALUES(".$row->id.",".$teams.")";
			$db->setQuery($query);
			$db->query();
		}
	}
	
	if(JRequest::getCmd('task') == "group_apply"){
		$mainframe->redirect( 'index.php?option='.$option."&task=group_edit&cid[]=".$row->id);
	}else{
		$mainframe->redirect( 'index.php?option='.$option."&task=group_list");
	}
	
}
function BL_GroupDel($cid, $option){
	$mainframe = JFactory::getApplication();
	$db			=& JFactory::getDBO();
	if(count($cid)){
		$cids = implode(',',$cid);
		$db->setQuery("DELETE FROM #__bl_groups WHERE id IN (".$cids.")");
		$db->query();
	}
	$mainframe->redirect( 'index.php?option='.$option.'&task=group_list');
}

function BL_SaveOrderGr($option){
	$mainframe = JFactory::getApplication();
	// Initialize variables
		$db			=& JFactory::getDBO();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order		= JRequest::getVar( 'order', array(), 'post', 'array' );
		
		$row		= new JTableGroups($db);;
		$total		= count( $cid );
		
		if (empty( $cid )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
		// update ordering values
		for ($i = 0; $i < $total; $i++)
		{
			$row->load( (int) $cid[$i] );
			if ($row->ordering != $order[$i])
			{
				$row->ordering = $order[$i];
				if (!$row->store()) {
					return JError::raiseError( 500, $db->getErrorMsg() );
				}
				// remember to reorder this category
				
				
			}
		}
	$link = 'index.php?option='.$option.'&task=group_list';
	
		
	$mainframe->redirect( $link );
}
///--------Fields------------////
function BL_FieldsList($option,$e_type){
	$mainframe = JFactory::getApplication();
	
	$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	$filtr_type	= $mainframe->getUserStateFromRequest( $option.'.filtr_type', 'filtr_type', -1, 'int' );
	
	$db			=& JFactory::getDBO();
	$query = "SELECT COUNT(*) FROM #__bl_extra_filds ".(($filtr_type != -1)?("WHERE type=".$filtr_type):"")." ORDER BY ordering";
	$db->setQuery($query);
	$total = $db->loadResult();
	
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	
	$query = "SELECT * FROM #__bl_extra_filds ".(($filtr_type != -1)?("WHERE type=".$filtr_type):"")." ORDER BY ordering";
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
	$rows = $db->loadObjectList();
	
	$is_field[] = JHTML::_('select.option',  -1, JText::_('BLBE_SELTYPE'), 'id', 't_name' ); 
	$is_field[] = JHTML::_('select.option',  0, JText::_('BLBE_PLAYER'), 'id', 't_name' ); 
	$is_field[] = JHTML::_('select.option',  1, JText::_('BLBE_TEAM'), 'id', 't_name' ); 
	$is_field[] = JHTML::_('select.option',  2, JText::_('BLBE_MATCH'), 'id', 't_name' );
	
	$javascript = " onChange='javascript:document.adminForm.submit();'";
	
	$lists['is_type'] = JHTML::_('select.genericlist',   $is_field, 'filtr_type', 'class="inputbox" size="1"'.$javascript, 'id', 't_name', $filtr_type );
	$lists['f_edit'] = 'fields_edit';
	$lists['f_publ'] = 'fields_publ';
	$lists['f_unpubl'] = 'fields_unpubl';
	
	joomsport_html::bl_FieldsList($rows, $pageNav, $option, $lists);
	
}
function BL_FieldsEdit($is_id, $option, $e_type){
	$mainframe = JFactory::getApplication();
	$db			=& JFactory::getDBO();
	$filtradf = $mainframe->getUserStateFromRequest( $option.'.filtr_type', 'filtr_type', -1, 'int' );
	$row 	= new JTableFields($db);
	$row->load($is_id);
	$is_field[] = JHTML::_('select.option',  0, JText::_('BLBE_PLAYER'), 'id', 't_name' ); 
	$is_field[] = JHTML::_('select.option',  1, JText::_('BLBE_TEAM'), 'id', 't_name' ); 
	$is_field[] = JHTML::_('select.option',  2, JText::_('BLBE_MATCH'), 'id', 't_name' ); 
	$lists['is_type'] = JHTML::_('select.genericlist',   $is_field, 'type', 'class="inputbox" size="1"', 'id', 't_name', $row->type?$row->type:$filtradf );
	
	$published = ($row->id) ? $row->published : 1;
	$lists['published'] 		= JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $published );
	$lists['t_view'] 		= JHTML::_('select.booleanlist',  'e_table_view', 'class="inputbox"', $row->e_table_view );
	joomsport_html::bl_editFields($row, $lists, $option);
}
function BL_FieldsSave($option, $e_type){
	$mainframe = JFactory::getApplication();
	
	$db			=& JFactory::getDBO();
	
	$post		= JRequest::get( 'post' );
	$post['descr'] = JRequest::getVar( 'descr', '', 'post', 'string', JREQUEST_ALLOWRAW );
	$row 	= new JTableFields($db);
	$row->type = $e_type;
	if (!$row->bind( $post )) {
		JError::raiseError(500, $row->getError() );
	}
	if (!$row->check()) {
		JError::raiseError(500, $row->getError() );
	}
	// if new item order last in appropriate group
	
	if (!$row->store()) {
		JError::raiseError(500, $row->getError() );
	}
	$row->checkin();
	
	if(JRequest::getCmd('task') == "fields_apply"){
		$link = 'index.php?option='.$option.'&task=fields_edit&cid[]='.$row->id;
	}else{
		$link = 'index.php?option='.$option.'&task=fields_list';
	}
		
	$mainframe->redirect( $link );
}
function BL_FieldsPubl($cid, $pb, $option, $e_type){
	$mainframe = JFactory::getApplication();
	$db			=& JFactory::getDBO();
	
	if(count($cid)){
		$cids = implode(',',$cid);
		$query = "UPDATE #__bl_extra_filds SET published = ".$pb." WHERE id IN (".$cids.")";
		$db->setQuery($query);
		$db->query();
	}	
	switch ($e_type){
		case 1: $link = 'index.php?option='.$option.'&task=tfields_list';break;
		default: $link = 'index.php?option='.$option.'&task=fields_list';
	}
		
	$mainframe->redirect( $link );
	
}
function BL_FieldsDel($cid, $option, $e_type){
	$mainframe = JFactory::getApplication();
	$db			=& JFactory::getDBO();
	if(count($cid)){
		$cids = implode(',',$cid);
		$db->setQuery("DELETE FROM #__bl_extra_filds WHERE id IN (".$cids.")");
		$db->query();
	}
	switch ($e_type){
		case 1: $link = 'index.php?option='.$option.'&task=tfields_list';break;
		default: $link = 'index.php?option='.$option.'&task=fields_list';
	}
		
	$mainframe->redirect( $link );
}
function BL_SaveOrder($option){
	$mainframe = JFactory::getApplication();
	// Initialize variables
		$db			=& JFactory::getDBO();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order		= JRequest::getVar( 'order', array(), 'post', 'array' );
		$f_type		= JRequest::getVar( 'f_type', 0, 'post', 'int' );
		$row		= new JTableFields($db);;
		$total		= count( $cid );
		
		if (empty( $cid )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
		// update ordering values
		for ($i = 0; $i < $total; $i++)
		{
			$row->load( (int) $cid[$i] );
			if ($row->ordering != $order[$i])
			{
				$row->ordering = $order[$i];
				if (!$row->store()) {
					return JError::raiseError( 500, $db->getErrorMsg() );
				}
				// remember to reorder this category
				
				
			}
		}
	switch ($f_type){
		case 1: $link = 'index.php?option='.$option.'&task=tfields_list';break;
		default: $link = 'index.php?option='.$option.'&task=fields_list';
	}
		
	$mainframe->redirect( $link );
}
 			#######################################
			###	--- ---		LANGUAGES 	--- --- ###
function BL_ViewLanguages( $option ) {
	
	$mainframe = JFactory::getApplication();
	$db			=& JFactory::getDBO();
	$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	$query = "SELECT COUNT(*)"
	. "\n FROM #__bl_languages";
	$db->setQuery( $query );
	$total = $db->loadResult();
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	$query = "SELECT * "
	. "\n FROM #__bl_languages"
	. "\n ORDER BY lang_file"
	. "\n LIMIT $pageNav->limitstart, $pageNav->limit"
	;
	$db->setQuery( $query );
	$rows = $db->loadObjectList();
	joomsport_html::BL_showLanguagesList( $rows, $pageNav, $option);
}
function BL_editLanguage( $id, $option ) {
	$mainframe = JFactory::getApplication();
	$db			=& JFactory::getDBO();
	$GLOBALS['j_toolbar_id'] = $id;
	$row = new JTableLang( $db );
	$row->load( $id );
	require_once ( JPATH_ROOT.'/media/bearleague/languages/default.php' );
	if ($row->id) {
		if ($row->lang_file) {
			if (preg_match("/[0-9a-z]/", $row->lang_file)) {
				require_once ( JPATH_ROOT.'/media/bearleague/languages/'.$row->lang_file.'.php' );
			}
		}
	}
	$lists = array();
	joomsport_html::BL_editLanguage( $row, $lists, $option, $bl_lang );
}
function BL_saveLanguage( $option ) {
	$mainframe = JFactory::getApplication();
	$db			=& JFactory::getDBO();
	$row = new JTableLang( $db );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.location='index.php?option=".$option."&task=languages'; </script>\n";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$lang_filename = $row->lang_file;
	require_once ( JPATH_COMPONENT.DS.'language.joomsport.php' );
	$row_language = new mos_BL_laguange_class();
	$row_language->BL_TBL_RANK = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TBL_RANK'])?($_POST['BL_TBL_RANK']):''):(isset($_POST['BL_TBL_RANK'])?($_POST['BL_TBL_RANK']):'');
	$row_language->BL_TBL_TEAMS = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TBL_TEAMS'])?($_POST['BL_TBL_TEAMS']):''):(isset($_POST['BL_TBL_TEAMS'])?($_POST['BL_TBL_TEAMS']):'');
	$row_language->BL_TBL_PLAYED = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TBL_PLAYED'])?($_POST['BL_TBL_PLAYED']):''):(isset($_POST['BL_TBL_PLAYED'])?($_POST['BL_TBL_PLAYED']):'');
	$row_language->BL_TBL_WINS = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TBL_WINS'])?($_POST['BL_TBL_WINS']):''):(isset($_POST['BL_TBL_WINS'])?($_POST['BL_TBL_WINS']):'');
	$row_language->BL_TBL_DRAW = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TBL_DRAW'])?($_POST['BL_TBL_DRAW']):''):(isset($_POST['BL_TBL_DRAW'])?($_POST['BL_TBL_DRAW']):'');
	$row_language->BL_TBL_LOST = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TBL_LOST'])?($_POST['BL_TBL_LOST']):''):(isset($_POST['BL_TBL_LOST'])?($_POST['BL_TBL_LOST']):'');
	$row_language->BL_TBL_EXTRAWIN = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TBL_EXTRAWIN'])?($_POST['BL_TBL_EXTRAWIN']):''):(isset($_POST['BL_TBL_EXTRAWIN'])?($_POST['BL_TBL_EXTRAWIN']):'');
	$row_language->BL_TBL_EXTRALOST = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TBL_EXTRALOST'])?($_POST['BL_TBL_EXTRALOST']):''):(isset($_POST['BL_TBL_EXTRALOST'])?($_POST['BL_TBL_EXTRALOST']):'');
	$row_language->BL_TBL_DIFF = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TBL_DIFF'])?($_POST['BL_TBL_DIFF']):''):(isset($_POST['BL_TBL_DIFF'])?($_POST['BL_TBL_DIFF']):'');
	$row_language->BL_TBL_GD = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TBL_GD'])?($_POST['BL_TBL_GD']):''):(isset($_POST['BL_TBL_GD'])?($_POST['BL_TBL_GD']):'');
	$row_language->BL_TBL_POINTS = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TBL_POINTS'])?($_POST['BL_TBL_POINTS']):''):(isset($_POST['BL_TBL_POINTS'])?($_POST['BL_TBL_POINTS']):'');
	$row_language->BL_TAB_TEAM = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TAB_TEAM'])?($_POST['BL_TAB_TEAM']):''):(isset($_POST['BL_TAB_TEAM'])?($_POST['BL_TAB_TEAM']):'');
	$row_language->BL_TAB_MATCHES = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TAB_MATCHES'])?($_POST['BL_TAB_MATCHES']):''):(isset($_POST['BL_TAB_MATCHES'])?($_POST['BL_TAB_MATCHES']):'');
	$row_language->BL_TAB_PLAYERS = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TAB_PLAYERS'])?($_POST['BL_TAB_PLAYERS']):''):(isset($_POST['BL_TAB_PLAYERS'])?($_POST['BL_TAB_PLAYERS']):'');
	$row_language->BL_TAB_PHOTOS = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TAB_PHOTOS'])?($_POST['BL_TAB_PHOTOS']):''):(isset($_POST['BL_TAB_PHOTOS'])?($_POST['BL_TAB_PHOTOS']):'');
	$row_language->BL_TAB_PLAYER = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TAB_PLAYER'])?($_POST['BL_TAB_PLAYER']):''):(isset($_POST['BL_TAB_PLAYER'])?($_POST['BL_TAB_PLAYER']):'');
	$row_language->BL_TAB_MATCH = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TAB_MATCH'])?($_POST['BL_TAB_MATCH']):''):(isset($_POST['BL_TAB_MATCH'])?($_POST['BL_TAB_MATCH']):'');
	$row_language->BL_TAB_ABOUT = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TAB_ABOUT'])?($_POST['BL_TAB_ABOUT']):''):(isset($_POST['BL_TAB_ABOUT'])?($_POST['BL_TAB_ABOUT']):'');
	$row_language->BL_LINK_DETAILMATCH = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_LINK_DETAILMATCH'])?($_POST['BL_LINK_DETAILMATCH']):''):(isset($_POST['BL_LINK_DETAILMATCH'])?($_POST['BL_LINK_DETAILMATCH']):'');
	$row_language->BL_TBL_PLAYER = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TBL_PLAYER'])?($_POST['BL_TBL_PLAYER']):''):(isset($_POST['BL_TBL_PLAYER'])?($_POST['BL_TBL_PLAYER']):'');
	$row_language->BL_TBL_POSITION = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TBL_POSITION'])?($_POST['BL_TBL_POSITION']):''):(isset($_POST['BL_TBL_POSITION'])?($_POST['BL_TBL_POSITION']):'');
	$row_language->BL_RES_EXTRA = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_RES_EXTRA'])?($_POST['BL_RES_EXTRA']):''):(isset($_POST['BL_RES_EXTRA'])?($_POST['BL_RES_EXTRA']):'');
	$row_language->BL_CITY = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_CITY'])?($_POST['BL_CITY']):''):(isset($_POST['BL_CITY'])?($_POST['BL_CITY']):'');
	$row_language->BL_NAME = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_NAME'])?($_POST['BL_NAME']):''):(isset($_POST['BL_NAME'])?($_POST['BL_NAME']):'');
	$row_language->BL_POSITION = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_POSITION'])?($_POST['BL_POSITION']):''):(isset($_POST['BL_POSITION'])?($_POST['BL_POSITION']):'');
	$row_language->BL_NICK = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_NICK'])?($_POST['BL_NICK']):''):(isset($_POST['BL_NICK'])?($_POST['BL_NICK']):'');
	$row_language->BL_TBL_STAT = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TBL_STAT'])?($_POST['BL_TBL_STAT']):''):(isset($_POST['BL_TBL_STAT'])?($_POST['BL_TBL_STAT']):'');
	$row_language->BL_BACK = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_BACK'])?($_POST['BL_BACK']):''):(isset($_POST['BL_BACK'])?($_POST['BL_BACK']):'');
	$row_language->BL_CALENDAR = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_CALENDAR'])?($_POST['BL_CALENDAR']):''):(isset($_POST['BL_CALENDAR'])?($_POST['BL_CALENDAR']):'');
	$row_language->BL_TAB_STAT = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TAB_STAT'])?($_POST['BL_TAB_STAT']):''):(isset($_POST['BL_TAB_STAT'])?($_POST['BL_TAB_STAT']):'');
	$row_language->BL_TBL_WINPERCENT = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TBL_WINPERCENT'])?($_POST['BL_TBL_WINPERCENT']):''):(isset($_POST['BL_TBL_WINPERCENT'])?($_POST['BL_TBL_WINPERCENT']):'');
	$row_language->BL_LINEUP = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_LINEUP'])?($_POST['BL_LINEUP']):''):(isset($_POST['BL_LINEUP'])?($_POST['BL_LINEUP']):'');
	$row_language->BL_SUBTITUTES = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_SUBTITUTES'])?($_POST['BL_SUBTITUTES']):''):(isset($_POST['BL_SUBTITUTES'])?($_POST['BL_SUBTITUTES']):'');
	$row_language->BL_TAB_SQUAD = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TAB_SQUAD'])?($_POST['BL_TAB_SQUAD']):''):(isset($_POST['BL_TAB_SQUAD'])?($_POST['BL_TAB_SQUAD']):'');	
	$row_language->BL_TAB_TBL = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TAB_TBL'])?($_POST['BL_TAB_TBL']):''):(isset($_POST['BL_TAB_TBL'])?($_POST['BL_TAB_TBL']):'');
	$row_language->BL_TAB_ABOUTSEAS = get_magic_quotes_gpc() ? stripslashes(isset($_POST['BL_TAB_ABOUTSEAS'])?($_POST['BL_TAB_ABOUTSEAS']):''):(isset($_POST['BL_TAB_ABOUTSEAS'])?($_POST['BL_TAB_ABOUTSEAS']):'');	
	
	$config_lang = "<?php \n";
	$config_lang .= "/** \n";
	$config_lang .= " Beardev\n";
	$config_lang .= "**/\n";
	$config_lang .= "// no direct access\n";
	$config_lang .= "defined( '_JEXEC' ) or die( 'Restricted access' );\n";
	$config_lang .= "\n";
	$config_lang .= $row_language->getVarText();
	$config_lang .= '?>';
	$fname = JPATH_ROOT."/media/bearleague/languages/".$lang_filename.".php";
	if ( $fp = fopen($fname, 'w') ) {
		fputs($fp, $config_lang, strlen($config_lang));
		fclose($fp);
	}
	if (JRequest::getCmd('task') == 'apply_lang') {
		$mainframe->redirect( "index.php?option=$option&task=edit_lang&hidemainmenu=1&cid[]=". $row->id );
	} else {
		$mainframe->redirect( "index.php?option=$option&task=languages" );
	}
}
function BL_removeLanguage( &$cid, $option ) {
	$mainframe = JFactory::getApplication();
	$db			=& JFactory::getDBO();
	if (count( $cid )) {
		$cids = implode( ',', $cid );
		$query = "SELECT lang_file FROM #__bl_languages WHERE id IN ( $cids ) and lang_file <> 'default'";
		$db->setQuery( $query );
		$lang_files = $db->LoadObjectList();
		$query = "DELETE FROM #__bl_languages"
		. "\n WHERE id IN ( $cids ) and lang_file <> 'default'";
		$db->setQuery( $query );
		if (!$db->query()) {
			echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
		}
		if (count($lang_files)) {
			foreach ($lang_files as $lang_file) {
				if (file_exists(JPATH_ROOT."/media/bearleague/languages/".$lang_file->lang_file.".php")) {
					@unlink(JPATH_ROOT."/media/bearleague/languages/".$lang_file->lang_file.".php");
				}
			}
		}
	}
	$mainframe->redirect( "index.php?option=$option&task=languages" );
}
function BL_cancelLanguage($option) {
	$mainframe = JFactory::getApplication();
	$mainframe->redirect("index.php?option=$option&task=languages");
}
function BL_doDefaultLanguage( $id, $option ) {
	$db			=& JFactory::getDBO();
	$mainframe = JFactory::getApplication();
	$query = "UPDATE #__bl_languages SET is_default = 0 WHERE is_default = 1";
	$db->SetQuery( $query );
	$db->query();
	$query = "UPDATE #__bl_languages SET is_default = 1 WHERE id = '".$id."'";
	$db->SetQuery( $query );
	$db->query();
	$mainframe->redirect('index.php?option='. $option .'&task=languages');
} 
///--------------------MENU-----------------------------------///
function BL_Season_Menu($option){
	$db			=& JFactory::getDBO();
	$query = "SELECT s.s_id as id, CONCAT(t.name,' ',s.s_name) as name FROM #__bl_tournament as t, #__bl_seasons as s WHERE s.published = '1' AND t.published = '1' AND s.t_id = t.id AND s.t_id = t.id ORDER BY t.name, s.s_name";
	$db->setQuery($query);
	$row = $db->loadObjectList();
	joomsport_html::bl_SeasonMenu($row, $option);
}
function BL_TeamMenu($option){
	$db			=& JFactory::getDBO();
	$query = "SELECT COUNT(*) FROM #__bl_teams ORDER BY t_name";
	$db->setQuery($query);
	$total = $db->loadResult();
	
	$query = "SELECT * FROM #__bl_teams ORDER BY t_name";
	$db->setQuery($query);
	$rows = $db->loadObjectList();
	
	joomsport_html::bl_TeamMenu($rows, $option);
}
function BL_MatchMenu($option){
	$mainframe = JFactory::getApplication();
	
	$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	
	$db			=& JFactory::getDBO();
	$query = "SELECT COUNT(*) FROM #__bl_matchday as md , #__bl_match as m WHERE m.m_id = md.id";
	$db->setQuery($query);
	$total = $db->loadResult();
	
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	
	$query = "SELECT m.*,md.m_name,t1.t_name as home,t2.t_name as away FROM #__bl_matchday as md , #__bl_match as m, #__bl_teams as t1, #__bl_teams as t2  WHERE m.m_id = md.id AND t1.id = m.team1_id AND t2.id = m.team2_id ORDER BY md.s_id,m.m_id";
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
	$rows = $db->loadObjectList();
	
	joomsport_html::bl_MatchMenu($rows, $pageNav, $option);
}
function BL_Group_Menu($option){
	$mainframe = JFactory::getApplication();
	
	$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	
	$db			=& JFactory::getDBO();
	$query = "SELECT COUNT(*) FROM #__bl_groups as g, #__bl_tournament as t, #__bl_seasons as s WHERE s.t_id = t.id AND s.s_id=g.s_id";
	$db->setQuery($query);
	$total = $db->loadResult();
	
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	
	$query = "SELECT g.*,CONCAT(t.name,' ',s.s_name) as name FROM #__bl_groups as g, #__bl_tournament as t, #__bl_seasons as s WHERE s.t_id = t.id AND s.s_id=g.s_id ORDER BY g.group_name";
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
	$rows = $db->loadObjectList();
	joomsport_html::bl_GroupMenu($rows, $option);
}
function BL_PlayerMenu($option){
	$mainframe = JFactory::getApplication();
	
	$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	$f_team		= $mainframe->getUserStateFromRequest( $option.'.filter_team', 'f_team', 0, 'int' );
	$f_pos		= $mainframe->getUserStateFromRequest( $option.'.filter_pos', 'f_pos', 0, 'int' );
	
	$db			=& JFactory::getDBO();
	$query = "SELECT COUNT(*) FROM #__bl_players as p LEFT JOIN #__bl_positions as bp ON bp.p_id=p.position_id, #__bl_teams as t WHERE p.team_id = t.id ".($f_team?" AND t.id =".$f_team:"").($f_pos?" AND bp.p_id =".$f_pos:"")." ";
	$db->setQuery($query);
	$total = $db->loadResult();
	
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	
	$query = "SELECT p.*,t.t_name,bp.p_name FROM #__bl_players as p LEFT JOIN #__bl_positions as bp ON bp.p_id=p.position_id, #__bl_teams as t WHERE p.team_id = t.id ".($f_team?" AND t.id =".$f_team:"").($f_pos?" AND bp.p_id =".$f_pos:"")."  ORDER BY p.first_name,p.last_name";
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
	$rows = $db->loadObjectList();
	
	$javascript = 'onchange = "document.adminForm.submit();"';
		
	$pos = array();
	$query = "SELECT * FROM #__bl_positions ORDER BY p_name";
	$db->setQuery($query);
	$tourn = $db->loadObjectList();
	$pos[] = JHTML::_('select.option',  0, JText::_('BLBE_SELPOSITION'), 'p_id', 'p_name' ); 
	$positions = array_merge($pos,$tourn);
	$lists['pos'] = JHTML::_('select.genericlist',   $positions, 'f_pos', 'class="inputbox" size="1"'.$javascript, 'p_id', 'p_name', $f_pos );
	
	$is_team = array();
	$query = "SELECT t.id as id,t.t_name FROM #__bl_teams as t ORDER BY t.t_name";
	$db->setQuery($query);
	$team = $db->loadObjectList();
	$is_team[] = JHTML::_('select.option',  0, JText::_('BLBE_SELTEAM'), 'id', 't_name' ); 
	$teamis = array_merge($is_team,$team);
	$lists['teams1'] = JHTML::_('select.genericlist',   $teamis, 'f_team', 'class="inputbox" size="1"'.$javascript, 'id', 't_name', $f_team);
	
	
	joomsport_html::bl_PlayerMenu($rows, $pageNav, $lists, $option);
	
}
function BL_MatchdayMenu($option){
	$mainframe = JFactory::getApplication();
	
	$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	$season_id	= $mainframe->getUserStateFromRequest( $option.'.s_id', 's_id', 0, 'int' );
	
	$db			=& JFactory::getDBO();
	$is_tourn = array();
	$javascript = 'onchange = "document.adminForm.submit();"';
	$query = "SELECT s.s_id as id, CONCAT(t.name,' ',s.s_name) as name FROM #__bl_tournament as t, #__bl_seasons as s WHERE s.t_id = t.id ORDER BY t.name, s.s_name";
	$db->setQuery($query);
	$tourn = $db->loadObjectList();
	$is_tourn[] = JHTML::_('select.option',  0, JText::_('BLBE_SELTOURNAMENT'), 'id', 'name' ); 
	$tourn_is = array_merge($is_tourn,$tourn);
	$lists['tourn'] = JHTML::_('select.genericlist',   $tourn_is, 's_id', 'class="inputbox" size="1" '.$javascript, 'id', 'name', $season_id );
	
	
	$query = "SELECT COUNT(*) FROM #__bl_matchday as m , #__bl_tournament as t LEFT JOIN #__bl_seasons as s ON s.t_id = t.id WHERE m.s_id = s.s_id ".($season_id?" AND s.s_id=".$season_id:"")." ORDER BY m.m_name";
	$db->setQuery($query);
	$total = $db->loadResult();
	
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	
	$query = "SELECT m.*, CONCAT(t.name,' ',s.s_name) as tourn FROM #__bl_matchday as m , #__bl_tournament as t LEFT JOIN #__bl_seasons as s ON s.t_id = t.id WHERE m.s_id = s.s_id ".($season_id?" AND s.s_id=".$season_id:"")." ORDER BY m.m_name";
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
	$rows = $db->loadObjectList();
	
	joomsport_html::bl_Matchday_menu($rows, $pageNav, $lists, $option);
	
}
/////---------------------upload files-------------------------------///
function uploadFile( $filename, $userfile_name, $dir = '') {
	require_once(JPATH_ROOT.'/components/com_joomsport/includes/thumb.php');
	$msg = '';
	$thumb_width = 100;
	if(!$dir){
		$baseDir =  JPATH_ROOT . '/media/bearleague/' ;
	}else{
		$baseDir = $dir;
	}
	jimport('joomla.filesystem.path');
	if (file_exists( $baseDir )) {
		if (is_writable( $baseDir )) {
			if (move_uploaded_file( $filename, $baseDir . $userfile_name )) {
			
				if (JPath::setPermissions( $baseDir . $userfile_name )) {
					//createThumb(JPATH_ROOT."/media/bearleague/",JPATH_ROOT."/media/bearleague/thumbs/",$thumb_width, $userfile_name);
					return true;
				} else {
					$msg = JText::_('BLBE_UPFAIL');
				}
			} else {
				$msg = JText::_('BLBE_UPFAIL1');
			}
		} else {
			$msg = JText::_('BLBE_UPFAIL2');
		}
	} else {
		$msg = JText::_('BLBE_UPFAIL3');
	}
	if($msg != ''){
		JError::raiseError(500, $msg );
	}
	return false;
}
?>
