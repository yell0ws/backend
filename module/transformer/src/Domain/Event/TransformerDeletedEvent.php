<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Transformer\Domain\Event;

use Ergonode\Core\Domain\Entity\AbstractId;
use Ergonode\EventSourcing\Infrastructure\AbstractDeleteEvent;
use Ergonode\Transformer\Domain\Entity\TransformerId;
use JMS\Serializer\Annotation as JMS;

/**
 */
class TransformerDeletedEvent extends AbstractDeleteEvent
{
    /**
     * @var TransformerId
     *
     * @JMS\Type("Ergonode\Transformer\Domain\Entity\TransformerId")
     */
    private TransformerId $id;

    /**
     * @param TransformerId $id
     */
    public function __construct(TransformerId $id)
    {
        $this->id = $id;
    }

    /**
     * @return AbstractId
     */
    public function getAggregateId(): AbstractId
    {
        return $this->id;
    }
}
