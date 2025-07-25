<div class="border-b border-gray-200 pb-5 flex justify-between items-center">
    <div>
        <h3 class="text-lg font-medium leading-6 text-gray-900">Dashboard</h3>
        <p class="mt-2 text-sm text-gray-500">Welcome back, <?= esc($user['first_name']) ?>!</p>
    </div>
    <a href="<?= base_url('logout') ?>" 
       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
        <i class="fas fa-sign-out-alt mr-2"></i> Logout
    </a>
</div>
        
        <div class="mt-6">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                                    <i class="fas fa-user text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="truncate text-sm font-medium text-gray-500">Account</dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900"><?= esc($user['first_name'] . ' ' . $user['last_name']) ?></div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <span class="font-medium text-indigo-600 hover:text-indigo-500">
                                Role: <?= esc($user['role_name']) ?>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                    <i class="fas fa-clock text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="truncate text-sm font-medium text-gray-500">Last Login</dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            <?= $user['last_login'] ? date('M j, Y g:i A', strtotime($user['last_login'])) : 'First login' ?>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <span class="font-medium text-green-600 hover:text-green-500">
                                <i class="fas fa-envelope mr-1"></i> <?= esc($user['email']) ?>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                                    <i class="fas fa-key text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="truncate text-sm font-medium text-gray-500">Permissions</dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            <?= count($permissions) ?> assigned
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <a href="#" class="font-medium text-purple-600 hover:text-purple-500">
                                View all permissions
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-8">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Your Permissions</h3>
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Permission</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Description</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <?php if (empty($permissions)): ?>
                            <tr>
                                <td colspan="2" class="px-3 py-4 text-sm text-gray-500 text-center">No permissions assigned</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($permissions as $permission): ?>
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        <?= esc($permission['name']) ?>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <?= esc($permission['description']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<form id="logoutForm" action="<?= site_url('logout') ?>" method="post" style="display: none;">
    <?= csrf_field() ?>
</form>

<!-- In your header -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- Before closing body tag -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Add this to your main layout file or a JS file
document.addEventListener('DOMContentLoaded', function() {
    // Handle logout confirmation with SweetAlert
    const logoutButtons = document.querySelectorAll('[data-logout]');
    
    logoutButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Logout Confirmation',
                text: 'Are you sure you want to logout?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, logout!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the logout form
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = this.href;
                    
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '<?= csrf_token() ?>';
                    csrf.value = '<?= csrf_hash() ?>';
                    form.appendChild(csrf);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
});
</script>