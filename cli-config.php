<?php

ini_set("display_errors", "on");

define('APP_PATH', __DIR__ . '/');
require APP_PATH . "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array(APP_PATH . "modules/Admin/xml");
$isDevMode = true;

// the connection configuration
$dbParams = array(
    'host' => '127.0.0.1',
    'port' => '8889',
    'driver' => 'pdo_mysql',
    'user' => 'root',
    'password' => 'root',
    'dbname' => 'fuska',
);

$config = Setup::createXMLMetadataConfiguration($paths, $isDevMode);
$driver = new \Doctrine\ORM\Mapping\Driver\XmlDriver([APP_PATH . 'modules/Admin/xml']);
$config->setMetadataDriverImpl($driver);
$entityManager = EntityManager::create($dbParams, $config);

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);


//php vendor/bin/doctrine orm:convert-mapping --from-database xml ./modules/Admin/xml --filter="usuario"
//php vendor/bin/doctrine orm:generate-entities ./modules/Admin/xml

//php vendor/bin/doctrine orm:convert-mapping metadata_format --from-database xml ./modules/Admin/xml --filter="usuario"