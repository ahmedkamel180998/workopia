<!-- Footer -->
<footer class="bg-blue-900 text-white py-10 mt-auto">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
            <!-- Brand -->
            <div class="md:col-span-2">
                <h3 class="text-2xl font-bold mb-3">Workopia</h3>
                <p class="text-blue-200 leading-relaxed">Find your dream job or the perfect candidate. Workopia connects talent with opportunity.</p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-bold mb-3">Quick Links</h4>
                <ul class="grid grid-cols-2 gap-2">
                    <li><a href="/" class="text-blue-200 hover:text-yellow-400 transition">Home</a></li>
                    <li><a href="/listings" class="text-blue-200 hover:text-yellow-400 transition">Browse Jobs</a></li>
                    <li><a href="/listings/create" class="text-blue-200 hover:text-yellow-400 transition">Post a Job</a></li>
                    <li><a href="/login" class="text-blue-200 hover:text-yellow-400 transition">Login</a></li>
                    <li><a href="/register" class="text-blue-200 hover:text-yellow-400 transition">Register</a></li>
                </ul>
            </div>

            <!-- Contact / Social -->
            <div>
                <h4 class="text-lg font-bold mb-3">Follow Us</h4>
                <div class="flex space-x-5 mb-5">
                    <a href="#" class="text-blue-200 hover:text-yellow-400 transition text-2xl"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-blue-200 hover:text-yellow-400 transition text-2xl"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-blue-200 hover:text-yellow-400 transition text-2xl"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="text-blue-200 hover:text-yellow-400 transition text-2xl"><i class="fab fa-github"></i></a>
                </div>
                <p class="text-blue-200"><i class="fa fa-envelope mr-2"></i>support@workopia.com</p>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="border-t border-blue-800 mt-10 pt-5 text-center text-blue-300 text-sm">
            <p>&copy; <?= date('Y') ?> Workopia. All rights reserved.</p>
        </div>
    </div>
</footer>