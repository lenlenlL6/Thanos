<?php

namespace thanos\pmmdst;

use pocketmine\Server;
use pocketmine\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;

use pocketmine\event\Listener;

use pocketmine\event\player\PlayerInteractEvent;

use pocketmine\event\block\BlockBreakEvent;

use pocketmine\item\Item;

use pocketmine\level\Level;

use thanos\pmmdst\BungtayTask;

class Thanos extends PluginBase implements Listener {
  
  public $prefix = "§e【 §cKING OF VICTORY §e】";
  
  public function onEnable(){
    $this->getLogger()->info("Thanos By Pmmdst");
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
  
  public function onDisable(){
    $this->getLogger()->info("Thanos Off :3");
  }
  
  public function onCommand(CommandSender $sender, Command $cmd, String $label, array $args): bool{
    switch($cmd->getName()){
      case "gangtay":
        if($sender instanceof Player){
          if($sender->hasPermission("gangtay.command")){
            $item = Item::get(313, 0, 1);
    $item->setCustomName("§5GĂNG TAY THANOS");
    $item->setLore(["§a♦ §cCHẠM HOẶC GIỮ ĐỂ KÍCH HOẠT §a♦"]);
    $sender->getInventory()->addItem($item);
    $sender->sendMessage($this->prefix . "§a Đã lấy găng tay §5Thanos !");
          }
        }else{
          $sender->sendMessage($this->prefix . "§c Please use this command in game !");
        }
        break;
    }
    return true;
  }
  
  public function bungtay() : void{
    $players = $this->getServer()->getOnlinePlayers();
    $rand = array_rand($players, 1);
    $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "kill " . $players[$rand]->getName());
    $this->getServer()->broadcastMessage($this->prefix . "§e " . $players[$rand]->getName() . "§a đã bị §5Thanos §abúng tay !");
  }
  
  public function onBreak(BlockBreakEvent $event){
    $player = $event->getPlayer();
    $block = $event->getBlock();
    $item = Item::get(313, 0, 1);
    $item->setCustomName("§5GĂNG TAY THANOS");
    $item->setLore(["§a♦ §cCHẠM HOẶC GIỮ ĐỂ KÍCH HOẠT §a♦"]);
    if(!$event->isCancelled()){
    switch(mt_rand(1, 100000)){
      case 86284:
        $player->getLevel()->dropItem($block, $item);
        $this->getServer()->broadcastMessage($this->prefix . "§a Người chơi §e" . $player->getName() . "§a đã đào mine rơi ra găng tay §5Thanos :()");
        break;
    }
    }
  }
  
  public function onInteract(PlayerInteractEvent $event){
    $player = $event->getPlayer();
    $item = $event->getItem();
    if($item->getId() === 313 and $item->getCustomName() === "§5GĂNG TAY THANOS"){
   if(count($this->getServer()->getOnlinePlayers()) >= 2){
     foreach($this->getServer()->getOnlinePlayers() as $p){
       $p->addTitle("§5THANOS", "§eTA LÀ ĐIỀU HIỂN NHIÊN >=(");
     }
     $this->getServer()->broadcastMessage($this->prefix . "§5 THANOS: §eTA LÀ ĐIỀU HIỂN NHIÊN >=(");
      $this->getScheduler()->scheduleDelayedTask(new BungtayTask($this), 100);
   }else{
     $player->sendMessage($this->prefix . "§c Số người chơi phải lớn hơn hoặc bằng 2 mới búng tay được !");
   }
    }
  }
}
