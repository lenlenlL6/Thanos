<?php

namespace thanos\pmmdst;

use thanos\pmmdst\Thanos;

use pocketmine\scheduler\Task;

class BungtayTask extends Task{
  
  public function __construct(Thanos $main){
    $this->main = $main;
  }
  
  public function onRun($currentTick){
    $this->main->bungtay();
  }
}