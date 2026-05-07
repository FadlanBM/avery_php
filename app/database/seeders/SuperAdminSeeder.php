<?php

use App\Core\Database;

class SuperAdminSeeder
{
    public function run()
    {
        $db = Database::getInstance()->getConnection();

        // 1. Seed Roles
        $roles = [
            ['name' => 'superadmin'],
            ['name' => 'staff'],
            ['name' => 'cashier']
        ];

        foreach ($roles as $role) {
            $stmt = $db->prepare("SELECT id FROM role WHERE name = :name");
            $stmt->execute(['name' => $role['name']]);
            if (!$stmt->fetch()) {
                $stmt = $db->prepare("INSERT INTO role (name) VALUES (:name)");
                $stmt->execute(['name' => $role['name']]);
                echo "Role '{$role['name']}' seeded.\n";
            }
        }

        // 2. Seed SuperAdmin User
        $stmt = $db->prepare("SELECT id FROM role WHERE name = 'superadmin'");
        $stmt->execute();
        $superAdminRole = $stmt->fetch();

        if ($superAdminRole) {
            $roleId = $superAdminRole['id'];

            // Check if 'username' column exists, otherwise use 'email'
            $stmt = $db->query("SELECT column_name FROM information_schema.columns WHERE table_name = 'users' AND column_name = 'username'");
            $hasUsername = $stmt->fetch();

            $column = $hasUsername ? 'username' : 'email';
            $value = $hasUsername ? 'superadmin' : 'admin@gmail.com';

            $stmt = $db->prepare("SELECT id FROM users WHERE $column = :val");
            $stmt->execute(['val' => $value]);

            if (!$stmt->fetch()) {
                $password = password_hash('Tempe123', PASSWORD_DEFAULT);

                if ($hasUsername) {
                    $stmt = $db->prepare("INSERT INTO users (name, username, password, role_id, status, remamber) VALUES (:name, :username, :password, :role_id, :status, :remamber)");
                    $stmt->execute([
                        'name' => 'Super Administrator',
                        'username' => 'superadmin',
                        'password' => $password,
                        'role_id' => $roleId,
                        'status' => 1,
                        'remamber' => ''
                    ]);
                } else {
                    $stmt = $db->prepare("INSERT INTO users (name, email, password, role_id, status) VALUES (:name, :email, :password, :role_id, :status)");
                    $stmt->execute([
                        'name' => 'Super Administrator',
                        'email' => 'admin@gmail.com',
                        'password' => $password,
                        'role_id' => $roleId,
                        'status' => 1
                    ]);
                }
                echo "User 'superadmin' seeded with password: password123\n";
            } else {
                echo "User 'superadmin' already exists.\n";
            }
        }
    }
}
