<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
	if(isset($this->message)){
		$this->display('message');
	}
	$row = $this->row;
	$lists = $this->lists;
	$s_id = $this->s_id;
	$match = $this->match;
	
	$Itemid = JRequest::getInt('Itemid'); 
		
?>
<div align="right">
<div style="float:right;padding:0px 5px;width:32px;"><a href="#" class="toolbar" onclick="javascript:submitbutton('admin_match');return false;"><span class="icon-32-cancel"></span><?php echo JText::_('BLFA_CLOSE')?></a></div>
<div style="float:right;padding:0px 5px;width:32px;"><a href="#" class="toolbar" onclick="javascript:submitbutton('match_apply');return false;"><span class="icon-32-apply"></span><?php echo JText::_('BLFA_APPLY')?></a></div>
<div style="float:right;padding:0px 5px;width:32px;"><a href="#" class="toolbar" onclick="javascript:submitbutton('match_save');return false;"><span class="icon-32-save"></span><?php echo JText::_('BLFA_SAVE')?></a></div>
</div>
<div style="clear:both;"></div>
<?php
		$editor =& JFactory::getEditor();
		JHTML::_('behavior.tooltip');
		?>
		<script language="javascript" type="text/javascript">
		function getObj(name) {
		  if (document.getElementById)  {  return document.getElementById(name);  }
		  else if (document.all)  {  return document.all[name];  }
		  else if (document.layers)  {  return document.layers[name];  }
		}
		</script>
		<script type="text/javascript">
		<!--
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'matchday_save' || pressbutton == 'matchday_apply') {
				
				if(form.m_name.value != "" && form.s_id.value != 0){
					var extras = eval("document.adminForm['extra_time[]']");
					if(extras){
						for(i=0;i<extras.length;i++){
							if(extras[i].checked){	
								extras[i].value = 1;	
							}else{
								extras[i].value = 0;
							}
							extras[i].checked = true;
						}
					}
				
					
				}else{	
					alert("<?php echo JText::_('BLFA_JSMDNOT3');?>");	
				}
			}else{
				if(pressbutton == 'match_apply'){
						form.isapply.value='1';
						pressbutton = 'match_save';
					}
					
				var regE = /[0-2][0-9]:[0-5][0-9]/;
					if(!document.adminForm.d_time.value.test(regE) && document.adminForm.d_time.value != ''){
						alert("<?php echo JText::_( 'BLBE_JSMDNOT7' ); ?>");return;
					}else{
						submitform( pressbutton );
						return;
					}
			}
		}	
		
		function bl_add_event(){
			var cur_event = getObj('event_id');
			
			//var e_count = getObj('e_count').value;
			var e_minutes = getObj('e_minutes').value;
			var e_player = getObj('playerz_id');
			var re_count = getObj('re_count').value;
			
			if (cur_event.value == 0) {
				alert("<?php echo JText::_('BLFA_JSMDNOT4');?>");return;
			}
			if (e_player.value == 0) {
				alert("<?php echo JText::_('BLFA_JSMDNOT5');?>");return;
			}
			
			var tbl_elem = getObj('new_events');
			var row = tbl_elem.insertRow(tbl_elem.rows.length);
			var cell1 = document.createElement("td");
			var cell2 = document.createElement("td");
			var cell3 = document.createElement("td");
			var cell4 = document.createElement("td");
			var cell5 = document.createElement("td");
			var cell6 = document.createElement("td");
			
			var input_hidden = document.createElement("input");
			input_hidden.type = "hidden";
			input_hidden.name = "em_id[]";
			input_hidden.value = 0;
			cell1.appendChild(input_hidden);
			cell1.innerHTML = '<a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/images/publish_x.png"  border="0" alt="Delete"></a>';
			
			var input_hidden = document.createElement("input");
			input_hidden.type = "hidden";
			input_hidden.name = "new_eventid[]";
			input_hidden.value = cur_event.value;
			cell2.innerHTML = cur_event.options[cur_event.selectedIndex].text;
			cell2.appendChild(input_hidden);
			
			var input_hidden = document.createElement("input");
			input_hidden.type = "text";
			input_hidden.name = "e_countval[]";
			input_hidden.value = re_count;
			//cell4.innerHTML = e_minutes;
			input_hidden.setAttribute("maxlength",5);
			input_hidden.setAttribute("size",5);
			cell6.appendChild(input_hidden);
			
			var input_hidden = document.createElement("input");
			input_hidden.type = "text";
			input_hidden.name = "e_minuteval[]";
			input_hidden.value = e_minutes;
			//cell4.innerHTML = e_minutes;
			input_hidden.setAttribute("maxlength",5);
			input_hidden.setAttribute("size",5);
			cell4.appendChild(input_hidden);
			
			var input_player = document.createElement("input");
			input_player.type = "hidden";
			input_player.name = "new_player[]";
			input_player.value = e_player.value;
			if(e_player.value != 0){
				cell5.innerHTML = e_player.options[e_player.selectedIndex].text;
			}	
			cell5.appendChild(input_player);
			
			row.appendChild(cell1);
			row.appendChild(cell2);
			row.appendChild(cell5);
			row.appendChild(cell4);
			row.appendChild(cell6);
			
			getObj('event_id').value =  0;
			getObj('playerz_id').value =  0;
			getObj('e_minutes').value = '';
			getObj('re_count').value =  1;
		}
		function bl_add_tevent(){
			var cur_event = getObj('tevent_id');
			
			var e_count = getObj('et_count').value;
			var e_player = getObj('teamz_id');
			
			if (cur_event.value == 0) {
				alert("<?php echo JText::_('BLFA_JSMDNOT4');?>");return;
			}
			if (e_player.value == 0) {
				alert("<?php echo JText::_('BLFA_JSMDNOT6');?>");return;
			}
			
			var tbl_elem = getObj('new_tevents');
			var row = tbl_elem.insertRow(tbl_elem.rows.length);
			var cell1 = document.createElement("td");
			var cell2 = document.createElement("td");
			var cell3 = document.createElement("td");
			var cell4 = document.createElement("td");
			var cell5 = document.createElement("td");
			
			
			cell1.innerHTML = '<a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/images/publish_x.png"  border="0" alt="Delete"></a>';
			
			var input_hidden = document.createElement("input");
			input_hidden.type = "hidden";
			input_hidden.name = "new_teventid[]";
			input_hidden.value = cur_event.value;
			cell2.innerHTML = cur_event.options[cur_event.selectedIndex].text;
			cell2.appendChild(input_hidden);
			
			var input_hidden = document.createElement("input");
			input_hidden.type = "text";
			input_hidden.name = "et_countval[]";
			input_hidden.value = e_count;
			input_hidden.setAttribute("maxlength",5);
			input_hidden.setAttribute("size",5);
			
			//cell3.align = "center";
			//cell3.innerHTML = e_count;
			cell3.appendChild(input_hidden);
			
			
			var input_player = document.createElement("input");
			input_player.type = "hidden";
			input_player.name = "new_tplayer[]";
			input_player.value = e_player.value;
			if(e_player.value != 0){
				cell5.innerHTML = e_player.options[e_player.selectedIndex].text;
			}	
			cell5.appendChild(input_player);
			
			row.appendChild(cell1);
			row.appendChild(cell2);
			row.appendChild(cell5);
			row.appendChild(cell3);
		
			getObj('tevent_id').value =  0;
			getObj('teamz_id').value =  0;
			getObj('et_count').value = '';
		}
		
		function bl_add_squard(tblid,selid,elname){
			var cur_event = getObj(selid);
			

			if (cur_event.value == 0) {
				alert("<?php echo JText::_('BLFA_JSMDNOT8');?>");return;
			}
			
			
			var tbl_elem = getObj(tblid);
			var row = tbl_elem.insertRow(tbl_elem.rows.length);
			var cell1 = document.createElement("td");
			var cell2 = document.createElement("td");
			
			
			
			cell1.innerHTML = '<a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/images/publish_x.png"  border="0" alt="Delete"></a>';
			
			var input_hidden = document.createElement("input");
			input_hidden.type = "hidden";
			input_hidden.name = elname;
			input_hidden.value = cur_event.value;
			cell2.innerHTML = cur_event.options[cur_event.selectedIndex].text;
			cell2.appendChild(input_hidden);
			
			
			
			row.appendChild(cell1);
			row.appendChild(cell2);
			
		
			getObj(selid).value =  0;
			
		}
		
		function Delete_tbl_row(element) {
			var del_index = element.parentNode.parentNode.sectionRowIndex;
			var tbl_id = element.parentNode.parentNode.parentNode.parentNode.id;
			element.parentNode.parentNode.parentNode.deleteRow(del_index);
		}
		//-->
		</script>
		<form action="" method="post" name="adminForm" enctype="multipart/form-data">
		<?php
		//echo $tabs->startPane('matchmain');
		//echo $tabs->startPanel('Main','match_conf');
		require_once(JPATH_ROOT.DS.'components'.DS.'com_joomsport'.DS.'includes'.DS.'tabs.php');

		$etabs = new esTabs();
		$etabs->newTab(JText::_('BLBE_MAIN'),'match_conf','','vis');
		$etabs->newTab(JText::_( 'BLFA_SQUARD' ),'squard_conf');
		?>
		<div style="clear:both"></div>
		<div id="match_conf_div" class="tabdiv">
		<table class="jsnoborders">
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLFA_MATCHDAYNAME' ); ?>
				</td>
				<td>
					<?php echo $lists['mday'];?>
				</td>
			</tr>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLFA_RESULTS' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_RESULTS' ); ?>::<?php echo JText::_( '' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $lists['teams1'].' <input type="text" name="score1" value="'.$row->score1.'" size="5" maxlength="5" />&nbsp;:&nbsp;<input type="text" name="score2" value="'.$row->score2.'" size="5" maxlength="5" /> '.$lists['teams2'];?>
				</td>
			</tr>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLFA_BONUSPTS' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_BONUSPTS' ); ?>::<?php echo JText::_( '' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $lists['teams1'].' <input type="text" name="bonus1" value="'.$row->bonus1.'" size="5" maxlength="5" />&nbsp;:&nbsp;<input type="text" name="bonus2" value="'.$row->bonus2.'" size="5" maxlength="5" /> '.$lists['teams2'];?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JText::_( 'BLFA_ET' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_ET' ); ?>::<?php echo JText::_( '' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span>
				</td>
				<Td>
					<?php echo $lists['extra'];?>
				</Td>
			</tr>
			<tr>
				<td>
					<?php echo JText::_( 'BLFA_PLAYED' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_PLAYED' ); ?>::<?php echo JText::_( 'BLFA_TT_PLAYED' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span>					
				</td>
				<Td>
					<?php echo $lists['m_played'];?>
				</Td>
			</tr>
			
			<tr>
				<td>
					<?php echo JText::_('BLFA_DATE');?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_DATE' ); ?>::<?php echo JText::_( 'BLFA_TT_DATE' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span>					
					
				</td>
				<td>
					<?php
						echo JHTML::_('calendar', $row->m_date ? $row->m_date : date("Y-m-d"), 'm_date', 'm_date', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'10')); 
					?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JText::_('BLFA_TIME');?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_TIME' ); ?>::<?php echo JText::_( 'BLFA_TT_TIME' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span>
					
				</td>
				<td>
					<input type="text" maxlength="5" size="10" name="d_time" value="<?php echo substr($row->m_time,0,5);?>" />
					
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JText::_('BLFA_LOCATION');?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_LOCATION' ); ?>::<?php echo JText::_( 'BLFA_TT_LOCATION' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span>
					
				</td>
				<td>
					<input type="text" maxlength="255" size="20" name="m_location" value="<?php echo htmlspecialchars($row->m_location);?>" />
					
				</td>
			</tr>
			<?php
			for($p=0;$p<count($lists['ext_fields']);$p++){
			?>
			<tr>
				<td width="100">
					<?php echo $lists['ext_fields'][$p]->name;?>
				</td>
				<td>
					<input type="text" maxlength="255" size="60" name="extraf[]" value="<?php echo isset($lists['ext_fields'][$p]->fvalue)?htmlspecialchars($lists['ext_fields'][$p]->fvalue):""?>" />
					<input type="hidden" name="extra_id[]" value="<?php echo $lists['ext_fields'][$p]->id?>" />
				</td>
			</tr>
			<?php	
			}
			?>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLFA_ABOUTMATCH' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_ABOUTMATCH' ); ?>::<?php echo JText::_( '' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $editor->display( 'match_descr',  htmlspecialchars($row->match_descr, ENT_QUOTES), '550', '300', '60', '20', array('pagebreak', 'readmore') ) ;  ?>
				</td>
			</tr>
			
		</table>
		<br />
<table width="100%" class="jsnoborders">
<tr>
	<td>
	<div>		
		<table class="adminlist" id="new_events">
			<tr>
				<th align="center" colspan="5" class="title">
					<?php echo JText::_('BLFA_PLAYEREVENTS');?>
				</th>
			</tr>
			<tr>
				<th class="title" width="2%">
					#
				</th>
				<th class="title" width="170">
					<?php echo JText::_( 'BLFA_PLAYEREVENT' ); ?>
				</th>
				<th>
					<?php echo JText::_( 'BLFA_PLAYERR' ); ?>
				</th>
				
				<th class="title" width="60">
					<?php echo JText::_( 'BLFA_MINUTES' ); ?>
				</th>
				<th class="title" width="60">
					<?php echo JText::_( 'Count' ); ?>
				</th>
			</tr>
			<?php
			if(count($lists['m_events'])){
				foreach($lists['m_events'] as $m_events){
					echo "<tr>";
					echo '<td><input type="hidden" name="em_id[]" value="'.$m_events->id.'" /><a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/images/publish_x.png"  border="0" alt="Delete"></a></td>';
					echo '<td><input type="hidden" name="new_eventid[]" value="'.$m_events->e_id.'" />'.$m_events->e_name.'</td>';
					echo '<td><input type="hidden" name="new_player[]" value="'.$m_events->player_id.'" />'.$m_events->p_name.'</td>';
					echo '<td><input type="text" size="5" maxlenght="5" name="e_minuteval[]" value="'.$m_events->minutes.'" /></td>';
					echo '<td><input type="text" size="5" maxlenght="5" name="e_countval[]" value="'.$m_events->ecount.'" /></td>';
					echo "</tr>";
				}
			}
			?>
		</table>
		<table class="adminlist">
			<tr>
				<th class="title" colspan="3" align="center">
					<?php echo JText::_('BLFA_ADDPLEVENTS');?>
				</td>
			</tr>
			
			<tr>
				<th class="title" width="260">
					<?php echo $lists['events'];?>
				</th>
				<th>
					<?php echo $lists['players'];?>
				</th>
				
				<th class="title" width="150">
					<input name="e_minutes" id="e_minutes" type="text" maxlength="5" size="5" />
					<input name="re_count" id="re_count" type="text" maxlength="5" size="5" value="1" />
					<input type="button" value="<?php echo JText::_('BLFA_ADD');?>" onClick="bl_add_event();" />
				</th>
				
			</tr>
		</table>
		<br />
	</div>
	<div>
		<table class="adminlist" id="new_tevents">
			<tr>
				<th class="title" align="center" colspan="4">
					<?php echo JText::_('BLFA_MATCHSTATS');?>
				</th>
			</tr>
			<tr>
				<th class="title" width="2%">
					#
				</th>
				<th class="title" width="170">
					<?php echo JText::_( 'BLFA_MATCHSTATSEV' ); ?>
				</th>
				<th>
					<?php echo JText::_( 'BLFA_TT_TEAM' ); ?>
				</th>
				<th width="60">
					<?php echo JText::_( 'BLFA_COUNT' ); ?>
				</th>
				
			</tr>
			<?php
			if(count($lists['t_events'])){
				foreach($lists['t_events'] as $m_events){
					echo "<tr>";
					echo '<td><a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/images/publish_x.png"  border="0" alt="Delete"></a></td>';
					echo '<td><input type="hidden" name="new_teventid[]" value="'.$m_events->e_id.'" />'.$m_events->e_name.'</td>';
					echo '<td><input type="hidden" name="new_tplayer[]" value="'.$m_events->pid.'" />'.$m_events->p_name.'</td>';
					echo '<td><input type="text" size="5" maxlenght="5" name="et_countval[]" value="'.$m_events->ecount.'" /></td>';
					echo "</tr>";
				}
			}
			?>
		</table>
		<table class="adminlist">
			<tr>
				<th class="title" colspan="3" align="center">
					<?php echo JText::_('BLFA_ADDSTATTOMATCH')?>
				</th>
			</tr>
			<tr>
				<th class="title" width="260">
					<?php echo $lists['team_events'];?>
				</th>
				<th>
					<?php echo $lists['sel_team'];?>
				</th>
				<th width="110">
					<input name="e_count" id="et_count" type="text" maxlength="5" size="5" />
					<input type="button" value="Add" onClick="bl_add_tevent();" />
				</th>
			</tr>
		</table>
		<br />
	</div>
</td>
</tr>
</table>
	<div style="margin-top:10px;border:1px solid #BBB;">

		
		<table style="padding:10px;" class="jsnoborders">
			<tr>
				<td>
					<?php echo JText::_('BLFA_UPLPHTOMTCH');?>
				</td>
			</tr>
			<tr>
				<td>&nbsp;
				
				</td>
			</tr>
			<tr>
				<td>
				<input type="file" name="player_photo_1" value="" />
				</td>
			</tr>
			<tr>
				<td>
				<input type="file" name="player_photo_2" value="" />
				</td>
			</tr>
			<tr>
				<td>&nbsp;
				
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JText::_('BLFA_ONEPHSEL');?>
				</td>
			</tr>
		</table>
		<?php
		if(count($lists['photos'])){
		?>
		<table class="adminlist">
			<tr>
				<th class="title" width="30"><?php echo JText::_('BLFA_DELETE');?></th>
				
				<th class="title" ><?php echo JText::_('BLFA_TITLE');?></th>
				<th class="title" width="250"><?php echo JText::_('BLFA_IMAGE');?></th>
			</tr>
			<?php
			foreach($lists['photos'] as $photos){
			?>
			<td align="center">
				<a href="javascript:void(0);" title="Remove" onClick="javascript:Delete_tbl_row(this);"><img src="<?php echo JURI::base();?>components/com_joomsport/images/publish_x.png" title="Remove" /></a>
				<input type="hidden" name="photos_id[]" value="<?php echo $photos->id;?>"/>
			</td>
			
			<td>
				<input type="text" maxlength="255" size="60" name="ph_names[]" value="<?php echo htmlspecialchars($photos->name)?>" />
			</td>
			<td align="center">
				<?php
				$imgsize = getimagesize('media/bearleague/'.$photos->filename);
				if($imgsize[0] > 200){
					$width = 200;
				}else{
					$width  = $imgsize[0];
				}
				?>
				<a rel="{handler: 'image'}" href="<?php echo JURI::base();?>../media/bearleague/<?php echo $photos->filename?>" title="Image" class="modal-button"><img src="<?php echo JURI::base();?>../media/bearleague/<?php echo $photos->filename?>" width="<?php echo $width;?>" /></a>
			</td>
			</tr>
			<?php
			}
			?>
		</table>
		<?php
		}
		?>
	</div>	
	</div>
	<div id="squard_conf_div" style="display:none;" class="tabdiv">
	<?php
		//echo $tabs->endPanel();
		//echo $tabs->startPanel(JText::_( 'BLFA_SQUARD' ),'squard_conf');
		?>	
		<?php echo JText::_( 'BLFA_LINEUP' ); ?>
		<div style="width:100%;overflow:hidden;">
				<div style="float:left; width:50%">
			<table class="adminlist" id="new_squard1">
				<tr>
					<th class="title" align="center" colspan="2">
						<?php echo $lists['teams1'];?> 
					</th>
				</tr>
				<tr>
					<th class="title" width="2%">
						#
					</th>
					
					<th>
						<?php echo JText::_( 'BLFA_PLAYERNAME' ); ?>
					</th>
					
					
				</tr>
				<?php
				if(count($lists['squard1'])){
					foreach($lists['squard1'] as $m_events){
						echo "<tr>";
						echo '<td><a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/images/publish_x.png"  border="0" alt="Delete"></a></td>';
						echo '<td><input type="hidden" name="t1_squard[]" value="'.$m_events->id.'" />'.$m_events->name.'</td>';
						echo "</tr>";
					}
				}
				?>
			</table>

			<table class="adminlist">
				
				<tr>
					
					<th colspan="2">
						<?php echo $lists['players_team1'];?>
					
						<input type="button" value="Add" onClick="bl_add_squard('new_squard1','playersq1_id','t1_squard[]');" />
					</th>
				</tr>
			</table>
			<br />
		</div>
		<div style="float:left; width:50%">
			<table class="adminlist" id="new_squard2">
				<tr>
					<th class="title" align="center" colspan="2">
						<?php echo $lists['teams2'];?> 
					</th>
				</tr>
				<tr>
					<th class="title" width="2%">
						#
					</th>
					
					<th>
						<?php echo JText::_( 'BLFA_PLAYERNAME' ); ?>
					</th>
					
					
				</tr>
				<?php
				if(count($lists['squard2'])){
					foreach($lists['squard2'] as $m_events){
						echo "<tr>";
						echo '<td><a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/images/publish_x.png"  border="0" alt="Delete"></a></td>';
						echo '<td><input type="hidden" name="t2_squard[]" value="'.$m_events->id.'" />'.$m_events->name.'</td>';
						echo "</tr>";
					}
				}
				?>
			</table>
			<table class="adminlist">
				
				<tr>
					
					<th colspan="2">
						<?php echo $lists['players_team2'];?>
					
						<input type="button" value="Add" onClick="bl_add_squard('new_squard2','playersq2_id','t2_squard[]');" />
					</th>
				</tr>
			</table>
			<br />
		</div>
			</div>
		<?php echo JText::_( 'BLFA_SUBSTITUTES' ); ?>
		<div style="width:100%;overflow:hidden;">
		<div style="float:left; width:50%">
			<table class="adminlist" id="new_squard1_res">
				<tr>
					<th class="title" align="center" colspan="2">
						<?php echo $lists['teams1'];?>
					</th>
				</tr>
				<tr>
					<th class="title" width="2%">
						#
					</th>
					
					<th>
						<?php echo JText::_( 'BLFA_PLAYERNAME' ); ?>
					</th>
					
					
				</tr>
				<?php
				if(count($lists['squard1_res'])){
					foreach($lists['squard1_res'] as $m_events){
						echo "<tr>";
						echo '<td><a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/images/publish_x.png"  border="0" alt="Delete"></a></td>';
						echo '<td><input type="hidden" name="t1_squard_res[]" value="'.$m_events->id.'" />'.$m_events->name.'</td>';
						echo "</tr>";
					}
				}
				?>
			</table>
			<table class="adminlist">
				
				<tr>
					
					<th colspan="2">
						<?php echo $lists['players_team1_res'];?>
					
						<input type="button" value="Add" onClick="bl_add_squard('new_squard1_res','playersq1_id_res','t1_squard_res[]');" />
					</th>
				</tr>
			</table>
			<br />
		</div>
		<div style="float:left; width:50%">
			<table class="adminlist" id="new_squard2_res">
				<tr>
					<th class="title" align="center" colspan="2">
						<?php echo $lists['teams2'];?>
					</th>
				</tr>
				<tr>
					<th class="title" width="2%">
						#
					</th>
					
					<th>
						<?php echo JText::_( 'BLFA_PLAYERNAME' ); ?>
					</th>
					
					
				</tr>
				<?php
				if(count($lists['squard2_res'])){
					foreach($lists['squard2_res'] as $m_events){
						echo "<tr>";
						echo '<td><a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/images/publish_x.png"  border="0" alt="Delete"></a></td>';
						echo '<td><input type="hidden" name="t2_squard_res[]" value="'.$m_events->id.'" />'.$m_events->name.'</td>';
						echo "</tr>";
					}
				}
				?>
			</table>
			<table class="adminlist">
				
				<tr>
					
					<th colspan="2">
						<?php echo $lists['players_team2_res'];?>
					
						<input type="button" value="Add" onClick="bl_add_squard('new_squard2_res','playersq2_id_res','t2_squard_res[]');" />
					</th>
				</tr>
			</table>
			<br />
		</div>
		</div>
		<?php
		//echo $tabs->endPanel();
		//echo $tabs->endPane();
		?>
		</div>
		
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="id" value="<?php echo $row->id?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="sid" value="<?php echo $s_id?>" />
		<input type="hidden" name="team1_id" value="<?php echo $row->team1_id?>" />
		<input type="hidden" name="team2_id" value="<?php echo $row->team2_id?>" />
		<input type="hidden" name="isapply" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
