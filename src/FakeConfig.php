<?php
/**
 * Created by Jiří Zapletal.
 * Date: 01/12/2016
 * Time: 20:36
 */

$appDir = realpath(__DIR__ . '/../../../../app');
$connection = NettePropel\Setup::getConnection($appDir);

return $connection;