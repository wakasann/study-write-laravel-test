<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected static $tablesToReseed = [];

    public function seed($class = 'DatabaseSeeder', array $tables = [])
    {
        $this->artisan('db:seed', ['--class' => $class, '--tables' => implode(',', $tables)]);
    }

    protected function reseed()
    {
        // TEST_SEEDERS is defined in phpunit.xml, e.g. <env name="TEST_SEEDERS" value="\SimpleYamlSeeder"/>
        $seeders = env('TEST_SEEDERS') ? explode(',', env('TEST_SEEDERS')) : [];

        if ($seeders && is_array(static::$tablesToReseed)) {
            foreach ($seeders as $seeder) {
                $this->seed($seeder, static::$tablesToReseed);
            }
        }

        \Cache::flush();

        static::$tablesToReseed = false;
    }

    protected static function reseedInNextTest(array $tables = [])
    {
        static::$tablesToReseed = $tables;
    }

    /**
     * Call protected or private method of a class.
     *
     * @param object $object      instantiated object that we will run method on.
     * @param string $method_name method name to call
     * @param array  $parameters  array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    protected function invokeNonPublicMethod($object,  $method_name, ...$parameters)
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method     = $reflection->getMethod($method_name);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    protected function getNonPublicMethod($object,  $method_name)
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method     = $reflection->getMethod($method_name);
        $method->setAccessible(true);

        return $method;
    }

    protected function invokeNonPublicMethodSecond($object,  $method_name, ...$parameters)
    {
        return $this->getNonPublicMethod($object, $method_name)->invokeArgs($object, $parameters);
    }






}
