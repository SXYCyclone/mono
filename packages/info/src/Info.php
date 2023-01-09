<?php

declare(strict_types=1);

namespace Cyclone\Info;

use Cyclone\Extend\Annotations\CycloneCommand;
use Cyclone\Extend\CyclonePlugin;

class Info extends CyclonePlugin
{
    #[CycloneCommand('user <user>')]
    public function showUserInfo(): void
    {
        // do something
    }

    #[CycloneCommand('avatar <target>')]
    public function showAvatar(): void
    {
        // do something
    }

    #[CycloneCommand('guild')]
    public function showGuildInfo(): void
    {
        // do something
    }

    #[CycloneCommand('roles <target>')]
    public function showRoles(): void
    {
        // do something
    }
}
