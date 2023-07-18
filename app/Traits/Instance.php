<?php

namespace App\Traits;


trait Instance
{
    private static $instances;

    /**
     *
     * @param mixed ...$args
     * @return $this
     */
    public static function getInstance(...$args): static
    {
        $className = static::class;

        if (!isset(self::$instances[$className])) {
            self::$instances[$className] = new $className(...$args);
        }

        return self::$instances[$className];
    }
}
