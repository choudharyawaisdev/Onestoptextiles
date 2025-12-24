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
        // Unsplash Images based on category
        $images = [
            'blanket' => 'https://images.unsplash.com/photo-1580302200322-22467d93a109?q=80&w=800',
            'curtain' => 'https://images.unsplash.com/photo-1513201099705-a9746e1e201f?q=80&w=800',
            'fabric'  => 'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?q=80&w=800',
            'sheet'   => 'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?q=80&w=800',
        ];

        // --- 1. THERMAL BLANKETS ---
        $blanket = Product::create([
            'name'        => 'THERMAL BLANKETS',
            'slug'        => Str::slug('Thermal Blankets'),
            'category'    => 'blanket',
            'material'    => '100% NEW COTTON',
            'price'       => 8.00,
            'moq'         => 2,
            'unit'        => 'PIECE',
            'main_image'  => [$images['blanket']], // Casted as array in model
            'description' => 'Premium grade thermal blankets for home and hospital use.',
        ]);

        $blanketColors = ['WHITE', 'IVORY', 'SKY BLUE', 'LIGHT PINK'];
        foreach ($blanketColors as $color) {
            ProductVariation::create([
                'product_id' => $blanket->id,
                'price'      => 8.00,
                'size'       => '71” X 95” (180 CM X 240 CM)',
                'color'      => $color,
                'weight'     => '1.5 KG',
                'notes'      => 'Machine washable. Minimum order 2 pieces.',
                'images'     => [$images['blanket']], // Casted as array
            ]);
        }

        // --- 2. BLACK OUT CURTAINS ---
        $curtain = Product::create([
            'name'        => 'BLACK OUT CURTAINS',
            'slug'        => Str::slug('Black Out Curtains'),
            'category'    => 'curtain',
            'material'    => '100% POLYESTER',
            'price'       => 45.00,
            'moq'         => 1,
            'unit'        => 'PAIR',
            'main_image'  => [$images['curtain']],
            'description' => 'REDUCES OUTSIDE NOISE, PROVIDES THERMAL INSULATION.',
        ]);

        $curtainSizes = ['24”W X 60”L', '30”W X 60”L', '36”W X 60”L', '72”W X 72”L', '96”W X 72”L'];
        foreach ($curtainSizes as $size) {
            ProductVariation::create([
                'product_id' => $curtain->id,
                'price'      => 45.00,
                'size'       => $size,
                'finish'     => 'grommet',
                'notes'      => 'Price for 2 grommet panels. Shipping cost varies by weight.',
                'images'     => [$images['curtain']],
            ]);
        }

        // --- 3. WOVEN FABRIC ROLLS ---
        $fabric = Product::create([
            'name'        => 'WOVEN FABRIC ROLLS (T130/T180)',
            'slug'        => Str::slug('Woven Fabric Rolls'),
            'category'    => 'fabric',
            'material'    => '50/50% POLYESTER COTTON',
            'price'       => 0.00, // Price to be quoted
            'moq'         => 350,
            'unit'        => 'YARD',
            'main_image'  => [$images['fabric']],
            'description' => 'PLAIN WEAVE CLOSED SELVEDGE 3.4 OSY. PILLING CONTROLLED.',
        ]);

        $fabrics = [
            ['color' => 'PARROT GREEN', 'size' => '65"'],
            ['color' => 'JADE / MISTY GREEN', 'size' => '54"'],
            ['color' => 'SKY BLUE', 'size' => '65"'],
        ];

        foreach ($fabrics as $f) {
            ProductVariation::create([
                'product_id' => $fabric->id,
                'price'      => 0.00,
                'color'      => $f['color'],
                'size'       => $f['size'],
                'finish'     => 'anti_microbial',
                'notes'      => '350-400 Yards per roll. Dyed goods are color fast.',
                'images'     => [$images['fabric']],
            ]);
        }

        // --- 4. FITTED SHEETS ---
        $fittedSheet = Product::create([
            'name'        => 'KNITTED FITTED SHEETS',
            'slug'        => Str::slug('Knitted Fitted Sheets'),
            'category'    => 'fitted_sheet',
            'material'    => '50/50% PC BLEND SINGLE JERSEY',
            'price'       => 15.00,
            'moq'         => 24,
            'unit'        => 'PIECE',
            'main_image'  => [$images['sheet']],
            'description' => 'KNITTED FITTED SHEETS, PATTERN: SINGLE JERSEY, COLOR: WHITE',
        ]);

        $finishes = ['all_around', 'four_corner'];
        foreach ($finishes as $fin) {
            ProductVariation::create([
                'product_id' => $fittedSheet->id,
                'price'      => 15.00,
                'size'       => '36” X 84” X 11”',
                'color'      => 'WHITE',
                'weight'     => '450 GRAMS',
                'finish'     => $fin,
                'notes'      => 'Packed 2 dozen per carton. Delivery from Atlanta or LA.',
                'images'     => [$images['sheet']],
            ]);
        }
    }
}