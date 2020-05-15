<?php

declare(strict_types=1);

namespace wumpotamus\chunkloader;

use pocketmine\math\Vector3;
use pocketmine\world\ChunkListener;
use pocketmine\world\ChunkLoader;
use pocketmine\world\format\Chunk;
use pocketmine\world\Position;
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

	public function onChunkLoaded(Chunk $chunk) : void{
		if(!$chunk->isPopulated()){
			$this->world->populateChunk((int) $this->getX(), (int) $this->getZ());

			return;
		}
		$this->onComplete();
	}

	public function onChunkPopulated(Chunk $chunk) : void{
		$this->onComplete();
	}

	public function onComplete() : void{
		$this->world->unregisterChunkLoader($this, $this->getX(), $this->getZ());
		$this->world->unregisterChunkListener($this, $this->getX(), $this->getZ());
		($this->callback)();
	}

	public function getX(){
		return $this->x;
	}

	public function getZ(){
		return $this->z;
	}

	public function onChunkChanged(Chunk $chunk) : void{
	}

	public function onBlockChanged(Vector3 $block) : void{
	}

	public function onChunkUnloaded(Chunk $chunk) : void{
	}
}