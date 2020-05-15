<?php

declare(strict_types=1);

namespace wumpotamus\chunkloader;

use pocketmine\world\World;

final class ChunkRegion{

	public static function onChunkGenerated(World $world, int $chunkX, int $chunkZ, callable $callback){
		if($world->isChunkPopulated($chunkX, $chunkZ)){
			$callback();
			return;
		}

		$chunkLoader = new InternalChunkLoader($world, $chunkX, $chunkZ, $callback);

		$world->registerChunkListener($chunkLoader, $chunkX, $chunkZ);
		$world->registerChunkLoader($chunkLoader, $chunkX, $chunkZ, true);
	}
}