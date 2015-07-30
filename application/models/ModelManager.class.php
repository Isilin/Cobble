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
 * @file ModelManager.class.php
 * @brief Gestionnaire de modèles du pattern MVC.
 * @author Pierre Casati
 * @version 1.0
 * @date 27 Juillet 2015
 *
 * 
 *  
 * Contient la classe ModelManager.
 */

	/**
	 * @namespace application\controllers
	 * @brief Namespace de la partie contrôleur du pattern MVC pour l'application.
	 */
	namespace application\models ;

	/**
	 * @class ModelManager
	 * @brief classe ModelManager, qui hérite de iController.
	 *
	 * Cette classe charge le mapper demandé pour exécuter la requête, puis retourne le résultat.
	 */
	class ModelManager{
		protected $_mapper ; /**< Objet de type mapper. */
		public $_nameMapper ; /**< Nom du mapper. */

		/**
		 * @brief Constructeur.
		 * Constructeur de la classe ModelManager.
		 */
		public function __construct(){
			$this->_mapper = NULL ;
		}

		/**
		 * @brief Fonction de chargement d'un mapper.
		 * Charge le mapper demandé.
		 */
		public function LoadModel($mapperIn){
			$this->_nameMapper = $mapperIn ;
			$class = '\\application\\models\\'.$mapperIn.'Mapper' ;
			try{
				$this->_mapper = new $class() ;
			} catch(\Exception $e){
				echo $e->getMessage() ;
			}
		}

		/**
		 * @brief Exécute une requête.
		 * Envoie la requête au mapper courant et retourne le résultat.
		 */
		public function LoadInfos($queryIn, $methodIn, $paramsIn = array()){
			return $this->_mapper->$methodIn($queryIn, $paramsIn) ;
		}

		/**
		 * @brief Nettoie un résultat pour le rendre exploitable.
		 * Cette fonction est un routeur vers le bon "nettoyeur".
		 */
		public function Clean($jsonIn){
			$function = 'Clean'.$this->_nameMapper ;
			if(method_exists($this, $function)){
				return $this->$function($jsonIn) ;
			}
		}

		/**
		 * @brief Nettoie un résultat pour le rendre exploitable.
		 * Cette fonction nettoie un résultat pour avoir une télémétrie propre.
		 */
		private function CleanTelemetry($jsonIn){
			$case = '' ;
			$res = array() ;
			foreach ($jsonIn as $key => $value) {
				$case = json_decode($value) ;
				$res[$case->_name] = array('value' => $case->_value, 'type' => $case->_type) ;
			}
			return $res ;
		}

		/**
		 * @brief Nettoie un résultat pour le rendre exploitable.
		 * Cette fonction nettoie un résultat pour avoir une télémétrie avec date propre.
		 */
		private function CleanTelemetryDate($jsonIn){
			$case = '' ;
			$res = array() ;
			foreach ($jsonIn as $key => $value) {
				$case = json_decode($value) ;
				if(!array_key_exists($case->_dateReception, $res)){
					$res[$case->_dateReception] = array() ;
				}
				$res[$case->_dateReception][$case->_name] = array('value' => $case->_value, 'type' => $case->_type) ;
			}
			return $res ;
		}
	}
?>