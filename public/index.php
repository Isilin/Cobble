<?php
	use core\Log;
	use core\Contract;
	use core\Autoloader;
	use core\router\Router;

// TODO retirer code html et mettre en place la préparation de réponse (HTML ou JSON).
	echo '
	<!DOCTYPE html>
	<html>
		<head>
			<style>
				.log_info {
					color: #00ff00;
				}
				.log_exception {
					color: #ff0000;
				}
				.log_tagged {
					color: #0000ff;
				}
			</style>
			<title></title>
		</head>
		<body lang="fr">';
	
	require_once '../core/Log.class.php';
	Log::setMode(BROWSER);
	
	Log::taggedLog('BEGIN', '<br>');
	
	require_once '../core/Autoloader.class.php';
	Autoloader::register();

	Contract::initialize(true);

	try {
		$router = new Router();
		$router->parseRequest();
		$router->processRequest();
	} catch (\Exception $e) {
		echo $e->getMessage();
	}
	
	Log::taggedLog('END', '<br>');

	echo '
		</body>
	</html>';
?>