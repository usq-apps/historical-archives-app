<?php

namespace App\Livewire\Timeline;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\HistoricalItem;

class ItemModal extends Component
{
    public HistoricalItem $historicalItem;
    public bool $showModal = false;
    public array $mediaData = [];
    public array $itemIds = [];
    public int $itemKey = 0;
    public bool $showNextBtn = true;
    public bool $showPrevBtn = true;
    public string $itemCount;

    public function mount()
    {
        $this->historicalItem = HistoricalItem::first();
    }

    #[On('open-modal')]
    public function openModal($id)
    {
        $this->historicalItem = HistoricalItem::findOrFail($id);
        $this->showModal = true;

        $this->itemKey = array_search($id, $this->itemIds);
        $this->setNavBtns();
    }

    public function setItem($action)
    {
        if ($action === "next" && $this->showNextBtn) {
            $this->itemKey++;
            $id = $this->itemIds[$this->itemKey];
            $this->historicalItem = HistoricalItem::findOrFail($id);
        } elseif ($action === "prev" && $this->showPrevBtn) {
            $this->itemKey--;
            $id = $this->itemIds[$this->itemKey];
            $this->historicalItem = HistoricalItem::findOrFail($id);
        }

        $this->setNavBtns();
    }

    private function setNavBtns()
    {
        $this->showNextBtn = ($this->itemKey !== array_key_last($this->itemIds)) ? true : false;
        $this->showPrevBtn = ($this->itemKey !== array_key_first($this->itemIds)) ? true : false;
        $this->itemCount = $this->itemKey + 1 . " of " . count($this->itemIds);
    }

    private function fillMediaData()
    {
        $this->mediaData['collectionName'] = $this->historicalItem->getFirstMedia('*')->collection_name;
        $this->mediaData['playerType'] = ($this->historicalItem->getFirstMedia('*')->collection_name === "videos") ? "video" : "audio";
        $this->mediaData['srcPath'] =  $this->historicalItem->getFirstMediaUrl('*');
        $this->mediaData['mediaType'] = $this->historicalItem->getFirstMedia('*')->mime_type;
        $this->mediaData['mediaThumb'] = $this->historicalItem->getFirstMedia('*')->getUrl('thumb');
    }

    public function render()
    {
        $this->fillMediaData();

        return view('livewire.timeline.item-modal');
    }
}
