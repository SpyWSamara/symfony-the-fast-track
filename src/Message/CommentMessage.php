<?php

namespace App\Message;

final class CommentMessage
{
    private int $id;
    private array $context;

    public function __construct(int $id, array $context = [])
    {
        $this->id = $id;
        $this->context = $context;
    }

    /**
     * @return int Message id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return array Message context data
     */
    public function getContext(): array
    {
        return $this->context;
    }
}
