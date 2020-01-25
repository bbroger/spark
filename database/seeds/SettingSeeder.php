<?php


use Phinx\Seed\AbstractSeed;

class SettingSeeder extends AbstractSeed
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
                'name' => 'app.name',
                'value' => 'Spark'
            ],
            [
                'name' => 'app.url',
                'value' => 'http://localhost:8000'
            ],
            [
                'name' => 'font-awesome.kit',
                'value' => 'https://kit.fontawesome.com/5a3176b5aa.js'
            ],
            [
                'name' => 'app.logo',
                'value' => null
            ]
        ];

        $settings = $this->table('settings');

        $settings->truncate();
        $settings->insert($data);

        $settings->save();
    }
}
