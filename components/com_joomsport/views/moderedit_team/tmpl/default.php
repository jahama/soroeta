<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 

	if(isset($this->message)){
		$this->display('message');
	}
	$row = $this->rows;
	$lists = $this->lists;
	$Itemid = JRequest::getInt('Itemid'); 

?>
<script type="text/javascript">
function bl_submit(task,chk){
	if(chk == 1 && document.adminForm.boxchecked.value == 0){
		alert('<?php echo JText::_('BLFA_SELECTITEM')?>');
	}else{
		document.adminForm.task.value = task;
		document.adminForm.submit();	
	}
}
function getObj(name) {
		  if (document.getElementById)  {  return document.getElementById(name);  }
		  else if (document.all)  {  return document.all[name];  }
		  else if (document.layers)  {  return document.layers[name];  }
		}
</script>
<?php if($this->msg){ ?>
<div class="message"><?php echo $this->msg;?></div>
<?php }?>
<div align="right">
<div style="float:right;padding:0px 5px;width:32px;"><a href="<?php echo JRoute::_( 'index.php?option=com_joomsport&sid='.$this->s_id.'&Itemid='.$Itemid )?>" class="toolbar"><span class="icon-32-cancel"></span><?php echo JText::_('BLFA_CANCEL')?></a></div>
<div style="float:right;padding:0px 5px;width:32px;"><a href="#" class="toolbar" onclick="javascript:submitbutton('team_save');return false;"><span class="icon-32-save"></span><?php echo JText::_('BLFA_SAVE')?></a></div>
</div>
<div style="clear:both;"></div>
<div>

<span><?php echo JText::_('BLFA_TEAM')?></span>

|&nbsp;<span><a href="<?php echo JRoute::_( 'index.php?option=com_joomsport&controller=moder&task=madmin_player&sid='.$this->s_id.'&tid='.$this->tid.'&Itemid='.$Itemid )?>"><?php echo JText::_('BLFA_PLAYER')?></a></span>

|&nbsp;<span><a href="<?php echo JRoute::_( 'index.php?option=com_joomsport&controller=moder&task=matchday_medit&sid='.$this->s_id.'&tid='.$this->tid.'&Itemid='.$Itemid )?>"><?php echo JText::_('BLFA_MATCHDAY')?></a></span>
</div>
<?php

		//$editor =& JFactory::getEditor();
		JHTML::_('behavior.tooltip');
		?>
		<script type="text/javascript">
		
		function Delete_tbl_row(element) {
			var del_index = element.parentNode.parentNode.sectionRowIndex;
			var tbl_id = element.parentNode.parentNode.parentNode.parentNode.id;
			element.parentNode.parentNode.parentNode.deleteRow(del_index);
		}	
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'team_save' || pressbutton == 'team_apply') {
				
				
				if(form.t_name.value != ""){
				
					submitform( pressbutton );
					return;
				}else{	
					alert("BLFA_ENTERNAME");	
				}
			}else{
				submitform( pressbutton );
					return;
			}
		}	
		function delete_logo(){
			getObj("logoiddiv").innerHTML = '';
		}
		</script>
		<form action="" method="post" name="adminForm" enctype="multipart/form-data">
		
		<table class="jsnoborders">
			<tr>
				<td width="100">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_TEAMNAME' ); ?>::<?php echo JText::_( 'BLFA_TEAM_NAME' );?>"><?php echo JText::_( 'Team name' ); ?>
					<img src="components/com_joomsport/images/quest.jpg" border="0" /></span>
				</td>
				<td>
					<input type="text" maxlength="255" size="60" name="t_name" value="<?php echo htmlspecialchars($row->t_name)?>" />
				</td>
			</tr>
			<tr>
				<td width="100">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_CITY' ); ?>::<?php echo JText::_( 'BLFA_TT_CITY' );?>"><?php echo JText::_( 'BLFA_CITY' ); ?>
					<img src="components/com_joomsport/images/quest.jpg" border="0" /></span>
				</td>
				<td>
					<input type="text" maxlength="255" size="60" name="t_city" value="<?php echo htmlspecialchars($row->t_city)?>" />
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
				<td valign="top">
					<?php echo JText::_( 'BLFA_TEAM_LOGO' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_TEAM_LOGO' ); ?>::<?php echo JText::_( 'BLFA_TT_TEAM_LOGO' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span>
				</td>
				<td>
					<input type="file" name="t_logo" />
					<br />
					<div id="logoiddiv">
					<?php
					
					if($row->t_emblem && is_file('media/bearleague/'.$row->t_emblem)){
						echo '<img src="'.JURI::base().'media/bearleague/'.$row->t_emblem.'" width="200" />';
						echo '<input type="hidden" name="istlogo" value="1" />';
						?>
						<a href="javascript:void(0);" title="<?php echo JText::_( 'BLBE_REMOVE' ); ?>" onClick="javascript:delete_logo();"><img src="<?php echo JURI::base();?>components/com_joomsport/images/publish_x.png" title="Remove" /></a>
						</div>
					<?php	
					}
					?>
					</div>
				</td>
			</tr>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLFA_ABOUT_TEAM' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_About_Team' ); ?>::<?php echo JText::_( 'BLFA_TT_ABOUT_TEAM' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php  echo $this->editor->display( 't_descr',  htmlspecialchars($row->t_descr, ENT_QUOTES), '100%', '300', '60', '20', array('pagebreak', 'readmore') ) ;  ?>
					
				</td>
			</tr>
		</table>
		
		<br />
		<div style="margin-top:10px;border:1px solid #BBB;">

		<table style="padding:10px;" class="jsnoborders">
			<tr>
				<td>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JText::_( 'BLFA_UPLFOTO' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_UPLFOTO' ); ?>::<?php echo JText::_( 'BLFA_TT_UPLOAD_PHOTO' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span>
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
				<td>
					<input type="button" style="cursor:pointer;" value="<?php echo JText::_( 'BLFA_UPLOAD' ); ?>" onclick="javascript:submitbutton('team_save');" />
				</td>
			</tr>
		</table>
		<?php
		if(count($lists['photos'])){
		?>
		<table class="adminlist">
			<tr>
				<th class="title" width="30"><?php echo JText::_( 'BLFA_DELETE' ); ?></th>
				<th class="title" width="30"><?php echo JText::_( 'BLFA_DEFAULT' ); ?></th>
				<th class="title" ><?php echo JText::_( 'BLFA_TITLE' ); ?></th>
				<th class="title" width="250"><?php echo JText::_( 'BLFA_IMAGE' ); ?></th>
			</tr>
			<?php
			foreach($lists['photos'] as $photos){
			?>
			<td align="center">
				<a href="javascript:void(0);" title="<?php echo JText::_( 'BLFA_REMOVE' ); ?>" onClick="javascript:Delete_tbl_row(this);"><img src="<?php echo JURI::base();?>components/com_joomsport/images/publish_x.png" title="<?php echo JText::_( 'BLFA_REMOVE' ); ?>" /></a>
			</td>
			<td align="center">
				<?php
				$ph_checked = ($row->def_img == $photos->id) ? 'checked="true"' : "";
				
				?>
				<input type="radio" name="ph_default" value="<?php echo $photos->id;?>" <?php echo $ph_checked?>/>
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
		<input type="hidden" name="option" value="com_joomsport" />
		<input type="hidden" name="controller" value="moder" />
		<input type="hidden" name="task" value="edit_team" />
		<input type="hidden" name="id" value="<?php echo $row->id?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="tid" value="<?php echo $this->tid;?>" />
		<input type="hidden" name="sid" value="<?php echo $this->s_id;?>" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
