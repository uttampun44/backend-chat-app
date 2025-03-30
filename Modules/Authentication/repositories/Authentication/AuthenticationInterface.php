<?php
namespace Modules\Authentication\Repositories\Authentication;

interface AuthenticationInterface
{
    public function userPostLogin();

    public function userPostSignup();

    public function userPostLogout();

    public function userPostResetPassword();
}