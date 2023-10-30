<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use padavvan\placer\Collection;

class CollectionTest extends TestCase
{
		public function testCollectionIsEmptyWhenCreated(): void
		{
				$collection = new Collection();

				self::assertEmpty($collection->getItems());
		}
}
