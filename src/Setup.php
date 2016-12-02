<?php
/**
 * Created by Jiří Zapletal.
 * Date: 01/12/2016
 * Time: 16:38
 */

namespace NettePropel;


use Nette\DI\Container;
use Nette\Neon\Neon;
use Propel\Runtime\Propel;
use Propel\Runtime\Connection\ConnectionManagerSingle;

class Setup
{
    private static $database;
    private static $dataSource;

    public static function parseConfig($appDir)
    {

        $file = $appDir . '/config/propel.local.neon';

        if (!file_exists($file)) {
            throw new \Exception('Missing propel configuration file');
        }

        $config = Neon::decode(file_get_contents($file));

        self::$dataSource = array_keys($config)[0];
        self::$database = $config[self::$dataSource];
    }

    public static function getConfig()
    {
        $config = self::$database;

        return [
            'adapter' => $config['adapter'],
            'dsn' => "{$config['adapter']}:host={$config['host']};dbname={$config['dbname']}",
            'user' => $config['user'],
            'password' => $config['password']
        ];
    }

    public static function getConnection($appDir)
    {
        self::parseConfig($appDir);

        $connection = [
            'propel' => [
                'database' => [
                    'connections' => [
                        self::$dataSource => self::getConfig()
                    ]
                ],
                'runtime' => [
                    'defaultConnection' => self::$dataSource,
                    'connections' => self::$dataSource
                ],
                'generator' => [
                    'defaultConnection' => self::$dataSource,
                    'connections' => self::$dataSource
                ]
            ]
        ];

        return $connection;
    }

    public static function setup(Container $container)
    {
        $appDir = $container->parameters['appDir'];

        self::parseConfig($appDir);

        $serviceContainer = Propel::getServiceContainer();
        $serviceContainer->setAdapterClass(self::$database['dbname'], self::$database['adapter']);

        $manager = new ConnectionManagerSingle();
        $manager->setConfiguration(self::getConfig());

        $serviceContainer->setConnectionManager(self::$database['dbname'], $manager);
    }
}