<?php

/**
 * Created by Jiří Zapletal.
 * Date: 01/12/2016
 * Time: 13:14
 */

namespace NettePropel\DI;

use Nette;

class NettePropelExtension extends \Nette\DI\CompilerExtension
{
    public function afterCompile(Nette\PhpGenerator\ClassType $class)
    {
        $initialize = $class->methods['initialize'];
        $initialize->addBody('\NettePropel\Setup::setup($this);');
    }
}