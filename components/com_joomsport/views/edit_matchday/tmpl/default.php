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
<?php if($this->msg){ ?>
<div class="message"><?php echo $this->msg;?></div>
<?php }?>
<div align="right">
<div style="float:right;padding:0px 5px;width:32px;"><a href="#" class="toolbar" onclick="javascript:submitbutton('admin_matchday');return false;"><span class="icon-32-cancel"></span><?php echo JText::_('BLFA_CLOSE')?></a></div>
<div style="float:right;padding:0px 5px;"><a href="#" class="toolbar" onclick="javascript:submitbutton('matchday_apply');return false;"><span class="icon-32-apply"></span><?php echo JText::_('BLFA_APPLY')?></a></div>
<div style="float:right;padding:0px 5px;"><a href="#" class="toolbar" onclick="javascript:submitbutton('matchday_save');return false;"><span class="icon-32-save"></span><?php echo JText::_('BLFA_SAVE')?></a></div>
</div>
<div style="clear:both;"></div>
<?php
		JHTML::_('behavior.tooltip');
		
		?>
		<script type="text/javascript">
		<!--
		function getObj(name) {
		  if (document.getElementById)  {  return document.getElementById(name);  }
		  else if (document.all)  {  return document.all[name];  }
		  else if (document.layers)  {  return document.layers[name];  }
		}
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'matchday_save' || pressbutton == 'matchday_apply') {
				if(form.m_name.value != "" && form.sid.value != 0){
					var extras = eval("document.adminForm['extra_time[]']");
					if(extras){
						if(extras.length){
							for(i=0;i<extras.length;i++){
								if(extras[i].checked){	
									extras[i].value = 1;	
								}else{
									extras[i].value = 0;
								}
								extras[i].checked = true;
							}
						}else{
							if(extras.checked){	
								extras.value = 1;	
							}else{
								extras.value = 0;
							}
							extras.checked = true;
						}
					}
					var played = eval("document.adminForm['match_played[]']");
					if(played){
						if(played.length){
							for(i=0;i<played.length;i++){
								if(played[i].checked){	
									played[i].value = 1;	
								}else{
									played[i].value = 0;
								}
								played[i].checked = true;
							}
						}else{
							if(played.checked){	
								played.value = 1;	
							}else{
								played.value = 0;
							}
							played.checked = true;
						}
					}
					var errortime = '';
					var mt_time = eval("document.adminForm['match_time[]']");
					if(mt_time){
						if(mt_time.length){
							for(i=0;i<mt_time.length;i++){
								var regE = /[0-2][0-9]:[0-5][0-9]/;
								if(!mt_time[i].value.test(regE) && mt_time[i].value != ''){
									errortime = '1';
									mt_time[i].style.border = "1px solid red";
								}else{
									mt_time[i].style.border = "1px solid #C0C0C0";
								}
							}
						}else{
							var regE = /[0-2][0-9]:[0-5][0-9]/;
								if(!mt_time.value.test(regE) && mt_time.value != ''){
									errortime = '1';
									mt_time.style.border = "1px solid red";
								}else{
									mt_time.style.border = "1px solid #C0C0C0";
								}
						}
					}
					var errortime2 = '';
					var mt_data = eval("document.adminForm['match_data[]']");
					if(mt_data){
						if(mt_data.length){
							for(i=0;i<mt_data.length;i++){
								var regE = /[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]/;
								if(!mt_data[i].value.test(regE) && mt_data[i].value != ''){
									errortime2 = '1';
									mt_data[i].style.border = "1px solid red";
								}else{
									mt_data[i].style.border = "1px solid #C0C0C0";
								}
							}
						}else{
							var regE = /[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]/;
								if(!mt_data.value.test(regE) && mt_data.value != ''){
									errortime2 = '1';
									mt_data.style.border = "1px solid red";
								}else{
									mt_data.style.border = "1px solid #C0C0C0";
								}
						}
					}
					
					if(errortime){
						alert("<?php echo JText::_( 'BLBE_JSMDNOT7' ); ?>");return;
					}else{
						if(errortime2){
							alert("<?php echo JText::_( 'BLFA_JSMDNOT77' ); ?>");return;
						}else{	
							if(pressbutton == 'matchday_apply'){
								form.isapply.value='1';
								pressbutton = 'matchday_save';
							}
							submitform( pressbutton );
							return;
						}
					}
					
				}else{	
					alert("Enter Name, Tournament, Season");	
				}
			}else{
				submitform( pressbutton );
					return;
			}
		}	
		
		function bl_add_match(){
			var team1 = getObj('teams1');
			var team2 = getObj('teams2');
			var score1 = getObj('add_score1').value;
			var score2 = getObj('add_score2').value;
			var tm_played = getObj('tm_played').checked;
			
			
			if (team1.value == 0 || team2.value == 0) {
				alert("<?php echo JText::_('BLFA_JSMDNOT1')?>");return;
			}
			if (((score1) == '' || (score2) == '') && tm_played){
				alert("Please enter text to the field.");return;
			}
			if ( team1.value == team2.value ){
				alert("<?php echo JText::_('BLFA_JSMDNOT2')?>");return;
			}
			
			var regE = /[0-2][0-9]:[0-5][0-9]/;
			if(!getObj('match_time_new').value.test(regE)){
				alert("<?php echo JText::_('BLFA_JSMDNOT7')?>");return;
			}
			var tbl_elem = getObj('new_matches');
			var row = tbl_elem.insertRow(tbl_elem.rows.length);
			var cell1 = document.createElement("td");
			var cell2 = document.createElement("td");
			var cell3 = document.createElement("td");
			var cell4 = document.createElement("td");
			var cell5 = document.createElement("td");
			var cell6 = document.createElement("td");
			
			var input_hidden = document.createElement("input");
			input_hidden.type = "hidden";
			input_hidden.name = "match_id[]";
			input_hidden.value = 0;
			cell1.appendChild(input_hidden);
			cell1.innerHTML = '<a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/images/publish_x.png"  border="0" alt="Delete"></a>';
			cell1.setAttribute("rowspan",2);
			var input_hidden = document.createElement("input");
			input_hidden.type = "hidden";
			input_hidden.name = "home_team[]";
			input_hidden.value = team1.value;
			cell2.innerHTML = team1.options[team1.selectedIndex].text;
			cell2.appendChild(input_hidden);
			
			var input_hidden = document.createElement("input");
			input_hidden.type = "text";
			input_hidden.name = "home_score[]";
			input_hidden.value = score1;
			input_hidden.size = 3;
			input_hidden.setAttribute("maxlength",5);
			cell3.align = "center";
			//cell3.innerHTML = score1 + ' : ' + score2;
			cell3.appendChild(input_hidden);
			var txtnode = document.createTextNode(" : ");
			cell3.appendChild(txtnode);
			var input_hidden = document.createElement("input");
			input_hidden.type = "text";
			input_hidden.name = "away_score[]";
			input_hidden.value = score2;
			input_hidden.size = 3;
			input_hidden.setAttribute("maxlength",5);
			cell3.appendChild(input_hidden);
			
			var input_hidden = document.createElement("input");
			input_hidden.type = "checkbox";
			input_hidden.name = "extra_time[]";
			
			if(getObj('extra_timez').checked){
				input_hidden.checked = true;
				input_hidden.value = '1';
			}else{
				input_hidden.value = '0';
			}
			cell3.appendChild(input_hidden);
			
			var input_hidden = document.createElement("input");
			input_hidden.type = "hidden";
			input_hidden.name = "away_team[]";
			input_hidden.value = team2.value;
			cell4.innerHTML = team2.options[team2.selectedIndex].text;
			cell4.appendChild(input_hidden);
			cell5.innerHTML = '';
			cell5.setAttribute("rowspan",2);
			
			////-------------new---------------////
			
			var cell7 = document.createElement("td");
			var cell8 = document.createElement("td");
			
			var input_hidden = document.createElement("input");
			input_hidden.type = "text";
			input_hidden.name = "match_data[]";
			input_hidden.value = getObj('tm_date').value;
			input_hidden.size = 10;
			input_hidden.setAttribute("maxlength",10);
			
			cell6.appendChild(input_hidden);
			cell6.align = "left";
			
			
			var input_hidden = document.createElement("input");
			input_hidden.type = "text";
			input_hidden.name = "match_time[]";
			input_hidden.value = getObj('match_time_new').value;
			input_hidden.size = 5;
			input_hidden.setAttribute("maxlength",5);
			
			cell7.appendChild(input_hidden);
			
			
			cell7.align = "left";
			
			
			var input_hidden = document.createElement("input");
			input_hidden.type = "checkbox";
			input_hidden.name = "match_played[]";
			if(getObj('tm_played').checked){
				input_hidden.checked = true;
				input_hidden.value = '1';
			}else{
				input_hidden.value = '0';
			}
			cell8.appendChild(input_hidden);
			
			////------------/new---------------////
			
			row.appendChild(cell1);
			row.appendChild(cell2);
			row.appendChild(cell3);
			
			row.appendChild(cell4);
			row.appendChild(cell5);
			var row2 = tbl_elem.insertRow(tbl_elem.rows.length);
			row2.appendChild(cell6);
			
			row2.appendChild(cell8);
			row2.appendChild(cell7);
			
			var row3 = tbl_elem.insertRow(tbl_elem.rows.length);
			var cell_f = document.createElement("td");
			cell_f.setAttribute("colspan",5);
			row3.appendChild(cell_f);
			getObj('teams1').value =  0;
			getObj('teams2').value = 0;
			getObj('add_score1').value = '';
			getObj('add_score2').value = '';
			getObj('extra_timez').checked = false;
		}
		
		function Delete_tbl_row(element) {
			var del_index = element.parentNode.parentNode.sectionRowIndex;
			var tbl_id = element.parentNode.parentNode.parentNode.parentNode.id;
			element.parentNode.parentNode.parentNode.deleteRow(del_index+1);
			element.parentNode.parentNode.parentNode.deleteRow(del_index+1);
			element.parentNode.parentNode.parentNode.deleteRow(del_index);
		}
		//-->
		</script>
		<form action="" method="post" name="adminForm">
		
		<table class='jsnoborders'>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLFA_MATCHDAYNAME' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_MATCHDAYNAME' ); ?>::<?php echo JText::_( ' ' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span> 
				</td>
				<td>
					<input type="text" maxlength="255" size="60" name="m_name" value="<?php echo htmlspecialchars($row->m_name)?>" />
				</td>
			</tr>
			
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLFA_ISPLAYOFF' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_ISPLAYOFF' ); ?>::<?php echo JText::_( ' ' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span> 
				</td>
				<td>
					<?php echo $lists['is_playoff'];?>
				</td>
			</tr>
			
		</table>
		<br />
		<table class="adminlist" id="new_matches" border="0">
			<tr>
				<th class="title" style="padding-left:250px;" colspan="8">
					<?php echo JText::_('BLFA_MATCHRESULTS');?>
				</th>
			</tr>
			<tr>
				<th class="title" width="20">
					#
				</th>
				<th class="title" width="170">
					<?php echo JText::_( 'BLFA_HOMETEAM' ); ?>
				</th>
				<th width="140">
					<?php echo JText::_( 'BLFA_SCORE' ); ?>
				</th>
				
				<th class="title" width="170">
					<?php echo JText::_( 'BLFA_AWAYTEAM' ); ?>
				</th>
				
				<th class="title">
					<?php echo JText::_( 'BLFA_MATCHDETAILS' ); ?>
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_MATCHDETAILS' ); ?>::<?php echo JText::_( 'BLFA_TT_MATCHDETAILS' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span> 
				</th>
			</tr>
			<?php
			if(count($match)){
				foreach($match as $curmatch){
					$match_link = 'index.php?option=com_joomsport&amp;task=match_edit&amp;cid[]='.$curmatch->id.'&amp;controller=admin&amp;sid='.$this->s_id.'&Itemid='.$Itemid;
					echo "<tr>";
					echo '<td rowspan="2"><input type="hidden" name="match_id[]" value="'.$curmatch->id.'" /><a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/images/publish_x.png"  border="0" alt="Delete"></a></td>';
					echo '<td><input type="hidden" name="home_team[]" value="'.$curmatch->team1_id.'" />'.$curmatch->home_team.'</td>';
					echo '<td align="center"><input type="text" name="home_score[]" value="'.$curmatch->score1.'" size="3" maxlength="5" /> : <input type="text" name="away_score[]" value="'.$curmatch->score2.'" size="3" maxlength="5" /><input type="checkbox" name="extra_time[]" value="'.(($curmatch->is_extra)?1:0).'" '.(($curmatch->is_extra)?"checked":"").' /></td>';
					echo '<td><input type="hidden" name="away_team[]" value="'.$curmatch->team2_id.'" />'.$curmatch->away_team.'</td>';
					echo '<td rowspan=2><a href="'.$match_link.'">'.JText::_( 'BLFA_MATCHDETAILS' ).'</a></td>';
					
					echo '</tr>';
					echo '<tr>';
					
					echo '<td>'.JText::_( 'BLFA_DATEE' ).'';
						echo JHTML::_('calendar', $curmatch->m_date, 'match_data[]', 'match_data_'.$curmatch->id, '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'12',  'maxlength'=>'10')); 
					
					echo '</td>';	
					echo '<td>'.JText::_( 'BLFA_ISPLAYED' ).'<input type="checkbox" name="match_played[]" value="'.($curmatch->m_played?1:0).'" '.($curmatch->m_played?"checked":"").' /></td>';					
						
					echo '<td>'.JText::_( 'BLFA_TIMEE' ).'<input type="text" name="match_time[]" maxlength="5" size="12" value="'.substr($curmatch->m_time,0,5).'" />';
					echo "</tr>";
					echo '<tr><td colspan="5"></td></tr>';
				}
			}
			?>
		</table>
		<table class="adminlist">
			<tr >
				<th  class="title" colspan="3" style=" padding-left:200px;">
					<?php echo JText::_('BLFA_ADDMATCHRESULTS');?>
				</th>
			</tr>
			
			<tr>
				<th>
					<?php echo $lists['teams1']?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_HOMETEAM' ); ?>::<?php echo JText::_( '' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span> 
				</th>
				<th>
					<input name="add_score1" id="add_score1" type="text" maxlength="5" size="5" />:
					<input name="add_score2" id="add_score2" type="text" maxlength="5" size="5" />
					<input type="checkbox" name="extra_timez" id="extra_timez" />&nbsp;ET
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_ET' ); ?>::<?php echo JText::_( '' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span> 
				</th>
				<th>	                   
					 <?php echo $lists['teams2']?>
					 <span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_AWAYTEAM' ); ?>::<?php echo JText::_( '' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span> 
				</th>
			</tr>
			<tr>
				
				<th>
					<?php
						echo JText::_( 'BLFA_DATEE' );
						echo JHTML::_('calendar', date("Y-m-d"), 'tm_date', 'tm_date', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'12',  'maxlength'=>'10')); 
					?>
				</th>
				<th>	
					<input type="checkbox" name="tm_played" id="tm_played"  />
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_PLAYED' ); ?>::<?php echo JText::_( '' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span> 
				</th>
				<th>
					<?php echo JText::_( 'Time:' );?>
					<input type="text" name="match_time_new" id="match_time_new" maxlength="5" size="12" value="00:00" />
					<input type="button" value="<?php echo JText::_( 'BLFA_ADD' ); ?>" onClick="bl_add_match();" />	
				</th>
				
				
			</tr>
		</table>
		
		<input type="hidden" name="return_sh" value="0" />
		<input type="hidden" name="task" value="admin_matchday" />
		<input type="hidden" name="id" value="<?php echo $row->id?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="isapply" value="0" />
		<input type="hidden" name="sid" value="<?php echo $this->s_id;?>" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
