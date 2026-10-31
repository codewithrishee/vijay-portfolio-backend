<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            ['name' => 'PHP', 'category' => 'LANGUAGES', 'description' => 'Server-side web development', 'icon' => '{ }', 'color' => 'orange', 'sort_order' => 1],
            ['name' => 'JavaScript', 'category' => 'LANGUAGES', 'description' => 'Interactive web experiences', 'icon' => 'JS', 'color' => 'yellow', 'sort_order' => 2],
            ['name' => 'HTML5', 'category' => 'LANGUAGES', 'description' => 'Semantic, accessible markup', 'icon' => '<>', 'color' => 'orange', 'sort_order' => 3],
            ['name' => 'CSS3', 'category' => 'LANGUAGES', 'description' => 'Responsive styling and layouts', 'icon' => '✎', 'color' => 'cyan', 'sort_order' => 4],
            ['name' => 'React', 'category' => 'FRONTEND', 'description' => 'Components, props and hooks', 'icon' => '⚛', 'color' => 'cyan', 'sort_order' => 5],
            ['name' => 'Bootstrap', 'category' => 'FRONTEND', 'description' => 'Responsive UI development', 'icon' => 'B', 'color' => 'purple', 'sort_order' => 6],
            ['name' => 'Tailwind CSS', 'category' => 'FRONTEND', 'description' => 'Utility-first styling', 'icon' => '≋', 'color' => 'cyan', 'sort_order' => 7],
            ['name' => 'Laravel', 'category' => 'BACKEND', 'description' => 'MVC applications, routing', 'icon' => '◆', 'color' => 'red', 'sort_order' => 8],
            ['name' => 'REST APIs', 'category' => 'BACKEND', 'description' => 'CRUD, validation and responses', 'icon' => '⌘', 'color' => 'green', 'sort_order' => 9],
            ['name' => 'MySQL', 'category' => 'DATABASE', 'description' => 'Queries, joins and relationships', 'icon' => '▤', 'color' => 'blue', 'sort_order' => 10],
            ['name' => 'Git & GitHub', 'category' => 'DEVOPS', 'description' => 'Version control and repositories', 'icon' => '⑂', 'color' => 'orange', 'sort_order' => 11],
            ['name' => 'VS Code', 'category' => 'DEVOPS', 'description' => 'Everyday development workflow', 'icon' => '⌘', 'color' => 'blue', 'sort_order' => 12],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(
                ['name' => $skill['name']],
                array_merge($skill, ['is_active' => true])
            );
        }
    }
}