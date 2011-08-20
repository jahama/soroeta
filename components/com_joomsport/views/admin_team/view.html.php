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
class bleagueViewadmin_team extends JView
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
		
	
	$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	$s_id = JRequest::getVar( 'sid', 0, '', 'int' );	
	$db			=& JFactory::getDBO();
	$query = "SELECT COUNT(DISTINCT(t.id)) FROM #__bl_teams as t, #__bl_seasons as s, #__bl_season_teams as st, #__bl_tournament as tr WHERE s.s_id=st.season_id AND st.team_id = t.id AND s.t_id = tr.id AND s.s_id=".$s_id;
	$db->setQuery($query);
	$total = $db->loadResult();
	
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	
	$query = "SELECT DISTINCT(t.id),t.* FROM #__bl_teams as t, #__bl_seasons as s, #__bl_season_teams as st, #__bl_tournament as tr WHERE s.s_id=st.season_id AND st.team_id = t.id AND s.t_id = tr.id AND s.s_id=".$s_id." ORDER BY t.t_name";
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
	$rows = $db->loadObjectList();
		
		$this->assignRef('params',		$params); 
		
		$this->assignRef('rows',		$rows);
		$this->assignRef('page', $pageNav);
		$this->assignRef('s_id', $s_id);
		parent::display($tpl);
	}
	
	
}
