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



class bleagueViewmoderedit_matchday extends JView

{

	function display($tpl = null)

	{

		$mainframe = JFactory::getApplication();


		$pathway  =& $mainframe->getPathway();

		$document =& JFactory::getDocument();

		$params	= &$mainframe->getParams();

		$user	=& JFactory::getUser();

	 	// Page Title

		$menus	= &JSite::getMenu();

		$menu	= $menus->getActive();
		$lists = array();	
		$is_id = 0;
		
		$cid 		= JRequest::getVar( 'cid', array(0), '', 'array' );
		$tid 		= JRequest::getVar( 'tid', 0, '', 'int' );	
		$sid = JRequest::getVar( 'sid', 0, '', 'int' );	
		$mid = JRequest::getVar( 'mid', 0, '', 'int' );	
		$db			=& JFactory::getDBO();
			
		$query = "SELECT s.*,CONCAT(tr.name,' ',s.s_name) as t_name FROM #__bl_season_teams as t,#__bl_seasons as s,#__bl_tournament as tr WHERE s.published=1 AND tr.id=s.t_id AND s.s_id=t.season_id AND t.team_id=".$tid." ORDER BY s.s_id desc";
		$db->setQuery($query);
		
		$seasons = $db->loadObjectList();
		
		$javascript = "onchange='document.filtrForm.submit();'";
		
		$lists['seas_filtr'] = JHTML::_('select.genericlist',   $seasons, 'sid', 'class="inputbox" size="1"'.$javascript, 's_id', 't_name', $sid );
		
		if(!$sid){
			$sid = $seasons[0]->s_id;
		}
		
		$query = "SELECT m.* FROM #__bl_season_teams as t,#__bl_seasons as s,#__bl_matchday as m WHERE s.published=1 AND m.s_id=s.s_id AND s.s_id=t.season_id AND t.team_id=".$tid." AND s.s_id=".$sid." ORDER BY m.id desc";
		$db->setQuery($query);
		$mdays = $db->loadObjectList();	
		
		$query = "SELECT COUNT(*) FROM #__bl_season_teams as t,#__bl_seasons as s,#__bl_matchday as m WHERE s.published=1 AND m.s_id=s.s_id AND s.s_id=t.season_id AND t.team_id=".$tid." AND s.s_id=".$sid." AND m.id=".$mid." ORDER BY m.id desc";
		$db->setQuery($query);
		if(!$db->loadResult()){
			$mid = $mdays[0]->id;
		}
		
		if(!$mid && count($mdays)){
			$mid = $mdays[0]->id;
		}
		
		$lists['md_filtr'] = JHTML::_('select.genericlist',   $mdays, 'mid', 'class="inputbox" size="1"'.$javascript, 'id', 'm_name', $mid );
		
		

	
		
	$query = "SELECT s.s_id as id, CONCAT(t.name,' ',s.s_name) as name FROM #__bl_tournament as t, #__bl_seasons as s WHERE s.t_id = t.id   ORDER BY t.name, s.s_name";
    $db->setQuery($query);

    $tourns = $db->loadObjectList(); 

		JArrayHelper::toInteger($cid, array(0));
		if($cid[0])
		{
			$is_id = $cid[0];
		}
		$option = 'com_joomsport';
		$season_id	= $mainframe->getUserStateFromRequest( $option.'.sid', 'sid', $tourns[0]->id, 'int' );


	$msg = JRequest::getVar( 'msg', '', 'get', 'string', JREQUEST_ALLOWRAW );


	

	$row 	= new JTableMday($db);

	$row->load($is_id?$is_id:$mid);
	
	//----checking for rights----//
		
		if($is_id){
			
			$query = "SELECT COUNT(*) FROM #__bl_seasons as s LEFT JOIN #__bl_tournament as t ON t.id = s.t_id WHERE  s.s_id = ".($row->s_id?$row->s_id:$season_id);

			$db->setQuery($query);
			
			if(!$db->loadResult()){
				
				JError::raiseError( 403, JText::_('Access Forbidden') );

				return; 
			}
			//$tpl="edit";
		}
		
		//---------------------------//
	
		$query = "SELECT t.id FROM #__bl_teams as t, #__bl_moders as m WHERE m.tid=t.id AND m.uid=".$user->id." ORDER BY t.t_name";

		$db->setQuery($query);
	
		$teams_moder = $db->loadResultArray();

	
	
	$lists['is_playoff'] 		= JHTML::_('select.booleanlist',  'is_playoff', 'class="inputbox"', $row->is_playoff );


	$query = "SELECT m.*,t.t_name as home_team, t2.t_name as away_team, t.id as t1id, t2.id as t2id FROM #__bl_match as m, #__bl_teams as t, #__bl_teams as t2  WHERE m.m_id = ".$row->id." AND t.id = m.team1_id AND t2.id = m.team2_id AND (t.id = ".$tid." OR t2.id = ".$tid.")  ORDER BY m.id";

	$db->setQuery($query);

	$match = $db->loadObjectList();

	

	$is_team = array();

	$query = "SELECT * FROM #__bl_teams as t , #__bl_season_teams as st WHERE st.team_id = t.id AND st.season_id = ".($sid?$sid:$season_id)." ORDER BY t.t_name";

	$db->setQuery($query);

	$team = $db->loadObjectList();

	$is_team[] = JHTML::_('select.option',  0, JText::_('Select Team'), 'id', 't_name' ); 

	$teamis = array_merge($is_team,$team);

	$lists['teams1'] = JHTML::_('select.genericlist',   $teamis, 'teams1', 'class="inputbox" size="1" id="teams1"', 'id', 't_name', 0 );

	$lists['teams2'] = JHTML::_('select.genericlist',   $teamis, 'teams2', 'class="inputbox" size="1" id="teams2"', 'id', 't_name', 0 );


	
	/*$is_month[] = JHTML::_('select.option',  0, JText::_('Month'), 'id', 'name' ); 

	for($z=1;$z<13;$z++){
		$is_month[] = JHTML::_('select.option',  $z, $z, 'id', 'name' ); 
	}
	

	$lists['month'] = JHTML::_('select.genericlist',   $is_month, 'd_month', 'class="inputbox" size="1"', 'id', 'name', 0 );
	
	$is_day[] = JHTML::_('select.option',  0, JText::_('Day'), 'id', 'name' ); 

	for($z=1;$z<32;$z++){
		$is_day[] = JHTML::_('select.option',  $z, $z, 'id', 'name' ); 
	}
	

	$lists['day'] = JHTML::_('select.genericlist',   $is_day, 'd_day', 'class="inputbox" size="1"', 'id', 'name', 0 );
	*/
	
	$is_time[] = JHTML::_('select.option',  'AM', JText::_('AM'), 'id', 'name' ); 
	$is_time[] = JHTML::_('select.option',  'PM', JText::_('PM'), 'id', 'name' ); 
	$lists['time'] = JHTML::_('select.genericlist',   $is_time, 'da_time', 'class="inputbox" size="1"', 'id', 'name', 0 );
	

	$s_id = $row->s_id?$row->s_id:$season_id;

	
	if($tpl){
		for($g=0;$g<count($match);$g++){
			$lists['teams1_'.$match[$g]->id] = JHTML::_('select.genericlist',   $teamis, 'teams1_'.$match[$g]->id, 'class="inputbox" size="1"', 'id', 't_name', $match[$g]->t1id );
			$lists['teams2_'.$match[$g]->id] = JHTML::_('select.genericlist',   $teamis, 'teams2_'.$match[$g]->id, 'class="inputbox" size="1"', 'id', 't_name', $match[$g]->t2id );
			$lists['time_'.$match[$g]->id] = JHTML::_('select.genericlist',   $is_time, 'da_time_'.$match[$g]->id, 'class="inputbox" size="1"', 'id', 'name', substr($match[$g]->m_time,strlen($match[$g]->m_time)-2,2) );
	
		}
	}
	
	
	

		$this->assignRef('params',		$params); 
		
		$this->assignRef('lists',		$lists);

		$this->assignRef('row', $row);
		
		$this->assignRef('match', $match);

		$this->assignRef('tid', $tid);
		$this->assignRef('mid', $mid);
		
		$this->assignRef('msg', $msg);
		$this->assignRef('s_id', $sid);

		parent::display($tpl);

	}

	

	

}

