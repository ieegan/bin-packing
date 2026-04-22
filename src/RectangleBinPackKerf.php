<?php

namespace Egan\BinPacking;

use BinPacking\RectangleBinPack;
use BinPacking\Rectangle;

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
     * Set the kerf width (material lost to saw blade during cutting)
     * Kerf is applied between packed rectangles
     *
     * @param float|int $kerf Kerf width in same units as bin dimensions
     * @return self
     */
    public function setKerf($kerf): self
    {
        parent::setKerf($kerf);
        return $this;
    }

    /**
     * Get the kerf width
     *
     * @return float|int
     */
    public function getKerf()
    {
        return parent::getKerf();
    }
}
