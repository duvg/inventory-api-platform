<?php

declare(strict_types=1);

namespace Mailer\Messenger\Handler;

use Mailer\Messenger\Message\GroupRequestMessage;
use Mailer\Service\Mailer\ClientRoute;
use Mailer\Service\Mailer\MailerService;
use Mailer\Templating\TwigTemplate;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GroupRequestMessageHandler implements MessageHandlerInterface
{

    private MailerService $mailerService;
    private string $host;

    public function __construct (MailerService $mailerService, string $host)
    {
        $this->mailerService = $mailerService;
        $this->host = $host;
    }

    /**
     * @param GroupRequestMessage $message
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke (GroupRequestMessage $message): void
    {
        $payload = [
            'requesterName' => $message->getRequesterName(),
            'groupName' => $message->getGroupName(),
            'url' => \sprintf(
                '%s/%s?groupId=%s&userId=%s&token=%s',
                $this->host,
                ClientRoute::GROUP_REQUEST,
                $message->getGroupId(),
                $message->getUserId(),
                $message->getToken()
            )
        ];

        $this->mailerService->send($message->getEmail(), TwigTemplate::GROUP_REQUEST, $payload );

    }
}