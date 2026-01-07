<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Website;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        
        $client1 = Client::create([
            'email' => 'donepudideviprasanna@gmail.com',
        ]);

        Website::create([
            'client_id' => $client1->id,
            'url' => 'https://example.com',
        ]);

        Website::create([
            'client_id' => $client1->id,
            'url' => 'https://google.com',
        ]);

        Website::create([
            'client_id' => $client1->id,
            'url' => 'https://github.com',
        ]);

        
        $client2 = Client::create([
            'email' => 'lekkalapudichetan@gmail.com',
        ]);

        Website::create([
            'client_id' => $client2->id,
            'url' => 'https://laravel.com',
        ]);

        Website::create([
            'client_id' => $client2->id,
            'url' => 'https://vuejs.org',
        ]);

        Website::create([
            'client_id' => $client2->id,
            'url' => 'https://stackoverflow.com',
        ]);

        echo "✅ Test data created successfully!\n";
        echo "Client 1: donepudideviprasanna@gmail.com (3 websites)\n";
        echo "Client 2: lekkalapudichetan@gmail.com (3 websites)\n";
    }
}
