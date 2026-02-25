<?php

namespace App\Helpers;

class FlashMessage
{
    const KEY = 'flash_messages';

    public static function set($type, $message)
    {
        if (!isset($_SESSION[self::KEY])) {
            $_SESSION[self::KEY] = [];
        }
        $_SESSION[self::KEY][] = [
            'type' => $type,
            'message' => $message
        ];
    }

    public static function success($message)
    {
        self::set('success', $message);
    }

    public static function error($message)
    {
        self::set('error', $message);
    }

    public static function info($message)
    {
        self::set('info', $message);
    }

    public static function warning($message)
    {
        self::set('warning', $message);
    }

    public static function get()
    {
        if (isset($_SESSION[self::KEY])) {
            $messages = $_SESSION[self::KEY];
            unset($_SESSION[self::KEY]);
            return $messages;
        }
        return [];
    }

    public static function has()
    {
        return isset($_SESSION[self::KEY]) && count($_SESSION[self::KEY]) > 0;
    }
}
