<div>
    <div x-data="dateSlider" x-modelable="dateRange" {{ $attributes }}>
        <div wire:ignore class="flex flex-col gap-4 mb-8 w-full">
            <div class="flex flex-row gap-2">
                <span class="font-semibold font-['Courier_New'] text-gray-600 underline underline-offset-4 decoration-1">Date Range:</span>
                <span id="startDate"></span>
                <span>to</span>
                <span id="endDate"></span>
            </div>

            <div class="flex flex-row items-center gap-12 pr-8">
                <button @click="resetSlider()" type="button" class="flex items-center justify-center h-[30px] w-[80px] text-sm text-neutral-600 hover:text-[#ffb448] shadow-gray-500 shadow-md no-underline rounded-full bg-white border border-gray-300 font-semibold focus:outline-none active:shadow-none pointer-events-auto">
                    RESET
                </button>
                <div x-ref="slider" class="flex-1"></div>
            </div>
        </div>
    </div>
</div>

@assets
<script src="https://cdn.jsdelivr.net/npm/nouislider@15.8.1/dist/nouislider.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@15.8.1/dist/nouislider.min.css">

<style>
    .noUi-target {
        height: 6px !important;
    }

    .noUi-base {
        height: 800% !important;
        top: -12px !important;
        cursor: pointer !important;
    }

    .noUi-origin {
        top: 6px !important;
    }

    .noUi-connect {
        height: 16% !important;
        top: 12px !important;
        background: #ffb448 !important;
    }

    .noUi-handle {
        cursor: ew-resize !important;
    }

    .noUi-handle-lower {
        right: 0 !important;
    }

    .noUi-handle-upper {
        right: -34px !important;
    }
</style>
@endassets

@script
<script>
    "use strict";

    Alpine.data('dateSlider', () => {
        let initialPoints;

        return {
            dateRange: '',

            init() {
                this.$nextTick(() => {
                    let dateSlider = this.$refs.slider;
                    let valuesForSlider = this.dateRange['values'];
                    let pointsForSlider = this.dateRange['points'];
                    initialPoints = this.dateRange['points'];
                    let dateValues = [
                        document.getElementById('startDate'),
                        document.getElementById('endDate')
                    ];
                    let format = {
                        from: function (value) {
                            return value;
                        },
                        to: function(value) {
                            return valuesForSlider[Math.round(value)];
                        }
                    };
                    let formatter = new Intl.DateTimeFormat('en-GB', { month: "short", year: "numeric" });

                    noUiSlider.create(dateSlider, {
                        start: [0, valuesForSlider.length - 1],
                        connect: true,
                        range: {
                            min: 0,
                            max: valuesForSlider.length - 1
                        },
                        step: 1,
                        format: format,
                        pips: {
                            mode: 'positions',
                            values: [],
                            density: 10,
                        },
                    });

                    dateSlider.noUiSlider.on('update', function (values, handle) {
                        dateValues[handle].innerHTML = formatter.format(new Date(values[handle]));
                    });

                    dateSlider.noUiSlider.on('change', function (values, handle) {
                        $dispatch('update-date-range', { dateRange: values });
                    });

                    this.$watch('dateRange', () => {
                        valuesForSlider = this.dateRange['values'];
                        pointsForSlider = this.dateRange['points'];

                        dateSlider.noUiSlider.updateOptions({
                            start: [
                                valuesForSlider.indexOf(pointsForSlider[0]),
                                valuesForSlider.indexOf(pointsForSlider[1])
                            ],
                            range: {
                                min: 0,
                                max: valuesForSlider.length - 1
                            }
                        });
                    });
                });
            },

            resetSlider() {
                $dispatch('update-date-range', { dateRange: initialPoints });
            }
        }
    });
</script>
@endscript

