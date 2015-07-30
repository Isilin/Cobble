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
 * @file SlaveController.class.php
 * @brief Abstraction de contrôleurs esclaves.
 * @author Pierre Casati
 * @version 1.0
 * @date 27 Juillet 2015
 *
 * 
 *  
 * Contient la classe SlaveController.
 */

	/**
	 * @namespace application\controllers
	 * @brief Namespace de la partie contrôleur du pattern MVC pour l'application.
	 */
	namespace application\controllers ;

	/**
	 * @class SlaveController
	 * @brief classe abstraite SlaveController, qui hérite de iController.
	 *
	 * Cette classe définie le comportement des contrôleurs esclaves.
	 */
	abstract class SlaveController implements \application\controllers\iController{
		protected $_viewManager ; /**< Objet de type ViewManager, pour la construction de la vue. */
		protected $_modelManager ; /**< Objet de type ModelManager, pour la communication avec la base de données. */
		protected $_queryURI ; /**< Objet de type QueryURI, contenant la requête du client. */

		/**
		 * @brief Constructeur.
		 * Constructeur de la classe SlaveController.
		 * @param $queryURI - Objet de type QueryURI contenant toutes les informations sur la requête du client.
		 */
		public function __construct($queryURIIn){
			$this->_queryURI = $queryURIIn ;
			$this->_viewManager = NULL ;
			$this->_modelManager = NULL ;
		}

		/**
		 * @brief Traitement classique pour un contrôleur esclave. Peut être redéfini.
		 * Génère une vue en passant tous les paramètres connus.
		 */
		public function Process(){
			if($this->_viewManager !== NULL){
				$this->_viewManager->GetView($this->_queryURI->Parameters(), TRUE, $this->_queryURI->Path()) ;
			}
		}

		/**
		 * @brief Action 'error' du contrôleur.
		 * S'exécute lorsqu'une erreur survient, et que la ressource n'a pas été trouvée.
		 */
		public function ErrorAction(){
			$this->_viewManager = new \application\views\ViewManager('error') ; /* Chargement de la vue 'error'. */
			$this->_queryURI->AddParameter('codeError', '404') ; /* Ajout du paramètre 'error'. */
		}
	}
?>
