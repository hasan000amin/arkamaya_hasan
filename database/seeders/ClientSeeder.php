<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = [
            [
                'client_id' => 1,
                'client_name' => 'NEC',
                'client_address' => 'Jakarta',
            ],
            [
                'client_id' => 2,
                'client_name' => 'TAM',
                'client_address' => 'Jakarta',
            ],
            [
                'client_id' => 3,
                'client_name' => 'TUA',
                'client_address' => 'Bandung',
            ],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}
