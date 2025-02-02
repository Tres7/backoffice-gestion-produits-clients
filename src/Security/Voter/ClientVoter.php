<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class ClientVoter extends Voter{
    public const EDIT = 'EDIT_CLIENT';
    public const VIEW = 'VIEW_CLIENT';
    public const CREATE = 'CREATE_CLIENT';

    public const DELETE = 'DELETE_CLIENT';


    protected function supports(string $attribute, mixed $subject): bool
    {
        //self::CREATE not depend on a specific product
        if ($attribute === self::VIEW || $attribute === self::CREATE) {
            return true;
        }
        return in_array($attribute, [self::EDIT, self::CREATE, self::DELETE], true)
            && $subject instanceof \App\Entity\Client;

    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::VIEW:
            case self::EDIT:
            case self::CREATE:
            case self::DELETE:
                return in_array('ROLE_ADMIN', $user->getRoles()) || in_array('ROLE_MANAGER', $user->getRoles());
        }


        return false;
    }

}
