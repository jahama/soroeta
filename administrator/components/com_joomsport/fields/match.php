<?php
/**
developed by BearDev.com
*/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
jimport('joomla.form.formfield');
class JFormFieldMatch extends JFormField
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	 protected $type = 'match';
	protected function getInput()
	{
		
		$db			=& JFactory::getDBO();
		$doc 		=& JFactory::getDocument();
		
		//$fieldName	= $control_name.'['.$name.']';
		$article->title = '';
		
		if ($this->value) {
			$query = "SELECT m.*,t1.t_name as home,t2.t_name as away FROM #__bl_match as m, #__bl_teams as t1, #__bl_teams as t2 WHERE t1.id = m.team1_id AND t2.id = m.team2_id AND m.id = ".$this->value;
			$db->setQuery($query);
		
			$rows = $db->loadObjectList();
			if(isset($rows[0])){
				$row = $rows[0];
				$article->title = $row->home." ".$row->score1.":".$row->score2." ".$row->away;
			}
		} else {
			$article->title = JText::_('BLBE_SELMATCHY');
		}
		$script = array();
		$script[] = '	function jSelectArticle(id, title, catid, object) {';
		$script[] = '		document.id("'.$this->id.'_id").value = id;';
		$script[] = '		document.id("'.$this->id.'_name").value = title;';
		$script[] = '		SqueezeBox.close();';
		$script[] = '	}';

		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
		$link = 'index.php?option=com_joomsport&amp;task=match_menu&amp;tmpl=component&amp;object=namee';
		JHTML::_('behavior.modal', 'a.modal');
		$title = htmlspecialchars($article->title, ENT_QUOTES, 'UTF-8');

		// The current user display field.
		$html[] = '<div class="fltlft">';
		$html[] = '  <input type="text" id="'.$this->id.'_name" value="'.$title.'" disabled="disabled" size="35" />';
		$html[] = '</div>';

		// The user select button.
		$html[] = '<div class="button2-left">';
		$html[] = '  <div class="blank">';
		$html[] = '	<a class="modal" title="'.JText::_('SELECT').'"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 800, y: 450}}">'.JText::_('SELECT').'</a>';
		$html[] = '  </div>';
		$html[] = '</div>';

		// The active article id field.
		if (0 == (int)$this->value) {
			$value = '';
		} else {
			$value = (int)$this->value;
		}

		// class='required' for client side validation
		$class = '';
		if ($this->required) {
			$class = ' class="required modal-value"';
		}

		$html[] = '<input type="hidden" id="'.$this->id.'_id"'.$class.' name="'.$this->name.'" value="'.$value.'" />';

		return implode("\n", $html);
	}
}