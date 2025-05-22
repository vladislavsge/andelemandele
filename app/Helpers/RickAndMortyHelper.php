<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RickAndMortyHelper
{
    protected const BASE_API_URL = 'https://rickandmortyapi.com/api';

    /**
     * Returns all characters by page number
     *
     * @param int $page
     * @return mixed
     */
    public function getAllCharacters(int $page = 1): mixed
    {
        $response = Http::get(self::BASE_API_URL . "/character", [
            'page' => $page
        ]);

        if ($response->failed()) {
            return null;
        }

        return $response->json();
    }

    /**
     * Get character by ID
     *
     * @param int $id
     * @return JsonResponse|mixed
     */
    public function getById(int $id): mixed
    {
        $response = Http::get(self::BASE_API_URL . "/character/{$id}");

        if ($response->failed()) {
            return response()->json(['error' => 'Character not found'], 404);
        }

        return response()->json($response->json(), $response->status());
    }

    /**
     * Search characters by name or status
     *
     * @param Request $request
     * @return JsonResponse|mixed
     */
    public function search(Request $request): mixed
    {
        $name = $request->query('name');
        $status = $request->query('status');

        $query = array_filter([
            'name' => $name,
            'status' => $status
        ]);

        $response = Http::get(self::BASE_API_URL . "/character", $query);

        if ($response->failed()) {
            return response()->json(['error' => 'No characters found'], 404);
        }

        return response()->json($response->json(), $response->status());
    }

    /**
     * Get characters by episode
     *
     * @param int $episode
     * @return JsonResponse|mixed
     */
    public function getByEpisode(int $episode): mixed
    {
        $episodeResponse = Http::get(self::BASE_API_URL . "/episode/{$episode}");

        if ($episodeResponse->failed()) {
            return response()->json(['error' => 'Episode not found'], 404);
        }

        $charactersUrls = $episodeResponse->json()['characters'];

        $characterIds = collect($charactersUrls)
            ->map(fn($url) => basename($url))
            ->implode(',');

        $charactersResponse = Http::get(self::BASE_API_URL . "/character/{$characterIds}");

        return response()->json($charactersResponse->json(), $charactersResponse->status());
    }
}