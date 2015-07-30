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
 * @file errorController.class.php
 * @brief Controller pour le module 'error'.
 * @author Pierre Casati
 * @version 1.0
 * @date 27 Juillet 2015
 *
 * 
 *  
 * Contient la classe ErrorController.
 */

	/**
	 * @namespace application\controllers
	 * @brief Namespace de la partie contrôleur du pattern MVC pour l'application.
	 */
	namespace application\controllers ;

	/**
	 * @class ErrorController
	 * @brief classe ErrorController, qui hérite de SlaveController.
	 *
	 * Cette classe crée des routes vers les ressources du module 'error'.
	 */
	class ErrorController extends \application\controllers\SlaveController{
		public function __construct($queryURI){
			parent::__construct($queryURI) ;
		}

		/**
		 * @brief Action par défaut du contrôleur.
		 * S'exécute dans le cas où le module est chargé sans qu'une action ne soit demandée.
		 */
		public function DefaultAction(){
			$this->_viewManager = new \application\views\ViewManager('error') ; /* Chargement de la vue 'error'. */
		}
		
		/**
		 * @brief Traitement de la requête.
		 * Cette fonction la vue correspondant à la bonne erreur.
		 */
		public function Process(){
			if($this->_viewManager !== NULL){
				$this->_viewManager->GetView($this->_queryURI->Parameters(), TRUE, array('error')) ;
			}
		}
	}
?>
