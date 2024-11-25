<?php

namespace App\Core;

class FlashMessages
{
    public static function set($type, $message)
    {
        $_SESSION['flash_messages'][$type] = $message;
    }

    public static function display()
    {
        if (isset($_SESSION['flash_messages'])) {
            foreach ($_SESSION['flash_messages'] as $type => $message) {
                echo "<div class='alert alert-$type' role='alert'>$message</div>";
            }
            unset($_SESSION['flash_messages']);
        }
    }
}
