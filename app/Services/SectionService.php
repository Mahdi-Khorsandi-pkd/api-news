<?php

namespace App\Services;

use App\Models\Section;
use Illuminate\Database\Eloquent\Collection;

class SectionService
{
    public function getAllSections(): Collection
    {
        return Section::all()->load('categories');
    }

    public function getSectionWithCategories(Section $section): Section
    {
        return $section->load('categories');
    }

    public function syncCategories(Section $section, array $categoryIds): void
    {
        $section->categories()->sync($categoryIds);
    }
}
