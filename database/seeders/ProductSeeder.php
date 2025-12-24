<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $image = [
            'blanket' => 'https://image.unsplash.com/photo-1580302200322-22467d93a109?w=800',
            'curtain' => 'https://image.unsplash.com/photo-1513201099705-a9746e1e201f?w=800',
            'fabric' => 'https://image.unsplash.com/photo-1620799140408-edc6dcb6d633?w=800',
            'sheet' => 'https://image.unsplash.com/photo-1522771739844-6a9f6d5f14af?w=800',
        ];

        /*
        |--------------------------------------------------------------------------
        | 1. THERMAL BLANKETS
        |--------------------------------------------------------------------------
        */
        $blanket = Product::create([
            'name' => 'THERMAL BLANKETS',
            'slug' => Str::slug('Thermal Blankets'),
            'category' => 'blanket',
            'material' => '100% NEW COTTON',
            'price' => 8.00,
            'moq' => 2,
            'unit' => 'PIECE',
            'main_image' => [$image['blanket']],
            'description' => '
SIZE: 71” X 95” (180 CM X 240 CM)
MATERIAL: 100% NEW COTTON
WEIGHT: 1.5 KG

AVAILABLE COLORS:
WHITE, IVORY, SKY BLUE, LIGHT PINK

PRICE: $8 / PIECE
MINIMUM ORDER QUANTITY: 2 PIECES

DELIVERY ADDRESS FORMAT:
Line 1: House / Apartment Number (Special characters ignored)
Line 2: Street, Town / City
Line 3: 5 Digit ZIP Code

Shipping charges are calculated based on delivery address and shipment weight.
',
        ]);

        foreach (['WHITE', 'IVORY', 'SKY BLUE', 'LIGHT PINK'] as $color) {
            ProductVariation::create([
                'product_id' => $blanket->id,
                'price' => 8.00,
                'size' => '71” X 95”',
                'color' => $color,
                'weight' => '1.5 KG',
                'notes' => 'Minimum order 2 pieces. Shipping calculated by courier based on ZIP code.',
                'image' => [$image['blanket']],
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 2. BLACK OUT CURTAINS
        |--------------------------------------------------------------------------
        */
        $curtain = Product::create([
            'name' => 'BLACK OUT CURTAINS',
            'slug' => Str::slug('Black Out Curtains'),
            'category' => 'curtain',
            'material' => '100% POLYESTER',
            'price' => 45.00,
            'moq' => 1,
            'unit' => 'PAIR',
            'main_image' => [$image['curtain']],
            'description' => '
FEATURES:
• Reduces outside noise
• Provides thermal insulation

MATERIAL: 100% POLYESTER
STYLE: Grommet Curtains (2 Panels Per Pair)

WINDOW SIZES AVAILABLE:
24” W X 60” L
30” W X 60” L
36” W X 60” L
72” W X 72” L
96” W X 72” L

PRICE: $45 / PAIR

Shipping cost depends on delivery address and total weight.
Courier selection will be determined accordingly.
',
        ]);

        foreach ([
            '24” W X 60” L',
            '30” W X 60” L',
            '36” W X 60” L',
            '72” W X 72” L',
            '96” W X 72” L',
        ] as $size) {
            ProductVariation::create([
                'product_id' => $curtain->id,
                'price' => 45.00,
                'size' => $size,
                'finish' => 'grommet',
                'notes' => 'Price includes 2 grommet panels. Shipping calculated separately.',
                'image' => [$image['curtain']],
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 3. WOVEN FABRIC ROLLS (T130 / T180)
        |--------------------------------------------------------------------------
        */
        $fabric = Product::create([
            'name' => 'WOVEN FABRIC ROLLS (T130 / T180)',
            'slug' => Str::slug('Woven Fabric Rolls'),
            'category' => 'fabric',
            'material' => '50/50% POLYESTER COTTON',
            'price' => 0.00,
            'moq' => 350,
            'unit' => 'YARD',
            'main_image' => [$image['fabric']],
            'description' => '
DESCRIPTION:
Plain weave, closed selvedge, 3.4 OSY woven fabric.
Premium grade for Home, Hospital & Senior Care usage.

ROLL LENGTH:
350 – 400 Yards per roll

PAYMENT TERMS:
50% advance payment
50% Net 30 days

REFUND POLICY:
Re-packed goods are not acceptable for refund.
Return freight cost is deducted from paid advance.
Unopened goods in original packing are acceptable.

CUSTOM FINISHES:
Anti-microbial finishes available.
Add $0.20 per yard for 60°C color fast dyes.

FOB:
X-U.S Port or X-Warehouse (Atlanta / LA)
',
        ]);

        foreach ([
            ['color' => 'PARROT GREEN', 'size' => '65”'],
            ['color' => 'JADE / MISTY GREEN', 'size' => '54”'],
            ['color' => 'SKY BLUE', 'size' => '65”'],
        ] as $f) {
            ProductVariation::create([
                'product_id' => $fabric->id,
                'price' => 0.00,
                'color' => $f['color'],
                'size' => $f['size'],
                'finish' => 'anti_microbial',
                'notes' => 'Price on request. Order value $5,000 – $40,000.',
                'image' => [$image['fabric']],
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 4. KNITTED FITTED SHEETS
        |--------------------------------------------------------------------------
        */
        $sheet = Product::create([
            'name' => 'KNITTED FITTED SHEETS',
            'slug' => Str::slug('Knitted Fitted Sheets'),
            'category' => 'fitted_sheet',
            'material' => '50/50% PC BLEND SINGLE JERSEY',
            'price' => 0.00,
            'moq' => 24,
            'unit' => 'PIECE',
            'main_image' => [$image['sheet']],
            'description' => '
PATTERN: Single Jersey
COLOR: White
SIZE: 36” X 84” X 11”
WEIGHT: 450 Grams per sheet

PACKING:
2 Dozen per carton

ELASTIC OPTIONS:
All Around Elastic
4 Corner Elastic

FOB: Atlanta or LA Warehouse
Shipping via customer trucking company or warehouse pickup.
',
        ]);

        foreach (['all_around', 'four_corner'] as $finish) {
            ProductVariation::create([
                'product_id' => $sheet->id,
                'price' => 0.00,
                'size' => '36” X 84” X 11”',
                'color' => 'WHITE',
                'weight' => '450 GRAMS',
                'finish' => $finish,
                'notes' => 'Price quoted based on quantity. Order value $5,000 – $40,000.',
                'image' => [$image['sheet']],
            ]);
        }
    }
}
