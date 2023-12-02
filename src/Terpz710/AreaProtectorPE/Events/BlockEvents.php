<?php

namespace Terpz710\AreaProtectorPE\Events;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;

use Terpz710\AreaProtectorPE\ProtectArea;

class BlockEvents implements Listener
{
    public function onBreak(BlockBreakEvent $event): void
    {
        $player = $event->getPlayer();

        if (ProtectArea::getInstance()->getProtectAreaAPI()->cancel($event->getPlayer(), "break", $player->getPosition())) {
            $event->cancel();
        }
    }

    public function onPlace(BlockPlaceEvent $event): void
    {
        $block = $event->getBlockAgainst();

        if (ProtectArea::getInstance()->getProtectAreaAPI()->cancel($event->getPlayer(), "place", $event->getBlockAgainst()->getPosition())) $event->cancel();
        }
    }