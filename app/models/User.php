<?php
class User extends Model {
    protected string $table = 'users';

    public function findByUsername(string $username): ?array
    {
        return $this->findOneWhere(['username' => $username]);
    }

    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
