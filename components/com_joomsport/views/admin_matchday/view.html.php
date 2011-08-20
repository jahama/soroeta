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
class bleagueViewadmin_matchday extends JView
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
	
	$season_id	= $mainframe->getUserStateFromRequest( $option.'.sid', 'sid', 0, 'int' );
	$db			=& JFactory::getDBO();
	
	$query = "SELECT COUNT(*) FROM #__bl_matchday as m , #__bl_tournament as t LEFT JOIN #__bl_seasons as s ON s.t_id = t.id WHERE m.s_id = s.s_id ".($season_id?" AND s.s_id=".$season_id:"")."  ORDER BY m.m_name";
	$db->setQuery($query);
	$total = $db->loadResult();
	
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );
	
	$query = "SELECT m.*, t.name as tourn,s.s_name FROM #__bl_matchday as m , #__bl_tournament as t LEFT JOIN #__bl_seasons as s ON s.t_id = t.id WHERE m.s_id = s.s_id ".($season_id?" AND s.s_id=".$season_id:"")."  ORDER BY m.m_name";
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
	$rows = $db->loadObjectList();
		
		$this->assignRef('params',		$params); 
		
		$this->assignRef('rows',		$rows);
		
		$this->assignRef('lists',		$lists);
		$this->assignRef('page', $pageNav);
		$this->assignRef('s_id', $season_id);
		parent::display($tpl);
	}
	
	
}
