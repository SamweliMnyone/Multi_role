<div class="px-4 py-6 sm:px-0">
    <div class="rounded-lg bg-white p-6 shadow-sm">
        <div class="border-b border-gray-200 pb-5">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Create New Permission</h3>
            <p class="mt-2 text-sm text-gray-500">Define a new system permission</p>
        </div>
        
        <form class="mt-6 space-y-6" action="<?= base_url('admin/permissions/create') ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <div class="sm:col-span-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Permission Name</label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" required
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="<?= old('name') ?>">
                        <p class="mt-2 text-sm text-gray-500">Use lowercase with underscores (e.g., 'edit_content')</p>
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <div class="mt-1">
                        <textarea id="description" name="description" rows="3"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"><?= old('description') ?></textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <a href="<?= base_url('admin/permissions') ?>" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Cancel
                </a>
                <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Create Permission
                </button>
            </div>
        </form>
    </div>
</div>