# Phurry - Phunctional Programming Tools for PHP

This library is just an experiment in functional programming concepts for PHP such as currying.

Right now it pretty much only does partial [[application/currying.]]

```php
$phurry = new Phurry\Phurry;
$add = $phurry->curry(function ($a, $b, $c) {
    return $a + $b + $c;
});

$add4 = $add(4);
$add2 = $add(2);
echo $add(6); // 12
```
