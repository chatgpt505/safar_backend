<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AutoSwaggerService;
use Illuminate\Support\Facades\File;

class GenerateAutoSwagger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swagger:generate-auto {--format=json : Output format (json or yaml)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate automatic Swagger documentation without annotations';

    /**
     * Execute the console command.
     */
    public function handle(AutoSwaggerService $swaggerService)
    {
        $this->info('Generating automatic Swagger documentation...');

        try {
            $documentation = $swaggerService->generateDocumentation();
            $format = $this->option('format');

            if ($format === 'yaml') {
                $output = yaml_emit($documentation);
                $filename = 'api-docs-auto.yaml';
            } else {
                $output = json_encode($documentation, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                $filename = 'api-docs-auto.json';
            }

            $outputPath = storage_path('api-docs/' . $filename);
            File::put($outputPath, $output);

            $this->info("Documentation generated successfully!");
            $this->info("File saved to: {$outputPath}");
            $this->info("Total endpoints documented: " . count($documentation['paths']));

            // Show summary of documented endpoints
            $this->newLine();
            $this->info('Documented endpoints:');
            foreach ($documentation['paths'] as $path => $methods) {
                foreach ($methods as $method => $operation) {
                    $this->line("  {$method->upper()} {$path} - {$operation['summary']}");
                }
            }

        } catch (\Exception $e) {
            $this->error('Error generating documentation: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
