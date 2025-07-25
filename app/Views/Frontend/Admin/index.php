<div class="px-4 py-6 sm:px-0">
    <div class="rounded-lg bg-white p-6 shadow-sm">
        <div class="border-b border-gray-200 pb-5">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Admin Dashboard</h3>
            <p class="mt-2 text-sm text-gray-500">Manage your application settings and users</p>
        </div>
        
        <div class="mt-6">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                <!-- Users Card -->
                <div class="overflow-hidden rounded-lg bg-white shadow border border-gray-200">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                    <i class="fas fa-users text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="truncate text-sm font-medium text-gray-500">Total Users</dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900"><?= $userCount ?></div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <a href="<?= base_url('admin/users') ?>" class="font-medium text-blue-600 hover:text-blue-500">
                                View all users
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Roles Card -->
                <div class="overflow-hidden rounded-lg bg-white shadow border border-gray-200">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                    <i class="fas fa-user-tag text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="truncate text-sm font-medium text-gray-500">Total Roles</dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900"><?= $roleCount ?></div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <a href="<?= base_url('admin/roles') ?>" class="font-medium text-green-600 hover:text-green-500">
                                View all roles
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Permissions Card -->
                <div class="overflow-hidden rounded-lg bg-white shadow border border-gray-200">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                                    <i class="fas fa-key text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="truncate text-sm font-medium text-gray-500">Total Permissions</dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900"><?= $permissionCount ?></div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <a href="<?= base_url('admin/permissions') ?>" class="font-medium text-purple-600 hover:text-purple-500">
                                View all permissions
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-8">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <a href="<?= base_url('admin/users/create') ?>" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <i class="fas fa-user-plus"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="text-sm font-medium text-gray-900">Add New User</p>
                        <p class="text-sm text-gray-500 truncate">Create a new user account</p>
                    </div>
                </a>
                
                <a href="<?= base_url('admin/roles/create') ?>" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                            <i class="fas fa-tag"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="text-sm font-medium text-gray-900">Create New Role</p>
                        <p class="text-sm text-gray-500 truncate">Define a new user role</p>
                    </div>
                </a>
                
                <a href="<?= base_url('admin/permissions/create') ?>" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                            <i class="fas fa-key"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="text-sm font-medium text-gray-900">Add New Permission</p>
                        <p class="text-sm text-gray-500 truncate">Create a new permission</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>