<?php
/*
BearDev.com
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<div style=" width:100%;float:left; padding:10px;font-family: verdana, arial, sans-serif; font-size: 9pt;">
	<div style="float:left; width:70%;">
		<h1>JoomSport Help</h1>
	</div>
	<div style="float:right;margin-right:20px;">
		<?php
			echo '<a href="http://beardev.com" target="_blank">'.JHTML::_('image.site',  'logobigbright.png', '/components/com_joomsport/img/', NULL, NULL, 	'BearDev.com' ).'</a>'
		?>
	</div>	
	<div style="float:left; width:75%">
		<p>
			<a href="#1">1. Tournament</a><br />
			<a href="#2">2. Season</a><br />
			<a href="#3">3. Teams</a><br />
			<a href="#4">4. Match Day</a><br />
			<a href="#5">5. Players</a><br />
			<a href="#6">6. Positions</a><br />
			<a href="#7">7. Events</a><br />
			<a href="#8">8. Groups</a><br />
			<a href="#9">9. Extra fields</a><br />
			<a href="#10">10. Languages</a><br />
			<a href="#11">11. Configuration</a><br />
			<a href="#12">12. Team Captains</a><br />
			<a href="#13">13. FE access</a><br />
			<a href="#14">14. FE Managment</a><br />
		</p>

		<div>
			<a name="1"></a>
			<h4>1. Tournament</h4>
			In this section you can create <i>Tournament</i> for any teams.
			
			<ul>
				<li>Go to <b>Components -> JoomSport -> Tournaments</b></li>
				<li>Click <b>New</b> button</li>
			</ul>
			Tournaments are used as categories for the seasons<br />
			Also you can upload Logo for tournament and write some description about it.
		</div>

		<div>
			<a name="2"></a>
			<h4>2. Season</h4>
			In this section you can create <i>Season</i>.  To create new season
			<ul>
				<li>Go to <b>Components -> JoomSport -> Season</b></li>
				<li>Press <b>New</b> button</li>
				<li>Select tournament</li>
				<li>Set won, draw, lost points</li>
				<li>Add teams to the season</li>
				<li>Press <b>Save</b> button</li>
			</ul>
			Specify the colors to highlight the Tournament Table lines (Tab 'Table Colors'). </p>
			To highlight the line you need: 
			<ul>
				<li>Select the Color <b>Season -> Tab 'Table colors'</b></li>
				<li>Press <b>...</b> button or input the color value. Ex. <i>'#FFFFFF'</i></li>
				<li>Input the line number for selected color. Ex. <i>'1,2,3'</i> or <i>'1-3'</i></li>
				<li>To add other color press <i>'Add new'</i> button</li>
			</ul>
			Also in this section you can specify site Users who have FE access to edit the Season.
			You may specify <i>Tournament Table Columns</i> which should be displayed at FE<br> 
			Set ranking criteria. The order of the sorting Teams on the tournament table when the Points are equal.
		</div>

		<div>
			<a name="3"></a>
			<h4>3. Teams</h4>
			In this section you can create <i>Teams.</i> To create new team
			<ul>
				<li>Go to <b>Comopnents -> JoomSport -> Team</b></li>
				<li>Press <b>New</b> button</li>
				<li>Fill all necessary fields*</li>
				<li>Press <b>Save</b> button</li>
			</ul>
			
			You can set custom points for each team for each tournament<br />
			If you want to <a href="#11">highlight your team</a> in Season Table you need mark CheckBox 'Your Team'<br />
			<p><i>*If the standard fields are not enough you can create extra text fields</i> ( <a href="#9">Extra fields</a> )</p>
			<p><i>Attention!!  If you keep any Extra Team field empty, it will not display at FE</i></p>
			
		</div>

		<div>
			<a name="4"></a>
			<h4>4. Match Day</h4>
			In that section you can create new <i>Match Day.</i> To create new Match Day
			<ul>
				<li>Go to <b>Components -> JoomSport -> Match Day</b></li>
				<li>Select tournament in DropDown List under match day list</li>
				<li>Press <b>New</b> button</li>
				<li>Add match results</li>
				<li>Press <b>Apply</b> or <b>Save</b> button</li>
			</ul>
				You can also add details** to the match. There are player events and match statistics. To add player events choose event, player and set minutes. To add statistic choose event and set count. After that press <b>Save</b> button.<br />
				Also in match details section you can specify bonus points for each team which will be calculated as extra points in the tournament table<br />
				Add simnplest Teams Squad.<br />
				<p><i>**To add match details, press <b>Apply</b> button after creating match results, then <b>&quot;Match Details&quot;</b> link will be displayed next to the match</i></p>
		</div>	

		<div>
			<a name="5"></a>
			<h4>5. Players</h4>
			In this section you can create <i>Players.</i> 
			<ul>	
				<li>Go to <b>Comopnents -> JoomSport -> Players</b></li>
				<li>Press <b>New</b> button</li>
				<li>Enter First, Last and Nick name, upload photo, set player position, player team, enter player description***</li>
				<li>Press <b>Save</b> button</li></br>
			</ul>
			<p><i>***If the standard fields are not enough you can create extra text fields</i> ( <a href="#9">Extra fields</a> )</p>
			<p><i>Attention!!  If you keep any Extra Player field empty, it will not display at FE</i></p>		
		</div>

		<div>
			<a name="6"></a>
			<h4>6. Positions</h4>
			In this section you can add a player position according to your kind of sport.
		</div>

		<div>
			<a name="7"></a>
			<h4>7. Events</h4>
			In this section you can create player events or statistics. You can also add an icon to the events which will be displayed at the FE near event name.
		</div>

		<div>
			<a name="8"></a>
			<h4>8. Groups</h4>
			If you have Group tournament in that section you can create groups and attached**** teams. At the FE tournament table will be displayed according to your groups.
			<p><i>****To add teams to a Group first you need press <b>Apply</b> button and then sort teams.</i></p>
		</div>

		<div>
			<a name="9"></a>
			<h4>9. Extra fields</h4>
			In this section you can create extra text fields to improve teams/players or match info.<br />
			To display extra field at the tournament/player statistic table (Season page/Team page) mark 'Yes'
		</div>

		<div>
			<a name="10"></a>
			<h4>10. Languages</h4>
			In this section you can create new language file for Front End<br />
			To create new language file you need: 
			<ul>
				<li>Go to <b>Components -> JoomSport->Languages</b></li>
				<li>Press <b>New</b> button </li>
				<li>Translate all the words </li>
				<li>Press <b>Save</b> button</li>
			</ul>
			To display your translation on the FE make default the language file
		</div>

		<div>
			<a name="11"></a>
			<h4>11. Configurations</h4>
			In this section you can set <i>Date Format</i> you want to display at FE <br />
			And specify <i>Your Team Color</i> to highlight your team in the Season Table
		</div>

		<div>
			<a name="12"></a>
			<h4>12. Team Captains</h4>
			In this section you can specify teams which the User can moderate from FE.<br />
			To follow in moderate area you need click Edit icon. The icon will be appear on FE near the Team name in the Tournamnet table when the user is logged in.
		</div>		
		
		<div>
			<a name="13"></a><h4>13. FE access</h4></br>
			You can create FE access to the: 
			<ul>
				<li>Team </li>
				<li>Season </li>
				<li>Match </li>
				<li>Player</li>
				<li>MatchDay</li>
			</ul>
			<p>In order to display the Team at FE, first, create a new menu item. Choose the type <i>JoomSport -> Team Layout</i> then on the following page in the <i>Parameters (Basic)</i> block select the <i>Season</i> and then select the <i>Team</i> you want to display on FE</p>
			<p>In order to display the Season at FE, first, create a new menu item. Choose the type <i>JoomSport -> Season Table Layout</i> then on the following page in the <i>Parameters (Basic)</i> block select the <i>Season</i> you want to display on FE</p>
			<p>In order to display the Match at FE, first, create a new menu item. Choose the type <i>JoomSport -> Match Layout</i> then on the following page in the <i>Parameters (Basic)</i> block select the <i>Match</i> you want to display on FE</p>
			<p>In order to display the Player at FE, first, create a new menu item. Choose the type <i>JoomSport -> Player Layout</i> then on the following page in the <i>Parameters (Basic)</i> block select the <i>Player</i> you want to display on FE</p>	
			<p>In order to display the MatchDay at FE, first, create a new menu item. Choose the type <i>JoomSport -> MatchDay Layout</i> then on the following page in the <i>Parameters (Basic)</i> block select the <i>MatchDay</i> you want to display on FE</p>		
		</div>


		<div>
			<a name="14"></a>
			<h4>14. FE Managment</h4>
			JoomSport allows Site users manage Season and specified Team from FE.<br />
			To specify Users who can manage the Season you need:
			<ul>
				<li>Go to <b>Components -> JoomSport -> Season</b> </li>
				<li>In section 'Add Season Administrators' specify users you want to manage the Season </li>
				<li>Press <b>Save</b> button </li>
				<li>Create menu item to the season (Menus -> New item)</li>
				<li>Go to FE</li>
				<li>Login as specified user</li>
				<li>Click on the Season link under the Season table</li>
			</ul>
			<p>Season Administrators can manage teams, players and Match Days. </p>

			To specify Users who can manage only Team you need(Team Captains):
			<ul>
				<li>Go to <b>Components -> JoomSport -> Team Captains -> New</b> </li>ou want 
				<li>Select the user you want to be a Team Captain</li>
				<li>Specify the teams for the user account</li>
				<li>Press <b>Save</b> button </li>
				<li>Create menu item to the season (Menus -> New item)</li>
				<li>Go to FE</li>
				<li>Login as specified user</li>
				<li>Click on the Edit icon near the team name in the tournament table</li>
			</ul>
			<p>Team Captain can manage Team info, Team players and Team matches. </p>
			</div>
			<p><i>Attention!!  Team Captain cannot tick the match as played. Because the admin should approve the results which was Team Captain inserted. </i></p>
			
		<div>
			<p><b><i>Create your own league and enjoy the simplicity of the product!</i></b></p>
		</div>
	</div>
</div