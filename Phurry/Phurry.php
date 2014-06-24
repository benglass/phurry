<?php

namespace Phurry;

class Phurry
{
    protected static $placeholder;

    public static function placeholder()
    {
        if (! static::$placeholder) {
            static::$placeholder = new \StdClass();
        }

        return static::$placeholder;
    }

    public function fnArity(callable $fn) {
        $refl = new \ReflectionFunction($fn);
        return $refl->getNumberOfParameters();
    }

    public function fnArityRequired(callable $fn) {
        $refl = new \ReflectionFunction($fn);
        return $refl->getNumberOfRequiredParameters();
    }

    public function curry(callable $fn, $args = array()) {
        $numParams = $this->fnArity($fn);
        if ($numParams === 0) {
            throw new \InvalidArgumentException('Looks like you forgot some ingredients! Cant curry a function with no arguments.');
        }
        $phurry = $this;
        return function() use ($fn, $args, $phurry) {
            $numParams = $phurry->fnArity($fn);
            $numRequiredParams = $phurry->fnArityRequired($fn);
            $newArgs = func_get_args();
            $providedArgs = array_merge($args, $newArgs);
            $numProvidedArgs = count($providedArgs);
            $placeholder = call_user_func(array($phurry, 'placeholder'));
            $placeholderPositions = array();
            foreach ($providedArgs as $position => $value) {
                if ($value === $placeholder) {
                    $placeholderPositions[] = $position;
                }
            }
            $numPlaceholders = count($placeholderPositions);
            $numFinalArgs = $numProvidedArgs - $numPlaceholders;

            $finalArgs = array();
            foreach ($args as $position => $value) {
                // If its not a placeholder, copy it to the final args
                if ($value !== $placeholder) {
                    $finalArgs[$position] = $value;
                    continue;
                }

                // If its a placeholder
            }

            if ($numProvidedArgs > $numParams) {
                throw new \InvalidArgumentException('Dont overcook your curry! Provided more arguments than can be accepted.');
            }

            if ($numFinalArgs === $numRequiredParams) {
                return call_user_func_array($fn, array_merge($args, $newArgs));
            }

            return $phurry->curry($fn, array_merge($args, $newArgs));
        };
    }


}
