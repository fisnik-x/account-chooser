<?php
/**
 * cookie.php
 * 
 * @package Security\Cookie
 * @author Fisnik
 * @copyright Fisnik
 * 
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */
declare(strict_types=1);
namespace Security\Cookie;
use \Exception; 

/**
 * Cookie Management Class
 */
final class Cookie{

    private static $instance = null; 
    protected ?string $domain = null;
    protected ?string $path = null; 
    protected bool $secure = false;
    protected bool $httpOnly = true; 
    protected ?string $sameSite = null; 

    public function __construct() {}

    /**
     * Creates an instance of this class
     *
     * @return object
     */
    public static function get_instance() : object 
    {
        if (self::$instance == null){
            self::$instance = new Cookie(); 
        }
        return self::$instance;
    }

    /**
     * Creates a new cookie 
     *
     * @param string $name
     * @param string $value
     * @param integer $expire
     * @param string $path
     * @param string $domain
     * @param boolean $httpOnly
     * @param boolean $secure
     * @param string $sameSite
     * @return boolean
     */
    public function set_cookie(string $name = "", string $value = "", int $expire = 0, string $path = "/", 
    string $domain = "", bool $httpOnly = true, bool $secure = false, string $sameSite = "null") : bool
    {
        $expire = ($expire == -1) ? $expire = time() + 3600 * 24 * 366 : 
        ($expire && $expire < time()) ?? $expire = time() + $expire;

        $this->domain = $domain;
        $this->path = $path;
        $this->secure = $secure;
        $this->httpOnly = $httpOnly;
        $this->sameSite = $sameSite;

        $options = [
            'expires' => $expire,
            'path' => $this->path,
            'domain' => $this->domain,
            'secure' => $this->secure,
            'httponly' => $this->httpOnly,
            'samesite' => $this->sameSite
        ];

        return setcookie($name, $value, $options);
    }

    /**
     * Returns a cookie value
     *
     * @param string $key
     * @return string
     */
    public function get_cookie(string $key = null) : string 
    {
        return $_COOKIE[$key] ?? null;
    }

    /**
     * Checks if a cookie exists
     *
     * @param string $key
     * @return boolean
     */
    public function cookie_exists(string $key = null) : bool 
    {
        return array_key_exists($key, $_COOKIE);
    }

    public function clear(string $name = "") : void 
    {
        if($this->cookie_exists($name)){
            setcookie($name, '', time() - 3600, '/');
            unset($_COOKIE[$name]);
        }
    }

    /**
     * Clears all cookies under current domain
     */
    public function clear_all_cookies() : void 
    {
        if(!(count($_COOKIE) > 1)) {
            throw new Exception("There are no cookies to delete.");
        }

        foreach($_COOKIE as $k => $v) {
            setcookie($key, '', time() - 3600, '/');
            unset($_COOKIE[$key]);
        }
    }
}