<?php

namespace CC\CrazyNPC;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\entity\Entity;
use pocketmine\plugin\PluginBase;
use pocketmine\item\Item;
use pocketmine\network\protocol\Info as PInfo;
//NBT Tag type
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\nbt\tag\StringTag;
use CC\CrazyNPC\Entities\CrazyEntity;
use CC\CrazyNPC\Entities\CrazyHuman;
//Events
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;

class CrazyNPC extends PluginBase implements Listener
{
	const VERSION = "1.0.0";
	const NAME = "CrazyNPC";
	const TYPES = [
		"Chicken", "Pig", "Sheep", "Cow",
		"MushroomCow", "Wolf", "Enderman", "Spider",
		"Skeleton", "PigZombie", "Creeper", "Slime",
		"Silverfish", "Villager", "Zombie", "Human",
		"Bat", "CaveSpider", "LavaSlime", "Ghast",
		"Ocelot", "Blaze", "ZombieVillager", "Snowman",
		"Horse", "Donkey", "Mule", "SkeletonHorse",
		"ZombieHorse", "Witch", "Rabbit", "Stray",
		"Husk", "WitherSkeleton", "IronGolem", "Snowman",
		"MagmaCube", "Squid"
    ];
	public function onEnable()
	{	
		$cc="cnpc";
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
		$this->mainHelp="§6=====CrazyNPC=====\n§a/".$cc." create: §b新建一个NPC\n§a/".$cc." remove: §b移除一个NPC\n§a/".$cc." see: §b查看NPC的id\n§a/".$cc." set <NPC的ID>: §b设置NPC\n§a/".$cc." list: §b显示NPC的ID列表\n§a/".$cc." type: §bNPC类型列表";
	}
	public function registerEntities()
	{
		Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyCreeper::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyBat::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazySheep::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyPigZombie::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyGhast::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyBlaze::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyIronGolem::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazySnowman::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyOcelot::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyZombieVillager::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyHuman::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyVillager::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyZombie::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazySquid::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyCow::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazySpider::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyPig::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyMushroomCow::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyWolf::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyLavaSlime::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazySilverfish::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazySkeleton::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazySlime::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyChicken::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyEnderman::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyCaveSpider::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyHorse::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyDonkey::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyMule::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazySkeletonHorse::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyZombieHorse::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyRabbit::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyWitch::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyStray::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyHusk::class, true);
        Entity::registerEntity( \CC\CrazyNPC\Entities\CrazyWitherSkeleton::class, true);
	}
	public function createNBT($type,$name,$player)
	{
        $nbt = new CompoundTag;
        $nbt->Pos = new ListTag("Pos", [
            new DoubleTag(0, $player->getX()),
            new DoubleTag(1, $player->getY()),
            new DoubleTag(2, $player->getZ())
        ]);
        $nbt->Motion = new ListTag("Motion", [
            new DoubleTag(0, 0),
            new DoubleTag(1, 0),
            new DoubleTag(2, 0)
        ]);
        $nbt->Rotation = new ListTag("Rotation", [
            new FloatTag(0, $player->getYaw()),
            new FloatTag(1, $player->getPitch())
        ]);
        $nbt->Health = new ShortTag("Health", 1);
        $nbt->Commands = new CompoundTag("Commands", []);
        $nbt->MenuName = new StringTag("MenuName", $name);
		//$nbt->NPCVersion = new StringTag("SlapperVersion", "1.3.2");
        if($type === "Human")
		{
            $nbt->Inventory = new ListTag("Inventory", $player->getInventory());
            $nbt->Skin = new CompoundTag("Skin", [
				"Data" => new StringTag("Data", $player->getSkinData()),
				"Name" => new StringTag("Name", $player->getSkinId())
			]);
        }
        return $nbt;
    }
	public function onEntityDamage(EntityDamageEvent $event)
	{
		$entity=$event->getEntity();
		if($entity instanceof CrazyEntity or $entity instanceof CrazyHuman)
		{
			$event->setCancelled(true);
			if(!$event instanceof EntityDamageByEntityEvent)
				return;
			$damager=$event->getDamager();
			if(!$damager instanceof Player)
				return;
			if(isset($this->editMode[$damager->getName()]))
			{
				switch($this->editMode[$damager->getName()])
				{
					case 1:
						$id=$entity->getId();
						$damager->sendMessage("§b实体NPC的ID: ".$id);
						unset($this->editMode[$damager->getName()]);
						return;
				}
			}
			if(!(empty($entity->namedtag->Commands)))
			{
				foreach($entity->namedtag->Commands as $cmd)
				{
					$this->getServer()->dispatchCommand($damager,str_replace("%p",$damager->getName(),$cmd));
				}
			}
		}
	}
	public function onCommand(CommandSender $sender, Command $cmd, $label, array $args)//解析
	{
		switch($cmd->getName())
		{
			case "cnpc":
				$cc="cnpc";
				if(isset($args[0]))
				{
					switch($args[0])
					{
						case "create":
							if($sender instanceof ConsoleCommandSender)
							{
								$sender->sendMessage("§e请在游戏内输入指令！");
								return true;
							}
							if(isset($args[1]) && isset($args[2]))
							{
								$type=$args[1];$name=$args[2];
								if(!in_array($type,self::TYPES))
								{
									$sender->sendMessage("§c[CrazyNPC] 未知的NPC类型！");
									return true;
								}
								$nbt=$this->createNBT($type,$name,$sender);
								if(PInfo::CURRENT_PROTOCOL > 101)
									$entity=Entity::createEntity("Crazy".$type, $sender->getLevel(), $nbt);
								else
									$entity=Entity::createEntity("Crazy".$type, $sender->getLevel()->getChunk($sender->getX() >> 4, $sender->getZ() >> 4), $nbt);
								$entity->setNameTag($name);
								$entity->setNameTagVisible(true);
								if(PInfo::CURRENT_PROTOCOL > 90)
									$entity->setNameTagAlwaysVisible(true);
								$entity->spawnToAll();
								$this->getServer()->dispatchCommand(new ConsoleCommandSender(),"save-all");
								$sender->sendMessage("§a[CrazyNPC] 成功创建NPC, 类型为 $type , 实体动态编号ID为 ".$entity->getId());
								return true;
							}
							else
							{
								$sender->sendMessage("§e[用法] /".$this->cmd." create <NPC类型> <NPC显示名字>");
								return true;
							}
						case "remove":
							if($sender instanceof ConsoleCommandSender)
							{
								$sender->sendMessage("§e请在游戏内输入指令！");
								return true;
							}
							if(isset($args[1]))
							{
								$id=$args[1];
								$level=$sender->level;
								$entity=$level->getEntity($id);
								if($entity === null)
								{
									$sender->sendMessage("§c[CrazyNPC] 对不起，此ID的NPC不存在！");
									return true;
								}
								elseif($entity instanceof CrazyEntity or $entity instanceof CrazyHuman)
								{
									$entity->close();
									$sender->sendMessage("§a[CrazyNPC] 成功移除NPC！");
									return true;
								}
								else
								{
									$sender->sendMessage("§c[CrazyNPC] 对不起，此ID的NPC不存在！");
									return true;
								}
							}
							else
							{
								$sender->sendMessage("§e[用法] /".$this->cmd." remove <NPC的ID>");
								return true;
							}
						case "see":
							if($sender instanceof ConsoleCommandSender)
							{
								$sender->sendMessage("§e请在游戏内输入指令！");
								return true;
							}
							$this->editMode[$sender->getName()]=1;
							$sender->sendMessage("§e[CrazyNPC] 请点击一个NPC");
							return true;
						case "set":
							if(isset($args[1]))
							{
								$id=$args[1];
								$level=$sender->level;
								$entity=$level->getEntity($id);
								if($entity === null)
								{
									$sender->sendMessage("§c[CrazyNPC] 对不起，此ID的NPC不存在！");
									return true;
								}
								elseif($entity instanceof CrazyEntity or $entity instanceof CrazyHuman)
								{
									if(isset($args[2]))
									{
										switch($args[2])
										{
											case "name":
												if(isset($args[3]))
												{
													$name=$args[3];
													$entity->setNameTag($name);
													$entity->sendData($entity->getViewers());
													$sender->sendMessage("§a[CrazyNPC] 成功更换名字标签!");
													return true;
												}
												else
												{
													$sender->sendMessage("§e[用法] /".$this->cmd." set ".$id." name [新名字]");
													return true;
												}
											case "scale":
											case "大小":
												if(PInfo::CURRENT_PROTOCOL <= 90)
												{
													$sender->sendMessage("§c[CrazyNPC] 检测到你的服务器不是0.16/1.0版本，无法使用大小设置！");
													return true;
												}
												if(isset($args[3]))
												{
													$scale=floatval($args[3]);
													$entity->setDataProperty(Entity::DATA_SCALE, Entity::DATA_TYPE_FLOAT, $scale);
													$entity->sendData($entity->getViewers());
													$sender->sendMessage("§a[CrazyNPC] 成功设置NPC大小！");
													return true;
												}
												else
												{
													$sender->sendMessage("§e[用法] /".$this->cmd." set ".$id." scale <大小值>");
													return true;
												}
											case "helmit":
												if(isset($args[3]))
												{
													$helmit=Item::fromString($args[3]);
													if(!$entity instanceof CrazyHuman)
													{
														$sender->sendMessage("§c[CrazyNPC] 对不起，非Human的NPC不可以佩戴装备！");
														return true;
													}
													$entity->getInventory()->setHelmet($helmit);
													$sender->sendMessage("§b[CrazyNPC] 成功设置NPC的装备！");
													return true;
												}
												else
												{
													$sender->sendMessage("§e[用法] /".$this->cmd." set ".$id." helmit <物品ID>");
													return true;
												}
											case "clothes":
												if(isset($args[3]))
												{
													$shirt=Item::fromString($args[3]);
													if(!$entity instanceof CrazyHuman)
													{
														$sender->sendMessage("§c[CrazyNPC] 对不起，非Human的NPC不可以佩戴装备！");
														return true;
													}
													$entity->getInventory()->setHelmet($shirt);
													$sender->sendMessage("§b[CrazyNPC] 成功设置NPC的装备！");
													return true;
												}
												else
												{
													$sender->sendMessage("§e[用法] /".$this->cmd." set ".$id." clothes <物品ID>");
													return true;
												}
											case "shoes":
												if(isset($args[3]))
												{
													$shoe=Item::fromString($args[3]);
													if(!$entity instanceof CrazyHuman)
													{
														$sender->sendMessage("§c[CrazyNPC] 对不起，非Human的NPC不可以佩戴装备！");
														return true;
													}
													$entity->getInventory()->setHelmet($shoe);
													$sender->sendMessage("§b[CrazyNPC] 成功设置NPC的装备！");
													return true;
												}
												else
												{
													$sender->sendMessage("§e[用法] /".$this->cmd." set ".$id." shoes <物品ID>");
													return true;
												}
											case "pants":
												if(isset($args[3]))
												{
													$pants=Item::fromString($args[3]);
													if(!$entity instanceof CrazyHuman)
													{
														$sender->sendMessage("§c[CrazyNPC] 对不起，非Human的NPC不可以佩戴装备！");
														return true;
													}
													$entity->getInventory()->setHelmet($pants);
													$sender->sendMessage("§b[CrazyNPC] 成功设置NPC的装备！");
													return true;
												}
												else
												{
													$sender->sendMessage("§e[用法] /".$this->cmd." set ".$id." pants <物品ID>");
													return true;
												}
											case "skin":
												if($sender instanceof ConsoleCommandSender)
												{
													$sender->sendMessage("§e请在游戏内输入指令！");
													return true;
												}
												if(!$entity instanceof CrazyHuman)
												{
													$sender->sendMessage("§c[CrazyNPC] 对不起，非Human的NPC不可以设置皮肤！");
													return true;
												}
												$entity->setSkin($sender->getSkinData(), $sender->getSkinId());
												$entity->sendData($entity->getViewers());
												$sender->sendMessage("§a[CrazyNPC] 成功设置NPC的皮肤！");
												return true;
											case "hidename":
												$entity->setNameTagVisible(false);
												if(PInfo::CURRENT_PROTOCOL > 90)
													$entity->setNameTagAlwaysVisible(false);
												$entity->sendData($entity->getViewers());
												$sender->sendMessage("§a[CrazyNPC] 成功隐藏NPC的名字标签！");
												return true;
											case "showname":
												$entity->setNameTagVisible(true);
												if(PInfo::CURRENT_PROTOCOL > 90)
													$entity->setNameTagAlwaysVisible(true);
												$entity->sendData($entity->getViewers());
												$sender->sendMessage("§a[CrazyNPC] 成功显示NPC的名字标签！");
												return true;
											case "addcmd":
												if(isset($args[3]))
												{
													$i=3;
													while(isset($args[$i]))
													{
														$cmd[]=$args[$i];
														$i++;
													}
													$cmd=implode(" ",$cmd);
													if(isset($entity->namedtag->Commands[$cmd]))
													{
														$sender->sendMessage("§e[CrazyNPC] 对不起， 这个指令已经存在了！");
														return true;
													}
													$entity->namedtag->Commands[$cmd] = new StringTag($cmd, $cmd);
													$sender->sendMessage("§a[CrazyNPC] 成功添加指令！");
													return true;
												}
												else
												{
													$sender->sendMessage("§e[用法] /".$this->cmd." set ".$id." addcmd <添加的指令>\n*PS: 玩家名字可用动态标签 %p 代替哦");
													return true;
												}
											case "delcmd":
												if(isset($args[3]))
												{
													$i=3;
													while(isset($args[$i]))
													{
														$cmd[]=$args[$i];
														$i++;
													}
													$cmd=implode(" ",$cmd);
													if(!isset($entity->namedtag->Commands[$cmd]))
													{
														$sender->sendMessage("§e[CrazyNPC] 对不起， 这个指令不存在！");
														return true;
													}
													unset($entity->namedtag->Commands[$cmd]);
													$sender->sendMessage("§a[CrazyNPC] 成功删除指令！");
													return true;
												}
												else
												{
													$sender->sendMessage("§e[用法] /".$this->cmd." set ".$id." delcmd <指令>");
													return true;
												}
											case "cmdlist":
												if(empty($entity->namedtag->Commands))
												{
													$sender->sendMessage("§b[CrazyNPC] 这个NPC还没有添加过任何指令！");
													return true;
												}
												$count=1;
												foreach($entity->namedtag->Commands as $cmd)
												{
													$sender->sendMessage("§e[".$count."] /".$cmd);
													$count++;
												}
												return true;
											case "tphere":
												if($sender instanceof ConsoleCommandSender)
												{
													$sender->sendMessage("§e请在游戏内输入指令！");
													return true;
												}
												$entity->teleport($sender);
												$sender->sendMessage("§a[CrazyNPC] 已将NPC ".$id." 传送到你的位置！");
												return true;
											case "tp":
												if($sender instanceof ConsoleCommandSender)
												{
													$sender->sendMessage("§e请在游戏内输入指令！");
													return true;
												}
												$sender->teleport($entity);
												$sender->sendMessage("§a[CrazyNPC] 已将你传送到！NPC ".$id." !");
												return true;
										}
									}
									else
									{
										$sender->sendMessage("§6=====Setting=====");
										$sender->sendMessage("§a/".$cc." set ".$id." name: §b设置NPC的名字标签");
										$sender->sendMessage("§a/".$cc." set ".$id." scale: §b设置NPC的大小(仅限0.16以上)");
										$sender->sendMessage("§a/".$cc." set ".$id." helmit: §b设置人类NPC的头盔");
										$sender->sendMessage("§a/".$cc." set ".$id." clothes: §b设置人类NPC的衣服");
										$sender->sendMessage("§a/".$cc." set ".$id." shoes: §b设置人类NPC的鞋");
										$sender->sendMessage("§a/".$cc." set ".$id." pants: §b设置人类NPC的裤子");
										$sender->sendMessage("§a/".$cc." set ".$id." skin: §b设置人类NPC的皮肤为你的皮肤");
										$sender->sendMessage("§a/".$cc." set ".$id." [hidename/showname]: §b隐藏/显示NPC的名字标签");
										$sender->sendMessage("§a/".$cc." set ".$id." addcmd: §b添加触碰NPC执行的指令");
										$sender->sendMessage("§a/".$cc." set ".$id." delcmd: §b删除触碰NPC执行的指令");
										$sender->sendMessage("§a/".$cc." set ".$id." cmdlist: §b查看触碰NPC执行的指令列表");
										$sender->sendMessage("§a/".$cc." set ".$id." tphere: §b将NPC传送到你的位置");
										$sender->sendMessage("§a/".$cc." set ".$id." tp: §b将你传送到NPC的位置");
										return true;
									}
								}
								else
								{
									$sender->sendMessage("§c[CrazyNPC] 对不起，此ID的NPC不存在！");
									return true;
								}
							}
							else
							{
								$sender->sendMessage("§e[CrazyNPC] 请输入/".$cc." set <NPC的ID>");
								return true;
							}
						case "list":
							$allLevel=$this->getServer()->getLevels();
							$list=[];
							foreach($allLevel as $level)
							{
								$entities=$level->getEntities();
								foreach($entities as $entity)
								{
									if($entity instanceof CrazyEntity or $entity instanceof CrazyHuman)
									{
										$list[]=array($level->getFolderName(),$entity->getId());
									}
								}
							}
							$sender->sendMessage("§6=====NPC列表=====");
							if($list === [])
							{
								$sender->sendMessage("§e没有任何NPC存在！");
								return true;
							}
							$idd=1;
							foreach($list as $data)
							{
								$sender->sendMessage("[".$idd."] §b地图: ".$data[0].", ID: ".$data[1]);
								$idd++;
							}
							return true;
						case "type":
							$sender->sendMessage("§eNPC类型列表：");
							$sender->sendMessage("§b".implode(", ",self::TYPES));
							return true;
					}
				}
				else
				{
					$sender->sendMessage($this->mainHelp);
					return true;
				}
		}
	}
}