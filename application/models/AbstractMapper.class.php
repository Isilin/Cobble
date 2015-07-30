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
 * @file AbstractMapper.class.php
 * @brief Interface de mappers du pattern MVC.
 * @author Pierre Casati
 * @version 1.0
 * @date 27 Juillet 2015
 *
 * 
 *  
 * Contient la classe abstraite AbstractMapper.
 */

	/**
	 * @namespace application\models
	 * @brief Namespace de la partie modèle du pattern MVC pour l'application.
	 */
	namespace application\models ;

	/**
	 * @class AbstractMapper
	 * @brief classe AbstractMapper.
	 *
	 * Cette classe instaure un comportement type pour les mappers.
	 */
	abstract class AbstractMapper{
		private $_connection ; /**< Objet de type PDO pour la connexion à la base de données. */

		/**
		 * @brief Constructeur.
		 * Constructeur de la classe AbstractMapper.
		 */
		public function __construct(){
			try{
				$this->_connection = new \application\models\OwnPDO('SERVER') ; /* Crée une connexoin à la base de données LOCAL ou SERVER. */
			} catch(Exception $e){
				die('Erreur : '.$e->getMessage()) ;
				$this->_connection = NULL ;
			}
			$this->_values = array() ;
		}

		/**
		 * @brief Fonction d'exécution d'une requête SQL.
		 * Prépare la requête, ajoute les paramètres, l'exécue et retourne le résultat sous forme de tableau.
		 */
		protected function Execute($query, $parameters=array()){
			$localParameters = $parameters ;
			if($this->_connection !== NULL){
				$result = $this->_connection->prepare($query) ;
				foreach($localParameters as $key => $value){
					if(is_int($value)){
						$result->bindValue(':'.$key, (int)$value, \PDO::PARAM_INT) ;
					} else{
						$result->bindValue(':'.$key, $value, \PDO::PARAM_STR) ;
					}
				}
				$result->execute() ;
				if(substr($query, 0, 6) === 'SELECT'){
					$data = $result->fetchAll() ;
				} else{
					$data = true ;
				}
				$result->closeCursor() ;
				return $data ;
			}else{
				echo 'Database down or connection not permitted !<br>' ;
			}
		}

		/**
		 * @brief Requête de sélection.
		 * Oblige les classes qui héritent à définir cette fonction.
		 */
		abstract public function Select($requestIn, $parameters=array()) ;
		/**
		 * @brief Requête d'insertion.
		 * Oblige les classes qui héritent à définir cette fonction.
		 */
		abstract public function Insert($requestIn, $parameters=array()) ;
		/**
		 * @brief Requête de suppression.
		 * Oblige les classes qui héritent à définir cette fonction.
		 */
		abstract public function Delete($requestIn, $parameters=array()) ;
		/**
		 * @brief Requête de modification.
		 * Oblige les classes qui héritent à définir cette fonction.
		 */
		abstract public function Update($requestIn, $parameters=array()) ;
	}
?>