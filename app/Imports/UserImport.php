<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Spatie\Permission\Models\Role;

class UserImport implements ToModel, WithHeadingRow
{
    use Importable;

    /**
     * @return User|null
     */
    public function model(array $row)
    {
        if (empty($row['nama']) || empty($row['email'])) {
            return null;
        }

        $user = User::create([
            'name' => $row['nama'],
            'email' => strtolower($row['email']),
            'initial' => ! empty($row['inisial']) ? strtoupper($row['inisial']) : null,
        ]);

        $roleName = $row['jabatan'] ?? null;

        if ($roleName) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $user->assignRole($role);
            }
        }

        return $user;
    }
}
