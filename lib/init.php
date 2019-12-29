<?php
/**
 * init.php
 * 
 * @author Fisnik
 * @copyright Fisnik
 * 
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'en_US.UTF8');
date_default_timezone_set("Europe/Stockholm");

header('Content-Type: text/html;charset="UTF-8"');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header("X-Content-Security-Policy: default-src 'self'; script-src 'self';");
header("Content-Security-Policy: default-src 'none'; style-src 'self' data:; img-src 'self' data:; script-src 'self'; connect-src 'self';");

define("ROOT_DIR", realpath(dirname(__FILE__)));

assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_BAIL, 1); // Force PHP engine to stop when an assertion fails

include_once(ROOT_DIR . "./cookie.php");
include_once(ROOT_DIR . "./cryptography.php");
include_once(ROOT_DIR . "./template.php");

use Security\Cryptography\Cryptography;
use Security\Cookie\Cookie;
use Strings\Template\Template;

global $crypto;
global $tmp;
global $cookie; 

$crypto = new Cryptography();
$tmp = new Template();
$cookie = Cookie::get_instance();

?>