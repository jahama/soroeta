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



class bleagueViewmoderedit_player extends JView

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
		$is_id = 0;
		
		$cid 		= JRequest::getVar( 'cid', array(0), '', 'array' );
		
		$msg = JRequest::getVar( 'msg', '', 'get', 'string', JREQUEST_ALLOWRAW );

		JArrayHelper::toInteger($cid, array(0));
		if($cid[0])
		{
			$is_id = $cid[0];
		}
		
		$db			=& JFactory::getDBO();
		
		//----checking for rights----//
		$tid = JRequest::getVar( 'tid', 0, '', 'int' );	
		$sid = JRequest::getVar( 'sid', 0, '', 'int' );	
		/*if($is_id){
			
			$query = "SELECT COUNT(*) FROM #__bl_players as p LEFT JOIN #__bl_positions as bp ON bp.p_id=p.position_id, #__bl_teams as t, #__bl_seasons as s, #__bl_season_teams as st, #__bl_tournament as tr WHERE s.s_id=st.season_id AND st.team_id = t.id AND s.t_id = tr.id AND s.s_id=".$s_id." AND p.team_id = t.id  AND p.id = ".$is_id;

			$db->setQuery($query);
			
			if(!$db->loadResult()){
				
				JError::raiseError( 403, JText::_('Access Forbidden') );

				return; 
			}
		}*/
		
		//---------------------------//
		
		$row 	= new JTablePlayer($db);
	
		$row->load($is_id);
	
		
	
		$pos = array();
	
		$query = "SELECT * FROM #__bl_positions ORDER BY p_name";
	
		$db->setQuery($query);
	
		$tourn = $db->loadObjectList();
	
		$pos[] = JHTML::_('select.option',  0, JText::_('Select Position'), 'p_id', 'p_name' ); 
	
		$positions = array_merge($pos,$tourn);
	
		$lists['pos'] = JHTML::_('select.genericlist',   $positions, 'position_id', 'class="inputbox" size="1"', 'p_id', 'p_name', $row->position_id );
	
	
		$query = "SELECT * FROM #__bl_teams ORDER BY t_name";
	
		$db->setQuery($query);
	
		$teams = $db->loadObjectList();
		
	
		$lists['teams'] = JHTML::_('select.genericlist',   $teams, 'team_id', 'class="inputbox" size="1" disabled', 'id', 't_name', $tid );
	
		
	
		$query = "SELECT p.ph_name as name,p.id as id,p.ph_filename as filename FROM #__bl_assign_photos as ap, #__bl_photos as p WHERE ap.photo_id = p.id AND cat_type = 1 AND cat_id = ".$row->id."";
	
		$db->setQuery($query);
	
		$lists['photos'] = $db->loadObjectList();
	
		
		$query = "SELECT t.sport_id FROM #__bl_tournament as t,#__bl_seasons as s, #__bl_season_teams as st WHERE s.t_id=t.id AND st.season_id = s.s_id AND st.team_id = ".$row->team_id." ORDER BY s.s_id LIMIT 1";
	
	$db->setQuery($query);

	$sport_id = $db->loadResult();
	

	$query = "SELECT ef.*,ev.fvalue as fvalue FROM #__bl_extra_filds as ef LEFT JOIN #__bl_extra_values as ev ON ef.id=ev.f_id AND ev.uid=".$row->id." WHERE  ef.published=1 AND ef.type='0' ORDER BY ef.ordering";
	$db->setQuery($query);

	
		$lists['ext_fields'] = $db->loadObjectList();

		

		$this->assignRef('params',		$params); 

		
		$this->assignRef('lists',		$lists);

		$this->assignRef('rows', $row);

		$this->assignRef('tid', $tid);
		$this->assignRef('s_id', $sid);
		
		$this->assignRef('msg', $msg);

		parent::display($tpl);

	}

	

	

}

