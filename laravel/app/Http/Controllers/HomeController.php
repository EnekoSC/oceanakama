<?php

namespace App\Http\Controllers;

use App\Enums\EstadoCurso;
use App\Enums\EstadoPost;
use App\Models\Curso;
use App\Models\Post;

class HomeController extends Controller
{
    public function __invoke()
    {
        $cursosDestacados = Curso::query()
            ->where('estado', EstadoCurso::Proximo)
            ->where('plazas_disponibles', '>', 0)
            ->orderBy('fecha_inicio')
            ->take(3)
            ->get();

        $ultimosPosts = Post::query()
            ->where('estado', EstadoPost::Publicado)
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('home', compact('cursosDestacados', 'ultimosPosts'));
    }
}
