<?php

/**
 *   @author          Black Cat Development
 *   @copyright       2013, Black Cat Development
 *   @link            http://blackcat-cms.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @category        CAT_Modules
 *   @package         ckeditor4
 *
 */

// Include the config file
require_once('../../../../../config.php');

/**
 * cleanup some items that may cause problems
 */
function droplet_clean_str(&$aStr,$quotes=true) {
	$vars = array(
		"\n" => "<br /> ",
		"\r" => "<br /> ",
        '&'  => '&amp;',
	);
    if($quotes)
        $vars = array_merge($vars, array('"' => "\\\"", '\'' => "") );
	$string = str_replace( array_keys($vars), array_values($vars), $aStr);
    $string = preg_replace('/(?:\]\](?!\s))/', ']]<br />', $string );
    //return strip_tags($string);
    return $string;
}

$droplets = CAT_Helper_Droplet::getDroplets();

foreach ( $droplets as $item )
{
	$title	= droplet_clean_str( $item['name'] );
	$desc	= droplet_clean_str( $item['description'], false );
	$comm	= droplet_clean_str( $item['comments'], false );
    $data[] = array( 'title' => $title, 'description' => $desc, 'comment' => $comm );
}

$parser->setPath(dirname(__FILE__));
$parser->output(
    'droplets.tpl',
    array('data'=>$data)
);