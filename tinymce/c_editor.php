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
 *   @author          Administrator
 *   @copyright       2013, Black Cat Development
 *   @link            http://blackcat-cms.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @category        CAT_Modules
 *   @package         TinyMCE
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

$debug = false;
if (true === $debug) {
	ini_set('display_errors', 1);
	error_reporting(E_ALL|E_STRICT);
}

require sanitize_path(realpath(dirname(__FILE__).'/../wysiwyg_admin/c_editor_base.php'));

final class c_editor extends c_editor_base
{

    protected static $default_skin   = 'lightgray';
    protected static $editor_package = 'custom';

    public function getFilemanagerPath()
    {
        return sanitize_path(realpath(dirname(__FILE__).'/tinymce/filemanager'));
    }

    public function getSkinPath()
    {
        return sanitize_path(realpath(dirname(__FILE__).'/tinymce/skins'));
    }

    public function getPluginsPath()
    {
        return sanitize_path(realpath(dirname(__FILE__).'/tinymce/plugins'));
    }

    public function getToolbars()
    {
        return array( 'Full', 'Smart', 'Simple' );
    }

    public function getAdditionalSettings()
    {
        return array();
    }

    public function getAdditionalPlugins()
    {
        $defaults = array( 'emoticons', 'filemanager', 'image', 'link', 'media', 'visualblocks' );
        $path     = $this->getPluginsPath();
        $subs     = CAT_Helper_Directory::getInstance()->setRecursion(false)->getDirectories( $path, $path.'/' );
        // remove defaults from subs
        $plugins  = array_diff($subs,$defaults);
        if(count($plugins)) return $plugins;
        return array();
    }

}