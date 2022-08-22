<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\TripResource;
use App\Models\CityTrip;
use App\Models\Reservation;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TripController extends Controller
{
    public function allTrips()
    {
        $trips = Trip::all();
        return TripResource::collection(Trip::all());
    }

    public function avaliableSeats(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from_city' => 'required|exists:cities,id',
            'to_city' => 'required|different:from_city|exists:cities,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages(), 'code' => 422], 422);
        }

        // Get all passangers will ride full distanse from start to end
        $fullTripDistance = CityTrip::whereFromCity($request->from_city)->whereToCity($request->to_city)->first();
        if (!$fullTripDistance) {
            return response()->json(['error' => 'In valid trip', 'code' => 422], 422);
        }
        // Get all pasangers by end city
        $allCityTripsEndsAtToCity = CityTrip::whereToCity($request->to_city)->pluck('id')->toArray();

        // get all pasagers based on ther startd and end 
        $toCityLessThanToCityAndFromCityMoreThanToCity = CityTrip::where([
            ['from_city', '<', $request->to_city],
            ['to_city', '>', $request->to_city]
        ])
            ->orWhere([
                ['from_city', '<', $request->from_city],
                ['to_city', '>', $request->from_city]
            ])
            ->orWhere([
                ['from_city', '>', $request->from_city],
                ['from_city', '<', $request->to_city],
            ])
            ->orWhere([
                ['to_city', '>', $request->from_city],
                ['to_city', '<', $request->to_city],
            ])
            ->orWhere([
                ['from_city', '<', $request->from_city],
                ['to_city', '>', $request->to_city],
            ])
            ->orWhere([
                ['from_city', '>', $request->from_city],
                ['to_city', '>', $request->to_city],
            ])
            ->pluck('id')->toArray();

        $allTripIds = array_merge($toCityLessThanToCityAndFromCityMoreThanToCity, $allCityTripsEndsAtToCity);
        $reservations = Reservation::whereCityTripId($fullTripDistance->id)
            ->orWhere(function ($query) use ($allTripIds) {
                return $query->whereIn('city_trip_id', $allTripIds);
            })
            ->orderBy('id', 'desc')->get();


        if (count($reservations) >= 12) {
            return response()->json(['error' => 'Sorry there is no seats avaliable.', 'code' => 404], 404);
        }

        $avalableSeatsArr = [];
        for ($i = 0; $i < 12; $i++) {
            $avalableSeatsArr[] = 12 - $i;
        }
        $avalableSeatsArr = array_diff($avalableSeatsArr, $reservations->pluck('seat_id')->toArray());
        $avalableSeatsNewArr = [];
        foreach ($avalableSeatsArr as $index => $avalableSeat) {
            $avalableSeatsNewArr[] = $avalableSeat;
        }
        return response()->json(['data' => $avalableSeatsNewArr, 'code' => 200], 200);
    }



    public function storeReservation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from_city' => 'required|exists:cities,id',
            'to_city' => 'required|different:from_city|exists:cities,id',
            'seat_id' => 'required|numeric|max:12|min:1',
        ]);

        $cityTrip = CityTrip::whereFromCity($request->from_city)->whereToCity($request->to_city)->first();

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages(), 'code' => 422], 422);
        }

        // Get all passangers will ride full distanse from start to end
        $fullTripDistance = CityTrip::whereFromCity($request->from_city)->whereToCity($request->to_city)->first();
        // Get all pasangers by end city
        $allCityTripsEndsAtToCity = CityTrip::whereToCity($request->to_city)->pluck('id')->toArray();
        // get all pasagers based on ther startd and end 
        $toCityLessThanToCityAndFromCityMoreThanToCity = CityTrip::where([
            ['from_city', '<', $request->to_city],
            ['to_city', '>', $request->to_city]
        ])
            ->orWhere([
                ['from_city', '<', $request->from_city],
                ['to_city', '>', $request->from_city]
            ])
            ->orWhere([
                ['from_city', '>', $request->from_city],
                ['from_city', '<', $request->to_city],
            ])
            ->orWhere([
                ['to_city', '>', $request->from_city],
                ['to_city', '<', $request->to_city],
            ])
            ->orWhere([
                ['from_city', '<', $request->from_city],
                ['to_city', '>', $request->to_city],
            ])
            ->orWhere([
                ['from_city', '>', $request->from_city],
                ['to_city', '>', $request->to_city],
            ])
            ->pluck('id')->toArray();

        $allTripIds = array_merge($toCityLessThanToCityAndFromCityMoreThanToCity, $allCityTripsEndsAtToCity);

        $reservations = Reservation::whereCityTripId($fullTripDistance->id)
            ->orWhere(function ($query) use ($allTripIds) {
                return $query->whereIn('city_trip_id', $allTripIds);
            })
            ->orderBy('id', 'desc')->get();

        if (count($reservations) >= 12) {
            return response()->json(['error' => 'Sorry there is no seats avaliable.', 'code' => 404], 404);
        }

        $theSameSeatInSametripInSameCityTripId = Reservation::where([
            ['seat_id', '=', $request->seat_id],
            ['city_trip_id', '=', $cityTrip->id],
        ])->first();

        if ($theSameSeatInSametripInSameCityTripId) {
            return response()->json(['error' => 'Sorry this seat alearady taken.', 'code' => 404], 404);
        }

        $avalableSeatsArr = [];
        for ($i = 0; $i < 12; $i++) {
            $avalableSeatsArr[] = 12 - $i;
        }
        $avalableSeatsArr = array_diff($avalableSeatsArr, $reservations->pluck('seat_id')->toArray());
        $avalableSeatsNewArr = [];
        foreach ($avalableSeatsArr as $index => $avalableSeat) {
            $avalableSeatsNewArr[] = $avalableSeat;
        }

        if (!in_array($request->seat_id, $avalableSeatsNewArr)) {
            return response()->json(['error' => 'Sorry this seat alearady taken.', 'code' => 404], 404);
        }

        $reservations = Reservation::create([
            'seat_id' => $request->seat_id,
            'trip_id' => $cityTrip->trip_id,
            'city_trip_id' => $cityTrip->id,
        ]);

        return new ReservationResource($reservations);
    }
}
