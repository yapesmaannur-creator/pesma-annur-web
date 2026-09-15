<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Http\Resources\ProgramResource;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $programs = Program::when($request->kategori, function ($q, $kategori) {
            return $q->where('kategori', $kategori);
        })->get();

        return ProgramResource::collection($programs);
    }
}
