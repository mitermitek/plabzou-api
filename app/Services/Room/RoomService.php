<?php

namespace App\Services\Room;

use App\Models\Room;
use Illuminate\Support\Collection;

class RoomService
{
    /**
     * Récupérer la liste des salles
     *
     * @return Collection
     */
    public static function getRooms(): Collection
    {
        return Room::all();
    }

    /**
     * @param array $data
     * @return Room
     */
    public static function createRoom(array $data): Room
    {
        return Room::create($data);
    }

    /**
     * @param Room $room
     * @param array $data
     * @return Room
     */
    public static function updateRoom(Room $room, array $data): Room
    {
        $room->update($data);

        return $room;
    }
}
