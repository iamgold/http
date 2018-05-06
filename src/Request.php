<?php

namespace iamgold\http;

/**
 * This class is used to manipulate HTTP request information.
 *
 * Initialize with $_SERVER.
 *
 * @author Eric Huang <iamgold0105@gmail.com>
 * @version 0.1.2
 */
class Request
{
    /**
     * @var array $data;
     */
    private $data = [];

    /**
     * construct
     *
     * @param array $server
     * @param array $cookie
     * @param array $queryParams
     * @param array $server
     */
    public function __construct(array $server = null, array $cookies = null, array $queryParams = null, array $post = null)
    {
        $this->data['server'] = ($server) ?? $_SERVER;
        $this->data['cookies'] = ($cookies) ?? $_COOKIE;
        $this->data['queryParams'] = ($queryParams) ?? $_GET;
        $this->data['post'] = ($post) ?? $_POST;
    }

    /**
     * Returns request cookies
     *
     * @param $name
     * @return string|null return null when undefined
     */
    public function getCookie($name)
    {
        return ($this->cookies[$name]) ?? null;
    }

    /**
     * Returns the method of the current request (e.g. GET, POST, HEAD, PUT, PATCH, DELETE).
     *
     * @return string such as GET, POST, HEAD, PUT, PATCH, DELETE.
     */
    public function getMethod()
    {
        if (isset($this->server['REQUEST_METHOD'])) {
            return strtoupper($this->server['REQUEST_METHOD']);
        }

        return 'GET';
    }

    /**
     * get user ip
     *
     * @see https://stackoverflow.com/questions/15699101/get-the-client-ip-address-using-php
     * @return string
     */
    public function getUserIp()
    {
        $ipaddress = '';
        if (isset($this->server['HTTP_CLIENT_IP']))
            $ipaddress = $this->server['HTTP_CLIENT_IP'];
        else if(isset($this->server['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $this->server['HTTP_X_FORWARDED_FOR'];
        else if(isset($this->server['HTTP_X_FORWARDED']))
            $ipaddress = $this->server['HTTP_X_FORWARDED'];
        else if(isset($this->server['HTTP_FORWARDED_FOR']))
            $ipaddress = $this->server['HTTP_FORWARDED_FOR'];
        else if(isset($this->server['HTTP_FORWARDED']))
            $ipaddress = $this->server['HTTP_FORWARDED'];
        else if(isset($this->server['REMOTE_ADDR']))
            $ipaddress = $this->server['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }

    /**
     * __set
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set(string $name, $value = null)
    {
        $methodName = 'set' . ucfirst($name);
        if (method_exists($this, $methodName))
            return call_user_func_array([$this, $methodName], [$value]);

        if (isset($this->data[$name]))
            throw new Exception("This property $name is readOnly", 403);

        throw new Exception("This property didn't be access", 400);
    }

    /**
     * __get
     */
    public function __get(string $name)
    {
        $methodName = 'get' . ucfirst($name);
        if (method_exists($this, $methodName))
            return call_user_func_array([$this, $methodName]);

        if (isset($this->data[$name]))
            return $this->data[$name];

        throw new Exception("This property was not found", 404);
    }
}
