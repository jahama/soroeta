<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
function createThumbs( $pathToImages, $pathToThumbs, $thumbWidth )
{
  $dir = opendir( $pathToImages );

  while (false !== ($fname = readdir( $dir ))) {
    $info = pathinfo($pathToImages . $fname);
	if ( strtolower($info['extension']) == 'jpg' || strtolower($info['extension']) == 'gif' || strtolower($info['extension']) == 'png'){
		if ( strtolower($info['extension']) == 'jpg' )
		{
			$img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
		}elseif(strtolower($info['extension']) == 'gif'){
			$img = imagecreatefromgif( "{$pathToImages}{$fname}" );
		}elseif(strtolower($info['extension']) == 'png'){
			$img = imagecreatefrompng( "{$pathToImages}{$fname}" );
		}
		  $width = imagesx( $img );
		  $height = imagesy( $img );

		  $new_width = $thumbWidth;
		  $new_height = floor( $height * ( $thumbWidth / $width ) );

		  $tmp_img = imagecreatetruecolor( $new_width, $new_height );

		  imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

		  if ( strtolower($info['extension']) == 'jpg' )
		  {
			imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
		  }elseif(strtolower($info['extension']) == 'gif'){
			imagegif( $tmp_img, "{$pathToThumbs}{$fname}" );
		  }elseif(strtolower($info['extension']) == 'png'){
			imagepng( $tmp_img, "{$pathToThumbs}{$fname}" );
		  }		
    }
  }
  closedir( $dir );
}

function createThumb( $pathToImages, $pathToThumbs, $thumbWidth, $fname )
{
    $info = pathinfo($pathToImages . $fname);
	if ( strtolower($info['extension']) == 'jpg' || strtolower($info['extension']) == 'gif' || strtolower($info['extension']) == 'png'){
		if ( strtolower($info['extension']) == 'jpg' )
		{
			$img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
		}elseif(strtolower($info['extension']) == 'gif'){
			$img = imagecreatefromgif( "{$pathToImages}{$fname}" );
		}elseif(strtolower($info['extension']) == 'png'){
			$img = imagecreatefrompng( "{$pathToImages}{$fname}" );
		}

		  $width = imagesx( $img );
		  $height = imagesy( $img );

		  $new_width = $thumbWidth;
		  $new_height = floor( $height * ( $thumbWidth / $width ) );

		  $tmp_img = imagecreatetruecolor( $new_width, $new_height );

		  imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

		  if ( strtolower($info['extension']) == 'jpg' )
		  {
			imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
		  }elseif(strtolower($info['extension']) == 'gif'){
			imagegif( $tmp_img, "{$pathToThumbs}{$fname}" );
		  }elseif(strtolower($info['extension']) == 'png'){
			imagepng( $tmp_img, "{$pathToThumbs}{$fname}" );
		  }
    }
}

?>