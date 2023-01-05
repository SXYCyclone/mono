<?php

declare(strict_types=1);

namespace Cyclone\Info;

use Cyclone\Extend\CyclonePlugin;
use ZM\Annotation\OneBot\BotCommand;
use ZM\Annotation\OneBot\CommandArgument;
use ZM\Annotation\OneBot\CommandHelp;

class Info extends CyclonePlugin
{
    #[BotCommand('user', 'user')]
    #[CommandArgument('user', 'cmd.user.arg.user')]
    #[CommandHelp('cmd.user.help.desc', 'cmd.user.help.usage', 'cmd.user.help.example')]
    public function showUserInfo(): void
    {
        // do something
    }

    #[BotCommand('avatar', 'avatar')]
    #[CommandArgument('target', 'cmd.avatar.arg.target')]
    #[CommandHelp('cmd.avatar.help.desc', 'cmd.avatar.help.usage', 'cmd.avatar.help.example')]
    public function showAvatar(): void
    {
        // do something
    }

    #[BotCommand('guild', 'guild')]
    #[CommandHelp('cmd.guild.help.desc', 'cmd.guild.help.usage', 'cmd.guild.help.example')]
    public function showGuildInfo(): void
    {
        // do something
    }

    #[BotCommand('roles', 'roles')]
    #[CommandHelp('cmd.roles.help.desc', 'cmd.roles.help.usage', 'cmd.roles.help.example')]
    public function showRoles(): void
    {
        // do something
    }
}
