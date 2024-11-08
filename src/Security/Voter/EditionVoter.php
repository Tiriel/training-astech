<?php

namespace App\Security\Voter;

use App\Entity\Event;
use App\Entity\Project;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class EditionVoter extends Voter
{
    public const EVENT = 'event.edition';
    public const PROJECT = 'project.edition';

    public function __construct(
        protected readonly AuthorizationCheckerInterface $checker,
    ) {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return \in_array($attribute, [self::EVENT, self::PROJECT])
            && ($subject instanceof Event || $subject instanceof Project);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        if ($this->checker->isGranted('ROLE_WEBSITE')) {
            return true;
        }

        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }

        /** @var Event|Project $subject */
        foreach ($subject->getOrganizations() as $organization) {
            if ($user->getOrganizations()->contains($organization)) {
                return true;
            }
        }

        return $user === $subject->getCreatedBy();
    }
}
