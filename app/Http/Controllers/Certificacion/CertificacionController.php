<?php

namespace App\Http\Controllers\Certificacion;
use App\Actions\Certificacion\CreateCertificacion;
use App\Actions\Certificacion\GetCertificacionesByPortafolio;
use App\Http\Requests\Certificacion\StoreCertificacionRequest;
use App\Http\Resources\CertificacionResource;
use App\Models\Certificacion;
use App\Services\Certificacion\CertificacionService;

class CertificacionController {
    public function __construct(
        protected CertificacionService $service, 
    ) {}

    public function index($idPortafolio, GetCertificacionesByPortafolio $action){
        $certificaciones = $action->execute($idPortafolio);
        return CertificacionResource::collection($certificaciones);

    }

    public function store($idPortafolio, StoreCertificacionRequest $request, CreateCertificacion $action){
        $certificaciones = $action->execute($request->validated(), $idPortafolio);
        return new CertificacionResource($certificaciones);
    }

    public function show(Certificacion $certificacion){
        return new CertificacionResource($certificacion ->load('categoria'));
    }
    
    public function update(StoreCertificacionRequest $request, Certificacion $certificacion){
        $certificacion = $this->service->actualizar($certificacion, $request->validated());
        return new CertificacionResource($certificacion);
    }

    public function destroy(Certificacion $certificacion){
        $this->service->eliminar($certificacion);
        return response()->json(['message' => 'Certificación eliminada correctamente']);
    }
    
    public function byCategoria($idPortafolio, $idCategoria)
{
    $certificaciones = \App\Models\Certificacion::with('categoria')
        ->where('id_portafolio', $idPortafolio)
        ->where('id_categoria_certificacion', $idCategoria)
        ->get();

    return \App\Http\Resources\CertificacionResource::collection($certificaciones);
}

 public function deleteByPortafolio($idPortafolio)
{
    $total = \App\Models\Certificacion::where('id_portafolio', $idPortafolio)->delete();

    return response()->json([
        'message' => 'Todas las certificaciones fueron eliminadas',
        'total_eliminadas' => $total
    ]);
}
}