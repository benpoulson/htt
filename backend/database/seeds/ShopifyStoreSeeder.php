<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Output\ConsoleOutput;

class ShopifyStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $output = new ConsoleOutput();

        if (!env('EXAMPLE_STORE_API_KEY') || !env('EXAMPLE_STORE_PASSWORD') || !env('EXAMPLE_STORE_DOMAIN') || !env('EXAMPLE_STORE_SHARED_SECRET')) {
            $output->writeln('Missing .env values!');
            $output->writeln('Ensure the following values are specified; EXAMPLE_STORE_API_KEY, EXAMPLE_STORE_PASSWORD, EXAMPLE_STORE_DOMAIN, EXAMPLE_STORE_SHARED_SECRET');
            die();
        }

        \App\ShopifyStore::create([
            'name' => 'Example Store',
            'domain' => env('EXAMPLE_STORE_DOMAIN'),
            'api_key' =>  env('EXAMPLE_STORE_API_KEY'),
            'password' => env('EXAMPLE_STORE_PASSWORD'),
            'shared_secret' => env('EXAMPLE_STORE_SHARED_SECRET'),
        ]);
    }
}
