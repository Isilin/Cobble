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
 * @file AbstractModel.class.php
 * @brief Interface de modèles du pattern MVC.
 * @author Pierre Casati
 * @version 1.0
 * @date 27 Juillet 2015
 *
 * 
 *  
 * Contient la classe abstraite AbstractModel.
 */

	/**
	 * @namespace application\models
	 * @brief Namespace de la partie modèle du pattern MVC pour l'application.
	 */
	namespace application\models ;

	/**
	 * @class AbstractModel
	 * @brief classe AbstractModel.
	 *
	 * Cette classe instaure un comportement type pour les modèles.
	 */
	abstract class AbstractModel{
		/**
		 * @brief Constructeur.
		 * Constructeur de la classe AbstractModel.
		 */
		public function __construct(){

		}

		/**
		 * @brief Parsage en JSON.
		 * Se retourne lui-même au format JSON.
		 */
		public function Parse(){
			return json_encode($this, TRUE) ;
		}
	}
?>