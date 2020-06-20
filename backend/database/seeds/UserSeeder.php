<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Output\ConsoleOutput;

class UserSeeder extends Seeder
{

    protected static $emails = [
        'benpoulson93@gmail.com',
        'chris@huel.com'
    ];

    protected static $password = 'Example123!';

    /**
     * Generate example users
     *
     * @return void
     */
    public function run()
    {
        $output = new ConsoleOutput();

        foreach (self::$emails as $email) {
            \App\User::create([
                'email' => $email,
                'name' => 'Example User',
                'password' => \Hash::make(self::$password)
            ]);
            $output->writeln(sprintf('Generated user "%s" with password "%s"', $email, self::$password));
        }
    }
}
