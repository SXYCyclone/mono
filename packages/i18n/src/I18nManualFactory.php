<?php

declare(strict_types=1);

namespace Cyclone\I18n;

use ZM\Annotation\OneBot\BotCommand;
use ZM\Annotation\OneBot\CommandArgument;
use ZM\Annotation\OneBot\CommandHelp;
use ZM\Context\BotContext;
use ZM\Plugin\CommandManual\StaticManualFactory;

class I18nManualFactory extends StaticManualFactory
{
    public function __construct(
        private TranslationProvider $translations,
        private LocaleDecider $decider,
    ) {
        parent::__construct();
    }

    public function make(BotCommand $command, array $template, array $adjacent_annotations, BotContext $context): string
    {
        $locale = $this->decider->decideFromBotContext($context);
        $this->translations->setLocale($locale);

        // translate header in template
        foreach ($template as $key => $item) {
            if ($item['header'] !== false) {
                $template[$key]['header'] = $this->translations->get($item['header']);
            }
        }
        return $this->__invoke($command, $template, $adjacent_annotations);
    }

    protected function getSectionContent(BotCommand $command, string $type, CommandHelp $help): string
    {
        switch ($type) {
            case 'command':
                return $command->name;
            case 'description':
                return $this->translations->get($help->description);
            case 'usage':
                return $this->translations->get($help->usage);
            case 'arguments':
                $ret = '';
                foreach ($command->getArguments() as $argument) {
                    /* @var CommandArgument $argument */
                    $ret .= $argument->name . ' - ' . $this->translations->get($argument->description) . PHP_EOL;
                }
                return $ret;
            case 'examples':
                return $this->translations->get($help->example);
            default:
                return '';
        }
    }
}
