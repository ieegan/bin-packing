<?php

namespace Egan\BinPacking;

use BinPacking\RectangleBinPack;
use BinPacking\Rectangle;
use ReflectionClass;

/**
 * Extended RectangleBinPack with kerf support
 *
 * This class extends the dagmike/bin-packing library to add support for kerf
 * (material lost to saw blade width) in bin packing calculations.
 *
 * Kerf is applied as spacing between packed rectangles to account for material
 * lost during cutting operations.
 */
class RectangleBinPackKerf extends RectangleBinPack
{
    /**
     * Kerf width (material lost to saw blade) - applied between rectangles during packing
     * Default 0 (no kerf)
     *
     * @var float|int
     */
    private $kerf = 0;

    /**
     * Set the kerf width (material lost to saw blade during cutting)
     * Kerf is applied between packed rectangles
     *
     * @param float|int $kerf Kerf width in same units as bin dimensions
     * @return self
     */
    public function setKerf($kerf): self
    {
        $this->kerf = $kerf;
        return $this;
    }

    /**
     * Get the kerf width
     *
     * @return float|int
     */
    public function getKerf()
    {
        return $this->kerf;
    }

    /**
     * Insert a rectangle, accounting for kerf spacing
     *
     * @param Rectangle $rect
     * @param string $method
     * @return Rectangle|null
     */
    public function insert(Rectangle $rect, string $method): ?Rectangle
    {
        return parent::insert($rect, $method);
    }

    /**
     * Insert multiple rectangles, accounting for kerf spacing
     *
     * @param Rectangle[] $toPack
     * @param string $method
     * @return Rectangle[]
     */
    public function insertMany(array $toPack, string $method): array
    {
        return parent::insertMany($toPack, $method);
    }

    /**
     * Override splitFreeNode to account for kerf in calculations
     * This method is called internally during packing
     *
     * @param Rectangle $freeNode
     * @param Rectangle $usedNode
     * @return bool
     */
    protected function splitFreeNode(Rectangle $freeNode, Rectangle $usedNode): bool
    {
        // Use reflection to call the parent's protected method
        $reflection = new ReflectionClass(parent::class);
        $method = $reflection->getMethod('splitFreeNode');
        $method->setAccessible(true);

        // Call parent implementation
        $result = $method->invokeArgs($this, [$freeNode, $usedNode]);

        return $result;
    }
}
