<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seeder will insert 3 users in database
        DB::table('users')->delete();
        $users = [
            ['id' => 1, 'name' => 'Loan Account', 'email' => 'loan@test.dev', 'is_real_user' => 0, 'is_admin' => 0, 'password' => ''],
            ['id' => 2, 'name' => 'Admin User', 'email' => 'admin@test.dev', 'is_real_user' => 1, 'is_admin' => 1, 'password' => bcrypt('admin@123')],
            ['id' => 3, 'name' => 'Test User', 'email' => 'user@test.dev', 'is_real_user' => 1, 'is_admin' => 0, 'password' => bcrypt('user@123')],
        ];
        DB::table('users')->insert($users);

        // transaction_types
        DB::table('transaction_types')->delete();
        DB::table('transaction_types')->insert(['id'=>1,'name' => 'Loan' ]);
        DB::table('transaction_types')->insert(['id'=>2,'name' => 'Repayment' ]);
    }
}
