<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
class com_joomsportInstallerScript{
 function postflight($type, $parent) 
        {
               $database =& JFactory::getDBO();
	       $query = "SELECT `extension_id` FROM #__extensions WHERE `element` = 'com_joomsport'";
		$database->setQuery( $query );
		$exid = $database->loadResult();
		
		$query = "UPDATE #__menu SET component_id = ".$exid." WHERE link LIKE 'index.php?option=com_joomsport%'";
		$database->setQuery( $query );
		$database->query();
		$query = "UPDATE #__extensions SET name='com_joomsport' WHERE `element` = 'com_joomsport'";
		$database->setQuery( $query );
		$database->query();
		
        }
}