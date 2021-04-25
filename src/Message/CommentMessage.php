<?php

namespace App\Message;

final class CommentMessage
{
    private int $id;
    private string $reviewUrl;
    private array $context;

    public function __construct(int $id, string $reviewUrl, array $context = [])
    {
        $this->id = $id;
        $this->reviewUrl = $reviewUrl;
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
     * @return string
     */
    public function getReviewUrl(): string
    {
        return $this->reviewUrl;
    }

    /**
     * @return array Message context data
     */
    public function getContext(): array
    {
        return $this->context;
    }
}
