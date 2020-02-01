<?php
/**
 * ApiControllerTest.php - Main Controller Test Class
 *
 * Test Class for Main Controller of Skeleton Module
 *
 * @category Test
 * @package Skeleton
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace OnePlaceTest\Skeleton\Controller;

use OnePlace\Skeleton\Controller\ApiController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Laminas\Session\Container;
use User\Model\TestUser;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Stdlib\Parameters;

class ApiControllerTest extends AbstractHttpControllerTestCase {
    public function setUp() : void {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        $this->setApplicationConfig([
            // Retrieve list of modules used in this application.
            'modules' => ['OnePlace\Skeleton'],

            // These are various options for the listeners attached to the ModuleManager
            'module_listener_options' => [
                // use composer autoloader instead of laminas-loader
                'use_laminas_loader' => false,
                // An array of paths from which to glob configuration files after
                // modules are loaded. These effectively override configuration
                // provided by modules themselves. Paths may use GLOB_BRACE notation.
                'config_glob_paths' => [
                    realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local}.php',
                ],
                // Whether or not to enable a configuration cache.
                // If enabled, the merged configuration will be cached and used in
                // subsequent requests.
                'config_cache_enabled' => true,
                // The key used to create the configuration cache file name.
                'config_cache_key' => 'application.config.cache',
                // Whether or not to enable a module class map cache.
                // If enabled, creates a module class map cache which will be used
                // by in future requests, to reduce the autoloading process.
                'module_map_cache_enabled' => true,
                // The key used to create the class map cache file name.
                'module_map_cache_key' => 'application.module.cache',
                // The path in which to cache merged configuration.
                'cache_dir' => 'data/cache/',
            ],
        ]);

        parent::setUp();
    }

    private function initFakeTestSession() {
        /**
         * Init Test Session to Fake Login
         */
        $oSm = $this->getApplicationServiceLocator();
        $oDbAdapter = $oSm->get(AdapterInterface::class);
        $oSession = new Container('plcauth');
        $oTestUser = new TestUser($oDbAdapter);
        $oTestUser->exchangeArray(['full_name'=>'Test','email'=>'admin@1plc.ch','User_ID'=>1]);
        $oSession->oUser = $oTestUser;
    }

    public function testIndexActionCannotBeAccessedWithoutKey() {
        $this->dispatch('/skeleton/api', 'GET');
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/login');
    }

    public function testIndexActionCanBeAccessed() {
        # todo: API works without session - somehow $_REQUEST is empty with testsuite find out why
        $this->initFakeTestSession();

        $this->dispatch('/skeleton/api?authkey=DEVRANDOMKEY', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('skeleton');
        $this->assertControllerName(ApiController::class); // as specified in router's controller name alias
        $this->assertControllerClass('ApiController');
        $this->assertMatchedRouteName('skeleton-api');
    }
}
