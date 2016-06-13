<?php

/*
    Copyright 20156 Pierre Casati

    This file is part of IsilinSAs.

    IsilinSAs is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    IsilinSAs is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with IsilinSAs.  If not, see <http://www.gnu.org/licenses/>.
*/


/**
 * @file Overloadable.trait.php
 * @brief Allows ot overload class methods.
 * @author Pierre Casati
 * @version 1.0
 * @date August 9th, 2016
 *
 * By using the trait Overloadable, a class can produce overloaded methods.
 */

    /**
     * @namespace Utils;
     */
	namespace Utils;


    /**
     * @brief Redirects the called function to right overloaded function.
     * @param $name - the base name of the function
     * @param $parameters - the parameters to pass to the function
     * @return return the returnment of the called function.
     */
    function overload(string $baseName, array $methodParameters)
    {
        $name = $baseName . generateSuffixe($methodParameters);
        if (function_exists($name)) {
            return call_user_func_array($name, $methodParameters);
        } else {
            // TODO exception ? (think about doxygen @throw)
            echo $name . '(' . implode($methodParameters, ',') . ') cannot be found !<br/>';
        }
    }

    /**
     * @brief Generate a suffixe from a list of parameters.
     * @param $parameters - the parameters to use.
     * @return return the generate suffixe as string.
     */
    function generateSuffixe(array $parameters) : string
    {
        $suffixe = '';
        foreach ($parameters as $parameter) {
            $suffixe = $suffixe . getSuffixe($parameter);
        }
        return $suffixe;
    }

    /**
     * @brief From a parameter generate a suffixe character.
     * @param $parameter - A parameter from any type to use.
     * @return return a character, unique for the parameter's type.
     */
    function getSuffixe($parameter) : string
    {
        $type = gettype($arg);
        $arg = substr(ucfirst($type), 0, 1);
        return $arg;
    }

    /**
     * @trait Overloadable
     * @brief trait, that allows you to overload a method.
     *
     * This trait allows a class to overload its methods.
     */
	trait Overloadable
	{
        /**
         * @brief Call the overloaded corresponding constructor.
         */
		public function __construct()
		{
			return $this->callMethod('__construct', func_get_args());
		}

        /**
         * @brief Call the overloaded corresponding method.
         * @param $baseName - the base name of the called method
         * @param $parameters - parameters of the called method.
         * @return return the returnment of the called method.
         */
		public function __call(string $baseName, array $parameters)
		{
			return $this->callMethod($baseName, $parameters);
		}

        /**
         * @brief Call the overloaded corresponding static method.
         * @param $baseName - the base name of the called static method
         * @param $parameters - parameters of the called static method.
         * @return return the returnment of the called static method.
         */
		public static function __callStatic(string $baseName, array $parameters)
		{
			return self::callStaticMethod($baseName, $parameters);
		}

        /**
         * @brief Redirect to the right overloaded corresponding method.
         * @param $baseName - the base name of the called method
         * @param $parameters - parameters of the called method.
         * @return return the returnment of the called method.
         */
        private function callMethod(string $baseName, array $parameters)
        {
        	$methodName = $baseName . generateSuffixe($parameters);
        	if (method_exists($this, $methodName)) {
        		return call_user_func_array(array($this, $methodName), $parameters);
        	} else {
                // TODO exception ? (think about doxygen @throw)
        		echo $methodName . '(' . implode($parameters, ',') . ') cannot be found !<br/>';
        	}
        }

        /**
         * @brief Redirect to the right overloaded corresponding static method.
         * @param $baseName - the base name of the called static method
         * @param $parameters - parameters of the called static method.
         * @return return the returnment of the called static method.
         */
        private static function callStaticMethod(string $baseName, array $parameters)
        {
        	$className = get_called_class();
        	$methodName = $baseName . generateSuffixe($parameters);
        	if (method_exists($className, $methodName)) {
        		return call_user_func_array($className . '::' . $methodName, $parameters);
        	} else {
                // TODO exception ? (think about doxygen @throw)
        		echo $className . '::' . $methodName . '(' . implode($parameters, ',') . ') cannot be found !<br/>';
        	}
        }
	}
?>