<?php
defined('_JEXEC') or die('Restricted access');

function date_bl($date,$time){
	$db			=& JFactory::getDBO(); 
	$format = "%d-%m-%Y %H:%M";
	if($date == '' || $date == '0000-00-00'){
		return '';
	}
	//echo $date.' - '.$time."<br />";
	$query = "SELECT cfg_value FROM #__bl_config WHERE cfg_name='date_format'";
	$db->setquery($query);
	$format = $db->loadResult();
	switch ($format){
		case "d-m-Y H:i": $format = "%d-%m-%Y %H:%M"; break;
		case "m-d-Y g:i A": $format = "%m-%d-%Y %I:%M %p"; break;
		case "j F, Y H:i": $format = "%m %B, %Y %H:%M"; break;
		case "j F, Y g:i A": $format = "%m %B, %Y %I:%H %p"; break;
		case "d-m-Y": $format = "%d-%m-%Y"; break;
		case "l d F, Y H:i": $format = "%A %d %B, %Y  %H:%M"; break;
	}
	
	if(!$time){
		$time = '00:00';
	}
	$time_m = explode(':',$time);
	$date_m = explode('-',$date);
	//echo $time_m[0].','.$time_m[1].','.$date_m[1].','.$date_m[2].','.$date_m[0];
	if(function_exists('date_default_timezone_set')){
		date_default_timezone_set('GMT');
	}
	$tm = @mktime($time_m[0],$time_m[1],'0',$date_m[1],$date_m[2],$date_m[0]);
	jimport('joomla.utilities.date');
	$dt = new JDate($tm,0);
	return $dt->toFormat($format);
	//return JHTML::_('date',@mktime(substr($time,0,2),substr($time,3,2),0,substr($date,5,2),substr($date,8,2),substr($date,0,4)),$format,0);
}
function getVer(){
	$version = new JVersion;
	$joomla = $version->getShortVersion();
	return substr($joomla,0,3);
}
function getImgPop($img){
	$max_height = 500;
	$max_width = 600;
	$link = JURI::base().'media/bearleague/'.$img;
	$fileDetails = pathinfo(JURI::base().'media/bearleague/'.$img);
	$img_types = array('png','gif','jpg','jpeg');
        $ext = strtolower($fileDetails["extension"]);
	
	if (is_file(JPATH_ROOT.'/media/bearleague/'.$img) && in_array(strtolower($ext),$img_types)){
		$size = getimagesize(JPATH_ROOT.'/media/bearleague/'.$img);
		
		if($size[0] > $max_width && $size[0] > $size[1]){
			$link = JURI::base().'components/com_joomsport/includes/imgres.php?src='.$link.'&w='.$max_width;
		}else if($size[1] > $max_height && $size[1] > $size[0]){
			$link =JURI::base().'components/com_joomsport/includes/imgres.php?src='.$link.'&h='.$max_height;
		}
	}
	
	return $link;
}
?>