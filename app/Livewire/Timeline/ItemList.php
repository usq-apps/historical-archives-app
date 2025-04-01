<?php

namespace App\Livewire\Timeline;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\HistoricalItem;

class ItemList extends Component
{
    public array $chunks = [];
    public int $chunkAmount = 10;
    public int $page = 1;
    public array $yearIds = [];
    public array $itemIds = [];
    public int $itemsTotal = 0;
    public int $itemsLoaded = 0;
    public string $itemsFilterType;
    public string $itemsFilterValue;
    public array $itemsDateRange = [];

    public function mount()
    {
        $startDate = Carbon::createFromFormat('Y-m', $this->itemsDateRange['points'][0])->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m', $this->itemsDateRange['points'][1])->endOfMonth();

        $this->chunks = HistoricalItem::whereRelation($this->itemsFilterType, 'slug', $this->itemsFilterValue)
            ->whereBetween('item_date_from', [$startDate, $endDate])
            ->orderBy('item_date_from')
            ->pluck('id')
            ->chunk($this->chunkAmount)
            ->toArray();

        $this->yearIds = HistoricalItem::whereRelation($this->itemsFilterType, 'slug', $this->itemsFilterValue)
            ->whereBetween('item_date_from', [$startDate, $endDate])
            ->orderBy('item_date_from')
            ->get()
            ->map(function ($item) {
                $item['year'] = $item->item_date_from->format('Y');
                return $item;
            })
            ->unique('year')
            ->pluck('id')
            ->toArray();

        $this->itemIds = HistoricalItem::whereRelation($this->itemsFilterType, 'slug', $this->itemsFilterValue)
            ->whereBetween('item_date_from', [$startDate, $endDate])
            ->orderBy('item_date_from')
            ->pluck('id')
            ->toArray();

        $this->itemsTotal = count($this->itemIds);

        $this->itemsLoaded = count($this->chunks[0]);
    }

    public function hasMorePages()
    {
        return $this->page < count($this->chunks);
    }

    public function loadMore()
    {
        if (!$this->hasMorePages()) {
            return;
        }

        $this->itemsLoaded = $this->itemsLoaded + count($this->chunks[$this->page]);

        $this->page++;
    }

    public function render()
    {
        return view('livewire.timeline.item-list');
    }
}
