<?php

namespace App\Security\Voter;

use App\Entity\Recette;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\User\UserInterface;

class RecetteVoter extends Voter
{
    const EDIT = 'RECETTE_EDIT';
    const DELETE = 'RECETTE_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof Recette;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        /** @var Recette $recette */
        $recette = $subject;

        if ($recette->getUser() === null) {
            return false;
        }

        return $recette->getUser()->getId() === $user->getId();
    }
}