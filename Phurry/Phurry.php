<?php

namespace Phurry;

class Phurry
{
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

            if (count($newArgs) + count($args) > $numParams) {
                throw new \InvalidArgumentException('Dont overcook your curry! Provided more arguments than can be accepted.');
            }

            if (count($newArgs) + count($args) === $numRequiredParams) {
                return call_user_func_array($fn, array_merge($args, $newArgs));
            }

            return $phurry->curry($fn, array_merge($args, $newArgs));
        };
    }


}
