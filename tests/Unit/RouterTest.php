<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Router;

final class RouterTest extends TestCase
{
    private Router $router;

    protected function setUp(): void
    {
        $this->router = new Router();
    }

    public function testAddRoute(): void
    {
        $path = '/test-route';
        $params = ['controller' => 'TestController', 'action' => 'testAction'];

        $this->router->add($path, $params);

        $this->assertEquals($params, $this->router->match($path));
    }

    public function testMatchValidRoute(): void
    {
        $path = '/valid-route';
        $params = ['controller' => 'ValidController', 'action' => 'validAction'];
        $this->router->add($path, $params);

        $result = $this->router->match($path);

        $this->assertIsArray($result);
        $this->assertEquals($params, $result);
    }

    public function testMatchInvalidRoute(): void
    {
        $path = '/non-existent-route';

        $result = $this->router->match($path);

        $this->assertFalse($result);
    }

    public function testMultipleRoutes(): void
    {
        $route1 = '/route-one';
        $params1 = ['controller' => 'ControllerOne', 'action' => 'actionOne'];

        $route2 = '/route-two';
        $params2 = ['controller' => 'ControllerTwo', 'action' => 'actionTwo'];

        $this->router->add($route1, $params1);
        $this->router->add($route2, $params2);

        $this->assertEquals($params1, $this->router->match($route1));
        $this->assertEquals($params2, $this->router->match($route2));
    }
}

