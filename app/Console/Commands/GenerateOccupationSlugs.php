<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Occupation;
use Illuminate\Support\Str;

class GenerateOccupationSlugs extends Command
{
    protected $signature = 'generate:occupation-slugs';
    protected $description = 'Generate slugs for occupations';

    public function handle()
    {
        $occupations = Occupation::all();

        foreach ($occupations as $occupation) {
            $slug = Str::slug($occupation->occupation_name);
            $occupation->update(['slug' => $slug]);
        }

        $this->info('Occupation slugs generated successfully.');
    }
}
