<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Main Courses
            ['name' => 'Nasi Goreng Special', 'price' => 35000, 'discount' => 0, 'description' => 'Nasi goreng dengan telur, ayam, dan sayuran segar', 'image_url' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=400&h=300&fit=crop', 'stock' => 50, 'category' => 'Main Course', 'is_available' => true],
            ['name' => 'Mie Goreng Seafood', 'price' => 40000, 'discount' => 10, 'description' => 'Mie goreng dengan seafood segar pilihan', 'image_url' => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=400&h=300&fit=crop', 'stock' => 30, 'category' => 'Main Course', 'is_available' => true],
            ['name' => 'Ayam Bakar Madu', 'price' => 45000, 'discount' => 0, 'description' => 'Ayam bakar dengan saus madu spesial', 'image_url' => 'https://images.unsplash.com/photo-1598103442097-8b74394b95c6?w=400&h=300&fit=crop', 'stock' => 25, 'category' => 'Main Course', 'is_available' => true],
            ['name' => 'Nasi Uduk', 'price' => 28000, 'discount' => 5, 'description' => 'Nasi uduk dengan lauk komplit', 'image_url' => 'https://images.unsplash.com/photo-1596797038530-2c107229654b?w=400&h=300&fit=crop', 'stock' => 45, 'category' => 'Main Course', 'is_available' => true],
            ['name' => 'Capcay Goreng', 'price' => 32000, 'discount' => 0, 'description' => 'Tumisan sayuran segar dengan saus tiram', 'image_url' => 'https://images.unsplash.com/photo-1543339308-43e59d6b73a6?w=400&h=300&fit=crop', 'stock' => 30, 'category' => 'Main Course', 'is_available' => true],
            ['name' => 'Nasi Goreng Kampung', 'price' => 30000, 'discount' => 0, 'description' => 'Nasi goreng kampung dengan ikan teri', 'image_url' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=400&h=300&fit=crop', 'stock' => 40, 'category' => 'Main Course', 'is_available' => true],
            ['name' => 'Kwetiau Goreng', 'price' => 38000, 'discount' => 0, 'description' => 'Kwetiau goreng siram saus', 'image_url' => 'https://images.unsplash.com/photo-1617093727343-374698b1b08d?w=400&h=300&fit=crop', 'stock' => 25, 'category' => 'Main Course', 'is_available' => true],
            ['name' => 'Ayam Goreng Kremes', 'price' => 42000, 'discount' => 0, 'description' => 'Ayam goreng dengan kremesan', 'image_url' => 'https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?w=400&h=300&fit=crop', 'stock' => 30, 'category' => 'Main Course', 'is_available' => true],
            // Appetizers
            ['name' => 'Sate Ayam', 'price' => 30000, 'discount' => 0, 'description' => '10 tusuk sate ayam dengan bumbu kacang', 'image_url' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400&h=300&fit=crop', 'stock' => 40, 'category' => 'Appetizer', 'is_available' => true],
            ['name' => 'Gado-Gado', 'price' => 25000, 'discount' => 0, 'description' => 'Sayuran segar dengan bumbu kacang', 'image_url' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400&h=300&fit=crop', 'stock' => 35, 'category' => 'Appetizer', 'is_available' => true],
            ['name' => 'Lumpia Goreng', 'price' => 22000, 'discount' => 0, 'description' => 'Lumpia isi sayuran dan ayam', 'image_url' => 'https://images.unsplash.com/photo-1548507200-b6567e7cadb2?w=400&h=300&fit=crop', 'stock' => 50, 'category' => 'Appetizer', 'is_available' => true],
            ['name' => 'Tahu Isi', 'price' => 20000, 'discount' => 0, 'description' => 'Tahu isi sayuran goreng crispy', 'image_url' => 'https://images.unsplash.com/photo-1604503468506-a8da13d82791?w=400&h=300&fit=crop', 'stock' => 45, 'category' => 'Appetizer', 'is_available' => true],
            ['name' => 'Siomay', 'price' => 28000, 'discount' => 0, 'description' => 'Siomay dengan bumbu kacang', 'image_url' => 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=400&h=300&fit=crop', 'stock' => 35, 'category' => 'Appetizer', 'is_available' => true],
            // Beverages
            ['name' => 'Es Teh Manis', 'price' => 8000, 'discount' => 0, 'description' => 'Es teh manis segar', 'image_url' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=400&h=300&fit=crop', 'stock' => 100, 'category' => 'Beverage', 'is_available' => true],
            ['name' => 'Es Jeruk', 'price' => 12000, 'discount' => 0, 'description' => 'Jus jeruk segar dengan gula', 'image_url' => 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?w=400&h=300&fit=crop', 'stock' => 80, 'category' => 'Beverage', 'is_available' => true],
            ['name' => 'Jus Alpukat', 'price' => 18000, 'discount' => 0, 'description' => 'Jus alpukat creamy dengan cokelat', 'image_url' => 'https://images.unsplash.com/photo-1638176066666-ffb2f013c7dd?w=400&h=300&fit=crop', 'stock' => 50, 'category' => 'Beverage', 'is_available' => true],
            ['name' => 'Es Kelapa Muda', 'price' => 15000, 'discount' => 0, 'description' => 'Kelapa muda segar dengan es', 'image_url' => 'https://images.unsplash.com/photo-1544252890-c21f69867e65?w=400&h=300&fit=crop', 'stock' => 40, 'category' => 'Beverage', 'is_available' => true],
            ['name' => 'Kopi Susu', 'price' => 16000, 'discount' => 0, 'description' => 'Kopi susu dingin/panas', 'image_url' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=400&h=300&fit=crop', 'stock' => 60, 'category' => 'Beverage', 'is_available' => true],
            ['name' => 'Teh Tarik', 'price' => 14000, 'discount' => 0, 'description' => 'Teh tarik susu hangat', 'image_url' => 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?w=400&h=300&fit=crop', 'stock' => 55, 'category' => 'Beverage', 'is_available' => true],
            ['name' => 'Jus Mangga', 'price' => 17000, 'discount' => 0, 'description' => 'Jus mangga segar', 'image_url' => 'https://images.unsplash.com/photo-1546173159-315724a31696?w=400&h=300&fit=crop', 'stock' => 45, 'category' => 'Beverage', 'is_available' => true],
            ['name' => 'Es Campur Cincau', 'price' => 15000, 'discount' => 0, 'description' => 'Es campur cincau segar', 'image_url' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=400&h=300&fit=crop', 'stock' => 50, 'category' => 'Beverage', 'is_available' => true],
            // Desserts
            ['name' => 'Pisang Goreng', 'price' => 15000, 'discount' => 0, 'description' => 'Pisang goreng crispy dengan keju', 'image_url' => 'https://images.unsplash.com/photo-1619740455993-9e612b1af08a?w=400&h=300&fit=crop', 'stock' => 60, 'category' => 'Dessert', 'is_available' => true],
            ['name' => 'Es Campur', 'price' => 20000, 'discount' => 0, 'description' => 'Es campur dengan buah segar dan jelly', 'image_url' => 'https://images.unsplash.com/photo-1488477181946-6428a0291777?w=400&h=300&fit=crop', 'stock' => 40, 'category' => 'Dessert', 'is_available' => true],
            ['name' => 'Puding Coklat', 'price' => 18000, 'discount' => 0, 'description' => 'Puding coklat lembut', 'image_url' => 'https://images.unsplash.com/photo-1541599468348-e96984315921?w=400&h=300&fit=crop', 'stock' => 35, 'category' => 'Dessert', 'is_available' => true],
            ['name' => 'Es Krim Goreng', 'price' => 25000, 'discount' => 0, 'description' => 'Es krim goreng dengan topping', 'image_url' => 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=400&h=300&fit=crop', 'stock' => 30, 'category' => 'Dessert', 'is_available' => true],
            ['name' => 'Martabak Manis', 'price' => 35000, 'discount' => 0, 'description' => 'Martabak manis berbagai topping', 'image_url' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=400&h=300&fit=crop', 'stock' => 25, 'category' => 'Dessert', 'is_available' => true],
            // Soups
            ['name' => 'Soto Ayam', 'price' => 32000, 'discount' => 0, 'description' => 'Soto ayam dengan nasi', 'image_url' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=400&h=300&fit=crop', 'stock' => 35, 'category' => 'Soup', 'is_available' => true],
            ['name' => 'Sop Buntut', 'price' => 55000, 'discount' => 0, 'description' => 'Sop buntut premium', 'image_url' => 'https://images.unsplash.com/photo-1583835746434-cf1534674b41?w=400&h=300&fit=crop', 'stock' => 20, 'category' => 'Soup', 'is_available' => true],
            ['name' => 'Bakso Spesial', 'price' => 28000, 'discount' => 0, 'description' => 'Bakso dengan berbagai macam isian', 'image_url' => 'https://images.unsplash.com/photo-1555126634-323283e090fa?w=400&h=300&fit=crop', 'stock' => 40, 'category' => 'Soup', 'is_available' => true],
            // Noodles
            ['name' => 'Mie Ayam', 'price' => 25000, 'discount' => 0, 'description' => 'Mie ayam dengan pangsit', 'image_url' => 'https://images.unsplash.com/photo-1552611052-33e04de081de?w=400&h=300&fit=crop', 'stock' => 45, 'category' => 'Noodles', 'is_available' => true],
            ['name' => 'Mie Goreng Jawa', 'price' => 30000, 'discount' => 0, 'description' => 'Mie goreng ala Jawa', 'image_url' => 'https://images.unsplash.com/photo-1585032226651-759b368d7246?w=400&h=300&fit=crop', 'stock' => 35, 'category' => 'Noodles', 'is_available' => true],
            ['name' => 'Indomie Rebus', 'price' => 15000, 'discount' => 0, 'description' => 'Indomie rebus dengan telur', 'image_url' => 'https://images.unsplash.com/photo-1612929633738-8fe44f7ec841?w=400&h=300&fit=crop', 'stock' => 80, 'category' => 'Noodles', 'is_available' => true],
        ];

        foreach ($products as $product) {
            Barang::create($product);
        }
    }
}
