<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Collection;
use App\Models\SubCategory;
use App\Models\HistoricalItem;
use App\Models\ItemType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HistoricalItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ItemType::create([
            'name' => 'Audio',
        ]);

        ItemType::create([
            'name' => 'Document',
        ]);

        ItemType::create([
            'name' => 'Photograph',
        ]);

        ItemType::create([
            'name' => 'Video',
        ]);

        Category::create([
            'name' => 'Buildings and Facilities',
        ]);

        Category::create([
            'name' => 'Memorabilia',
        ]);

        Category::create([
            'name' => 'Occasions and Events',
        ]);

        SubCategory::create([
            'name' => 'Awards and Prizes',
        ]);

        SubCategory::create([
            'name' => 'Faculty',
        ]);

        SubCategory::create([
            'name' => 'Queensland Institute of Technology Darling Downs (QITDD) (1967-1970)',
        ]);

        Collection::create([
            'name' => 'History of UniSQ',
            'description' => 'Description for History of UniSQ collection. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
        ]);

        Collection::create([
            'name' => 'Japanese Garden',
            'description' => 'Description for Japanese Garden collection. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
        ]);

        Collection::create([
            'name' => 'Residential Colleges',
            'description' => 'Description for Residential Colleges collection. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
        ]);

        Collection::create([
            'name' => 'Staff and Students',
            'description' => 'Description for Staff and Students collection. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
        ]);

        HistoricalItem::factory()->count(100)->create();

        // Get all the Collections and attach random Collections to each Historical Item
        $collections = Collection::all();

        // Populate the pivot table
        if ($collections->count()) {
            HistoricalItem::all()->each(function ($historicalItem) use ($collections) {
                $historicalItem->collections()->attach(
                    $collections->random(rand(1, $collections->count()))->pluck('id')->toArray()
                );
            });
        }
    }
}
