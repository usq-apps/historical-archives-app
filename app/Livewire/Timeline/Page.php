<?php

namespace App\Livewire\Timeline;

use Livewire\Component;
use App\Models\Category;
use App\Enums\FilterType;
use App\Models\Collection;
use App\Models\SubCategory;
use Illuminate\Support\Arr;
use Livewire\Attributes\On;
use App\Models\HistoricalItem;

class Page extends Component
{
    public string $filterType;
    public string $filterValue;
    public string $filterName;
    public string $filterDescription = '';
    public array $dateRange = [];

    public function mount(Category $category, SubCategory $subCategory, Collection $collection)
    {
        // (one to many) category:  buildings-and-facilities, memorabilia, occasions-and-events
        // (one to many) subcategory:  awards-and-prizes, faculty, queensland-institute-of-technology-darling-downs-qitdd-1967-1970
        // (many to many) collections:  history-of-unisq, japanese-garden, residential-colleges, staff-and-students

        if ($category->exists) {
            $this->filterType = FilterType::Category->value;
            $this->filterValue = $category->slug;
            $this->filterName = $category->name;
        }

        if ($subCategory->exists) {
            $this->filterType = FilterType::Subcategory->value;
            $this->filterValue = $subCategory->slug;
            $this->filterName = $subCategory->name;
        }

        if ($collection->exists) {
            $this->filterType = FilterType::Collections->value;
            $this->filterValue = $collection->slug;
            $this->filterName = $collection->name;
            $this->filterDescription = $collection->description;
        }

        $dateRange = HistoricalItem::whereRelation($this->filterType, 'slug', $this->filterValue)
            ->orderBy('item_date_from')
            ->pluck('item_date_from')
            ->map(fn ($date) => $date->format('Y-m'))
            ->unique()
            ->values()
            ->toArray();

        $startDate = Arr::first($dateRange);
        $endDate = Arr::last($dateRange);

        $this->dateRange['values'] = $dateRange;
        $this->dateRange['points'] = [$startDate, $endDate];
    }

    #[On('update-date-range')]
    public function updateDateRange($dateRange)
    {
        $this->dispatch('cleanup-animations');
        $this->dateRange['points'] = [$dateRange[0], $dateRange[1]];
    }

    public function render()
    {
        return view('livewire.timeline.page');
    }
}
