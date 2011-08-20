<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
	if(isset($this->message)){
		$this->display('message');
	}
	$row = $this->rows;
	$lists = $this->lists;
	$Itemid = JRequest::getInt('Itemid'); 
?>
<?php if($this->msg){ ?>
<div class="message"><?php echo $this->msg;?></div>
<?php }?>
<div align="right">
<div style="float:right;padding:0px 5px;width:32px;"><a href="#" class="toolbar" onclick="javascript:submitbutton('admin_player');return false;"><span class="icon-32-cancel"></span><?php echo JText::_('BLFA_CLOSE')?></a></div>
<div style="float:right;padding:0px 5px;width:32px;"><a href="#" class="toolbar" onclick="javascript:submitbutton('player_save');return false;"><span class="icon-32-save"></span><?php echo JText::_('BLFA_SAVE')?></a></div>
</div>
<div style="clear:both;"></div>
<?php
		$editor =& JFactory::getEditor();
		JHTML::_('behavior.tooltip');
		?>
		<script type="text/javascript">
		<!--
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			 if(pressbutton == 'player_apply' || pressbutton == 'player_save'){
			 	if(form.first_name.value == '' || form.last_name.value == ''){
			 		alert('<?php echo JText::_( 'BLFA_JSNOTICEPL' ); ?>');
			 	}else if(form.team_id.value == 0){
			 		alert('<?php echo JText::_( 'BLFA_JSNOTICETM' ); ?>');
			 	}else{
			 		submitform( pressbutton );
					return;
			 	}
			 }else{
				submitform( pressbutton );
					return;
			 }		
		}	
		
		function Delete_tbl_row(element) {
			var del_index = element.parentNode.parentNode.sectionRowIndex;
			var tbl_id = element.parentNode.parentNode.parentNode.parentNode.id;
			element.parentNode.parentNode.parentNode.deleteRow(del_index);
		}
		//-->
		</script>
		<?php
		if(!count($row)){
			echo "<div id='system-message'>".JText::_('BLFA_NOITEMS')."</div>";
		}
		?>
		<form action="" method="post" name="adminForm" enctype="multipart/form-data">
		
		<table class="jsnoborders">
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLFA_FIRSTNAME' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_FIRSTNAME' ); ?>::<?php echo JText::_( 'BLFA_TT_FIRST_NAME' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span>
				</td>
				<td>
					<input type="text" maxlength="255" size="60" name="first_name" value="<?php echo $row->first_name?>" />
				</td>
			</tr>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLFA_LASTNAME' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_LASTNAME' ); ?>::<?php echo JText::_( 'BLFA_TT_LAST_NAME' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span>
				</td>
				<td>
					<input type="text" maxlength="255" size="60" name="last_name" value="<?php echo $row->last_name?>" />
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
					<?php echo JText::_( 'BLFA_POSITION' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_POSITION' ); ?>::<?php echo JText::_( 'BLFA_TT_POSITION' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $lists['pos'];?>
				</td>
			</tr>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLFA_TEAM' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_TEAM' ); ?>::<?php echo JText::_( 'BLFA_TT_TEAM' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $lists['teams'];?>
				</td>
			</tr>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLFA_ABOUT_PLAYER' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLFA_ABOUT_PLAYER' ); ?>::<?php echo JText::_( 'BLFA_TT_ABOUT_PLAYER' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php  echo $this->editor->display( 'about',  htmlspecialchars($row->about, ENT_QUOTES), '550', '300', '60', '20', array('pagebreak', 'readmore') ) ;  ?>
					
				</td>
			</tr>
			
		</table>
		<div style="margin-top:10px;border:1px solid #BBB;">
		<table style="padding:10px;">
			<tr>
				<td>
					<?php echo JText::_('BLFA_UPLFOTO');?>
					<span class="editlinktip hasTip" title="<?php echo JText::_('BLFA_UPLFOTO');?>::<?php echo JText::_( 'BLFA_TT_UPLOAD_PL_PHOTO' );?>"><img src="components/com_joomsport/images/quest.jpg" border="0" /></span>
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
				<td>
					<input type="button" style="cursor:pointer;" value="<?php echo JText::_('BLFA_UPLOAD')?>" onclick="javascript:submitbutton('player_apply');" />
				</td>
			</tr>
		</table>
		<?php
		if(count($lists['photos'])){
		?>
		<table class="adminlist">
			<tr>
				<th class="title" width="30"><?php echo JText::_('BLFA_DELETE')?></th>
				<th class="title" width="30"><?php echo JText::_('BLFA_DEFAULT')?></th>
				<th class="title" ><?php echo JText::_('BLFA_TITLE')?></th>
				<th class="title" width="250"><?php echo JText::_('BLFA_IMAGE')?></th>
			</tr>
			<?php
			foreach($lists['photos'] as $photos){
			?>
			<td align="center">
				<a href="javascript:void(0);" title="<?php echo JText::_('BLFA_REMOVE')?>" onClick="javascript:Delete_tbl_row(this);"><img src="<?php echo JURI::base();?>components/com_joomsport/images/publish_x.png" title="<?php echo JText::_('BLFA_REMOVE')?>" /></a>
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
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="id" value="<?php echo $row->id?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="sid" value="<?php echo $this->s_id;?>" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
