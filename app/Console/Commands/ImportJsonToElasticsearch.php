<?php

namespace App\Console\Commands;

use Elastic\Elasticsearch\Client;
use Illuminate\Console\Command;

class ImportJsonToElasticsearch extends Command
{
    protected $signature = 'elasticsearch:import-json';
    protected $description = 'Import JSON file data into Elasticsearch';

    private $client;
    private $filePath = 'data/airports.json';

    public function __construct(Client $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    public function handle()
    {
        $filePath = storage_path($this->filePath);

        if (!file_exists($filePath)) {
            $this->error("File not found: $filePath");
            return 1;
        }

        $jsonContent = file_get_contents($filePath);
        $data = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error("Invalid JSON format.");
            return 1;
        }

        $params = ['body' => []];
        foreach ($data as $item) {
            $params['body'][] = [
                'index' => [
                    '_index' => env('ELASTICSEARCH_AIRPORT_INDEX'),
                ],
            ];
            $params['body'][] = $item;
        }

        $responses = $this->client->bulk($params);

        if (isset($responses['errors']) && $responses['errors']) {
            $this->error('Errors occurred during bulk indexing.');
        } else {
            $this->info('Data successfully imported into Elasticsearch.');
        }

        return 0;
    }
}
