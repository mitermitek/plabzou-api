<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }


    // Méthode pour invoquer une méthode privée à l'aide de la réflexion.
    private function invokePrivateMethod($object, $methodName, array $parameters = [])
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
