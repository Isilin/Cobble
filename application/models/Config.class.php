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
 * @file Config.class.php
 * @brief Classe de contenu pour les paramètres du connexion à une base de données.
 * @author Pierre Casati
 * @version 1.0
 * @date 27 Juillet 2015
 *
 * 
 *  
 * Contient la classe Config.
 */

	/**
	 * @namespace application\models
	 * @brief Namespace de la partie modèle du pattern MVC pour l'application.
	 */
	namespace application\models ;

	/**
	 * @class Config
	 * @brief classe Config.
	 *
	 * Cette classe stocke des données de connexion depuis un fichier INI.
	 */
	class Config{
		private $_parameters ; /**< Tableau de paramètres. */

		/**
		 * @brief Constructeur.
		 * Constructeur de la classe AbstractMapper.
		 * @param $iniPathIn - Chemin du fichier INI de configuration.
		 */
		public function __construct($iniPathIn){
			$this->_parameters = parse_ini_file($iniPathIn, true) ;
			foreach ($this->_parameters as $key => $value) {
				if(!array_key_exists('host', $value)){
					$this->_parameters[$key]['host'] = '' ;
				}
				if(!array_key_exists('dbname', $value)){
					$this->_parameters[$key]['dbname'] = '' ;
				}
				if(!array_key_exists('user', $value)){
					$this->_parameters[$key]['user'] = '' ;
				}
				if(!array_key_exists('password', $value)){
					$this->_parameters[$key]['password'] = '' ;
				}
				if(!array_key_exists('port', $value)){
					$this->_parameters[$key]['port'] = '80' ;
				}
			}
		}

		/**
		 * @brief Accesseur pour l'attribut $_parameters.
		 * Retourne l'attribut $_parameters.
		 */
		public function GetParameters(){
			return $this->_parameters ;
		}

		/**
		 * @brief Accesseur pour l'attribut $_parameters.
		 * Retourne une case de l'attribut $_parameters.
		 * @param $keyIn - Indice de la case.
		 */
		public function GetParameter($keyIn){
			return $this->_parameters[$keyIn] ;
		}
	}
?>