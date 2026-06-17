<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OmdbService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.omdb.key');
        $this->baseUrl = config('services.omdb.base_url');
    }

    /**
     * Search movies by keyword
     */
    public function search(string $query, int $page = 1, ?string $type = null): array
    {
        try {
            $params = [
                'apikey' => $this->apiKey,
                's' => $query,
                'page' => $page,
            ];

            if ($type && in_array($type, ['movie', 'series', 'episode'])) {
                $params['type'] = $type;
            }

            $response = Http::get($this->baseUrl, $params);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['Response']) && $data['Response'] === 'True') {
                    return [
                        'success' => true,
                        'results' => $data['Search'] ?? [],
                        'totalResults' => (int) ($data['totalResults'] ?? 0),
                    ];
                }

                return [
                    'success' => false,
                    'message' => $data['Error'] ?? 'No results found.',
                    'results' => [],
                    'totalResults' => 0,
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to connect to OMDB API.',
                'results' => [],
                'totalResults' => 0,
            ];
        } catch (\Throwable $th) {
            Log::error('OmdbService search error: ' . $th->getMessage());

            return [
                'success' => false,
                'message' => 'An error occurred while searching.',
                'results' => [],
                'totalResults' => 0,
            ];
        }
    }

    /**
     * Get movie detail by IMDB ID
     */
    public function getById(string $imdbId): array
    {
        try {
            $response = Http::get($this->baseUrl, [
                'apikey' => $this->apiKey,
                'i' => $imdbId,
                'plot' => 'full',
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['Response']) && $data['Response'] === 'True') {
                    return [
                        'success' => true,
                        'movie' => $data,
                    ];
                }

                return [
                    'success' => false,
                    'message' => $data['Error'] ?? 'Movie not found.',
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to connect to OMDB API.',
            ];
        } catch (\Throwable $th) {
            Log::error('OmdbService getById error: ' . $th->getMessage());

            return [
                'success' => false,
                'message' => 'An error occurred while fetching movie details.',
            ];
        }
    }
}
