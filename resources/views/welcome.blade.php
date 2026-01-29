<x-site-layout title="Welcome">

    <!-- HERO SECTION -->
    <section class="relative bg-gradient-to-br from-blue-50 via-teal-50 to-indigo-100 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-teal-400 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-400 rounded-full filter blur-3xl"></div>
        </div>
        
        <div class="relative container mx-auto px-6 py-24">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold bg-gradient-to-r from-teal-600 to-blue-600 bg-clip-text text-transparent mb-6">
                    Find Your Perfect Doctor
                </h1>
                <p class="text-xl md:text-2xl text-gray-700 mb-8 leading-relaxed">
                    Connect with top-rated medical professionals, explore trusted clinics, and book appointments seamlessly
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-white/20">
                        <div class="text-sm text-gray-500 mb-2">Available Doctors</div>
                        <div class="text-3xl font-bold text-teal-600">500+</div>
                    </div>
                    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-white/20">
                        <div class="text-sm text-gray-500 mb-2">Happy Patients</div>
                        <div class="text-3xl font-bold text-blue-600">10,000+</div>
                    </div>
                    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-white/20">
                        <div class="text-sm text-gray-500 mb-2">Appointments Today</div>
                        <div class="text-3xl font-bold text-indigo-600">250+</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SEARCH SECTION -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-3">Search Medical Cabinets</h2>
                <p class="text-gray-600">Find the perfect healthcare provider for your needs</p>
            </div>
            <div class="max-w-3xl mx-auto">
                <livewire:cabinet-search />
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT AREA WITH SIDEBAR -->
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- MAIN CONTENT -->
            <div class="lg:col-span-3 space-y-16">

                <!-- POPULAR CABINETS SECTION -->
                <section class="py-16 bg-gradient-to-b from-gray-50 to-white rounded-3xl">
                    <div class="mb-12">
                        <h2 class="text-4xl font-bold text-gray-800 mb-4 text-center">⭐ Most Popular Cabinets</h2>
                        <p class="text-xl text-gray-600 text-center">Highly-rated medical professionals trusted by our community</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        @foreach($popularCabinets as $cabinet)
                            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-teal-200">
                                
                                <!-- Header with Doctor Info -->
                                <div class="bg-gradient-to-r from-teal-500 to-blue-500 p-6">
                                    <div class="flex items-center gap-4">
                                        <div class="relative">
                                            <img
                                                src="{{ $cabinet->doctor->getFirstMediaUrl('profile')
                                                    ?: 'https://ui-avatars.com/api/?size=128&name=' . urlencode($cabinet->doctor->name) }}"
                                                class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-lg"
                                                alt="{{ $cabinet->doctor->name }}"
                                            >
                                            <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-400 rounded-full border-2 border-white"></div>
                                        </div>
                                        <div class="text-white">
                                            <p class="text-sm opacity-90 font-medium">Medical Professional</p>
                                            <h3 class="text-xl font-bold">{{ $cabinet->doctor->name }}</h3>
                                            <div class="flex items-center gap-1 mt-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 fill-yellow-300" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cabinet Content -->
                                <div class="p-6 space-y-4">
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-900 mb-2 group-hover:text-teal-600 transition-colors">
                                            {{ $cabinet->name }}
                                        </h3>
                                        
                                        @if($cabinet->location)
                                            <div class="flex items-start gap-2 text-gray-600">
                                                <svg class="w-5 h-5 text-teal-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                <span class="text-sm">{{ Str::limit($cabinet->location, 60) }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Stats Badge -->
                                    <div class="flex items-center justify-between">
                                        <div class="bg-gradient-to-r from-yellow-100 to-orange-100 text-yellow-800 px-3 py-1.5 rounded-full text-sm font-medium">
                                            📅 {{ $cabinet->appointments_count }} appointments this month
                                        </div>
                                        <div class="flex items-center gap-1 text-sm text-gray-500">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>High demand</span>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex gap-3 pt-4 border-t border-gray-100">
                                        <a href="/cabinets/{{ $cabinet->id }}" 
                                           class="flex-1 text-center bg-gray-100 text-gray-700 px-4 py-2.5 rounded-xl font-medium hover:bg-gray-200 transition-colors">
                                            View Details
                                        </a>
                                        <a href="/appointments/create?cabinet_id={{ $cabinet->id }}" 
                                           class="flex-1 text-center bg-gradient-to-r from-teal-500 to-blue-500 text-white px-4 py-2.5 rounded-xl font-medium hover:from-teal-600 hover:to-blue-600 transition-all shadow-lg hover:shadow-xl">
                                            Book Now
                                        </a>
                                    </div>
                                </div>

                            </div>
                        @endforeach

                    </div>
                </section>

            </div>

            <!-- SIDEBAR -->
            <aside class="lg:col-span-1">
                <div class="sticky top-24">
                    <livewire:medical-news />
                </div>
            </aside>

        </div>
    </div>

</x-site-layout>
