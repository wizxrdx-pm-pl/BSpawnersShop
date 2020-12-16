<?php

declare(strict_types=1);

namespace TheCoolWizard\BSpawnersShop;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\item\Item;
use pocketmine\utils\Config;
use TheCoolWizard\BSpawnersShop\utils\Utils;
use TheCoolWizard\BSpawnersShop\commands\BSpawnersCommand;
use Heisenburger69\BurgerSpawners\Main as BurgerSpawners;
use onebone\economyapi\EconomyAPI;

class Main extends pluginBase {

    public function onEnable() : void {
        $this->saveResource("messages.yml");
        $this->messages = new Config($this->getDataFolder() . "messages.yml");
        $this->saveDefaultConfig();
        $this->getServer()->getCommandMap()->register("spawnersshop", new BSpawnersCommand($this));
    }
    
    public function getRandomWeightedElement(int $max): int {
        return intval(floor(1 + pow(lcg_value(), $this->getConfig()->getNested('chance.gamma', 1.5)) * $max));
    }

    public function getColorFromRarity(string $rarity) : string {
        return Utils::getTFConstFromString($this->getConfig()->getNested("rarity-colors." . strtolower($rarity)));
    }
    
    public function getSpawnersByRarity(string $rarity) : array {
        return $this->getConfig()->getNested("rewards." . strtolower($rarity), []);
    }

    public function getRarity() : array {
        return Utils::RARITY_NAMES;
    }
    
    public function getEconomyProvider() : EconomyAPI {
        return EconomyAPI::getInstance();
    }

    public function getSpawner(String $spawner) : Item {
        return BurgerSpawners::getInstance()->getSpawner($spawner, 1);
    }

    public function getMessage(string $key, Array $tags = []) : string {
        return Utils::translateColorTags(str_replace(array_keys($tags), $tags, $this->messages->getNested($key, $key)));
    }

}