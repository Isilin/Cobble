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
 * @file OwnPDO.class.php
 * @brief Adaptation de PDO pour le framework MVC.
 * @author Pierre Casati
 * @version 1.0
 * @date 27 Juillet 2015
 *
 * 
 *  
 * Contient la classe OwnPDO.
 */

	/**
	 * @namespace application\models
	 * @brief Namespace de la partie modèle du pattern MVC pour l'application.
	 */
	namespace application\models ;


	/**
	 * @class OwnPDO
	 * @brief classe OwnPDO.
	 *
	 * Cette classe adapte la classe PDO de connexion pour le framework.
	 */
	class OwnPDO extends \PDO{
		private $_config ; /**< Objet de type Config contenant la configuration de la conenxion. */

		/**
		 * @brief Constructeur.
		 * Constructeur de la classe OwnPDO.
		 * @param $location - Situation de la connexion (selon le fichier de configuration). Par défaut : LOCAL | SERVER.
		 */
		public function __construct($location){
			try{
				$parameters = new \application\models\Config(__DIR__.'/../configs/connection.config.ini') ;
				$this->_config = $parameters->GetParameter($location) ;
			} catch(Exception $e){
				echo $e->getMessage() ;
			}

			try{
				parent::__construct('mysql:host='.$this->_config['host'].';dbname='.$this->_config['dbname'], $this->_config['user'], $this->_config['password']) ;
				parent::setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING) ;
			} catch(\PDOException $e){
				echo $e->getMessage() ;
			}
		}
	}
?>