<?php

namespace iamgold\http;

/**
 * This class is used to manipulate HTTP response
 *
 * @author Eric Huang <iamgold0105@gmail.com>
 * @version 0.1.0
 */
class Response
{
    /**
     * construct
     */
    public function __construct()
    {
    }

    /**
     * set cookie
     *
     * @see http://php.net/manual/en/function.setcookie.php
     * @return bool
     */
    public function setCookie(string $name, string $value = "", int $expire = 0, string $path = "", string $domain = "", bool $secure = FALSE, bool $httpOnly = false)
    {
        return setCookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
    }

    /**
     * set status code
     *
     * @param int $code
     * @param string $message
     * @return int return http code
     * @see http://php.net/manual/en/function.http-response-code.php
     */
    public function setStatusCode(int $code, $message = null)
    {
        switch ($code) {
            case 100: $text = 'Continue'; break;
            case 101: $text = 'Switching Protocols'; break;
            case 200: $text = 'OK'; break;
            case 201: $text = 'Created'; break;
            case 202: $text = 'Accepted'; break;
            case 203: $text = 'Non-Authoritative Information'; break;
            case 204: $text = 'No Content'; break;
            case 205: $text = 'Reset Content'; break;
            case 206: $text = 'Partial Content'; break;
            case 300: $text = 'Multiple Choices'; break;
            case 301: $text = 'Moved Permanently'; break;
            case 302: $text = 'Moved Temporarily'; break;
            case 303: $text = 'See Other'; break;
            case 304: $text = 'Not Modified'; break;
            case 305: $text = 'Use Proxy'; break;
            case 400: $text = 'Bad Request'; break;
            case 401: $text = 'Unauthorized'; break;
            case 402: $text = 'Payment Required'; break;
            case 403: $text = 'Forbidden'; break;
            case 404: $text = 'Not Found'; break;
            case 405: $text = 'Method Not Allowed'; break;
            case 406: $text = 'Not Acceptable'; break;
            case 407: $text = 'Proxy Authentication Required'; break;
            case 408: $text = 'Request Time-out'; break;
            case 409: $text = 'Conflict'; break;
            case 410: $text = 'Gone'; break;
            case 411: $text = 'Length Required'; break;
            case 412: $text = 'Precondition Failed'; break;
            case 413: $text = 'Request Entity Too Large'; break;
            case 414: $text = 'Request-URI Too Large'; break;
            case 415: $text = 'Unsupported Media Type'; break;
            case 500: $text = 'Internal Server Error'; break;
            case 501: $text = 'Not Implemented'; break;
            case 502: $text = 'Bad Gateway'; break;
            case 503: $text = 'Service Unavailable'; break;
            case 504: $text = 'Gateway Time-out'; break;
            case 505: $text = 'HTTP Version not supported'; break;
            default:
                $message = 'Unknown http status code "' . htmlentities($code) . '"';
                throw new Exception($message, 400);
            break;
        }

        if ($message===null)
            $message = $text;

        $protocol = ($_SERVER['SERVER_PROTOCOL']) ?? 'HTTP/1.0';
        header($protocol . ' ' . $code . ' ' . $message);

        return $code;
    }

    /**
     * Response a png pixel
     *
     * @param Response $response default: png
     * @return Response
     */
    public function sendOnePixel()
    {
        header('Content-Type: image/png');
        $im = @imagecreate(1, 1)
            or die("Cannot Initialize new GD image stream");
        $background_color = imagecolorallocate($im, 255, 255, 255);
        imagepng($im);
        imagedestroy($im);
    }
}
