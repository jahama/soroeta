<?php
defined('_JEXEC') or die( 'Restricted access' );
jimport('joomla.application.component.controller');
$doc =& JFactory::getDocument();
$mainframe = JFactory::getApplication();
$doc->addCustomTag( '<link rel="stylesheet" type="text/css"  href="components/com_joomsport/css/admin_bl.css" />' );
$doc->addCustomTag( '<link rel="stylesheet" type="text/css"  href="components/com_joomsport/css/joomsport.css" />' );
require_once('components/com_joomsport/includes/func.php');
?>
<?php
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomsport'.DS.'admin.joomsport.class.php');
$db			=& JFactory::getDBO();
$user	=& JFactory::getUser();
 $sid = JRequest::getVar( 'sid', 0, 'request', 'int' );
	 $tid = JRequest::getVar( 'tid', 0, 'request', 'int' );
	
	if ( $user->get('guest')) {
		$return_url = $_SERVER['REQUEST_URI'];
			$return_url = base64_encode($return_url);
			
			if(getVer() == '1.6'){
				$uopt = "com_users";
			}else{
				$uopt = "com_user";
			}
			$return	= 'index.php?option='.$uopt.'&view=login&return='.$return_url;

			// Redirect to a login form
			$mainframe->redirect( $return, JText::_('JERROR_LOGIN_DENIED') );

	} 
	
	$query = "SELECT COUNT(*) FROM #__bl_teams as t, #__bl_moders as m WHERE m.tid=t.id AND m.uid=".$user->id." AND t.id=".$tid." ORDER BY t.t_name";
		$db->setQuery($query);
	
		
	if(!$db->loadResult()){
		JError::raiseError( 403, JText::_('Access Forbidden') );
			return;
	}
	
	$query = "SELECT t.id,t.t_name FROM #__bl_teams as t, #__bl_moders as m WHERE m.tid=t.id AND m.uid=".$user->id." ORDER BY t.t_name";
	$db->setQuery($query);
	$Itemid = JRequest::getInt('Itemid'); 
	$m_teams = $db->loadObjectList();
	$javascript = "onchange='document.chg_team.submit();'";
	echo "<form action='/index.php?option=com_joomsport&task=team_edit&controller=moder&Itemid=".$Itemid."&sid=".$sid."' method='post' name='chg_team'>";
	echo $lists['tm_filtr'] = JHTML::_('select.genericlist',   $m_teams, 'tid', 'class="inputbox" size="1"'.$javascript, 'id', 't_name', $tid );
	echo "</form>";
	
class BLeagueControllerModer extends JController
{
	/**
	 * Method to display a view
	 *
	 * @access	public
	 * @since	1.5
	 */
	
	
	
	
	function display()
	{
		$view = JRequest::getCmd( 'view' );
		if(!$view) {
			$view = 'moderedit_team';
		}
		JRequest::setVar( 'view', $view );
		parent::display();
	}
	
	
	function team_edit()
	{
		JRequest::setVar( 'view', 'moderedit_team' );
		JRequest::setVar( 'edit', true );
		parent::display();
	}
	
