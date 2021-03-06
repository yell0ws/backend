<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Account\Tests\Infrastructure\JMS\Serializer\Handler;

use Ergonode\Account\Domain\ValueObject\Email;
use Ergonode\Account\Infrastructure\JMS\Serializer\Handler\EmailHandler;
use JMS\Serializer\Context;
use JMS\Serializer\Visitor\DeserializationVisitorInterface;
use JMS\Serializer\Visitor\SerializationVisitorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 */
class EmailHandlerTest extends TestCase
{
    /**
     * @var EmailHandler
     */
    private $handler;

    /**
     * @var SerializationVisitorInterface
     */
    private $serializerVisitor;

    /**
     * @var DeserializationVisitorInterface
     */
    private $deserializerVisitor;

    /**
     * @var Context
     */
    private $context;

    /**
     */
    protected function setUp(): void
    {
        $this->handler = new EmailHandler();
        $this->serializerVisitor = $this->createMock(SerializationVisitorInterface::class);
        $this->deserializerVisitor = $this->createMock(DeserializationVisitorInterface::class);
        $this->context = $this->createMock(Context::class);
    }

    /**
     */
    public function testConfiguration(): void
    {
        $configurations = EmailHandler::getSubscribingMethods();
        foreach ($configurations as $configuration) {
            $this->assertArrayHasKey('direction', $configuration);
            $this->assertArrayHasKey('type', $configuration);
            $this->assertArrayHasKey('format', $configuration);
            $this->assertArrayHasKey('method', $configuration);
        }
    }

    /**
     */
    public function testSerialize(): void
    {
        $value = 'test@ergonode.com';

        /** @var Email|MockObject $code */
        $code = $this->createMock(Email::class);
        $code->method('getValue')->willReturn($value);
        $result = $this->handler->serialize($this->serializerVisitor, $code, [], $this->context);

        $this->assertEquals($value, $result);
    }

    /**
     */
    public function testDeserialize(): void
    {
        $value = 'test@ergonode.com';

        $result = $this->handler->deserialize($this->deserializerVisitor, $value, [], $this->context);

        $this->assertInstanceOf(Email::class, $result);
        $this->assertEquals($value, $result->getValue());
    }
}
