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
 * @file AjaxManager.class.php
 * @brief Gestionnaire de requête AJAX.
 * @author Pierre Casati
 * @version 1.0
 * @date 27 Juillet 2015
 *
 * 
 *  
 * Contient la classe AjaxManager.
 * Lorsqu'une requête AJAX est effectuée, elle transite par l'AjaxManager qui crée la bonne route à la manière d'un contrôleur.
 * Cependant, aucune vue n'est retournée au client, uniquement des informations au format JSON.
 */

	/**
	 * @namespace application\controllers
	 * @brief Namespace de la partie contrôleur du pattern MVC pour l'application.
	 */
	namespace application\controllers ;

	/* Définition du format de retour des informations au client. */
	header("Access-Control-Allow-Origin: *") ;
	header("Content-Type: application/json; charset=UTF-8") ;

	/**
	 * @class AjaxManager
	 * @brief classe AjaxManager, qui hérite de AbstractController.
	 *
	 * Cette classe crée des routes vers toutes les ressources, mais les retourne 'bruts'.
	 */
	class AjaxManager extends \application\controllers\SlaveController{
		/**
		 * @brief Constructeur.
		 * Constructeur de la classe AjaxManager.
		 * @param $queryURI - Objet de type QueryURI contenant toutes les informations sur la requête du client.
		 */
		public function __construct($queryURIIn){
			parent::__construct($queryURIIn) ;
			try{
				$this->_modelManager = new \application\models\ModelManager() ;
			} catch(\Exception $e){
				echo $e->getMessage() ;
			}
		}

		/**
		 * @brief Routage de la requête.
		 * Cette fonction traite la requête, interroge la Base de Données et retourne les données aux formats JSON.
		 */
		public function Process(){
			$config = parse_ini_file(__DIR__.'/../configs/IsilinMVC.config.ini', TRUE) ;

			/* Extraction des paramètres de la requête AJAX. */
			$params = $this->_queryURI->Parameters() ;
			$type = $params['type'] ;
			$this->_modelManager->LoadModel($type) ;
			$action = $params['ajax'] ;
			$method = $params['method'] ;
			/* suppression des cases inutiles pour la suite. */
			array_shift($params) ; //  type
			array_shift($params) ; //  ajax
			array_shift($params) ; //  method
			/* Interrogation de la Base de Données. */
			$res = $this->_modelManager->LoadInfos($action, $method, $params) ;
			$res = $this->_modelManager->Clean($res) ;
			echo json_encode($res, TRUE) ; /* Retourne le résultat au format JSON. */
		}
	}
?>