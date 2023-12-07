<?php

namespace Terpz710\AreaProtectorPE\Forms;

use pocketmine\form\Form;
use pocketmine\player\Player;

use Terpz710\AreaProtectorPE\ProtectArea;
use Terpz710\AreaProtectorPE\Utils\Utils;

class ListForm implements Form
{
    private array $labelMap = [];
    protected array $data = [];
    private ?\Closure $callable;

    public function __construct()
    {
        $this->initText();
        $this->data["type"] = "form";
        $this->callable = function (Player $player, string $data = null) {
            if (is_null($data)) return;

            $player->sendForm(new EditForm($data));
        };
    }

    public function processData(&$data): void
    {
        $data = $this->labelMap[$data] ?? null;
    }

    public function handleResponse(Player $player, $data): void
    {
        $this->processData($data);
        $callable = $this->callable;
        $callable($player, $data);
    }

    public function initText(): void
    {
        $this->data["title"] = $this->data["title"] ?? Utils::getConfigReplace("title") ?: "";
        $this->data["content"] = Utils::getConfigReplace("content");

        foreach (ProtectArea::getInstance()->getProtectAreaAPI()->getAllArea() as $area) {
            $this->data["buttons"][] = ["text" => Utils::getConfigReplace("button_area", "{area}", $area)];
            $this->labelMap[] = $area;
        }
    }

    public function jsonSerialize(): array
    {
        return $this->data;
    }
}
