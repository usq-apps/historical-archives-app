<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Timeline') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div x-data="titleAnimations">
                        <div wire:ignore x-ref="typewriterElement" class="mb-10">
                            <div id="typeContainer" x-init="addTypewriterAnimation($refs.typewriterElement)">
                                <span id="typeValue" class="hidden">{{ $filterName }}</span>
                                <span id="typeTitle" class="text-4xl font-['Courier_New'] text-gray-600"></span>
                                <span id="typeCursor" class="text-4xl font-['Courier_New'] text-[#ffb448]">|</span>
                                <p id="typePara" class="mt-4 mb-8 invisible">{{ $filterDescription }}</p>
                            </div>

                            <x-timeline.date-slider id="dateSlider" wire:model="dateRange" class="h-14 invisible" />
                        </div>
                    </div>

                    <!-- Current filter types: itemType, category, subCategory and collections -->
                    <livewire:timeline.item-list :itemsFilterType="$filterType" :itemsFilterValue="$filterValue" :itemsDateRange="$dateRange" :key="uniqid()" />

                </div>
            </div>
        </div>
    </div>
</div>

@assets
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollToPlugin.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/TextPlugin.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/Flip.min.js"></script>
@endassets

@script
<script>
    "use strict";
    gsap.registerPlugin(ScrollTrigger, ScrollToPlugin, TextPlugin, Flip);

    let ctx = gsap.context(() => {});

    window.addEventListener('cleanup-animations', event => {
        ctx.kill();
    });

    Alpine.data('titleAnimations', () => {
        return {
            addTypewriterAnimation(element) {
                const typeValue = element.querySelector('#typeValue');
                const typeTitle = element.querySelector('#typeTitle');
                const typeCursor = element.querySelector('#typeCursor');
                const typePara = element.querySelector('#typePara');
                const dateSlider = element.querySelector('#dateSlider');
                const typewriterTimeline = gsap.timeline();

                gsap.fromTo(typeCursor, { autoAlpha: 0 }, { autoAlpha: 1, duration: 0.8, repeat: -1, ease: SteppedEase.config(1) });

                typewriterTimeline.to(typeTitle, { text: { value: typeValue.innerHTML, speed: 0.5 }, ease: "none", onUpdate: () => typeTitle.appendChild(typeCursor) }, 0.8).progress(1).progress(0)
                    .to(typePara, { text: { value: typePara.innerHTML, speed: 11, newClass: "visible" }, ease: "none" });

                gsap.fromTo(dateSlider, { autoAlpha: 0 }, { autoAlpha: 1, delay: 0.5, duration: 1.5 });
            }
        }
    });

    Alpine.data('timelineAnimations', () => {
        let lastYearLabel = {};
        let lastYearScrollTrigger = {};
        let firstItemTimeline = {};

        return {
            addTimelineAnimations(element) {
                ctx.add(() => {
                    const timelineContainers = gsap.utils.toArray('#timelineContainer', element);
                    const timelineYearLabels = gsap.utils.toArray('#timelineYearLabel', element);

                    timelineContainers.forEach((item, index) => {
                        const itemContainer = item.querySelector('#itemContainer');
                        const itemTitle = item.querySelector('#itemTitle');
                        const itemDescription = item.querySelector('#itemDescription');
                        const itemImage = item.querySelector('#itemImage');
                        const itemTimeline = gsap.timeline({ paused: true, reversed: true, onComplete: this.refreshScrollTriggers, onReverseComplete: this.refreshScrollTriggers });

                        itemTimeline.fromTo(itemContainer, { autoAlpha: 0, height: 0 }, { autoAlpha: 1, height: "auto", duration: 0.3 }, 0)
                            .fromTo(itemDescription, { autoAlpha: 0, x: 0, y: 0 }, { autoAlpha: 1, x: 60, y: 0, duration: 0.7 }, 0.3)
                            .fromTo(itemImage, { autoAlpha: 0, x: -300, y: 0, rotation: 0 }, { autoAlpha: 1, x: 20, y: 0, rotation: "random(-12, 12)", duration: 0.5, ease:"power2.out" }, 0.3);

                        // Play first timeline
                        if (Object.keys(firstItemTimeline).length === 0) {
                            firstItemTimeline = itemTimeline;
                            gsap.delayedCall(0.3, () => firstItemTimeline.play());
                        }

                        itemTitle.addEventListener('click', function () {
                            if (itemTimeline.reversed()) {
                                gsap.to(window, { duration: 1, scrollTo: { y: item, offsetY: window.innerHeight / 4 }, delay: 0.2 });
                                itemTimeline.play();
                            } else {
                                itemTimeline.reverse();
                            }
                        });
                    });

                    timelineYearLabels.forEach((item, index) => {
                        // Update last year scroll trigger
                        if (index === 0 && ScrollTrigger.getAll().length !== 0) {
                            lastYearScrollTrigger.scrollTrigger.kill();
                            lastYearScrollTrigger.kill();
                            lastYearScrollTrigger = null;
                            this.createYearScrollTrigger(lastYearLabel, item, 'top 20px');
                        }

                        // Create scroll trigger
                        const endTrigger = index === timelineYearLabels.length - 1 ? item : timelineYearLabels[index + 1];
                        const end = index === timelineYearLabels.length - 1 ? "+=999999" : "top 20px";
                        const yearScrollTrigger = this.createYearScrollTrigger(item, endTrigger, end);

                        // Capture last year element and scroll trigger
                        if (index === timelineYearLabels.length - 1) {
                            lastYearLabel = item;
                            lastYearScrollTrigger = yearScrollTrigger;
                        }
                    });
                });
            },

            createYearScrollTrigger(item, endTrigger, end) {
                return gsap.timeline({ paused: false, reversed: false,
                    scrollTrigger: {
                        trigger: item,
                        toggleActions: "none play reverse none",
                        start: "top 20px",
                        endTrigger,
                        end,
                        pin: true,
                        pinSpacing: false
                    }}).fromTo(item, { autoAlpha: 1, duration: 0.2 }, { autoAlpha: 0 , duration: 0.2 });
            },

            refreshScrollTriggers() {
                setTimeout(() => ScrollTrigger.refresh(), 200);
            },

            scrollToTop() {
                ctx.add(() => {
                    gsap.to(window, { scrollTo: { y: 0 } });
                });
            },

            addMediaAnimation(element) {
                ctx.add(() => {
                    const mediaThumbnail = element.querySelector('#mediaThumbnail');
                    const mediaBackground = element.querySelector('#mediaBackground');
                    const mediaFullSize = element.querySelector('#mediaFullSize');
                    const mediaCloseButton = element.querySelector('#mediaCloseButton');
                    const bgTimeline = gsap.timeline({ paused: true, reversed: true });
                    const fadeTime = 0.8;

                    bgTimeline.fromTo(mediaBackground, { autoAlpha: 0 }, { autoAlpha: 1, duration: fadeTime }, 0);

                    mediaThumbnail.addEventListener('click', flipAnimation);
                    mediaCloseButton.addEventListener('click', flipAnimation);

                    function flipAnimation() {
                        const state = Flip.getState([mediaThumbnail, mediaFullSize]);

                        mediaThumbnail.classList.toggle('active');
                        gsap.set(mediaBackground, { width: "100%", height: "100%" });
                        bgTimeline.reversed() ? bgTimeline.play() : bgTimeline.reverse();

                        Flip.from(state, {
                            duration: fadeTime,
                            fade: true,
                            absolute: true,
                            toggleClass: "flipping",
                            ease: "power1.inOut"
                        });

                        $dispatch('stop-media-player');
                    };
                });
            },
        }
    });
</script>
@endscript
