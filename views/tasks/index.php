<!DOCTYPE html>
<html lang="sr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Task Manager' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen">

    <nav class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-800">Task Manager</h1>
        <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-600">Zdravo, <strong><?= htmlspecialchars($userName ?? 'Korisnik') ?></strong></span>
            <a href="/logout" class="text-sm bg-red-50 text-red-600 hover:bg-red-100 px-3 py-1.5 rounded-lg transition font-medium">Odjavi se</a>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto p-6 space-y-6">

        <section class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Novi zadatak</h2>
            <form action="/tasks/create" method="POST" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?= \App\Core\Csrf::getToken() ?>">
                <div>
                    <input type="text" name="title" placeholder="Naslov zadatka..." required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <textarea name="description" rows="2" placeholder="Opis (opciono)..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-blue-700 transition">
                    Dodaj zadatak
                </button>
            </form>
        </section>

        <section class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Lista zadataka</h2>

            <?php if (empty($tasks)): ?>
                <p class="text-gray-500 text-sm">Trenutno nemate unesenih zadataka.</p>
            <?php else: ?>
                <div class="divide-y divide-gray-100">
                    <?php foreach ($tasks as $task): ?>
                        <div class="py-4 flex items-center justify-between gap-4">
                            <div class="space-y-1">
                                <h3 class="font-medium text-gray-900 <?= $task['status'] === 'completed' ? 'line-through text-gray-400' : '' ?>">
                                    <?= htmlspecialchars($task['title']) ?>
                                </h3>
                                <?php if (!empty($task['description'])): ?>
                                    <p class="text-sm text-gray-500"><?= htmlspecialchars($task['description']) ?></p>
                                <?php endif; ?>
                                <span class="inline-block text-xs px-2 py-0.5 rounded <?= $task['status'] === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' ?>">
                                    <?= $task['status'] === 'completed' ? 'Završeno' : 'U toku' ?>
                                </span>
                            </div>

                            <div class="flex items-center space-x-2">
                                <a href="/tasks/edit?id=<?= $task['id'] ?>" class="text-xs bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-1.5 rounded-md transition font-medium">
                                    Izmeni
                                </a>

                                <form action="/tasks/toggle" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?= \App\Core\Csrf::getToken() ?>">
                                    <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                    <button type="submit" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-md transition">
                                        <?= $task['status'] === 'completed' ? 'Vrati' : 'Završi' ?>
                                    </button>
                                </form>

                                <form action="/tasks/delete" method="POST" onsubmit="return confirm('Sigurno želite obrisati zadatak?')">
                                    <input type="hidden" name="csrf_token" value="<?= \App\Core\Csrf::getToken() ?>">
                                    <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                    <button type="submit" class="text-xs bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1.5 rounded-md transition">
                                        Obriši
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

    </main>

</body>

</html>