	function team_save(){
		$mainframe = JFactory::getApplication();
		$Itemid = JRequest::getInt('Itemid'); 

		$db			=& JFactory::getDBO();
	
		$msg = '';
	
		$post		= JRequest::get( 'post' );
	
		$post['t_descr'] = JRequest::getVar( 't_descr', '', 'post', 'string', JREQUEST_ALLOWRAW );
	
		$post['def_img'] = JRequest::getVar( 'ph_default', 0, 'post', 'int' );
		$sid = JRequest::getVar( 'sid', 0, 'post', 'int' );
		
		$row 	= new JTableTeams($db);
		$istlogo = JRequest::getVar( 'istlogo', 0, 'post', 'int' );
	
		if(!$istlogo){
			$post['t_emblem'] = '';
		}
	
		if(isset($_FILES['t_logo']['name']) && $_FILES['t_logo']['tmp_name'] != '' && isset($_FILES['t_logo']['tmp_name'])){
	
			$bl_filename = strtolower($_FILES['t_logo']['name']);
	
			$ext = pathinfo($_FILES['t_logo']['name']);
			$bl_filename = "bl".time().rand(0,3000).'.'.$ext['extension'];
	
			$bl_filename = str_replace(" ","",$bl_filename);
	
			//echo $bl_filename;
			
			 if($this->uploadFile($_FILES['t_logo']['tmp_name'], $bl_filename)){
	
			 	$post['t_emblem'] = $bl_filename;
	
			 }
	
		}
	
		
	
		if (!$row->bind( $post )) {
	
			JError::raiseError(500, $row->getError() );
	
		}
		
	
		if(!$row->id){
			die();
		}
	
		if (!$row->check()) {
	
			JError::raiseError(500, $row->getError() );
	
		}
	
		// if new item order last in appropriate group
	
		
	
		if (!$row->store()) {
	
			JError::raiseError(500, $row->getError() );
	
		}
	
		$row->checkin();
	
		
	
		$query = "DELETE FROM #__bl_assign_photos WHERE cat_type = 2 AND cat_id = ".$row->id;
	
		$db->setQuery($query);
	
		$db->query();
	
		if(isset($_POST['photos_id']) && count($_POST['photos_id'])){
	
			for($i = 0; $i < count($_POST['photos_id']); $i++){
	
				$photo_id = intval($_POST['photos_id'][$i]);
	
				$photo_name = addslashes(strval($_POST['ph_names'][$i]));
	
				$query = "INSERT INTO #__bl_assign_photos(photo_id,cat_id,cat_type) VALUES(".$photo_id.",".$row->id.",2)";
	
			 	$db->setQuery($query);
	
				$db->query();
	
				
	
				$query = "UPDATE #__bl_photos SET ph_name = '".($photo_name)."' WHERE id = ".$photo_id;
	
				$db->setQuery($query);
	
				$db->query();
	
			}
	
		}
	
	
	
		if(isset($_FILES['player_photo_1']['name']) && $_FILES['player_photo_1']['tmp_name'] != '' && isset($_FILES['player_photo_1']['tmp_name'])){
			
			$bl_filename = strtolower($_FILES['player_photo_1']['name']);
	
			$ext = pathinfo($_FILES['player_photo_1']['name']);
			$bl_filename = "bl".time().rand(0,3000).'.'.$ext['extension'];
	
			$bl_filename = str_replace(" ","",$bl_filename);
	
			//echo $bl_filename;
	
			 if($this->uploadFile($_FILES['player_photo_1']['tmp_name'], $bl_filename)){
	
			 	$post1['ph_filename'] = $bl_filename;
	
				
	
				$img1 = new JTablePhotos($db);
	
				$img1->id = 0;
	
				if (!$img1->bind( $post1 )) {
	
					JError::raiseError(500, $img1->getError() );
	
				}
	
				if (!$img1->check()) {
	
					JError::raiseError(500, $img1->getError() );
	
				}
	
				// if new item order last in appropriate group
	
				
	
				if (!$img1->store()) {
	
					JError::raiseError(500, $img1->getError() );
	
				}
	
				$img1->checkin();
	
				
	
				$query = "INSERT INTO #__bl_assign_photos(photo_id,cat_id,cat_type) VALUES(".$img1->id.",".$row->id.",2)";
	
			 	$db->setQuery($query);
	
				$db->query();
	
			 }
		}
	
		if(isset($_FILES['player_photo_2']['name']) && $_FILES['player_photo_2']['tmp_name'] != ''  && isset($_FILES['player_photo_2']['tmp_name'])){
	
			 $bl_filename = strtolower($_FILES['player_photo_2']['name']);
	
			$ext = pathinfo($_FILES['player_photo_2']['name']);
			$bl_filename = "bl".time().rand(0,3000).'.'.$ext['extension'];
	
			$bl_filename = str_replace(" ","",$bl_filename);
			
			
			 if($this->uploadFile($_FILES['player_photo_2']['tmp_name'], $bl_filename)){
	
			 	$post2['ph_filename'] = $bl_filename;
	
				
	
				$img2 = new JTablePhotos($db);
	
				$img2->id = 0;
	
				if (!$img2->bind( $post2 )) {
	
					JError::raiseError(500, $img2->getError() );
	
				}
	
				if (!$img2->check()) {
	
					JError::raiseError(500, $img2->getError() );
	
				}
	
				// if new item order last in appropriate group
	
				
	
				if (!$img2->store()) {
	
					JError::raiseError(500, $img2->getError() );
	
				}
	
				$img2->checkin();
	
				
	
				$query = "INSERT INTO #__bl_assign_photos(photo_id,cat_id,cat_type) VALUES(".$img2->id.",".$row->id.",2)";
	
			 	$db->setQuery($query);
	
				$db->query();
	
			 }
	
		}
		
		//---season-------
		/*$sid = JRequest::getVar( 'sid', 0, 'post', 'int' );
		$query = "INSERT INTO #__bl_season_teams(season_id,team_id) VALUES(".$sid.",".$row->id.")";
		$db->setQuery($query);
		$db->query();*/
		
		
		//-------extra fields-----------//
	
	
	
		if(isset($_POST['extraf']) && count($_POST['extraf'])){
	
			for($p=0;$p<count($_POST['extraf']);$p++){
	
				$query = "DELETE FROM #__bl_extra_values WHERE f_id = ".$_POST['extra_id'][$p]." AND uid = ".$row->id;
	
				$db->setQuery($query);
	
				$db->query();
	
				$query = "INSERT INTO #__bl_extra_values(f_id,uid,fvalue) VALUES(".$_POST['extra_id'][$p].",".$row->id.",'".$_POST['extraf'][$p]."')";
	
				$db->setQuery($query);
	
				$db->query();
	
			}
	
		}
		
		//--------------//
		/*$query = "INSERT INTO #__bl_season_teams(season_id,team_id) VALUES(".$row->s_id.",".$row->id.")";
		$db->setQuery($query);
		$db->query();*/
		
		//$s_id = JRequest::getVar( 'sid', 0, '', 'int' );
		
			$link = "index.php?option=com_joomsport&controller=moder&task=edit_team&sid=".$sid."&tid=".$row->id."&Itemid=".$Itemid;
		
		
		$this->setRedirect($link);
	}
	
	
	///---------------Players--------------------------/
	function madmin_player()
	{
		JRequest::setVar( 'view', 'moderadmin_player' );
		parent::display();
	}
	function mplayer_edit()
	{
		JRequest::setVar( 'view', 'moderedit_player' );
		JRequest::setVar( 'edit', true );
		parent::display();
	}
	
