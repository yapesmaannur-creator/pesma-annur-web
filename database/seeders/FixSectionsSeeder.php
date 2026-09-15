<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;

class FixSectionsSeeder extends Seeder
{
    public function run(): void
    {
        // Deactivate team section
        PageSection::where('type', 'team')->update(['is_active' => false]);
        $this->command->info('Team section deactivated.');

        // Show beranda sections
        $page = \App\Models\Page::where('slug', 'beranda')->first();
        if ($page) {
            foreach ($page->sections()->orderBy('order')->get() as $s) {
                $this->command->info("[{$s->order}] {$s->type} - {$s->section_name} (active: {$s->is_active})");
            }
        }

        // Check testimonials
        try {
            $count = \App\Models\Testimonial::count();
            $this->command->info("Testimonials in DB: {$count}");
            if ($count > 0) {
                $t = \App\Models\Testimonial::first();
                $cols = implode(', ', array_keys($t->toArray()));
                $this->command->info("Columns: {$cols}");
            }
        } catch (\Exception $e) {
            $this->command->error("Testimonial error: " . $e->getMessage());
        }
    }
}
