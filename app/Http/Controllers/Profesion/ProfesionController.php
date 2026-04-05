<?php

namespace App\Http\Controllers\Profesion;

use App\Http\Controllers\Controller;
use App\Services\Profesion\ProfesionService;
use Illuminate\Http\JsonResponse;

class ProfesionController extends Controller
{
  public function __construct(protected ProfesionService $profesionService) {}

  public function index(): JsonResponse
  {
    return response()->json(["data" => $this->profesionService->getAll()]);
  }

  public function show(string $id): JsonResponse
  {
    return response()->json(["data" => $this->profesionService->getById($id)]);
  }
}