	function player_add()
	{
		JRequest::setVar( 'view', 'moderedit_player' );
		JRequest::setVar( 'edit', false );
		unset($_REQUEST['cid']);
		parent::display();
	}
	
	function player_apply(){
		$this->player_save(1);
	}
	
	function player_save($apl = 0){
		$mainframe = JFactory::getApplication();
		$Itemid = JRequest::getInt('Itemid'); 
	
		$db			=& JFactory::getDBO();
	
		$msg = '';
	
		$post		= JRequest::get( 'post' );
	
		$post['about'] = JRequest::getVar( 'about', '', 'post', 'string', JREQUEST_ALLOWRAW );
	
		$post['def_img'] = JRequest::getVar( 'ph_default', 0, 'post', 'int' ); 
		$sid = JRequest::getVar( 'sid', 0, 'post', 'int' ); 
	
		$row 	= new JTablePlayer($db);
	
		$row->team_id = JRequest::getVar( 'tid', 0, '', 'int' );	
	
	
	
		if (!$row->bind( $post )) {
	
			JError::raiseError(500, $row->getError() );
	
		}
	
		if (!$row->check()) {
	
			JError::raiseError(500, $row->getError() );
	
		}
	
		// if new item order last in appropriate group
	
		
	
		if (!$row->store()) {
	
			JError::raiseError(500, $row->getError() );
	
		}
	
		$row->checkin();
	
		
	
		$query = "DELETE FROM #__bl_assign_photos WHERE cat_type = 1 AND cat_id = ".$row->id;
	
		$db->setQuery($query);
	
		$db->query();
	
		if(isset($_POST['photos_id']) && count($_POST['photos_id'])){
	
			for($i = 0; $i < count($_POST['photos_id']); $i++){
	
				$photo_id = intval($_POST['photos_id'][$i]);
	
				$photo_name = addslashes(strval($_POST['ph_names'][$i]));
	
				$query = "INSERT INTO #__bl_assign_photos(photo_id,cat_id,cat_type) VALUES(".$photo_id.",".$row->id.",1)";
	
			 	$db->setQuery($query);
	
				$db->query();
	
				
	
				$query = "UPDATE #__bl_photos SET ph_name = '".($photo_name)."' WHERE id = ".$photo_id;
	
				$db->setQuery($query);
	
				$db->query();
	
			}
	
		}
	
	
	
		if(isset($_FILES['player_photo_1']['name']) && $_FILES['player_photo_1']['tmp_name'] != '' && isset($_FILES['player_photo_1']['tmp_name'])){
	
			$bl_filename = strtolower($_FILES['player_photo_1']['name']);
	
			$ext = pathinfo($_FILES['player_photo_1']['name']);
			$bl_filename = "bl".time().rand(0,3000).'.'.$ext['extension'];
	
			$bl_filename = str_replace(" ","",$bl_filename);
	
			 if($this->uploadFile($_FILES['player_photo_1']['tmp_name'], $bl_filename)){
	
			 	$post1['ph_filename'] = $bl_filename;
	
				
	
				$img1 = new JTablePhotos($db);
	
				$img1->id = 0;
	
				if (!$img1->bind( $post1 )) {
	
					JError::raiseError(500, $img1->getError() );
	
				}
	
				if (!$img1->check()) {
	
					JError::raiseError(500, $img1->getError() );
	
				}
	
				// if new item order last in appropriate group
	
				
	
				if (!$img1->store()) {
	
					JError::raiseError(500, $img1->getError() );
	
				}
	
				$img1->checkin();
	
				
	
				$query = "INSERT INTO #__bl_assign_photos(photo_id,cat_id,cat_type) VALUES(".$img1->id.",".$row->id.",1)";
	
			 	$db->setQuery($query);
	
				$db->query();
	
			 
			}
	
		}
	
		if(isset($_FILES['player_photo_2']['name']) && $_FILES['player_photo_2']['tmp_name'] != ''  && isset($_FILES['player_photo_2']['tmp_name'])){
	
			 $bl_filename = strtolower($_FILES['player_photo_2']['name']);
	
			$ext = pathinfo($_FILES['player_photo_2']['name']);
			$bl_filename = "bl".time().rand(0,3000).'.'.$ext['extension'];
	
			$bl_filename = str_replace(" ","",$bl_filename);
	
			 if($this->uploadFile($_FILES['player_photo_2']['tmp_name'], $bl_filename)){
	
			 	$post2['ph_filename'] = $bl_filename;
	
				
	
				$img2 = new JTablePhotos($db);
	
				$img2->id = 0;
	
				if (!$img2->bind( $post2 )) {
	
					JError::raiseError(500, $img2->getError() );
	
				}
	
				if (!$img2->check()) {
	
					JError::raiseError(500, $img2->getError() );
	
				}
	
				// if new item order last in appropriate group
	
				
	
				if (!$img2->store()) {
	
					JError::raiseError(500, $img2->getError() );
	
				}
	
				$img2->checkin();
	
				
	
				$query = "INSERT INTO #__bl_assign_photos(photo_id,cat_id,cat_type) VALUES(".$img2->id.",".$row->id.",1)";
	
			 	$db->setQuery($query);
	
				$db->query();
	
			 }
	
		}
	
		//-------extra fields-----------//
	
	
	
		if(isset($_POST['extraf']) && count($_POST['extraf'])){
	
			for($p=0;$p<count($_POST['extraf']);$p++){
	
				$query = "DELETE FROM #__bl_extra_values WHERE f_id = ".$_POST['extra_id'][$p]." AND uid = ".$row->id;
	
				$db->setQuery($query);
	
				$db->query();
	
				$query = "INSERT INTO #__bl_extra_values(f_id,uid,fvalue) VALUES(".$_POST['extra_id'][$p].",".$row->id.",'".$_POST['extraf'][$p]."')";
	
				$db->setQuery($query);
	
				$db->query();
	
			}
	
		}
		if($apl){
			$link = "index.php?option=com_joomsport&controller=moder&task=mplayer_edit&cid[]=".$row->id."&tid=".$row->team_id.'&msg='.$msg."&sid=".$sid."&Itemid=".$Itemid;
		}else{
			$link = "index.php?option=com_joomsport&controller=moder&task=madmin_player&tid=".$row->team_id."&sid=".$sid."&Itemid=".$Itemid;
		}
		$this->setRedirect( $link );
	
	}
	
