<?php

namespace Tests\Feature;

use App\Models\SuratMasuk;
use App\Models\SuratPengantar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LetterViewsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_all_letter_pages_load_successfully(): void
    {
        $user = User::where('role', 'ketua_rt')->first();

        // 1. Index Surat Pengantar
        $r1 = $this->actingAs($user)->get('/surat-pengantar');
        $r1->assertOk();

        // 2. Create Surat Pengantar
        $r2 = $this->actingAs($user)->get('/surat-pengantar/create');
        $r2->assertOk();

        // 3. Show Surat Pengantar
        $sp = SuratPengantar::first();
        $r3 = $this->actingAs($user)->get('/surat-pengantar/'.$sp->id);
        $r3->assertOk();

        // 4. Print Surat Pengantar
        $r4 = $this->actingAs($user)->get('/surat-pengantar/'.$sp->id.'/print');
        $r4->assertOk();

        // 5. Index Surat Masuk
        $r5 = $this->actingAs($user)->get('/surat-masuk');
        $r5->assertOk();

        // 6. Create Surat Masuk
        $r6 = $this->actingAs($user)->get('/surat-masuk/create');
        $r6->assertOk();

        // 7. Show Surat Masuk
        $sm = SuratMasuk::first();
        $r7 = $this->actingAs($user)->get('/surat-masuk/'.$sm->id);
        $r7->assertOk();

        // 8. Print Surat Masuk
        $r8 = $this->actingAs($user)->get('/surat-masuk/'.$sm->id.'/print');
        $r8->assertOk();

        // 9. Arsip Semua Surat
        $r9 = $this->actingAs($user)->get('/arsip-surat');
        $r9->assertOk();
    }
}
