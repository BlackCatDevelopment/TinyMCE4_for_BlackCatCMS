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
 *   @copyright       2013, Black Cat Development
 *   @link            http://blackcat-cms.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @category        CAT_Modules
 *   @package         tinymce
 *
 */

if (defined('CAT_PATH')) {
    if (defined('CAT_VERSION')) include(CAT_PATH.'/framework/class.secure.php');
} elseif (file_exists($_SERVER['DOCUMENT_ROOT'].'/framework/class.secure.php')) {
    include($_SERVER['DOCUMENT_ROOT'].'/framework/class.secure.php');
} else {
    $subs = explode('/', dirname($_SERVER['SCRIPT_NAME']));    $dir = $_SERVER['DOCUMENT_ROOT'];
    $inc = false;
    foreach ($subs as $sub) {
        if (empty($sub)) continue; $dir .= '/'.$sub;
        if (file_exists($dir.'/framework/class.secure.php')) {
            include($dir.'/framework/class.secure.php'); $inc = true;    break;
        }
    }
    if (!$inc) trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
}

include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderConnector.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinder.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeDriver.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeLocalFileSystem.class.php';

if(!defined('CAT_PATH'))
    require dirname(__FILE__).'/../../../../../../../../config.php';

/**
 * Simple function to demonstrate how to control file access using "accessControl" callback.
 * This method will disable accessing files/folders starting from  '.' (dot)
 *
 * @param  string  $attr  attribute name (read|write|locked|hidden)
 * @param  string  $path  file path relative to volume root directory started with directory separator
 * @return bool|null
 **/
function access($attr, $path, $data, $volume) {
	return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
		? !($attr == 'read' || $attr == 'write')    // set read+write to false, other (locked+hidden) set to true
		:  null;                                    // else elFinder decide it itself
}


$val  = CAT_Helper_Validate::getInstance();
$path = sanitize_path(CAT_PATH.MEDIA_DIRECTORY);
$url  = sanitize_url(CAT_URL.MEDIA_DIRECTORY);

if($val->fromSession('HOME_FOLDER') && file_exists(CAT_PATH.MEDIA_DIRECTORY.$val->fromSession('HOME_FOLDER')))
{
   $path = sanitize_path(CAT_PATH.MEDIA_DIRECTORY.$val->fromSession('HOME_FOLDER'));
   $url  = sanitize_url(CAT_URL.MEDIA_DIRECTORY.$val->fromSession('HOME_FOLDER'));
}

$opts = array(
	'debug' => true,
	'roots' => array(
        // root directory
		array(
			'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
			'path'          => $path,               // path to files (REQUIRED)
			'URL'           => $url,                // URL to files (REQUIRED)
			'accessControl' => 'access',            // disable and hide dot starting files (OPTIONAL)
  	        'acceptedName'  => '/^[^\.].*$/',       // deny dot starting files
            'defaults'      => array( 'read' => true, 'write' => true ),
            'attributes'    => array(
                array(  // show directories
                    'pattern' => '~^[/\\\]~',
                    'hidden' => false,
                ),
                array( // hide any files
                    'pattern' => '~\..*$~',
                    //'hidden' => true,
                    'locked' => true,
                    'read' => false,
                    'write' => false,
                ),
        	),
            'uploadAllow' => array(),
            'uploadOrder' => array('allow', 'deny'),
		),
	),
);

if($val->sanitizeGet('mode'))
{
    switch ($val->sanitizeGet('mode'))
    {
        case 'image':
            array_push( // show images only
                $opts['roots'][0]['attributes'],
                array(
                    'pattern' => '~\.(png|jpe?g|gif|bmp)$~',
                    'hidden' => false,
                    'locked' => false,
                    'read' => true,
                    'write' => true,
                )
            );
            $opts['roots'][0]['uploadAllow'] = array('image');
            break;
        case 'flash':
            array_push( // show flash only
                $opts['roots'][0]['attributes'],
                array(
        			'pattern' => '/\.(swf|fla)$/',   // allow flash
        			'hidden' => false,
        		)
            );
            break;
        default:
    	  	break;
    }
}






// run elFinder
$connector = new elFinderConnector(new elFinder($opts));
$connector->run();

