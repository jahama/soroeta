<?php
/**
 * $ModDesc
 * 
 * @version		$Id: $file.php $Revision
 * @package		modules
 * @subpackage	$Subpackage.
 * @copyright	Copyright (C) November 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
 */
 
// no direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';

$list = modLofArticlesSlideShowHelper::getList( $params );

$tmp            = $params->get( 'module_height', 'auto' );
$moduleHeight   = ( $tmp=='auto' ) ? 'auto' : (int)$tmp.'px';
$tmp            = $params->get( 'module_width', 'auto' );
$moduleWidth    = ( $tmp=='auto') ? 'auto': (int)$tmp.'px';
$themeClass     = $params->get( 'theme' , '');
$openTarget     = $params->get( 'open_target', 'parent' );
$class          = $params->get( 'navigator_pos', 'right' ) == "0" ? '':'lof-sn'.$params->get( 'navigator_pos', 'right' );
$css3           = $params->get('enable_css3','1')? " lof-css3":"";
$isIntrotext    = $params->get('slider_information', 'description') == 'description'?0:1;
$enableBlockdescription = $params->get( 'enable_blockdescription' , 1 );
// navigator setting 
$navEnableThumbnail     = $params->get( 'enable_thumbnail', 1 );
$navEnableTitle         = $params->get( 'enable_navtitle', 1 );
$navEnableDate          = $params->get( 'enable_navdate', 1 );
$navEnableCate          = $params->get( 'enable_navcate', 1 );
$customSliderClass = $params->get('custom_slider_class','');
$customSliderClass = is_array($customSliderClass)?$customSliderClass:array($customSliderClass);

modLofArticlesSlideShowHelper::loadMediaFiles( $params, $module );
require( JModuleHelper::getLayoutPath($module->module) );

?>
<script type="text/javascript">

  var _lofmain =  $('lofass<?php echo $module->id; ?>'); 
  <?php if( $params->get('desc_opacity',1) != 1 ){ ?>
	if( _lofmain.getElements(".lof-description") ){
		_lofmain.getElements(".lof-description").setStyle("opacity", <?php echo (float)$params->get('desc_opacity',1); ?>);
	}
  <?php } ?>
  
  var object = new LofSlideshow( _lofmain,
                  { 
                    fxObject:{
                    transition:<?php echo $params->get( 'effect', 'Sine.easeInOut' );?>,  
                    duration:<?php echo (int)$params->get('duration', '700')?>
                    },
                    startItem:<?php echo (int)$params->get('start_item',0);?>,
                    interval:<?php echo (int)$params->get('interval', '3000'); ?>,
                    direction :'<?php echo $params->get('layout_style','opacity');?>', 
                    navItemHeight:<?php echo $params->get('navitem_height', 100) ?>,
                    navItemWidth:<?php echo $params->get('navitem_width', 290) ?>,
                    navItemsDisplay:<?php echo $params->get('max_items_display', 3) ?>,
                    navPos:'<?php echo $params->get( 'navigator_pos', 0 ); ?>'
                  } );
  <?php if( $params->get('display_button', '') ): ?>
    object.registerButtonsControl( 'click', {next:_lofmain.getElement('.lof-next'),
                         previous:_lofmain.getElement('.lof-previous')} );
  <?php endif; ?>
    object.start( <?php echo $params->get('auto_start',1)?>, _lofmain.getElement('.preload') );

</script>

