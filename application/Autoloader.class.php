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
 * @file Autoloader.class.php
 * @brief Autoloader du framework MVC.
 * @author Pierre Casati
 * @version 1.0
 * @date 27 Juillet 2015
 *
 * 
 *  
 * Contient la classe Autoloader.
 */

	/**
	 * @namespace application
	 * Espace de nom contenant l'application
	 */
	namespace application ;

	/**
	 * @class Autoloader
	 * @brief classe d'autoload des fichiers
	 *
	 * Cette classe charge automatiquement les bons fichiers lors de l'instanciations d'objets.
	 * Elle permet de réduire l'utilisation de require(), require_once(), include(), include_once().
	 */
	class Autoloader{
		/**
		 * @brief Charge les diverses fonction d'autoload dans le registre d'autoload.
		 */
		static public function Register(){
			spl_autoload_register(array(__CLASS__, 'Load')) ;
		}

		/**
		 * @brief Fonction de chargement d'un fichier dans l'arborescence du framework MVC.
		 */
		static private function Load($classNameIn){
			$path = str_replace('\\', '/', $classNameIn) ; /* transforme les '\' du namespace en '/' d'URL. */
			$path = __DIR__.'/../'.$path.'.class.php' ; /* ajoute la racine du projet au début. */
			if(file_exists($path)){
				require $path ;
			} else{
				throw new \Exception('Fichier inconnu ! (Chemin : '.$path.' )<br>', 1) ;
			}
		}
	}
?>