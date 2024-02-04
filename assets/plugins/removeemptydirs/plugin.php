<?php
/**
 * Если функция не существует
 * Создать
 * Если функция существует
 * Пропустить
 */
if(!function_exists('removeEmptyFolders')):
	function removeEmptyFolders($path){
		/**
		 * по умолчание ставим, что текущий раздел пустой
		*/
		$isFolderEmpty = true;
		/**
		 * смотрим последний символ пути
		*/
		if(substr($path, -1) == "/"){
			/**
			 * добавим "*" в конце
			*/
			$pathForGlob = $path . "*";
		}else{
			/**
			 * добавим "/*" в конце
			*/
			$pathForGlob = $path . DIRECTORY_SEPARATOR . "*";
		}
		// смотрим что есть внутри раздела
		foreach (glob($pathForGlob) as $file){
			/**
			 * Если раздел директория
			*/
			if (is_dir($file)){
				/**
				 * Запустим ещё раз самого себя
				*/
				if (!removeEmptyFolders($file)) {
					$isFolderEmpty = false;
				}
			}else{
				/**
				 * значит раздел не пустой
				*/
				$isFolderEmpty = false;
			}
		}

		/**
		 * если раздел в итоге пустой, удаляем его
		*/
		if ($isFolderEmpty){
			@rmdir($path);
		}
		/**
		 * возвращаем значение
		*/
		return $isFolderEmpty;
	}
endif;
/**
 * Запустим для директорий images, files, media
 */
removeEmptyFolders(MODX_BASE_PATH . 'assets/images');
removeEmptyFolders(MODX_BASE_PATH . 'assets/files');
removeEmptyFolders(MODX_BASE_PATH . 'assets/media');