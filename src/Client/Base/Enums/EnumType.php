<?php

declare(strict_types=1);

namespace App\Client\Base\Enums;

use ReflectionClass;

/**
 * Description of Enum
 *
 * @author Eno Mullaraj <emullaraj.a4b@gmail.com>
 */
abstract class EnumType
{
    private static $constCacheArray = null;

    /**
     * @param $name
     * @param bool $strict
     *
     * @return bool
     */
    public static function isValidName($name, $strict = false)
    {
        $constants = self::getConstants();

        if ($strict) {
            return \array_key_exists($name, $constants);
        }

        $keys = array_map('mb_strtolower', array_keys($constants));

        return in_array(mb_strtolower($name), $keys, true);
    }

    /**
     * @return array
     */
    public static function getConstants()
    {
        if (self::$constCacheArray === null) {
            self::$constCacheArray = [];
        }

        $calledClass = static::class;

        try {
            if (!\array_key_exists($calledClass, self::$constCacheArray)) {
                $reflect = new ReflectionClass($calledClass);
                self::$constCacheArray[$calledClass] = $reflect->getConstants();
            }
        } catch (\Exception $e) {
            return [];
        }

        return self::$constCacheArray[$calledClass];
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public static function isValidValue($value)
    {
        $values = array_values(self::getConstants());

        return in_array($value, $values, $strict = true);
    }

    /**
     * @param $name
     *
     * @return null|mixed
     */
    public static function getValueFromName($name)
    {
        $constants = self::getConstants();

        return $constants[$name] ?? null;
    }

    /**
     * @param $value
     *
     * @return bool|int|string
     */
    public static function getNameFromValue($value)
    {
        $constants = self::getConstants();

        foreach ($constants as $constantName => $constantValue) {
            if ($constantValue === $value) {
                return $constantName;
            }
        }

        return false;
    }
}
