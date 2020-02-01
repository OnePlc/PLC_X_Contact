<?php
/**
 * Module.php - Module Class
 *
 * Module Class File for Skeleton Module
 *
 * @category Config
 * @package Skeleton
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Skeleton;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Mvc\MvcEvent;
use Laminas\ModuleManager\ModuleManager;
use Laminas\Session\Config\StandardConfig;
use Laminas\Session\SessionManager;
use Laminas\Session\Container;
use Application\Controller\CoreEntityController;
use OnePlace\Skeleton\Controller\PluginController;

class Module {
    /**
     * Module Version
     *
     * @since 1.0.7
     */
    const VERSION = '1.0.7';

    /**
     * Load module config file
     *
     * @since 1.0.0
     * @return array
     */
    public function getConfig() : array {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * Load Models
     */
    public function getServiceConfig() : array {
        return [
            'factories' => [
                # Skeleton Module - Base Model
                Model\SkeletonTable::class => function($container) {
                    $tableGateway = $container->get(Model\SkeletonTableGateway::class);
                    return new Model\SkeletonTable($tableGateway,$container);
                },
                Model\SkeletonTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Skeleton($dbAdapter));
                    return new TableGateway('skeleton', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    /**
     * Load Controllers
     */
    public function getControllerConfig() : array {
        return [
            'factories' => [
                # Plugin Example Controller
                Controller\PluginController::class => function($container) {
                    $oDbAdapter = $container->get(AdapterInterface::class);
                    return new Controller\PluginController(
                        $oDbAdapter,
                        $container->get(Model\SkeletonTable::class),
                        $container
                    );
                },
                # Skeleton Main Controller
                Controller\SkeletonController::class => function($container) {
                    $oDbAdapter = $container->get(AdapterInterface::class);
                    $tableGateway = $container->get(Model\SkeletonTable::class);
                    # hook plugin
                    CoreEntityController::addHook('skeleton-add-before',(object)['sFunction'=>'testFunction','oItem'=>new PluginController($oDbAdapter,$tableGateway,$container)]);
                    return new Controller\SkeletonController(
                        $oDbAdapter,
                        $container->get(Model\SkeletonTable::class),
                        $container
                    );
                },
                # Api Plugin
                Controller\ApiController::class => function($container) {
                    $oDbAdapter = $container->get(AdapterInterface::class);
                    return new Controller\ApiController(
                        $oDbAdapter,
                        $container->get(Model\SkeletonTable::class),
                        $container
                    );
                },
                # Export Plugin
                Controller\ExportController::class => function($container) {
                    $oDbAdapter = $container->get(AdapterInterface::class);
                    return new Controller\ExportController(
                        $oDbAdapter,
                        $container->get(Model\SkeletonTable::class),
                        $container
                    );
                },
                # Search Plugin
                Controller\SearchController::class => function($container) {
                    $oDbAdapter = $container->get(AdapterInterface::class);
                    return new Controller\SearchController(
                        $oDbAdapter,
                        $container->get(Model\SkeletonTable::class),
                        $container
                    );
                },
            ],
        ];
    }
}
