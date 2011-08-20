<?php
/*
http://BearDev.com
 */

function joomsportBuildRoute(&$query)
{
	$segments = array();

	if(isset($query['view']))
	{
		$segments[] = $query['view'];
		unset($query['view']);
	}elseif (isset($query['task'])){
		$segments[] = $query['task'];
		unset($query['task']);
	}
	if(isset($query['sid']))
	{
		$segments[] = $query['sid'];
		unset($query['sid']);
	};
	if(isset($query['tid']))
	{
		$segments[] = $query['tid'];
		unset($query['tid']);
	};
	if(isset($query['id']))
	{
		$segments[] = $query['id'];
		unset($query['id']);
	};
	if(isset($query['controller']))
	{
		$segments[] = $query['controller'];
		unset($query['controller']);
	};
	if(isset($query['cid'][0]))
	{
		$segments[] = $query['cid'][0];
		unset($query['cid']);
	};
	if(isset($query['mid']))
	{
		$segments[] = $query['mid'];
		unset($query['mid']);
	};
	
	return $segments;
}

function joomsportParseRoute($segments)
{
	$vars = array();
	
	switch($segments[0])
	{
		case 'ltable':
		$vars['view'] = 'ltable';
		break;
		case 'team':
		$vars['view'] = 'blteam';
		$id = explode(':', $segments[1]);
		$vars['sid'] = (int)$id[0];
		$id = explode(':', $segments[2]);
		$vars['tid'] = (int)$id[0];
		break;
		case 'player':
		$vars['view'] = 'player';
		$id = explode(':', $segments[1]);
		$vars['sid'] = (int)$id[0];
		$id = explode(':', $segments[2]);
		$vars['id'] = (int)$id[0];
		break;
		case 'calendar':
			$vars['view'] = 'calendar';
			
			$id = explode(':', $segments[1]);
			$vars['sid'] = (int)$id[0];
		break;
		case 'view_match':
		$vars['view'] = 'match';
		$id = explode(':', $segments[1]);
		$vars['id'] = (int)$id[0];
		break;
		case 'admin_team':
			$vars['view'] = 'admin_team';
			$vars['controller']='admin';
			$id = explode(':', $segments[1]);
			$vars['sid'] = (int)$id[0];
		break;
		case 'admin_player':
			$vars['view'] = 'admin_player';
			$vars['controller']='admin';
			$id = explode(':', $segments[1]);
			$vars['sid'] = (int)$id[0];
			
		break;
		case 'admin_matchday':
			$vars['view'] = 'admin_matchday';
			$vars['controller']='admin';
			$id = explode(':', $segments[1]);
			$vars['sid'] = (int)$id[0];
			
		break;
		case 'team_edit':
			$vars['view'] = 'edit_team';
			$vars['controller']='admin';
			$id = explode(':', $segments[1]);
			$vars['sid'] = (int)$id[0];
			$id = explode(':', $segments[3]);
			$vars['cid'][0] = (int)$id[0];
			
		break;
		case 'player_edit':
			$vars['view'] = 'edit_player';
			$vars['controller']='admin';
			$id = explode(':', $segments[1]);
			$vars['sid'] = (int)$id[0];
			$id = explode(':', $segments[3]);
			$vars['cid'][0] = (int)$id[0];
			
		break;
		case 'matchday_edit':
			$vars['view'] = 'edit_matchday';
			$vars['controller']='admin';
			$id = explode(':', $segments[1]);
			$vars['sid'] = (int)$id[0];
			$id = explode(':', $segments[3]);
			$vars['cid'][0] = (int)$id[0];
			
		break;
		case 'match_edit':
			$vars['view'] = 'edit_match';
			$vars['controller']='admin';
			$id = explode(':', $segments[1]);
			$vars['sid'] = (int)$id[0];
			$id = explode(':', $segments[3]);
			$vars['cid'][0] = (int)$id[0];
			
		break;
		case 'edit_team':
			$vars['view'] = 'moderedit_team';
			$vars['controller']='moder';
			$id = explode(':', $segments[1]);
			$vars['sid'] = (int)$id[0];
			$id = explode(':', $segments[2]);
			$vars['tid'] = (int)$id[0];
			
		break;
		case 'madmin_player':
			$vars['view'] = 'moderadmin_player';
			$vars['controller']='moder';
			$id = explode(':', $segments[1]);
			$vars['sid'] = (int)$id[0];
			$id = explode(':', $segments[2]);
			$vars['tid'] = (int)$id[0];
			
		break;
		
		case 'mplayer_edit':
			$vars['view'] = 'moderedit_player';
			$vars['controller']='moder';
			$id = explode(':', $segments[1]);
			$vars['sid'] = (int)$id[0];
			$id = explode(':', $segments[2]);
			$vars['tid'] = (int)$id[0];
			$id = explode(':', $segments[4]);
			$vars['cid'][0] = (int)$id[0];
			
		break;
		case 'matchday_medit':
			$vars['view'] = 'moderedit_matchday';
			$vars['controller']='moder';
			
				$id = explode(':', $segments[3]);
				$vars['mid'] = (int)$id[0];

				$id = explode(':', $segments[1]);

				$vars['sid'] = (int)$id[0];
				$id = explode(':', $segments[2]);
				$vars['tid'] = (int)$id[0];
			
			
		break;
		case 'match_medit':
			$vars['view'] = 'moderedit_match';
			$vars['controller']='moder';
			$id = explode(':', $segments[1]);
			$vars['sid'] = (int)$id[0];
			$id = explode(':', $segments[2]);
			$vars['tid'] = (int)$id[0];
			$id = explode(':', $segments[4]);
			$vars['cid'][0] = (int)$id[0];
			
		break;
		case 'ltable':
				$vars['view'] = 'ltable';
				$id = explode(':', $segments[1]);
				$vars['sid'] = (int)$id[0];
		break;		
		default:
			
				$vars['view'] = 'ltable';
				$id = explode(':', $segments[0]);
				$vars['sid'] = (int)$id[0];
			
			
		
	}
	return $vars;
}
