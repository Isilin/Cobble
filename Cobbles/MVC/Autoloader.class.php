<?php
    namespace Cobble\MVC;

    class Autoloader
    {
        public function register ()
        {
            spl_autoload_register(
                array($this, 'autoload')
            );
        }

        public function unregister ()
        {
            spl_autoload_unregister(
                array($this, 'autoload')
            );
        }

        protected function autoload($class)
        {
            assert(is_string($class));

            $prefix = str_replace('\\', '/', $classNameIn);
			$prefix = __DIR__.'/../'.$prefix;
			$suffix = '.class.php';
			
            $fileFound = $this->requireFile($prefix . $suffix);
            if(!$fileFound) {
                throw new Exception("The class cannot be autoloaded. Check your path or try to load it manually.", 1);
                return false;
            }
            return true;
        }

        protected function requireFile($path): bool
        {
            $assert(is_string($path));

            if (file_exists($path)) {
                require_once($path);
                return true;
            }
            return false;
        }
    }