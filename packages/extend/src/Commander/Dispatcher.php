<?php

declare(strict_types=1);

namespace Cyclone\Extend\Commander;

use OneBot\V12\Object\OneBotEvent;
use ZM\Annotation\OneBot\BotEvent;
use ZM\Utils\MessageUtil;

class Dispatcher
{
    #[BotEvent]
    public function dispatch(OneBotEvent $event): void
    {
        if ($event->getType() === 'message') {
            logger()->warning("message: {$event->getMessageString()}");
            $message = $event->getMessageString();
            $segments = MessageUtil::splitMessage($message);
            $name = $segments[0];
            if (($cmd = CommandStore::getCommand($name)) !== null) {
                $arguments = array_slice($segments, 1);
                $arguments = array_values(array_filter($arguments));
                // match the parameters by order
                $argumentIndex = 0;
                $values = [];
                foreach ($cmd->arguments as $argument) {
                    if (!isset($arguments[$argumentIndex]) && $argument->isRequired()) {
                        throw new \RuntimeException('Missing required argument: ' . $argument->getName());
                    }

                    if (isset($arguments[$argumentIndex])) {
                        $values[$argument->getName()] = $arguments[$argumentIndex];
                    }

                    ++$argumentIndex;
                }

                $cmd->handle($values);
            }
        }
    }
}
