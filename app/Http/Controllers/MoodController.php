<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMoodRequest;
use App\Http\Requests\UpdateMoodRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Mood;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;

class MoodController extends Controller
{
    /**
     * Display a listing of the moods for a specific user.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $userId): JsonResponse
    {
        try {
            // Fetch all moods for the user
            $moods = Mood::where('user_id', $userId)->get();


            return response()->json([
                'message' => 'Moods retrieved successfully',
                'data' => $moods
            ], 200);
        } catch (\Exception $e) {
            Log::error("Error in Mood endpoint: " . $e->getMessage());
            // Handle any exceptions that occur during retrieving moods
            return response()->json([
                'message' => 'Error occurred during retrieving moods',
            ], 500);
        }
    }

    /**
     * Store a new mood.
     *
     * @param  \App\Http\Requests\StoreMoodRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreMoodRequest $request): JsonResponse
    {
        try {
            // Validate the request using StoreMoodRequest
            // The request is already validated by StoreMoodRequest
            // Create a new mood entry in the database
            $newMood = Mood::create([
                'emoji' => $request->emoji,
                'note' => $request->note,
                'rating' => $request->rating,
                'user_id' => $request->user_id,
            ]);

            // Return a JSON response with the newly created mood
            return response()->json([
                'message' => 'Mood stored successfully',
                'data' => $newMood
            ], 201);
        } catch (\Exception $e) {
            Log::error("Error in Mood endpoint: " . $e->getMessage());
            // Handle any exceptions that occur during storing mood
            return response()->json([
                'message' => 'Error occurred during store mood',
            ], 500);
        }
    }


    /**
     * Update an existing mood by its ID.
     *
     * @param  \App\Http\Requests\UpdateMoodRequest  $request
     * @param  int  $moodId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateMoodRequest $request, int $moodId): JsonResponse
    {
        try {
            // Find the mood by its ID
            // The request is already validated by UpdateMoodRequest
            $mood = Mood::find($moodId);

            // If the mood does not exist, return a 404 response
            if (!$mood) {
                return response()->json([
                    'message' => 'Mood not found',
                ], 404);
            }

            // Update the mood with the validated data from the request
            $mood->emoji = $request->emoji;
            $mood->note = $request->note;
            $mood->rating = $request->rating;
            $mood->save();

            // Return a JSON response indicating successful update
            return response()->json([
                'message' => 'Mood updated successfully',
                'data' => $mood
            ], 200);
        } catch (\Exception $e) {
            Log::error("Error in Mood endpoint: " . $e->getMessage());
            // Handle any exceptions that occur during updating mood
            return response()->json([
                'message' => 'Error occurred during updating mood',
            ], 500);
        }
    }



    /**
     * Delete a mood by its ID.
     * @param  int  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $moodId): JsonResponse
    {
        try {
            // Find the mood by its ID
            $mood = Mood::find($moodId);

            // If the mood does not exist, return a 404 response
            if (!$mood) {
                return response()->json([
                    'message' => 'Mood not found',
                ], 404);
            }

            // Delete the mood
            // The delete method will remove the mood from the database
            $mood->delete();

            // Return a JSON response indicating successful deletion
            return response()->json([
                'message' => 'Mood deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            Log::error("Error in Mood endpoint: " . $e->getMessage());
            // Handle any exceptions that occur during deleting mood
            return response()->json([
                'message' => 'Error occurred during deleting mood',
            ], 500);
        }
    }
}
