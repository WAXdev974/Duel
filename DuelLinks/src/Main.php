<?php

/*
 *  __      __                         .___
/  \    /  \_____  ___  ___       __| _/_______  __
\   \/\/   /\__  \ \  \/  /      / __ |/ __ \  \/ /
 \        /  / __ \_>    <      / /_/ \  ___/\   /
  \__/\  /  (____  /__/\_ \_____\____ |\___  >\_/
       \/        \/      \/_____/    \/    \/
 */

declare(strict_types=1);

namespace wax_dev\DuelLinks;

use pocketmine\plugin\PluginBase;
use wax_dev\DuelLinks\Duel\duelPlayer;

class Main extends PluginBase{

    public function onEnable () : void
    {
        $this->getServer ()->getCommandMap ()->registerAll ("Duel", [
            new duelPlayer()
        ]);
        $this->getLogger ()->info("plugin active");
    }
}