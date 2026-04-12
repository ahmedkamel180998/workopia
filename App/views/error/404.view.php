<!DOCTYPE html>
<html lang="en">

<?php partial('head'); ?>

<body class="bg-gray-100 flex flex-col min-h-screen">
    <?php partial('navbar'); ?>
    <?php partial('top-banner'); ?>

    <!-- 404 Error -->
    <section class="flex-grow">
        <div class="container mx-auto p-4 mt-4">
            <div class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3">404 Error</div>
            <p class="text-center text-2xl mb-4">
                This page does not exist
            </p>
        </div>
    </section>

    <?php partial('footer'); ?>
</body>

</html>