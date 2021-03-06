<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Tests\Condition\Domain\Command;

use Ergonode\Condition\Domain\Command\UpdateConditionSetCommand;
use Ergonode\Condition\Domain\ConditionInterface;
use Ergonode\Condition\Domain\Entity\ConditionSetId;
use PHPUnit\Framework\TestCase;

/**
 */
class UpdateConditionSetCommandTest extends TestCase
{
    /**
     * @param ConditionSetId $id
     * @param array          $conditions
     *
     * @dataProvider dataProvider
     */
    public function testUpdateSetCommand(ConditionSetId $id, array $conditions): void
    {
        $command = new UpdateConditionSetCommand($id, $conditions);

        $this->assertSame($id, $command->getId());
        $this->assertSame($conditions, $command->getConditions());
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            [
                $this->createMock(ConditionSetId::class),
                [],
            ],
            [
                $this->createMock(ConditionSetId::class),
                [$this->createMock(ConditionInterface::class)],
            ],
        ];
    }
}
