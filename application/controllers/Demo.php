<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demo extends CI_Controller {

    public function switch_role($role = 'user')
    {
        $allowed = ['admin_dosen', 'user'];
        $role = in_array($role, $allowed) ? $role : 'user';

        setcookie('demo_role', $role, time() + 86400, '/');

        $referer = $_SERVER['HTTP_REFERER'] ?? base_url();
        header('Location: ' . $referer);
        exit;
    }
}
