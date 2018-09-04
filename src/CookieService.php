<?php

namespace Devtoolboxuk\CookieService;

class CookieService
{

    /**
     * Prefix for cookies.
     * @var string
     */
    private $prefix = '';

    /**
     * @var
     */
    private $domain = '';

    /**
     * @var bool
     */
    private $secure = true;

    /**
     * @var bool
     */
    private $httpOnly = true;

    /**
     * @var string
     */
    private $path = '/';

    /**
     *
     * By default, the cookie time is a session cookie.
     *
     * @var int
     */
    private $time = 0;

    /**
     * Set cookie.
     *
     * @param string $key → name the data to save
     * @param string $value → the data to save
     *
     * @return boolean
     */
    public function set($key, $value)
    {
        $prefix = $this->prefix . $key;
        return setcookie($prefix, $value, $this->time, $this->path, $this->domain, $this->secure, $this->httpOnly);
    }

    /**
     * CookieService constructor.
     * @param $options
     */
    public function __construct($options)
    {
        isset($options['prefix']) ? $this->setPrefix($options['prefix']) : null;
        isset($options['time']) ? $this->setTime($options['time']) : null;
        isset($options['futureTime']) ? $this->setTime($options['setFutureTime']) : null;
        isset($options['path']) ? $this->setPath($options['path']) : null;
        isset($options['domain']) ? $this->setDomain($options['domain']) : null;
        isset($options['secure']) ? $this->setSecure($options['secure']) : null;
        isset($options['httpOnly']) ? $this->setHttpOnly($options['httpOnly']) : null;

    }

    public function setPath($path)
    {
        if (!empty($path) && is_string($path)) {
            $this->path = $path;
            return true;
        }

        return false;
    }

    public function setDomain($domain)
    {
        if (!empty($domain) && is_string($domain)) {
            $this->domain = $domain;
            return true;
        }

        return false;
    }

    public function setSecure($secure)
    {
        if (!empty($secure) && is_bool($secure)) {
            $this->secure = $secure;
            return true;
        }

        return false;
    }

    public function setHttpOnly($httpOnly)
    {
        if (!empty($httpOnly) && is_bool($httpOnly)) {
            $this->httpOnly = $httpOnly;
            return true;
        }

        return false;
    }

    public function setStaticTime($time)
    {
        if (!empty($time) && is_int($time)) {
            $this->time = $time;
            return true;
        }

        return false;
    }

    public function setFutureTime($time = 365)
    {

        if (!empty($time) && is_int($time)) {
            $this->time = time() + (86400 * $time);
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
    public function get($key = '')
    {
        if (isset($_COOKIE[$this->prefix . $key])) {
            return $_COOKIE[$this->prefix . $key];
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
    public function pull($key)
    {
        if (isset($_COOKIE[$this->prefix . $key])) {
            setcookie($this->prefix . $key, '', time() - 3600, $this->path);

            return $_COOKIE[$this->prefix . $key];
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
    public function destroy($key = '')
    {
        if (isset($_COOKIE[$this->prefix . $key])) {
            setcookie($this->prefix . $key, '', time() - 3600, $this->path);

            return true;
        }

        if (count($_COOKIE) > 0) {
            foreach ($_COOKIE as $key => $value) {
                setcookie($key, '', time() - 3600, $this->path);
            }

            return true;
        }

        return false;
    }

    /**
     * Get cookie prefix.
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    public function setPrefix($prefix)
    {
        if (!empty($prefix) && is_string($prefix)) {
            $this->prefix = $prefix;
            return true;
        }

        return false;
    }


}