<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::create([
            'username' => 'admin',
            'name' => 'admin',
            'password' => bcrypt('admin'),
            'email' => 'admin@sibabe.app',
            'phone' => '081234567890',
        ]);

        Product::create([
            'name' => 'Original Bima Bread',
            'price' => 10000,
            'stock' => 14,
            'image' => 'https://i.ibb.co/MCWDqy9/Original-Bima-Bread.jpg',
            'description' => 'Original Bima Bread with signature flavor and scent',
        ]);

        Product::create([
            'name' => 'Artisan Bread',
            'price' => 12000,
            'stock' => 6,
            'image' => 'https://i.ibb.co/37rkhk7/Artisan-Bread.jpg',
            'description' => 'Our signature homemade artisan bread, handmade, without machine, no preservatives, and make with love',
        ]);

        Product::create([
            'name' => 'Baguette Bread',
            'price' => 9000,
            'stock' => 5,
            'image' => 'https://i.ibb.co/4RPNWSB/Baguette-Bread.jpg',
            'description' => 'Our Baguette Signature Bread with long and thin type of bread of French origin. that is commonly made from basic lean dough (the dough, though not the shape, is defined by French law). It is distinguishable by its length and crisp crust.',
        ]);

        Product::create([
            'name' => 'Biscuit Flower Branch',
            'price' => 5000,
            'stock' => 0,
            'image' => 'https://i.ibb.co/hFXyMSC/Biscuit-Flower-Branch.jpg',
            'description' => 'Our Signature Biscuit with flower branch shape and with the lavender scent',
        ]);

        Product::create([
            'name' => 'Black Bread',
            'price' => 12000,
            'stock' => 4,
            'image' => 'https://i.ibb.co/bN6rVX8/Black-Bread.jpg',
            'description' => 'Our Signature Black Bread with coffe flavor',
        ]);

        Product::create([
            'name' => 'Chocolate Brownies',
            'price' => 40000,
            'stock' => 2,
            'image' => 'https://i.ibb.co/0ypmckF/Chocolate-Brownies.jpg',
            'description' => 'Our Signature Chocolate Brownies with special premium chocolate, you can also buy this brownies with one package with 20 pieces',
        ]);

        Product::create([
            'name' => 'Chocolate Cookies',
            'price' => 6000,
            'stock' => 8,
            'image' => 'https://i.ibb.co/qdyfLc5/Chocolate-Cookies.jpg',
            'description' => 'Delicious Chocolate Cookies with our signature flavor',
        ]);

        Product::create([
            'name' => 'Circle Pastry',
            'price' => 9500,
            'stock' => 0,
            'image' => 'https://i.ibb.co/3Y1LzdC/Circle-Pastry.jpg',
            'description' => 'Our siganture pastry with circle shape with bima bakery signature taste',
        ]);

        Product::create([
            'name' => 'Cookies with Jam',
            'price' => 6500,
            'stock' => 5,
            'image' => 'https://i.ibb.co/YjyGfjd/Cookies-with-Jam.jpg',
            'description' => 'Delicious cookies with strawberry jam and signature Bima Bakery taste',
        ]);

        Product::create([
            'name' => 'Croissant Bread',
            'price' => 12000,
            'stock' => 13,
            'image' => 'https://i.ibb.co/zrK2njP/Croissant-Bread.jpg',
            'description' => 'Delicious cookies with strawberry jam and signature Bima Bakery taste',
        ]);

        Product::create([
            'name' => 'Macaroons',
            'price' => 7500,
            'stock' => 12,
            'image' => 'https://i.ibb.co/f22XsQj/Macaroons.jpg',
            'description' => 'Cutie Macaron with various special flavors',
        ]);

        Product::create([
            'name' => 'Premium Slice Bread',
            'price' => 18500,
            'stock' => 3,
            'image' => 'https://i.ibb.co/pKjztPJ/Premium-Slice-Bread.jpg',
            'description' => 'Our premium slice bread with signature flavor and scent',
        ]);
    }
}
