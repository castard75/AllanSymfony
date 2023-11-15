<?php
namespace App\Security;

use App\Entity\Employees;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof Employees) {
            return;
        }
        if ($user->getDeletedat() != "") {
            throw new CustomUserMessageAuthenticationException(
                'Inactive account cannot log in!'
            );
        }
    }
    public function checkPostAuth(UserInterface $user)
    {
        $this->checkPreAuth($user);
    }
}