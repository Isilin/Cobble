<?php
/*
	Copyright 2015 Pierre Casati

    This file is part of IsilinMVC.

    IsilinMVC is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    IsilinMVC is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with IsilinMVC.  If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * @file ViewManager.class.php
 * @brief Gestionnaire de vues du pattern MVC.
 * @author Pierre Casati
 * @version 1.0
 * @date 27 Juillet 2015
 *
 * 
 *  
 * Contient la classe ViewManager.
 */

	/**
	 * @namespace application\views
	 * @brief Namespace de la partie vue du pattern MVC pour l'application.
	 */
	namespace application\views ;
	
	/**
	 * @class ViewManager
	 * @brief classe ViewManager, qui hérite de iController.
	 *
	 * Cette classe prépare la vue demandée et la retourne au contrôleur.
	 */
	class ViewManager{
		private $_viewTitle ; /**< Titre de la vue. */
		private $_viewFile ; /**< Chemin du fichier contenant la vue. */

		/**
		 * @brief Constructeur.
		 * Constructeur de la classe ViewManager.
		 */
		public function __construct($query){
			$this->_viewTitle = $query ;
			$this->_viewFile = __DIR__.'/../views/'.$this->_viewTitle.'View.inc.php' ;
		}
		
		/**
		 * @brief Fonction de préparation de la vue.
		 * Cette fonction intègre la vue dans le pattern de l'application et transmet les paramètres nécessairer à la génération de la vue.
		 */
		public function GetView($infos = array(), $classicPattern = TRUE, $titleInfos = array()){
			$config = parse_ini_file(__DIR__.'/../configs/content.config.ini', TRUE) ;

			$configSat = array() ;

			/* Préparation du titre de la vue. */
			if($this->_viewTitle !== 'error'){
				if(count($titleInfos) > 0){
					$infos['title'] = $config[$infos['lang']][$titleInfos[0].'Title'] ;
					array_shift($titleInfos) ;
					foreach ($titleInfos as $key => $value) {
						if(intval($key) % 2 === 1){
							$infos['title'] .= ' > '.$config[$infos['lang']][$value.'Title'] ;
						} else{
							$infos['title'] .= ' : '.$value ;
						}
					}
				} else{
					$infos['title'] = '' ;
				}
			} else{
				$infos['title'] = $config[$infos['lang']][$this->_viewTitle.'Title'] ;
			}
			$dir = "www/configs/" ;
		    if (is_dir($dir)) { /* Si c'est bien un dossier. */
		        $dh = opendir($dir) ; /* résultat de l'ouverture. */
		        if($dh) { /* Si on a bien ouvert le dossier. */
		            $file = readdir($dh) ; /* On lit le premier élément. */
		            $i = 0 ;
		            while ($file !== false) { /* Tant qu'on a des éléments. */
		                if( $file != '.' && $file != '..' && substr($file, -5) === '.json') {

		                	$jsondur = file_get_contents($dir.$file);
							$configSat[substr($file, 0, -5)] = json_decode($jsondur, TRUE) ;
						}
	                	$file = readdir($dh) ;
					}
				}
			}

			/* Préparation de la vue. */
			$content = $this->CreateContent($this->_viewFile, $infos, $config, $configSat) ;

			$infos['body'] = $content ;

			$ini = parse_ini_file(__DIR__.'/../configs/IsilinMVC.config.ini', TRUE) ;
			if($classicPattern){
				$patternPath = 'Pattern' ;
			} else{
				$patternPath = 'PatternBis' ;
			}
			if(array_key_exists('View', $ini) && array_key_exists($patternPath, $ini['View'])){

				$pattern = __DIR__.'/../layouts/'.$ini['View'][$patternPath] ;
				$content = $this->CreateContent($pattern, $infos, $config, $configSat) ; /* Intégration de la vue dans le pattern. */
			} else{
				$content = $infos['body'] ;
			}
			unset($ini) ;
			echo $content ;
		}

		/**
		 * @brief Fonction privée de préparation de contenu HTML.
		 * Cette fonction prépare du contenu HTML en transmettant les paramètres nécessaires, sans renvoyer directement au client.
		 */
		private function CreateContent($fileURI, $datas, $config, $configSat){
			if(file_exists($fileURI)){
				extract($datas) ; /* Transforme le tableau associatif en variables nommées par les clés. */
				ob_start() ; /* Début de l'écriture dans le tampon http. */
				require_once $fileURI ;
				return ob_get_clean() ; /* Retourne le tampon et le vide. */
			} else{
				echo 'Erreur : '.$fileURI. ' non trouvé !<br>' ;
				if(isset($datas['body'])){
					return $datas['body'] ;
				}
			}
		}
	}
?>