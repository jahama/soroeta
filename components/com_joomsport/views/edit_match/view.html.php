<?php
// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
/**
 * HTML View class for the Registration component
 *
 * @package		Joomla
 * @subpackage	Registration
 * @since 1.0
 */
class bleagueViewedit_match extends JView
{
	function display($tpl = null)
	{
		$mainframe = JFactory::getApplication();
		$pathway  =& $mainframe->getPathway();
		$document =& JFactory::getDocument();
		$params	= &$mainframe->getParams();
	 	// Page Title
		$menus	= &JSite::getMenu();
		$menu	= $menus->getActive();
		
		$cid 		= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		if($cid[0])
		{
			$is_id = $cid[0];
		}
		$option= 'com_joomsport';
		$season_id	= $mainframe->getUserStateFromRequest( $option.'.sid', 'sid', 0, 'int' );
	
	$db			=& JFactory::getDBO();
	
	
	$row 	= new JTableMatch($db);
	$row->load($is_id);
	$lists = array();	
	
	$query = "SELECT * FROM #__bl_matchday  WHERE s_id = ".($season_id)." ORDER BY m_name";
	$db->setQuery($query);
	$mday = $db->loadObjectList();
	$is_matchday[] = JHTML::_('select.option',  0, JText::_('Select Match day'), 'id', 'm_name' ); 
	$mdayis = array_merge($is_matchday,$mday);
	$lists['mday'] = JHTML::_('select.genericlist',   $mdayis, 'm_id', 'class="inputbox" size="1"', 'id', 'm_name', $row->m_id);
	$query = "SELECT m.*,t.t_name as home_team, t2.t_name as away_team FROM #__bl_match as m, #__bl_teams as t, #__bl_teams as t2  WHERE m.id = ".$row->id." AND t.id = m.team1_id AND t2.id = m.team2_id  ORDER BY m.id";
	$db->setQuery($query);
	$match = $db->loadObjectList();
	$is_team = array();
	$query = "SELECT * FROM #__bl_teams as t , #__bl_season_teams as st WHERE st.team_id = t.id AND st.season_id = ".($season_id)." ORDER BY t.t_name";
	$db->setQuery($query);
	$team = $db->loadObjectList();
	$is_team[] = JHTML::_('select.option',  0, JText::_('Select Team'), 'id', 't_name' ); 
	$teamis = array_merge($is_team,$team);
	$lists['teams1'] = JHTML::_('select.genericlist',   $teamis, 'teams1', 'class="inputbox" size="1" id="teams1"', 'id', 't_name', $row->team1_id );
	$lists['teams2'] = JHTML::_('select.genericlist',   $teamis, 'teams2', 'class="inputbox" size="1" id="teams2"', 'id', 't_name', $row->team2_id );
	$is_event = array();
	$query = "SELECT * FROM #__bl_events WHERE player_event = '1' ORDER BY e_name";
	$db->setQuery($query);
	$events = $db->loadObjectList();
	$is_event[] = JHTML::_('select.option',  0, JText::_('Select Event'), 'id', 'e_name' ); 
	$ev_pl = array_merge($is_event,$events);
	$lists['events'] = JHTML::_('select.genericlist',   $ev_pl, 'event_id', 'class="inputbox" size="1"', 'id', 'e_name', 0);
	
	$is_event = array();
	$query = "SELECT * FROM #__bl_events WHERE player_event = '0' ORDER BY e_name";
	$db->setQuery($query);
	$events = $db->loadObjectList();
	$is_event[] = JHTML::_('select.option',  0, JText::_('Select Event'), 'id', 'e_name' ); 
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
	$is_player[] = JHTML::_('select.option',  0, JText::_('Select Player'), 'id', 'p_name' ); 
	$is_player[] = JHTML::_('select.optgroup',  $team_1, 'id', 'p_name' ); 
	$is_player2[] = JHTML::_('select.optgroup',  $team_2, 'id', 'p_name' ); 
	//$is2_player[] = '</optgroup>';$lists['players']
	$jqre = '<select name="playerz_id" id="playerz_id" class="inputbox" size="1">';
		$jqre .= '<option value="">'.JText::_('BLFA_SELPLAYER').'</option>';
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
		
		$lists['players'] = $jqre;//JHTML::_('select.genericlist',   $ev_pl, 'playerz_id', 'class="inputbox" size="1"', 'id', 'p_name', 0);
	
	$is_team2[] = JHTML::_('select.option',  0, JText::_('Select Team'), 'id', 'p_name' ); 
	$is_team2[] = JHTML::_('select.option', $row->team1_id, $team_1, 'id', 'p_name' ); 
	$is_team2[] = JHTML::_('select.option', $row->team2_id, $team_2, 'id', 'p_name' ); 
	$lists['sel_team'] = JHTML::_('select.genericlist',   $is_team2, 'teamz_id', 'class="inputbox" size="1"', 'id', 'p_name', 0);
	
	$lists['extra'] 		= JHTML::_('select.booleanlist',  'is_extra', 'class="inputbox"', $row->is_extra );
	$lists['m_played'] 		= JHTML::_('select.booleanlist',  'm_played', 'class="inputbox"', $row->m_played );
	//$lists['m_calc'] 		= JHTML::_('select.booleanlist',  'm_calc', 'class="inputbox"', $row->m_calc );
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
	//extrafields
	$query = "SELECT ef.*,ev.fvalue as fvalue FROM #__bl_extra_filds as ef LEFT JOIN #__bl_extra_values as ev ON ef.id=ev.f_id AND ev.uid=".$row->id." WHERE ef.published=1 AND ef.type='2' ORDER BY ef.ordering";
	$db->setQuery($query);
	$lists['ext_fields'] = $db->loadObjectList();
	
	//----squard----//
	$is_player_sq[] = JHTML::_('select.option',  0, JText::_('Select Player'), 'id', 'p_name' ); 
	$ev_pl = array_merge($is_player_sq,$players_1);
	$lists['players_team1'] = JHTML::_('select.genericlist',   $ev_pl, 'playersq1_id', 'class="inputbox" size="1"', 'id', 'p_name', 0);
	$lists['players_team1_res'] = JHTML::_('select.genericlist',   $ev_pl, 'playersq1_id_res', 'class="inputbox" size="1"', 'id', 'p_name', 0);
	$ev_pl = array_merge($is_player_sq,$players_2);
	$lists['players_team2'] = JHTML::_('select.genericlist',   $ev_pl, 'playersq2_id', 'class="inputbox" size="1"', 'id', 'p_name', 0);
	$lists['players_team2_res'] = JHTML::_('select.genericlist',   $ev_pl, 'playersq2_id_res', 'class="inputbox" size="1"', 'id', 'p_name', 0);
	
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
	
	$s_id = $season_id;
		
		$this->assignRef('params',		$params); 
		
		$this->assignRef('lists',		$lists);
		$this->assignRef('row', $row);
		
		$this->assignRef('match', $match);
		$this->assignRef('s_id', $s_id);
		
		parent::display($tpl);
	}
	
	
}
