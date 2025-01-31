<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserVoter extends Voter{
    public const MANAGE = 'manage_users';
//    public const VIEW = 'POST_VIEW';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return $attribute === self::MANAGE;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

//        // ... (check conditions and return true to grant permission) ...
//        switch ($attribute) {
//            case self::EDIT:
//                // logic to determine if the user can EDIT
//                // return true or false
//                break;
//            case self::VIEW:
//                // logic to determine if the user can VIEW
//                // return true or false
//                break;
//        }


        return in_array('ROLE_ADMIN', $user->getRoles());
    }
}
