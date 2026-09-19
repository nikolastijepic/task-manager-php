<?php

namespace App\Controllers;

use App\Models\Task;

class TaskController extends Controller
{
    public function __construct()
    {
        if (empty($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }

    public function index(): void
    {
        $userId = $_SESSION['user_id'];
        $tasks = Task::getAllByUser($userId);

        $this->render('tasks/index', [
            'title' => 'Moji Zadaci',
            'tasks' => $tasks,
            'userName' => $_SESSION['user_name'] ?? 'Korisnik'
        ]);
    }

    public function store(): void
    {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (!empty($title)) {
            Task::create($_SESSION['user_id'], $title, $description ?: null);
        }

        $this->redirect('/tasks');
    }

    public function toggle(): void
    {
        $taskId = (int)($_POST['task_id'] ?? 0);

        if ($taskId > 0) {
            Task::toggleStatus($taskId, $_SESSION['user_id']);
        }

        $this->redirect('/tasks');
    }

    public function edit(): void
    {
        $taskId = (int)($_GET['id'] ?? 0);
        $task = Task::findByIdAndUser($taskId, $_SESSION['user_id']);

        if (!$task) {
            $this->redirect('/tasks');
        }

        $this->render('tasks/edit', [
            'title' => 'Izmena zadatka',
            'task' => $task
        ]);
    }

    public function update(): void
    {
        $taskId = (int)($_POST['task_id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($taskId > 0 && !empty($title)) {
            Task::update($taskId, $_SESSION['user_id'], $title, $description ?: null);
        }

        $this->redirect('/tasks');
    }

    public function destroy(): void
    {
        $taskId = (int)($_POST['task_id'] ?? 0);

        if ($taskId > 0) {
            Task::delete($taskId, $_SESSION['user_id']);
        }

        $this->redirect('/tasks');
    }
}
