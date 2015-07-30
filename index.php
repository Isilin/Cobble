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
 * @file index.php
 * @brief Fichier main pour l'initialisation de l'application.
 * @author Pierre Casati
 * @version 1.0
 * @date 27 Juillet 2015
 *
 * 
 *  
 * Charge l'autoloader du framework MVC.
 * Puis démarre l'application.
 */

	# ===== Point d'entrée unique pour application. =====
	# ===== Crée un FrontController et exécute son traitement. =====
	require_once './application/Autoloader.class.php' ;
	\application\Autoloader::Register() ;
	
	try{
		$app = new \application\controllers\AppController() ;
		$app->Process() ;
	} catch(\Exception $e){
		echo $e->getMessage() ;
	}
?>