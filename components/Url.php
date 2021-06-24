<?php

namespace components;
class Url
{
    /**
     * Strip main domain from URL
     *
     * @param string $url
     * @return string domain
     */
    public static function getDomain($url)
    {
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : '';
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            return $regs['domain'];
        }
        return $url;
    }

    /**
     * The following function will strip the path name from the request URL
     *
     * @return String
     */
    public static function getCurrentPath()
    {
        $basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        $uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
        if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
        $uri = '/' . trim($uri, '/');
        return $uri;
    }

    /**
     * Get the current path without the last component
     *
     * @return string
     */
    public static function getCurrentPathWithoutLastComponent() {
        if (self::getCurrentPath() !== '/')
            return preg_replace('/\/(?:.(?!\/))+$/m', "", self::getCurrentPath());
        else
            return '/';
    }

    /**
     * Get only the last component of the current path
     *
     * @return string
     */
    public static function getCurrentPathLastComponent() {
        if (self::getCurrentPath() !== '/') {
            preg_match('/\/(?:.(?!\/))+$/m', self::getCurrentPath(), $matches);
            return $matches[0];
        } else {
            return '/';
        }
    }
}