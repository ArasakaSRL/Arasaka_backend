<?php

namespace App\Http\Controllers\Certificacion;
use App\Actions\Certificacion\CreateCertificacion;
use App\Actions\Certificacion\GetCertificacionesByPortafolio;
use App\Http\Requests\Certificacion\StoreCertificacionRequest;
use App\Http\Resources\CertificacionResource;
use App\Models\Certificacion;
use App\Services\Certificacion\CertificacionService;
use App\Http\Requests\Certificacion\DeleteCertificacionRequest;
class CertificacionController {

    public function __construct(
        protected CertificacionService $service, 
    ) {}

    public function index(GetCertificacionesByPortafolio $action, string $idPortafolio){
        $certificaciones = $action->execute($idPortafolio);
        return CertificacionResource::collection($certificaciones);
    }

    public function store(StoreCertificacionRequest $request, CreateCertificacion $action, string $idPortafolio){
        $certificacion = $action->execute(
            $request->validated(),
            $idPortafolio
        );

        return new CertificacionResource($certificacion);
    }

    public function show(Certificacion $certificacion){
        return new CertificacionResource(
            $certificacion->load('categoria')
        );
    }
    
    public function update(StoreCertificacionRequest $request, Certificacion $certificacion){
        $certificacion = $this->service->actualizar($certificacion, $request->validated());
        return new CertificacionResource($certificacion);
    }

    public function destroy(Certificacion $certificacion){
        $this->service->eliminar($certificacion);
        return response()->json(['message' => 'Certificación eliminada correctamente']);
    }
    public function destroyMultiple(DeleteCertificacionRequest $request)
   {
    $ids = $request->ids;

    $totalEliminadas = $this->service->eliminar($ids);

    return response()->json([
        'message' => 'Certificaciones eliminadas correctamente',
        'total_eliminadas' => $totalEliminadas
    ]);
  }
    
    public function byCategoria(string $idPortafolio, $idCategoria)
    {
        $certificaciones = \App\Models\Certificacion::with('categoria')
            ->where('id_portafolio', $idPortafolio)
            ->where('id_categoria_certificacion', $idCategoria)
            ->get();

        return CertificacionResource::collection($certificaciones);
    }

    public function deleteByPortafolio(string $idPortafolio)
    {
        $total = \App\Models\Certificacion::where(
            'id_portafolio',
            $idPortafolio
        )->delete();

        return response()->json([
            'message' => 'Todas las certificaciones fueron eliminadas',
            'total_eliminadas' => $total
        ]);
    }
}