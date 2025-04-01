<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl mb-4">Timeline Filters Test</h1>

                    <hr class="w-96 h-1 mb-6 bg-[#ffb448] border-0">

                    <div class="flex flex-row gap-6 mb-4">
                        <!-- Category Filter Test -->
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center p-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>Category</div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('timeline.category', ['category' => 'buildings-and-facilities'])">
                                    Buildings and Facilities
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('timeline.category', ['category' => 'memorabilia'])">
                                    Memorabilia
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('timeline.category', ['category' => 'occasions-and-events'])">
                                    Occasions and Events
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>

                        <!-- Sub-Category Filter Test -->
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center p-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>Sub-Category</div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('timeline.subcategory', ['subCategory' => 'awards-and-prizes'])">
                                    Awards and Prizes
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('timeline.subcategory', ['subCategory' => 'faculty'])">
                                    Faculty
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('timeline.subcategory', ['subCategory' => 'queensland-institute-of-technology-darling-downs-qitdd-1967-1970'])">
                                    Queensland Institute of Technology Darling Downs (QITDD) (1967-1970)
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>

                        <!-- Collection Filter Test -->
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center p-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>Collections</div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('timeline.collections', ['collection' => 'history-of-unisq'])">
                                    History of UniSQ
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('timeline.collections', ['collection' => 'japanese-garden'])">
                                    Japanese Garden
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('timeline.collections', ['collection' => 'residential-colleges'])">
                                    Residential Colleges
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('timeline.collections', ['collection' => 'staff-and-students'])">
                                    Staff and Students
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <div class="flex flex-col gap-2 pt-8">
                        <p>
                            Category = One to Many Relationship
                        </p>
                        <p>
                            Sub-Category = One to Many Relationship
                        </p>
                        <p>
                            Collections = Many to Many Relationship
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

