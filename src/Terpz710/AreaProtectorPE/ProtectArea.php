<?php

namespace Terpz710\AreaProtectorPE;

use JsonException;
use pocketmine\plugin\PluginBase;

use Terpz710\AreaProtectorPE\API\ProtectAreaAPI;
use Terpz710\AreaProtectorPE\Commands\ProtectAreaCommand;
use Terpz710\AreaProtectorPE\Events\BlockEvents;
use Terpz710\AreaProtectorPE\Events\EntityEvents;
use Terpz710\AreaProtectorPE\Events\PlayerEvents;
use Terpz710\AreaProtectorPE\Utils\Utils;

class ProtectArea extends PluginBase
{
    private ProtectAreaAPI $protectAreaAPI;
    private static self $this;

    public function onEnable(): void
    {
        self::$this = $this;
        $this->protectAreaAPI = new ProtectAreaAPI();

        foreach (
            [
                new BlockEvents(),
                new PlayerEvents(),
                new EntityEvents()
            ] as $event) {
            $this->getServer()->getPluginManager()->registerEvents($event, $this);
        }

        $this->getServer()->getCommandMap()->register("ProtectAreaCommand",
            new ProtectAreaCommand(
                Utils::getConfigValue("command")[0] ?? "protectarea",
                Utils::getConfigValue("command")[1] ?? "ProtectArea Command",
                Utils::getConfigValue("commandAliases") ?? [],
            )
        );
    }

    /**
     * @throws JsonException
     */
    public function onDisable(): void
    {
        $this->protectAreaAPI->save();
    }

    public function getProtectAreaAPI(): ProtectAreaAPI
    {
        return $this->protectAreaAPI;
    }

    public static function getInstance(): self
    {
        return self::$this;
    }
}