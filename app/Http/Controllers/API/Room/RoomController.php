<?php

namespace App\Http\Controllers\API\Room;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Room\RoomRequest;
use App\Models\Room;
use App\Services\Room\RoomService;

class RoomController extends BaseController
{
    public function index()
    {
        $rooms = RoomService::getRooms();

        return $this->success($rooms->toArray(), 'Salles récupérées avec succès.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomRequest $request)
    {
        $room = RoomService::createRoom($request->validated());

        return $this->success($room->toArray(), 'Salle créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return $this->success($room->toArray(), 'Salle récupérée avec succès.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomRequest $request, Room $room)
    {
        $room = RoomService::updateRoom($room, $request->validated());

        return $this->success($room->toArray(), 'Salle mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return $this->success([], 'Salle supprimée avec succès.');
    }
}
