<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\GenerateAutoSwagger;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Register the auto-swagger command
Artisan::command('swagger:generate-auto', function () {
    $swaggerService = app(\App\Services\AutoSwaggerService::class);
    $documentation = $swaggerService->generateDocumentation();
    
    $output = json_encode($documentation, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    $outputPath = storage_path('api-docs/api-docs-auto.json');
    
    if (!is_dir(dirname($outputPath))) {
        mkdir(dirname($outputPath), 0755, true);
    }
    
    file_put_contents($outputPath, $output);
    
    $this->info("Auto-generated Swagger documentation saved to: {$outputPath}");
    $this->info("Total endpoints documented: " . count($documentation['paths']));
    
    // Show summary of documented endpoints
    $this->newLine();
    $this->info('Documented endpoints:');
    foreach ($documentation['paths'] as $path => $methods) {
        foreach ($methods as $method => $operation) {
            $this->line("  " . strtoupper($method) . " {$path} - {$operation['summary']}");
        }
    }
})->purpose('Generate automatic Swagger documentation without annotations');
