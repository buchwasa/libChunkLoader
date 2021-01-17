<?php

declare(strict_types=1);

namespace muqsit\chunkloader;

use pocketmine\math\Vector3;
use pocketmine\world\ChunkListener;
use pocketmine\world\ChunkLoader;
use pocketmine\world\format\Chunk;
use pocketmine\world\World;

/**
 * @internal
 */
class InternalChunkLoader implements ChunkListener, ChunkLoader{
	/** @var World */
	private $world;
	/** @var int */
	private $x;
	/** @var int */
	private $z;
	/** @var callable */
	private $callback;

	public function __construct(World $world, int $chunkX, int $chunkZ, callable $callback){
		$this->world = $world;
		$this->x = $chunkX;
		$this->z = $chunkZ;
		$this->callback = $callback;
	}

	public function onChunkLoaded(int $chunkX, int $chunkZ, Chunk $chunk) : void{
		if(!$chunk->isPopulated()){
			return;
		}
		$this->onComplete();
	}

	public function onChunkPopulated(int $chunkX, int $chunkZ, Chunk $chunk): void{
		$this->onComplete();
	}

	public function onComplete() : void{
		$this->world->unregisterChunkLoader($this, $this->x, $this->z);
		$this->world->unregisterChunkListener($this, $this->x, $this->z);
		($this->callback)();
	}

	public function getX(){
		return $this->x;
	}

	public function getZ(){
		return $this->z;
	}

	public function onChunkChanged(int $chunkX, int $chunkZ, Chunk $chunk) : void{
	}

	public function onBlockChanged(Vector3 $block) : void{
	}

	public function onChunkUnloaded(int $chunkX, int $chunkZ, Chunk $chunk) : void{
	}
}
