<!DOCTYPE html>
<html lang="sr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Registracija' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Registracija</h1>

        <?php if (!empty($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="/register" method="POST" class="space-y-4">

            <input type="hidden" name="csrf_token" value="<?= \App\Core\Csrf::getToken() ?>">

            <div>
                <label class="block text-sm font-medium text-gray-700">Ime i prezime</label>
                <input type="text" name="name" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email adresa</label>
                <input type="email" name="email" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Lozinka</label>
                <input type="password" name="password" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg font-medium hover:bg-blue-700 transition">
                Kreiraj nalog
            </button>
        </form>

        <p class="text-sm text-gray-600 mt-4 text-center">
            Već imaš nalog? <a href="/login" class="text-blue-600 hover:underline">Prijavi se</a>
        </p>
    </div>

</body>

</html>