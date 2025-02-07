<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserVoter extends Voter{
    public const VIEW = 'VIEW_USER';
    public const EDIT = 'EDIT_USER';
    public const CREATE = 'CREATE_USER';
    public const DELETE = 'DELETE_USER';

    protected function supports(string $attribute, mixed $subject): bool
    {
        //self::CREATE not depend on a specific product
        if ($attribute === self::CREATE) {
            return true;
        }
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])
            && $subject instanceof User;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        return in_array('ROLE_ADMIN', $user->getRoles());
    }
}
