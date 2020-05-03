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
            'Spicy chorizo',
            'Italian herbs',
            'Mushrooms',
            'Black olives',
            'Cheese',
            'Tomatoes',
            'Blue cheese',
            'Cheddar',
            'Parmesan',
            'Cream sauce',
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
                'base' => 0,
                'hint' => 'The most popular pizza in the world',
                'vegan' => 0,
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
                'base' => 1,
                'hint' => 'Simple but very tasty. It goes well with carbonated drinks.',
                'vegan' => 1,
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
                'base' => 0,
                'hint' => 'A lot of meat does not happen. Great for those who are hungry. Remember to add a foamy drink.',
                'vegan' => 0,
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
                'base' => 0,
                'hint' => 'Simple and tasteful. Great combination of components. We are sure that colored wine will be very handy.',
                'vegan' => 0,
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
                'base' => 0,
                'hint' => 'Feel the notes of Italy. A fascinating combination of ingredients. We highly recommend adding wine, preferably red.',
                'vegan' => 0,
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
                'base' => 1,
                'hint' => 'If you want to relax and enjoy the wonderful tastes, then this option is perfect for those who understand pizza. Perhaps tea will not be superfluous.',
                'vegan' => 0,
                'ingredients' => [
                    'Chicken',
                    'Cheese',
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
                'base' => 1,
                'hint' => 'How about a little exotic? A refreshing set of ingredients will not leave you indifferent. And if you add a non-alcoholic cocktail, then you will not leave the feeling that you are on the beach.',
                'vegan' => 0,
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
                'base' => 1,
                'hint' => 'Perfect for those who need to decorate the holiday. This unusual pizza will appeal to any lover of desserts. Do not forget to add green tea with the lemon.',
                'vegan' => 1,
                'ingredients' => [
                    'Pineapples',
                    'Lingonberries',
                    'Condensed milk'
                ]
            ],
            [
                'name' => 'Four cheeses',
                'image' => 'four_cheeses.jpg',
                'size' => 25,
                'weight' => 400,
                'price' => 20,
                'base' => 1,
                'hint' => 'A lot of cheese does not happen. Make yourself enjoyable and try the rich variety of cream-based cheeses. White wine is perfect here.',
                'vegan' => 1,
                'ingredients' => [
                    'Blue cheese',
                    'Mozzarella',
                    'Cheddar',
                    'Parmesan',
                    'Cream sauce'
                ]
            ],
            [
                'name' => 'Margarita',
                'image' => 'margarita.jpg',
                'size' => 25,
                'weight' => 350,
                'price' => 13,
                'base' => 0,
                'hint' => 'Fragrant and sophisticated. Modest but seductive. An ideal choice for those who want variety. Recommended to try.',
                'vegan' => 1,
                'ingredients' => [
                    'Italian herbs',
                    'Mozzarella',
                    'Tomato sauce',
                    'Tomatoes'
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
                'base' => $pizza['base'],
                'hint' => $pizza['hint'],
                'vegan' => $pizza['vegan'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            foreach ($pizza['ingredients'] as $ingredient) {
                if (!isset($_ingredients[$ingredient])) {
                    throw new Exception('No ingredient');
                }
                DB::table('pizza_ingredients')->insert([
                    'pizza_id' => $pizzaId,
                    'ingredient_id' => $_ingredients[$ingredient]
                ]);
            }
        }
    }
}
