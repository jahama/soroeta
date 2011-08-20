<?php
/**
developed by Beardev.com
*/
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
require_once(JPATH_ROOT.DS.'components'.DS.'com_joomsport'.DS.'libs'.DS.'season.php');
class bleagueViewCalendar extends JView
{
	function display($tpl = null)
	{
		$Itemid = JRequest::getInt('Itemid'); 

		$mainframe = JFactory::getApplication();
		$pathway  =& $mainframe->getPathway();
		$document =& JFactory::getDocument();
		$params	= &$mainframe->getParams();
	 	// Page Title
		$menus	= &JSite::getMenu();
		$menu	= $menus->getActive();
		$gr_id = JRequest::getVar( 'gr_id', 0, '', 'int' );
		$s_id = JRequest::getVar( 'sid', 0, '', 'int' );
		$calendar = JRequest::getVar( 'calendar', 0, '', 'int' );
		$tmpl = JRequest::getVar( 'tmpl', '', '', 'string' );
		$layout=JRequest::getVar( 'layout', '', '', 'string' );;
		if(!$s_id){
			JError::raiseError( 403, JText::_('Access Forbidden') );
			return; 
		}
		$user	=& JFactory::getUser();
		$db			= & JFactory::getDBO();
		
		$option = 'com_joomsport';
		
		
		
		$query = "SELECT CONCAT(t.name,' ',s.s_name) FROM #__bl_seasons as s, #__bl_tournament as t WHERE t.id = s.t_id AND s.s_id = ".$s_id;
		$db->setQuery($query);
		$p_title = $db->loadResult();
		
		
		
		// because the application sets a default page title, we need to get it
		// right from the menu item itself
		if (is_object( $menu )) {
			$menu_params = new JRegistry;// new JParameter( $menu->params );
			if (!$menu_params->get( 'page_title')) {
				$params->set('page_title',	JText::_( $p_title ));
			}
		} else {
			$params->set('page_title',	JText::_( $p_title ));
		}
		$document->setTitle( $params->get( 'page_title' ) );
		$pathway->addItem( JText::_( $p_title ));
		
		
		
		$myseas = new mclSeason($s_id, $db);

		$matchs = $myseas->getMatchs();

		
		
	
	$query = "SELECT * FROM #__bl_seasons as s, #__bl_tournament as t WHERE t.id = s.t_id AND s.s_id = ".$s_id;
		$db->setQuery($query);
		$curseas = $db->loadObject();
	
		//---language-----------//
		require_once(JPATH_ROOT.DS.'components'.DS.'com_joomsport'.DS.'bl_lang.php');
		
		$this->assignRef('bl_lang', $bl_lang);
		
		$this->assignRef('params',		$params); 
		
		$this->assignRef('sid', $s_id);
		
		$this->assignRef('enbl_extra',$season_par->s_enbl_extra);
		$this->assignRef('season_par', $season_par);
		
		$this->assignRef('lists', $lists);
		
		
		
		$this->assignRef('matchs', $matchs);
		
		
		$this->assignRef('curseas', $curseas);
		$this->assignRef('adm_links', $adm_links);
		$this->assignRef('tmpl', $tmpl);
		$this->assignRef('gr_id', $gr_id);
		parent::display($tpl);
	}
	
	
}
