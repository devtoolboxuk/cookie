<?php

namespace devtoolboxuk\CookieService;

class CookieService
{


    /**
     * Prefix for cookies.
     * @var string
     */
    public static $prefix = '';

    /**
     * @var
     */
    public static $domain;

    /**
     * @var bool
     */
    public static $secure = true;

    /**
     * @var bool
     */
    public static $httpOnly = true;

    /**
     * @var string
     */
    public static $path = '/';

    /**
     *
     * By default, the cookie time is a session cookie.
     *
     * @var int
     */
    public static $time = 0;

    /**
     * Set cookie.
     *
     * @param string $key → name the data to save
     * @param string $value → the data to save
     * @param integer $time → expiration time in days
     *
     * @return boolean
     */
    public static function set($key, $value)
    {
        $prefix = self::$prefix . $key;
        return setcookie($prefix, $value, self::$time, self::$path, self::$domain, self::$secure, self::$httpOnly);
    }


    public static function setConfig($options)
    {
        isset($options['prefix']) ? self::setPrefix($options['prefix']) : null;
        isset($options['time']) ? self::setTime($options['time']) : null;
        isset($options['futureTime']) ? self::setTime($options['setFutureTime']) : null;
        isset($options['path']) ? self::setPath($options['path']) : null;
        isset($options['domain']) ? self::setDomain($options['domain']) : null;
        isset($options['secure']) ? self::setSecure($options['secure']) : null;
        isset($options['httpOnly']) ? self::setHttpOnly($options['httpOnly']) : null;

    }

    public function setPath($path)
    {
        if (!empty($path) && is_string($path)) {
            self::$path = $path;
            return true;
        }

        return false;
    }

    public function setDomain($domain)
    {
        if (!empty($domain) && is_string($domain)) {
            self::$domain = $domain;
            return true;
        }

        return false;
    }

    public function setSecure($secure)
    {
        if (!empty($secure) && is_bool($secure)) {
            self::$secure = $secure;
            return true;
        }

        return false;
    }

    public function setHttpOnly($httpOnly)
    {
        if (!empty($httpOnly) && is_bool($httpOnly)) {
            self::$httpOnly = $httpOnly;
            return true;
        }

        return false;
    }

    public static function setStaticTime($time)
    {
        if (!empty($time) && is_int($time)) {
            self::$time = $time;
            return true;
        }

        return false;
    }

    public static function setFutureTime($time = 365)
    {

        if (!empty($time) && is_int($time)) {
            self::$time = time() + (86400 * $time);
            return true;
        }

        return false;
    }

    /**
     * Get item from cookie.
     *
     * @param string $key → item to look for in cookie
     *
     * @return mixed|false → returns cookie value, cookies array or false
     */
    public static function get($key = '')
    {
        if (isset($_COOKIE[self::$prefix . $key])) {
            return $_COOKIE[self::$prefix . $key];
        }

        return (isset($_COOKIE) && count($_COOKIE)) ? $_COOKIE : false;
    }

    /**
     * Extract item from cookie then delete cookie and return the item.
     *
     * @param string $key → item to extract
     *
     * @return string|false → return item or false when key does not exists
     */
    public static function pull($key)
    {
        if (isset($_COOKIE[self::$prefix . $key])) {
            setcookie(self::$prefix . $key, '', time() - 3600, '/');

            return $_COOKIE[self::$prefix . $key];
        }

        return false;
    }

    /**
     * Empties and destroys the cookies.
     *
     * @param string $key → cookie name to destroy. Not set to delete all
     *
     * @return boolean
     */
    public static function destroy($key = '')
    {
        if (isset($_COOKIE[self::$prefix . $key])) {
            setcookie(self::$prefix . $key, '', time() - 3600, '/');

            return true;
        }

        if (count($_COOKIE) > 0) {
            foreach ($_COOKIE as $key => $value) {
                setcookie($key, '', time() - 3600, '/');
            }

            return true;
        }

        return false;
    }

    /**
     * Get cookie prefix.
     * @return string
     */
    public static function getPrefix()
    {
        return self::$prefix;
    }

    public static function setPrefix($prefix)
    {
        if (!empty($prefix) && is_string($prefix)) {
            self::$prefix = $prefix;
            return true;
        }

        return false;
    }


}