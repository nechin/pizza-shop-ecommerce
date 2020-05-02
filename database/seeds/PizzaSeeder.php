<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PizzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ingredients = [
            'Spicy pepperoni',
            'Tomato sauce',
            'Mozzarella',
            'Pineapples',
            'Lingonberries',
            'Condensed milk',
            'Chicken',
            'Ham',
            'Spicy pepperoni',
            'Spicy chorizo',
            'Italian herbs',
            'Mushrooms',
            'Black olives',
            'Cheese chicken',
            'Tomatoes',
            'Lingonberries',
            'Condensed milk'
        ];
        $_ingredients = [];
        foreach ($ingredients as $ingredient) {
            $ingredientId = DB::table('ingredient')->insertGetId([
                'name' => $ingredient,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            $_ingredients[$ingredient] = $ingredientId;
        }

        $pizzas = [
            [
                'name' => 'Pepperoni',
                'image' => 'pepperoni.jpg',
                'size' => 30,
                'weight' => 350,
                'price' => 15,
                'ingredients' => [
                    'Spicy pepperoni',
                    'Tomato sauce',
                    'Mozzarella'
                ]
            ],
            [
                'name' => 'Cheese',
                'image' => 'cheese.jpg',
                'size' => 25,
                'weight' => 200,
                'price' => 10,
                'ingredients' => [
                    'Tomato sauce',
                    'Mozzarella'
                ]
            ],
            [
                'name' => 'Meat',
                'image' => 'meat.jpg',
                'size' => 30,
                'weight' => 400,
                'price' => 15,
                'ingredients' => [
                    'Chicken',
                    'Ham',
                    'Spicy pepperoni',
                    'Tomato sauce',
                    'Spicy chorizo',
                    'Mozzarella'
                ]
            ],
            [
                'name' => 'Ham and mushrooms',
                'image' => 'ham_and_mushrooms.jpg',
                'size' => 30,
                'weight' => 350,
                'price' => 15,
                'ingredients' => [
                    'Ham',
                    'Tomato sauce',
                    'Mushrooms',
                    'Mozzarella'
                ]
            ],
            [
                'name' => 'Italian',
                'image' => 'italian.jpg',
                'size' => 30,
                'weight' => 350,
                'price' => 17,
                'ingredients' => [
                    'Italian herbs',
                    'Spicy pepperoni',
                    'Tomato sauce',
                    'Mushrooms',
                    'Black olives',
                    'Mozzarella'
                ]
            ],
            [
                'name' => 'Cheese Chicken',
                'image' => 'cheese_chicken.jpg',
                'size' => 35,
                'weight' => 500,
                'price' => 25,
                'ingredients' => [
                    'Chicken',
                    'Cheese chicken',
                    'Tomatoes',
                    'Mozzarella'
                ]
            ],
            [
                'name' => 'Hawaiian',
                'image' => 'hawaiian.jpg',
                'size' => 35,
                'weight' => 400,
                'price' => 20,
                'ingredients' => [
                    'Chicken',
                    'Tomato sauce',
                    'Pineapples',
                    'Mozzarella'
                ]
            ],
            [
                'name' => 'Pizza Pie',
                'image' => 'pie.jpg',
                'size' => 30,
                'weight' => 400,
                'price' => 15,
                'ingredients' => [
                    'Pineapples',
                    'Lingonberries',
                    'Condensed milk'
                ]
            ],
        ];

        foreach ($pizzas as $pizza) {
            $pizzaId = DB::table('pizza')->insertGetId([
                'name' => $pizza['name'],
                'image' => $pizza['image'],
                'size' => $pizza['size'],
                'weight' => $pizza['weight'],
                'price' => $pizza['price'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            foreach ($pizza['ingredients'] as $ingredient) {
                DB::table('pizza_ingredients')->insert([
                    'pizza_id' => $pizzaId,
                    'ingredient_id' => $_ingredients[$ingredient]
                ]);
            }
        }
    }
}
