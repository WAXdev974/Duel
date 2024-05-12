<?php

declare(strict_types=1);

namespace wax_dev\DuelLinks\Duel;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\math\Vector3;
use wax_dev\DuelLinks\forms\elements\Image;
use wax_dev\DuelLinks\forms\MenuForm;
use wax_dev\DuelLinks\forms\elements\Button;
use pocketmine\level\Position;

class duelPlayer extends Command{


    public function __construct()
    {
        parent::__construct("duel", "permet de lancer un duel", "/duel", ["dl"]);
        $this->setPermission("duel.cmd");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player){
            $this->DuelMenu($sender);
            return;
        }
    }

    private function DuelMenu(Player $player): void{
        $duelList = [
            new Button("§e§lGold", new Image("textures/items/gold_sword", Image::TYPE_PATH), 0),
            new Button("§b§lDiamond", new Image("textures/items/diamond_sword", Image::TYPE_PATH), 1)
        ];

        $duelMenuTeams = new MenuForm("Duel", "Choix D'équipe", $duelList, function (Player $player, Button $button): void{
            switch ($button->getValue()){
                case 0:
                    $this->GoldTeams($player);
                    $player->sendMessage("§aVous avez sélectionné la §e§lteam Gold");
                    break;
                case 1:
                    $this->DiamondTeams($player);
                    $player->sendMessage("§aVous avez sélectionné la §b§lteam Diamond");
                    break;
            }
        });
        $player->sendForm($duelMenuTeams);
    }

    private function GoldTeams(Player $player): void{
        $goldPlayerPositions = [
            "Joueur 1" => $this->getGoldPlayer1Position(),
            "Joueur 2" => $this->getGoldPlayer2Position()
        ];

        $goldList = [];
        foreach($goldPlayerPositions as $playerName => $position){
            $goldList[] = new Button("§f§l".$playerName, null, $playerName);
        }

        $goldTeam = new MenuForm("§e§lGold Team", "List Joueur", $goldList, function (Player $player, Button $button) use ($goldPlayerPositions): void{
            $playerName = $button->getValue();
            if(isset($goldPlayerPositions[$playerName])){
                $this->teleportPlayer($player, $goldPlayerPositions[$playerName]);
            }else{
                $player->sendMessage("§cErreur de téléportation : joueur non trouvé.");
            }
        });
        $player->sendForm($goldTeam);
    }

    private function DiamondTeams(Player $player): void{
        $diamondPlayerPositions = [
            "Joueur 1" => $this->getDiamondPlayer1Position(),
            "Joueur 2" => $this->getDiamondPlayer2Position()
        ];

        $diamondList = [];
        foreach($diamondPlayerPositions as $playerName => $position){
            $diamondList[] = new Button("§f§l".$playerName, null, $playerName);
        }

        $diamondTeam = new MenuForm("§b§lDiamond Team", "List Joueur", $diamondList, function (Player $player, Button $button) use ($diamondPlayerPositions): void{
            $playerName = $button->getValue();
            if(isset($diamondPlayerPositions[$playerName])){
                $this->teleportPlayer($player, $diamondPlayerPositions[$playerName]);
            }else{
                $player->sendMessage("§cErreur de téléportation : joueur non trouvé.");
            }
        });
        $player->sendForm($diamondTeam);
    }

    private function teleportPlayer(Player $player, array $position): void{
        $x = $position["x"] ?? null;
        $y = $position["y"] ?? null;
        $z = $position["z"] ?? null;

        if($player instanceof Player && $x !== null && $y !== null && $z !== null){
            $level = $player->getLevel();
            $player->teleport(new Position($x, $y, $z, $level));
        } else {
            $player->sendMessage("§cErreur de téléportation : coordonnées invalides.");
        }
    }




    private function getGoldPlayer1Position(): array{
        return ["x" => 100, "y" => 64, "z" => 200];
    }

    private function getGoldPlayer2Position(): array{
        return ["x" => 150, "y" => 64, "z" => 250];
    }

    private function getDiamondPlayer1Position(): array{
        return ["x" => 200, "y" => 64, "z" => 300];
    }

    private function getDiamondPlayer2Position(): array{
        return ["x" => 250, "y" => 64, "z" => 350];
    }
}
