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
                'value' => ''
            ]
        ];

        $this->table('settings')
            ->insert($data)
            ->save();
    }
}
