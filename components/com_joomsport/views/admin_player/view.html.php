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
class bleagueViewadmin_player extends JView
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
		$option = 'com_joomsport';
		
	$s_id		= $mainframe->getUserStateFromRequest( $option.'.sid', 'sid', 0, 'int' );
	$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	$f_team		= $mainframe->getUserStateFromRequest( $option.'.filter_team', 'f_team', 0, 'int' );
	$f_pos		= $mainframe->getUserStateFromRequest( $option.'.filter_pos', 'f_pos', 0, 'int' );
	$db			=& JFactory::getDBO();
	$query = "SELECT COUNT(DISTINCT(p.id)) FROM #__bl_players as p LEFT JOIN #__bl_positions as bp ON bp.p_id=p.position_id, #__bl_teams as t, #__bl_seasons as s, #__bl_season_teams as st, #__bl_tournament as tr WHERE s.s_id=st.season_id AND st.team_id = t.id AND s.t_id = tr.id AND s.s_id=".$s_id." AND p.team_id = t.id ".($f_team?" AND t.id =".$f_team:"").($f_pos?" AND bp.p_id =".$f_pos:"")." ";
	$db->setQuery($query);
	$total = $db->loadResult();
	
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	
	$query = "SELECT DISTINCT(p.id),p.*,t.t_name,bp.p_name FROM #__bl_players as p LEFT JOIN #__bl_positions as bp ON bp.p_id=p.position_id, #__bl_teams as t, #__bl_seasons as s, #__bl_season_teams as st, #__bl_tournament as tr WHERE s.s_id=st.season_id AND st.team_id = t.id AND s.t_id = tr.id AND s.s_id=".$s_id." AND p.team_id = t.id ".($f_team?" AND t.id =".$f_team:"").($f_pos?" AND bp.p_id =".$f_pos:"")."  ORDER BY p.first_name,p.last_name";
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
	$rows = $db->loadObjectList();
	
	$javascript = 'onchange = "document.adminForm.submit();"';
		
	$pos = array();
	$query = "SELECT * FROM #__bl_positions ORDER BY p_name";
	$db->setQuery($query);
	$tourn = $db->loadObjectList();
	$pos[] = JHTML::_('select.option',  0, JText::_('BLFA_SELPOSITION'), 'p_id', 'p_name' ); 
	$positions = array_merge($pos,$tourn);
	$lists['pos'] = JHTML::_('select.genericlist',   $positions, 'f_pos', 'class="inputbox" size="1"'.$javascript, 'p_id', 'p_name', $f_pos );
	
	$is_team = array();
	$query = "SELECT t.id as id,t.t_name FROM #__bl_teams as t ORDER BY t.t_name";
	$db->setQuery($query);
	$team = $db->loadObjectList();
	$is_team[] = JHTML::_('select.option',  0, JText::_('BLFA_SELTEAM'), 'id', 't_name' ); 
	$teamis = array_merge($is_team,$team);
	$lists['teams1'] = JHTML::_('select.genericlist',   $teamis, 'f_team', 'class="inputbox" size="1"'.$javascript, 'id', 't_name', $f_team);
		
		$this->assignRef('params',		$params); 
		
		$this->assignRef('rows',		$rows);
		
		$this->assignRef('lists',		$lists);
		$this->assignRef('page', $pageNav);
		$this->assignRef('s_id', $s_id);
		parent::display($tpl);
	}
	
	
}
