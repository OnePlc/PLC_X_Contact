<?php
/**
 * module.config.php - Contact Config
 *
 * Main Config File for Contact Module
 *
 * @category Config
 * @package Contact
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Contact;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    # Contact Module - Routes
    'router' => [
        'routes' => [
            # Module Basic Route
            'contact' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/contact[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ContactController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'contact-api' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/contact/api[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ApiController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    # View Settings
    'view_manager' => [
        'template_path_stack' => [
            'contact' => __DIR__ . '/../view',
        ],
    ],
];
