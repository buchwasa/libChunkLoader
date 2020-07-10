### libChunkLoader

**Notice: This actually was created by [muqsit](https://github.com/muqsit), I've only gone and made it a virion.**

## What is libChunkLoader?
libChunkLoader is a library that loads a chunk and keeps it loaded until you've done what you've need to do.<br>
For instance, say I want to teleport a player to the highest block in my task. The highest block in an unloaded chunk is -1, because, well it's an unloaded chunk.<br>
Using libChunkLoader, I can load that chunk to tell me what the highest block actually is and teleport the player to it.

## How can I use libChunkLoader?
Here is an example of how to use it:
```php
<?php

use pocketmine\math\Vector3;
use pocketmine\player\Player;
use muqsit\chunkloader\ChunkRegion;

class ExampleTeleport{
    public function teleport(Player $player, int $x, int $z){
        ChunkRegion::onChunkGenerated($player->getWorld(), $x >> 4, $z >> 4, function() use($player, $x, $z){
            $player->teleport(new Vector3($x, $player->getWorld()->getHighestBlockAt($x, $z), $z));
        });
    }
}
```
