<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See license.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Workflow\Persistence\Dbal\Projector\Workflow;

use Doctrine\DBAL\Connection;
use Ergonode\Workflow\Domain\Entity\StatusId;
use Ergonode\Workflow\Domain\Event\Workflow\WorkflowTransitionAddedEvent;

/**
 */
class WorkflowTransitionAddedEventProjector
{
    private const TABLE = 'workflow_transition';

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(WorkflowTransitionAddedEvent $event): void
    {
        $this->connection->insert(
            self::TABLE,
            [
                'workflow_id' => $event->getAggregateId()->getValue(),
                'source_id' => StatusId::fromCode($event->getTransition()->getFrom())->getValue(),
                'destination_id' => StatusId::fromCode($event->getTransition()->getTo())->getValue(),
            ]
        );
    }
}
