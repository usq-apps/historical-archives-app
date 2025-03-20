<div>
    <div x-data="mediaPlayer" x-modelable="mediaData" {{ $attributes }}>
        <div x-show="mediaData.collectionName === 'audio'">
            <div class="flex justify-center mb-10">
                <img :src="mediaData.mediaThumb">
            </div>
        </div>

        <div wire:ignore>
            <video x-ref="player" controls style="--plyr-color-main: #ffb448;">
                This browser does not support the video tag
            </video>
        </div>
    </div>
</div>

@assets
<script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
@endassets

@script
<script>
    "use strict";

    Alpine.data('mediaPlayer', () => {
        let player;

        return {
            mediaData: '',

            init() {
                player = this.initPlayer(this.$refs.player);

                this.$watch('mediaData', () => {
                    if (this.mediaData.collectionName === 'videos' || this.mediaData.collectionName === 'audio') {
                        this.updatePlayer(player, this.mediaData.playerType, this.mediaData.srcPath, this.mediaData.mediaType);
                    }
                });

                window.addEventListener('stop-media-player', event => {
                    if (player.playing) {
                        player.stop();
                    }
                });
            },

            updatePlayer(player, playerType, src, type) {
                player.source = {
                    type: playerType,
                    sources: [
                        {
                            src: src,
                            type: type,
                        }
                    ]
                };
            },

            initPlayer(el) {
                return new Plyr(el, {
                    autoplay: false,
                    controls: [
                        'play-large',
                        'restart',
                        'rewind',
                        'play',
                        'fast-forward',
                        'progress',
                        'current-time',
                        'duration',
                        'mute',
                        'volume',
                        'captions',
                        'settings',
                        'pip',
                        'airplay',
                        'fullscreen',
                        'quality',
                    ],
                });
            },
        }
    });
</script>
@endscript
