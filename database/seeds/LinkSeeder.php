<?php

use CQ\DB\Seeder;
use CQ\Helpers\Hash;

class LinkSeeder extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $faker = Seeder::faker();
        $data = [];

        for ($i = 0; $i < 5; $i++) {
            $data[] = [
                'id'            => $faker->uuid,
                'user_id'       => $faker->uuid,
                'clicks'        => $faker->numberBetween(0, 10000),
                'short_url'     => $faker->domainWord,
                'long_url'      => $faker->url,
                'password'      => Hash::make($faker->password),
                'expires_at'    => null,
                'updated_at'    => date('Y-m-d H:i:s'),
                'created_at'    => date('Y-m-d H:i:s'),
            ];
        }

        $this->table('links')->insert($data)->saveData();
    }
}
