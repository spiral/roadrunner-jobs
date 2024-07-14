<?php

declare(strict_types=1);

namespace Spiral\RoadRunner\Jobs\Tests\Unit\Queue;

use PHPUnit\Framework\TestCase;
use Spiral\RoadRunner\Jobs\Queue\Driver;
use Spiral\RoadRunner\Jobs\Queue\PubSubCreateInfo;

final class PubSubCreateInfoTest extends TestCase
{
    public function testCreatePubSubCreateInfo(): void
    {
        $pubSubCreateInfo = new PubSubCreateInfo(
            name: 'test_name',
            projectId: 'test_project_id',
            topic: 'test_topic',
            priority: 3,
            deadLetterTopic: 'test_dead_letter_topic',
            maxDeliveryAttempts: 15,
        );

        $this->assertSame(Driver::PubSub, $pubSubCreateInfo->driver);
        $this->assertSame('test_name', $pubSubCreateInfo->name);
        $this->assertSame('test_project_id', $pubSubCreateInfo->projectId);
        $this->assertSame('test_topic', $pubSubCreateInfo->topic);
        $this->assertSame(3, $pubSubCreateInfo->priority);
        $this->assertSame('test_dead_letter_topic', $pubSubCreateInfo->deadLetterTopic);
        $this->assertSame(15, $pubSubCreateInfo->maxDeliveryAttempts);
    }

    public function testCreatePubSubCreateInfoOnlyRequiredData(): void
    {
        $pubSubCreateInfo = new PubSubCreateInfo(
            name: 'test_name',
            projectId: 'test_project_id',
            topic: 'test_topic',
        );

        $this->assertSame(Driver::PubSub, $pubSubCreateInfo->driver);
        $this->assertSame('test_name', $pubSubCreateInfo->name);
        $this->assertSame('test_project_id', $pubSubCreateInfo->projectId);
        $this->assertSame('test_topic', $pubSubCreateInfo->topic);
        $this->assertSame(10, $pubSubCreateInfo->priority);
        $this->assertNull($pubSubCreateInfo->deadLetterTopic);
        $this->assertSame(10, $pubSubCreateInfo->maxDeliveryAttempts);
    }

    public function testToArray(): void
    {
        $pubSubCreateInfo = new PubSubCreateInfo(
            name: 'test_name',
            projectId: 'test_project_id',
            topic: 'test_topic',
            priority: 3,
            deadLetterTopic: 'test_dead_letter_topic',
            maxDeliveryAttempts: 15,
        );

        $expectedArray = [
            'name' => 'test_name',
            'driver' => Driver::PubSub->value,
            'priority' => 3,
            'project_id' => 'test_project_id',
            'topic' => 'test_topic',
            'dead_letter_topic' => 'test_dead_letter_topic',
            'max_delivery_attempts' => 15,
        ];

        $this->assertSame($expectedArray, $pubSubCreateInfo->toArray());
    }

    public function testToArrayOnlyRequiredData(): void
    {
        $pubSubCreateInfo = new PubSubCreateInfo(
            name: 'test_name',
            projectId: 'test_project_id',
            topic: 'test_topic',
        );

        $expectedArray = [
            'name' => 'test_name',
            'driver' => Driver::PubSub->value,
            'priority' => 10,
            'project_id' => 'test_project_id',
            'topic' => 'test_topic',
        ];

        $this->assertSame($expectedArray, $pubSubCreateInfo->toArray());
    }
}
