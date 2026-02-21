<?php

namespace App\Http\Controllers;

use App\Enums\EstadoCurso;
use App\Enums\EstadoResena;
use App\Enums\NivelCurso;
use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        $cursos = Curso::query()
            ->whereIn('estado', [EstadoCurso::Proximo, EstadoCurso::EnCurso])
            ->when($request->filled('nivel'), fn ($q) => $q->where('nivel', $request->nivel))
            ->when($request->filled('precio_max'), fn ($q) => $q->where('precio', '<=', $request->precio_max))
            ->when($request->filled('buscar'), fn ($q) => $q->where('nombre', 'like', '%' . $request->buscar . '%'))
            ->orderBy('fecha_inicio')
            ->paginate(9)
            ->withQueryString();

        $niveles = NivelCurso::cases();

        return view('cursos.index', compact('cursos', 'niveles'));
    }

    public function show(Curso $curso)
    {
        $curso->load([
            'resenas' => fn ($q) => $q->where('estado', EstadoResena::Aprobada)->with('user')->latest(),
        ]);

        return view('cursos.show', compact('curso'));
    }
}
