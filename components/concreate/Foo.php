<?php
namespace app\components\concreate;


use app\components\interfaces\IFoo;

class Foo implements IFoo {

    public function show()
    {
        var_dump('Foo3 method');
    }
}