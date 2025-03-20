<div>
    <div x-ref="timelineElements" class="flex">
        <div class="flex-none w-10 border-r-2 py-10 -ml-4 border-neutral-500"></div>
        <div class="flex-auto w-auto">
            @foreach ($historicalItems as $historicalItem)
                <ol :key="{{ $historicalItem->id }}">
                    @if ($historicalItem->group_year)
                        <div id="timelineYearLabel" class="flex items-center pt-4 pb-8 pointer-events-none z-10">
                            <div class="-ml-[18px] h-[2px] w-[75px] bg-neutral-500"></div>
                            <span class="text-[20px] h-[40px] w-[120px] text-neutral-600 text-center font-['Courier_New'] py-1 shadow-gray-500 shadow-lg no-underline rounded-full bg-white border border-gray-300 font-semibold focus:outline-none">
                                {{ $historicalItem->group_year }}
                            </span>
                        </div>
                    @endif

                    <li>
                        <div id="timelineContainer" class="mb-6">
                            <div class="flex items-center mb-4">
                                <div class="-ml-[12px] mr-0 h-[1px] w-[65px] bg-neutral-400"></div>
                                <h4 id="itemTitle" class="ml-4 text-lg font-semibold font-['Courier_New'] text-neutral-600 hover:text-[#FFB448] cursor-pointer">
                                    {{ $historicalItem->title }}
                                </h4>
                            </div>
                            <div id="itemContainer" wire:click="$dispatch('open-modal', { id: {{ $historicalItem->id }} })" class="flex flex-col-reverse sm:flex-row gap-8 sm:gap-16 -ml-2 sm:ml-4 mt-4 mb-8 w-10/12 cursor-pointer invisible">
                                <div id="itemDescription" class="w-10/12">
                                    <p class="border-l-2 border-[#ffb448] text-neutral-600 pl-6">
                                        {{ $historicalItem->description }}
                                    </p>
                                </div>

                                <div class="shrink-0 self-center size-36">
                                    <img id="itemImage" src="{{ $historicalItem->getFirstMedia("*")->getUrl('thumb') }}">
                                </div>
                            </div>
                        </div>
                    </li>
                </ol>
                @if ($loop->last)
                    <div x-init="addTimelineAnimations($refs.timelineElements)"></div>
                @endif
            @endforeach
        </div>
    </div>
</div>
