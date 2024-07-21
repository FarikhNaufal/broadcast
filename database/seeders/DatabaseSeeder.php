<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Group;
use App\Models\Media;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Muhammad Farikh Naufal Tajuddin',
        //     'email' => 'mfarikh9@gmail.com',
        // ]);

        Media::create([
            'name' => 'Mars UISI',
            'type' => 'youtube',
            'data' => 'eLe-pR78zAE',
        ]);
        Media::create([
            'name' => 'Profil Informatika UISI',
            'type' => 'youtube',
            'data' => 'ZkGIg4_lnvA&t=2s',
        ]);
        Media::create([
            'name' => 'Himbauan dilarang merokok',
            'type' => 'text',
            'data' => 'Merokok mungkin merupakan hal biasa bagi sebagian orang karena bisa menjadikan hidupnya lebih semangat, ada juga karena ingin terlihat trendi di hadapan teman dan orang-orang disekitarnya. Sedangkan sebagian beranggapan bahwa kalau tidak merokok hidupnya terasa ada yang kurang enak dan mulut terasa seakan kecut dan tidak enak. Tapi mereka tidak tahu apa sebenarnya bahaya dari merokok untuk kesehatan dirinya sendiri, dan juga orang-orang  disekitarnya. Aktivitas merokok bisa merusak kesehatan dan untuk yang menghisap asap rokok (perokok pasif) mempunyai risiko terkena peyakit yang sama.',
        ]);

        // Media::create([
        //     'name' => 'Himbauan',
        //     'type' => 'text',
        //     'data' => 'Dilarang Merokok Di Area Kampus',
        // ]);

        // Group::create([
        //     'name' => 'Group 1',
        //     'description' => fake()->sentence(),
        //     'media_id' => 1,
        // ]);



        // Client::create([
        //     'name' => 'c1',
        //     'password' => bcrypt('123'),
        //     'group_id' => 1,
        // ]);

        // Client::create([
        //     'name' => 'c2',
        //     'password' => bcrypt('123'),
        //     'group_id' => 1,
        // ]);

        // Client::create([
        //     'name' => 'c3',
        //     'password' => bcrypt('123'),
        // ]);

        // Client::create([
        //     'name' => 'c4',
        //     'password' => bcrypt('123'),
        // ]);
    }
}
