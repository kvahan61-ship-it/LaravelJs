<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\Category;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'mod1@example.com')->first() ?? User::first();

        if (!$user) {
            $user = User::create([
                'name' => 'user',
                'email' => 'user@gmail.com',
                'password' => bcrypt('password'),
            ]);
        }

        $phoneCat   = Category::where('name', 'LIKE', '%հեռախոս%')->orWhere('name', 'LIKE', '%phone%')->first();
        $laptopCat  = Category::where('name', 'LIKE', '%լապտոպ%')->orWhere('name', 'LIKE', '%laptop%')->orWhere('name', 'LIKE', '%համակարգիչ%')->first();
        $watchCat   = Category::where('name', 'LIKE', '%ժամ%')->orWhere('name', 'LIKE', '%watch%')->first();

        $fallbackId = Category::first()?->id ?? 1;

        $phoneId  = $phoneCat ? $phoneCat->id : $fallbackId;
        $laptopId = $laptopCat ? $laptopCat->id : $fallbackId;
        $watchId  = $watchCat ? $watchCat->id : $fallbackId;

        $products = [
            [
                'title' => 'Samsung S26 Ultra',
                'category_id' => $phoneId,
                'description' => '256GB, անթերի աշխատանք, գերժամանակակից էկրան և S-Pen գրիչ։',
                'images' => ['S26Ultra.jpeg', 'S26Ultra2.jpeg', 'S26Ultra3.jpeg'],
                'price' => '513900դր',
                'is_published' => 1,
            ],
            [
                'title' => 'iPhone 17 Pro Max',
                'category_id' => $phoneId,
                'description' => 'Նորագույն մոդել, իդեալական կատարելություն, տրվում է պաշտոնական երաշխիք։',
                'images' => ['17promax.jpeg', '17promax2.jpeg', '17promax3.jpeg'],
                'price' => '599000դր',
                'is_published' => 1,

            ],
            [
                'title' => 'MacBook Pro',
                'category_id' => $laptopId,
                'description' => 'Հզորագույն պրոցեսոր, ծրագրավորման և ծանր գրաֆիկական աշխատանքների համար։',
                'images' => ['macbookpro.jpeg', 'macbookpro2.jpeg'],
                'price' => '1024900դր',
                'is_published' => 1,
            ],
            [
                'title' => 'Samsung Galaxy Book',
                'category_id' => $laptopId,
                'description' => 'Թեթև, բարակ և շատ արագագործ նոթբուք ամենօրյա աշխատանքի համար։',
                'images' => ['SamsungBook1.jpeg', 'SamsungBook2.jpeg'],
                'price' => '799000դր',
                'is_published' => 1,
            ],
            [
                'title' => 'Apple Watch Ultra',
                'category_id' => $watchId,
                'description' => 'Սպորտային, դիմացկուն և սմարթ ֆունկցիաներով լեցուն ժամացույց։',
                'images' => ['applewatch1.jpeg', 'applewatch2.jpeg'],
                'price' => '442900դր',
                'is_published' => 1,
            ],
            [
                'title' => 'Smart Watch',
                'category_id' => $watchId,
                'description' => 'Ոճային խելացի ժամացույց, հետևում է առողջությանը և ծանուցումներին։',
                'images' => ['watch.jpeg', 'watch2.jpeg'],
                'price' => '139000դր',
                'is_published' => 1,
            ]
        ];

        foreach ($products as $prod) {

            $post = Post::create([
                'user_id'     => $user->id,
                'title'       => $prod['title'],
                'category_id' => $prod['category_id'],
                'price'       => $prod['price'],
                'description' => $prod['description'],
                'is_published' => $prod['is_published'],
            ]);

            foreach ($prod['images'] as $imgName) {
                PostImage::create([
                    'post_id' => $post->id,
                    'path'    => 'demo-' . $imgName
                ]);
            }
        }
    }
}
