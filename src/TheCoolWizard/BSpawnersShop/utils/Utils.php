<?php

declare(strict_types=1);

namespace TheCoolWizard\BSpawnersShop\utils;

use pocketmine\utils\TextFormat;

class Utils {

    const RARITY_NAMES = [
        "Common",
        "Uncommon",
        "Rare",
        "Mythic"
    ];

    public static function translateColorTags(string $message): string {
        $replacements = [
            "{BLACK}" => TextFormat::BLACK,
            "{DARK_BLUE}" => TextFormat::DARK_BLUE,
            "{DARK_GREEN}" => TextFormat::DARK_GREEN,
            "{DARK_AQUA}" => TextFormat::DARK_AQUA,
            "{DARK_RED}" => TextFormat::DARK_RED,
            "{DARK_PURPLE}" => TextFormat::DARK_PURPLE,
            "{GOLD}" => TextFormat::GOLD,
            "{GRAY}" => TextFormat::GRAY,
            "{DARK_GRAY}" => TextFormat::DARK_GRAY,
            "{BLUE}" => TextFormat::BLUE,
            "{GREEN}" => TextFormat::GREEN,
            "{AQUA}" => TextFormat::AQUA,
            "{RED}" => TextFormat::RED,
            "{LIGHT_PURPLE}" => TextFormat::LIGHT_PURPLE,
            "{YELLOW}" => TextFormat::YELLOW,
            "{WHITE}" => TextFormat::WHITE,
            "{OBFUSCATED}" => TextFormat::OBFUSCATED,
            "{BOLD}" => TextFormat::BOLD,
            "{STRIKETHROUGH}" => TextFormat::STRIKETHROUGH,
            "{UNDERLINE}" => TextFormat::UNDERLINE,
            "{ITALIC}" => TextFormat::ITALIC,
            "{RESET}" => TextFormat::RESET,
            "{NEWLINE}" => TextFormat::EOL
        ];
        return str_replace(array_keys($replacements), $replacements, $message);
    }

    public static function getTFConstFromString(string $color): string {
        $colorConversionTable = [
            "BLACK" => TextFormat::BLACK,
            "DARK_BLUE" => TextFormat::DARK_BLUE,
            "DARK_GREEN" => TextFormat::DARK_GREEN,
            "DARK_AQUA" => TextFormat::DARK_AQUA,
            "DARK_RED" => TextFormat::DARK_RED,
            "DARK_PURPLE" => TextFormat::DARK_PURPLE,
            "GOLD" => TextFormat::GOLD,
            "GRAY" => TextFormat::GRAY,
            "DARK_GRAY" => TextFormat::DARK_GRAY,
            "BLUE" => TextFormat::BLUE,
            "GREEN" => TextFormat::GREEN,
            "AQUA" => TextFormat::AQUA,
            "RED" => TextFormat::RED,
            "LIGHT_PURPLE" => TextFormat::LIGHT_PURPLE,
            "YELLOW" => TextFormat::YELLOW,
            "WHITE" => TextFormat::WHITE
        ];
        return $colorConversionTable[strtoupper($color)] ?? TextFormat::GRAY;
    }

}