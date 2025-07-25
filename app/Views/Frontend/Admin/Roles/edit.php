<div class="px-4 py-6 sm:px-0">
    <div class="rounded-lg bg-white p-6 shadow-sm">
        <div class="border-b border-gray-200 pb-5">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Role</h3>
            <p class="mt-2 text-sm text-gray-500">Update the role details and permissions</p>
        </div>
        
        <form class="mt-6 space-y-6" action="<?= base_url('admin/roles/edit/' . $role['id']) ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <div class="sm:col-span-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Role Name</label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" required
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="<?= old('name', $role['name']) ?>">
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <div class="mt-1">
                        <textarea id="description" name="description" rows="3"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"><?= old('description', $role['description']) ?></textarea>
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <label class="block text-sm font-medium text-gray-700">Permissions</label>
                    <p class="mt-1 text-sm text-gray-500">Select the permissions to assign to this role</p>
                    <div class="mt-4 space-y-4">
                        <div class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 lg:grid-cols-3">
                            <?php foreach ($permissions as $permission): ?>
                                <div class="relative flex items-start">
                                    <div class="flex h-5 items-center">
                                        <input id="permission-<?= $permission['id'] ?>" name="permissions[]" type="checkbox" value="<?= $permission['id'] ?>"
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                            <?= in_array($permission['id'], old('permissions', $assignedPermissionIds)) ? 'checked' : '' ?>>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="permission-<?= $permission['id'] ?>" class="font-medium text-gray-700"><?= esc($permission['name']) ?></label>
                                        <p class="text-gray-500"><?= esc($permission['description']) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <a href="<?= base_url('admin/roles') ?>" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Cancel
                </a>
                <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Update Role
                </button>
            </div>
        </form>
    </div>
</div>