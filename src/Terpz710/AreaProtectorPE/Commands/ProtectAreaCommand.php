<?php

namespace Terpz710\AreaProtectorPE\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

use Terpz710\AreaProtectorPE\Forms\ProtectAreaForm;
use Terpz710\AreaProtectorPE\Utils\Utils;

class ProtectAreaCommand extends Command
{
    public function __construct(string $name, string $description, array $aliases)
    {
        parent::__construct($name, $description, null, $aliases);
        $this->setPermission("protectorpe.use");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player) {
            if ($sender->hasPermission("protectorpe.use")) {
                $sender->sendForm(new ProtectAreaForm());
            } else $sender->sendMessage(Utils::getConfigReplace("no_permission"));
        }
    }
}