<?php

namespace Fuska\Mvc;

/**
 * @see \Doctrine\ORM\EntityRepository
 * @method createQueryBuilder($alias) Creates a new QueryBuilder instance that is prepopulated for this entity name.
 * @method createResultSetMappingBuilder($alias) Creates a new result set mapping builder for this entity.
 * @method createNamedQuery($queryName) Creates a new Query instance based on a predefined metadata named query.
 * @method createNativeNamedQuery($queryName) Creates a native SQL query.
 * @method clear() Clears the repository, causing all managed entities to become detached.
 * @method find($id, $lockMode = LockMode::NONE, $lockVersion = null) Finds an entity by its primary key / identifier.
 * @method array findAll() Finds all entities in the repository.
 * @method findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null) Finds entities by a set of criteria.
 * @method findOneBy(array $criteria, array $orderBy = null) Finds a single entity by a set of criteria.
 * @method matching(\Doctrine\Common\Collections\Criteria $criteria) Select all elements from a selectable that match the expression and return a new collection containing these elements.
 *
 * @see \Doctrine\ORM\EntityManager
 * @method beginTransaction()
 * @method commit()
 * @method rollback()
 * @method getClassMetadata($className) Returns the ORM metadata descriptor for a class.
 * @method createQuery($dql = '')
 * @method flush($entity = null) Flushes all changes to objects that have been queued up to now to the database.
 * @method persist($entity) Tells the EntityManager to make an instance managed and persistent.
 * @method remove($entity) Removes an entity instance.
 * @method refresh($entity) Refreshes the persistent state of an entity from the database, overriding any local changes that have not yet been persisted.
 * @method detach($entity) Detaches an entity from the EntityManager, causing a managed entity to become detached.
 * @method merge($entity) Merges the state of a detached entity into the persistence context of this EntityManager and returns the managed copy of the entity.
 * @method copy($entity, $deep = false)
 * @method lock($entity, $lockMode, $lockVersion = null)
 * @method getRepository($entityName) Gets the repository for an entity class.
 * @method contains($entity) Determines whether an entity instance is managed in this EntityManager.
 */
abstract class Service {

    /**
     * @var string Model Name
     */
    private $modelName;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private static $manager;

    public function __construct($modelName) {
        $this->setModelName($modelName);
        if (!self::$manager) {
            $dbParams = array(
                'host' => '127.0.0.1',
                'port' => '8889',
                'driver' => 'pdo_mysql',
                'user' => 'root',
                'password' => 'root',
                'dbname' => 'fuska',
            );
            $paths = array(APP_PATH . "modules/Admin/model");
            $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths, true);
            $entityManager = \Doctrine\ORM\EntityManager::create($dbParams, $config);
            $this->setManager($entityManager);
        }
    }

    public function getModelName() {
        return $this->modelName;
    }

    public function setModelName($modelName) {
        $this->modelName = $modelName;
        return $this;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public static function getManager() {
        if (!self::$manager) {
            $paths = array(APP_PATH . "modules/Admin/model");
            $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths, true);
            $entityManager = \Doctrine\ORM\EntityManager::create(\Fuska\App::$config['system']['db'], $config);
            self::setManager($entityManager);
        }
        return self::$manager;
    }

    /**
     * @param \Doctrine\ORM\EntityManager $manager
     */
    public static function setManager(\Doctrine\ORM\EntityManager $manager) {
        self::$manager = $manager;
    }

    public function save($model) {
        if ($model->getId()) {
            $this->merge($model);
        } else {
            $this->persist($model);
        }
        $this->flush();
        return $model;
    }

    public function delete($model) {
        if (!$model->getId()) {
            return;
        }
        $entity = $this->getReference(get_class($model), $model->getId());
        $this->remove($entity);
        $this->flush($entity);
        return $model;
    }

    public function __call($name, $arguments) {
        $modelName = $this->getModelName();
        $repository = self::$manager->getRepository($modelName);

        switch (true) {
            case method_exists($repository, $name):
                return call_user_func_array([$repository, $name], $arguments);
            case method_exists(self::$manager, $name):
                return call_user_func_array([self::$manager, $name], $arguments);
            case $model = new $modelName:
            case method_exists($model, $name):
                return call_user_func_array([$model, $name], $arguments);
        }
    }

}
