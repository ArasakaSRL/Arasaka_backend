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

    private function getPortafolioId()
    {
        return auth()->user()->portafolio->id_portafolio;
    }

    public function index(GetCertificacionesByPortafolio $action){
        $certificaciones = $action->execute($this->getPortafolioId());
        return CertificacionResource::collection($certificaciones);
    }

    public function store(StoreCertificacionRequest $request, CreateCertificacion $action){
        $certificacion = $action->execute(
            $request->validated(),
            $this->getPortafolioId()
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
    
    public function byCategoria($idCategoria)
    {
        $certificaciones = \App\Models\Certificacion::with('categoria')
            ->where('id_portafolio', $this->getPortafolioId())
            ->where('id_categoria_certificacion', $idCategoria)
            ->get();

        return CertificacionResource::collection($certificaciones);
    }

    public function deleteByPortafolio()
    {
        $total = \App\Models\Certificacion::where(
            'id_portafolio',
            $this->getPortafolioId()
        )->delete();

        return response()->json([
            'message' => 'Todas las certificaciones fueron eliminadas',
            'total_eliminadas' => $total
        ]);
    }
}