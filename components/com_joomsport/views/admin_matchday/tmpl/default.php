<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
	if(isset($this->message)){
		$this->display('message');
	}
	$rows = $this->rows;
	$lists = $this->lists;
	$page = $this->page;
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
</script>
<div align="right">
<div style="float:left;font-size:20px;padding:15px 0px;"><?php echo JText::_('BLFA_MATCHDAYLIST')?></div>
<div style="float:right;padding:0px 5px;width:32px;"><a href="javascript:void(0);" class="toolbar" onclick="javascript:submitbutton('matchday_add');return false;"><span class="icon-32-new"></span><?php echo JText::_('BLFA_NEW')?></a></div>
<div style="float:right;padding:0px 5px;width:32px;"><a href="javascript:void(0);" class="toolbar" onclick="javascript:bl_submit('matchday_edit',1);return false;"><span class="icon-32-edit"></span><?php echo JText::_('BLFA_EDIT')?></a></div>
<div style="float:right;padding:0px 5px;width:32px;"><a href="javascript:void(0);" class="toolbar" onclick="javascript:bl_submit('matchday_del',1);return false;"><span class="icon-32-delete"></span><?php echo JText::_('BLFA_DELETE')?></a></div>
</div>
<div style="clear:both;"></div>
<div>
<span><a href="<?php echo JRoute::_( 'index.php?option=com_joomsport&controller=admin&task=admin_team&sid='.$this->s_id."&Itemid=".$Itemid )?>"><?php echo JText::_('BLFA_ADMIN_TEAM')?></a></span>
|&nbsp;<span><a href="<?php echo JRoute::_( 'index.php?option=com_joomsport&controller=admin&task=admin_player&sid='.$this->s_id.'&Itemid='.$Itemid )?>"><?php echo JText::_('BLFA_PLAYER')?></a></span>
|&nbsp;<span><?php echo JText::_('BLFA_MATCHDAY')?></span>
</div>
<script type="text/javascript">
		<!--
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			
				submitform( pressbutton );
					return;
		}	
		//-->
		</script>
		<?php
		if(!count($rows)){
			echo "<div id='system-message'><dd class='notice'><ul>".JText::_('BLFA_NOITEMS')."</ul></dd></div>";
		}
		?>
		<form action="" method="post" name="adminForm">
		<table class="adminlist">
		<thead>
			<tr>
				<th width="2%" align="left">
					<?php echo JText::_( 'BLFA_NUM' ); ?>
				</th>
				<th width="2%">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" />
				</th>
				<th class="title">
					<?php echo JText::_( 'BLFA_MATCHDAY' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_( 'BLFA_TOURNAMENT' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_( 'BLFA_SEASON' ); ?>
				</th>
				
			</tr>
		</thead>
		<tfoot>
		<tr>
			<td colspan="13">
				<?php echo $page->getListFooter(); ?>
			</td>
		</tr>
		</tfoot>
		<tbody>
		<?php
		$k = 0;
		if( count( $rows ) ) {
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row 	= $rows[$i];
			JFilterOutput::objectHtmlSafe($row);
			$link = JRoute::_( 'index.php?option=com_joomsport&controller=admin&task=matchday_edit&cid[]='. $row->id.'&sid='.$this->s_id.'&Itemid='.$Itemid );
			$checked 	= @JHTML::_('grid.checkedout',   $row, $i );
			//$published 	= JHTML::_('grid.published', $row, $i);
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $page->getRowOffset( $i ); ?>
				</td>
				<td>
					<?php echo $checked; ?>
				</td>
				<td>
					<?php
						echo '<a href="'.$link.'">'.$row->m_name.'</a>';
					?>
				</td>
				<td>
					<?php echo $row->tourn;?>
				</td>
				<td>
					<?php echo $row->s_name;?>
				</td>
				
			</tr>
			<?php
		}
		} 
		?>
		</tbody>
		</table>
		<input type="hidden" name="task" value="admin_matchday" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="sid" value="<?php echo $this->s_id;?>" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
