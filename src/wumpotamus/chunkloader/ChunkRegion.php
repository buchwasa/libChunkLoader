<?php

declare(strict_types=1);

namespace wumpotamus\chunkloader;

use pocketmine\level\Level;

final class ChunkRegion{
	
	public static function onChunkGenerated(Level $level, int $chunkX, int $chunkZ, callable $callback) : void{
		if($level->isChunkPopulated($chunkX, $chunkZ)){
			$callback();
			return;
		}
		$level->registerChunkLoader(new InternalChunkLoader($level, $chunkX, $chunkZ, $callback), $chunkX, $chunkZ, true);
	}
}