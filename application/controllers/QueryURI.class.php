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
 * @file QueryURI.class.php
 * @brief Classe d'interfaçage de la requête du client.
 * @author Pierre Casati
 * @version 1.0
 * @date 27 Juillet 2015
 *
 * 
 *  
 * Contient la classe QueryURI.
 */

	/**
	 * @namespace application\controllers
	 * @brief Namespace de la partie contrôleur du pattern MVC pour l'application.
	 */
	namespace application\controllers ;

	/**
	 * @class QueryURI
	 * @brief classe QueryURI.
	 *
	 * Cette classe est une interface pour faciliter l'utilisation de la requête du client, pendant les divers processus.
	 */
	class QueryURI{
		private $_verb ; /**< Verbe de la requête HTTP(POST | GET | DELETE | SET | ...). */
		private $_valid ; /**< Indicateur de validité de la requête. */
		private $_path ; /**< Tableau contenant le chemin de la ressource demandée. */
		private $_parameters ; /* Un tableau de paramètres concernant la ressource demandée. */

		/**
		 * @brief Constructeur.
		 * Constructeur de la classe QueryURI.
		 */
		public function __construct(){
			$this->_verb = $_SERVER['REQUEST_METHOD'] ;
			$this->_valid = strpos($_SERVER['REQUEST_URI'], '//') === FALSE ;
			$this->_path = explode('/', strtolower($_SERVER['REQUEST_URI'])) ; /* Utilise les lettres minuscules tout le temps pour prévenir les erreurs. */
			array_shift($this->_path) ; /* Le '/' de la racine crée une case vide dans le tableau. */
			array_shift($this->_path) ; /* Suppression du répertoire du projet. */

			$config = parse_ini_file(__DIR__.'/../configs/IsilinMVC.config.ini', true) ;

			if($this->_path[0] === ''){
				/* Transforme la requête '/' pour accèder à la ressource dites principale. */
				$this->_path[0] = $config['QueryURI']['MainResource'] ;
			}

			unset($config) ;

			if(end($this->_path) === ''){
				/* '/home' est unr URI aussi valide que '/home/'. */
				array_pop($this->_path) ;
			}

			/* On vérifie quelle est la méthode pour la requête HTTP, et on stocke les paramètres dans un tableau. */
			$this->_parameters = array() ;
			if($this->_verb === 'GET'){
				foreach($_GET as $key => $value){
					$this->_parameters[$key] = $this->SecureData($value) ;
				}
			} else if($this->_verb === 'POST'){
				foreach($_POST as $key => $value){
					$this->_parameters[$key] = $this->SecureData($value) ;
				}
			} else{
				$this->_verb = 'GET' ;
			}
 			/* Récupération de la langue du client. */
			$this->_parameters['lang'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) ;

			/* Vérifie qu'il n'y a pas de caractères spéciaux dans la requête. */
			if(preg_match("`[^A-Za-z0-9/_-]`", $_SERVER['REQUEST_URI']) || ($this->_path[0] === 'application')){
				$this->_valid = FALSE ;
			}
		}

		/**
		 * @brief Accesseur de l'attribut $_valid ;
		 * Retour la validité de la requête.
		 */
		public function IsValidQuery(){
			return $this->_valid ;
		}

		/**
		 * @brief Accesseur de l'attribut $_verb.
		 * Indique si la requête HTTP a été faite par requête GET.
		 */
		public function IsGetMethod(){
			return $this->_verb === 'GET' ;
		}

		/**
		 * @brief Accesseur de l'attribut $_verb.
		 * Indique si la requête HTTP a été faite par requête POST.
		 */
		public function IsPostMethod(){
			return $this->_verb === 'POST' ;
		}

		/**
		 * @brief Accesseur de l'attribut $_path.
		 * Retourne le chemin complet de la ressource demandée.
		 */
		public function Path(){
			return $this->_path ;
		}

		/**
		 * @brief Accesseur de l'attribut $_path.
		 * Retourne un élément du chemin de la ressource demandée.
		 */
		public function PathElement($keyIn){
			return $this->_path[$keyIn] ;
		}

		/**
		 * @brief Accesseur de l'attribut $_parameters.
		 * Retourne les paramètres de la requête.
		 */
		public function Parameters(){
			return $this->_parameters ;
		}

		/**
		 * @brief Accesseur de l'attribut $_parameters.
		 * Retourne un des paramètres de la requête s'il existe. Retourne FALSE sinon.
		 */
		public function Parameter($keyIn){
			if(array_key_exists($keyIn, $this->_parameters)){
				return $this->_parameters[$keyIn] ;
			} else{
				return FALSE ;
			}
		}

		/**
		 * @brief Mutateur de l'attribut $_parameters.
		 * Ajoute ou remplace un paramètre aux tableau de paramètres de la requête.
		 */
		public function AddParameter($keyIn, $valueIn){
			$this->_parameters[$keyIn] = $valueIn ;
		}

		/**
		 * @brief Fonction interne.
		 * Applique des filtres de sécurité sur les données entrantes.
		 */
		private function SecureData($dataIn){
			$res = '' ;
			if(ctype_digit($dataIn)){
				$res = (int)$dataIn ;
			} else{
				$res = htmlentities($dataIn) ;
				$res = addcslashes($res, '()%[]') ; /* To prevent SQL injections. Can be decoded with stripcslashes() function. */
			}
			return $res ;
		}
	}
?>