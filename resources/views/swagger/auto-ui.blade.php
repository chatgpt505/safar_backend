<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    
    <!-- Swagger UI CSS -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/swagger-ui-dist@5.9.0/swagger-ui.css" />
    
    <style>
        html {
            box-sizing: border-box;
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }
        
        *, *:before, *:after {
            box-sizing: inherit;
        }
        
        body {
            margin: 0;
            background: #fafafa;
        }
        
        .swagger-ui .topbar {
            background-color: #2c3e50;
        }
        
        .swagger-ui .topbar .download-url-wrapper .select-label {
            color: #fff;
        }
        
        .swagger-ui .topbar .download-url-wrapper input[type=text] {
            border: 2px solid #34495e;
        }
        
        .swagger-ui .info .title {
            color: #2c3e50;
        }
        
        .swagger-ui .scheme-container {
            background: #f8f9fa;
            box-shadow: 0 1px 2px 0 rgba(0,0,0,.15);
        }
    </style>
</head>
<body>
    <div id="swagger-ui"></div>

    <!-- Swagger UI JavaScript -->
    <script src="https://unpkg.com/swagger-ui-dist@5.9.0/swagger-ui-bundle.js"></script>
    <script src="https://unpkg.com/swagger-ui-dist@5.9.0/swagger-ui-standalone-preset.js"></script>
    
    <script>
        window.onload = function() {
            // Auto-generated OpenAPI specification
            const spec = {!! $spec !!};
            
            // Initialize Swagger UI
            const ui = SwaggerUIBundle({
                spec: spec,
                dom_id: '#swagger-ui',
                deepLinking: true,
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                plugins: [
                    SwaggerUIBundle.plugins.DownloadUrl
                ],
                layout: "StandaloneLayout",
                validatorUrl: null,
                docExpansion: 'list',
                filter: true,
                showRequestHeaders: true,
                showCommonExtensions: true,
                tryItOutEnabled: true,
                requestInterceptor: function(request) {
                    // Add base URL if not present
                    if (!request.url.startsWith('http')) {
                        request.url = window.location.origin + '/api' + request.url;
                    }
                    return request;
                },
                responseInterceptor: function(response) {
                    return response;
                }
            });
            
            // Add custom styling for better UX
            const style = document.createElement('style');
            style.textContent = `
                .swagger-ui .opblock.opblock-get .opblock-summary-method {
                    background-color: #61affe;
                }
                .swagger-ui .opblock.opblock-post .opblock-summary-method {
                    background-color: #49cc90;
                }
                .swagger-ui .opblock.opblock-put .opblock-summary-method {
                    background-color: #fca130;
                }
                .swagger-ui .opblock.opblock-delete .opblock-summary-method {
                    background-color: #f93e3e;
                }
                .swagger-ui .opblock.opblock-patch .opblock-summary-method {
                    background-color: #50e3c2;
                }
                .swagger-ui .info .title {
                    font-size: 36px;
                    font-weight: 600;
                }
                .swagger-ui .info .description {
                    font-size: 16px;
                    line-height: 1.5;
                }
                .swagger-ui .scheme-container {
                    margin: 0 0 20px;
                    padding: 20px;
                    border-radius: 4px;
                }
            `;
            document.head.appendChild(style);
        };
    </script>
</body>
</html>
