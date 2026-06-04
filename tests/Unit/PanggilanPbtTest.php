<?php

namespace Tests\Unit;

use App\Http\Controllers\PanggilanController;
use App\Models\Panggilan;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class PanggilanPbtTest extends TestCase
{
    public function test_panggilan_model_allows_link_pbt_mass_assignment(): void
    {
        $panggilan = new Panggilan([
            'link_pbt' => 'https://example.com/pbt.pdf',
        ]);

        $this->assertSame('https://example.com/pbt.pdf', $panggilan->link_pbt);
    }

    public function test_panggilan_controller_allows_link_pbt_field(): void
    {
        $reflection = new ReflectionClass(PanggilanController::class);
        $property = $reflection->getProperty('allowedFields');
        $property->setAccessible(true);

        $allowedFields = $property->getValue(new PanggilanController());

        $this->assertContains('link_pbt', $allowedFields);
    }
}