<?php
/*
http://BearDev.com
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
class mclSeason
{
var $sid;
var $db;

	function __construct($sid, $db)
	{
		$this->sid = $sid;
		$this->db = $db;
	}
	
	function getAdmLinks(){
		$user	=& JFactory::getUser();
		
		$adm_links = '';
		$query = "SELECT s.*,t.name FROM #__users as u, #__bl_feadmins as f, #__bl_seasons as s, #__bl_tournament as t WHERE s.published = '1' AND t.published = '1' AND f.user_id = u.id AND s.s_id = f.season_id AND s.t_id = t.id AND u.id = ".intval($user->id);
		$this->db->setQuery($query);
		
		$sidsss = $this->db->loadObjectList();
		if(count($sidsss)){
			foreach ($sidsss as $adm_sid){
				$adm_links .= '<a href="'.JRoute::_('index.php?option=com_joomsport&view=admin_team&controller=admin&sid='.$adm_sid->s_id).'">'.$adm_sid->name.' '.$adm_sid->s_name.'</a>&nbsp;|&nbsp;';
			}
		}
		return $adm_links;
	}
	
	function getMatchs(){
		$query = "SELECT m.m_date,m.m_time,md.m_name,md.id as mdid, t1.t_name as home, t2.t_name as away, score1,score2,m.is_extra,t1.id as hm_id,t2.id as aw_id, m.m_played, m.id FROM #__bl_matchday as md, #__bl_match as m, #__bl_teams as t1, #__bl_teams as t2 WHERE m.m_id = md.id AND m.published = 1 AND md.s_id=".$this->sid."  AND m.team1_id = t1.id AND m.team2_id = t2.id ORDER BY m.m_date,m.m_time,md.id";
		$this->db->setQuery($query);
    
		return $this->db->loadObjectList();
	}
	
	function getSParametrs(){
		$query = "SELECT * FROM #__bl_seasons WHERE s_id = ".$this->sid;
		$this->db->setQuery($query);
		return $this->db->LoadObject();
	}
	
	function getTeam($tid){
		$query = "SELECT * FROM #__bl_teams WHERE id = ".$tid;
		$this->db->setQuery($query);
		return $this->db->LoadObject();
	}
	
	function getColors(){
		$query = "SELECT * FROM #__bl_tblcolors WHERE s_id=".$this->sid." ORDER BY place";
		$this->db->setQuery($query);
		$colors = $this->db->loadObjectList();
		$color_mass = array();
		for($j=0;$j<count($colors);$j++){
			
			$tmp_pl = $colors[$j]->place;
			$color_mass[intval($colors[$j]->place)] = $colors[$j]->color;
			$tmp_arr = explode(',',$tmp_pl);
			$tmp_arr2 = explode('-',$tmp_pl);
			if(count($tmp_arr)>1){
				foreach ($tmp_arr as $arr){
					if(intval($arr)){
						$color_mass[intval($arr)] = $colors[$j]->color;
					}
				}
			}
			if(count($tmp_arr2)>1){
				for($zzz=$tmp_arr2[0];$zzz<$tmp_arr2[1]+1;$zzz++){
					$color_mass[$zzz] = $colors[$j]->color;
				}
			}
		}
		
		return $color_mass;
	}
	
	function getSOptions($val){
		$query = "SELECT opt_value FROM #__bl_season_option WHERE s_id = ".$this->sid." AND opt_name='".$val."'";
		$this->db->setQuery($query);
		return $this->db->loadResult();
	}
	
}