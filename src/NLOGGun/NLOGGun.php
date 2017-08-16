<?php

namespace NLOGGun {

	use pocketmine\plugin\PluginBase;
	use pocketmine\event\Listener;
	use pocketmine\event\player\PlayerInteractEvent;
	use pocketmine\level\particle\DustParticle;
	use pocketmine\level\particle\FlameParticle;
																							
	class NLOGGun extends PluginBase implements Listener {
		
		public function onEnable() {
			$this->getServer()->getPluginManager()->registerEvents($this, $this);
		}
		
		public function random() {
				$result = mt_rand() / mt_getrandmax();
				$result = (float) substr($result, 0, 14);
				return $result;
		}
		
		public function onIneract (PlayerInteractEvent $ev) {
			$player = $ev->getPlayer();
			if ($ev->getItem()->getId() === 369) { //블레이즈 막대
				
				$directonVector = $player->getDirectionVector();
				
				for ($i = 0; $i < 20; $i++) {
					$pos = $directonVector->multiply($i)->add($player);
					
					if ($player->getLevel()->getBlockIdAt($pos->x, $pos->y, $pos->z) !== 0) {
						return;
					}
					
					$particle = new DustParticle($pos, 0, 0, 0);
					$player->getLevel()->addParticle($particle);
					
					foreach ($player->getLevel()->getEntities() as $ent) {
						if (!isset($temp)) {
							$temp = $ent;
						}else{
							if ($ent->distance($pos) < $temp->distance($pos)) {
								$temp = $ent;
							}
						}
					}
					
					if ($temp->distance($pos) < 2) {
						for ($a=0; $a<5; $a++) {
							$par = new FlameParticle($pos);
							$par->setComponents(
									$pos->x + (self::random() * 2 - 1) * 3, 
									$pos->y + 0.3, 
									$pos->z + (self::random() * 2 - 1) * 3
							);
							$player->getLevel()->addParticle($par);
						}
					}
				}
			}
		}
		
	}
}
