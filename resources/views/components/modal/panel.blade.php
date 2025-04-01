<div
    x-dialog
    x-model="open"
    style="display: none"
    class="fixed inset-0 overflow-y-auto z-20"
>
    <!-- Overlay -->
    <div x-dialog:overlay x-transition.opacity class="fixed inset-0 bg-black/40"></div>

    <!-- Panel -->
    <div class="relative min-h-full flex justify-center items-center p-0 sm:p-4">
        <div
            x-dialog:panel
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-50"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-50"
            x-init="$watch('open', value => value ? $nextTick(() => $el.scrollIntoView(false)) : '')"

            class="relative max-w-4xl w-full bg-white rounded-none sm:rounded-xl shadow-lg overflow-hidden"
        >
            <!-- Close Button -->
            <div class="absolute top-0 right-0 pt-2 pr-2">
                <button type="button" @click="$dialog.close()" class="bg-[#f5f5f3] rounded-lg p-2 text-neutral-600 hover:text-[#ffb448] focus:outline-none">
                    <span class="sr-only">Close modal</span>
                    <x-icon.x-mark-mini size="5" />
                </button>
            </div>

            <!-- Content -->
            <div class="p-8">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
