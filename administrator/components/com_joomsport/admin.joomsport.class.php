<?php
/*
http://BearDev.com
 */
class JTableTourn extends JTable
{
	var $id				= null;
	var $name 			= null;
	var $descr			= null;
	var $published			= null;
	var $logo			= null;
	
	function __construct( &$db )
	{
		parent::__construct( '#__bl_tournament', 'id', $db );
	}
}
class JTableSeason extends JTable
{
	var $s_id				= null;
	var $s_name 			= null;
	var $s_descr			= null;
	var $published			= null;
	var $s_rounds			= null;
	var $t_id				= null;
	var $s_win_point		= null;
	var $s_lost_point		= null;
	var $s_enbl_extra		= null;
	var $s_extra_win		= null;
	var $s_extra_lost		= null;
	var $s_draw_point		= null;
	var $s_groups			= null;
	var $s_win_away			= null;
	var $s_draw_away		= null;
	var $s_lost_away		= null;
	
	function __construct( &$db )
	{
		parent::__construct( '#__bl_seasons', 's_id', $db );
	}
}
class JTableTeams extends JTable
{
	var $id					= null;
	var $t_name 			= null;
	var $t_descr			= null;
	var $t_yteam			= null;
	var $def_img			= null;
	var $t_emblem			= null;
	var $t_city				= null;
	
	function __construct( &$db )
	{
		parent::__construct( '#__bl_teams', 'id', $db );
	}
}
class JTablePos extends JTable
{
	var $p_id				= null;
	var $p_name 			= null;
	
	function __construct( &$db )
	{
		parent::__construct( '#__bl_positions', 'p_id', $db );
	}
}
class JTablePlayer extends JTable
{
	var $id						= null;
	var $first_name 			= null;
	var $last_name 				= null;
	var $nick 					= null;
	var $about 					= null;
	var $position_id 			= null;
	var $def_img 				= null;
	var $team_id				= null;
	
	function __construct( &$db )
	{
		parent::__construct( '#__bl_players', 'id', $db );
	}
}
class JTablePhotos extends JTable
{
	var $id						= null;
	var $ph_name 				= null;
	var $ph_filename 			= null;
	var $ph_descr 				= null;
	
	function __construct( &$db )
	{
		parent::__construct( '#__bl_photos', 'id', $db );
	}
}
class JTableMday extends JTable
{
	var $id						= null;
	var $m_name 				= null;
	var $m_descr 				= null;
	var $s_id					= null;
	var $is_playoff				= null;
	
	function __construct( &$db )
	{
		parent::__construct( '#__bl_matchday', 'id', $db );
	}
}
class JTableMatch extends JTable
{
	var $id						= null;
	var $m_id 					= null;
	var $team1_id 				= null;
	var $team2_id				= null;
	var $score1 				= null;
	var $score2 				= null;
	var $match_descr			= null;
	var $published				= null;
	var $is_extra				= null;
	var $m_played				= null;
	var $m_date					= null;
	var $m_time					= null;
	
	var $m_location				= null;
	
	var $bonus1					= null;
	var $bonus2					= null;
	
	function __construct( &$db )
	{
		parent::__construct( '#__bl_match', 'id', $db );
	}
}
class JTableEvents extends JTable
{
	var $id						= null;
	var $e_name 				= null;
	var $e_img					= null;
	var $e_descr				= null;
	var $player_event			= null;
	
	function __construct( &$db )
	{
		parent::__construct( '#__bl_events', 'id', $db );
	}
}
class JTableGroups extends JTable
{
	var $id						= null;
	var $group_name				= null;
	var $s_id					= null;
	var $ordering				= null;
	
	function __construct( &$db )
	{
		parent::__construct( '#__bl_groups', 'id', $db );
	}
}
class JTableFields extends JTable
{
	var $id						= null;
	var $name					= null;
	var $published				= null;
	var $type					= null;
	var $ordering				= null;
	var $e_table_view			= null;
	
	function __construct( &$db )
	{
		parent::__construct( '#__bl_extra_filds', 'id', $db );
	}
}
class JTableLang extends JTable
{
	var $id						= null;
	var $lang_file				= null;
	var $is_default				= null;
	
	function __construct( &$db )
	{
		parent::__construct( '#__bl_languages', 'id', $db );
	}
	
	function check() {
		$db			=& JFactory::getDBO();
		$query = "SELECT lang_file FROM #__bl_languages WHERE id = '".$this->id."'";
		$db->SetQuery( $query );
		$old_name = $db->LoadResult();
		if (isset($old_name) && $old_name == 'default') {
			$this->setError('Could not modify DEFAULT Language');
			return false;
		} 
		$query = "SELECT count(*) FROM #__bl_languages WHERE id <> '".$this->id."' and lang_file = '".$this->lang_file."'";
		$db->SetQuery( $query );
		$items_count = $db->LoadResult();
		if ($items_count > 0) {
			$this->setError('This name for Language is already exist');
			return false;
		} 
		if ((trim($this->lang_file == '')) || (preg_match("/[0-9a-z]/", $this->lang_file ) == false)) {
			$this->setError('Please enter valid Language name');
			return false;
		} 
		return true;
	}
}
?>