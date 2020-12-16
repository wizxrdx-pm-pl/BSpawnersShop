<?php

declare(strict_types=1);

namespace TheCoolWizard\BSpawnersShop\commands;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use jojoe77777\FormAPI\ModalForm;
use jojoe77777\FormAPI\SimpleForm;
use TheCoolWizard\BSpawnersShop\Main;

class BSpawnersCommand extends PluginCommand {

    public function __construct(Main $plugin) {
        parent::__construct("spawnersshop", $plugin);
        $this->setUsage("/spawnersshop");
        $this->setAliases(["spawnshop"]);
        $this->setDescription("Opens BurgersSpawners Shop Menu");
        $this->setPermission("bspawnersshop.spawnersshop");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, String $commandLabel, Array $args) {
        if(!$sender->hasPermission("bspawnersshop.spawnersshop")) {
            $sender->sendMessage("§cInsufficient Permission");
            return false;
        }
        $this->sendShopForm($sender);
    }

    public function sendShopForm($player) {
        $form = new SimpleForm(function (Player $player, ?int $data): void {
            if ($data !== null) {
                $name = $this->plugin->getRarity()[$data];
                $cost = $this->plugin->getConfig()->getNested("cost." . strtolower($name));
                $form = new ModalForm(function (Player $player, ?bool $data) use ($cost, $name): void {
                    if ($data !== null) {
                        if ($data) {
                            $economyProvider = $this->plugin->getEconomyProvider();
                            if ($economyProvider->myMoney($player) < $cost) {
                                $player->sendMessage($this->plugin->getMessage("command.insufficient-funds", ["{AMOUNT}" => round($cost - $economyProvider->myMoney($player), 2, PHP_ROUND_HALF_DOWN)]));
                                return;
                            }
                            $item = $this->plugin->getSpawner($this->plugin->getSpawnersByRarity($name)[array_rand($this->plugin->getSpawnersByRarity($name))]);
                            $inventory = $player->getInventory();
                            if ($inventory->canAddItem($item)) {
                                $economyProvider->reduceMoney($player, $cost);
                                $inventory->addItem($item);
                                return;
                            }
                            $player->sendMessage($this->plugin->getMessage("menu.confirmation.inventory-full"));
                        } else {
                            $this->sendShopForm($player);
                        }
                    }
                });
                $form->setTitle($this->plugin->getMessage("menu.confirmation.title"));
                $form->setContent($this->plugin->getMessage("menu.confirmation.content", ["{RARITY_COLOR}" => $this->plugin->getColorFromRarity($name), "{RARITY}" => $name, "{AMOUNT}" => round($cost, 2, PHP_ROUND_HALF_DOWN)]) . "\nChance to get: " . join(", ", array_unique($this->plugin->getSpawnersByRarity($name))));
                $form->setButton1("Yes");
                $form->setButton2("No");
                $player->sendForm($form);
                return;
            }
        });
        $form->setTitle($this->plugin->getMessage("menu.title"));
        foreach ($this->plugin->getRarity() as $name) {
            $cost = $this->plugin->getConfig()->getNested('cost.' . strtolower($name));
            $form->addButton($this->plugin->getMessage("menu.button", ["{RARITY_COLOR}" => $this->plugin->getColorFromRarity($name), "{RARITY}" => $name, "{AMOUNT}" => round($cost, 2, PHP_ROUND_HALF_DOWN)]));
        }
        $player->sendForm($form);
        return;
    }
}