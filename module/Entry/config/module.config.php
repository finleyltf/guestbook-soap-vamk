<?php

namespace Entry;

return array(
    'controllers' => array(
        'invokables' => array(
            'Entry\Controller\Entry' => 'Entry\Controller\EntryController',
            'Entry\Controller\SoapHandler' => 'Entry\Controller\SoapHandlerController',
        ),
    ),
    'router' => array(
        'routes' => array(

//            'entry' => array(
//                'type'    => 'Literal',
//                'options' => array(
//                    // Change this to something specific to your module
//                    'route'    => '/entry[/][:action][/:id]',
//                    'defaults' => array(
//                        // Change this value to reflect the namespace in which
//                        // the controllers for your module are found
//                        '__NAMESPACE__' => 'Entry\Controller',
//                        'controller'    => 'Entry',
//                        'action'        => 'index',
//                    ),
//                ),
//                'may_terminate' => true,
//                'child_routes' => array(
//                    // This route is a sane default when developing a module;
//                    // as you solidify the routes for your module, however,
//                    // you may want to remove it and replace it with more
//                    // specific routes.
//                    'default' => array(
//                        'type'    => 'Segment',
//                        'options' => array(
//                            'route'    => '/[:controller[/:action]]',
//                            'constraints' => array(
//                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
//                            ),
//                            'defaults' => array(
//                            ),
//                        ),
//                    ),
//                ),
//            ),

            'entry' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/entry[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults'    => array(
                        'controller' => 'Entry\Controller\Entry',
                        'action'     => 'index',
                    ),
                ),
            ),

            'soaphandler' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/soaphandler[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults'    => array(
                        'controller' => 'Entry\Controller\SoapHandler',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                // so that it will accept the ?wsdl if requested - else it redirects as a bad route
                'child_routes' => array(
                    'default' => array(
                        'type'  => 'Segment',
                        'options' => array(
                            'route' => '/[:wsdl]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),

            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'ZendSkeletonModule' => __DIR__ . '/../view',
        ),
    ),

    // Doctrine config
    'doctrine'     => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default'             => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    )
);
