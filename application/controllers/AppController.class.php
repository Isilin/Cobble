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
 * @file AppController.class.php
 * @brief FrontController du pattern MVC.
 * @author Pierre Casati
 * @version 1.0
 * @date 27 Juillet 2015
 *
 * 
 *  
 * Contient la classe AppController.
 */

	/**
	 * @namespace application\controllers
	 * @brief Namespace de la partie contrôleur du pattern MVC pour l'application.
	 */
	namespace application\controllers ;
	
	/**
	 * @class AppController
	 * @brief classe AppController, qui hérite de iController.
	 *
	 * Cette classe oriente la requête vers un sous-contrôleur nommé contrôleur esclave.
	 */
	class AppController implements \application\controllers\iController{
		private $_slave ; /**< Contrôleur esclave. */
		private $_queryURI ; /**< Objet de type QueryURI contenant la requête du client. */
		private $_modules ; /**< Tableau de plugins pour le framework. */
		private $_moduleReports ; /** Tableau de retours d'erreur des plugins pour le framework. */
		
		/**
		 * @brief Constructeur.
		 * Constructeur de la classe AppController.
		 */
		public function __construct(){
			$this->_slave = NULL ;
			try{
				$this->_queryURI = new \application\controllers\QueryURI() ;
			} catch(\Exception $e){
				echo $e->getMessage() ;
				$this->_queryURI = NULL ;
			}
			$this->_modules = array() ;
			$this->_moduleReports = array() ;
		}
		
		/**
		 * @brief Routage de la requête.
		 * Cette fonction charge les plugins du framework, puis oriente la requête vers le bon contrôleur esclave.
		 */
		public function Process(){
			if($this->_queryURI !== NULL){
				/* Construction du nom du contrôleur esclave. */
				$nameController = '' ;
				if($this->_queryURI->IsValidQuery()){
					if($this->_queryURI->IsPostMethod() && array_key_exists('ajax', $this->_queryURI->Parameters())){
						$nameController = '\\application\\controllers\\AjaxManager' ;
					} else{
						$nameController = '\\application\\controllers\\'.$this->_queryURI->PathElement(0).'Controller' ;
						if(array_key_exists('2', $this->_queryURI->Path())){
							$actionController = $this->_queryURI->PathElement(2).'Action' ;
						} else{
							$actionController = 'DefaultAction' ;
						}
					}
				} else{
					$nameController = '\\application\\controllers\\ErrorController' ;
					$this->_queryURI->AddParameter('codeError', '400') ;
					$actionController = 'DefaultAction' ;
				}

				/* Chargement des plugins du framework. */
				$config = parse_ini_file(__DIR__.'/../configs/IsilinMVC.config.ini', TRUE) ;
				if(array_key_exists('modules', $config)){
					foreach ($config['modules'] as $key => $value) {
						if(is_dir(__DIR__.'/../../libraries/'.$value)){
							$module = '\\libraries\\'.$value.'\\'.$value ;
							try{
								$this->_modules[$key] = new $module($this, $nameController) ;
								$this->_modules[$key]->Execute() ;
							} catch(\Exception $e){
								echo $e->getMessage() ;
							}
						} else{
							throw new \Exception('Erreur : /../libraries/'.$value.' n\'existe pas !<br>') ;
						}
					}
					unset($config) ;
				}

				$tmp = '' ;
				foreach($this->_moduleReports as $key => $value){
					if($value !== ''){
						$tmp = $value ;
						break ;
					}
				}
				if($tmp !== ''){
					$nameController = '\\application\\controllers\\ErrorController' ;
					$this->_queryURI->AddParameter('codeError', $tmp) ;
				}

				/* Chargement du contrôleur esclave. */
				try{
					$this->_slave = new $nameController($this->_queryURI) ;
				} catch(\Exception $e){
					$nameController = '\\application\\controllers\\ErrorController' ;
					$actionController = 'ErrorAction' ;
					try{
						$this->_slave = new $nameController($this->_queryURI) ;
					} catch(\Exception $e){
						echo $e->getMessage() ;
					}
				}

				/* Traitement de la requête par le contrôleur esclave. */
				if($this->_slave !== NULL){
					if(!array_key_exists('ajax', $this->_queryURI->Parameters())){
						if(method_exists($this->_slave, $actionController)){
							$this->_slave->$actionController() ;
						} else{
							$this->_slave->ErrorAction() ;
						}
					}
					$this->_slave->Process() ;
				} else{
					throw new \Exception('Erreur de chargement d\'un esclave !<br>') ;
				}
				/* ========== SLAVE CALLING ========== */
			} else{
				throw new \Exception('Erreur de création de la requête URI !<br>') ;
			}
		}

		/**
		 * @brief Accesseur de $_queryURI.
		 * Utile en particulier pour les plugins.
		 */
		public function QueryURI(){
			return $this->_queryURI ;
		}

		/**
		 * @brief Mutateur de _moduleReport.
		 * Utilisé uniquement par les plugins.
		 * @param $moduleIn - nom du plugin concerné.
		 * @param $codeErrorIn - code erreur à retourné au client.
		 */
		public function SetReport($moduleIn, $codeErrorIn){
			$this->_moduleReports[$moduleIn] = $codeErrorIn ;
		}
	}
?>