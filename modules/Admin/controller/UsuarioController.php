<?php

namespace Admin\Controller;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class UsuarioController extends \Fuska\Mvc\Controller {

    public function generateSchema() {
        $dir = APP_PATH . 'modules/Admin/';
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
                $metadata[] = $cmf->getMetadataFor($class);
            }
        }

        $generator = new \Doctrine\ORM\Tools\EntityGenerator();
        $generator->setAnnotationPrefix('');   // edit: quick fix for No Metadata Classes to process
        $generator->setUpdateEntityIfExists(true); // only update if class already exists
        //$generator->setRegenerateEntityIfExists(true);	// this will overwrite the existing classes
        $generator->setGenerateStubMethods(true);
        $generator->setGenerateAnnotations(true);
        $generator->generate($metadata, $dir . '/model');

        print 'Done!';
        die;
    }

    public function relatorio() {
        $service = new \Admin\Service\UsuarioService;
        $collection = new \Fuska\System\Collection($service->findBy([], ['login' => 'ASC']));
        $this->view->list = $collection->normalizeDataToGrid()->toArray();
        return $this->view;
    }

    public function cadastro() {
        if ($this->request->get->id) {
            $service = new \Admin\Service\UsuarioService;
            $this->view->usuario = $service->find($this->request->get->id)->normalizeDataToView();
        }
        return $this->view;
    }

    public function salvar() {
        $service = new \Admin\Service\UsuarioService;
        $usuario = new \Admin\Model\Usuario;

        if ($this->request->isDelete()) {
            $usuario->id = $this->request->get->id;
            return \Fuska\View\Json::createWithArrayOrObject($service->delete($usuario));
        }

        $post = $this->request->post;
        $usuario->setLogin($post->login)
                ->setSenha($post->senha)
                ->setUltimoLogin(new \Fuska\System\DateTime())
                ->setId($post->id);

        return \Fuska\View\Json::createWithArrayOrObject($service->save($usuario));
    }

}
