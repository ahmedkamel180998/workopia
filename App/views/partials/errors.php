<?php if (!empty($errors)) : ?>
    <div class="bg-red-100 p-3 my-3">
        <ul class="list-disc list-inside text-red-700">
            <?php foreach ($errors as $error) : ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>