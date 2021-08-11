<?php 

namespace myitem;

use pocketmine\plugin\PluginBase as PB;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\event\Listener;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\Enchantment;

use pocketmine\item\Item;
use pocketmine\command\PluginCommand;
use pocketmine\inventory\Inventory;
class MyItem extends PB implements Listener{

	public $enchant;

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->enchant = ["0: Protection","1:Fire Protection","2:Feather Falling","3:Blast Protection","4:Projectile Protection","5:Thorns","6:Respiration","7:Depth Strider","8:Aqua Affinity","9:Sharpness","10:Smite","11:Bane of Athropods","12:Knockback","13:Fire Aspect","14:Looting","15:Efficiency","16:Silk Touch","17:Unbreaking","18:Fortune","19:Power","20:Punch","21:Flame","22:Infinity","23:Luck of the Sea",
"24:Lure"];
	}
	public function onCommand(CommandSender $s, Command $cmd, String $label, Array $args): bool{
		if($cmd->getName() == "setname"){
			if(!$s->hasPermission("setname.command")){
				$s->sendMessage("§cYou do not have permission to use this command!");
				return true;
			}
			$name = $s->getName();
		   $text = implode(" ", $args);
		   $item = $s->getInventory()->getItemInHand();
		   $item->setCustomname($text);
		   $s->getInventory()->setItemInHand($item);
		   $s->sendMessage("§6[§aMyItem§6]: §7Change custom name succeed");
		}
		if($cmd->getName() == "setlore"){
			if(!$s->hasPermission("setlore.command")){
				$s->sendMessage("§cYou do not have permission to use this command!");
				return true;
			}
		   $name = $s->getName();
		   $item = $s->getInventory()->getItemInHand();
		   $lore = implode(" ", $args);
		   $lore = explode("\\n",$lore);
		   $item->setLore($lore);
		   $s->getInventory()->setItemInHand($item);
		   $s->sendMessage("§6[§aMyItem§6]: §7Change lore succeed");
		}
		if($cmd->getName() == "addench"){
			if(!$s->hasPermission("addench.command")){
				$s->sendMessage("§cYou do not have permission to use this command!");
				return true;
			}
	if(isset($args[0]) && isset($args[1])) {				  
				if(is_numeric($args[0])) {					  
					if(is_numeric($args[1])) {						  
							$enchantLevel = $args[1];
							$enchantId = $args[0];
							$enchantment = Enchantment::getEnchantment($enchantId);
							if($args[0] == 9 || $args[0] == 10){
		   if($args[1] > 3){
		 $s->sendMessage("§6[§aMyItem§6] §cMax level of sharpness and smite is 3.");
		 return true;
			}
			}
			
							if(empty($enchantment)){								
								$enchantment = Enchantment::getEnchantmentByName($enchantId);								
								if(empty($enchantment)){
									$s->sendMessage("§6[§aMyItem§6] §cEnchant does not exist");
									return true;
								}
							}
							
							$id = $enchantment->getId();
							$maxLevel = 5;
							
							if($enchantLevel > $maxLevel or $enchantLevel <= 0){
								$s->sendMessage("§6[§aMyItem§6] §cMax level enchant is:". $maxLevel);
								return true;
							}
							
							$instance = new EnchantmentInstance($enchantment, $enchantLevel);
							$item = $s->getInventory()->getItemInHand();
							if($item->getId() <= 0){
								$s->sendMessage("§6[§aMyItem§6] §cPlease pick up the item to enchant");
								return true;
							}
							$item->addEnchantment($instance);
							$s->getInventory()->setItemInHand($item);
							
							$s->sendMessage("§6[§aMyItem§6] §aEnchant success");
							return true;
					} else {
						$s->sendMessage("§6[§aMyItem§6] §cLevel must is number");
						return false;
						}
				  
			  } else {
				  $s->sendMessage("§6[§aMyItem§6] §cID enchant must is number /listench to open list id enchant.");
				 return false;
			  }
			} else {
				$s->sendMessage("§6[§aMyItem§6] §cUsage: /addench <id enchant> <level>.");
				return false;
			}
		}

		if($cmd->getName() == "listench"){
			if(!$s->hasPermission("listench.command")){
				$s->sendMessage("§cYou do not have permission to use this command!");
				return true;
			}
 if(isset($args[0])) {

			 			  $pages = array_chunk($this->enchant, 5);
			  if($args[0] <= count($pages) || $args[0] < 1) {
				  
			  
			  $s->sendMessage("Page ". $args[0] ."/". count($pages));
			  $s->sendMessage("Name enchant: ID enchant");
			  foreach($pages[$args[0] - 1] as $enchant) {
				  $is = explode(":", $enchant);
				  $s->sendMessage("| ". $is[1] .":". $is[0]);
			  }
			  $s->sendMessage("§6[§aMyItem§6]: §7/addench <ID Enchant> <Level>");
			  return true;
		  } else {
			  $s->sendMessage("§6[§aMyItem§6]: §7This page is not found!");
			  return false;
		  }
		  } else {
			  $s->sendMessage("§6[§aMyItem§6]: §7/listench <page>");
			  return true;
		  }
		}
		return true;
	}
		}
