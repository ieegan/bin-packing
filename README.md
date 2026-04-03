# Bin Packing with Kerf Support

An extension of [dagmike/bin-packing](https://github.com/dagmike/BinPacking) that adds support for **kerf** (material lost to saw blade width) in 2D bin packing calculations.

## What is Kerf?

Kerf is the material lost during cutting operations. When using a saw blade, a small amount of material is consumed by the blade itself. This package allows you to account for that loss in your bin packing calculations.

## Installation

```bash
composer require ieegan/bin-packing
```

## Usage

Instead of using `BinPacking\RectangleBinPack` directly, use the extended class with kerf support:

```php
use Egan\BinPacking\RectangleBinPackKerf;
use BinPacking\Rectangle;

// Create a bin (width: 1000, height: 500)
$bin = new RectangleBinPackKerf(1000, 500);

// Set kerf to 3mm (material lost to saw blade)
$bin->setKerf(3);

// Initialize the bin
$bin->init();

// Create rectangles to pack
$rect1 = new Rectangle(100, 200);
$rect2 = new Rectangle(150, 250);

// Pack items
$rect1Packed = $bin->insert($rect1, 'RectBestShortSideFit');
$rect2Packed = $bin->insert($rect2, 'RectBestShortSideFit');
```

## Features

- **Kerf Support**: Account for saw blade width in packing calculations
- **Transparent Integration**: Works with all existing dagmike/bin-packing methods
- **Easy to Use**: Simple `setKerf()` and `getKerf()` methods
- **Production Ready**: Used in real-world woodworking applications

## API

### `setKerf($kerf)`

Set the kerf width (material lost to saw blade).

**Parameters:**
- `$kerf` (float|int) - Kerf width in the same units as bin dimensions

**Returns:** `self` (for method chaining)

```php
$bin->setKerf(3);  // 3mm kerf
```

### `getKerf()`

Get the current kerf width.

**Returns:** `float|int`

```php
$kerf = $bin->getKerf();
```

## How Kerf Works

When kerf is set, the bin packing algorithm accounts for material loss by:
1. Adding the kerf width as spacing between packed rectangles
2. Reducing available space after each rectangle placement
3. Ensuring accurate material yield calculations

For example, with a 3mm kerf:
- Two adjacent 100mm pieces require 103mm total space (100 + 3 + 0)
- Three adjacent 100mm pieces require 206mm total space (100 + 3 + 100 + 3 + 0)

## Example: Woodworking Application

```php
use Egan\BinPacking\RectangleBinPackKerf;
use BinPacking\Rectangle;

// Wood sheet: 2440mm x 1220mm
$bin = new RectangleBinPackKerf(2440, 1220);

// Account for 3.2mm kerf from saw blade
$bin->setKerf(3.2);
$bin->init();

// Pieces to cut
$pieces = [
    new Rectangle(400, 300),  // 4 pieces
    new Rectangle(400, 300),
    new Rectangle(400, 300),
    new Rectangle(400, 300),
    new Rectangle(500, 250),  // 2 pieces
    new Rectangle(500, 250),
];

// Pack pieces
$packed = $bin->insertMany($pieces, 'RectBestShortSideFit');

// Get usage statistics
$usage = $bin->getUsage();
echo "Material usage: " . round($usage * 100, 2) . "%\n";

// Get unpacked items
$unpacked = $bin->getCantPack();
echo "Items that didn't fit: " . count($unpacked) . "\n";
```

## Requirements

- PHP >= 7.4
- dagmike/bin-packing ^1.7

## License

MIT - See LICENSE file for details

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Support

For issues, questions, or suggestions, please open an issue on [GitHub](https://github.com/ieegan/bin-packing/issues).
