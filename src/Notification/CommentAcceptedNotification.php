<?php

namespace App\Notification;

use App\Entity\Comment;
use Symfony\Component\Notifier\Message\EmailMessage;
use Symfony\Component\Notifier\Notification\EmailNotificationInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\EmailRecipientInterface;

class CommentAcceptedNotification extends Notification implements EmailNotificationInterface
{
    private Comment $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
        $this->importance(Notification::IMPORTANCE_LOW);

        parent::__construct('Your comment accepted');
    }

    public function asEmailMessage(EmailRecipientInterface $recipient, string $transport = null): ?EmailMessage
    {
        $message = EmailMessage::fromNotification($this, $recipient);
        $message->getMessage()
            ->htmlTemplate('emails/comment_accepted_notification.html.twig')
            ->context(
                [
                    'comment' => $this->comment,
                ]
            );

        return $message;
    }
}
