<?php

namespace App\Controller;

use App\Helper\LoggerTrait;
use Nexy\Slack\Client;
use Psr\Log\LoggerInterface;

class SlackClient
{
    use LoggerTrait;

    /**
     * @var Client
     */
    private $slack;

    /**
     * @var LoggerInterface|null
     */
    private $logger;

    /**
     * SlackClient constructor.
     *
     * @param Client $slack
     */
    public function __construct(Client $slack)
    {

        $this->slack = $slack;
    }

    /**
     * @param LoggerInterface $logger
     *
     * @required
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function sendMessage(string $from, string $message)
    {
        $this->logInfo('Send to Slack', [
            'message' => $message
        ]);

        $slackMessage = $this->slack->createMessage();
        $slackMessage
            ->from($from)
            ->withIcon(':ghost:')
            ->setText($message)
        ;

        $this->slack->sendMessage($slackMessage);
    }


}