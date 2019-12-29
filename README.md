# Account Chooser

## Motivation
For many years, I have had the idea of implementing a functionality, that normally was available on more modern operating systems. A sign in **account chooser** functionality which would list most recently used accounts, and allow to sign in with *ease*. 

Eventually, this functionality came to the web, with Google being the first platform to introduce this. Inspired by this, I decided to showcase and deconstruct both Google's and Facebook's account chooser functionality. By implementing similar functionality with PHP and jQuery. 

## Prerequisites
- Prior knowledge of PHP OOP
- [Apache 2.4.x](https://httpd.apache.org/)
- PHP 7.4.x (or any PHP 7.x)
- Enable **rewrite_module** in *httpd.conf* (Apache)
- [IIS Mod-Rewrite](http://www.micronovae.com/ModRewrite/ModRewrite.html)* (Windows-only)

## Note to Windows Users
I wrote all of the code from a **Windows PC**. If you are on Windows and decide to give this a try, make sure you have everything properly setup and configured prior.
Follow instructions here: https://www.furqansiddiqui.com/install-php-7-with-apache-2-on-windows-10/. 

## Future Improvements
* Improve the *cryptography.php* class and make it more modular
* Implement a delete an account from the list (*Ajax implemented*)
* Implement a remove all accounts (*Ajax implemented*)
* Improve this Readme - when I have more time

## Addendum
The aim of this project is to showcase some of the cool features, some of the most popular websites implement. The project can be downloaded and used in a real production environment. I am fully aware of the different security cryptographies that exist for PHP 7.4. Some of the older cryptographies have been depreciated. This project uses *openssl*, even if *libsodium* is built in. 

The reason for built in openssl over libsodium, is because of backward compatibility, e.g. if someone tries this under PHP 7.0 or 7.1, then very little effort or no effort is required to run this. While in a real production environment, libsodium would be much preferred. 

***Disclaimer**: I know that *Microsoft URL Rewrite Module 2.0 for IIS* exist, but, I also know that this module is not easy to use, therefore, I am proposing: IIS Mod-Rewrite by a third-party provider.