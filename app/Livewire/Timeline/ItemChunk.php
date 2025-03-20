<?php

namespace App\Livewire\Timeline;

use Livewire\Component;
use Livewire\Attributes\Lazy;
use App\Models\HistoricalItem;

#[Lazy]
class ItemChunk extends Component
{
    public array $itemIds = [];
    public array $yearIds = [];

    public function render()
    {
        return view('livewire.timeline.item-chunk', [
            'historicalItems' => HistoricalItem::whereIn('id', $this->itemIds)
                ->orderByRaw("FIELD(id, " . implode(',', $this->itemIds) . ")")
                ->get()
                ->map(function ($item) {
                    $groupYear = '';
                    foreach ($this->yearIds as $value) {
                        if ($item->id === $value) {
                            $groupYear = $item->item_date_from->format('Y');
                            break;
                        }
                    }
                    $item['group_year'] = $groupYear;
                    return $item;
                }),
        ]);
    }

    public function placeholder()
    {
        return view('livewire.timeline.item-chunk-placeholder');
    }
}
