<div>
    <x-modal wire:model="showModal">
        <x-modal.panel>
            <h1 class="text-2xl font-['Courier_New'] font-semibold text-gray-600">{{ $historicalItem->title }}</h1>

            <!-- Item Thumbnail -->
            <div x-ref="mediaElement">
                <div class="flex justify-center items-center">
                    <div x-init="addMediaAnimation($refs.mediaElement)" class="flex items-center justify-center py-6">
                        <div class="flex justify-center size-72">
                            <div id="mediaThumbnail" data-flip-id="media" class="relative flex justify-center [&.active]:hidden [&.flipping]:visible cursor-pointer">
                                <x-icon.magnifying-glass-plus size="9" class="absolute text-gray-300 bottom-0 -right-10" />
                                <img class="object-scale-down" src="{{ $historicalItem->getFirstMedia('*')->getUrl('thumb') }}">
                            </div>
                        </div>

                        <div id="mediaBackground" class="flex fixed items-center justify-center top-0 left-0 bg-black z-40 invisible">
                            <div id="mediaCloseButton" class="flex fixed top-0 right-0 p-4 z-40 text-white cursor-pointer">
                                <x-icon.x-mark size="10" />
                            </div>

                            <div id="mediaFullSize" data-flip-id="media" class="object-scale-down z-20">
                                <!-- Load Documents -->
                                @if ($mediaData['collectionName'] === 'documents')
                                    <div class="flex items-end h-screen">
                                        <div class="relative w-screen h-[calc(100vh-75px)]">
                                            <iframe src="{{ $mediaData['srcPath'] }}" width="100%" height="100%">
                                                This browser does not support PDFs
                                            </iframe>
                                        </div>
                                    </div>
                                @endif

                                <!-- Load Images -->
                                @if ($mediaData['collectionName'] === 'images')
                                    <img src="{{ $mediaData['srcPath'] }}">
                                @endif

                                <!-- Load Videos or Audio -->
                                @if ($mediaData['collectionName'] === 'videos' || $mediaData['collectionName'] === 'audio')
                                    <x-timeline.media-player wire:model="mediaData" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item Navigation -->
            <div class="fixed inset-0 flex justify-center items-center p-0 sm:p-4 pointer-events-none">
                <div class="relative max-w-4xl w-full h-full">
                    <div x-show="open" x-transition:enter.delay.400ms class="absolute top-[30%] left-0 p-4">
                        <div x-show="$wire.showPrevBtn">
                            <button wire:click="setItem('prev')" type="button" class="flex items-center justify-center h-[40px] w-[40px] text-neutral-600 hover:text-[#ffb448] shadow-gray-500 shadow-md no-underline rounded-full bg-white border border-gray-300 font-semibold focus:outline-none active:shadow-none pointer-events-auto">
                                <x-icon.chevron-left size="6" />
                            </button>
                        </div>
                    </div>

                    <div x-show="open" x-transition:enter.delay.400ms class="absolute top-[30%] right-0 p-4">
                        <div x-show="$wire.showNextBtn">
                            <button wire:click="setItem('next')" type="button" class="flex items-center justify-center h-[40px] w-[40px] text-neutral-600 hover:text-[#ffb448] shadow-gray-500 shadow-md no-underline rounded-full bg-white border border-gray-300 font-semibold focus:outline-none active:shadow-none pointer-events-auto">
                                <x-icon.chevron-right size="6" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <span class="flex justify-center font-semibold font-['Courier_New'] text-gray-600 mb-4">{{ $itemCount }}</span>

            <hr class="w-3/4 h-1 mx-auto mb-8 bg-[#ffb448] border-0">

            <!-- Item Metadata -->
            <div class="flex flex-col gap-2">
                <div class="space-x-2">
                    <span class="font-semibold font-['Courier_New'] text-gray-600 underline underline-offset-4 decoration-1">Title:</span>
                    <span>{{ $historicalItem->title }}</span>
                </div>
                <div class="space-x-2">
                    <span class="font-semibold font-['Courier_New'] text-gray-600 underline underline-offset-4 decoration-1">Date Range:</span>
                    <span>{{ $historicalItem->toArray()['item_date_from'] . " - " . $historicalItem->toArray()['item_date_to'] }}</span>
                </div>
                <div class="space-x-2">
                    <span class="font-semibold font-['Courier_New'] text-gray-600 underline underline-offset-4 decoration-1">Description:</span>
                    <span>{{ $historicalItem->description }}</span>
                </div>
                <div class="space-x-2">
                    <span class="font-semibold font-['Courier_New'] text-gray-600 underline underline-offset-4 decoration-1">Item Type:</span>
                    <span>{{ $historicalItem->itemType->name }}</span>
                </div>
                <div class="space-x-2">
                    <span class="font-semibold font-['Courier_New'] text-gray-600 underline underline-offset-4 decoration-1">Category:</span>
                    <span><a class="text-blue-500 hover:underline" href="{{ route('timeline.category', ['category' => $historicalItem->category->slug]) }}">{{ $historicalItem->category->name }}</a></span>
                </div>
                <div class="space-x-2">
                    <span class="font-semibold font-['Courier_New'] text-gray-600 underline underline-offset-4 decoration-1">Sub-Category:</span>
                    <span><a class="text-blue-500 hover:underline" href="{{ route('timeline.subcategory', ['subCategory' => $historicalItem->subCategory->slug]) }}">{{ $historicalItem->subCategory->name }}</a></span>
                </div>
                <div class="space-x-2">
                    <span class="font-semibold font-['Courier_New'] text-gray-600 underline underline-offset-4 decoration-1">Collections:</span>
                    @foreach($historicalItem->collections as $collection)
                        <span>
                            <a class="text-blue-500 hover:underline" href="{{ route('timeline.collections', ['collection' => $collection->slug]) }}">{{ $collection->name }}</a>
                            @if(!$loop->last)
                            ,
                            @endif
                        </span>
                    @endforeach
                </div>
            </div>

            <x-modal.footer>
                <p>
                    <em>Disclaimer regarding use of media...</em>
                </p>
            </x-modal.footer>
        </x-modal.panel>
    </x-modal>
</div>
