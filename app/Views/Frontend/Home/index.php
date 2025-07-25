<div class="px-4 py-6 sm:px-0">
    <div class="rounded-lg bg-white p-6 shadow-sm">
        <h1 class="text-3xl font-bold text-gray-900 mb-4"><?= esc($title) ?></h1>
        <p class="text-gray-600 mb-6"><?= esc($description) ?></p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-blue-50 p-6 rounded-lg">
                <h2 class="text-xl font-semibold text-blue-800 mb-2">Multiple User Roles</h2>
                <p class="text-blue-600">Admin, Editor, and User roles with different permissions.</p>
            </div>
            
            <div class="bg-green-50 p-6 rounded-lg">
                <h2 class="text-xl font-semibold text-green-800 mb-2">Secure Authentication</h2>
                <p class="text-green-600">Password hashing, CSRF protection, and session management.</p>
            </div>
            
            <div class="bg-purple-50 p-6 rounded-lg">
                <h2 class="text-xl font-semibold text-purple-800 mb-2">Admin Dashboard</h2>
                <p class="text-purple-600">Manage users, roles, and permissions with ease.</p>
            </div>
        </div>
        
        <?php if (!session()->get('isLoggedIn')): ?>
            <div class="mt-8 flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="<?= base_url('login') ?>" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Login to your account
                </a>
                <a href="<?= base_url('register') ?>" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Register new account
                </a>
            </div>
        <?php else: ?>
            <div class="mt-8">
                <a href="<?= base_url('dashboard') ?>" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Go to Dashboard
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>