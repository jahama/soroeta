<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
jimport('joomla.html.pane');
$tabs = &JPane::getInstance('tabs', array('allowAllClose' => true)); 
	if(isset($this->message)){
		$this->display('message');
	}
$Itemid = JRequest::getInt('Itemid'); 

JHTML::_('behavior.tooltip');
?>
<?php if ( $this->params->def( 'show_page_title', 1 ) ) : ?>
<div class="componentheading<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
	<?php echo $this->escape($this->params->get('page_title')); ?>
</div>
<?php endif; ?>

<?php
//echo '<div id="d_name">'.$this->md_title."</div>";
?>
<?php
if($this->tmpl != 'component'){
	
	$lnk = "window.open('".JURI::base()."index.php?&tmpl=component&option=com_joomsport&amp;task=calendar&amp;sid=".$this->sid."','jsmywindow','width=600,height=700');";
}else{
	$lnk = "window.print();";
}
?>
<div style="float:right">
	<img onClick="<?php echo $lnk;?>" src="components/com_joomsport/images/printButton.png" border="0" alt="Print" style="cursor:pointer;" title="Print" />
</div>
<table style="margin-top:15px;" border="0" cellpadding="5" cellspacing="0" width="100%" class="jsnoborders">
	<?php
		$old_md = 0;
		for($j=0;$j<count($this->matchs);$j++){
			$match = $this->matchs[$j];
			if( $j && $old_md != $match->mdid){
				echo "<tr><td colspan='6'><hr /></td></tr>";
			}
			
		?>
		<?php 
			
			 ob_start();
   
   
			?>
				<table cellpadding="3" border=0 width="100%">
					<?php
					$ev_count = (count($match->m_events_home) > count($match->m_events_away)) ? (count($match->m_events_home)) : (count($match->m_events_home));
					
					for($i=0;$i<$ev_count;$i++){
					?>
					<tr>
						<?php
						if(isset($match->m_events_home[$i])){
							echo '<td class="home_event_tip" nowrap>';
							if($match->m_events_home[$i]->e_img && is_file('media/bearleague/events/'.$match->m_events_home[$i]->e_img)){
								echo '<img height="15" src="'.JURI::base().'media/bearleague/events/'.$match->m_events_home[$i]->e_img.'" title="'.$match->m_events_home[$i]->e_name.'" />';
							}else{ 
								echo $match->m_events_home[$i]->e_name;
							}
							echo "&nbsp;".$match->m_events_home[$i]->p_name;
							echo '</td>';
							?>
							<td class="home_event_count">
							<?php
							if($match->m_events_home[$i]->ecount){
								echo $match->m_events_home[$i]->ecount;
							}else echo "&nbsp;";
							?>
							</td>
							<td class="home_event_minute">
							<?php
							if($match->m_events_home[$i]->minutes){
								echo $match->m_events_home[$i]->minutes.'"';
							}else echo "&nbsp;";
							?>
							</td>
							<?php
						}else{
							echo '<td style="padding:0px" colspan="3" width="50%">&nbsp;</td>';
						}
						if(isset($match->m_events_away[$i])){
							?>
							<td class="away_event_minute">
							<?php
							if($match->m_events_away[$i]->minutes){
								echo $match->m_events_away[$i]->minutes.'"';
							}else echo "&nbsp;";
							?>
							</td>
							<td class="away_event_count">
							<?php
							if($match->m_events_away[$i]->ecount){
								echo $match->m_events_away[$i]->ecount;
							}else echo "&nbsp;";
							?>
							</td>
							<?php
							echo '<td class="away_event_tip" nowrap>';
							if($match->m_events_away[$i]->e_img && is_file('media/bearleague/events/'.$match->m_events_away[$i]->e_img)){
								echo '<img height="15" src="'.JURI::base().'media/bearleague/events/'.$match->m_events_away[$i]->e_img.'" title="'.$match->m_events_away[$i]->e_name.'" />';
							}else{ 
								echo $match->m_events_away[$i]->e_name;
							}
							echo "&nbsp;".$match->m_events_away[$i]->p_name;
							echo '</td>';
						}else{
							echo '<td style="padding:0px" colspan="3" width="50%">&nbsp;</td>';
						}
						?>
					</tr>
					<?php } ?>
				</table>
				<?php
				 $ret = ob_get_contents();
				ob_end_clean();
				
				?>
				
		<tr>
			<td>
			<?php 
				if($old_md != $match->mdid){
				echo $match->m_name;
				}else{
					echo '&nbsp;';
				}
			?>
			</td>
			<td>
			<?php echo date_bl($match->m_date,$match->m_time);?>
			</td>
			<td class="team_thome"><?php echo $match->home?></td>
			<td class="match_result" nowrap="nowrap">
			<a href="<?php echo JRoute::_('index.php?option=com_joomsport&task=view_match&id='.$match->id.'&Itemid='.$Itemid)?>">
				
				<?php 
				if($match->m_played == 1){
				$title = $match->home." ".$match->score1." : ".$match->score2.(($this->enbl_extra && $match->is_extra)?(" (".$this->bl_lang['BL_RES_EXTRA'].")"):"")." ".$match->away;
				?>
				<?php
					echo $match->score1?> : <?php echo $match->score2; if($this->enbl_extra && $match->is_extra){ echo " (".$this->bl_lang['BL_RES_EXTRA'].")";}
				
				}else{
					echo " - : - ";
				}
				echo '</a>';
				?>
			</td>
			<td class="team_taway"><?php echo $match->away?></td>
		</tr>
			
				
		<?php
		$old_md = $match->mdid;
		}
	?>
	
</table>
<?php if($this->tmpl != 'component'){?>
<div align="right" style="padding-bottom:30px;"><div style="width:100px;float:right;text-align:right"><a href="javascript:void(0);" onclick="history.back(-1);"><?php echo $this->bl_lang["BL_BACK"]?></a></div></div>
<?php } ?>