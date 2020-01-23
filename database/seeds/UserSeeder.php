<?php

use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Ashura',
                'email' => 'ashura@ashura.com',
                'password' => password_hash('123456', PASSWORD_DEFAULT),
                'type' => 'admin'
            ]
        ];

        $this->table('posts')
            ->insert($data)
            ->save();
    }
}
