<!DOCTYPE html>
<html lang="en">

<?php partial('head'); ?>

<body class="bg-gray-100">
    <?php partial('navbar'); ?>
    <?php partial('top-banner'); ?>

    <section class="flex justify-center items-center mt-20 lg:w-1/2 mx-auto">
        <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-600 mx-6">
            <h2 class="text-4xl text-center font-bold mb-4">Edit Job Listing</h2>
            <form method="POST" action="/listings/<?= $listing->id ?>">
                <input type="hidden" name="_method" value="PUT">
                <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                    Job Info
                </h2>
                <?php partial('errors', ['errors' => $errors ?? []]); ?>
                <div class="mb-4">
                    <input
                        type="text"
                        name="title"
                        placeholder="Job Title"
                        class="w-full px-4 py-2 border rounded focus:outline-none"
                        value="<?= htmlspecialchars($listing->title ?? '') ?>" />
                </div>
                <div class="mb-4">
                    <textarea
                        name="description"
                        placeholder="Job Description"
                        class="w-full px-4 py-2 border rounded focus:outline-none"><?= htmlspecialchars($listing->description ?? '') ?></textarea>
                </div>
                <div class="mb-4">
                    <input
                        type="number"
                        name="salary"
                        placeholder="Annual Salary"
                        class="w-full px-4 py-2 border rounded focus:outline-none"
                        value="<?= htmlspecialchars($listing->salary ?? '') ?>" />
                </div>
                <div class="mb-4">
                    <input
                        type="text"
                        name="requirements"
                        placeholder="Requirements"
                        class="w-full px-4 py-2 border rounded focus:outline-none"
                        value="<?= htmlspecialchars($listing->requirements ?? '') ?>" />
                </div>
                <div class="mb-4">
                    <input
                        type="text"
                        name="benefits"
                        placeholder="Benefits"
                        class="w-full px-4 py-2 border rounded focus:outline-none"
                        value="<?= htmlspecialchars($listing->benefits ?? '') ?>" />
                </div>
                <div class="mb-4">
                    <input
                        type="text"
                        name="tags"
                        placeholder="Tags"
                        class="w-full px-4 py-2 border rounded focus:outline-none"
                        value="<?= htmlspecialchars($listing->tags ?? '') ?>" />
                </div>
                <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                    Company Info & Location
                </h2>
                <div class="mb-4">
                    <input
                        type="text"
                        name="company"
                        placeholder="Company Name"
                        class="w-full px-4 py-2 border rounded focus:outline-none"
                        value="<?= htmlspecialchars($listing->company ?? '') ?>" />
                </div>
                <div class="mb-4">
                    <input
                        type="text"
                        name="address"
                        placeholder="Address"
                        class="w-full px-4 py-2 border rounded focus:outline-none"
                        value="<?= htmlspecialchars($listing->address ?? '') ?>" />
                </div>
                <div class="mb-4">
                    <input
                        type="text"
                        name="city"
                        placeholder="City"
                        class="w-full px-4 py-2 border rounded focus:outline-none"
                        value="<?= htmlspecialchars($listing->city ?? '') ?>" />
                </div>
                <div class="mb-4">
                    <input
                        type="text"
                        name="state"
                        placeholder="State"
                        class="w-full px-4 py-2 border rounded focus:outline-none"
                        value="<?= htmlspecialchars($listing->state ?? '') ?>" />
                </div>
                <div class="mb-4">
                    <input
                        type="tel"
                        name="phone"
                        placeholder="Phone"
                        class="w-full px-4 py-2 border rounded focus:outline-none"
                        value="<?= htmlspecialchars($listing->phone ?? '') ?>" />
                </div>
                <div class="mb-4">
                    <input
                        type="email"
                        name="email"
                        placeholder="Email Address For Applications"
                        class="w-full px-4 py-2 border rounded focus:outline-none"
                        value="<?= htmlspecialchars($listing->email ?? '') ?>" />
                </div>
                <div class="flex items-center gap-2">
                    <button
                        type="submit"
                        class="w-1/2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none">
                        Save
                    </button>
                    <a
                        href="/listings"
                        class="block text-center w-1/2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded focus:outline-none">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </section>

    <?php partial('bottom-banner'); ?>
    <?php partial('footer'); ?>
</body>

</html>