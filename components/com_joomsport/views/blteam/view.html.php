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
class bleagueViewblteam extends JView
{
	function display($tpl = null)
	{
		$mainframe = JFactory::getApplication();
    require_once(JPATH_ROOT.DS.'components'.DS.'com_joomsport'.DS.'bl_lang.php');
JHTML::_('behavior.modal', 'a.team-images');
		$pathway  =& $mainframe->getPathway();
		$document =& JFactory::getDocument();
		$params	= &$mainframe->getParams();
	 	// Page Title
		$menus	= &JSite::getMenu();
		$menu	= $menus->getActive();
		
		$team_id = JRequest::getVar( 'tid', 0, '', 'int' );
		$s_id = JRequest::getVar( 'sid', 0, '', 'int' );
		
		if(!$s_id || !$team_id){
			JError::raiseError( 403, JText::_('Access Forbidden') );
			return; 
		}
		
		$db			= & JFactory::getDBO();
		
		$query = "SELECT * FROM #__bl_teams WHERE id = ".$team_id;
		$db->setQuery($query);
		$teams = $db->loadObjectList();
		
		$team = $teams[0];
		
		// because the application sets a default page title, we need to get it
		// right from the menu item itself
		if (is_object( $menu )) {
			$menu_params = new JRegistry;// new JParameter( $menu->params );
			if (!$menu_params->get( 'page_title')) {
				$params->set('page_title',	$team->t_name);
			}
		} else {
			$params->set('page_title',	$team->t_name);
		}
		$document->setTitle( $params->get( 'page_title' ) );
		$pathway->addItem( JText::_( $team->t_name ));
		// table league
		
		$query = "SELECT * FROM #__bl_seasons WHERE s_id = ".$s_id;
			$db->setQuery($query);
			$season_par = $db->LoadObjectList();
			$season_par = $season_par[0];
		
		$query = "SELECT p.ph_name as name,p.id as id,p.ph_filename as filename FROM #__bl_assign_photos as ap, #__bl_photos as p WHERE ap.photo_id = p.id AND cat_type = 2 AND cat_id = ".$team_id;
		$db->setQuery($query);
		$photos = $db->loadObjectList();
		
		$def_img = '';
		if($team->def_img){
			$query = "SELECT ph_filename FROM  #__bl_photos as p WHERE p.id = ".$team->def_img;
			$db->setQuery($query);
			$def_img = $db->loadResult();
		}else if(isset($photos[0])){
			$def_img = $photos[0]->filename;
		}
		
		$query = "SELECT md.m_name,m.id as mid,m.m_date,m.m_time, t1.t_name as home, t2.t_name as away, score1,score2,m.is_extra, m.m_played FROM #__bl_matchday as md, #__bl_match as m, #__bl_teams as t1, #__bl_teams as t2 WHERE m.m_id = md.id AND m.published = 1 AND (m.team1_id = ".$team_id." OR m.team2_id = ".$team_id.") AND m.team1_id = t1.id AND m.team2_id = t2.id ORDER BY m.m_date";
		$db->setQuery($query);
		$matshes = $db->loadObjectList();
		//----
		
		$query = "SELECT * FROM #__bl_players as p LEFT JOIN #__bl_positions as ps ON p.position_id = ps.p_id WHERE p.team_id = ".$team_id." ORDER BY p.position_id,p.first_name,p.last_name";
		$db->setQuery($query);
		$players = $db->loadObjectList();
		
		$query = "SELECT DISTINCT(ev.id),ev.* FROM #__bl_events as ev, #__bl_match_events as me, #__bl_match as m, #__bl_matchday as md WHERE ev.id = me.e_id AND me.match_id = m.id AND m.m_id=md.id AND md.s_id=".$s_id." AND ev.player_event = 1  ORDER BY ev.id";
		$db->setQuery($query);
		$events = $db->loadObjectList();
		
		//- -- CREATE OUTPUT TABLE
		$player_table = array();
		
		$query = "SELECT ef.name FROM #__bl_extra_filds as ef  WHERE ef.published=1 AND ef.type = '0' AND ef.e_table_view = '1' ORDER BY ef.ordering";
		$db->setQuery($query);
		
		$ext_fields_name = $db->loadResultArray();
		
		for($i=0;$i<count($players);$i++){
			if($i == 0){
				$player_table[0][] = JText::_($bl_lang['BL_TBL_PLAYER']);
				$player_table[0][] = JText::_($bl_lang['BL_TBL_POSITION']);
				
				
			}
			$Itemid = JRequest::getInt('Itemid'); 

			$player_table[$i+1][] = "<a href='".JRoute::_('index.php?option=com_joomsport&amp;task=player&amp;id='.$players[$i]->id.'&amp;sid='.$s_id.'&amp;Itemid='.$Itemid)."'>".$players[$i]->first_name.' '.$players[$i]->last_name."</a>";
			$player_table[$i+1][] = $players[$i]->p_name;
			
			
			for($j=0;$j<count($events);$j++){
				if($i==0){
					$ev_tbl = $events[$j]->e_name;
					if($events[$j]->e_img && is_file('media/bearleague/events/'.$events[$j]->e_img)){
						$ev_tbl = '<img src="media/bearleague/events/'.$events[$j]->e_img.'" title="'.$events[$j]->e_name.'" height="20" />';
					}
					$player_table[0][] = $ev_tbl;
				}
				$db->setQuery("SELECT SUM(me.ecount) FROM #__bl_match_events as me, #__bl_match as m, #__bl_matchday as md WHERE me.e_id = ".$events[$j]->id." AND me.player_id = ".$players[$i]->id." AND me.match_id = m.id AND m.m_played = 1 AND md.id=m.m_id AND md.s_id=".$s_id);
				$curcount = $db->loadResult();
				$player_table[$i+1][]  = intval($curcount)?intval($curcount):0;
			}
			if($i == 0){
				if(count($ext_fields_name)){
					$player_table[0] = array_merge($player_table[0],$ext_fields_name);
				}
			}
			$query = "SELECT IF(ev.fvalue <> '',ev.fvalue,'&nbsp;') FROM #__bl_extra_filds as ef LEFT JOIN #__bl_extra_values as ev ON ef.id=ev.f_id AND ev.uid=".$players[$i]->id." WHERE ef.published=1 AND ef.type = '0' AND ef.e_table_view = '1' ORDER BY ef.ordering";
			$db->setQuery($query);
	
			$ext_pl = $db->loadResultArray();
			
			if(count($ext_pl)){
				$player_table[$i+1] = array_merge($player_table[$i+1],$ext_pl);
			}
		}
		
		$query = "SELECT ef.*,ev.fvalue as fvalue FROM #__bl_extra_filds as ef LEFT JOIN #__bl_extra_values as ev ON ef.id=ev.f_id AND ev.uid=".$team_id." WHERE ef.published=1 AND ef.type = '1' ORDER BY ef.ordering";
		$db->setQuery($query);
		$this->ext_fields = $db->loadObjectList();
		
		
		//---language-----------//
		
		$this->assignRef('bl_lang', $bl_lang);
		$this->assignRef('params',		$params); 
		$this->assignRef('team',		$team);
		$this->assignRef('matshes',		$matshes);
		$this->assignRef('def_img',		$def_img);
		$this->assignRef('photos',		$photos);
		$this->assignRef('players',		$player_table);
		$this->assignRef('enbl_extra',$season_par->s_enbl_extra);
		
		parent::display($tpl);
	}
	
	
}
