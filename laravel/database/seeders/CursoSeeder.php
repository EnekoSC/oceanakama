<?php

namespace Database\Seeders;

use App\Enums\EstadoCurso;
use App\Enums\NivelCurso;
use App\Models\Curso;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        $cursos = [
            [
                'nombre' => ['es' => 'Open Water Diver', 'en' => 'Open Water Diver'],
                'nivel' => NivelCurso::Principiante,
                'duracion' => '4 días',
                'precio' => 450.00,
                'certificacion_ssi' => 'Open Water Diver',
                'plazas_max' => 8,
                'plazas_disponibles' => 5,
                'estado' => EstadoCurso::Proximo,
                'descripcion' => [
                    'es' => '<p>Tu primer paso en el mundo del buceo. Aprende las habilidades fundamentales para bucear de forma segura hasta 18 metros de profundidad.</p>',
                    'en' => '<p>Your first step into the diving world. Learn the fundamental skills to dive safely to 18 meters depth.</p>',
                ],
                'fecha_inicio' => '2026-04-15',
                'fecha_fin' => '2026-04-18',
            ],
            [
                'nombre' => ['es' => 'Advanced Adventurer', 'en' => 'Advanced Adventurer'],
                'nivel' => NivelCurso::Intermedio,
                'duracion' => '3 días',
                'precio' => 380.00,
                'certificacion_ssi' => 'Advanced Adventurer',
                'plazas_max' => 6,
                'plazas_disponibles' => 3,
                'estado' => EstadoCurso::Proximo,
                'descripcion' => [
                    'es' => '<p>Amplía tus habilidades con 5 inmersiones de especialidad. Navegación, profundidad, nocturna y más.</p>',
                    'en' => '<p>Expand your skills with 5 specialty dives. Navigation, deep, night and more.</p>',
                ],
                'fecha_inicio' => '2026-05-10',
                'fecha_fin' => '2026-05-12',
            ],
            [
                'nombre' => ['es' => 'Especialidad en Buceo Profundo', 'en' => 'Deep Diving Specialty'],
                'nivel' => NivelCurso::Avanzado,
                'duracion' => '2 días',
                'precio' => 320.00,
                'certificacion_ssi' => 'Deep Diving',
                'plazas_max' => 4,
                'plazas_disponibles' => 4,
                'estado' => EstadoCurso::Proximo,
                'descripcion' => [
                    'es' => '<p>Domina las técnicas de buceo profundo hasta 40 metros. Planificación, gestión de gas y procedimientos de seguridad.</p>',
                    'en' => '<p>Master deep diving techniques to 40 meters. Planning, gas management and safety procedures.</p>',
                ],
                'fecha_inicio' => '2026-06-07',
                'fecha_fin' => '2026-06-08',
            ],
            [
                'nombre' => ['es' => 'Buceo Nocturno', 'en' => 'Night Diving'],
                'nivel' => NivelCurso::Intermedio,
                'duracion' => '1 día',
                'precio' => 180.00,
                'certificacion_ssi' => 'Night Diving',
                'plazas_max' => 6,
                'plazas_disponibles' => 6,
                'estado' => EstadoCurso::Proximo,
                'descripcion' => [
                    'es' => '<p>Descubre la magia del mar de noche. Técnicas de iluminación, comunicación y navegación nocturna.</p>',
                    'en' => '<p>Discover the magic of the sea at night. Lighting techniques, communication and night navigation.</p>',
                ],
                'fecha_inicio' => '2026-05-23',
                'fecha_fin' => '2026-05-23',
            ],
            [
                'nombre' => ['es' => 'Divemaster', 'en' => 'Divemaster'],
                'nivel' => NivelCurso::Profesional,
                'duracion' => '2 semanas',
                'precio' => 1200.00,
                'certificacion_ssi' => 'Divemaster',
                'plazas_max' => 4,
                'plazas_disponibles' => 2,
                'estado' => EstadoCurso::Proximo,
                'descripcion' => [
                    'es' => '<p>Conviértete en profesional del buceo. Lidera inmersiones, asiste en cursos y comienza tu carrera en el mundo submarino.</p>',
                    'en' => '<p>Become a diving professional. Lead dives, assist in courses and start your career in the underwater world.</p>',
                ],
                'fecha_inicio' => '2026-07-01',
                'fecha_fin' => '2026-07-14',
            ],
            [
                'nombre' => ['es' => 'Try Scuba - Bautizo de buceo', 'en' => 'Try Scuba - Discover Diving'],
                'nivel' => NivelCurso::Principiante,
                'duracion' => '3 horas',
                'precio' => 75.00,
                'certificacion_ssi' => 'Try Scuba',
                'plazas_max' => 10,
                'plazas_disponibles' => 8,
                'estado' => EstadoCurso::Proximo,
                'descripcion' => [
                    'es' => '<p>Primera experiencia de buceo en aguas confinadas. Sin requisitos previos. Incluye equipo completo.</p>',
                    'en' => '<p>First diving experience in confined waters. No previous requirements. Full equipment included.</p>',
                ],
                'fecha_inicio' => '2026-04-05',
                'fecha_fin' => '2026-04-05',
            ],
        ];

        foreach ($cursos as $data) {
            $data['slug'] = Str::slug($data['nombre']['es']);
            Curso::create($data);
        }
    }
}
