<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Facades\ApplicationHelperFacade as Helper;
use App\Helpers\SuccessResponse;
use App\Services\WeatherService;
use Throwable;

class WeatherController extends Controller
{
    private $service;

    public function __construct(WeatherService $service)
    {
        $this->service = $service;
    }
    /**
     * @OA\Get(
     *      path="/get-weather",
     *      operationId="getWeatherInfo",
     *      tags={"Weather"},
     *      summary="Get Weather Details",
     *      description="Returns weather details",
     *      @OA\Parameter(
     *          description="date",
     *          in="query",
     *          name="date",
     *          required=true,
     *          example="2022-03-03",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Exception Occurred"
     *     ),
     *      @OA\Response(
     *          response=422,
     *          description="Invalid Data"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *      ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'date' => 'required|date_format:Y-m-d'
            ]);
            if ($validator->fails()) {
                return response()->json(Helper::failureResponse($validator->errors()->first()), 422);
            } else {
                $data = $this->service->getWeatherData($request->date);
                if ($data instanceof SuccessResponse) {
                    return response()->json($data);
                } else {
                    $data = $this->service->pullDataByDate($request->date);
                    if ($data instanceof SuccessResponse) {
                        return response()->json($data);
                    } else {
                        return response()->json(Helper::failureResponse(), 400);
                    }
                }
            }
        } catch (Throwable $th) {
            return response()->json(Helper::failureResponse($th->getMessage()),400);
        }
    }
}
