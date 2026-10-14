<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('is_admin_or_dosen')) {
    function is_admin_or_dosen()
    {
        return isset($_COOKIE['demo_role']) && $_COOKIE['demo_role'] === 'admin_dosen';
    }
}
