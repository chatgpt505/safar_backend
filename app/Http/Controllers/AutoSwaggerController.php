<?php

namespace App\Http\Controllers;

use App\Services\AutoSwaggerService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AutoSwaggerController extends Controller
{
    protected $swaggerService;

    public function __construct(AutoSwaggerService $swaggerService)
    {
        $this->swaggerService = $swaggerService;
    }

    /**
     * Serve the auto-generated Swagger UI
     */
    public function ui()
    {
        $documentation = $this->swaggerService->generateDocumentation();
        $jsonSpec = json_encode($documentation, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        return view('swagger.auto-ui', [
            'spec' => $jsonSpec,
            'title' => 'Safar Backend API - Auto Generated'
        ]);
    }

    /**
     * Serve the OpenAPI specification as JSON
     */
    public function json(): JsonResponse
    {
        $documentation = $this->swaggerService->generateDocumentation();
        
        return response()->json($documentation);
    }

    /**
     * Serve the OpenAPI specification as YAML
     */
    public function yaml()
    {
        $documentation = $this->swaggerService->generateDocumentation();
        $yaml = yaml_emit($documentation);
        
        return response($yaml, 200, [
            'Content-Type' => 'application/x-yaml',
            'Content-Disposition' => 'inline; filename="api-docs-auto.yaml"'
        ]);
    }
}
