<?php

namespace Database\Seeders;

use App\Enums\EstadoPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@oceanakama.com')->first();
        $userId = $admin?->id ?? User::first()->id;

        $posts = [
            [
                'titulo' => [
                    'es' => 'Cómo prepararte para tu primer curso de buceo',
                    'en' => 'How to prepare for your first diving course',
                    'fr' => 'Comment se préparer pour son premier cours de plongée',
                ],
                'extracto' => [
                    'es' => 'Todo lo que necesitas saber antes de sumergirte por primera vez. Consejos prácticos para disfrutar al máximo de tu bautizo de buceo.',
                    'en' => 'Everything you need to know before your first dive. Practical tips to make the most of your discover scuba experience.',
                    'fr' => 'Tout ce que vous devez savoir avant votre première plongée. Conseils pratiques pour profiter au maximum de votre baptême de plongée.',
                ],
                'contenido' => [
                    'es' => '<h2>Antes de tu primera inmersión</h2><p>El buceo es una actividad emocionante que abre las puertas a un mundo completamente nuevo. Si estás pensando en hacer tu primer curso, aquí tienes algunos consejos para que todo salga perfecto.</p><h3>Preparación física</h3><p>No necesitas ser un atleta, pero es importante estar en buena forma general. Asegúrate de saber nadar con comodidad y de no tener problemas de oído o respiratorios.</p><h3>Qué llevar</h3><p>Bañador, toalla, protección solar y muchas ganas de aprender. Todo el equipo de buceo te lo proporcionamos nosotros.</p><h3>El día del curso</h3><p>Llegarás al centro donde empezaremos con una sesión teórica sobre seguridad y técnicas básicas. Después, pasaremos al agua para poner en práctica todo lo aprendido.</p>',
                    'en' => '<h2>Before your first dive</h2><p>Diving is an exciting activity that opens the door to a completely new world. If you\'re thinking about taking your first course, here are some tips to make everything perfect.</p><h3>Physical preparation</h3><p>You don\'t need to be an athlete, but it\'s important to be in good general shape. Make sure you can swim comfortably and don\'t have ear or breathing problems.</p><h3>What to bring</h3><p>Swimsuit, towel, sunscreen and a great desire to learn. We provide all the diving equipment.</p><h3>Course day</h3><p>You\'ll arrive at the center where we\'ll start with a theory session on safety and basic techniques. Then, we\'ll move to the water to practice everything you\'ve learned.</p>',
                    'fr' => '<h2>Avant votre première plongée</h2><p>La plongée est une activité passionnante qui ouvre les portes d\'un monde complètement nouveau. Si vous envisagez de suivre votre premier cours, voici quelques conseils pour que tout se passe parfaitement.</p><h3>Préparation physique</h3><p>Vous n\'avez pas besoin d\'être un athlète, mais il est important d\'être en bonne forme générale. Assurez-vous de savoir nager confortablement et de ne pas avoir de problèmes d\'oreille ou respiratoires.</p><h3>Quoi apporter</h3><p>Maillot de bain, serviette, crème solaire et une grande envie d\'apprendre. Nous fournissons tout l\'équipement de plongée.</p><h3>Le jour du cours</h3><p>Vous arriverez au centre où nous commencerons par une session théorique sur la sécurité et les techniques de base. Ensuite, nous passerons à l\'eau pour mettre en pratique tout ce que vous avez appris.</p>',
                ],
                'published_at' => '2026-02-15 10:00:00',
            ],
            [
                'titulo' => [
                    'es' => 'Los mejores puntos de inmersión en nuestra zona',
                    'en' => 'The best dive sites in our area',
                    'fr' => 'Les meilleurs sites de plongée dans notre région',
                ],
                'extracto' => [
                    'es' => 'Descubre los fondos marinos más espectaculares que podrás explorar con nuestros cursos y salidas de buceo.',
                    'en' => 'Discover the most spectacular seabeds you can explore with our courses and diving trips.',
                    'fr' => 'Découvrez les fonds marins les plus spectaculaires que vous pourrez explorer avec nos cours et sorties de plongée.',
                ],
                'contenido' => [
                    'es' => '<h2>Nuestros puntos de inmersión favoritos</h2><p>La costa mediterránea ofrece algunos de los mejores puntos de inmersión de Europa. Aquí te presentamos nuestros favoritos.</p><h3>La Cueva del Coral</h3><p>Una formación submarina espectacular con paredes cubiertas de coral naranja y gorgonias. Ideal para buceadores de nivel intermedio.</p><h3>El Pecio del Atlante</h3><p>Un barco hundido a 25 metros de profundidad que se ha convertido en un arrecife artificial lleno de vida marina.</p><h3>La Pradera de Posidonia</h3><p>Perfecta para principiantes, esta inmersión poco profunda te permite descubrir el ecosistema más importante del Mediterráneo.</p>',
                    'en' => '<h2>Our favourite dive sites</h2><p>The Mediterranean coast offers some of the best dive sites in Europe. Here are our favourites.</p><h3>The Coral Cave</h3><p>A spectacular underwater formation with walls covered in orange coral and gorgonians. Ideal for intermediate level divers.</p><h3>The Atlante Wreck</h3><p>A sunken ship at 25 metres depth that has become an artificial reef teeming with marine life.</p><h3>The Posidonia Meadow</h3><p>Perfect for beginners, this shallow dive lets you discover the most important ecosystem in the Mediterranean.</p>',
                    'fr' => '<h2>Nos sites de plongée préférés</h2><p>La côte méditerranéenne offre certains des meilleurs sites de plongée d\'Europe. Voici nos préférés.</p><h3>La Grotte du Corail</h3><p>Une formation sous-marine spectaculaire avec des parois couvertes de corail orange et de gorgones. Idéale pour les plongeurs de niveau intermédiaire.</p><h3>L\'épave de l\'Atlante</h3><p>Un navire coulé à 25 mètres de profondeur qui est devenu un récif artificiel regorgeant de vie marine.</p><h3>La Prairie de Posidonie</h3><p>Parfaite pour les débutants, cette plongée peu profonde vous permet de découvrir l\'écosystème le plus important de la Méditerranée.</p>',
                ],
                'published_at' => '2026-02-20 09:00:00',
            ],
            [
                'titulo' => [
                    'es' => 'Certificación SSI: todo lo que necesitas saber',
                    'en' => 'SSI Certification: everything you need to know',
                    'fr' => 'Certification SSI : tout ce que vous devez savoir',
                ],
                'extracto' => [
                    'es' => 'Te explicamos qué es la certificación SSI, los diferentes niveles disponibles y cómo avanzar en tu formación como buceador.',
                    'en' => 'We explain what SSI certification is, the different levels available and how to advance in your training as a diver.',
                    'fr' => 'Nous vous expliquons ce qu\'est la certification SSI, les différents niveaux disponibles et comment progresser dans votre formation de plongeur.',
                ],
                'contenido' => [
                    'es' => '<h2>¿Qué es SSI?</h2><p>Scuba Schools International (SSI) es una de las agencias de certificación de buceo más importantes del mundo, con presencia en más de 150 países.</p><h3>Niveles de certificación</h3><p>SSI ofrece una progresión clara desde principiante hasta profesional:</p><ul><li><strong>Try Scuba:</strong> Tu primera experiencia sin compromiso.</li><li><strong>Open Water Diver:</strong> La certificación básica que te permite bucear hasta 18m.</li><li><strong>Advanced Adventurer:</strong> Amplía tus habilidades con inmersiones de especialidad.</li><li><strong>Divemaster:</strong> El primer nivel profesional.</li></ul><h3>¿Por qué elegir SSI?</h3><p>SSI destaca por su enfoque en la práctica, materiales digitales gratuitos y reconocimiento internacional. Tu certificación SSI es válida en todo el mundo y para siempre.</p>',
                    'en' => '<h2>What is SSI?</h2><p>Scuba Schools International (SSI) is one of the most important diving certification agencies in the world, with a presence in over 150 countries.</p><h3>Certification levels</h3><p>SSI offers a clear progression from beginner to professional:</p><ul><li><strong>Try Scuba:</strong> Your first no-commitment experience.</li><li><strong>Open Water Diver:</strong> The basic certification that allows you to dive to 18m.</li><li><strong>Advanced Adventurer:</strong> Expand your skills with specialty dives.</li><li><strong>Divemaster:</strong> The first professional level.</li></ul><h3>Why choose SSI?</h3><p>SSI stands out for its practical approach, free digital materials and international recognition. Your SSI certification is valid worldwide and for life.</p>',
                    'fr' => '<h2>Qu\'est-ce que SSI ?</h2><p>Scuba Schools International (SSI) est l\'une des agences de certification de plongée les plus importantes au monde, présente dans plus de 150 pays.</p><h3>Niveaux de certification</h3><p>SSI offre une progression claire du débutant au professionnel :</p><ul><li><strong>Try Scuba :</strong> Votre première expérience sans engagement.</li><li><strong>Open Water Diver :</strong> La certification de base qui vous permet de plonger jusqu\'à 18m.</li><li><strong>Advanced Adventurer :</strong> Élargissez vos compétences avec des plongées de spécialité.</li><li><strong>Divemaster :</strong> Le premier niveau professionnel.</li></ul><h3>Pourquoi choisir SSI ?</h3><p>SSI se distingue par son approche pratique, ses supports numériques gratuits et sa reconnaissance internationale. Votre certification SSI est valable dans le monde entier et à vie.</p>',
                ],
                'published_at' => '2026-02-22 14:00:00',
            ],
        ];

        foreach ($posts as $data) {
            $data['slug'] = Str::slug($data['titulo']['es']);
            $data['estado'] = EstadoPost::Publicado;
            $data['user_id'] = $userId;
            Post::create($data);
        }
    }
}
