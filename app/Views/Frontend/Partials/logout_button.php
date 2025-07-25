<form method="POST" action="<?= base_url('logout') ?>">
    <?= csrf_field() ?>
    <button type="submit" 
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
        <i class="fas fa-sign-out-alt mr-2"></i> Logout
    </button>
</form>