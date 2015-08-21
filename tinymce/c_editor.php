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
        return CAT_Helper_Directory::sanitizePath(realpath(dirname(__FILE__).'/tinymce/filemanager'));
    }

    public function getSkinPath()
    {
        return CAT_Helper_Directory::sanitizePath(realpath(dirname(__FILE__).'/tinymce/skins'));
    }

    public function getPluginsPath()
    {
        return CAT_Helper_Directory::sanitizePath(realpath(dirname(__FILE__).'/tinymce/plugins'));
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
        $defaults = array(
            'advlist', 'anchor', 'autolink', 'autoresize', 'autosave', 'bbcode', 'charmap', 'cmsplink', 'code', 'colorpicker',
            'contextmenu', 'directionality', 'droplets', 'emoticons', 'example', 'example_dependency',
            'filemanager', 'fullpage', 'fullscreen', 'hr', 'image', 'imagetools', 'importcss', 'insertdatetime',
            'layer', 'legacyoutput', 'link', 'lists', 'media', 'nonbreaking', 'noneditable',
            'pagebreak', 'paste', 'preview', 'print', 'save', 'searchreplace', 'spellchecker',
            'tabfocus', 'table', 'template', 'textcolor', 'textpattern',
            'visualblocks', 'visualchars', 'wordcount', 
        );
        $path     = $this->getPluginsPath();
        $subs     = CAT_Helper_Directory::getInstance()->setRecursion(false)->getDirectories( $path, $path.'/' );
        // remove defaults from subs
        $plugins  = array_diff($subs,$defaults);
        if(count($plugins)) return $plugins;
        return array();
    }

    public function getFrontendCSS()
    {
        return array();
    }

}