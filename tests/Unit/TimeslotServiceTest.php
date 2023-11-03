<?php

namespace Tests\Unit;

use App\Models\Learner;
use App\Models\Room;
use App\Models\Timeslot;
use App\Services\Timeslot\TimeslotService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionException;
use Tests\TestCase;

class TimeslotServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function testCheckRoomAvailabilityForTimeslotsWhenRoomIsAvailable()
    {
        $room = Room::factory()->create();
        $timeslot = Timeslot::factory()->create(['room_id' => $room->id]);
        $timeslots = new Collection([$timeslot]);
        //On crée une autre salle qui sera dispo
        $room = Room::factory()->create();
        $service = new TimeslotService();

        //Utilisez la réflexion pour appeler la méthode privée.
        $isAvailable = $this->invokePrivateMethod($service, 'checkRoomAvailabilityForTimeslots', [$room, $timeslots]);

        $this->assertTrue($isAvailable);
    }


    public function testCheckRoomAvailabilityForTimeslotsWhenRoomIsOccupied()
    {
        $room = Room::factory()->create();
        $timeslot = Timeslot::factory()->create(['room_id' => $room->id]);

        $timeslots = new Collection([$timeslot]);

        $service = new TimeslotService();

        // Utilisez la réflexion pour appeler la méthode privée.
        $isAvailable = $this->invokePrivateMethod($service, 'checkRoomAvailabilityForTimeslots', [$room, $timeslots]);

        $this->assertFalse($isAvailable);
    }

    public function testCheckUsersAvailabilityForTimeslotsWhenUsersAreAvailable()
    {
        // Créez des données de test pour les créneaux, les utilisateurs à vérifier et la relation utilisateur.
        $timeslot1 = Timeslot::factory()->create();
        $timeslot2 = Timeslot::factory()->create();

        $learner1 = Learner::all()[0]->user_id;
        $learner2 = Learner::all()[1]->user_id;

        $timeslot1->learners()->attach($learner1);
        $timeslot2->learners()->attach($learner2);

        $timeslots = new Collection([$timeslot1, $timeslot2]);
        $usersToCheck = [
            ['user_id' => Learner::all()[3]->user_id],
            ['user_id' => Learner::all()[4]->user_id],
        ];
        $userRelation = 'learners';

        $service = new TimeslotService();

        // Utilisez la réflexion pour appeler la méthode privée.
        $isAvailable = $this->invokePrivateMethod($service, 'checkUsersAvailabilityForTimeslots', [$timeslots, $usersToCheck, $userRelation]);

        $this->assertTrue($isAvailable);
    }

    public function testCheckUsersAvailabilityForTimeslotsWhenUsersAreOccupied()
    {
        // Créez des données de test pour les créneaux, les utilisateurs à vérifier et la relation utilisateur.
        $timeslot1 = Timeslot::factory()->create();
        $timeslot2 = Timeslot::factory()->create();

        $learner1 = Learner::all()[0]->user_id;
        $learner2 = Learner::all()[1]->user_id;

        $timeslot1->learners()->attach($learner1);
        $timeslot2->learners()->attach($learner2);

        $timeslots = new Collection([$timeslot1, $timeslot2]);
        $usersToCheck = [
            ['user_id' => $learner1],
            ['user_id' => Learner::all()[2]->user_id],
        ];
        $userRelation = 'learners';

        $service = new TimeslotService();

        // Utilisez la réflexion pour appeler la méthode privée.
        $isAvailable = $this->invokePrivateMethod($service, 'checkUsersAvailabilityForTimeslots', [$timeslots, $usersToCheck, $userRelation]);

        $this->assertFalse($isAvailable);
    }


    public function testFormatTimeslotData()
    {
        //Données à formater
        $data = [
            'training' => 1,
            'starts_at' => '2023-10-20 08:00:00',
            'ends_at' => '2023-10-20 09:00:00',
            'is_validated' => 1,
            'room' => 2,
        ];

        $service = new TimeslotService();

        $formattedData = $this->invokePrivateMethod($service, 'formatTimeslotData', [$data]);

        //Résultat attendu
        $expectedData = [
            'training_id' => 1,
            'starts_at' => '2023-10-20 08:00:00',
            'ends_at' => '2023-10-20 09:00:00',
            'is_validated' => true,
            'room_id' => 2,
        ];

        $this->assertEquals($expectedData, $formattedData);
    }


    // Méthode pour invoquer une méthode privée à l'aide de la réflexion.
    private function invokePrivateMethod($object, $methodName, array $parameters = [])
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
