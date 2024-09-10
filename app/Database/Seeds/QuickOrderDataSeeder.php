<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class QuickOrderDataSeeder extends Seeder
{
    public function run()
    {
        // Insert sample data into the user table for each restaurant
        $user_data = [
            [
                'username' => 'user1',
                'email' => 'user1@example.com'
            ],
            [
                'username' => 'user2',
                'email' => 'user2@example.com'
            ],
            [
                'username' => 'user3',
                'email' => 'user3@example.com'
            ]
        ];


        
        // Insert user data and retrieve inserted IDs
        $userIds = [];
        foreach ($user_data as $user) {
            $this->db->table('user')->insert($user);
            $userIds[] = $this->db->insertID();
        }
        

        // Insert sample data into the restaurants table for each restaurant
        foreach ($userIds as $index => $userId) {
            $restaurants_data = [
                [
                    'user_id' => $userId,
                    'name' => 'Restaurant' . ($index + 1),
                    'address' => '123 Main St',
                    'phone_number' => '123-456-7890'
                ]
            ];

            $this->db->table('restaurants')->insertBatch($restaurants_data);

            // Get the last inserted restaurant ID
            $restaurantId = $this->db->insertID();
            


            // Insert sample data into the table table for each restaurant
            $numTables = 3; // Number of tables for each restaurant
            $tableIds = [];
            for ($i = 1; $i <= $numTables; $i++) {
                $table_data = [
                    'restaurant_id' => $restaurantId,
                    'table_number' => $i, // Ensure table_number cycles for each restaurant
                ];
                $this->db->table('table')->insert($table_data);
                $tableIds[] = $this->db->insertID();
            }

            // Insert sample data into the order table for each table
            foreach ($tableIds as $tableId) {
                $order_data = [
                    [
                        'table_id' => $tableId,
                        'status' => 'pending',
                        'created_at' => date('Y-m-d')
                    ],
                    [
                        'table_id' => $tableId,
                        'status' => 'completed',
                        'created_at' => date('Y-m-d')
                    ],
                    [
                        'table_id' => $tableId,
                        'status' => 'cancelled',
                        'created_at' => date('Y-m-d')
                    ]
                ];
                $this->db->table('order')->insertBatch($order_data);
            
            }

            // Insert sample data into the menu table for each restaurant
            $menu_data = [
                [
                    'restaurant_id' => $restaurantId,
                    'menu_name' => 'menu' . ($index + 1),
                ]
            ];
            $this->db->table('menu')->insertBatch($menu_data);

            $menuId = $this->db->insertID(); // Get the last inserted menu ID

            // Insert sample data into the item table for each menu
            $item_data = [
                [
                    'menu_id' => $menuId, 
                    'name' => 'Sandwich',
                    'category' => 'Starters',
                    'description' => 'A classic sandwich filled with fresh vegetables, cheese, and your choice of meat, served on toasted bread.',
                    'price' => '10.00',
                ],
                [
                    'menu_id' => $menuId,
                    'name' => 'Vegetable salad',
                    'category' => 'Salad',
                    'description' => 'A refreshing salad bursting with juicy tomatoes, crunchy cucumbers, and a variety of colorful vegetables.',
                    'price' => '15.00',
                ],
                [
                    'menu_id' => $menuId,
                    'name' => 'Pancake',
                    'category' => 'Dessert',
                    'description' => 'Fluffy pancakes made with a secret family recipe, topped with butter and maple syrup.',
                    'price' => '12.00',
                ],
                [
                    'menu_id' => $menuId,
                    'name' => 'Shrimp Pasta',
                    'category' => 'Pasta',
                    'description' => 'Delicious pasta dish with tender shrimp, creamy Alfredo sauce, and a sprinkle of Parmesan cheese.',
                    'price' => '20.00',
                ],
            ];
            $this->db->table('item')->insertBatch($item_data);
        }
    }
}
