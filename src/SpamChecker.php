<?php

declare(strict_types=1);

namespace App;

use App\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class SpamChecker
{
    private $client;
    private $endpoint;

    public function __construct(HttpClientInterface $httpClient, string $akismetKey)
    {
        $this->client = $httpClient;
        $this->endpoint = \sprintf('https://%s.rest.akismet.com/1.1/comment-check', $akismetKey);
    }

    public function getSpamScore(Comment $comment, array $context): int
    {
        $response = $this->client->request(Request::METHOD_POST, $this->endpoint, [
            'body' => \array_merge($context, [
                'blog' => 'https://my.blog.local',
                'comment_type' => 'comment',
                'comment_author' => $comment->getAuthor(),
                'comment_author_email' => $comment->getEmail(),
                'comment_content' => $comment->getText(),
                'comment_date_gtm' => $comment->getCreatedAt()->format('c'),
                'blog_lang' => 'en',
                'blog_charset' => 'UTF-8',
                'is_test' => true,
            ]),
        ]);
        $headers = $response->getHeaders();
        if ('discard' === ($headers['x-akismet-pro-tip'][0] ?? '')) {
            return 2;
        }
        $content = $response->getContent();
        if (isset($headers['x-akismet-debug-help'][0])) {
            throw new \RuntimeException(\sprintf('Unable to check for spam: %s (%s).', $content, $headers['x-akismet-debug-help'][0]));
        }

        return 'true' === $content ? 1 : 0;
    }
}
