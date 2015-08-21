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

$filemanager_name          = 'elFinder';
$filemanager_dirname       = 'elfinder';
$filemanager_version       = '2.0 rc1';
$filemanager_sourceurl     = 'http://elfinder.org';
$filemanager_registerfiles = array(
    '/modules/tinymce/tinymce/filemanager/elfinder/php/connector.php'
);
$filemanager_include = "
    ,file_browser_callback: function(field_name, url, type, win) {
        var elfinder_url = CAT_URL+'/modules/tinymce/tinymce/filemanager/elfinder/elfinder.php?mode='+type;
        tinymce.activeEditor.windowManager.open({
            file: elfinder_url,
            title: 'elFinder 2.0',
            width: 900,
            height: 450,
            resizable: 'yes',
            oninsert: function(url) {
                win.document.getElementById(field_name).value = url;
            }
        }, {
            setUrl: function (url) {
                win.document.getElementById(field_name).value = url;
            }
        });
        return false;
    }
";

/*
function elFinderBrowser (field_name, url, type, win) {
                var cmsURL = '/elfinder/elfinder.php';    // script URL - use an absolute path!
                if (cmsURL.indexOf("?") < 0) {
                    //add the type as the only query parameter
                    cmsURL = cmsURL + "?type=" + type;
                }
                else {
                    //add the type as an additional query parameter
                    // (PHP session ID is now included if there is one at all)
                    cmsURL = cmsURL + "&type=" + type;
                }

                tinyMCE.activeEditor.windowManager.open({
                    file : cmsURL,
                    title : 'elFinder 2.0',
                    width : 900,
                    height : 450,
                    resizable : "yes",
                    inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
                    popup_css : false, // Disable TinyMCE's default popup CSS
                    close_previous : "no"
                }, {
                    window : win,
                    input : field_name
                });
                return false;
            }
*/