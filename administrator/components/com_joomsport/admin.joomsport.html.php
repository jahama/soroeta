<?php
/*
http://BearDev.com
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<style>
.etabs_vis{
	float:left;
	padding:5px 20px 5px 30px;
	margin:1px;
	cursor:pointer;
	background-color:#cfcfcf;
	border:1px solid #cfcfcf;
	background-repeat:no-repeat;
	background-position:5px 5px;
	color:#333;
}
.etabs_hide{
	float:left;
	padding:5px 20px 5px 30px;
	margin:1px;
	cursor:pointer;
	background-color:#eee;
	border:1px solid #cfcfcf;
	background-repeat:no-repeat;
	background-position:5px 5px;
	color:#333;
	
}
.tabdiv{
	border:1px solid #cfcfcf;
	padding:7px;
}

.icon-48-tourn{
	background-image:url('components/com_joomsport/img/tourn48.png');
}
.icon-48-season{
	background-image:url('components/com_joomsport/img/season48.png');
}
.icon-48-team{
	background-image:url('components/com_joomsport/img/team48.png');
}
.icon-48-about{
	background-image:url('components/com_joomsport/img/about48.png');
}
.icon-48-group{
	background-image:url('components/com_joomsport/img/group48.png');
}
.icon-48-config{
	background-image:url('components/com_joomsport/img/config48.png');
}
.icon-48-event{
	background-image:url('components/com_joomsport/img/events48.png');
}

.icon-48-match{
	background-image:url('components/com_joomsport/img/match48.png');
}
.icon-48-additional{
	background-image:url('components/com_joomsport/img/additional48.png');
}
.icon-48-player{
	background-image:url('components/com_joomsport/img/players48.png');
}
.icon-48-moder{
	background-image:url('components/com_joomsport/img/moder48.png');
}
</style>
<?php 
class joomsport_html
{
	function JS_getObj() {
		?>
		<script language="javascript" type="text/javascript">
		function getObj(name) {
		  if (document.getElementById)  {  return document.getElementById(name);  }
		  else if (document.all)  {  return document.all[name];  }
		  else if (document.layers)  {  return document.layers[name];  }
		}
		function JS_addSelectedToList( frmName, srcListName, tgtListName ) {
			var form = eval( 'document.' + frmName );
			var srcList = eval( 'form.' + srcListName );
			var tgtList = eval( 'form.' + tgtListName );

			var srcLen = srcList.length;
			var tgtLen = tgtList.length;
			var tgt = "x";

			//build array of target items
			for (var i=tgtLen-1; i > -1; i--) {
				tgt += "," + tgtList.options[i].value + ","
			}

			//Pull selected resources and add them to list
			//for (var i=srcLen-1; i > -1; i--) {
			for (var i=0; i < srcLen; i++) {
				if (srcList.options[i].selected && tgt.indexOf( "," + srcList.options[i].value + "," ) == -1) {
					opt = new Option( srcList.options[i].text, srcList.options[i].value );
					tgtList.options[tgtList.length] = opt;
				}
			}
		}

		function JS_delSelectedFromList( frmName, srcListName ) {
			var form = eval( 'document.' + frmName );
			var srcList = eval( 'form.' + srcListName );

			var srcLen = srcList.length;

			for (var i=srcLen-1; i > -1; i--) {
				if (srcList.options[i].selected) {
					srcList.options[i] = null;
				}
			}
		}
		</script>
		<?php
	}
	////////---------------moderators--------------////
	function ModerList( $rows, $page, $option )
	{
		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');
		JHTML::_('behavior.tooltip');
		
		?>
		<?php
		if(!count($rows)){
			echo "<div id='system-message'><dd class='notice'><ul>".JText::_('BLBE_NOITEMS')."</ul></dd></div>";
		}
		?>
		<form action="index.php?option=<?php echo $option;?>" method="post" name="adminForm">
		<table class="adminlist">
		<thead>
			<tr>
				<th width="2%" align="left">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				<th width="2%">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" />
				</th>
				<th class="title">
					<?php echo JText::_( 'User' ); ?>
				</th>
				<th width="25%">
					<?php echo JText::_( 'BLBE_TEAM' ); ?>
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
			$link = JRoute::_( 'index.php?option=com_joomsport&task=moder_edit&cid[]='. $row->id );
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
						echo '<a href="'.$link.'">'.$row->name.'</a>';
					?>
				</td>
				<td>
					<?php
					if(isset($row->teams) && count($row->teams)){
						foreach($row->teams as $tm){
							echo $tm."<br/>";
						}
					}
					?>
				</td>
				
			</tr>
			<?php
		}
		} 
		?>
		</tbody>
		</table>
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="moder_list" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
	<?php
	}
	
	function bl_editModer($lists, $option){
		$editor =& JFactory::getEditor();
		JHTML::_('behavior.tooltip');
		joomsport_html::JS_getObj();
		?>
		<script type="text/javascript">
		Joomla.submitbutton = function(task) {
			submitbutton(task);
		}
		function submitbutton(pressbutton) {
			var form = document.adminForm;
				var srcListName = 'teams_season';
					var srcList = eval( 'form.' + srcListName );
					var srcLen = srcList.length;
					for (var i=0; i < srcLen; i++) {
						srcList.options[i].selected = true;
					} 
					submitform( pressbutton );
					return;
		}	
		</script>
		<form action="index.php?option=<?php echo $option?>" method="post" name="adminForm">
		<table  border="0">
			<tr>
				<td>
				
				</td>
				<td>
					<?php echo $lists['moder'];?>
				</td>
			</tr>
			<tr>
				<td width="150">
					<?php echo JText::_( 'BLBE_ADD_TEAMS' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_ADD_TEAMS' ); ?>::<?php echo JText::_( 'BLBE_TT_MOD_ADD_TEAMS' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td width="150">
					<?php echo $lists['teams'];?>
				</td>
				<td valign="middle" width="60" align="center">
					<input type="button" value=">>" onClick="javascript:JS_addSelectedToList('adminForm','teams_id','teams_season');" /><br />
					<input type="button" value="<<" onClick="javascript:JS_delSelectedFromList('adminForm','teams_season');" />
				</td>
				<td >
					<?php echo $lists['teams2'];?>
				</td>
			</tr>
		</table>
		
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="moder_list" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php
	}
	
	function bl_Config($lists, $option){
		?>
		<?php
		JHTML::_('behavior.tooltip');
		?>
		<script type="text/javascript" src="components/com_joomsport/color_piker/201a.js"></script>
		
		<form action="index.php?option=<?php echo $option;?>" method="post" name="adminForm">
		<table class="adminlist">
			<tr>
				<td>
					<?php echo JText::_( 'BLBE_DATECONFIG' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_DATECONFIG' ); ?>::<?php echo JText::_( 'BLBE_TT_DATECONFIG' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $lists['data_sel'] ?>
				</td>
			
			</tr>
			<tr>
				<td>
					<?php echo JText::_( 'BLBE_YTEAMCOLOR' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_YTEAMCOLOR' ); ?>::<?php echo JText::_( 'BLBE_TT_YTEAMCOLOR' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<div id="colorpicker201" class="colorpicker201"></div>
					<input type="button" onclick="showColorGrid2('yteam_color','sample_1');" value="...">&nbsp;<input type="text" name="yteam_color" id="yteam_color" size="9" maxlength="30" value="<?php echo $lists['yteam_color'];?>" /><input type="text" id="sample_1" size="1" value="" style="background-color:<?php echo $lists['yteam_color']?>" />
				</td>
			
			</tr>
		</table>
		
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="config" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php
	}
	
	function bl_TournList( $rows, $page, $option )
	{
		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');
		JHTML::_('behavior.tooltip');
		?>
		<?php
		if(!count($rows)){
			echo "<div id='system-message'><dd class='notice'><ul>".JText::_('BLBE_NOITEMS')."</ul></dd></div>";
		}
		?>
		<form action="index.php?option=<?php echo $option;?>" method="post" name="adminForm">
		<table class="adminlist">
		<thead>
			<tr>
				<th width="2%" align="left">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				<th width="2%">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" />
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_TOURNAMENT' ); ?>
				</th>
				<th width="5%">
					<?php echo JText::_( 'Published' ); ?>
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
			$link = JRoute::_( 'index.php?option=com_joomsport&task=tour_edit&cid[]='. $row->id );
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
						echo '<a href="'.$link.'">'.$row->name.'</a>';
					?>
				</td>
				<td align="center">
					<?php 
					if(!$row->published){
						?>
						<a title="Publish Item" onclick="return listItemTask('cb<?php echo $i?>','tour_publ')" href="javascript:void(0);">
						<img border="0" alt="Unpublished" src="components/com_joomsport/img/publish_x.png"/></a>
						<?php
					}else{
						?>
						<a title="Unpublish Item" onclick="return listItemTask('cb<?php echo $i?>','tour_unpubl')" href="javascript:void(0);">
						<img border="0" alt="Published" src="components/com_joomsport/img/tick.png"/></a>
						<?php
					}
					?>
				</td>
				
			</tr>
			<?php
		}
		} 
		?>
		</tbody>
		</table>
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
	<?php
	}
	
	function bl_editTourn($row, $lists, $option){
		$editor =& JFactory::getEditor();
		JHTML::_('behavior.tooltip');
		joomsport_html::JS_getObj();
		?>
		<script type="text/javascript">
		Joomla.submitbutton = function(task) {
			submitbutton(task);
		}
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			 if(pressbutton == 'tour_apply' || pressbutton == 'tour_save'){
			 	if(form.name.value != ''){
					submitform( pressbutton );
					return;
				}else{
					getObj('trname').style.border = "1px solid red";
					alert("<?php echo JText::_('BLBE_JSMDNOT1');?>");
					
					
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
		<form action="index.php?option=<?php echo $option?>" method="post" name="adminForm" enctype="multipart/form-data">
		
		<table>
			<tr>
				<td width="120">
					<?php echo JText::_( 'BLBE_TOURNAMENTNAME' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_TOURNAMENTNAME' ); ?>::<?php echo JText::_( '' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<input type="text" maxlength="255" size="60" name="name" id="trname" value="<?php echo $row->name?>" />
				</td>
			</tr>
			<tr>
				<td width="100">
					<?php echo JText::_( 'Publish' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'Publish' ); ?>::<?php echo JText::_( 'Publishing' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $lists['published'];?>
				</td>
			</tr>
			<tr>
				<td valign="top">
					<?php echo JText::_( 'BLBE_TOURN_LOGO' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_TOURN_LOGO' ); ?>::<?php echo JText::_( 'BLBE_TT_TOURN_LOGO' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span> 
				</td>
				<td>
					<input type="file" name="t_logo" />&nbsp;<input type="button" value="<?php echo JText::_('BLFA_TT_UPLOAD_PHOTO');?>" onClick="if(document.adminForm.t_logo.value){submitform('tour_apply');};" />
					<br />
					<?php
					
					if($row->logo && is_file('../media/bearleague/'.$row->logo)){
						echo '<div id="logoiddiv"><img width="120" src="'.JURI::base().'../media/bearleague/'.$row->logo.'">';
						echo '<input type="hidden" name="istlogo" value="1" />';
						?>
						<a href="javascript:void(0);" title="<?php echo JText::_( 'BLBE_REMOVE' ); ?>" onClick="javascript:delete_logo();"><img src="<?php echo JURI::base();?>components/com_joomsport/img/publish_x.png" title="Remove" /></a>
						</div>
					<?php
					}
					?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JText::_( 'BLBE_ABOUT_TOURN' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_ABOUT_TOURN' ); ?>::<?php echo JText::_( 'BLBE_TT_ABOUT_TOURN' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $editor->display( 'descr',  htmlspecialchars($row->descr, ENT_QUOTES), '550', '300', '60', '20', array('pagebreak', 'readmore') ) ;  ?>
				</td>
			</tr>
		</table>
		
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="id" value="<?php echo $row->id?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php
	}
	
	///-----------------------seasons---------------------------///
	function bl_SeasonList( $rows, $page, $option )
	{
		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');
		JHTML::_('behavior.tooltip');
		?>
		<?php
		if(!count($rows)){
			echo "<div id='system-message'><dd class='notice'><ul>".JText::_('BLBE_NOITEMS')."</ul></dd></div>";
		}
		?>
		<form action="index.php?option=<?php echo $option;?>" method="post" name="adminForm">
		<table class="adminlist">
		<thead>
			<tr>
				<th width="2%" align="left">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				<th width="2%" align="left">
					<?php echo JText::_( 'ID' ); ?>
				</th>
				<th width="2%">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" />
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_SEASON' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_TOURNAMENT' ); ?>
				</th>
				<th width="5%">
					<?php echo JText::_( 'Published' ); ?>
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
			$link = JRoute::_( 'index.php?option=com_joomsport&task=season_edit&cid[]='. $row->id );
			$checked 	= @JHTML::_('grid.checkedout',   $row, $i );
			//$published 	= JHTML::_('grid.published', $row, $i);
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $page->getRowOffset( $i ); ?>
				</td>
				<td>
					<?php echo $row->id; ?>
				</td>
				<td>
					<?php echo $checked; ?>
				</td>
				<td>
					<?php
						echo '<a href="'.$link.'">'.$row->s_name.'</a>';
					?>
				</td>
				<td>
					<?php echo $row->name; ?>
				</td>
				<td align="center">
					<?php 
					if(!$row->published){
						?>
						<a title="Publish Item" onclick="return listItemTask('cb<?php echo $i?>','season_publ')" href="javascript:void(0);">
						<img border="0" alt="Unpublished" src="components/com_joomsport/img/publish_x.png"/></a>
						<?php
					}else{
						?>
						<a title="Unpublish Item" onclick="return listItemTask('cb<?php echo $i?>','season_unpubl')" href="javascript:void(0);">
						<img border="0" alt="Published" src="components/com_joomsport/img/tick.png"/></a>
						<?php
					}
					?>
				</td>
				
			</tr>
			<?php
		}
		} 
		?>
		</tbody>
		</table>
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="season_list" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
	<?php
	}
	
	function bl_editSeason($row, $lists, $option){
		$editor =& JFactory::getEditor();
		JHTML::_('behavior.tooltip');
		joomsport_html::JS_getObj();
		require_once(JPATH_ROOT.DS.'components'.DS.'com_joomsport'.DS.'includes'.DS.'tabs.php');
		$etabs = new esTabs();
		?>
		<script type="text/javascript" src="components/com_joomsport/color_piker/201a.js"></script>
		<script type="text/javascript">
		var colors_count = parseInt('<?php echo count($lists['colors'])?count($lists['colors']):1?>');
		Joomla.submitbutton = function(task) {
			submitbutton(task);
		}
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'season_save' || pressbutton == 'season_apply') {
				if(form.s_name.value != ''){
					if(form.s_win_point.value == '' || form.s_draw_point.value == '' || form.s_lost_point.value == '' || (getObj('s_enbl_extra').checked && (form.s_extra_win.value == '' || form.s_extra_lost.value == ''))){
						alert("<?php echo JText::_( 'BLBE_JSMDNOT8' ); ?>");

					}else
					if(form.t_id.value != "0"){
					var srcListName = 'teams_season';
						var srcList = eval( 'form.' + srcListName );
					
						var srcLen = srcList.length;
					
						for (var i=0; i < srcLen; i++) {
								srcList.options[i].selected = true;
						} 
						
						var srcListName2 = 'usr_admins';
						var srcList2 = eval( 'form.' + srcListName2 );
					
						var srcLen2 = srcList2.length;
					
						for (var i=0; i < srcLen2; i++) {
								srcList2.options[i].selected = true;
						} 
						
						submitform( pressbutton );
						return;
					}else{	
						alert("<?php echo JText::_( 'BLBE_JSMDNOT9' ); ?>");	

					}
				}else{
					getObj("easname").style.border = "1px solid red";
					alert("<?php echo JText::_( 'BLBE_JSMDNOT10' ); ?>");	
				}	
			}else{
				submitform( pressbutton );
					return;
			}
		}	
		
		function showopt(){
			if(getObj('s_enbl_extra').checked){
				getObj('extraoptions').style.visibility = 'visible';
			}else{
				getObj('extraoptions').style.visibility = 'hidden';
			}
		}
		
		function add_colors(){
			var cell = document.createElement("div");
			colors_count++;
			var input_hidden = document.createElement("input");
			input_hidden.type = "text";
			input_hidden.name = 'input_field_'+colors_count;
			input_hidden.id = 'input_field_'+colors_count;
			input_hidden.value = '';
			input_hidden.size = 9;
			var input_hidden2 = document.createElement("input");
			input_hidden2.type = "text";
			input_hidden2.id = 'sample_'+colors_count;
			input_hidden2.value = '';
			input_hidden2.size = 1;
			var input_hidden3 = document.createElement("input");
			input_hidden3.type = "text";
			input_hidden3.name = 'place_'+colors_count;
			input_hidden3.value = '';
			input_hidden3.size = 5;
			cell.innerHTML = 'Color: <input type="button" onclick="showColorGrid2(\'input_field_'+colors_count+'\',\'sample_'+colors_count+'\');" value="...">&nbsp;';
			
			var txtnode2 = document.createTextNode(" Place: ");
			cell.appendChild(input_hidden);
			cell.appendChild(input_hidden2);
			cell.appendChild(txtnode2);
			
			cell.appendChild(input_hidden3);
			
			getObj('app_newcol').appendChild(cell);
			document.adminForm.col_count.value = colors_count;
		}
		</script>
		<form action="index.php?option=<?php echo $option?>" method="post" name="adminForm">
		<?php
	$etabs->newTab(JText::_( 'BLBE_MAIN' ),'main_conf','','vis');
	$etabs->newTab(JText::_( 'BLBE_TABLEV' ),'esport_conf','');
	$etabs->newTab(JText::_( 'BLBE_TTCOLOR' ),'col_conf','');
	?>
		<div style="clear:both"></div>
		<div id="main_conf_div" class="tabdiv">
		<table>
			<tr>
				<td width="150">
					<?php echo JText::_( 'BLBE_SEASONNAME' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_SEASONNAME' ); ?>::<?php echo JText::_( '' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<input type="text" maxlength="255" size="60" name="s_name" id="easname" value="<?php echo $row->s_name?>" />
				</td>
			</tr>
			<tr>
				<td width="150">
					<?php echo JText::_( 'BLBE_SELTOURNAMENT' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_SELTOURNAMENT' ); ?>::<?php echo JText::_( 'BLBE_TT_SELTOURNAMENT' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $lists['tourn'];?>
				</td>
			</tr>
			<tr>
				<td width="150">
					<?php echo JText::_( 'Publish' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'Publish' ); ?>::<?php echo JText::_( 'Publishing' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $lists['published'];?>
				</td>
			</tr>
			<tr>
				<td width="150">
					<?php echo JText::_( 'BLBE_GROUPS' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_GROUPS' ); ?>::<?php echo JText::_( 'BLBE_TT_GROUPS' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $lists['s_groups'];?>
				</td>
			</tr>
			
			<tr>
				<td width="150">
					<?php echo JText::_( 'BLBE_WPH' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_WPH' ); ?>::<?php echo JText::_( 'BLBE_TT_WPH' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<input type="text" maxlength="5" size="10" name="s_win_point" value="<?php echo floatval($row->s_win_point)?>" />
				</td>
			</tr>
			<tr>
				<td width="150">
					<?php echo JText::_( 'BLBE_WPA' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_WPA' ); ?>::<?php echo JText::_( 'BLBE_TT_WPA' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<input type="text" maxlength="5" size="10" name="s_win_away" value="<?php echo floatval($row->s_win_away)?>" />
				</td>
			</tr>
			<tr>
				<td width="150">
					<?php echo JText::_( 'BLBE_DPH' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_DPH' ); ?>::<?php echo JText::_( 'BLBE_TT_DPH' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<input type="text" maxlength="5" size="10" name="s_draw_point" value="<?php echo floatval($row->s_draw_point)?>" />
				</td>
			</tr>
			<tr>
				<td width="150">
					<?php echo JText::_( 'BLBE_DPA' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_DPA' ); ?>::<?php echo JText::_( 'BLBE_TT_DPA' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<input type="text" maxlength="5" size="10" name="s_draw_away" value="<?php echo floatval($row->s_draw_away)?>" />
				</td>
			</tr>
			<tr>
				<td width="150">
					<?php echo JText::_( 'BLBE_LPH' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_LPH' ); ?>::<?php echo JText::_( 'BLBE_TT_LPH' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<input type="text" maxlength="5" size="10" name="s_lost_point" value="<?php echo floatval($row->s_lost_point)?>" />
				</td>
			</tr>
			<tr>
				<td width="150">
					<?php echo JText::_( 'BLBE_LPA' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_LPA' ); ?>::<?php echo JText::_( 'BLBE_TT_LPA' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<input type="text" maxlength="5" size="10" name="s_lost_away" value="<?php echo floatval($row->s_lost_away)?>" />
				</td>
			</tr>
			<tr>
				<td width="150">
					<?php echo JText::_( 'BLBE_EXTIME' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_EXTIME' ); ?>::<?php echo JText::_( 'BLBE_TT_EXTIME' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<input type="checkbox" name="s_enbl_extra" id="s_enbl_extra" value="1" onclick="javascript:showopt();" <?php if($row->s_enbl_extra) { echo "checked";}?> />
				</td>
			</tr>
			<tr>
				<td id="extraoptions" colspan="2" <?php if(!$row->s_enbl_extra){echo "style='visibility:hidden';";}?>>	
					<table cellpadding="1" cellspacing="0">	
						<tr>
							<td width="150">
								<?php echo JText::_( 'BLBE_WPEXTIME' ); ?>
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_WPEXTIME' ); ?>::<?php echo JText::_( 'BLBE_TT_WPEXTIME' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
							</td>
							<td>
								<input type="text" maxlength="5" size="10" name="s_extra_win" value="<?php echo floatval($row->s_extra_win)?>" />
							</td>
						</tr>
						<tr>
							<td width="150">
								<?php echo JText::_( 'BLBE_LPEXTIME' ); ?>
								<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_LPEXTIME' ); ?>::<?php echo JText::_( 'BLBE_TT_LPEXTIME' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
							</td>
							<td>
								<input type="text" maxlength="5" size="10" name="s_extra_lost" value="<?php echo floatval($row->s_extra_lost)?>" />
							</td>
						</tr>
					</table>		
				</td>		
			</tr>
			<tr>
				<td width="150">
					<?php echo JText::_( 'BLBE_ABOUT_SEASON' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_ABOUT_SEASON' ); ?>::<?php echo JText::_( 'BLBE_TT_ABOUT_SEASON' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $editor->display( 's_descr',  htmlspecialchars($row->s_descr, ENT_QUOTES), '550', '300', '60', '20', array('pagebreak', 'readmore') ) ;  ?>
				</td>
			</tr>
		</table>
		
		<table  border="0">
			<tr>
				<td width="150">
					<?php echo JText::_( 'BLBE_ADD_TEAMS' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_ADD_TEAMS' ); ?>::<?php echo JText::_( 'BLBE_TT_ADD_TEAMS' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td width="150">
					<?php echo $lists['teams'];?>
				</td>
				<td valign="middle" width="60" align="center">
					<input type="button" value=">>" onClick="javascript:JS_addSelectedToList('adminForm','teams_id','teams_season');" /><br />
					<input type="button" value="<<" onClick="javascript:JS_delSelectedFromList('adminForm','teams_season');" />
				</td>
				<td >
					<?php echo $lists['teams2'];?>
				</td>
			</tr>
		</table>
		<br />
		<table  border="0">
			<tr>
				<td width="150">
					<?php echo JText::_( 'BLBE_ADD_MOD' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_ADD_MOD' ); ?>::<?php echo JText::_( 'BLBE_TT_ADD_MOD' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>

				</td>
				<td width="150">
					<?php echo $lists['usrlist'];?>
				</td>
				<td valign="middle" width="60" align="center">
					<input type="button" value=">>" onClick="javascript:JS_addSelectedToList('adminForm','usracc_id','usr_admins');" /><br />
					<input type="button" value="<<" onClick="javascript:JS_delSelectedFromList('adminForm','usr_admins');" />
				</td>
				<td >
					<?php echo $lists['usrlist_vyb'];?>
				</td>
			</tr>
		</table>
		<br />
		
		</div>
		<div id="esport_conf_div" class="tabdiv" style="display:none;">
		
		<table>
			<tr>
				<td colspan="2" style="font-weight:bold"><?php echo JText::_( 'BLBE_TOURN_TABLE' ); ?><span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_TOURN_TABLE' ); ?>::<?php echo JText::_( 'BLBE_TT_TOURN_TABLE' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span></td>
			</tr>
			<tr>
				<td><?php echo JText::_('Played');?></td>
				<td align="right"><input type="checkbox" name="played_chk" value="1" <?php echo $lists['played_chk']?'checked':'';?> /></td>
			</tr>
			<tr>
				<td><?php echo JText::_('Team Emblem');?></td>
				<td align="right"><input type="checkbox" name="emblem_chk" value="1" <?php echo $lists['emblem_chk']?'checked':'';?> /></td>
			</tr>
			<tr>
				<td><?php echo JText::_('BLBE_TTWC');?></td>
				<td align="right"><input type="checkbox" name="win_chk" value="1" <?php echo $lists['win_chk']?'checked':'';?> /></td>
			</tr>
			<tr>
				<td><?php echo JText::_('BLBE_TTLC');?></td>
				<td align="right"><input type="checkbox" name="lost_chk" value="1" <?php echo $lists['lost_chk']?'checked':'';?> /></td>
			</tr>
			<tr>
				<td><?php echo JText::_('BLBE_TTDC');?></td>
				<td align="right"><input type="checkbox" name="draw_chk" value="1" <?php echo $lists['draw_chk']?'checked':'';?> /></td>
			</tr>
			<tr>
				<td><?php echo JText::_('BLBE_TTEWC');?></td>
				<td align="right"><input type="checkbox" name="otwin_chk" value="1" <?php echo $lists['otwin_chk']?'checked':'';?> /></td>
			</tr>
			<tr>
				<td><?php echo JText::_('BLBE_TTELC');?></td>
				<td align="right"><input type="checkbox" name="otlost_chk" value="1" <?php echo $lists['otlost_chk']?'checked':'';?> /></td>
			</tr>
			<tr>
				<td><?php echo JText::_('BLBE_TTDIFC');?></td>
				<td align="right"><input type="checkbox" name="diff_chk" value="1" <?php echo $lists['diff_chk']?'checked':'';?> /></td>
			</tr>
			<tr>
				<td><?php echo JText::_('BLBE_TTGDC');?></td>
				<td align="right"><input type="checkbox" name="gd_chk" value="1" <?php echo $lists['gd_chk']?'checked':'';?> /></td>
			</tr>
			<tr>
				<td><?php echo JText::_('BLBE_TTPC');?></td>
				<td align="right"><input type="checkbox" name="point_chk" value="1" <?php echo $lists['point_chk']?'checked':'';?> /></td>
			</tr>
			<tr>
				<td><?php echo JText::_('BLBE_TTWPC');?></td>
				<td align="right"><input type="checkbox" name="percent_chk" value="1" <?php echo $lists['percent_chk']?'checked':'';?> /></td>
			</tr>
			
			<tr>
				<td><?php echo JText::_('BLBE_TTGSC');?></td>
				<td align="right"><input type="checkbox" name="goalscore_chk" value="1" <?php echo $lists['goalscore_chk']?'checked':'';?> /></td>
			</tr>
			<tr>
				<td><?php echo JText::_('BLBE_TTGCC');?></td>
				<td align="right"><input type="checkbox" name="goalconc_chk" value="1" <?php echo $lists['goalconc_chk']?'checked':'';?> /></td>
			</tr>
			<tr>
				<td><?php echo JText::_('BLBE_TTWHC');?></td>
				<td align="right"><input type="checkbox" name="winhome_chk" value="1" <?php echo $lists['winhome_chk']?'checked':'';?> /></td>
			</tr>
			<tr>
				<td><?php echo JText::_('BLBE_TTWAC');?></td>
				<td align="right"><input type="checkbox" name="winaway_chk" value="1" <?php echo $lists['winaway_chk']?'checked':'';?> /></td>
			</tr>
			<tr>
				<td><?php echo JText::_('BLBE_TTDHC');?></td>
				<td align="right"><input type="checkbox" name="drawhome_chk" value="1" <?php echo $lists['drawhome_chk']?'checked':'';?> /></td>
			</tr>
			<tr>
				<td><?php echo JText::_('BLBE_TTDAC');?></td>
				<td align="right"><input type="checkbox" name="drawaway_chk" value="1" <?php echo $lists['drawaway_chk']?'checked':'';?> /></td>
			</tr>
			<tr>
				<td><?php echo JText::_('BLBE_TTLHC');?></td>
				<td align="right"><input type="checkbox" name="losthome_chk" value="1" <?php echo $lists['losthome_chk']?'checked':'';?> /></td>
			</tr>
			<tr>
				<td><?php echo JText::_('BLBE_TTLAC');?></td>
				<td align="right"><input type="checkbox" name="lostaway_chk" value="1" <?php echo $lists['lostaway_chk']?'checked':'';?> /></td>
			</tr>
			<tr>
				<td><?php echo JText::_('BLBE_TTPHC');?></td>
				<td align="right"><input type="checkbox" name="pointshome_chk" value="1" <?php echo $lists['pointshome_chk']?'checked':'';?> /></td>
			</tr>
			<tr>
				<td><?php echo JText::_('BLBE_TTPAC');?></td>
				<td align="right"><input type="checkbox" name="pointsaway_chk" value="1" <?php echo $lists['pointsaway_chk']?'checked':'';?> /></td>
			</tr>
		</table>
		<br />
		<table class="admin">
			<tr>
				<th colspan="2"><?php echo JText::_('BLBE_RANK_CRIT');?></th>
			</tr>
			<tr>
				<td><?php echo JText::_('BLBE_RANK_EQUAL');?></td>
				<td><input type="checkbox" name="equalpts_chk" value="1" <?php echo $lists['equalpts_chk']?'checked':'';?> /></td>
			</tr>
			<?php
			for($i=0;$i<4;$i++){
				echo '<tr>';
				echo '<td>'.JHTML::_('select.genericlist',   $lists['sortfield'], 'sortfield[]', 'class="inputbox"', 'id', 'name', ((isset($lists['savedsort'][$i]->sort_field))?$lists['savedsort'][$i]->sort_field:0) ).'</td>';
				echo '<td>'.JHTML::_('select.genericlist',   $lists['sortway'], 'sortway[]', 'class="inputbox"', 'id', 'name', ((isset($lists['savedsort'][$i]->sort_way))?$lists['savedsort'][$i]->sort_way:0) ).'</td>';
				echo '</tr>';
			}
			?>
		</table>
		</div>
		<div id="col_conf_div" class="tabdiv" style="display:none;">
		<br />
		<div style="background-color:#eee;"><?php echo JText::_( 'BLBE_HIGHLIGHT' ); ?></div>
		<br />
		<table>
			<tr>
				<td>
					<div id="colorpicker201" class="colorpicker201"></div>
				</td>
			</tr>
			<tr>
				<td id="app_newcol">
					<?php if(!count($lists['colors'])){?>
					<div>
						<?php echo JText::_( 'BLBE_COLORS' ); ?><span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_COLORS' ); ?>::<?php echo JText::_( 'BLBE_TT_COLORS' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span> 
						<input type="button" onclick="showColorGrid2('input_field_1','sample_1');" value="...">&nbsp;<input type="text" ID="input_field_1" name="input_field_1" size="9" value=""><input type="text" ID="sample_1" size="1" value="" />
						<?php echo JText::_( 'BLBE_PLACE' ); ?> <span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_PLACE' ); ?>::<?php echo JText::_( "BLBE_TT_PLACE" );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
						<input type="text" ID="place_1" name="place_1" size="5" value="" />
					</div>
					<?php
					}else{
						$m = 0;
						foreach ($lists['colors'] as $colores){
							$m++;
					?>
						<div>
							<?php echo JText::_( 'BLBE_COLORS' ); ?>

							<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_COLORS' ); ?>::<?php echo JText::_( 'BLBE_TT_COLORS' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span> 
							<input type="button" onclick="showColorGrid2('input_field_<?php echo $m?>','sample_<?php echo $m?>');" value="...">&nbsp;<input type="text" ID="input_field_<?php echo $m?>" name="input_field_<?php echo $m?>" size="9" value="<?php echo $colores->color?>"><input type="text" ID="sample_<?php echo $m?>" size="1" value="" style="background-color:<?php echo $colores->color?>" />
							<?php echo JText::_( 'BLBE_PLACE' ); ?> 


							<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_PLACE' ); ?>::<?php echo JText::_( 'BLBE_TT_PLACES' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
							<input type="text" ID="place_<?php echo $m?>" name="place_<?php echo $m?>" size="5" value="<?php echo $colores->place?>" />
						</div>
					<?php	
						}
					}
					?>
				</td>
			</tr>
			<tr>
				<td>
				<input type="hidden" name="col_count" value="<?php echo count($lists['colors'])?count($lists['colors']):1?>" />
				<input type="button" value="<?php echo JText::_( 'BLBE_NEWCOLOR' ); ?>" onclick="javascript:add_colors();" />
				</td>
			</tr>
		</table>
		
		</div>
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="s_id" value="<?php echo $row->s_id?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php
	}
	
	///////----------Teams---------
	function bl_TeamList( $rows, $page, $option )
	{
		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');
		JHTML::_('behavior.tooltip');
		?>
		<?php
		if(!count($rows)){
			echo "<div id='system-message'><dd class='notice'><ul>".JText::_('BLBE_NOITEMS')."</ul></dd></div>";
		}
		?>
		<form action="index.php?option=<?php echo $option;?>" method="post" name="adminForm">
		<table class="adminlist">
		<thead>
			<tr>
				<th width="2%" align="left">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				<th width="2%" align="left">
					<?php echo JText::_( 'ID' ); ?>
				</th>
				<th width="2%">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" />
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_TEAM' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_CITY' ); ?>
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
			$link = JRoute::_( 'index.php?option=com_joomsport&task=team_edit&cid[]='. $row->id );
			$checked 	= @JHTML::_('grid.checkedout',   $row, $i );
			//$published 	= JHTML::_('grid.published', $row, $i);
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $page->getRowOffset( $i ); ?>
				</td>
				<td>
					<?php echo $row->id;?>
				</td>
				<td>
					<?php echo $checked; ?>
				</td>
				<td>
					<?php
						echo '<a href="'.$link.'">'.$row->t_name.'</a>';
					?>
				</td>
				<td>
					<?php echo $row->t_city;?>
				</td>
				
				
			</tr>
			<?php
		}
		} 
		?>
		</tbody>
		</table>
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="team_list" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
	<?php
	}
	
	function bl_editTeam($row, $lists, $option){
		$editor =& JFactory::getEditor();
		JHTML::_('behavior.tooltip');
		jimport('joomla.html.pane');
		require_once(JPATH_ROOT.DS.'components'.DS.'com_joomsport'.DS.'includes'.DS.'tabs.php');
		$etabs = new esTabs();
		joomsport_html::JS_getObj();
		?>
		<script type="text/javascript">
		Joomla.submitbutton = function(task) {
			submitbutton(task);
		}
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			 if(pressbutton == 'team_apply' || pressbutton == 'team_save'){
			 	if(form.t_name.value != ''){
					submitform( pressbutton );
					return;
				}else{
					getObj('tmname').style.border = "1px solid red";
					alert("<?php echo JText::_('BLBE_JSMDNOT1');?>");
					
					
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
		function delete_logo(){
			getObj("logoiddiv").innerHTML = '';
		}		
		</script>
		<form action="index.php?option=<?php echo $option?>" method="post" name="adminForm" enctype="multipart/form-data">
		<?php
		//echo $tabs->startPane('teamop');
		//echo $tabs->startPanel(JText::_( 'BLBE_MAIN' ),'main_conf');
		$etabs->newTab(JText::_( 'BLBE_MAIN' ),'main_conf','','vis');
		$etabs->newTab(JText::_( 'BLBE_BONUSES' ),'bonuses_conf','');
		
		?>
		<div style="clear:both"></div>
		<div id="main_conf_div" class="tabdiv">
		
		<table>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLBE_TEAMNAME' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_TEAMNAME' ); ?>::<?php echo JText::_( 'BLBE_TT_TEAMNAME' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span> 
				</td>
				<td>
					<input type="text" maxlength="255" size="60" name="t_name" id="tmname" value="<?php echo htmlspecialchars($row->t_name)?>" />
				</td>
			</tr>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLBE_CITY' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_CITY' ); ?>::<?php echo JText::_( 'BLBE_TT_CITY' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span> 
				</td>
				<td>
					<input type="text" maxlength="255" size="60" name="t_city" value="<?php echo htmlspecialchars($row->t_city)?>" />
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JText::_( 'BLBE_YTEAM' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_YTEAM' ); ?>::<?php echo JText::_( 'BLBE_TT_YTEAM' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span> 
				</td>
				<td>
					<input type="checkbox"  name="t_yteam" value="1" <?php if($row->t_yteam) echo "checked"?> />
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
				<td colspan="2">
				<em><?php echo JText::_( 'BLBE_EMPTYFIELD' ); ?>

				</td>
			</tr>
			<tr>
				<td valign="top">
					<?php echo JText::_( 'BLBE_TEAM_LOGO' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_TEAM_LOGO' ); ?>::<?php echo JText::_( 'BLBE_TT_TEAM_LOGO' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span> 
				</td>
				<td>
					<input type="file" name="t_logo" /><input type="button" value="<?php echo JText::_( 'BLFA_UPLOAD' ); ?>" style="cursor:pointer;" onclick="submitbutton('team_apply');" />
					<br /><br />
					<div id="logoiddiv">
					<?php
					
					if($row->t_emblem && is_file('../media/bearleague/'.$row->t_emblem)){
						echo '<img src="'.JURI::base().'../media/bearleague/'.$row->t_emblem.'" width="200" />';
						echo '<input type="hidden" name="istlogo" value="1" />';
						?>
						<a href="javascript:void(0);" title="<?php echo JText::_( 'BLBE_REMOVE' ); ?>" onClick="javascript:delete_logo();"><img src="<?php echo JURI::base();?>components/com_joomsport/img/publish_x.png" title="Remove" /></a>
						</div>
					<?php	
					}
					?>
					</div>
				</td>
			</tr>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLBE_ABOUT_TEAM' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_ABOUT_TEAM' ); ?>::<?php echo JText::_( 'BLBE_TT_ABOUT_TEAM' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span> 
				</td>
				<td>
					<?php echo $editor->display( 't_descr',  htmlspecialchars($row->t_descr, ENT_QUOTES), '550', '300', '60', '20', array('pagebreak', 'readmore') ) ;  ?>
				</td>
			</tr>
		</table>
		
		<table style="padding:10px;">
			<tr>
				<td>
					<?php echo JText::_( 'BLBE_UPLFOTO' ); ?>

				</td>
			</tr>
			<tr>
				<td>
				<input type="file" name="player_photo_1" value="" />
				</td>
			</tr>
			<tr>
				<td>
				<input type="file" name="player_photo_2" value="" /><input type="button" value="<?php echo JText::_( 'BLFA_UPLOAD' ); ?>" style="cursor:pointer;" onclick="submitbutton('team_apply');" />
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JText::_( 'BLBE_ONEPHSEL' ); ?>

				</td>
			</tr>
		</table>
		<?php
		if(count($lists['photos'])){
		?>
		<table class="adminlist">
			<tr>
				<th class="title" width="30"><?php echo JText::_( 'BLBE_DELETE' ); ?></th>
				<th class="title" width="30"><?php echo JText::_( 'BLBE_DEFAULT' ); ?></th>
				<th class="title" ><?php echo JText::_( 'BLBE_TITLE' ); ?></th>

				<th class="title" width="250"><?php echo JText::_( 'BLBE_IMAGE' ); ?></th>
			</tr>
			<?php
			foreach($lists['photos'] as $photos){
			?>
			<td align="center">
				<a href="javascript:void(0);" title="<?php echo JText::_( 'BLBE_REMOVE' ); ?>" onClick="javascript:Delete_tbl_row(this);"><img src="<?php echo JURI::base();?>components/com_joomsport/img/publish_x.png" title="Remove" /></a>
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
				$imgsize = getimagesize('../media/bearleague/'.$photos->filename);
				if($imgsize[0] > 200){
					$width = 200;
				}else{
					$width  = $imgsize[0];
				}
				?>
				<a rel="{handler: 'image'}" href="<?php echo JURI::base();?>../media/bearleague/<?php echo $photos->filename?>" title="<?php echo JText::_( 'BLBE_IMAGE' ); ?>" class="modal-button"><img src="<?php echo JURI::base();?>../media/bearleague/<?php echo $photos->filename?>" width="<?php echo $width;?>" /></a>
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
		<div id="bonuses_conf_div" class="tabdiv" style="display:none;">
		<?php
		
		//echo $tabs->endPanel();
		//echo $tabs->startPanel(JText::_( 'BLBE_BONUSES' ),'bonuses_conf');
		echo '<table class="adminlist">';
		echo '<tr>';?>
		<th class="title"><?php echo JText::_( 'BLBE_SEASON' ); ?></th>
		<th class="title"><?php echo JText::_( 'BLBE_BONUSES' ); ?></th>
		<?php echo '</tr>';
		for($i=0;$i<count($lists['bonuses']);$i++){
			$bonuses = $lists['bonuses'][$i];
			echo '<tr><td><input type="hidden" name="sids[]" value="'.$bonuses->season_id.'" />'.$bonuses->name.'</td>';
			echo '<td><input type="text" name="bonuses[]" value="'.floatval($bonuses->bonus_point).'" />'.'</td></tr>';
		}
		?>
		</table>
		<?php
		//echo $tabs->endPanel();
		//echo $tabs->endPane();
		
		?>
		</div>
		
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="id" value="<?php echo $row->id?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php
	}
	
	///////----------Position---------
	function bl_PosList( $rows, $page, $option )
	{
		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');
		JHTML::_('behavior.tooltip');
		?>
		<?php
		if(!count($rows)){
			echo "<div id='system-message'><dd class='notice'><ul>".JText::_('BLBE_NOITEMS')."</ul></dd></div>";
		}
		?>
		<form action="index.php?option=<?php echo $option;?>" method="post" name="adminForm">
		<table class="adminlist">
		<thead>
			<tr>
				<th width="2%" align="left">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				<th width="2%">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" />
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_POSITION' ); ?>
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
			$link = JRoute::_( 'index.php?option=com_joomsport&task=pos_edit&cid[]='. $row->id );
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
						echo '<a href="'.$link.'">'.$row->p_name.'</a>';
					?>
				</td>
				
				
			</tr>
			<?php
		}
		} 
		?>
		</tbody>
		</table>
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="pos_list" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
	<?php
	}
	
	function bl_editPos($row, $lists, $option){
		$editor =& JFactory::getEditor();
		JHTML::_('behavior.tooltip');
		joomsport_html::JS_getObj();
		?>
		<script type="text/javascript">
		Joomla.submitbutton = function(task) {
			submitbutton(task);
		}
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			 if(pressbutton == 'pos_apply' || pressbutton == 'pos_save'){
			 	if(form.p_name.value != ''){
					submitform( pressbutton );
					return;
				}else{
					getObj('posname').style.border = "1px solid red";
					alert("<?php echo JText::_('BLBE_JSMDNOT1');?>");
					
					
				}
			}else{
				submitform( pressbutton );
					return;
			}
		}	
		</script>
		<form action="index.php?option=<?php echo $option?>" method="post" name="adminForm">
		
		<table>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLBE_POSITIONNAME' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_POSITIONNAME' ); ?>::<?php echo JText::_( 'BLBE_TT_POSITIONNAME' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<input type="text" maxlength="255" size="60" name="p_name" id="posname" value="<?php echo $row->p_name?>" />
				</td>
			</tr>
			
		</table>
		
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="p_id" value="<?php echo $row->p_id?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php
	}
	
	///////----------Players---------
	function bl_PlayerList( $rows, $page, $lists, $option )
	{
		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');
		JHTML::_('behavior.tooltip');
		?>
		<?php
		if(!count($rows)){
			echo "<div id='system-message'><dd class='notice'><ul>".JText::_('BLBE_NOITEMS')."</ul></dd></div>";
		}
		?>
		<form action="index.php?option=<?php echo $option;?>" method="post" name="adminForm">
		<div align="right"><?php echo JText::_( 'BLBE_FILTERS' ); ?>: <?php echo $lists['pos']."".$lists['teams1'];?></div>	
		<table class="adminlist">
		<thead>
			<tr>
				<th width="2%" align="left">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				<th width="2%" align="left">
					<?php echo JText::_( 'ID' ); ?>
				</th>
				<th width="2%">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" />
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_PLAYER' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_POSITION' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_TEAM' ); ?>
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
			$link = JRoute::_( 'index.php?option=com_joomsport&task=player_edit&cid[]='. $row->id );
			$checked 	= @JHTML::_('grid.checkedout',   $row, $i );
			//$published 	= JHTML::_('grid.published', $row, $i);
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $page->getRowOffset( $i ); ?>
				</td>
				<td>
					<?php echo $row->id; ?>
				</td>
				<td>
					<?php echo $checked; ?>
				</td>
				<td>
					<?php
						echo '<a href="'.$link.'">'.$row->first_name.' '.$row->last_name.'</a>';
					?>
				</td>
				<td>
					<?php echo $row->p_name; ?>
				</td>
				<td>
					<?php echo $row->t_name; ?>
				</td>
				
				
			</tr>
			<?php
		}
		} 
		?>
		</tbody>
		</table>
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="player_list" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
	<?php
	}
	
	function bl_editPlayer($row, $lists, $option){
		$editor =& JFactory::getEditor();
		JHTML::_('behavior.tooltip');
		?>
		<script type="text/javascript">
		<!--
		Joomla.submitbutton = function(task) {
			submitbutton(task);
		}
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			 if(pressbutton == 'player_apply' || pressbutton == 'player_save'){
			 	if(form.first_name.value == '' || form.last_name.value == ''){
			 		alert('<?php echo JText::_( 'BLBE_JSNOTICEPL' ); ?>');
			 	}else if(form.team_id.value == 0){
			 		alert('<?php echo JText::_( 'BLBE_SELTEAM' ); ?>');
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
			echo "<div id='system-message'>".JText::_('BLBE_NOITEMS')."</div>";
		}
		?>
		<form action="index.php?option=<?php echo $option?>" method="post" name="adminForm" enctype="multipart/form-data">
		
		<table>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLBE_FIRSTNAME' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_FIRSTNAME' ); ?>::<?php echo JText::_( 'BLBE_TT_FIRSTNAME' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span> 
				</td>
				<td>
					<input type="text" maxlength="255" size="60" name="first_name" value="<?php echo $row->first_name?>" />
				</td>
			</tr>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLBE_LASTNAME' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_LASTNAME' ); ?>::<?php echo JText::_( 'BLBE_TT_LASTNAME' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<input type="text" maxlength="255" size="60" name="last_name" value="<?php echo $row->last_name?>" />
				</td>
			</tr>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLBE_NICKNAME' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_NICKNAME' ); ?>::<?php echo JText::_( 'BLBE_TT_NICKNAME' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<input type="text" maxlength="255" size="60" name="nick" value="<?php echo $row->nick?>" />
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
				<td colspan="2">
				<em><?php echo JText::_( 'BLBE_EMPTYFIELD' ); ?>


				</td>
			</tr>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLBE_POSITION' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_POSITION' ); ?>::<?php echo JText::_( 'BLBE_TT_POSITION' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $lists['pos'];?>
				</td>
			</tr>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLBE_TEAM' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_TEAM' ); ?>::<?php echo JText::_( 'BLBE_TT_TEAM' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $lists['teams'];?>
				</td>
			</tr>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLBE_ABPLAYER' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_ABPLAYER' ); ?>::<?php echo JText::_( 'BLBE_TT_ABPLAYER' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $editor->display( 'about',  htmlspecialchars($row->about, ENT_QUOTES), '550', '300', '60', '20', array('pagebreak', 'readmore') ) ;  ?>
				</td>
			</tr>
			
		</table>
		<table style="padding:10px;">
			<tr>
				<td>
					<?php echo JText::_( 'BLBE_UPLPHTOPLYR' ); ?>


				</td>
			</tr>
			<tr>
				<td>
				<input type="file" name="player_photo_1" value="" />
				</td>
			</tr>
			<tr>
				<td>
				<input type="file" name="player_photo_2" value="" /><input type="button" value="<?php echo JText::_( 'BLFA_UPLOAD' ); ?>" style="cursor:pointer;" onclick="submitbutton('player_apply');" />
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JText::_( 'BLBE_ONEPHSEL' ); ?>


				</td>
			</tr>
		</table>
		<?php
		if(count($lists['photos'])){
		?>
		<table class="adminlist">
			<tr>
				<th class="title" width="30"><?php echo JText::_( 'BLBE_DELETE' ); ?></th>
				<th class="title" width="30"><?php echo JText::_( 'BLBE_DEFAULT' ); ?></th>
				<th class="title" ><?php echo JText::_( 'BLBE_TITLE' ); ?></th>

				<th class="title" width="250"><?php echo JText::_( 'BLBE_IMAGE' ); ?></th>
			</tr>
			<?php
			foreach($lists['photos'] as $photos){
			?>
			<td align="center">
				<a href="javascript:void(0);" title="<?php echo JText::_( 'BLBE_REMOVE' ); ?>" onClick="javascript:Delete_tbl_row(this);"><img src="<?php echo JURI::base();?>components/com_joomsport/img/publish_x.png" title="<?php echo JText::_( 'BLBE_REMOVE' ); ?>" /></a>
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
				$imgsize = getimagesize('../media/bearleague/'.$photos->filename);
				if($imgsize[0] > 200){
					$width = 200;
				}else{
					$width  = $imgsize[0];
				}
				?>
				<a rel="{handler: 'image'}" href="<?php echo JURI::base();?>../media/bearleague/<?php echo $photos->filename?>" title="<?php echo JText::_( 'BLBE_IMAGE' ); ?>" class="modal-button"><img src="<?php echo JURI::base();?>../media/bearleague/<?php echo $photos->filename?>" width="<?php echo $width;?>" /></a>
			</td>
			</tr>
			<?php
			}
			?>
		</table>
		<?php
		}
		?>
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="id" value="<?php echo $row->id?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		
		<?php
		
	}
	
	////////-------------match day
	function bl_MdayList( $rows, $page, $lists, $option )
	{
		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');
		JHTML::_('behavior.tooltip');
		?>
		
		<script type="text/javascript">
		<!--
		Joomla.submitbutton = function(task) {
			submitbutton(task);
		}
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'matchday_add') {
				if(form.s_id.value != 0){
					submitform( pressbutton );
					return;
				}else{	
					alert("<?php echo JText::_( 'BLBE_JSMDNOT9' ); ?>");	

				}
			}else{
				submitform( pressbutton );
					return;
			}
		}	
		//-->
		</script>
		<?php
		if(!count($rows)){
			echo "<div id='system-message'><dd class='notice'><ul>".JText::_('BLBE_NOITEMS')."</ul></dd></div>";
		}
		?>
		<form action="index.php?option=<?php echo $option;?>" method="post" name="adminForm">
		<div align="right"><?php echo $lists['tourn'];?></div>	
		<table class="adminlist">
		<thead>
			<tr>
				<th width="2%" align="left">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				<th width="2%">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" />
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_MATCHDAY' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_TOURNAMENT' ); ?>
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
			$link = JRoute::_( 'index.php?option=com_joomsport&task=matchday_edit&cid[]='. $row->id );
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
				
			</tr>
			<?php
		}
		} 
		?>
		</tbody>
		</table>
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="matchday_list" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
	<?php
	}
	
	function bl_editMday($row, $lists, $match, $s_id, $option){
		$editor =& JFactory::getEditor();
		JHTML::_('behavior.tooltip');
		joomsport_html::JS_getObj();
		?>
		<script type="text/javascript">
		<!--
		Joomla.submitbutton = function(task) {
			submitbutton(task);
		}
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'matchday_save' || pressbutton == 'matchday_apply') {
				if(form.m_name.value != "" && form.s_id.value != 0){
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
							alert("<?php echo JText::_( 'BLBE_JSMDNOT77' ); ?>");return;
						}else{	
							submitform( pressbutton );
							return;
						}
					}
					
					
				}else{	
					alert("<?php echo JText::_( 'BLBE_JSMDNOT3' ); ?>");	

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
				alert("<?php echo JText::_( 'BLBE_JSMDNOT1' ); ?>");return;

			}
			if (((score1) == '' || (score2) == '') && tm_played){
				alert("<?php echo JText::_( 'BLBE_JSMDNOT1' ); ?>");return;

			}
			if ( team1.value == team2.value ){
				alert("<?php echo JText::_( 'BLBE_JSMDNOT2' ); ?>");return;

			}
			
			var regE = /[0-2][0-9]:[0-5][0-9]/;
			if(!getObj('match_time_new').value.test(regE)){
				alert("<?php echo JText::_( 'BLBE_JSMDNOT7' ); ?>");return;

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
			cell1.innerHTML = '<a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/img/publish_x.png"  border="0" alt="Delete"></a>';
			
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
			
			////-------------new---------------////
			
			var cell7 = document.createElement("td");
			var cell8 = document.createElement("td");
			var cell9 = document.createElement("td");
			
			var input_hidden = document.createElement("input");
			input_hidden.type = "text";
			input_hidden.name = "match_data[]";
			input_hidden.value = getObj('tm_date').value;
			input_hidden.size = 12;
			input_hidden.setAttribute("maxlength",10);
			
			cell6.appendChild(input_hidden);
			cell6.align = "left";
			
			
			var input_hidden = document.createElement("input");
			input_hidden.type = "text";
			input_hidden.name = "match_time[]";
			input_hidden.value = getObj('match_time_new').value;
			input_hidden.size = 12;
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
			row.appendChild(cell8);
			
			row.appendChild(cell6);
			
			row.appendChild(cell7);
			row.appendChild(cell5);
			getObj('teams1').value =  0;
			getObj('teams2').value = 0;
			getObj('add_score1').value = '';
			getObj('add_score2').value = '';
			getObj('extra_timez').checked = false;
		}
		
		function Delete_tbl_row(element) {
			var del_index = element.parentNode.parentNode.sectionRowIndex;
			var tbl_id = element.parentNode.parentNode.parentNode.parentNode.id;
			element.parentNode.parentNode.parentNode.deleteRow(del_index);
		}
		//-->
		</script>
		<form action="index.php?option=<?php echo $option?>" method="post" name="adminForm">
		<table>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLBE_MATCHDAYNAME' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_MATCHDAYNAME' ); ?>::<?php echo JText::_( 'BLBE_TT_MATCHDAYNAME' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span> 
				</td>
				<td>
					<input type="text" maxlength="255" size="60" name="m_name" value="<?php echo htmlspecialchars($row->m_name)?>" />
				</td>
			</tr>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLBE_TOURNAMENT' ); ?>					
				</td>
				<td>
					<?php echo $lists['tourn'];?>
				</td>
			</tr>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLBE_ISPLAYOFF' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_ISPLAYOFF' ); ?>::<?php echo JText::_( 'BLBE_TT_ISPLAYOFF' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span> 
				</td>
				<td>
					<?php echo $lists['is_playoff'];?>
				</td>
			</tr>
			
		</table>
		<br />
		<table class="adminlist" id="new_matches">
			<tr>
				<th class="title" style="padding-left:250px;" colspan="9">
					<?php echo JText::_( 'BLBE_MATCHRESULTS' ); ?>

				</th>
			</tr>
			<tr>
				<th class="title" width="20">


					<?php echo JText::_( 'Num' ); ?>


				</th>

				<th class="title" width="170">
					<?php echo JText::_( 'BLBE_HOMETEAM' ); ?>
				</th>
				<th width="110">
					<?php echo JText::_( 'BLBE_SCORE' ); ?>
				</th>
				
				<th class="title" width="170">
					<?php echo JText::_( 'BLBE_AWAYTEAM' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_PLAYED' ); ?>
				</th>
				
				<th class="title">
					<?php echo JText::_( 'BLBE_DATE' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_TIME' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_MATCHDETAILS' ); ?>
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_MATCHDETAILS' ); ?>::<?php echo JText::_( 'BLBE_TT_MATCHDETAILS' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span> 
				</th>
			</tr>
			<?php
			if(count($match)){
				foreach($match as $curmatch){
					$match_link = 'index.php?option='.$option.'&amp;task=match_edit&amp;cid='.$curmatch->id;
					echo "<tr>";
					echo '<td><input type="hidden" name="match_id[]" value="'.$curmatch->id.'" /><a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/img/publish_x.png"  border="0" alt="Delete"></a></td>';
					echo '<td><input type="hidden" name="home_team[]" value="'.$curmatch->team1_id.'" />'.$curmatch->home_team.'</td>';
					echo '<td align="center"><input type="text" name="home_score[]" value="'.$curmatch->score1.'" size="3" maxlength="5" /> : <input type="text" name="away_score[]" value="'.$curmatch->score2.'" size="3" maxlength="5" /><input type="checkbox" name="extra_time[]" value="'.(($curmatch->is_extra)?1:0).'" '.(($curmatch->is_extra)?"checked":"").' /></td>';
					echo '<td><input type="hidden" name="away_team[]" value="'.$curmatch->team2_id.'" />'.$curmatch->away_team.'</td>';
					echo '<td><input type="checkbox" name="match_played[]" value="'.($curmatch->m_played?1:0).'" '.($curmatch->m_played?"checked":"").' /></td>';					
					echo '<td>';
						echo JHTML::_('calendar', $curmatch->m_date, 'match_data[]', 'match_data_'.$curmatch->id, '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'12',  'maxlength'=>'10')); 
					
					echo '</td>';		
					echo '<td><input type="text" name="match_time[]" maxlength="5" size="12" value="'.substr($curmatch->m_time,0,5).'" />';
					echo '<td><a href="'.$match_link.'">'.JText::_( 'BLBE_MATCHDETAILS' ).'</a></td>';
					echo "</tr>";
				}
			}
			?>
		</table>
		<table class="adminlist">
			<tr >
				<th  class="title" colspan="8" style=" padding-left:200px;">

					<?php echo JText::_( 'BLBE_ADDMATCHRESULTS' ); ?>


				</th>
			</tr>
			
			<tr>
				<th width="220">
					<?php echo $lists['teams1']?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_HOMETEAM' ); ?>::<?php echo JText::_( '' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span> 
				</th>
				<th width="160">
					<input name="add_score1" id="add_score1" type="text" maxlength="5" size="5" />&nbsp;:
                    <input name="add_score2" id="add_score2" type="text" maxlength="5" size="5" />
					<input type="checkbox" name="extra_timez" id="extra_timez" />&nbsp;ET
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_ET' ); ?>::<?php echo JText::_( '' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span> 
				</th>
				<th width="200">
                <?php echo $lists['teams2']?>
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_AWAYTEAM' ); ?>::<?php echo JText::_( '' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span> 
				</th>
				<th width="50">
					<input type="checkbox" name="tm_played" id="tm_played" />
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_PLAYED' ); ?>::<?php echo JText::_( '' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span> 
				</th>
				
				<th width="110">
					<?php
						echo JHTML::_('calendar', date("Y-m-d"), 'tm_date', 'tm_date', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'12',  'maxlength'=>'10')); 
					?>
				</th>
				<th width="120">
					<input type="text" name="match_time_new" id="match_time_new" maxlength="5" size="12" value="00:00" />
				</th>
				<th>
					<input type="button" value="<?php echo JText::_( 'BLBE_ADD' ); ?>" onClick="bl_add_match();" />
				</th>
			</tr>
		</table>
		
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="id" value="<?php echo $row->id?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="s_id" value="<?php echo $s_id?>" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		
		<?php
		
	}
	
	////////-------------match --------------///
	function bl_MatchList( $rows, $page, $option )
	{
		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');
		JHTML::_('behavior.tooltip');
		?>
		<form action="index.php?option=<?php echo $option;?>" method="post" name="adminForm">
		<table class="adminlist">
		<thead>
			<tr>
				<th width="2%" align="left">
					<?php echo JText::_( 'Num' ); ?>				</th>
				<th width="2%">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" />				</th>
				<th class="title"><?php echo JText::_( 'Name' ); ?></th>
				<th class="title">
					<?php echo JText::_( 'BLBE_TOURNAMENT' ); ?>				</th>
			</tr>
		</thead>
		<tfoot>
		<tr>
			<td colspan="13">
				<?php echo $page->getListFooter(); ?>			</td>
		</tr>
		</tfoot>
		<tbody>
		<?php
		$k = 0;
		if( count( $rows ) ) {
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row 	= $rows[$i];
			JFilterOutput::objectHtmlSafe($row);
			$link = JRoute::_( 'index.php?option=com_joomsport&task=matchday_edit&cid[]='. $row->id );
			$checked 	= @JHTML::_('grid.checkedout',   $row, $i );
			//$published 	= JHTML::_('grid.published', $row, $i);
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $page->getRowOffset( $i ); ?>				</td>
				<td>
					<?php echo $checked; ?>				</td>
				<td>
					<?php
						echo '<a href="'.$link.'">'.$row->m_name.'</a>';
					?>				</td>
				<td>
					<?php echo $row->tourn;?>				</td>
			</tr>
			<?php
		}
		} 
		?>
		</tbody>
		</table>
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
	<?php
	}
	
	function bl_editMatch($row, $lists, $option){
		$editor =& JFactory::getEditor();
		JHTML::_('behavior.tooltip');
		joomsport_html::JS_getObj();
		require_once(JPATH_ROOT.DS.'components'.DS.'com_joomsport'.DS.'includes'.DS.'tabs.php');
		$etabs = new esTabs();
		?>
		<script type="text/javascript">
		<!--
		Joomla.submitbutton = function(task) {
			submitbutton(task);
		}
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if(pressbutton == 'matchday_cancel'){
				window.history.back(-1);
			}
			else{
					
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
			var re_count = getObj('re_count').value;
			var e_player = getObj('playerz_id');
			
			if (cur_event.value == 0) {

				alert("<?php echo JText::_( 'BLBE_JSMDNOT4' ); ?>");return;


			}
			if (e_player.value == 0) {
				alert("<?php echo JText::_( 'BLBE_JSMDNOT5' ); ?>");return;


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
			cell1.innerHTML = '<a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/img/publish_x.png"  border="0" alt="Delete"></a>';
			
			var input_hidden = document.createElement("input");
			input_hidden.type = "hidden";
			input_hidden.name = "new_eventid[]";
			input_hidden.value = cur_event.value;
			cell2.innerHTML = cur_event.options[cur_event.selectedIndex].text;
			cell2.appendChild(input_hidden);
			
			
			var input_hidden = document.createElement("input");
			input_hidden.type = "text";
			input_hidden.name = "e_minuteval[]";
			input_hidden.value = e_minutes;
			//cell4.innerHTML = e_minutes;
			input_hidden.setAttribute("maxlength",5);
			input_hidden.setAttribute("size",5);
			cell4.appendChild(input_hidden);
			
			var input_hidden = document.createElement("input");
			input_hidden.type = "text";
			input_hidden.name = "e_countval[]";
			input_hidden.value = re_count;
			//cell4.innerHTML = e_minutes;
			input_hidden.setAttribute("maxlength",5);
			input_hidden.setAttribute("size",5);
			cell6.appendChild(input_hidden);
			
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
				alert("<?php echo JText::_( 'BLBE_JSMDNOT4' ); ?>");return;


			}
			if (e_player.value == 0) {
				alert("<?php echo JText::_( 'BLBE_JSMDNOT6' ); ?>");return;


			}
			
			var tbl_elem = getObj('new_tevents');
			var row = tbl_elem.insertRow(tbl_elem.rows.length);
			var cell1 = document.createElement("td");
			var cell2 = document.createElement("td");
			var cell3 = document.createElement("td");
			var cell4 = document.createElement("td");
			var cell5 = document.createElement("td");
			
			
			cell1.innerHTML = '<a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/img/publish_x.png"  border="0" alt="Delete"></a>';
			
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
				alert("<?php echo JText::_( 'BLBE_JSMDNOT5' ); ?>");return;
				}
			
			
			var tbl_elem = getObj(tblid);
			var row = tbl_elem.insertRow(tbl_elem.rows.length);
			var cell1 = document.createElement("td");
			var cell2 = document.createElement("td");
			
			
			
			cell1.innerHTML = '<a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/img/publish_x.png"  border="0" alt="Delete"></a>';
			
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
		<form action="index.php?option=<?php echo $option?>" method="post" name="adminForm" enctype="multipart/form-data">
		<?php
		//echo $tabs->startPane('matchmain');
		//echo $tabs->startPanel(JText::_( 'BLBE_MAIN' ),'match_conf');
		$etabs->newTab(JText::_( 'BLBE_MAIN' ),'main_conf','','vis');
		$etabs->newTab(JText::_( 'BLBE_SQUARD' ),'squard_conf','');
		
		?>
		<div style="clear:both"></div>
		<div id="main_conf_div" class="tabdiv">
		
		<table>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLBE_MATCHDAYNAME' ); ?>
				</td>
				<td>
					<?php echo $lists['mday'];?>
				</td>
			</tr>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLBE_RESULTS' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_RESULTS' ); ?>::<?php echo JText::_( '' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $lists['teams1'].' <input type="text" name="score1" value="'.$row->score1.'" size="5" maxlength="5" />&nbsp;:&nbsp;<input type="text" name="score2" value="'.$row->score2.'" size="5" maxlength="5" /> '.$lists['teams2'];?>
				</td>
			</tr>
			<tr>
				<td width="100">
					<?php echo JText::_( 'Bonus Points' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'Bonus Points' ); ?>::<?php echo JText::_( '' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $lists['teams1'].' <input type="text" name="bonus1" value="'.floatval($row->bonus1).'" size="5" maxlength="5" />&nbsp;:&nbsp;<input type="text" name="bonus2" value="'.floatval($row->bonus2).'" size="5" maxlength="5" /> '.$lists['teams2'];?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JText::_( 'BLBE_ET' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_ET' ); ?>::<?php echo JText::_( '' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<Td>
					<?php echo $lists['extra'];?>
				</Td>
			</tr>
			<tr>
				<td>
					<?php echo JText::_( 'BLBE_PLAYED' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_PLAYED' ); ?>::<?php echo JText::_( 'BLBE_TT_PLAYED' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>					
				</td>
				<Td>
					<?php echo $lists['m_played'];?>
				</Td>
			</tr>
			
			<tr>
				<td>
					<?php echo JText::_('BLBE_DATE');?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_DATE' ); ?>::<?php echo JText::_( 'BLBE_TT_DATE' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>					
					
				</td>
				<td>
					<?php
						echo JHTML::_('calendar', $row->m_date ? $row->m_date : date("Y-m-d"), 'm_date', 'm_date', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'10')); 
					?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JText::_('BLBE_TIME');?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_TIME' ); ?>::<?php echo JText::_( 'BLBE_TT_TIME' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
					
				</td>
				<td>
					<input type="text" maxlength="5" size="10" name="d_time" value="<?php echo substr($row->m_time,0,5);?>" />
					
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JText::_('BLBE_LOCATION');?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_LOCATION' ); ?>::<?php echo JText::_( 'BLBE_TT_LOCATION' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
					
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
					<?php echo JText::_( 'BLBE_ABOUTMATCH' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_ABOUTMATCH' ); ?>::<?php echo JText::_( '' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $editor->display( 'match_descr',  htmlspecialchars($row->match_descr, ENT_QUOTES), '550', '300', '60', '20', array('pagebreak', 'readmore') ) ;  ?>
				</td>
			</tr>
			
		</table>
		<br />
<table width="100%">
<tr>
	<td>
	<div style="float:left; width:50%;">		
		<table class="adminlist" id="new_events">
			<tr>
				<th align="center" colspan="5" class="title">
				<?php echo JText::_( 'BLBE_PLAYEREVENTS' ); ?>


				</th>
			</tr>
			<tr>
				<th class="title" width="2%">
					<?php echo JText::_( 'Num' ); ?>				</th>


				<th class="title" width="170">
					<?php echo JText::_( 'BLBE_PLAYEREVENT' ); ?>
				</th>
				<th>
					<?php echo JText::_( 'BLBE_PLAYER' ); ?>
				</th>
				
				<th class="title" width="60">
					<?php echo JText::_( 'BLBE_MINUTES' ); ?>
				</th>
				<th class="title" width="60">
					<?php echo JText::_( 'BLBE_COUNT' ); ?>
				</th>
			</tr>
			<?php
			if(count($lists['m_events'])){
				foreach($lists['m_events'] as $m_events){
					echo "<tr>";
					echo '<td><input type="hidden" name="em_id[]" value="'.$m_events->id.'" /><a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/img/publish_x.png"  border="0" alt="Delete"></a></td>';
					echo '<td><input type="hidden" name="new_eventid[]" value="'.$m_events->e_id.'" />'.$m_events->e_name.'</td>';
					echo '<td><input type="hidden" name="new_player[]" value="'.$m_events->player_id.'" />'.$m_events->p_name.'</td>';
					echo '<td><input type="text" size="5" maxlength="5" name="e_minuteval[]" value="'.$m_events->minutes.'" /></td>';
					echo '<td><input type="text" size="5" maxlength="5" name="e_countval[]" value="'.$m_events->ecount.'" /></td>';
					echo "</tr>";
				}
			}
			?>
		</table>
		<table class="adminlist">
			<tr>
				<th class="title" colspan="3" align="center">
					<?php echo JText::_( 'BLBE_ADDPLEVENTS' ); ?>

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
					<input name="re_count" id="re_count" type="text" maxlength="5" size="5" value="" />
					<input type="button" value="<?php echo JText::_( 'BLBE_ADD' ); ?>" onClick="bl_add_event();" />
				</th>
				
			</tr>
		</table>
		<br />
	</div>
	<div style="float:right; width:50%">
		<table class="adminlist" id="new_tevents">
			<tr>
				<th class="title" align="center" colspan="4">
					<?php echo JText::_( 'BLBE_MATCHSTATS' ); ?>


				</th>
			</tr>
			<tr>
				<th class="title" width="2%">
					<?php echo JText::_( 'Num' ); ?>


				</th>
				<th class="title" width="170">
					<?php echo JText::_( 'BLBE_MATCHSTATSEV' ); ?>
				</th>
				<th>
					<?php echo JText::_( 'BLBE_TEAM' ); ?>
				</th>
				<th width="60">
					<?php echo JText::_( 'BLBE_COUNT' ); ?>
				</th>
				
			</tr>
			<?php
			if(count($lists['t_events'])){
				foreach($lists['t_events'] as $m_events){
					echo "<tr>";
					echo '<td><a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/img/publish_x.png"  border="0" alt="Delete"></a></td>';
					echo '<td><input type="hidden" name="new_teventid[]" value="'.$m_events->e_id.'" />'.$m_events->e_name.'</td>';
					echo '<td><input type="hidden" name="new_tplayer[]" value="'.$m_events->pid.'" />'.$m_events->p_name.'</td>';
					echo '<td><input type="text" size="5" maxlength="5" name="et_countval[]" value="'.$m_events->ecount.'" /></td>';
					echo "</tr>";
				}
			}
			?>
		</table>
		<table class="adminlist">
			<tr>
				<th class="title" colspan="3" align="center">
					<?php echo JText::_( 'BLBE_ADDSTATTOMATCH' ); ?>


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
					<input type="button" value="<?php echo JText::_( 'BLBE_ADD' ); ?>" onClick="bl_add_tevent();" />
				</th>
			</tr>
		</table>
		<br />
	</div>
</td>
</tr>
</table>
	<div>	
		<table style="padding:10px;">
			<tr>
				<td>
					<?php echo JText::_( 'BLBE_UPLPHTOMTCH' ); ?>

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
					<?php echo JText::_( 'BLBE_ONEPHSEL' ); ?>


				</td>
			</tr>
		</table>
		<?php
		if(count($lists['photos'])){
		?>
		<table class="adminlist">
			<tr>
				<th class="title" width="30"><?php echo JText::_( 'BLBE_DELETE' ); ?></th>
				
				<th class="title" ><?php echo JText::_( 'BLBE_TITLE' ); ?></th>

				<th class="title" width="250"><?php echo JText::_( 'BLBE_IMAGE' ); ?></th>
			</tr>
			<?php
			foreach($lists['photos'] as $photos){
			?>
			<td align="center">
				<a href="javascript:void(0);" title="<?php echo JText::_( 'BLBE_REMOVE' ); ?>" onClick="javascript:Delete_tbl_row(this);"><img src="<?php echo JURI::base();?>components/com_joomsport/img/publish_x.png" title="<?php echo JText::_( 'BLBE_REMOVE' ); ?>" /></a>
				<input type="hidden" name="photos_id[]" value="<?php echo $photos->id;?>"/>
			</td>
			
			<td>
				<input type="text" maxlength="255" size="60" name="ph_names[]" value="<?php echo htmlspecialchars($photos->name)?>" />
			</td>
			<td align="center">
				<?php
				$imgsize = getimagesize('../media/bearleague/'.$photos->filename);
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
	<div id="squard_conf_div" class="tabdiv" style="display:none;">	
		<?php echo JText::_( 'BLBE_LINEUP' ); ?>
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
					<?php echo JText::_( 'Num' ); ?>


					</th>
					
					<th>
						<?php echo JText::_( 'BLBE_PLAYER' ); ?>
					</th>
					
					
				</tr>
				<?php
				if(count($lists['squard1'])){
					foreach($lists['squard1'] as $m_events){
						echo "<tr>";
						echo '<td><a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/img/publish_x.png"  border="0" alt="Delete"></a></td>';
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
					
						<input type="button" value="<?php echo JText::_( 'BLBE_ADD' ); ?>" onClick="bl_add_squard('new_squard1','playersq1_id','t1_squard[]');" />
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
					<?php echo JText::_( 'Num' ); ?>

					</th>
					
					<th>
						<?php echo JText::_( 'BLBE_PLAYER' ); ?>
					</th>
					
					
				</tr>
				<?php
				if(count($lists['squard2'])){
					foreach($lists['squard2'] as $m_events){
						echo "<tr>";
						echo '<td><a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/img/publish_x.png"  border="0" alt="Delete"></a></td>';
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
					
						<input type="button" value="<?php echo JText::_( 'BLBE_ADD' ); ?>" onClick="bl_add_squard('new_squard2','playersq2_id','t2_squard[]');" />
					</th>
				</tr>
			</table>
			<br />
		</div>
		</div>
				<?php echo JText::_( 'BLBE_SUBSTITUTES' ); ?>
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
					<?php echo JText::_( 'Num' ); ?>

					</th>
					
					<th>
						<?php echo JText::_( 'BLBE_PLAYER' ); ?>
					</th>
					
					
				</tr>
				<?php
				if(count($lists['squard1_res'])){
					foreach($lists['squard1_res'] as $m_events){
						echo "<tr>";
						echo '<td><a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/img/publish_x.png"  border="0" alt="Delete"></a></td>';
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
					
						<input type="button" value="<?php echo JText::_( 'BLBE_ADD' ); ?>" onClick="bl_add_squard('new_squard1_res','playersq1_id_res','t1_squard_res[]');" />
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
					<?php echo JText::_( 'Num' ); ?>

					</th>
					
					<th>
						<?php echo JText::_( 'BLBE_PLAYER' ); ?>
					</th>
					
					
				</tr>
				<?php
				if(count($lists['squard2_res'])){
					foreach($lists['squard2_res'] as $m_events){
						echo "<tr>";
						echo '<td><a href="javascript: void(0);" onClick="javascript:Delete_tbl_row(this); return false;" title="Delete"><img src="components/com_joomsport/img/publish_x.png"  border="0" alt="Delete"></a></td>';
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
					
						<input type="button" value="<?php echo JText::_( 'BLBE_ADD' ); ?>" onClick="bl_add_squard('new_squard2_res','playersq2_id_res','t2_squard_res[]');" />
					</th>
				</tr>
			</table>
			<br />
		</div>
		</div>
	</div>
		
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="id" value="<?php echo $row->id?>" />
		<input type="hidden" name="team1_id" value="<?php echo $row->team1_id?>" />
		<input type="hidden" name="team2_id" value="<?php echo $row->team2_id?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
	
		<?php
		
	}
	
	////////-------------Events --------------///
	function bl_EventList( $rows, $page, $option )
	{
		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');
		JHTML::_('behavior.tooltip');
		?>
		<?php
		if(!count($rows)){
			echo "<div id='system-message'><dd class='notice'><ul>".JText::_('BLBE_NOITEMS')."</ul></dd></div>";
		}
		?>
		<form action="index.php?option=<?php echo $option;?>" method="post" name="adminForm">
		<table class="adminlist">
		<thead>
			<tr>
				<th width="2%" align="left">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				<th width="2%" align="left">
					<?php echo JText::_( 'ID' ); ?>
				</th>
				<th width="2%">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" />
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_EVENT' ); ?>
				</th>
				<th class="title" width="100">
					<?php echo JText::_( 'BLBE_IMAGE' ); ?>
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
			$link = JRoute::_( 'index.php?option='.$option.'&task=event_edit&cid[]='. $row->id );
			$checked 	= @JHTML::_('grid.checkedout',   $row, $i );
			//$published 	= JHTML::_('grid.published', $row, $i);
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $page->getRowOffset( $i ); ?>
				</td>
				<td>
					<?php echo $row->id; ?>
				</td>
				<td>
					<?php echo $checked; ?>
				</td>
				<td>
					<?php
						echo '<a href="'.$link.'">'.$row->e_name.'</a>';
					?>
				</td>
				<td align="center">
					<?php 
					if( $row->e_img ){
						echo '<img height="20px"src="/media/bearleague/events/'.$row->e_img.'" />';
					}
					?>
				</td>
				
			</tr>
			<?php
		}
		} 
		?>
		</tbody>
		</table>
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="event_list" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
	<?php
	}
	
	function bl_editEvent($row, $lists, $option){
		$editor =& JFactory::getEditor();
		JHTML::_('behavior.tooltip');
		joomsport_html::JS_getObj();
		?>
		<script type="text/javascript">
		<!--
		Joomla.submitbutton = function(task) {
			submitbutton(task);
		}
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			 if(pressbutton == 'event_apply' || pressbutton == 'event_save'){
			 	if(form.e_name.value != ''){
					submitform( pressbutton );
					return;
				}else{
					getObj('evname').style.border = "1px solid red";
					alert("<?php echo JText::_('BLBE_JSMDNOT1');?>");
					
					
				}
			}else{
				submitform( pressbutton );
					return;
			}
		}	
		function View_eventimg(){
			getObj('view_img').innerHTML = '<img src="/media/bearleague/events/'+document.adminForm.e_img.value+'" width="25" />';
		}
		
		//-->
		</script>
		<form action="index.php?option=<?php echo $option?>" method="post" name="adminForm" enctype="multipart/form-data">
		
		<table>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLBE_EVENTNAME' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_EVENTNAME' ); ?>::<?php echo JText::_( '' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<input type="text" name="e_name" id="evname" value="<?php echo $row->e_name?>" maxlength="255" />
				</td>
			</tr>
			<tr>
				<td width="100" valign="top">
					<?php echo JText::_( 'BLBE_PLEVENT' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_PLEVENT' ); ?>::<?php echo JText::_( 'BLBE_TT_PLEVENT' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $lists['player_event'];?>
				</td>
			</tr>
			<tr>
				<td width="100" valign="top">
					<?php echo JText::_( 'BLBE_EVIMG' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_EVIMG' ); ?>::<?php echo JText::_( '' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $lists['image']." ".Jtext::_('BLBE_EVNEWIMG') ;?> <input type="file" name="new_event_img">
					<br />
					<div id="view_img" style="width:50px; height:50px; margin: 10px; ">
						<?php 
						if( $row->e_img ){
							echo '<img id="img_div" src="/media/bearleague/events/'.$row->e_img.'" width="25" />';
						}
						?>
					</div>
				</td>
			</tr>
		</table>
		
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="id" value="<?php echo $row->id?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		
		<?php
		
	}
	
	
	////////-------------Groups --------------///
	function bl_GroupList( $rows, $page, $option )
	{
		
		?>
		<?php
		if(!count($rows)){
			echo "<div id='system-message'><dd class='notice'><ul>".JText::_('BLBE_NOITEMS')."</ul></dd></div>";
		}
		?>
		<form action="index.php?option=<?php echo $option;?>" method="post" name="adminForm">
		<table class="adminlist">
		<thead>
			<tr>
				<th width="2%" align="left">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				<th width="2%">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" />
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_GROUP' ); ?>
				</th>
				<th width="8%" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   'Order', 'ordering', @$lists['order_Dir'], @$lists['order'] ); ?>
					<?php echo JHTML::_('grid.order',  $rows,'filesave.png', 'group_ordering' ); ?>
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
			$link = JRoute::_( 'index.php?option='.$option.'&task=group_edit&cid[]='. $row->id );
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
						echo '<a href="'.$link.'">'.$row->group_name.'</a>';
					?>
				</td>
				<td class="order">
					<input type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>" class="text_area" style="text-align: center" />
				</td> 
				
			</tr>
			<?php
		}
		} 
		?>
		</tbody>
		</table>
		
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="group_list" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
	<?php
	}
	
	function bl_editGroup($row, $lists, $option){
		JHTML::_('behavior.tooltip');
		joomsport_html::JS_getObj();
		?>
		<script type="text/javascript">
		<!--
		Joomla.submitbutton = function(task) {
			submitbutton(task);
		}
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'group_save' || pressbutton == 'group_apply') {
				if(form.group_name.value != "" && form.s_id.value != 0){
					if('<?php echo $row->id?>' != 0){
						var srcListName = 'teams_seasons';
						var srcList = eval( 'form.' + srcListName );
						if(srcList){
						var srcLen = srcList.length;
					
						for (var i=0; i < srcLen; i++) {
								srcList.options[i].selected = true;
						} 
						}
					}
					submitform( pressbutton );
					return;
				}else{	
					alert("<?php echo JText::_( 'BLBE_JSMDNOT10' ); ?>");	



				}
			}else{
				submitform( pressbutton );
					return;
			}
		}	
		
		
		//-->
		</script>
		<form action="index.php?option=<?php echo $option?>" method="post" name="adminForm">
				<br />
		<div style="background-color:#eee;"><?php echo JText::_( 'BLBE_ASSIGNTEAMGROUP' ); ?></div>
		<br />
		<table>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLBE_GROUPNAME' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_GROUPNAME' ); ?>::<?php echo JText::_( '' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<input type="text" name="group_name" value="<?php echo $row->group_name?>" maxlength="255" />
				</td>
			</tr>
			<tr>
				<td width="100" valign="top">
					<?php echo JText::_( 'BLBE_SEASON' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_SEASON' ); ?>::<?php echo JText::_( 'BLBE_TT_SEASONGROUP' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $lists['tourn'];?>
				</td>
			</tr>
			
			
		</table>
		<?php
		if($row->id && $row->s_id){
		?>
		<table>
			<tr>
				<td width="150">
					<?php echo JText::_( 'BLBE_ADD_TEAMS' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_ADD_TEAMS' ); ?>::<?php echo JText::_( 'BLBE_TT_ADD_TEAMS' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td width="150">
					<?php echo $lists['teams'];?>
				</td>
				<td valign="middle" width="60" align="center">
					<input type="button" value=">>" onClick="javascript:JS_addSelectedToList('adminForm','teams_id','teams_seasons');" /><br />
					<input type="button" value="<<" onClick="javascript:JS_delSelectedFromList('adminForm','teams_seasons');" />
				</td>
				<td >
					<?php echo $lists['teams2'];?>
				</td>
			</tr>
		</table>
		<?php
		}
		?>
		
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="id" value="<?php echo $row->id?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		
		<?php
		
	}
	
	///-----------menu-----------------//
	function bl_SeasonMenu( $rows, $option )
	{
		$jsf = JRequest::getVar('function','jSelectArticle','','string');
		JHTML::_('behavior.tooltip');
		?>
		
		<table class="adminlist">
		<thead>
			<tr>
				<th width="2%" align="left">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				
				<th class="title">
					<?php echo JText::_( 'Name' ); ?>
				</th>
			</tr>
		</thead>
		
		<tbody>
		<?php
		$k = 0;
		if( count( $rows ) ) {
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row 	= $rows[$i];
			JFilterOutput::objectHtmlSafe($row);
			//$published 	= JHTML::_('grid.published', $row, $i);
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo  $i+1; ?>
				</td>
				
				<td>
					<a href="javascript:window.parent.<?php echo $jsf;?>('<?php echo $row->id?>', '<?php echo htmlspecialchars($row->name, ENT_QUOTES, 'UTF-8')?>', 'sid');"><?php echo $row->name; ?></a>
				</td>
				
				
			</tr>
			<?php
		}
		} 
		?>
		</tbody>
		</table>
	<?php
	}
	function bl_GroupMenu( $rows, $option )
	{
		$jsf = JRequest::getVar('function','jSelectArticle','','string');
		JHTML::_('behavior.tooltip');
		?>
		
		<table class="adminlist">
		<thead>
			<tr>
				<th width="2%" align="left">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				
				<th class="title">
					<?php echo JText::_( 'Name' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_( 'Season' ); ?>
				</th>
			</tr>
		</thead>
		
		<tbody>
		<?php
		$k = 0;
		if( count( $rows ) ) {
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row 	= $rows[$i];
			JFilterOutput::objectHtmlSafe($row);
			//$published 	= JHTML::_('grid.published', $row, $i);
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo  $i+1; ?>
				</td>
				
				<td>
					<a href="javascript:window.parent.<?php echo $jsf;?>('<?php echo $row->id?>', '<?php echo htmlspecialchars($row->group_name, ENT_QUOTES, 'UTF-8')?>', 'gr_id');"><?php echo $row->group_name; ?></a>
				</td>
				<td>
					<?php echo $row->name; ?>
				</td>
				
			</tr>
			<?php
		}
		} 
		?>
		</tbody>
		</table>
	<?php
	}
	function bl_TeamMenu( $rows, $option )
	{
		
		JHTML::_('behavior.tooltip');
		?>
		
		<table class="adminlist">
		<thead>
			<tr>
				<th width="2%" align="left">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				
				<th class="title">
					<?php echo JText::_( 'Name' ); ?>
				</th>
			</tr>
		</thead>
		
		<tbody>
		<?php
		$k = 0;
		if( count( $rows ) ) {
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row 	= $rows[$i];
			JFilterOutput::objectHtmlSafe($row);
			//$published 	= JHTML::_('grid.published', $row, $i);
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo  $i+1; ?>
				</td>
				
				<td>
					<a href="javascript:window.parent.jSelectArticle('<?php echo $row->id?>', '<?php echo htmlspecialchars($row->t_name, ENT_QUOTES, 'UTF-8')?>?>', 'tid');"><?php echo $row->t_name; ?></a>
				</td>
				
				
			</tr>
			<?php
		}
		} 
		?>
		</tbody>
		</table>
	<?php
	}
	
	function bl_PlayerMenu( $rows, $page, $lists, $option )
	{
		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');
		JHTML::_('behavior.tooltip');
		?>
		<?php
		if(!count($rows)){
			echo "<div id='system-message'><dd class='notice'><ul>".JText::_('BLBE_NOITEMS')."</ul></dd></div>";
		}
		?>
		<form action="index.php?option=<?php echo $option;?>" method="post" name="adminForm">
		<div align="right"><?php echo JText::_( 'BLBE_FILTERS' ); ?><?php echo $lists['pos']."".$lists['teams1'];?></div>	
		<table class="adminlist">
		<thead>
			<tr>
				<th width="2%" align="left">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				
				<th class="title">
					<?php echo JText::_( 'BLBE_PLAYER' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_POSITION' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_TEAM' ); ?>
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
			$link = JRoute::_( 'index.php?option=com_joomsport&task=player_edit&cid[]='. $row->id );
			$checked 	= @JHTML::_('grid.checkedout',   $row, $i );
			//$published 	= JHTML::_('grid.published', $row, $i);
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $page->getRowOffset( $i ); ?>
				</td>
				
				<td>
					<?php
						echo '<a href="javascript:window.parent.jSelectArticle('.$row->id.', \''.htmlspecialchars($row->first_name.' '.$row->last_name, ENT_QUOTES, 'UTF-8').'\', \'id\');">'.$row->first_name.' '.$row->last_name.'</a>';
					?>
				</td>
				<td>
					<?php echo $row->p_name; ?>
				</td>
				<td>
					<?php echo $row->t_name; ?>
				</td>
				
				
			</tr>
			<?php
		}
		} 
		?>
		</tbody>
		</table>
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="player_menu" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="tmpl" value="component" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
	<?php
	}
	
	function bl_MatchMenu( $rows, $page, $option )
	{
		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');
		JHTML::_('behavior.tooltip');
		?>
		<form action="index.php?option=<?php echo $option;?>" method="post" name="adminForm">
		<table class="adminlist">
		<thead>
			<tr>
				<th width="2%" align="left">
					<?php echo JText::_( 'Num' ); ?>				</th>
				<th class="title"><?php echo JText::_( 'Game' ); ?></th>
				<th class="title"><?php echo JText::_( 'BLBE_MATCHDAY' ); ?></th>
				
				
			</tr>
		</thead>
		<tfoot>
		<tr>
			<td colspan="13">
				<?php echo $page->getListFooter(); ?>			</td>
		</tr>
		</tfoot>
		<tbody>
		<?php
		$k = 0;
		if( count( $rows ) ) {
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row 	= $rows[$i];
			JFilterOutput::objectHtmlSafe($row);
			
			
			//$published 	= JHTML::_('grid.published', $row, $i);
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $page->getRowOffset( $i ); ?>				
				</td>
				<td>
					<?php echo '<a href="javascript:window.parent.jSelectArticle('.$row->id.', \''.htmlspecialchars($row->home." ".$row->score1.":".$row->score2." ".$row->away, ENT_QUOTES, 'UTF-8').'\', \'id\');">'.$row->home." ".$row->score1.":".$row->score2." ".$row->away.'</a>';?>				
				</td>
				<td>
					<?php
						echo $row->m_name;
					?>
				</td>
				
			</tr>
			<?php
		}
		} 
		?>
		</tbody>
		</table>
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="match_menu" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="tmpl" value="component" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
	<?php
	}
	
	
	////////-------------match day
	function bl_Matchday_menu( $rows, $page, $lists, $option )
	{
		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');
		JHTML::_('behavior.tooltip');
		?>
		
		<?php
		if(!count($rows)){
			echo "<div id='system-message'><dd class='notice'><ul>".JText::_('BLBE_NOITEMS')."</ul></dd></div>";
		}
		?>
		<form action="index.php?option=<?php echo $option;?>" method="post" name="adminForm">
		<div align="right"><?php echo $lists['tourn'];?></div>	
		<table class="adminlist">
		<thead>
			<tr>
				<th width="2%" align="left">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_MATCHDAY' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_TOURNAMENT' ); ?>
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
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $page->getRowOffset( $i ); ?>
				</td>
				<td>
				
					<?php echo '<a href="javascript:window.parent.jSelectArticle('.$row->id.', \''.htmlspecialchars($row->m_name, ENT_QUOTES, 'UTF-8').'\', \'id\');">'.$row->m_name.'</a>';?>				
			
				</td>
				<td>
					<?php echo $row->tourn;?>
				</td>
				
			</tr>
			<?php
		}
		} 
		?>
		</tbody>
		</table>
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="matchday_menu" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="tmpl" value="component" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
	<?php
	}
	
	//-------FIELDS-------------//
	function bl_FieldsList( $rows, $page, $option, $lists )
	{
		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');
		JHTML::_('behavior.tooltip');
		?>
		<?php
		if(!count($rows)){
			echo "<div id='system-message'><dd class='notice'><ul>".JText::_('BLBE_NOITEMS')."</ul></dd></div>";
		}
		?>
		<form action="index.php?option=<?php echo $option;?>" method="post" name="adminForm">
		<div align="right"><?php echo $lists['is_type'];?></div>
		<table class="adminlist">
		<thead>
			<tr>
				<th width="2%" align="left">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				<th width="2%">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" />
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_FIELD' ); ?>
				</th>
				<th class="title">
					<?php echo JText::_( 'BLBE_FIELDTYP' ); ?>
				</th>
				<th width="8%" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   'Order', 'ordering', @$lists['order_Dir'], @$lists['order'] ); ?>
					<?php echo JHTML::_('grid.order',  $rows ); ?>
				</th> 
				<th width="5%">
					<?php echo JText::_( 'Published' ); ?>
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
			$link = JRoute::_( 'index.php?option=com_joomsport&task='.$lists['f_edit'].'&cid[]='. $row->id );
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
						echo '<a href="'.$link.'">'.$row->name.'</a>';
					?>
				</td>
				<td>
					<?php echo $row->type?(($row->type==1)?JText::_( 'BLBE_TEAM'):'Match' ):JText::_( 'BLBE_PLAYER' ); ?>
				</td>
				<td class="order">
					<input type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>" class="text_area" style="text-align: center" />
				</td> 
				<td align="center">
					<?php 
					if(!$row->published){
						?>
						<a title="Publish Item" onclick="return listItemTask('cb<?php echo $i?>','<?php echo $lists['f_publ'];?>')" href="javascript:void(0);">
						<img border="0" alt="Unpublished" src="components/com_joomsport/img/publish_x.png"/></a>
						<?php
					}else{
						?>
						<a title="Unpublish Item" onclick="return listItemTask('cb<?php echo $i?>','<?php echo $lists['f_unpubl'];?>')" href="javascript:void(0);">
						<img border="0" alt="Published" src="components/com_joomsport/img/tick.png"/></a>
						<?php
					}
					?>
				</td>
				
			</tr>
			<?php
		}
		} 
		?>
		</tbody>
		</table>
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="fields_list" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
	<?php
	}
	
	function bl_editFields($row, $lists, $option){
		$editor =& JFactory::getEditor();
		JHTML::_('behavior.tooltip');
		joomsport_html::JS_getObj();
		?>
		<script type="text/javascript">
		Joomla.submitbutton = function(task) {
			submitbutton(task);
		}
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			 if(pressbutton == 'fields_apply' || pressbutton == 'fields_save'){
			 	if(form.name.value != ''){
					submitform( pressbutton );
					return;
				}else{
					getObj('fldname').style.border = "1px solid red";
					alert("<?php echo JText::_('BLBE_JSMDNOT1');?>");
					
					
				}
			}else{
				submitform( pressbutton );
					return;
			}	
		}	
		</script>
		<form action="index.php?option=<?php echo $option?>" method="post" name="adminForm">
		
		<table>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLBE_FIELDNAME' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_FIELDNAME' ); ?>::<?php echo JText::_( 'BLBE_TT_FIELDNAME' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<input type="text" maxlength="255" size="60" name="name" id="fldname" value="<?php echo htmlspecialchars($row->name)?>" />
				</td>
			</tr>
			<tr>
				<td width="100">
					<?php echo JText::_( 'Publish' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'Publish' ); ?>::<?php echo JText::_( 'Publishing' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $lists['published'];?>
				</td>
			</tr>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLBE_FIELDTYP' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_FIELDTYP' ); ?>::<?php echo JText::_( 'BLBE_TT_FIELDTYP' );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $lists['is_type'];?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					
				</td>
			</tr>
			<tr>
				<td width="100">
					<?php echo JText::_( 'BLBE_FIELDTABVIEW' ); ?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'BLBE_FIELDTABVIEW' ); ?>::<?php echo JText::_( "BLBE_TT_FIELDTABVIEW" );?>"><img src="components/com_joomsport/img/quest.jpg" border="0" /></span>
				</td>
				<td>
					<?php echo $lists['t_view'];?>
				</td>
			</tr>
		</table>
		
		<input type="hidden" name="option" value="<?php echo $option?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="id" value="<?php echo $row->id?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		
			 		
		<?php
	}
	
	#######################################
			###	--- ---   	LANGUAGES 	--- --- ###
	
	function BL_showLanguagesList( &$rows, &$pageNav, $option ) {
		
		?>
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr>
				
				<td valign="top">
					<form action="index.php" method="post" name="adminForm">
					
					<table class="adminlist">
					<thead>
					<tr>
						<th width="20"><?php echo JText::_( 'Num' ); ?></th>

						<th width="20" class="title"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
						<th class="title"><?php echo JText::_( 'BLBE_LANGNAME' ); ?></th>
						<th class="title"><?php echo JText::_( 'BLBE_DEFAULT' ); ?></th>


						<th class="title" width="50%"></th>
					</tr>
					</thead>
					<tfoot>
					<tr>
						<td colspan="10">
						<?php echo $pageNav->getListFooter(); ?>
						</td>
					</tr>
					</tfoot>
					<?php
					$k = 0;
					for ($i=0, $n=count($rows); $i < $n; $i++) {
						$row = $rows[$i];
						$checked 	= @JHTML::_('grid.checkedout',   $row, $i );
						?>
						<tr class="<?php echo "row$k"; ?>">
							<td align="center"><?php echo $pageNav->getRowOffset( $i ); ?></td>
							<td><?php echo $checked; ?></td>
							<td align="left">
								<span>
									<?php echo $row->lang_file; ?>
								</span>
							</td>
							<td><?php if ($row->is_default) { ?>
								<img src="components/com_joomsport/img/tick.png"  border="0" alt="User choice" />
								<?php } ?>
							</td>
							<td></td>
						</tr>
						<?php
						$k = 1 - $k;
					}?>
					</table>
					
					
					<input type="hidden" name="option" value="<?php echo $option; ?>" />
					<input type="hidden" name="task" value="labels" />
					<input type="hidden" name="boxchecked" value="0" />
					<input type="hidden" name="hidemainmenu" value="0">
					</form>
				</td>
			</tr>
		</table>			
		<?php
	}
	
	function BL_editLanguage( &$row, &$lists, $option, $jq_language ) {
		jimport('joomla.html.pane');
		$tabs = &JPane::getInstance('tabs', array('allowAllClose' => true)); 
		?>
		<script language="javascript" type="text/javascript">
		<!--
		Joomla.submitbutton = function(task) {
			submitbutton(task);
		}
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel_lang') {
				submitform( pressbutton );
				return;
			}
			// do field validation
			var reg_label = /[0-9a-z]/;
			if (form.lang_file.value == ""){
				alert( "<?php echo JText::_( 'BLBE_JSMDNOT11' ); ?>" );


			} else if (!reg_label.test(form.lang_file.value)) {
				alert('<?php echo JText::_( 'BLBE_JSMDNOT12' ); ?>');


			} else {
				submitform( pressbutton );
			}
		}
		//-->
		</script>
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr>
				
				<td valign="top">
					<form action="index.php" method="post" name="adminForm" >
					
					
					<?php
					$tabs->startPane("labelsPane");
					$tabs->startPanel("Description","labeldetails-page");
					?> 
					<table width="100%" class="adminform">
						<tr>
							<th colspan="3"><?php echo JText::_( 'BLBE_LANGDET' ); ?></th>

						</tr>
						<tr>
							<td align="right" width="20%" valign="top"><?php echo JText::_( 'BLBE_LANGNAME' ); ?></td>
							<td valign="top"><input type="text" class="text_area" size="35" name="lang_file" value="<?php echo $row->lang_file;?>"></td>
							
						</tr>
					</table>
					<?php
						$tabs->endPanel();
						$tabs->startPanel("Table","labeltexts-page");
					?>
					<table width="100%" class="adminform">
						<tr>
							<th colspan="2"><?php echo JText::_( 'BLBE_LANGRANK' ); ?></th>

						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGRANK_RANK' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TBL_RANK" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TBL_RANK']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGRANK_TEAMS' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TBL_TEAMS" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TBL_TEAMS']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGRANK_PLAYED' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TBL_PLAYED" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TBL_PLAYED']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGRANK_WIN' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TBL_WINS" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TBL_WINS']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGRANK_DRAW' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TBL_DRAW" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TBL_DRAW']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGRANK_LOST' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TBL_LOST" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TBL_LOST']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGRANK_ETW' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TBL_EXTRAWIN" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TBL_EXTRAWIN']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGRANK_ETL' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TBL_EXTRALOST" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TBL_EXTRALOST']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGRANK_DIF' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TBL_DIFF" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TBL_DIFF']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGRANK_GD' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TBL_GD" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TBL_GD']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGRANK_POINT' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TBL_POINTS" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TBL_POINTS']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGRANK_WPC' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TBL_WINPERCENT" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TBL_WINPERCENT']));?>" /></td>
						</tr>
					</table>
					<?php
						$tabs->endPanel();
						$tabs->startPanel("Tabs","labeltexts-page2");
					?>
					<table width="100%" class="adminform">
						<tr>
							<th colspan="2"><?php echo JText::_( 'BLBE_LANGTAB' ); ?></th>

						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGTAB_TEAM' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TAB_TEAM" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TAB_TEAM']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGTAB_MATCHES' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TAB_MATCHES" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TAB_MATCHES']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGTAB_PLAYERS' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TAB_PLAYERS" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TAB_PLAYERS']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGTAB_PHTO' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TAB_PHOTOS" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TAB_PHOTOS']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGTAB_PLAY' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TAB_PLAYER" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TAB_PLAYER']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGTAB_MATCH' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TAB_MATCH" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TAB_MATCH']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGTAB_ABT' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TAB_ABOUT" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TAB_ABOUT']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGTAB_PLSTAT' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TAB_STAT" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TAB_STAT']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGTAB_SQUAD' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TAB_SQUAD" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TAB_SQUAD']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BL_TAB_TBL' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TAB_TBL" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TAB_TBL']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BL_TAB_ABOUTSEAS' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TAB_ABOUTSEAS" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TAB_ABOUTSEAS']));?>" /></td>
						</tr>
					</table>
					<?php
						$tabs->endPanel();
						$tabs->startPanel("Others","labeltexts-page2");
					?>
					<table width="100%" class="adminform">
						<tr>
							<th colspan="2"><?php echo JText::_( 'BLBE_LANGVIEWS' ); ?></th>

						</tr>
						<tr>
							<th colspan="2"><?php echo JText::_( 'BLBE_LANGVIEWST' ); ?></th>

						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGVIEWST_CITY' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_CITY" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_CITY']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGVIEWST_PL' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TBL_PLAYER" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TBL_PLAYER']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGVIEWST_POS' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TBL_POSITION" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TBL_POSITION']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGVIEWST_DET' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_LINK_DETAILMATCH" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_LINK_DETAILMATCH']));?>" /></td>
						</tr>
						<tr>
							<th colspan="2"><?php echo JText::_( 'BLBE_LANGVIEWSP' ); ?></th>

						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGVIEWSP_FN' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_NAME" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_NAME']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGVIEWSP_POS' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_POSITION" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_POSITION']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGVIEWSP_NIC' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_NICK" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_NICK']));?>" /></td>
						</tr>
						<tr>
							<th colspan="2"><?php echo JText::_( 'BLBE_LANGVIEWSMD' ); ?></th>

						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGVIEWSMD_ET' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_RES_EXTRA" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_RES_EXTRA']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGVIEWSMD_TSTAT' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_TBL_STAT" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_TBL_STAT']));?>" /></td>
						</tr>
						<tr>
							<th colspan="2"><?php echo JText::_( 'BLBE_LANGVIEWSOTH' ); ?></th>

						</tr>						
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGVIEWSOTH_B' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_BACK" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_BACK']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGVIEWSOTH_CAL' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_CALENDAR" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_CALENDAR']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGVIEWSOTH_LINUP' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_LINEUP" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_LINEUP']));?>" /></td>
						</tr>
						<tr>
							<td align="right" width="30%" valign="top"><?php echo JText::_( 'BLBE_LANGVIEWSOTH_SUBST' ); ?></td>
							<td><input type="text" class="text_area" size="50" name="BL_SUBTITUTES" value="<?php echo stripslashes(str_replace('"',"&quot;",$jq_language['BL_SUBTITUTES']));?>" /></td>
						</tr>
					</table>
					<?php
						$tabs->endPanel();
						$tabs->endPane();
					?>
					<input type="hidden" name="option" value="<?php echo $option; ?>" />
					<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
					<input type="hidden" name="task" value="" />
					</form>
				</td>
			</tr>
		</table>			
		<?php
	}
	
	function BL_Help()	{
	 ?>
		<table class="adminlist">
			<tr>
				<td>
				<?php include_once(JPATH_COMPONENT.DS.'jbl_help.php'); ?>
				</td>
			</tr>
		</table>
	<?php
	}
	function BL_About()	{
	 ?>
		<table class="adminlist">
			<tr>
				<td>
				<?php include_once(JPATH_COMPONENT.DS.'jbl_about.php'); ?>
				</td>
			</tr>
		</table>
	<?php
	}
	
}	