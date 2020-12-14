<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class)->create([
            'name' => 'Anderson Moraes',
            'email' => 'anderson@ycloud.com.br',
            'created_at' => Carbon::now(),
        ]);
    }
}
