<?php

/** @var array $task */
?>

<!DOCTYPE html>
<html lang="sr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Izmena zadatka' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200 w-full max-w-lg">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-bold text-gray-800">Izmeni zadatak</h1>
            <a href="/tasks" class="text-sm text-gray-500 hover:text-gray-700">← Nazad</a>
        </div>

        <form action="/tasks/update" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= \App\Core\Csrf::getToken() ?>">
            <input type="hidden" name="task_id" value="<?= $task['id'] ?>">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Naslov zadatka</label>
                <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Opis</label>
                <textarea name="description" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"><?= htmlspecialchars($task['description'] ?? '') ?></textarea>
            </div>

            <div class="flex justify-end space-x-3 pt-2">
                <a href="/tasks" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition">Otkaži</a>
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 text-sm rounded-lg font-medium hover:bg-blue-700 transition">
                    Sačuvaj izmene
                </button>
            </div>
        </form>
    </div>

</body>

</html>