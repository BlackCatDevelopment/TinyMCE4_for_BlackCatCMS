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
 *   @category        CAT_Modules
 *   @package         tinymce
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

include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderConnector.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinder.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeDriver.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeLocalFileSystem.class.php';

if(!defined('CAT_PATH'))
    require dirname(__FILE__).'/../../../../../../../../config.php';

/**
 * check user permissions
 *
 * @param  string  $attr  attribute name (read|write|locked|hidden)
 * @param  string  $path  file path relative to volume root directory started with directory separator
 * @return bool|null
 **/
function access($attr, $path, $data, $volume)
{
    $backend = CAT_Backend::getInstance('media','media',false,false);
    $user    = CAT_Users::getInstance();
    if(($user->get_permission('media_view') === true)) // user can view media
    {
        // always hide files and folders beginning with a dot
        if(strpos(basename($path), '.') === 0) return NULL;
        // if user can view and attr is read return true
        if($attr == 'read') return true;
        // if attr is write and user can write...
        // note: we cannot distinguish upload / create (folder) with elFinder!
        if($attr == 'write')
        {
            return
                ( $user->get_permission('media_upload') === true
                  || $user->get_permission('media_create') === true )
                ;
        }
    }
    return NULL; // default = denied
}

$val     = CAT_Helper_Validate::getInstance();
$path    = CAT_Helper_Directory::sanitizePath(CAT_PATH.MEDIA_DIRECTORY);
$url     = CAT_Helper_Validate::sanitize_url(CAT_URL.MEDIA_DIRECTORY);

if($val->fromSession('HOME_FOLDER') && file_exists(CAT_PATH.MEDIA_DIRECTORY.$val->fromSession('HOME_FOLDER')))
{
   $path = CAT_Helper_Directory::sanitizePath(CAT_PATH.MEDIA_DIRECTORY.$val->fromSession('HOME_FOLDER'));
   $url  = CAT_Helper_Validate::sanitize_url(CAT_URL.MEDIA_DIRECTORY.$val->fromSession('HOME_FOLDER'));
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
            'defaults'      => array( 'read' => false, 'write' => false ),
            'attributes'    => array(
                array(  // show directories
                    'pattern' => '~^[/\\\]~',
                    'hidden' => false,
                ),
                array( // hide any files by default; only show files that match the current type
                    'pattern' => '~\..*$~',
                    'hidden' => true,
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
                )
            );
            $opts['roots'][0]['uploadAllow'] = array('image');
            break;
        case 'media':
            array_push( // show flash only
                $opts['roots'][0]['attributes'],
                array(
        			'pattern' => '/\.(mp3|wav|mp4|webm|ogg|swf)$/',   // what the media plugin allows
        			'hidden' => false,
                    'locked' => false,
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

