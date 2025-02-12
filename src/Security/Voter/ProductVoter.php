<?php

namespace App\Security\Voter;

use App\Entity\Product;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class ProductVoter extends Voter{
    public const VIEW = 'VIEW_PRODUCT';
    public const CREATE = 'CREATE_PRODUCT';
    public const EDIT = 'EDIT_PRODUCT';
    public const DELETE = 'DELETE_PRODUCT';

    protected function supports(string $attribute, mixed $subject): bool
    {
        //self::CREATE not depend on a specific product
        if ($attribute === self::CREATE) {
            return true;
        }

        if ($attribute === self::VIEW) {
            return true;
        }
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::CREATE,self::EDIT, self::DELETE])
            && $subject instanceof Product;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::VIEW:
                return true;
            case self::CREATE:
                return in_array('ROLE_ADMIN', $user->getRoles(), true);
            case self::EDIT:
            case self::DELETE:
                return in_array('ROLE_ADMIN', $user->getRoles()); // Seuls les admins peuvent gérer les produits
        }

        return false;
    }
}
