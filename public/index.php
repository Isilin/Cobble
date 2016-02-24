<?php
	use core\Log;
	use core\Contract;
	use core\Autoloader;
	use core\front\FrontController;
	
	require_once '../core/Log.class.php';
	Log::setMode(BROWSER);
	
	Log::taggedLog('BEGIN', '<br>');
	
	require_once '../core/Autoloader.class.php';
	Autoloader::register();

	Contract::initialize(true);
	

	try {
		$frontController = new FrontController();
		$frontController->process();
	} catch (\Exception $e) {
		echo $e->getMessage();
	}
	
	Log::taggedLog('END', '<br>');
?>