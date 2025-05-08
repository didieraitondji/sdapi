<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SOUAIBOU DISTRIBUTION API</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600" rel="stylesheet" />
    <link rel="icon" href="{{ asset('SOUAIBOU.png') }}" type="image/x-icon" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4f46e5',
                        secondary: '#10b981',
                        accent: '#f59e0b',
                        darkbg: '#0a0a0a',
                        lightbg: '#f8fafc'
                    }
                }
            }
        };
    </script>
</head>

<body class="bg-lightbg dark:bg-darkbg text-gray-900 dark:text-gray-100 min-h-screen font-[inter]">

    <header class="w-full bg-white dark:bg-gray-900 shadow px-6 py-4">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="{{ asset('SOUAIBOU.png') }}" alt="Logo" class="w-10 h-10">
                <h1 class="text-2xl font-bold text-primary">sdapi</h1>
            </div>
            <nav class="flex gap-3">
                <a href="/login" class="text-sm px-4 py-2 border border-primary text-primary rounded hover:bg-primary hover:text-white transition">Connexion</a>
                <a href="/register" class="text-sm px-4 py-2 border border-primary text-primary rounded hover:bg-primary hover:text-white transition">Inscription</a>
            </nav>
        </div>
    </header>

    <main class="max-w-6xl mx-auto mt-10 px-6 grid grid-cols-1 lg:grid-cols-3 gap-10">

        <!-- Contenu principal -->
        <section class="lg:col-span-2 bg-white dark:bg-gray-900 p-8 rounded-lg shadow space-y-6">
            <h2 class="text-3xl font-bold text-primary">Bienvenue sur l'API de SOUAIBOU DISTRIBUTION</h2>
            <p class="text-gray-600 dark:text-gray-300">
                Cette API a été développée avec Laravel pour fournir des fonctionnalités backend robustes.
            </p>

            <!-- Répartition en deux colonnes -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-xl font-semibold mb-2">Fonctionnalités disponibles :</h3>
                    <ul class="list-disc list-inside text-gray-700 dark:text-gray-200 space-y-1">
                        <li>API RESTful complète</li>
                        <li>Authentification sécurisée</li>
                        <li>Gestion des produits</li>
                        <li>Gestion des clients</li>
                        <li>Gestion des commandes</li>
                        <li>Historique des commandes</li>
                        <li>Statistiques</li>
                        <li>Autres fonctionnalités</li>
                    </ul>
                </div>

                <div class="space-y-6">
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Documentation API :</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-2">Consultez la documentation pour apprendre à utiliser l'API.</p>
                        <a href="/api/documentation" class="inline-flex items-center gap-2 text-primary font-medium hover:underline">
                            Voir la documentation
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <a href="/api/products" class="bg-primary text-white px-5 py-2.5 rounded-lg hover:bg-indigo-700 transition">
                            Voir les produits
                        </a>

                    </div>
                </div>
            </div>
        </section>

        <!-- Section latérale droite -->
        <aside class="flex items-center justify-center">
            <div class="w-full bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-800 dark:to-purple-800 p-8 rounded-xl shadow text-center">
                <svg class="w-20 h-20 mx-auto text-primary dark:text-secondary mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Prêt à interagir avec l'API ? Utilisez nos routes pour consulter les données.
                </p>
            </div>
        </aside>

    </main>


</body>

</html>