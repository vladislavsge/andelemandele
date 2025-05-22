<?php

namespace App\Http\Controllers;

use App\Helpers\RickAndMortyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    /**
     * Returns all characters API call
     *
     * @param Request $request
     * @return mixed|JsonResponse|null
     */
    public function index(Request $request): mixed
    {
        $page = $request->query('page', 1);

        return RickAndMortyHelper::getAllCharacters($page);
    }

    /**
     * Search API call
     *
     * @param Request $request
     * @return JsonResponse|mixed
     */
    public function search(Request $request): mixed
    {
        try {
            $name = $request->query('name');
            $status = $request->query('status');

            if (empty($name) && empty($status)) {
                return response()->json(['error' => 'No search parameters provided'], 400);
            }

            return RickAndMortyHelper::search($request);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid search parameters'], 400);
        }
    }

    /**
     * Get character by ID API call
     *
     * @param mixed $id
     * @return JsonResponse|mixed
     */
    public function getById(int $id): mixed
    {
        try {
            $id = (int) $id;

            return RickAndMortyHelper::getById($id);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid ID'], 400);
        }
    }

    /**
     * Get character by episode API call
     *
     * @param mixed $episode
     * @return JsonResponse|mixed
     */
    public function getByEpisode($episode): mixed
    {
        try {
            $episode = (int) $episode;

            if ($episode <= 0) {
                return response()->json(['error' => 'Invalid episode number'], 400);
            }

            return RickAndMortyHelper::getByEpisode($episode);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid episode number'], 400);
        }
    }
}
