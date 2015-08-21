<?php

/**
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 3 of the License, or (at
 *   your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful, but
 *   WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 *   General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, see <http://www.gnu.org/licenses/>.
 *
 *   @author          Black Cat Development
 *   @copyright       2015, Black Cat Development
 *   @link            http://blackcat-cms.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @category        CAT_Core
 *   @package         CAT_Core
 *
 */

if (defined('CAT_PATH')) {
	include(CAT_PATH.'/framework/class.secure.php');
} else {
	$root = "../";
	$level = 1;
	while (($level < 10) && (!file_exists($root.'/framework/class.secure.php'))) {
		$root .= "../";
		$level += 1;
	}
	if (file_exists($root.'/framework/class.secure.php')) {
		include($root.'/framework/class.secure.php');
	} else {
		trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
	}
}

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
$regex    = '/\[\[(\w+\?[\w=]+)\]\]/';

foreach ( $droplets as $item )
{
	$title	= droplet_clean_str( $item['name'] );
	$desc	= droplet_clean_str( $item['description'], false );
	$comm	= droplet_clean_str( $item['comments'], false );
    // extract droplet params from comment
    preg_match($regex,$comm,$m);
    if(isset($m[1])) $usage = '[['.$m[1].']]';
    else             $usage = '[['.$title.']]';
    $data[] = array( 'title' => $title, 'description' => $desc, 'comment' => strip_tags($comm), 'usage' => $usage );
}

echo json_encode(array('result'=>$data));