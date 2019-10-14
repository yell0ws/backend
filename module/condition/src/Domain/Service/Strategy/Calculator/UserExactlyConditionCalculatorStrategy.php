<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Condition\Domain\Service\Strategy\Calculator;

use Ergonode\Account\Domain\Repository\UserRepositoryInterface;
use Ergonode\Condition\Domain\Condition\ConditionInterface;
use Ergonode\Condition\Domain\Condition\UserExactlyCondition;
use Ergonode\Condition\Domain\Service\ConditionCalculatorStrategyInterface;
use Ergonode\Core\Application\Provider\AuthenticatedUserProviderInterface;
use Ergonode\Product\Domain\Entity\AbstractProduct;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Webmozart\Assert\Assert;

/**
 */
class UserExactlyConditionCalculatorStrategy implements ConditionCalculatorStrategyInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var AuthenticatedUserProviderInterface
     */
    private $authenticatedUserProvider;

    /**
     * @param UserRepositoryInterface            $userRepository
     * @param AuthenticatedUserProviderInterface $authenticatedUserProvider
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        AuthenticatedUserProviderInterface $authenticatedUserProvider
    ) {
        $this->userRepository = $userRepository;
        $this->authenticatedUserProvider = $authenticatedUserProvider;
    }

    /**
     * {@inheritDoc}
     */
    public function supports(string $type): bool
    {
        return UserExactlyCondition::TYPE === $type;
    }

    /**
     * {@inheritDoc}
     *
     * @throws \Exception
     */
    public function calculate(AbstractProduct $object, ConditionInterface $configuration): bool
    {
        $user = $this->userRepository->load($configuration->getUser());
        Assert::notNull($user);

        try {
            $authenticatedUser = $this->authenticatedUserProvider->provide();

            $result = false;
            if ($authenticatedUser->getId() === $user->getId()) {
                $result = true;
            }
        } catch (AuthenticationException $exception) {
            $result = true;
        }

        return $result;
    }
}
