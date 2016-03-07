<?php

namespace Dba\Flavia\Storage;

class SessionAdapter implements StorageInterface
{
    public function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }




    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
}