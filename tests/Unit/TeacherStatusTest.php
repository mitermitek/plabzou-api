<?php

namespace Tests\Unit;

use App\Models\Teacher;
use App\Services\Teacher\TeacherService;
use PHPUnit\Framework\TestCase;

class TeacherStatusTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function testGetTeacherStatuses()
    {
        $teacherStatuses = TeacherService::getTeacherStatuses();

        //Renvoie un tableau
        $this->assertIsArray($teacherStatuses);

        //Tableau contient les valeurs de l'enum
        $this->assertContains('Interne', $teacherStatuses);
        $this->assertContains('Externe', $teacherStatuses);

        //Nombre de valeurs de l'enum
        $this->assertCount(2, $teacherStatuses);
    }
}
