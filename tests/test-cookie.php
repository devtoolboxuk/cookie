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
        $this->cookiePrefix = $this->CookieService->getPrefix();
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

        $this->assertTrue($this->CookieService->set('cookie_name', 'value', 365));
    }

    /**
     * Get item from cookie.
     *
     * @runInSeparateProcess
     */
    public function testGetCookie()
    {
        $_COOKIE[$this->cookiePrefix . 'cookie_name'] = 'value';

        $this->assertContains($this->CookieService->get('cookie_name'), 'value');
    }

    /**
     * Return cookies array.
     *
     * @runInSeparateProcess
     */
    public function testGetAllCookies()
    {

        $_COOKIE[$this->cookiePrefix . 'cookie_name_one'] = 'value';
        $_COOKIE[$this->cookiePrefix . 'cookie_name_two'] = 'value';

        $this->assertArrayHasKey(
            $this->cookiePrefix . 'cookie_name_two',
            $this->CookieService->get()
        );
    }

    /**
     * Return cookies array non-existent.
     *
     * @runInSeparateProcess
     */
    public function testGetAllCookiesNonExistents()
    {

        $this->assertFalse($this->CookieService->get());
    }

    /**
     * Extract item from cookie then delete cookie and return the item.
     *
     * @runInSeparateProcess
     */
    public function testPullCookie()
    {

        $_COOKIE[$this->cookiePrefix . 'cookie_name'] = 'value';

        $this->assertContains($this->CookieService->pull('cookie_name'), 'value');
    }

    /**
     * Extract item from cookie non-existent.
     *
     * @runInSeparateProcess
     */
    public function testPullCookieNonExistent()
    {
        $this->assertFalse($this->CookieService->pull('cookie_name'));
    }

    /**
     * Destroy one cookie.
     *
     * @runInSeparateProcess
     */
    public function testDestroyOneCookie()
    {
        $_COOKIE[$this->cookiePrefix . 'cookie_name'] = 'value';

        $this->assertTrue($this->CookieService->destroy('cookie_name'));
    }

    /**
     * Destroy one cookie non-existent.
     *
     * @runInSeparateProcess
     */
    public function testDestroyOneCookieNonExistent()
    {

        $this->assertFalse($this->CookieService->destroy('cookie_name'));
    }

    /**
     * Destroy all cookies.
     *
     * @runInSeparateProcess
     */
    public function testDestroyAllCookies()
    {

        $_COOKIE[$this->cookiePrefix . 'cookie_name_one'] = 'value';
        $_COOKIE[$this->cookiePrefix . 'cookie_name_two'] = 'value';

        $this->assertTrue($this->CookieService->destroy());
    }

    /**
     * Destroy all cookies non-existents.
     *
     * @runInSeparateProcess
     */
    public function testDestroyAllCookiesNonExistents()
    {

        $this->assertFalse($this->CookieService->destroy());
    }

    /**
     * Get cookie prefix.
     *
     * @runInSeparateProcess
     */
    public function testGetCookiePrefix()
    {

        $this->assertContains($this->CookieService->getPrefix(), 'jst_');
    }

    /**
     * Set cookie prefix.
     *
     * @runInSeparateProcess
     */
    public function testSetCookiePrefix()
    {

        $this->assertTrue($this->CookieService->setPrefix('prefix_'));
    }

    /**
     * Set cookie prefix incorrectly.
     *
     * @runInSeparateProcess
     */
    public function testSetCookieIncorrectly()
    {

        $this->assertFalse($this->CookieService->setPrefix(''));
        $this->assertFalse($this->CookieService->setPrefix(5));
        $this->assertFalse($this->CookieService->setPrefix(true));
    }

}
