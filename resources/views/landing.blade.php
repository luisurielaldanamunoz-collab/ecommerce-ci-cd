<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900">
                    <h1 class="text-4xl font-bold mb-4">Bienvenido a Nuestra Tienda</h1>
                    <p class="text-lg text-gray-600 mb-6">
                        Descubre nuestros productos de alta calidad y disfruta de una experiencia de compra excepcional.
                    </p>
                    @guest
                        <div class="space-x-4">
                            <a href="{{ route('login') }}"
                                class="inline-block bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                                Iniciar sesión
                            </a>
                            <a href="{{ route('login') }}"
                                class="inline-block bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700">
                                Continuar
                            </a>
                        </div>
                    @endguest
                </div>
            </div>

            <!-- Quiénes Somos Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-4">¿Quiénes Somos?</h2>
                    <p class="text-gray-600 mb-4">
                        Somos una empresa dedicada a ofrecer productos de excelente calidad a través de nuestra
                        plataforma de comercio electrónico.
                        Con más de 10 años de experiencia en el mercado, nos hemos ganado la confianza de miles de
                        clientes satisfechos.
                    </p>
                    <p class="text-gray-600">
                        Nuestro compromiso es brindar los mejores servicios, productos variados y atención al cliente de
                        primera clase.
                    </p>
                </div>
            </div>

            <!-- Misión y Visión Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">Misión y Visión</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-5">
                            <h3 class="text-xl font-semibold mb-3 text-indigo-700">Misión</h3>
                            <p class="text-gray-600">
                                Ofrecer una experiencia de compra en línea simple, segura y confiable, brindando
                                productos de calidad
                                y un servicio al cliente cercano que supere las expectativas de nuestros usuarios.
                            </p>
                        </div>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-5">
                            <h3 class="text-xl font-semibold mb-3 text-indigo-700">Visión</h3>
                            <p class="text-gray-600">
                                Ser la tienda en línea referente en la región por nuestra innovación, variedad de
                                productos y compromiso
                                con la satisfacción de cada cliente en cada etapa de su compra.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contáctanos Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-4">Contáctanos</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <h3 class="font-semibold mb-2">Email</h3>
                            <p class="text-gray-600">
                                <a href="mailto:info@tienda.com" class="text-indigo-600 hover:underline">
                                    info@tienda.com
                                </a>
                            </p>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-2">Teléfono</h3>
                            <p class="text-gray-600">+34 123 456 789</p>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-2">Dirección</h3>
                            <p class="text-gray-600">Calle Principal, 123<br>Madrid, España</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Servicios Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-4">Nuestros Servicios</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="border-l-4 border-indigo-600 pl-4">
                            <h3 class="font-semibold mb-2">Envíos Rápidos</h3>
                            <p class="text-gray-600">Entrega en 24-48 horas en toda España</p>
                        </div>
                        <div class="border-l-4 border-indigo-600 pl-4">
                            <h3 class="font-semibold mb-2">Garantía de Calidad</h3>
                            <p class="text-gray-600">Todos nuestros productos están garantizados</p>
                        </div>
                        <div class="border-l-4 border-indigo-600 pl-4">
                            <h3 class="font-semibold mb-2">Soporte 24/7</h3>
                            <p class="text-gray-600">Atención al cliente disponible siempre</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reseñas Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-4">Reseñas del servicio</h2>
                    <div class="space-y-4">
                        <article class="border border-gray-200 rounded-lg p-5">
                            <div class="flex items-center justify-between mb-2">
                                <p class="font-semibold">María González</p>
                                <p class="text-yellow-500">★★★★★</p>
                            </div>
                            <p class="text-gray-700">"Excelente atención, entrega puntual y producto tal como se describe. Repetiré compra sin duda."</p>
                        </article>
                        <article class="border border-gray-200 rounded-lg p-5">
                            <div class="flex items-center justify-between mb-2">
                                <p class="font-semibold">Carlos Ramírez</p>
                                <p class="text-yellow-500">★★★★☆</p>
                            </div>
                            <p class="text-gray-700">"Muy buen servicio al cliente y soporte rápido. Mejoraría la opción de seguimiento de pedido en la app."</p>
                        </article>
                        <article class="border border-gray-200 rounded-lg p-5">
                            <div class="flex items-center justify-between mb-2">
                                <p class="font-semibold">Ingrid Salas</p>
                                <p class="text-yellow-500">★★★★☆</p>
                            </div>
                            <p class="text-gray-700">"Buena experiencia general, solo tuve una demora menor con el envío, pero el producto llegó en perfectas condiciones."</p>
                        </article>
                    </div>
                </div>
            </div>

            <!-- Explorar Tienda Section -->
            @auth
                <div class="bg-indigo-50 overflow-hidden shadow-sm sm:rounded-lg text-center p-6">
                    <h2 class="text-2xl font-bold mb-4">Explora Nuestra Tienda</h2>
                    <a href="{{ route('home') }}"
                        class="inline-block bg-indigo-600 text-white px-8 py-3 rounded hover:bg-indigo-700">
                        Ver Productos
                    </a>
                </div>
            @endauth
        </div>
    </div>
</x-app-layout>
