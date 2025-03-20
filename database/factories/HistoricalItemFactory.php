<?php

namespace Database\Factories;

use App\Models\HistoricalItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class HistoricalItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $itemNumber = 1;

        return [
            'title' => "Historical Item ".$itemNumber++." - ".$this->faker->words(4, true),
            'description' => $this->faker->sentence(50),
            'item_date_from' => $this->faker->dateTimeBetween('-50 years', '-30 years'),
            'item_date_to' => $this->faker->dateTimeBetween('-50 years', '-30 years'),
            'item_type_id' => $this->faker->randomElement([1, 2, 3, 4]),
            'category_id' => $this->faker->randomElement([1, 2, 3]),
            'sub_category_id' => $this->faker->randomElement([1, 2, 3]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (HistoricalItem $item) {
            $itemType = $this->faker->randomElement(['document', 'image', 'video', 'audio']);
            $documentSample = $this->faker->randomElement(['media-samples/document-sample-01.pdf', 'media-samples/document-sample-02.pdf']);
            $imageSample = $this->faker->randomElement(['media-samples/image-sample-01.jpg', 'media-samples/image-sample-02.jpg']);
            $videoSample = $this->faker->randomElement(['media-samples/video-sample-01.mp4', 'media-samples/video-sample-02.mp4']);

            switch ($itemType) {
                case 'document':
                    $name = $item->title.".pdf";
                    $file = storage_path($documentSample);

                    $item->addMedia($file)
                        ->preservingOriginal()
                        ->usingName($name)
                        ->usingFileName($name)
                        ->toMediaCollection('documents');
                    break;

                case 'image':
                    $name = $item->title.".jpg";
                    $file = storage_path($imageSample);

                    $item->addMedia($file)
                        ->preservingOriginal()
                        ->usingName($name)
                        ->usingFileName($name)
                        ->toMediaCollection('images');
                    break;

                case 'video':
                    $name = $item->title.".mp4";
                    $file = storage_path($videoSample);

                    $item->addMedia($file)
                        ->preservingOriginal()
                        ->usingName($name)
                        ->usingFileName($name)
                        ->toMediaCollection('videos');
                    break;

                case 'audio':
                    $name = $item->title.".mp3";
                    $file = storage_path('media-samples/audio-sample.mp3');

                    $item->addMedia($file)
                        ->preservingOriginal()
                        ->usingName($name)
                        ->usingFileName($name)
                        ->toMediaCollection('audio');
                    break;
            }
        });
    }
}
