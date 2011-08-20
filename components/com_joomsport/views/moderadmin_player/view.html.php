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



class bleagueViewmoderadmin_player extends JView

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

		

	$tid		= $mainframe->getUserStateFromRequest( $option.'.tid', 'tid', 0, 'int' );

	$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );

	$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

	$f_pos		= $mainframe->getUserStateFromRequest( $option.'.filter_pos', 'f_pos', 0, 'int' );
	$sid 		= JRequest::getVar( 'sid', 0, '', 'int' );

	$db			=& JFactory::getDBO();

	$query = "SELECT COUNT(DISTINCT(p.id)) FROM #__bl_players as p LEFT JOIN #__bl_positions as bp ON bp.p_id=p.position_id, #__bl_teams as t WHERE p.team_id = t.id AND t.id =".$tid."".($f_pos?" AND bp.p_id =".$f_pos:"")." ";

	$db->setQuery($query);

	$total = $db->loadResult();

	

	jimport('joomla.html.pagination');

	$pageNav = new JPagination( $total, $limitstart, $limit );

	

	$query = "SELECT DISTINCT(p.id),p.*,t.t_name,bp.p_name FROM #__bl_players as p LEFT JOIN #__bl_positions as bp ON bp.p_id=p.position_id, #__bl_teams as t WHERE p.team_id = t.id AND t.id =".$tid."".($f_pos?" AND bp.p_id =".$f_pos:"")."  ORDER BY p.position_id,p.first_name,p.last_name";

	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);

	$rows = $db->loadObjectList();

	

	$javascript = 'onchange = "document.adminForm.submit();"';

		

	$pos = array();

	$query = "SELECT * FROM #__bl_positions ORDER BY p_name";

	$db->setQuery($query);

	$tourn = $db->loadObjectList();

	$pos[] = JHTML::_('select.option',  0, JText::_('Select Position'), 'p_id', 'p_name' ); 

	$positions = array_merge($pos,$tourn);

	$lists['pos'] = JHTML::_('select.genericlist',   $positions, 'f_pos', 'class="inputbox" size="1"'.$javascript, 'p_id', 'p_name', $f_pos );

	

	


		

		$this->assignRef('params',		$params); 

		
		$this->assignRef('rows',		$rows);
		
		$this->assignRef('lists',		$lists);

		$this->assignRef('page', $pageNav);

		$this->assignRef('tid', $tid);
		$this->assignRef('s_id', $sid);

		parent::display($tpl);

	}

	

	

}

