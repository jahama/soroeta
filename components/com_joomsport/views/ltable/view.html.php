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
require_once(JPATH_ROOT.DS.'components'.DS.'com_joomsport'.DS.'libs'.DS.'season.php');

class bleagueViewltable extends JView
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
		
		$s_id = JRequest::getVar( 'sid', 0, '', 'int' );
		$gr_id = JRequest::getVar( 'gr_id', 0, '', 'int' );
		$calendar = JRequest::getVar( 'calendar', 0, '', 'int' );
		if(!$s_id){
			JError::raiseError( 403, JText::_('Access Forbidden') );
			return; 
		}
		$user	=& JFactory::getUser();
		$db			= & JFactory::getDBO();
		
		$myseas = new mclSeason($s_id, $db);
		$adm_links = $myseas->getAdmLinks();
		
		$query = "SELECT CONCAT(t.name,' ',s.s_name) FROM #__bl_seasons as s, #__bl_tournament as t WHERE t.id = s.t_id AND s.s_id = ".$s_id;
		$db->setQuery($query);
		$p_title = $db->loadResult();
		
		$query = "SELECT * FROM #__bl_seasons as s, #__bl_tournament as t WHERE t.id = s.t_id AND s.published='1' AND t.published='1' AND s.s_id = ".$s_id;
		$db->setQuery($query);
		$curseas = $db->loadObject();
		if(!count($curseas)){
			JError::raiseError( 403, JText::_('Access Forbidden') );
			return;
		}
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
		
		
		// calendar
		if ($calendar){
			$tpl = 'calendar';
		}
		$matchs = $myseas->getMatchs();
		$m = 0;
		if(count($matchs)){
			foreach($matchs as $match){
				$query = "SELECT me.*,ev.*,CONCAT(p.first_name,' ',p.last_name) as p_name,p.team_id FROM #__bl_match_events as me, #__bl_events as ev, #__bl_players as p WHERE me.player_id = p.id AND ev.player_event = '1' AND me.e_id = ev.id AND me.t_id=".$match->hm_id." ORDER BY CAST(me.minutes AS UNSIGNED)";
				$db->setQuery($query);
				//echo mysql_error();die();
				$matchs[$m]->m_events_home = $db->loadObjectList();
				
				$query = "SELECT me.*,ev.*,CONCAT(p.first_name,' ',p.last_name) as p_name,p.team_id FROM #__bl_match_events as me, #__bl_events as ev, #__bl_players as p WHERE me.player_id = p.id AND ev.player_event = '1' AND me.e_id = ev.id AND me.t_id=".$match->aw_id." ORDER BY me.minutes";
				$db->setQuery($query);
				//echo mysql_error();die();
				$matchs[$m]->m_events_away = $db->loadObjectList();
				$m++;
			}
		}
		// table league
		
		$query = "SELECT cfg_value FROM #__bl_config  WHERE cfg_name = 'yteam_color'";
		$db->setQuery($query);
		$teams_your_color = $db->loadResult();
		
		$bonus_not = array();
		
		$season_par = $myseas->getSParametrs();
		$groups_exists = array();	
		$table_view = array();
		$query = "SELECT t.*,st.bonus_point FROM #__bl_season_teams as st, #__bl_teams as t WHERE t.id = st.team_id AND st.season_id = ".$s_id;
		$db->setQuery($query);
		$teams = $db->loadObjectList();
		for ($i=0;$i<count($teams);$i++){
			$tid = $teams[$i]->id;
			$t_par = $myseas->getTeam($tid);
			
			$teams_name = $t_par->t_name;
			
			$query = "SELECT bonus_point FROM #__bl_season_teams WHERE team_id = ".$tid." AND season_id=".$s_id;
			$db->setQuery($query);
			$bonus_point = $db->loadResult();
			
			$teams_your = $t_par->t_yteam;
			
			$query = "SELECT gr.g_id FROM  #__bl_season_teams as st, #__bl_grteams as gr, #__bl_groups as g WHERE g.s_id = ".$s_id." AND g.id = gr.g_id AND gr.t_id = st.team_id AND st.season_id = ".$s_id." AND st.team_id = ".$tid." LIMIT 1";
			$db->setQuery($query);
			$group_id = $db->loadResult();
			if(!in_array($group_id,$groups_exists) && $group_id){
				if($gr_id && $season_par->s_groups){	
					if($gr_id==$group_id){
						$groups_exists[] = $group_id;
					}
				}else{
					$groups_exists[] = $group_id;
				}
				
			}

			$emblems = $t_par->t_emblem;
	
			if($teams[$i]->bonus_point && $teams[$i]->bonus_point != 0.00){
				if(!isset($bonus_not[$group_id]) || !$bonus_not[$group_id]){
					
					$bonus_not[$group_id] = $teams_name." - ".floatval($teams[$i]->bonus_point)."<br />";
				}else{
					$bonus_not[$group_id] .= $teams_name." - ".floatval($teams[$i]->bonus_point)."<br />";
				}
			}
	
			
			/*$query = "SELECT gr.g_id FROM  #__bl_season_teams as st, #__bl_grteams as gr, #__bl_groups as g WHERE g.s_id = ".$s_id." AND g.id = gr.g_id AND gr.t_id = st.team_id AND st.season_id = ".$s_id." AND st.team_id = ".$tid." LIMIT 1";
			$db->setQuery($query);
			$group_id = $db->loadResult();*/
			if(!in_array($group_id,$groups_exists) && $group_id){
				$groups_exists[] = $group_id;
			}
			
			$query = "SELECT SUM(score1) as sc,SUM(score2) as rc FROM #__bl_matchday as md, #__bl_match as m WHERE m.m_id = md.id AND md.s_id = ".$s_id." AND m.published = 1 AND md.is_playoff = 0 AND m.m_played = 1 AND m.team1_id = ".$tid;
			$db->setQuery($query);
			$home = $db->loadObjectList();
			$query = "SELECT SUM(score1) as rc,SUM(score2) as sc FROM #__bl_matchday as md, #__bl_match as m WHERE m.m_id = md.id AND md.s_id = ".$s_id." AND m.published = 1 AND md.is_playoff = 0 AND m.m_played = 1 AND m.team2_id = ".$tid;
			$db->setQuery($query);
			$away = $db->loadObjectList();
			
			$query = "SELECT COUNT(*) FROM #__bl_matchday as md, #__bl_match as m WHERE m.m_id = md.id AND md.s_id = ".$s_id." AND m.published = 1 AND (".$tid." = m.team1_id AND m.score1 > m.score2) AND m.is_extra = 0 AND m.m_played = 1 AND md.is_playoff = 0";
			$db->setQuery($query);
			$wins = $db->loadResult();
			$query = "SELECT COUNT(*) FROM #__bl_matchday as md, #__bl_match as m WHERE m.m_id = md.id AND md.s_id = ".$s_id." AND m.published = 1 AND (".$tid." = m.team1_id) AND m.score1 = m.score2  AND m.m_played = 1 AND md.is_playoff = 0";
			$db->setQuery($query);
			$drows = $db->loadResult();
			$query = "SELECT COUNT(*) FROM #__bl_matchday as md, #__bl_match as m WHERE m.m_id = md.id AND md.s_id = ".$s_id." AND m.published = 1 AND (".$tid." = m.team1_id AND m.score1 < m.score2) AND m.is_extra = 0 AND md.is_playoff = 0 AND m.m_played = 1";
			$db->setQuery($query);
			$loose = $db->loadResult();
			
			$query = "SELECT SUM(bonus1) FROM #__bl_matchday as md, #__bl_match as m WHERE m.m_id = md.id AND md.s_id = ".$s_id." AND m.published = 1 AND ".$tid." = m.team1_id AND md.is_playoff = 0 AND m.m_played = 1";
			$db->setQuery($query);
			$bonus1 = $db->loadResult();
			$query = "SELECT SUM(bonus2) FROM #__bl_matchday as md, #__bl_match as m WHERE m.m_id = md.id AND md.s_id = ".$s_id." AND m.published = 1 AND ".$tid." = m.team2_id AND md.is_playoff = 0 AND m.m_played = 1";
			$db->setQuery($query);
			$bonus2 = $db->loadResult();
			
			$query = "SELECT COUNT(*) FROM #__bl_matchday as md, #__bl_match as m WHERE m.m_id = md.id AND md.s_id = ".$s_id." AND m.published = 1 AND (m.team2_id = ".$tid." AND m.score2 > m.score1) AND m.is_extra = 0 AND m.m_played = 1 AND md.is_playoff = 0";
			$db->setQuery($query);
			$wins_away = $db->loadResult();
			$query = "SELECT COUNT(*) FROM #__bl_matchday as md, #__bl_match as m WHERE m.m_id = md.id AND md.s_id = ".$s_id." AND m.published = 1 AND (".$tid." = m.team2_id) AND m.score1 = m.score2  AND m.m_played = 1 AND md.is_playoff = 0";
			$db->setQuery($query);
			$drows_away = $db->loadResult();
			$query = "SELECT COUNT(*) FROM #__bl_matchday as md, #__bl_match as m WHERE m.m_id = md.id AND md.s_id = ".$s_id." AND m.published = 1 AND (".$tid." = m.team2_id AND m.score2 < m.score1)  AND m.is_extra = 0 AND md.is_playoff = 0 AND m.m_played = 1";
			$db->setQuery($query);
			$loose_away = $db->loadResult();
			
			if($season_par->s_enbl_extra){
				$query = "SELECT COUNT(*) FROM #__bl_matchday as md, #__bl_match as m WHERE m.m_id = md.id AND md.s_id = ".$s_id." AND m.published = 1 AND ((m.team2_id = ".$tid." AND m.score2 > m.score1) OR (".$tid." = m.team1_id AND m.score1 > m.score2)) AND m.is_extra = 1 AND md.is_playoff = 0 AND m.m_played = 1";
				$db->setQuery($query);
				$wins_ext = $db->loadResult();
				
				$query = "SELECT COUNT(*) FROM #__bl_matchday as md, #__bl_match as m WHERE m.m_id = md.id AND md.s_id = ".$s_id." AND m.published = 1 AND ((".$tid." = m.team2_id AND m.score2 < m.score1) OR (".$tid." = m.team1_id AND m.score1 < m.score2)) AND m.is_extra = 1 AND md.is_playoff = 0 AND m.m_played = 1";
				$db->setQuery($query);
				$loose_ext = $db->loadResult();
			}
			

			$table_view[$i]['g_id'] = $season_par->s_groups ? $group_id : 0;
			$table_view[$i]['tid'] = $tid;
			$table_view[$i]['name'] = $teams_name;
			$table_view[$i]['played'] = $wins + $drows + $loose +$wins_away+$drows_away+$loose_away + (($season_par->s_enbl_extra)?($wins_ext + $loose_ext):0);
			$table_view[$i]['win'] = $wins +$wins_away;
			$table_view[$i]['draw'] = $drows+$drows_away;
			$table_view[$i]['lost'] = $loose+$loose_away;
			if($season_par->s_enbl_extra){
				$table_view[$i]['extra_win'] = $wins_ext;
				$table_view[$i]['extra_lost'] = $loose_ext;
			}
			$table_view[$i]['goals'] = ($home[0]->sc + $away[0]->sc).' - '.($home[0]->rc + $away[0]->rc);
			$table_view[$i]['gd'] = ($home[0]->sc + $away[0]->sc) - ($home[0]->rc + $away[0]->rc);
			$table_view[$i]['points'] = $wins * $season_par->s_win_point + $drows * $season_par->s_draw_point + $loose * $season_par->s_lost_point + $wins_away * $season_par->s_win_away + $drows_away * $season_par->s_draw_away + $loose_away * $season_par->s_lost_away + (($season_par->s_enbl_extra)?($wins_ext * $season_par->s_extra_win + $loose_ext * $season_par->s_extra_lost):0) + $bonus_point + $bonus1 + $bonus2;
			$table_view[$i]['goal_score'] = $home[0]->sc + $away[0]->sc;	
			//ob_start();
			$table_view[$i]['yteam'] = $teams_your?$teams_your_color:'';
			if($table_view[$i]['played']){
				$table_view[$i]['winperc'] = ($wins + $wins_away + (( $season_par->s_enbl_extra && isset($wins_ext))?$wins_ext:0) + ($table_view[$i]['draw']/2))/($table_view[$i]['played']);
			}else{
				$table_view[$i]['winperc'] = 0;
			}
			//ob_clean();
			$query = "SELECT ev.fvalue as fvalue FROM #__bl_extra_filds as ef LEFT JOIN #__bl_extra_values as ev ON ef.id=ev.f_id AND ev.uid=".$tid." WHERE ef.published=1 AND ef.type = '1' AND ef.e_table_view = '1' ORDER BY ef.ordering";
			$db->setQuery($query);
	
			$table_view[$i]['ext_fields'] = $db->loadResultArray();
			
			$table_view[$i]['avulka_v'] = '';
			$table_view[$i]['avulka_cf'] = '';
			$table_view[$i]['avulka_cs'] = '';
			$table_view[$i]['avulka_qc'] = '';
			$table_view[$i]['t_emblem'] = $emblems;
			///1.1.3
				$table_view[$i]['goals_score'] = $home[0]->sc + $away[0]->sc;
				$table_view[$i]['goals_conc'] = $home[0]->rc + $away[0]->rc;
				$table_view[$i]['win_home'] = $wins;
				$table_view[$i]['draw_home'] = $drows;
				$table_view[$i]['lost_home'] = $loose;
				$table_view[$i]['win_away'] = $wins_away;
				$table_view[$i]['draw_away'] = $drows_away;
				$table_view[$i]['lost_away'] = $loose_away;
				$table_view[$i]['points_home'] = ($wins) * $season_par->s_win_point + ($drows) * $season_par->s_draw_point + ($loose) * $season_par->s_lost_point + $bonus1;
				$table_view[$i]['points_away'] = ($wins_away) * $season_par->s_win_point + ($drows_away) * $season_par->s_draw_point + ($loose_away) * $season_par->s_lost_point + $bonus2;
			
		}
		
		//---playeachother---///
		$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$s_id." AND opt_name='equalpts_chk'";
		$db->setQuery($query);
		$equalpts_chk = $db->loadResult();
		
		if($equalpts_chk){
			$pts_arr = array();
			$pts_equal = array();
			foreach($table_view as $tv){
				if(!in_array($tv['points'],$pts_arr)){
					$pts_arr[] = $tv['points'];
				}else{
					if(!in_array($tv['points'],$pts_equal)){
						$pts_equal[] = $tv['points'];
					}
				}
			}
			$k = 0;
			$team_arr = array();
			foreach ($pts_equal as $pts){
				foreach($table_view as $tv){
					if($tv['points'] == $pts){
						$team_arr[$k][] = $tv['tid'];
						
					}
				}
				$k++;
			}
			
			foreach ($team_arr as $tm){
				
				foreach ($tm as $tm_one){
					
					$query = "SELECT COUNT(*) FROM #__bl_matchday as md, #__bl_match as m, #__bl_teams as t1, #__bl_teams as t2 WHERE m.m_id = md.id AND m.published = 1 AND md.s_id=".$s_id."  AND m.team1_id = t1.id AND m.team2_id = t2.id AND m.m_played=1 AND ((t1.id = ".$tm_one." AND m.score1>m.score2 AND t2.id IN (".implode(',',$tm).")) OR (t2.id=".$tm_one." AND m.score1<m.score2 AND t1.id IN (".implode(',',$tm).")))";
		
					$db->setQuery($query);
					
					$matchs_avulsa_win = $db->loadResult();
					
					$tm_equal_win = array();
					
					foreach ($tm as $tm_other){
						$query = "SELECT COUNT(*) FROM #__bl_matchday as md, #__bl_match as m, #__bl_teams as t1, #__bl_teams as t2 WHERE m.m_id = md.id AND m.published = 1 AND md.s_id=".$s_id."  AND m.team1_id = t1.id AND m.team2_id = t2.id AND m.m_played=1 AND ((t1.id = ".$tm_other." AND m.score1>m.score2 AND t2.id IN (".implode(',',$tm).")) OR (t2.id=".$tm_other." AND m.score1<m.score2 AND t1.id IN (".implode(',',$tm).")))";
			
						$db->setQuery($query);
						
						$matchs_avulsa_win_other = $db->loadResult();
						
						if($matchs_avulsa_win_other == $matchs_avulsa_win){
							$tm_equal_win[] = $tm_other;
						}
					}
					
					$query = "SELECT SUM(score1) as sh,SUM(score2) as sw FROM #__bl_matchday as md, #__bl_match as m, #__bl_teams as t1, #__bl_teams as t2 WHERE m.m_id = md.id AND m.published = 1 AND m.m_played=1 AND md.s_id=".$s_id."  AND m.team1_id = t1.id AND m.team2_id = t2.id AND ((t1.id = ".$tm_one." AND t2.id IN (".implode(',',$tm_equal_win).")))";
		
					$db->setQuery($query);
				
					$matchs_avulsa_score = $db->loadRow();
					//var_dump($matchs_avulsa_score);
					
					$query = "SELECT SUM(score2) as sh,SUM(score1) as sw FROM #__bl_matchday as md, #__bl_match as m, #__bl_teams as t1, #__bl_teams as t2 WHERE m.m_id = md.id AND m.published = 1 AND m.m_played=1 AND md.s_id=".$s_id."  AND m.team1_id = t1.id AND m.team2_id = t2.id AND ((t2.id=".$tm_one." AND t1.id IN (".implode(',',$tm_equal_win).")))";
		
					$db->setQuery($query);
				
					$matchs_avulsa_rec = $db->loadRow();
					
					 $matchs_avulsa_res = intval($matchs_avulsa_score[0]) + intval($matchs_avulsa_rec[0]);
					 $matchs_avulsa_res2 = intval($matchs_avulsa_score[1]) + intval($matchs_avulsa_rec[1]);
					

					for ($b=0;$b<count($table_view);$b++){
						if($table_view[$b]['tid']==$tm_one){
							$table_view[$b]['avulka_v'] = $matchs_avulsa_win;
							$table_view[$b]['avulka_cf'] = $matchs_avulsa_res;
							$table_view[$b]['avulka_cs'] = $matchs_avulsa_res2;
							$table_view[$b]['avulka_qc'] = $matchs_avulsa_res-$matchs_avulsa_res2;
						}
					}
				}	
			}
		}	
		//--/playeachother---///
		
		$sort_arr = array();
		 foreach($table_view AS $uniqid => $row){
	        foreach($row AS $key=>$value){
	            $sort_arr[$key][$uniqid] = $value;
	        }
	    }
	   if(count($groups_exists)){
	   	$query = "SELECT id FROM #__bl_groups WHERE id IN (".implode(',',$groups_exists).") ORDER BY ordering";
		$db->setQuery($query);
		$groups_exists = $db->loadResultArray();
		
		//sort($groups_exists, SORT_NUMERIC);
	   }
	  	if(!$season_par->s_groups){
	  		$groups_exists = array(0);
	  	}
		if(count($sort_arr)){
			// sort fields 1-points, 2-wins percent, /*3-if equal between teams*/, 4-goal difference, 5-goal score
			$query = "SELECT * FROM #__bl_ranksort WHERE seasonid=".$s_id." ORDER BY ordering";
			$db->setQuery($query);
			$savedsort = $db->loadObjectList();
			$argsort = array();
			if(count($savedsort)){
				foreach($savedsort as $sortop){
					switch($sortop->sort_field){
						case '1': $argsort[][0] = $sort_arr['points'];		break;
						case '2': $argsort[][0] = $sort_arr['winperc'];		break;
						case '3': $argsort[][0] = $sort_arr['points'];		break; /* not used */
						case '4': $argsort[][0] = $sort_arr['gd'];			break;
						case '5': $argsort[][0] = $sort_arr['goal_score'];	break;
					}
					
					$argsort[][1] = $sortop->sort_way;
				}
			}
			//var_dump($argsort);
			if($equalpts_chk){
				//var_dump($sort_arr['avulka_v']);
				array_multisort($sort_arr['g_id'], SORT_ASC,$sort_arr['points'], SORT_DESC,$sort_arr['avulka_v'], SORT_DESC,$sort_arr['avulka_qc'],SORT_DESC,$sort_arr['avulka_cf'],SORT_DESC,$sort_arr['gd'], SORT_DESC,$sort_arr['goal_score'], SORT_DESC, $table_view);
			
			}else{
			
			
				array_multisort($sort_arr['g_id'], SORT_ASC,(isset($argsort[0][0])?$argsort[0][0]:$sort_arr['points']), (isset($argsort[0][1])?($argsort[0][1]?SORT_ASC:SORT_DESC):SORT_DESC),(isset($argsort[1][0])?$argsort[1][0]:$sort_arr['gd']), (isset($argsort[1][1])?($argsort[1][1]?SORT_ASC:SORT_DESC):SORT_DESC),(isset($argsort[2][0])?$argsort[2][0]:$sort_arr['goal_score']), (isset($argsort[2][1])?($argsort[2][1]?SORT_ASC:SORT_DESC):SORT_DESC), $table_view);
			}
		}
		$query = "SELECT m.*,m.id as mid,t.t_name as home, t2.t_name as away, md.m_name, m.is_extra FROM #__bl_matchday as md, #__bl_match as m, #__bl_teams as t, #__bl_teams as t2  WHERE  m.m_id = md.id AND md.s_id = ".$s_id." AND m.published = 1 AND md.is_playoff = 1 AND t.id = m.team1_id AND t2.id = m.team2_id AND m.m_played = 1  ORDER BY md.id,m.id";
		$db->setQuery($query);
		$playoffs = $db->loadObjectList();
	    
		$query = "SELECT group_name FROM #__bl_groups WHERE id IN (".implode(',',$groups_exists).") ORDER BY ordering";
		$db->setQuery($query);
		$group_name = $db->loadResultArray();
	    //$table_view = $this->php_multisort($table_view, array(array('key'=>'points')));
		//var_dump($table_view);
		

	$lists['win_chk'] = $myseas->getSOptions('win_chk');
	
	$lists['lost_chk'] = $myseas->getSOptions('lost_chk');
	
	$lists['draw_chk'] = $myseas->getSOptions('draw_chk');

	$lists['otwin_chk'] = $myseas->getSOptions('otwin_chk');
	
	$lists['otlost_chk'] = $myseas->getSOptions('otlost_chk');
	
	$lists['diff_chk'] = $myseas->getSOptions('diff_chk');

	$lists['gd_chk'] = $myseas->getSOptions('gd_chk');

	$lists['point_chk'] = $myseas->getSOptions('point_chk');

	$lists['percent_chk'] = $myseas->getSOptions('percent_chk');
	
	$lists['played_chk'] = $myseas->getSOptions('played_chk');
	
	$lists['emblem_chk'] = $myseas->getSOptions('emblem_chk');
	$lists['goalscore_chk'] = $myseas->getSOptions('goalscore_chk');
	$lists['goalconc_chk'] = $myseas->getSOptions('goalconc_chk');
	$lists['winhome_chk'] = $myseas->getSOptions('winhome_chk');
	$lists['winaway_chk'] = $myseas->getSOptions('winaway_chk');
	$lists['drawhome_chk'] = $myseas->getSOptions('drawhome_chk');
	$lists['drawaway_chk'] = $myseas->getSOptions('drawaway_chk');
	$lists['losthome_chk'] = $myseas->getSOptions('losthome_chk');
	$lists['lostaway_chk'] = $myseas->getSOptions('lostaway_chk');
	$lists['pointshome_chk'] = $myseas->getSOptions('pointshome_chk');
	$lists['pointsaway_chk'] = $myseas->getSOptions('pointsaway_chk');
	
	$query = "SELECT ef.name FROM #__bl_extra_filds as ef  WHERE ef.published=1 AND ef.type = '1' AND ef.e_table_view = '1' ORDER BY ef.ordering";
	$db->setQuery($query);
	
	$ext_fields_name = $db->loadResultArray();
	
	
		//----colors----//
	
	$color_mass = $myseas->getColors();
	///moderate///
	$query = "SELECT t.id FROM #__bl_teams as t, #__bl_moders as m WHERE m.tid=t.id AND m.uid=".$user->id." ORDER BY t.t_name";

	$db->setQuery($query);

	$teams_season = $db->loadResultArray();
	
	$bonus_not = (isset($bonus_not)?$bonus_not:'');
	//---language-----------//
	require_once(JPATH_ROOT.DS.'components'.DS.'com_joomsport'.DS.'bl_lang.php');
		
		$this->assignRef('bl_lang', $bl_lang);
		$this->assignRef('params',		$params); 
		$this->assignRef('v_table', $table_view); 
		$this->assignRef('sid', $s_id);
		$this->assignRef('groups', $groups_exists);
		$this->assignRef('groups_name', $group_name);
		$this->assignRef('playoffs', $playoffs);
		$this->assignRef('enbl_extra',$season_par->s_enbl_extra);
		$this->assignRef('enbl_gr',$season_par->s_groups);
		$this->assignRef('lists', $lists);
		
		$this->assignRef('ext_fields_name',$ext_fields_name);
		
		$this->assignRef('matchs', $matchs);
		
		$this->assignRef('colors', $color_mass);
		
		$this->assignRef('adm_links', $adm_links);
		$this->assignRef('teams_season', $teams_season);
		$this->assignRef('curseas', $curseas);
		$this->assignRef('gr_id', $gr_id);
		$this->assignRef('bonus_not', $bonus_not);
		parent::display($tpl);
	}
	
	
}
