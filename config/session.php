<?php
class Session {
    public static function init(){
        session_start();
    }
    public static function set($key, $val){
        $_SESSION[$key] = $val;
    }
    public static function get($key){
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }

    public static function checkLogged(){
        self::init();
        if (self::get("authUser")) {
            header("Location:/admin/");
        }
    }

    public static function checkSession(){
        self::init();
        if (!self::get("authUser")) {
            header("Location:/admin/login.php");
        }
        elseif(self::get('authUser')['role'] == 2){
            self::destroy();
            header("Location:/");
        }
    }
    public static function destroy(){
        session_destroy();
        header("Location: /admin/login.php");
    }
    public static function unsetSession($key){
        unset($_SESSION[$key]);
    }
}
