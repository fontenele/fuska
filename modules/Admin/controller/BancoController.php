<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

namespace Admin\Controller;

class BancoController extends \Fuska\Mvc\Controller {

    public function gerarClasses() {
        $dir = APP_PATH . 'public/tmp/';
        $classLoader = new \Doctrine\Common\ClassLoader('Doctrine'); // with PEAR
        $classLoader->register();
        $classLoader = new \Doctrine\Common\ClassLoader('Entities', $dir);
        $classLoader->register();
        $classLoader = new \Doctrine\Common\ClassLoader('Proxies', $dir);
        $classLoader->register();

        $config = new \Doctrine\ORM\Configuration();
        $config->setMetadataDriverImpl($config->newDefaultAnnotationDriver($dir . '/model'));
        $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
        $config->setProxyDir($dir . '/model');
        $config->setProxyNamespace('Proxies');

        // the connection configuration
        $connectionParams = \Fuska\App::$config['system']['db'];
        $em = \Doctrine\ORM\EntityManager::create($connectionParams, $config);
        // custom datatypes (not mapped for reverse engineering)
        $em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('set', 'string');
        $em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        // fetch metadata
        $driver = new \Doctrine\ORM\Mapping\Driver\DatabaseDriver(
                $em->getConnection()->getSchemaManager()
        );

        $em->getConfiguration()->setMetadataDriverImpl($driver);
        $cmf = new \Doctrine\ORM\Tools\DisconnectedClassMetadataFactory();
        $cmf->setEntityManager($em); // we must set the EntityManager

        $classes = $driver->getAllClassNames();

        $metadata = array();
        foreach ($classes as $class) {
            //any unsupported table/schema could be handled here to exclude some classes
            if (true) {
                $mtdt = $cmf->getMetadataFor($class);
                $mtdt->name = substr($mtdt->name, 3);
                $mtdt->rootEntityName = substr($mtdt->name, 3);
                foreach ($mtdt->associationMappings as &$_tmp) {
                    $_tmp['targetEntity'] = substr($_tmp['targetEntity'], 3);
                }
                //x($mtdt);
                $metadata[] = $cmf->getMetadataFor($class);
                //xd($class, $cmf->getMetadataFor($class));
            }
        }

        $generator = new \Doctrine\ORM\Tools\EntityGenerator();
        $generator->setClassToExtend('\Fuska\Mvc\Model');
        $generator->setFieldVisibility('protected');

        $generator->setAnnotationPrefix('tab_');   // edit: quick fix for No Metadata Classes to process
        $generator->setUpdateEntityIfExists(true); // only update if class already exists
        $generator->setRegenerateEntityIfExists(true); // this will overwrite the existing classes
        $generator->setGenerateStubMethods(true);
        $generator->setGenerateAnnotations(true);
        $generator->generate($metadata, $dir . '/model');

        print 'Done!';
        die;
    }

}
