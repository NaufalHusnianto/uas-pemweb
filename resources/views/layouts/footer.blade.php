<footer class="text-black py-12 border-t border-gray-500 mx-8">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-lg font-bold mb-4">About Us</h3>
                <p class="text-sm">
                    We provide high-quality sportswear and footwear to help you elevate your performance. Explore our latest collections and embrace your passion for sports.
                </p>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('dashboard') }}" class="text-sm text-gray-500">New & Featured</a></li>
                    <li><a href="{{ route('dashboard') }}" class="text-sm text-gray-500">Men</a></li>
                    <li><a href="{{ route('dashboard') }}" class="text-sm text-gray-500">Women</a></li>
                    <li><a href="{{ route('dashboard') }}" class="text-sm text-gray-500">Kids</a></li>
                    <li><a href="{{ route('dashboard') }}" class="text-sm text-gray-500">Sale</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-4">Contact Us</h3>
                <p class="text-sm mb-4">
                    Email: <a href="mailto:contact@yourstore.com" class="text-gray-500">contact@mikeofficial.com</a><br>
                    Phone: <a href="tel:+1234567890" class="text-gray-500">+123 456 7890</a>
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-500">
                        <x-heroicon-o-link class="h-5 w-5" />
                    </a>
                    <a href="#" class="text-gray-500">
                        <x-heroicon-o-link class="h-5 w-5" />
                    </a>
                    <a href="#" class="text-gray-500">
                        <x-heroicon-o-link class="h-5 w-5" />
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-4 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Mike, Inc. All rights reserved.
        </div>
    </div>
</footer>
