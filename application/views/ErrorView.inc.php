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
?>

<?php if($codeError === '400'): ?>
	<h1>Error 400 : Mauvaise requête</h1>
	<h3>La requête HTTP n'a pas pu être comprise par le serveur en raison d'une syntaxe erronée.</h3>
	<p>Le problème peut provenir d'un navigateur web trop récent ou d'un serveur HTTP trop ancien.</p>
	<?php http_response_code(400) ; ?>
<?php elseif($codeError === '401'): ?>
	<h1>Error 401 : Non autorisé</h1>
	<h3>La requête nécessite une identification de l'utilisateur.</h3>
	<p>Concrètement, cela signifie que tout ou partie du serveur contacté est protégé par un mot de passe, qu'il faut indiquer au serveur pour pouvoir accéder à son contenu.</p>
	<?php http_response_code(401) ; ?>
<?php elseif($codeError === '403'): ?>
	<h1>Error 403 : Interdit</h1>
	<h3>Le serveur HTTP a compris la requête, mais refuse de la traiter.</h3>
	<p>Ce code est généralement utilisé lorsqu'un serveur ne souhaite pas indiquer pourquoi la requête a été rejetée, ou lorsque aucune autre réponse ne correspond (par exemple le serveur est un Intranet et seules les machines du réseau local sont autorisées à se connecter au serveur).</p>
	<?php http_response_code(403) ; ?>
<?php elseif($codeError === '404'): ?>
	<h1>Error 404 : Non trouvé</h1>
	<h3>Le serveur n'a rien trouvé qui corresponde à l'adresse (URI) demandée ( non trouvé ).</h3>
	<p>Cela signifie que l'URL que vous avez tapée ou cliquée est mauvaise ou obsolète et ne correspond à aucun document existant sur le serveur (vous pouvez essayez de supprimer progressivement les composants de l'URL en partant de la fin pour éventuellement retrouver un chemin d'accès existant).</p>
	<?php http_response_code(404) ; ?>
<?php elseif($codeError === '503'): ?>
	<h1>Error 503 : Service indisponible</h1>
	<h3>Le serveur HTTP est actuellement incapable de traiter la requête en raison d'une surcharge temporaire ou d'une opération de maintenance.</h3>
	<p>Cela sous-entend l'existence d'une condition temporaire qui sera levée après un certain délai.</p>" ;
	<?php http_response_code(503) ; ?>
<?php endif; ?>