<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Task
{
    public static function getAllByUser(int $userId): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM tasks WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetchAll();
    }

    public static function create(int $userId, string $title, ?string $description): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO tasks (user_id, title, description) VALUES (:user_id, :title, :description)");

        return $stmt->execute([
            'user_id' => $userId,
            'title' => $title,
            'description' => $description
        ]);
    }

    public static function toggleStatus(int $taskId, int $userId): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            UPDATE tasks 
            SET status = CASE WHEN status = 'pending' THEN 'completed' ELSE 'pending' END 
            WHERE id = :id AND user_id = :user_id
        ");

        return $stmt->execute([
            'id' => $taskId,
            'user_id' => $userId
        ]);
    }

    public static function delete(int $taskId, int $userId): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM tasks WHERE id = :id AND user_id = :user_id");

        return $stmt->execute([
            'id' => $taskId,
            'user_id' => $userId
        ]);
    }

    public static function findByIdAndUser(int $id, int $userId): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM tasks WHERE id = :id AND user_id = :user_id LIMIT 1");
        $stmt->execute(['id' => $id, 'user_id' => $userId]);
        $task = $stmt->fetch();

        return $task ?: null;
    }

    public static function update(int $id, int $userId, string $title, ?string $description): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE tasks SET title = :title, description = :description WHERE id = :id AND user_id = :user_id");

        return $stmt->execute([
            'id' => $id,
            'user_id' => $userId,
            'title' => $title,
            'description' => $description
        ]);
    }
}
