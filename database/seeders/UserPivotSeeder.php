<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserPivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            
            1 => [
                'roles' => [1],
            ],

        ];

        foreach ($roles as $id => $role) {
            $user = User::find($id);

            foreach ($role as $key => $ids) {
                $user->{$key}()->sync($ids);
            }
        }
    }
}