	function player_del(){
		$mainframe = JFactory::getApplication();
		$Itemid = JRequest::getInt('Itemid'); 
		
		$db			=& JFactory::getDBO();
		$sid = JRequest::getVar( 'sid', 0, 'post', 'int' ); 
		$cid 		= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		
		if(count($cid)){
	
			$cids = implode(',',$cid);
	
			$db->setQuery("DELETE FROM #__bl_players WHERE id IN (".$cids.")");
	
			$db->query();
	
		}
		$tid = JRequest::getVar( 'tid', 0, '', 'int' );	
		
		$this->setRedirect( "index.php?option=com_joomsport&controller=moder&task=madmin_player&tid=".$tid."&sid=".$sid."&Itemid=".$Itemid);
	}
	
	///---------------Matchday--------------------------/
	
	function matchday_medit()
	{
		JRequest::setVar( 'view', 'moderedit_matchday' );
		JRequest::setVar( 'edit', true );
		parent::display();
	}
	
	
	
	function matchday_save(){
		$Itemid = JRequest::getInt('Itemid'); 
		$mainframe = JFactory::getApplication();
		$tid = JRequest::getVar( 'tid', 0, '', 'int' );
		$sid = JRequest::getVar( 'sid', 0, '', 'int' );
		$mid = JRequest::getVar( 'mid', 0, '', 'int' );
		$db			=& JFactory::getDBO();
	
		$user	=& JFactory::getUser();
	
		$post		= JRequest::get( 'post' );
	
		//$post['m_descr'] = JRequest::getVar( 'm_descr', '', 'post', 'string', JREQUEST_ALLOWRAW );
		unset($post['m_descr']);
		unset($post['m_name']);
	
		$s_id = JRequest::getVar( 'sid', 0, '', 'int' );	
	
		$row 	= new JTableMday($db);
	
	
		$row->s_id = $s_id;
	
	
		if (!$row->bind( $post )) {
	
			JError::raiseError(500, $row->getError() );
	
		}
	
		if (!$row->check()) {
	
			JError::raiseError(500, $row->getError() );
	
		}
	
		// if new item order last in appropriate group
	
		
	
		// save match
	$mj = 0;
	$arr_match = array();
	if(isset($_POST['home_team']) && count($_POST['home_team'])){
		foreach($_POST['home_team'] as $home_team){
			$match 	= new JTableMatch($db);
			$match->load($_POST['match_id'][$mj]);
			$match->m_id = $row->id;
			$match->team1_id = intval($home_team);
			$match->team2_id = intval($_POST['away_team'][$mj]);
			$match->score1 = intval($_POST['home_score'][$mj]);
			$match->score2 = intval($_POST['away_score'][$mj]);
			$match->is_extra = intval($_POST['extra_time'][$mj]);
			$match->published = 1;
			$match->m_played = $match->m_played?$match->m_played:0;
			$match->m_date = strval($_POST['match_data'][$mj]);
			$match->m_time = strval($_POST['match_time'][$mj]);
			
			$query = "SELECT COUNT(*) FROM #__bl_teams as t, #__bl_moders as m WHERE m.tid=t.id AND m.uid=".$user->id." AND (t.id=".$match->team1_id." OR t.id=".$match->team2_id.")";
		$db->setQuery($query);
	
		if(!$db->loadResult()){
			JError::raiseError(500, $match->getError() );
		}
			if (!$match->check()) {
				JError::raiseError(500, $match->getError() );
			}
			
			if (!$match->store()) {
				JError::raiseError(500, $match->getError() );
			}
			$match->checkin();
			$arr_match[] = $match->id;
			$mj++;
		}
		
		$db->setQuery("DELETE FROM #__bl_match WHERE id NOT IN (".implode(',',$arr_match).") AND (team1_id = ".$tid." OR team2_id=".$tid.") AND m_id = ".$row->id);
		$db->query();
	}else{
		$db->setQuery("DELETE FROM #__bl_match WHERE (team1_id = ".$tid." OR team2_id=".$tid.") AND m_id = ".$row->id);
		$db->query();
	}	
	
		
			
		$msg = JText::_('Successfully added data to Schedule');
		
		$isapply = JRequest::getVar( 'isapply', 0, '', 'int' );
		
		//if(!$isapply){
		
		//	$link = JRoute::_("index.php?option=com_joomsport&controller=admin&task=madmin_matchday&sid=".$s_id);
		//}else{
			$link = "index.php?option=com_joomsport&controller=moder&task=matchday_medit&tid=".$tid."&sid=".$sid."&mid=".$mid."&Itemid=".$Itemid;
		//}
		
		$this->setRedirect( $link );
	}
	
	
	
	
	///---------------Match--------------------------/
	
	
	function match_medit()
	{
		JRequest::setVar( 'view', 'moderedit_match' );
		JRequest::setVar( 'edit', true );
		parent::display();
	}
	
	
	function match_save(){
		$Itemid = JRequest::getInt('Itemid');
		$mainframe = JFactory::getApplication();
	
		$db			=& JFactory::getDBO();
	
		
	
		$post		= JRequest::get( 'post' );
	
		$post['match_descr'] = JRequest::getVar( 'match_descr', '', 'post', 'string', JREQUEST_ALLOWRAW );
		unset($post['m_id']);
		$row 	= new JTableMatch($db);
		$row->load($_POST['id']);
		if (!$row->bind( $post )) {
	
			JError::raiseError(500, $row->getError() );
	
		}
	
		if (!$row->check()) {
	
			JError::raiseError(500, $row->getError() );
	
		}
		if (!$row->store()) {
	
			JError::raiseError(500, $row->getError() );
	
		}
	
		//var_dump($row);die();
		$me_arr = array();
	if(isset($_POST['new_eventid']) && count($_POST['new_eventid'])){
		for ($i=0; $i< count($_POST['new_eventid']); $i++){
			if(!isset($_POST['em_id'][$i]) || !intval($_POST['em_id'][$i])){
	
				$new_event = $_POST['new_eventid'][$i];
				
				
				$query = "SELECT team_id FROM #__bl_players WHERE id=".intval($_POST['new_player'][$i]);
				$db->setQuery($query);
				$teamid = $db->loadResult();
				
	
				$query = "INSERT INTO #__bl_match_events(e_id,player_id,match_id,ecount,minutes,t_id) VALUES(".$new_event.",".$_POST['new_player'][$i].",".$row->id.",".intval($_POST['e_countval'][$i]).",".intval($_POST['e_minuteval'][$i]).",".intval($teamid).")";
				$db->setQuery($query);
				$db->query();
				
				$me_arr[] = $db->insertid();
			}else{
				$query = "SELECT * FROM #__bl_match_events WHERE id=".intval($_POST['em_id'][$i]);
				$db->setQuery($query);
				$event_bl = $db->loadObjectList();
				
				if(count($event_bl)){
					$query = "UPDATE #__bl_match_events SET minutes=".intval($_POST['e_minuteval'][$i]).",ecount=".intval($_POST['e_countval'][$i])." WHERE id=".intval($_POST['em_id'][$i]);
					$db->setQuery($query);
					$db->query();
					
					$me_arr[] = intval($_POST['em_id'][$i]);
				}
			}
		}
		/*$query = "DELETE FROM #__bl_match_events WHERE match_id = ".$row->id." AND id NOT IN (".implode(',',$me_arr).")";
		$db->setQuery($query);
		$db->query();*/
		
	
	}
	$query = "DELETE FROM #__bl_match_events WHERE match_id = ".$row->id;
	if(count($me_arr)){
		$query .= " AND id NOT IN (".implode(',',$me_arr).")";
	}
	
	$db->setQuery($query);
	$db->query();
	
	
	$query = "DELETE me.* FROM #__bl_match_events as me,#__bl_events as e WHERE me.match_id = ".$row->id." AND me.e_id=e.id AND player_event=0";
		$db->setQuery($query);
		$db->query();
	if(isset($_POST['new_teventid']) && count($_POST['new_teventid'])){
		for ($i=0; $i< count($_POST['new_teventid']); $i++){
			$new_event = $_POST['new_teventid'][$i];
			$query = "INSERT INTO #__bl_match_events(e_id,t_id,match_id,ecount,minutes) VALUES(".$new_event.",".$_POST['new_tplayer'][$i].",".$row->id.",".intval($_POST['et_countval'][$i]).",'0')";
			$db->setQuery($query);
			$db->query();
		}
	}
	$query = "DELETE FROM #__bl_assign_photos WHERE cat_type = 3 AND cat_id = ".$row->id;
	$db->setQuery($query);
	$db->query();
	if(isset($_POST['photos_id']) && count($_POST['photos_id'])){
		for($i = 0; $i < count($_POST['photos_id']); $i++){
			$photo_id = intval($_POST['photos_id'][$i]);
			$photo_name = addslashes(strval($_POST['ph_names'][$i]));
			$query = "INSERT INTO #__bl_assign_photos(photo_id,cat_id,cat_type) VALUES(".$photo_id.",".$row->id.",3)";
		 	$db->setQuery($query);
			$db->query();
			$query = "UPDATE #__bl_photos SET ph_name = '".($photo_name)."' WHERE id = ".$photo_id;
			$db->setQuery($query);
			$db->query();
		}
	}
	if(isset($_FILES['player_photo_1']['name']) && $_FILES['player_photo_1']['tmp_name'] != '' && isset($_FILES['player_photo_1']['tmp_name'])){
		$bl_filename = strtolower($_FILES['player_photo_1']['name']);
		$ext = pathinfo($_FILES['player_photo_1']['name']);
		$bl_filename = "bl".time().rand(0,3000).'.'.$ext['extension'];
		$bl_filename = str_replace(" ","",$bl_filename);
		//echo $bl_filename;
		 if($this->uploadFile($_FILES['player_photo_1']['tmp_name'], $bl_filename)){
		 	$post1['ph_filename'] = $bl_filename;
			$img1 = new JTablePhotos($db);
			$img1->id = 0;
			if (!$img1->bind( $post1 )) {
				JError::raiseError(500, $img1->getError() );
			}
			if (!$img1->check()) {
				JError::raiseError(500, $img1->getError() );
			}
			// if new item order last in appropriate group
			if (!$img1->store()) {
				JError::raiseError(500, $img1->getError() );
			}
			$img1->checkin();
			$query = "INSERT INTO #__bl_assign_photos(photo_id,cat_id,cat_type) VALUES(".$img1->id.",".$row->id.",3)";
		 	$db->setQuery($query);
			$db->query();
		 }
	}
	if(isset($_FILES['player_photo_2']['name']) && $_FILES['player_photo_2']['tmp_name'] != ''  && isset($_FILES['player_photo_2']['tmp_name'])){
		 $bl_filename = strtolower($_FILES['player_photo_2']['name']);
		$ext = pathinfo($_FILES['player_photo_2']['name']);
			$bl_filename = "bl".time().rand(0,3000).'.'.$ext['extension'];
		$bl_filename = str_replace(" ","",$bl_filename);
		 if($this->uploadFile($_FILES['player_photo_2']['tmp_name'], $bl_filename)){
		 	$post2['ph_filename'] = $bl_filename;
			$img2 = new JTablePhotos($db);
			$img2->id = 0;
			if (!$img2->bind( $post2 )) {
				JError::raiseError(500, $img2->getError() );
			}
			if (!$img2->check()) {
				JError::raiseError(500, $img2->getError() );
			}
			// if new item order last in appropriate group
			
			if (!$img2->store()) {
				JError::raiseError(500, $img2->getError() );
			}
			$img2->checkin();
			$query = "INSERT INTO #__bl_assign_photos(photo_id,cat_id,cat_type) VALUES(".$img2->id.",".$row->id.",3)";
		 	$db->setQuery($query);
			$db->query();
		 }
	}
	
	//-------extra fields-----------//
	if(isset($_POST['extraf']) && count($_POST['extraf'])){
		for($p=0;$p<count($_POST['extraf']);$p++){
			$query = "DELETE FROM #__bl_extra_values WHERE f_id = ".$_POST['extra_id'][$p]." AND uid = ".$row->id;
			$db->setQuery($query);
			$db->query();
			$query = "INSERT INTO #__bl_extra_values(f_id,uid,fvalue) VALUES(".$_POST['extra_id'][$p].",".$row->id.",'".$_POST['extraf'][$p]."')";
			$db->setQuery($query);
			$db->query();
		}
	}
	//-----SQUARD--------///
	$query = "DELETE FROM #__bl_squard WHERE match_id = ".$row->id;
		$db->setQuery($query);
		$db->query();
	if(isset($_POST['t1_squard']) && count($_POST['t1_squard'])){
		for ($i=0; $i< count($_POST['t1_squard']); $i++){
			$new_event = $_POST['t1_squard'][$i];
			$query = "INSERT INTO #__bl_squard(match_id,team_id,player_id,mainsquard) VALUES(".$row->id.",".$row->team1_id.",".$new_event.",'1')";
			$db->setQuery($query);
			$db->query();
		}
	}
	
	if(isset($_POST['t2_squard']) && count($_POST['t2_squard'])){
		for ($i=0; $i< count($_POST['t2_squard']); $i++){
			$new_event = $_POST['t2_squard'][$i];
			$query = "INSERT INTO #__bl_squard(match_id,team_id,player_id,mainsquard) VALUES(".$row->id.",".$row->team2_id.",".$new_event.",'1')";
			$db->setQuery($query);
			$db->query();
		}
	}
	if(isset($_POST['t1_squard_res']) && count($_POST['t1_squard_res'])){
		for ($i=0; $i< count($_POST['t1_squard_res']); $i++){
			$new_event = $_POST['t1_squard_res'][$i];
			$query = "INSERT INTO #__bl_squard(match_id,team_id,player_id,mainsquard) VALUES(".$row->id.",".$row->team1_id.",".$new_event.",'0')";
			$db->setQuery($query);
			$db->query();
		}
	}
	if(isset($_POST['t2_squard_res']) && count($_POST['t2_squard_res'])){
		for ($i=0; $i< count($_POST['t2_squard_res']); $i++){
			$new_event = $_POST['t2_squard_res'][$i];
			$query = "INSERT INTO #__bl_squard(match_id,team_id,player_id,mainsquard) VALUES(".$row->id.",".$row->team2_id.",".$new_event.",'0')";
			$db->setQuery($query);
			$db->query();
		}
	}
	
	
		$s_id = JRequest::getVar( 'sid', 0, '', 'int' );
		$tid = JRequest::getVar( 'tid', 0, '', 'int' );
		$isapply = JRequest::getVar( 'isapply', 0, '', 'int' );
		if(!$isapply){
			$this->setRedirect( "index.php?option=com_joomsport&controller=moder&task=matchday_medit&mid=".$row->m_id."&sid=".$s_id."&tid=".$tid."&Itemid=".$Itemid);
		}else{
			$this->setRedirect( "index.php?option=com_joomsport&controller=moder&task=match_medit&cid[]=".$row->id."&sid=".$s_id."&tid=".$tid."&Itemid=".$Itemid);
		}
	} 
	
	
	//---
	
	
	
	
	
	
   
	
	//-----------///////////-----------
	function uploadFile( $filename, $userfile_name, $dir = '') {
	$msg = '';
	$thumb_width = 100;
	require_once(JPATH_ROOT.'/components/com_joomsport/includes/thumb.php');
	if(!$dir){
		$baseDir =  JPATH_ROOT . '/media/bearleague/' ;
	}else{
		$baseDir = $dir;
	}
	jimport('joomla.filesystem.path');
	if (file_exists( $baseDir )) {
		if (is_writable( $baseDir )) {
			if (move_uploaded_file( $filename, $baseDir . $userfile_name )) {
			
				if (JPath::setPermissions( $baseDir . $userfile_name )) {
					//createThumb(JPATH_ROOT."/media/bearleague/",JPATH_ROOT."/media/bearleague/thumbs/",$thumb_width, $userfile_name);
					return true;
				} else {
					$msg = 'Failed to change the permissions of the uploaded file.';
				}
			} else {
				$msg = 'Failed to move uploaded file to <code>/media</code> directory.';
			}
		} else {
			$msg = 'Upload failed as <code>/media</code> directory is not writable.';
		}
	} else {
		$msg = 'Upload failed as <code>/media</code> directory does not exist.';
	}
	if($msg != ''){
		JError::raiseError(500, $msg );
	}
	return false;
}
	
	
}	
?>