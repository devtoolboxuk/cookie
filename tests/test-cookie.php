<?php

namespace devtoolboxuk\CookieService;

use PHPUnit\Framework\TestCase;

class CookieTest extends TestCase
{

    /**
     * Cookie instance.
     * @var object
     */
    protected $CookieService;

    /**
     * Cookie prefix.
     * @var string
     */
    protected $cookiePrefix;

    /**
     * Set up.
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->CookieService = new CookieService();


        $cookie = $this->CookieService;

        $this->cookiePrefix = $cookie::getPrefix();
    }

    /**
     * Check if it is an instance of.
     *
     */
    public function testIsInstanceOf()
    {
        $this->assertInstanceOf('\devtoolboxuk\CookieService\CookieService', $this->CookieService);
    }

    /**
     * Set cookie.
     *
     * @runInSeparateProcess
     */
    public function testSetCookie()
    {
        $cookie = $this->CookieService;

        $this->assertTrue($cookie::set('cookie_name', 'value', 365));
    }

    /**
     * Get item from cookie.
     *
     * @runInSeparateProcess
     */
    public function testGetCookie()
    {
        $cookie = $this->CookieService;

        $_COOKIE[$this->cookiePrefix . 'cookie_name'] = 'value';

        $this->assertContains($cookie::get('cookie_name'), 'value');
    }

    /**
     * Return cookies array.
     *
     * @runInSeparateProcess
     */
    public function testGetAllCookies()
    {
        $cookie = $this->CookieService;

        $_COOKIE[$this->cookiePrefix . 'cookie_name_one'] = 'value';
        $_COOKIE[$this->cookiePrefix . 'cookie_name_two'] = 'value';

        $this->assertArrayHasKey(
            $this->cookiePrefix . 'cookie_name_two',
            $cookie::get()
        );
    }

    /**
     * Return cookies array non-existent.
     *
     * @runInSeparateProcess
     */
    public function testGetAllCookiesNonExistents()
    {
        $cookie = $this->CookieService;

        $this->assertFalse($cookie::get());
    }

    /**
     * Extract item from cookie then delete cookie and return the item.
     *
     * @runInSeparateProcess
     */
    public function testPullCookie()
    {
        $cookie = $this->CookieService;

        $_COOKIE[$this->cookiePrefix . 'cookie_name'] = 'value';

        $this->assertContains($cookie::pull('cookie_name'), 'value');
    }

    /**
     * Extract item from cookie non-existent.
     *
     * @runInSeparateProcess
     */
    public function testPullCookieNonExistent()
    {
        $cookie = $this->CookieService;

        $this->assertFalse($cookie::pull('cookie_name'));
    }

    /**
     * Destroy one cookie.
     *
     * @runInSeparateProcess
     */
    public function testDestroyOneCookie()
    {
        $cookie = $this->CookieService;

        $_COOKIE[$this->cookiePrefix . 'cookie_name'] = 'value';

        $this->assertTrue($cookie::destroy('cookie_name'));
    }

    /**
     * Destroy one cookie non-existent.
     *
     * @runInSeparateProcess
     */
    public function testDestroyOneCookieNonExistent()
    {
        $cookie = $this->CookieService;

        $this->assertFalse($cookie::destroy('cookie_name'));
    }

    /**
     * Destroy all cookies.
     *
     * @runInSeparateProcess
     */
    public function testDestroyAllCookies()
    {
        $cookie = $this->CookieService;

        $_COOKIE[$this->cookiePrefix . 'cookie_name_one'] = 'value';
        $_COOKIE[$this->cookiePrefix . 'cookie_name_two'] = 'value';

        $this->assertTrue($cookie::destroy());
    }

    /**
     * Destroy all cookies non-existents.
     *
     * @runInSeparateProcess
     */
    public function testDestroyAllCookiesNonExistents()
    {
        $cookie = $this->CookieService;

        $this->assertFalse($cookie::destroy());
    }

    /**
     * Get cookie prefix.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.6
     */
    public function testGetCookiePrefix()
    {
        $cookie = $this->CookieService;

        $this->assertContains($cookie::getPrefix(), 'jst_');
    }

    /**
     * Set cookie prefix.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.6
     */
    public function testSetCookiePrefix()
    {
        $cookie = $this->CookieService;

        $this->assertTrue($cookie::setPrefix('prefix_'));
    }

    /**
     * Set cookie prefix incorrectly.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.6
     */
    public function testSetCookieIncorrectly()
    {
        $cookie = $this->CookieService;

        $this->assertFalse($cookie::setPrefix(''));
        $this->assertFalse($cookie::setPrefix(5));
        $this->assertFalse($cookie::setPrefix(true));
    }

}
