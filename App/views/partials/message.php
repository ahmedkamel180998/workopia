<?php

use Framework\Session;
?>

<?php if ($successMessage = Session::getFlashMessage('success_message')): ?>
    <div class="message bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        <?= $successMessage ?>
    </div>
<?php endif ?>
<?php if ($errorMessage = Session::getFlashMessage('error_message')): ?>
    <div class="message bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?= $errorMessage ?>
    </div>
<?php endif ?>