<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ShopDummySeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $langRow = $this->db->table('tbl_lang')
            ->where('lang_default', 'Yes')
            ->get()
            ->getRowArray();
        $langId = (int) ($langRow['lang_id'] ?? 1);

        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('tbl_shop_product_category')->truncate();
        $this->db->table('tbl_shop_product_image')->truncate();
        $this->db->table('tbl_shop_product')->truncate();
        $this->db->table('tbl_shop_sub_category')->truncate();
        $this->db->table('tbl_shop_parent_category')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');

        $parents = [
            [
                'category_name'  => 'Electronics',
                'category_slug'  => 'electronics',
                'category_image' => 'portfolio-1.jpg',
                'meta_title'     => 'Electronics Shop',
                'sort_order'     => 1,
            ],
            [
                'category_name'  => 'Clothing',
                'category_slug'  => 'clothing',
                'category_image' => 'portfolio-2.jpg',
                'meta_title'     => 'Clothing Shop',
                'sort_order'     => 2,
            ],
            [
                'category_name'  => 'Home & Garden',
                'category_slug'  => 'home-garden',
                'category_image' => 'portfolio-3.jpg',
                'meta_title'     => 'Home & Garden Shop',
                'sort_order'     => 3,
            ],
            [
                'category_name'  => 'Sports & Outdoors',
                'category_slug'  => 'sports-outdoors',
                'category_image' => 'portfolio-4.jpg',
                'meta_title'     => 'Sports & Outdoors Shop',
                'sort_order'     => 4,
            ],
        ];

        foreach ($parents as $parent) {
            $this->db->table('tbl_shop_parent_category')->insert([
                'category_name'      => $parent['category_name'],
                'category_slug'      => $parent['category_slug'],
                'category_image'     => $parent['category_image'],
                'meta_title'         => $parent['meta_title'],
                'meta_keyword'       => strtolower($parent['category_name']) . ', shop, buy online',
                'meta_description'   => 'Browse ' . $parent['category_name'] . ' products in our online store.',
                'sort_order'         => $parent['sort_order'],
                'status'             => 1,
                'lang_id'            => $langId,
                'created_at'         => $now,
                'updated_at'         => $now,
            ]);
        }

        $parentIds = [
            'electronics'     => 1,
            'clothing'        => 2,
            'home-garden'     => 3,
            'sports-outdoors' => 4,
        ];

        $subs = [
            ['parent' => 'electronics', 'name' => 'Smartphones', 'slug' => 'smartphones', 'image' => 'portfolio-5.jpg', 'sort' => 1],
            ['parent' => 'electronics', 'name' => 'Laptops', 'slug' => 'laptops', 'image' => 'portfolio-6.jpg', 'sort' => 2],
            ['parent' => 'electronics', 'name' => 'Accessories', 'slug' => 'accessories', 'image' => 'portfolio-7.jpg', 'sort' => 3],
            ['parent' => 'clothing', 'name' => 'Men', 'slug' => 'men-clothing', 'image' => 'portfolio-8.jpg', 'sort' => 1],
            ['parent' => 'clothing', 'name' => 'Women', 'slug' => 'women-clothing', 'image' => 'portfolio-9.jpg', 'sort' => 2],
            ['parent' => 'home-garden', 'name' => 'Furniture', 'slug' => 'furniture', 'image' => 'portfolio-10.jpg', 'sort' => 1],
            ['parent' => 'home-garden', 'name' => 'Kitchen', 'slug' => 'kitchen', 'image' => 'service-8.jpg', 'sort' => 2],
            ['parent' => 'sports-outdoors', 'name' => 'Fitness', 'slug' => 'fitness', 'image' => 'service-12.jpg', 'sort' => 1],
            ['parent' => 'sports-outdoors', 'name' => 'Outdoor Gear', 'slug' => 'outdoor-gear', 'image' => 'news-1.jpg', 'sort' => 2],
        ];

        $subIds = [];
        foreach ($subs as $sub) {
            $this->db->table('tbl_shop_sub_category')->insert([
                'parent_category_id' => $parentIds[$sub['parent']],
                'category_name'      => $sub['name'],
                'category_slug'      => $sub['slug'],
                'category_image'     => $sub['image'],
                'meta_title'         => $sub['name'] . ' - Shop',
                'sort_order'         => $sub['sort'],
                'status'             => 1,
                'lang_id'            => $langId,
                'created_at'         => $now,
                'updated_at'         => $now,
            ]);
            $subIds[$sub['slug']] = $this->db->insertID();
        }

        $products = [
            [
                'name'  => 'Pro Smartphone X12',
                'slug'  => 'pro-smartphone-x12',
                'short' => '6.7" display, 128GB storage, dual camera.',
                'full'  => 'The Pro Smartphone X12 features a vibrant OLED display, fast processor, and all-day battery life. Perfect for work and entertainment.',
                'price' => 699.99,
                'image' => 'portfolio-1.jpg',
                'stock' => 25,
                'sort'  => 1,
                'parent' => 'electronics',
                'sub'    => 'smartphones',
            ],
            [
                'name'  => 'Budget Phone Lite',
                'slug'  => 'budget-phone-lite',
                'short' => 'Affordable smartphone with great battery.',
                'full'  => 'A reliable everyday phone with a crisp display, decent camera, and long-lasting battery at an unbeatable price.',
                'price' => 199.99,
                'image' => 'portfolio-2.jpg',
                'stock' => 40,
                'sort'  => 2,
                'parent' => 'electronics',
                'sub'    => 'smartphones',
            ],
            [
                'name'  => 'UltraBook Pro 15',
                'slug'  => 'ultrabook-pro-15',
                'short' => '15" laptop, 16GB RAM, 512GB SSD.',
                'full'  => 'Lightweight aluminum body, backlit keyboard, and powerful performance for developers and creatives.',
                'price' => 1299.00,
                'image' => 'portfolio-3.jpg',
                'stock' => 12,
                'sort'  => 3,
                'parent' => 'electronics',
                'sub'    => 'laptops',
            ],
            [
                'name'  => 'Wireless Earbuds Pro',
                'slug'  => 'wireless-earbuds-pro',
                'short' => 'Noise cancelling, 24hr battery case.',
                'full'  => 'Premium sound quality with active noise cancellation and comfortable fit for all-day wear.',
                'price' => 89.99,
                'image' => 'portfolio-4.jpg',
                'stock' => 60,
                'sort'  => 4,
                'parent' => 'electronics',
                'sub'    => 'accessories',
            ],
            [
                'name'  => 'Classic Cotton T-Shirt',
                'slug'  => 'classic-cotton-tshirt',
                'short' => 'Soft cotton tee, available in multiple colors.',
                'full'  => 'Breathable 100% cotton fabric with a relaxed fit. Machine washable and durable for everyday wear.',
                'price' => 24.99,
                'image' => 'portfolio-5.jpg',
                'stock' => 100,
                'sort'  => 5,
                'parent' => 'clothing',
                'sub'    => 'men-clothing',
            ],
            [
                'name'  => 'Slim Fit Denim Jeans',
                'slug'  => 'slim-fit-denim-jeans',
                'short' => 'Stretch denim with modern slim fit.',
                'full'  => 'Comfortable stretch denim jeans with classic five-pocket styling. Perfect for casual and smart-casual looks.',
                'price' => 59.99,
                'image' => 'portfolio-6.jpg',
                'stock' => 45,
                'sort'  => 6,
                'parent' => 'clothing',
                'sub'    => 'men-clothing',
            ],
            [
                'name'  => 'Floral Summer Dress',
                'slug'  => 'floral-summer-dress',
                'short' => 'Lightweight dress for warm weather.',
                'full'  => 'Elegant floral print on breathable fabric. Ideal for summer outings and casual events.',
                'price' => 49.99,
                'image' => 'portfolio-7.jpg',
                'stock' => 30,
                'sort'  => 7,
                'parent' => 'clothing',
                'sub'    => 'women-clothing',
            ],
            [
                'name'  => 'Modern Lounge Chair',
                'slug'  => 'modern-lounge-chair',
                'short' => 'Ergonomic chair for living room comfort.',
                'full'  => 'Contemporary design with padded seat and sturdy wooden legs. Adds style and comfort to any room.',
                'price' => 249.00,
                'image' => 'portfolio-8.jpg',
                'stock' => 8,
                'sort'  => 8,
                'parent' => 'home-garden',
                'sub'    => 'furniture',
            ],
            [
                'name'  => 'Stainless Steel Cookware Set',
                'slug'  => 'stainless-steel-cookware-set',
                'short' => '10-piece set for everyday cooking.',
                'full'  => 'Durable stainless steel pots and pans with even heat distribution. Dishwasher safe and oven compatible.',
                'price' => 179.50,
                'image' => 'portfolio-9.jpg',
                'stock' => 20,
                'sort'  => 9,
                'parent' => 'home-garden',
                'sub'    => 'kitchen',
            ],
            [
                'name'  => 'Adjustable Dumbbell Set',
                'slug'  => 'adjustable-dumbbell-set',
                'short' => '5–25 lb adjustable weights, pair.',
                'full'  => 'Space-saving adjustable dumbbells for home workouts. Quick weight changes with secure locking mechanism.',
                'price' => 149.99,
                'image' => 'portfolio-10.jpg',
                'stock' => 15,
                'sort'  => 10,
                'parent' => 'sports-outdoors',
                'sub'    => 'fitness',
            ],
            [
                'name'  => 'Camping Backpack 40L',
                'slug'  => 'camping-backpack-40l',
                'short' => 'Water-resistant hiking backpack.',
                'full'  => '40-liter capacity with multiple compartments, padded straps, and rain cover included. Built for trails and travel.',
                'price' => 79.99,
                'image' => 'service-8.jpg',
                'stock' => 22,
                'sort'  => 11,
                'parent' => 'sports-outdoors',
                'sub'    => 'outdoor-gear',
            ],
            [
                'name'  => 'Yoga Mat Premium',
                'slug'  => 'yoga-mat-premium',
                'short' => 'Non-slip mat with carrying strap.',
                'full'  => 'Extra thick cushioning for joints, non-slip surface on both sides, and easy-to-clean material.',
                'price' => 34.99,
                'image' => 'service-12.jpg',
                'stock' => 0,
                'sort'  => 12,
                'parent' => 'sports-outdoors',
                'sub'    => 'fitness',
            ],
        ];

        foreach ($products as $product) {
            $this->db->table('tbl_shop_product')->insert([
                'product_name'       => $product['name'],
                'product_slug'       => $product['slug'],
                'short_description'  => $product['short'],
                'full_description'   => $product['full'],
                'price'              => $product['price'],
                'featured_image'     => $product['image'],
                'stock_quantity'     => $product['stock'],
                'meta_title'         => $product['name'] . ' - Buy Online',
                'meta_keyword'       => strtolower($product['name']) . ', shop, buy',
                'meta_description'   => $product['short'],
                'status'             => 1,
                'lang_id'            => $langId,
                'sort_order'         => $product['sort'],
                'created_at'         => $now,
                'updated_at'         => $now,
            ]);

            $productId = $this->db->insertID();

            $this->db->table('tbl_shop_product_category')->insert([
                'product_id'         => $productId,
                'parent_category_id' => $parentIds[$product['parent']],
                'sub_category_id'    => $subIds[$product['sub']],
            ]);

            $this->db->table('tbl_shop_product_image')->insert([
                'product_id' => $productId,
                'image_name' => $product['image'],
                'sort_order' => 1,
            ]);
        }
    }
}
