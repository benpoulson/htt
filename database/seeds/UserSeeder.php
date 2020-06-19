<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Output\ConsoleOutput;

class UserSeeder extends Seeder
{
    /**
     * Generate example users
     *
     * @return void
     */
    public function run()
    {
        $output = new ConsoleOutput();

        $emails = [
            'benpoulson93@gmail.com',
            'chris@huel.com'
        ];

        foreach ($emails as $email) {
            $password = \Illuminate\Support\Str::random(16);

            \App\User::create([
                'email' => $email,
                'name' => 'Example User',
                'password' => \Hash::make($password)
            ]);

            $output->writeln(sprintf('Generated user "%s" with password "%s"', $email, $password));
        }
    }
}
