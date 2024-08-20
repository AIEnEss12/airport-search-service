<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Elastic\Elasticsearch\Client;

class InitElasticIndexConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-elastic-index-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an Elasticsearch index with custom settings and mappings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $params = [
            'index' => env('ELASTICSEARCH_AIRPORT_INDEX'),
            'body'  => [
                'settings' => [
                    'analysis' => [
                        'analyzer' => [
                            'custom_ru_analyzer' => [
                                'type' => 'custom',
                                'tokenizer' => 'standard',
                                'filter' => [
                                    'lowercase',
                                    'russian_stop',
                                    'russian_stemmer',
                                ],
                            ],
                            'custom_en_analyzer' => [
                                'type' => 'custom',
                                'tokenizer' => 'standard',
                                'filter' => [
                                    'lowercase',
                                    'english_stop',
                                    'english_stemmer',
                                ],
                            ],
                        ],
                        'filter' => [
                            'russian_stop' => [
                                'type' => 'stop',
                                'stopwords' => '_russian_',
                            ],
                            'russian_stemmer' => [
                                'type' => 'stemmer',
                                'language' => 'russian',
                            ],
                            'english_stop' => [
                                'type' => 'stop',
                                'stopwords' => '_english_',
                            ],
                            'english_stemmer' => [
                                'type' => 'stemmer',
                                'language' => 'english',
                            ],
                        ],
                    ],
                ],
                'mappings' => [
                    'properties' => [
                        'cityName' => [
                            'properties' => [
                                'ru' => [
                                    'type' => 'text',
                                    'analyzer' => 'custom_ru_analyzer',
                                ],
                                'en' => [
                                    'type' => 'text',
                                    'analyzer' => 'custom_en_analyzer',
                                ],
                            ],
                        ],
                        'area' => [
                            'type' => 'keyword',
                        ],
                        'country' => [
                            'type' => 'keyword',
                        ],
                        'timezone' => [
                            'type' => 'keyword',
                        ],
                    ],
                ],
            ],
        ];

        try {
            $client = app(Client::class);

            $response = $client->indices()->create($params);
            $this->info('Index created successfully.');
        } catch (\Exception $e) {
            $this->error('Error creating index: ' . $e->getMessage());
        }
    }
}
