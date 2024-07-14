<?php

declare(strict_types=1);

namespace Spiral\RoadRunner\Jobs\Queue;

final class PubSubCreateInfo extends CreateInfo
{
    public const MAX_DELIVERY_ATTEMPTS_DEFAULT_VALUE = 10;

    /**
     * @param non-empty-string $name
     * @param non-empty-string $projectId
     * @param non-empty-string $topic
     * @param positive-int $priority
     * @param non-empty-string|null $deadLetterTopic
     * @param positive-int $maxDeliveryAttempts
     */
    public function __construct(
        string $name,
        public readonly string $projectId,
        public readonly string $topic,
        int $priority = self::PRIORITY_DEFAULT_VALUE,
        public readonly ?string $deadLetterTopic = null,
        public readonly int $maxDeliveryAttempts = self::MAX_DELIVERY_ATTEMPTS_DEFAULT_VALUE,
    ) {
        parent::__construct(Driver::PubSub, $name, $priority);
    }

    public function toArray(): array
    {
        $result = \array_merge(parent::toArray(), [
            'project_id' => $this->projectId,
            'topic' => $this->topic,
        ]);

        if (!empty($this->deadLetterTopic)) {
            $result['dead_letter_topic'] = $this->deadLetterTopic;
            $result['max_delivery_attempts'] = $this->maxDeliveryAttempts;
        }

        return $result;
    }
}
