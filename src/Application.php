<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.3.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App;

use App\Middleware\HostHeaderMiddleware;
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Event\EventManagerInterface;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Routing\Router;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 *
 * @extends \Cake\Http\BaseApplication<\App\Application>
 */
class Application extends BaseApplication implements AuthenticationServiceProviderInterface
{
    /**
     * Load all the application configuration and bootstrap logic.
     *
     * @return void
     */
    public function bootstrap(): void
    {
        // Call parent to load bootstrap from files.
        parent::bootstrap();

        // By default, does not allow fallback classes.
        FactoryLocator::add(
            'Table',
            (new TableLocator())->allowFallbackClass(false),
        );
    }

    /**
     * Setup the middleware queue your application will use.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
     * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            // Catch any exceptions in the lower layers,
            // and make an error page/response
            ->add(new ErrorHandlerMiddleware(Configure::read('Error'), $this))

            // Validate Host header to prevent Host Header Injection attacks.
            ->add(new HostHeaderMiddleware())

            // Handle plugin/theme assets like CakePHP normally does.
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))

            // Routing middleware (finds the controller/action). Must stay.
            ->add(new RoutingMiddleware($this))

            // Authentication middleware (must come AFTER routing).
            ->add(new AuthenticationMiddleware($this))

            // Parse encoded request bodies so they are available via $request->getData()
            ->add(new BodyParserMiddleware())

            // Cross Site Request Forgery (CSRF) Protection Middleware
            ->add(new CsrfProtectionMiddleware([
                'httponly' => true,
            ]));

        return $middlewareQueue;
    }

    /**
     * Register application container services.
     *
     * @param \Cake\Core\ContainerInterface $container The Container to update.
     * @return void
     */
    public function services(ContainerInterface $container): void
    {
        // Allow your Tables to be dependency injected
        //$container->delegate(new \Cake\ORM\Locator\TableContainer());
    }

    /**
     * Register custom event listeners here
     *
     * @param \Cake\Event\EventManagerInterface $eventManager
     * @return \Cake\Event\EventManagerInterface
     */
    public function events(EventManagerInterface $eventManager): EventManagerInterface
    {
        // $eventManager->on(new SomeCustomListenerClass());

        return $eventManager;
    }

    /**
     * Tell the Authentication plugin how login should work.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @return \Authentication\AuthenticationServiceInterface
     */
       public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $service = new AuthenticationService();

        $service->setConfig([
            'unauthenticatedRedirect' => Router::url(['controller' => 'Users', 'action' => 'login']),
            'queryParam' => 'redirect',
        ]);

        $fields = [
            'username' => 'email',
            'password' => 'password',
        ];

        // How to check the email and password (note the "className" key).
        $identifier = [
            'className' => 'Authentication.Password',
            'fields' => $fields,
        ];

        // 1st: is the user already logged in (session)?
        $service->loadAuthenticator('Authentication.Session', [
            'identifier' => $identifier,
        ]);

        // 2nd: did the user just submit the login form?
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => $fields,
            'identifier' => $identifier,
        ]);

        return $service;
    }
}