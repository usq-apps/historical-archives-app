import './bootstrap';

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import intersect from '@alpinejs/intersect';
import ui from '@alpinejs/ui';

Alpine.plugin(intersect);
Alpine.plugin(ui);

Livewire.start();


