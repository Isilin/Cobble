<?php
    namespace Cobble\MVC;

    class MVC extends AbstractModule
    {
        public function __construct ()
        {
            require_once('Autoloader.class.php');
            $this->autoloader = new Autoloader();
        }
        public function initModule()
        {
            // Include the autoloader;
            $this->autoloader->register();

            // TODO add namespace used
            // TODO add trait
        }

        public function endModule()
        {
            $this->autoloader->unregister();
        }
    }