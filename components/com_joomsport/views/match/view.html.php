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
class bleagueViewmatch extends JView
{
	function display($tpl = null)
	{
		$mainframe = JFactory::getApplication();
		JHTML::_('behavior.modal', 'a.team-images');
		$pathway  =& $mainframe->getPathway();
		$document =& JFactory::getDocument();
		$params	= &$mainframe->getParams();
	 	// Page Title
		$menus	= &JSite::getMenu();
		$menu	= $menus->getActive();
		
		$m_id = JRequest::getVar( 'id', 0, '', 'int' );
		
		if(!$m_id){
			JError::raiseError( 403, JText::_('Access Forbidden') );
			return; 
		}
		
		$db			= & JFactory::getDBO();
		
		$query = "SELECT md.m_name,m.match_descr,m.m_time,m.m_date, t1.t_name as home, t2.t_name as away, score1,score2,md.s_id,m.is_extra,t1.id as hm_id,t2.id as aw_id,m.m_played,m.m_location FROM #__bl_matchday as md, #__bl_match as m, #__bl_teams as t1, #__bl_teams as t2 WHERE m.m_id = md.id AND m.published = 1  AND m.team1_id = t1.id AND m.team2_id = t2.id AND m.id = ".$m_id;
		$db->setQuery($query);
		$matchs = $db->loadObjectList();
		
		$match = $matchs[0];
		
		$query = "SELECT * FROM #__bl_seasons WHERE s_id = ".$match->s_id;
			$db->setQuery($query);
			$season_par = $db->LoadObjectList();
			$season_par = $season_par[0];
		
		$query = "SELECT me.*,ev.*,CONCAT(p.first_name,' ',p.last_name) as p_name,p.team_id,p.id as plid FROM #__bl_match_events as me, #__bl_events as ev, #__bl_players as p WHERE me.player_id = p.id AND ev.player_event = '1' AND me.e_id = ev.id AND me.match_id = ".$m_id." AND me.t_id=".$match->hm_id." ORDER BY CAST(me.minutes AS UNSIGNED)";
		$db->setQuery($query);
		//echo mysql_error();die();
		$m_events_home = $db->loadObjectList();
		
		$query = "SELECT me.*,ev.*,CONCAT(p.first_name,' ',p.last_name) as p_name,p.team_id,p.id as plid FROM #__bl_match_events as me, #__bl_events as ev, #__bl_players as p WHERE me.player_id = p.id AND ev.player_event = '1' AND me.e_id = ev.id AND me.match_id = ".$m_id." AND me.t_id=".$match->aw_id." ORDER BY CAST(me.minutes AS UNSIGNED)";
		$db->setQuery($query);
		//echo mysql_error();die();
		$m_events_away = $db->loadObjectList();
		
		$query = "SELECT me.*,ev.*,p.t_name as p_name,p.id FROM #__bl_match_events as me, #__bl_events as ev, #__bl_teams as p WHERE me.t_id = p.id AND me.t_id = ".$match->hm_id." AND ev.player_event = '0' AND me.e_id = ev.id AND me.match_id = ".$m_id." ORDER BY ev.e_name";
		$db->setQuery($query);
		//echo mysql_error();die();
		$t_events = $db->loadObjectList();
		
		$query = "SELECT me.*,ev.*,p.t_name as p_name,p.id FROM #__bl_match_events as me, #__bl_events as ev ,#__bl_teams as p WHERE me.t_id = p.id AND me.t_id = ".$match->aw_id." AND ev.player_event = '0' AND me.e_id = ev.id AND me.match_id = ".$m_id." ORDER BY ev.e_name";
		$db->setQuery($query);
		//echo mysql_error();die();
		$at_events = $db->loadObjectList();
		//var_dump($at_events);
		$query = "SELECT p.ph_name as name,p.id as id,p.ph_filename as filename FROM #__bl_assign_photos as ap, #__bl_photos as p WHERE ap.photo_id = p.id AND cat_type = 3 AND cat_id = ".$m_id;
		$db->setQuery($query);
		$photos = $db->loadObjectList();
		
		
		// because the application sets a default page title, we need to get it
		// right from the menu item itself
		if (is_object( $menu )) {
			$menu_params = new JRegistry;// new JParameter( $menu->params );
			if (!$menu_params->get( 'page_title')) {
				$params->set('page_title',	$match->home.' '.($match->m_played?$match->score1:'-').':'.($match->m_played?$match->score2:'-').' '.$match->away);
			}
		} else {
			$params->set('page_title',	$match->home.' '.($match->m_played?$match->score1:'-').' : '.($match->m_played?$match->score2:'-').' '.$match->away);
		}
		$document->setTitle( $params->get( 'page_title' ) );
		$pathway->addItem( JText::_( $match->home.' '.($match->m_played?$match->score1:'-').':'.($match->m_played?$match->score2:'-').' '.$match->away ));
		
		$query = "SELECT ef.*,ev.fvalue as fvalue FROM #__bl_extra_filds as ef LEFT JOIN #__bl_extra_values as ev ON ef.id=ev.f_id AND ev.uid=".$m_id." WHERE ef.published=1 AND ef.type='2' ORDER BY ef.ordering";
		$db->setQuery($query);
		$ext_fields = $db->loadObjectList();
		
		//----squard----//
	$query = "SELECT p.id,CONCAT(p.first_name,' ',p.last_name) as name FROM #__bl_players as p, #__bl_squard as s WHERE p.id=s.player_id AND s.match_id=".$m_id." AND s.team_id={$match->hm_id} AND s.mainsquard = '1'";
	$db->setQuery($query);
	$lists['squard1'] = $db->loadObjectList();
	$query = "SELECT p.id,CONCAT(p.first_name,' ',p.last_name) as name FROM #__bl_players as p, #__bl_squard as s WHERE p.id=s.player_id AND s.match_id=".$m_id." AND s.team_id={$match->aw_id} AND s.mainsquard = '1'";
	$db->setQuery($query);
	$lists['squard2'] = $db->loadObjectList();
	$query = "SELECT p.id,CONCAT(p.first_name,' ',p.last_name) as name FROM #__bl_players as p, #__bl_squard as s WHERE p.id=s.player_id AND s.match_id=".$m_id." AND s.team_id={$match->hm_id} AND s.mainsquard = '0'";
	$db->setQuery($query);
	$lists['squard1_res'] = $db->loadObjectList();
	$query = "SELECT p.id,CONCAT(p.first_name,' ',p.last_name) as name FROM #__bl_players as p, #__bl_squard as s WHERE p.id=s.player_id AND s.match_id=".$m_id." AND s.team_id={$match->aw_id} AND s.mainsquard = '0'";
	$db->setQuery($query);
	$lists['squard2_res'] = $db->loadObjectList();
	
		//---language-----------//
	require_once(JPATH_ROOT.DS.'components'.DS.'com_joomsport'.DS.'bl_lang.php');
		
		$this->assignRef('bl_lang', $bl_lang);
		$this->assignRef('params',		$params); 
		$this->assignRef('photos',		$photos);
		$this->assignRef('match',		$match);
		$this->assignRef('m_events_home',	$m_events_home);
		$this->assignRef('m_events_away',	$m_events_away);
		$this->assignRef('h_events',	$t_events);
		$this->assignRef('a_events',	$at_events);
		$this->assignRef('ext_fields',	$ext_fields);
		$this->assignRef('lists',	$lists);
		$this->assignRef('enbl_extra',$season_par->s_enbl_extra);
		
		parent::display($tpl);
	}
	
	
}
