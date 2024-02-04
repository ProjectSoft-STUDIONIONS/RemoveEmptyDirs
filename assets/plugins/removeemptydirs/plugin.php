<?php
if(!defined('MODX_BASE_PATH')){die('What are you doing? Get out of here!');}

if(!function_exists('removeEmptyFolders')):
	function removeEmptyFolders($path){
		$isFolderEmpty = true;
		$pathForGlob = (substr($path, -1) == "/") ? $path . "*" : $pathForGlob = $path . DIRECTORY_SEPARATOR . "*";
		// смотрим что есть внутри раздела
		foreach (glob($pathForGlob) as $file){
			if (is_dir($file)){
				if (!removeEmptyFolders($file)) {
					$isFolderEmpty = false;
				}
			}else{
				$isFolderEmpty = false;
			}
		}
		if ($isFolderEmpty){
			@rmdir($path);
		}
		return $isFolderEmpty;
	}
endif;

$e = &$modx->event;
switch($e->name){
	case "OnManagerLogin":
	case "OnManagerLogout":

		/**
		 * Запустим для директорий images, files, media
		 */
		removeEmptyFolders(MODX_BASE_PATH . 'assets/images');
		removeEmptyFolders(MODX_BASE_PATH . 'assets/files');
		removeEmptyFolders(MODX_BASE_PATH . 'assets/media');
		break;
}