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
class bleagueViewedit_team extends JView
{
	function display($tpl = null)
	{
		$mainframe = JFactory::getApplication();
		$pathway  =& $mainframe->getPathway();
		$document =& JFactory::getDocument();
		$params	= &$mainframe->getParams();
		$editor =& JFactory::getEditor(); 
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
		$s_id = JRequest::getVar( 'sid', 0, '', 'int' );	
		if($is_id){
			
			$query = "SELECT COUNT(*) FROM #__bl_teams as t, #__bl_seasons as s, #__bl_season_teams as st, #__bl_tournament as tr WHERE s.s_id=st.season_id AND st.team_id = t.id AND s.t_id = tr.id AND s.s_id=".$s_id." AND t.id=".$is_id;
			$db->setQuery($query);
			
			if(!$db->loadResult()){
				
				JError::raiseError( 403, JText::_('Access Forbidden') );
				return; 
			}
		}
		
		//---------------------------//
	
	
	$row 	= new JTableTeams($db);
	$row->load($is_id);
	
	$query = "SELECT p.ph_name as name,p.id as id,p.ph_filename as filename FROM #__bl_assign_photos as ap, #__bl_photos as p WHERE ap.photo_id = p.id AND cat_type = 2 AND cat_id = ".$row->id."";
	$db->setQuery($query);
	$lists['photos'] = $db->loadObjectList();
	
	
	$query = "SELECT ef.*,ev.fvalue as fvalue FROM #__bl_extra_filds as ef LEFT JOIN #__bl_extra_values as ev ON ef.id=ev.f_id AND ev.uid=".$row->id." WHERE ef.published=1 AND ef.type='1' ORDER BY ef.ordering";
	$db->setQuery($query);
	$lists['ext_fields'] = $db->loadObjectList();
	
	
		$this->assignRef('params',		$params); 
		
		$this->assignRef('lists',		$lists);
		$this->assignRef('rows', $row);
		$this->assignRef('s_id', $s_id);
		$this->assignRef('msg', $msg);
		
		$this->assignRef('editor', $editor);
		parent::display($tpl);
	}
	
	
}
