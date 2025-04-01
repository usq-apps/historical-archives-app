<div>
    <div x-data="timelineAnimations">
        <!-- Timeline Items -->
        <div>
            @for ($chunk = 0; $chunk < $page; $chunk++)
                <livewire:timeline.item-chunk :itemIds="$chunks[$chunk]" :yearIds="$yearIds" :key="$chunk" />
            @endfor

            <livewire:timeline.item-modal :itemIds="$itemIds" />
        </div>

        <!-- Intersection Observer -->
        @if ($this->hasMorePages())
            <div x-intersect="$wire.loadMore" class="-translate-y-48"></div>

            <button wire:click="loadMore" type="button" class="w-60 px-4 py-2 flex items-center justify-center gap-1 text-neutral-600 self-center hover:text-[#ffb448] shadow-gray-500 shadow-md no-underline rounded-full bg-white border border-gray-300 font-semibold focus:outline-none">
                <span>Show More</span>
                <x-icon.chevron-down size="6" />
            </button>
        @endif

        <!-- Counter and Scroll to Top -->
        <div class="fixed inset-0 flex justify-center items-center p-0 z-10 pointer-events-none">
            <div class="relative max-w-7xl w-full h-full sm:px-6 lg:px-8">
                <div class="absolute flex bottom-4 sm:bottom-8 right-4 sm:right-16 gap-4 sm:gap-8">
                    <span class="h-[40px] px-4 py-2 text-neutral-600 self-center shadow-gray-500 shadow-md no-underline rounded-full bg-white border border-gray-300 font-semibold focus:outline-none">
                        {{ $this->itemsLoaded . ' of ' . $this->itemsTotal }}
                    </span>

                    <button wire:ignore @click="scrollToTop()" type="button" class="flex items-center justify-center h-[40px] w-[40px] text-neutral-600 hover:text-[#ffb448] shadow-gray-500 shadow-md no-underline rounded-full bg-white border border-gray-300 font-semibold focus:outline-none active:shadow-none pointer-events-auto">
                        <x-icon.chevron-up size="6" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
