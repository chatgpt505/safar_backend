<?php

namespace App\Services;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AutoSwaggerService
{
    protected $router;
    protected $openApi = [];
    protected $paths = [];
    protected $schemas = [];
    protected $tags = [];

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->initializeOpenApi();
    }

    protected function initializeOpenApi()
    {
        $this->openApi = [
            'openapi' => '3.0.0',
            'info' => [
                'title' => 'Safar Backend API',
                'description' => 'Auto-generated API documentation for Safar Backend',
                'version' => '1.0.0',
                'contact' => [
                    'email' => 'admin@safar.com'
                ]
            ],
            'servers' => [
                [
                    'url' => config('app.url') . '/api',
                    'description' => 'API Server'
                ]
            ],
            'paths' => [],
            'components' => [
                'schemas' => [],
                'securitySchemes' => [
                    'bearerAuth' => [
                        'type' => 'http',
                        'scheme' => 'bearer',
                        'bearerFormat' => 'JWT'
                    ]
                ]
            ],
            'tags' => []
        ];
    }

    public function generateDocumentation()
    {
        $this->scanRoutes();
        $this->generateSchemas();
        
        return $this->openApi;
    }

    protected function scanRoutes()
    {
        $routes = Route::getRoutes();
        
        foreach ($routes as $route) {
            if ($route->getPrefix() === 'api') {
                $this->processRoute($route);
            }
        }
    }

    protected function processRoute($route)
    {
        $uri = $route->uri();
        $methods = $route->methods();
        $action = $route->getAction();
        
        if (!isset($action['controller'])) {
            return;
        }

        [$controllerClass, $method] = explode('@', $action['controller']);
        
        if (!class_exists($controllerClass)) {
            return;
        }

        $reflection = new ReflectionClass($controllerClass);
        $methodReflection = $reflection->getMethod($method);
        
        foreach ($methods as $httpMethod) {
            if ($httpMethod === 'HEAD') continue;
            
            $this->generatePathItem($uri, strtolower($httpMethod), $controllerClass, $method, $methodReflection, $route);
        }
    }

    protected function generatePathItem($uri, $method, $controllerClass, $methodName, $methodReflection, $route)
    {
        $path = '/' . $uri;
        $tag = $this->getControllerTag($controllerClass);
        
        $operation = [
            'tags' => [$tag],
            'summary' => $this->generateSummary($methodName),
            'description' => $this->generateDescription($methodName, $methodReflection),
            'operationId' => $this->generateOperationId($controllerClass, $methodName),
            'parameters' => $this->generateParameters($uri, $methodReflection),
            'requestBody' => $this->generateRequestBody($method, $methodReflection),
            'responses' => $this->generateResponses($method, $methodReflection),
        ];

        // Add security if route has auth middleware
        if ($this->hasAuthMiddleware($route)) {
            $operation['security'] = [['bearerAuth' => []]];
        }

        if (!isset($this->openApi['paths'][$path])) {
            $this->openApi['paths'][$path] = [];
        }

        $this->openApi['paths'][$path][$method] = $operation;
    }

    protected function getControllerTag($controllerClass)
    {
        $className = class_basename($controllerClass);
        return str_replace('Controller', '', $className);
    }

    protected function generateSummary($methodName)
    {
        $summary = str_replace(['_', '-'], ' ', $methodName);
        return ucfirst($summary);
    }

    protected function generateDescription($methodName, $methodReflection)
    {
        $docComment = $methodReflection->getDocComment();
        if ($docComment) {
            $lines = explode("\n", $docComment);
            foreach ($lines as $line) {
                $line = trim($line, " \t\n\r\0\x0B*/");
                if (!empty($line) && !str_starts_with($line, '@')) {
                    return $line;
                }
            }
        }
        
        return $this->generateSummary($methodName);
    }

    protected function generateOperationId($controllerClass, $methodName)
    {
        $controller = str_replace('Controller', '', class_basename($controllerClass));
        return strtolower($controller) . '_' . $methodName;
    }

    protected function generateParameters($uri, $methodReflection)
    {
        $parameters = [];
        
        // Extract path parameters from URI
        preg_match_all('/\{([^}]+)\}/', $uri, $matches);
        foreach ($matches[1] as $param) {
            $parameters[] = [
                'name' => $param,
                'in' => 'path',
                'required' => true,
                'schema' => ['type' => 'string']
            ];
        }

        // Add query parameters based on method parameters
        $methodParams = $methodReflection->getParameters();
        foreach ($methodParams as $param) {
            if ($param->getType() && $param->getType()->getName() === Request::class) {
                // Add common query parameters
                $parameters[] = [
                    'name' => 'page',
                    'in' => 'query',
                    'required' => false,
                    'schema' => ['type' => 'integer', 'default' => 1]
                ];
                $parameters[] = [
                    'name' => 'per_page',
                    'in' => 'query',
                    'required' => false,
                    'schema' => ['type' => 'integer', 'default' => 15]
                ];
                break;
            }
        }

        return $parameters;
    }

    protected function generateRequestBody($method, $methodReflection)
    {
        if (!in_array($method, ['post', 'put', 'patch'])) {
            return null;
        }

        $properties = [];
        $required = [];

        // Analyze method parameters to determine request body structure
        $methodParams = $methodReflection->getParameters();
        foreach ($methodParams as $param) {
            if ($param->getType() && $param->getType()->getName() === Request::class) {
                // Generate common request body properties based on method name
                $properties = $this->generateRequestBodyProperties($methodReflection->getName());
                break;
            }
        }

        if (empty($properties)) {
            return null;
        }

        return [
            'required' => true,
            'content' => [
                'application/json' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => $properties,
                        'required' => $required
                    ]
                ]
            ]
        ];
    }

    protected function generateRequestBodyProperties($methodName)
    {
        $properties = [];

        switch ($methodName) {
            case 'register':
                $properties = [
                    'name' => ['type' => 'string', 'example' => 'John Doe'],
                    'email' => ['type' => 'string', 'format' => 'email', 'example' => 'john@example.com'],
                    'password' => ['type' => 'string', 'format' => 'password', 'example' => 'password123'],
                    'password_confirmation' => ['type' => 'string', 'format' => 'password', 'example' => 'password123'],
                    'phone' => ['type' => 'string', 'example' => '+1234567890'],
                    'role' => ['type' => 'string', 'enum' => ['user', 'admin', 'moderator'], 'example' => 'user']
                ];
                break;
            case 'login':
                $properties = [
                    'email' => ['type' => 'string', 'format' => 'email', 'example' => 'john@example.com'],
                    'password' => ['type' => 'string', 'format' => 'password', 'example' => 'password123']
                ];
                break;
            case 'updateProfile':
                $properties = [
                    'name' => ['type' => 'string', 'example' => 'John Updated'],
                    'phone' => ['type' => 'string', 'example' => '+0987654321']
                ];
                break;
            case 'createUser':
                $properties = [
                    'name' => ['type' => 'string', 'example' => 'New User'],
                    'email' => ['type' => 'string', 'format' => 'email', 'example' => 'newuser@example.com'],
                    'password' => ['type' => 'string', 'format' => 'password', 'example' => 'password123'],
                    'phone' => ['type' => 'string', 'example' => '+1234567890'],
                    'role' => ['type' => 'string', 'enum' => ['user', 'admin', 'moderator'], 'example' => 'user'],
                    'is_active' => ['type' => 'boolean', 'example' => true]
                ];
                break;
            case 'updateUser':
                $properties = [
                    'name' => ['type' => 'string', 'example' => 'Updated Name'],
                    'email' => ['type' => 'string', 'format' => 'email', 'example' => 'updated@example.com'],
                    'phone' => ['type' => 'string', 'example' => '+0987654321'],
                    'role' => ['type' => 'string', 'enum' => ['user', 'admin', 'moderator'], 'example' => 'moderator'],
                    'is_active' => ['type' => 'boolean', 'example' => false]
                ];
                break;
            case 'resetUserPassword':
                $properties = [
                    'new_password' => ['type' => 'string', 'format' => 'password', 'example' => 'newpassword123']
                ];
                break;
        }

        return $properties;
    }

    protected function generateResponses($method, $methodReflection)
    {
        $responses = [];

        // Common success responses
        switch ($method) {
            case 'get':
                $responses['200'] = [
                    'description' => 'Success',
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'success' => ['type' => 'boolean', 'example' => true],
                                    'data' => ['type' => 'object']
                                ]
                            ]
                        ]
                    ]
                ];
                break;
            case 'post':
                $responses['201'] = [
                    'description' => 'Created successfully',
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'success' => ['type' => 'boolean', 'example' => true],
                                    'message' => ['type' => 'string'],
                                    'data' => ['type' => 'object']
                                ]
                            ]
                        ]
                    ]
                ];
                break;
            case 'put':
            case 'patch':
                $responses['200'] = [
                    'description' => 'Updated successfully',
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'success' => ['type' => 'boolean', 'example' => true],
                                    'message' => ['type' => 'string'],
                                    'data' => ['type' => 'object']
                                ]
                            ]
                        ]
                    ]
                ];
                break;
            case 'delete':
                $responses['200'] = [
                    'description' => 'Deleted successfully',
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'success' => ['type' => 'boolean', 'example' => true],
                                    'message' => ['type' => 'string']
                                ]
                            ]
                        ]
                    ]
                ];
                break;
        }

        // Common error responses
        $responses['400'] = [
            'description' => 'Bad Request',
            'content' => [
                'application/json' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'success' => ['type' => 'boolean', 'example' => false],
                            'message' => ['type' => 'string'],
                            'errors' => ['type' => 'object']
                        ]
                    ]
                ]
            ]
        ];

        $responses['401'] = [
            'description' => 'Unauthorized',
            'content' => [
                'application/json' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'success' => ['type' => 'boolean', 'example' => false],
                            'message' => ['type' => 'string', 'example' => 'Unauthorized']
                        ]
                    ]
                ]
            ]
        ];

        $responses['403'] = [
            'description' => 'Forbidden',
            'content' => [
                'application/json' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'success' => ['type' => 'boolean', 'example' => false],
                            'message' => ['type' => 'string', 'example' => 'Insufficient permissions']
                        ]
                    ]
                ]
            ]
        ];

        $responses['404'] = [
            'description' => 'Not Found',
            'content' => [
                'application/json' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'success' => ['type' => 'boolean', 'example' => false],
                            'message' => ['type' => 'string', 'example' => 'Resource not found']
                        ]
                    ]
                ]
            ]
        ];

        $responses['422'] = [
            'description' => 'Validation Error',
            'content' => [
                'application/json' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'success' => ['type' => 'boolean', 'example' => false],
                            'message' => ['type' => 'string'],
                            'errors' => ['type' => 'object']
                        ]
                    ]
                ]
            ]
        ];

        return $responses;
    }

    protected function hasAuthMiddleware($route)
    {
        $middleware = $route->middleware();
        return in_array('token.auth', $middleware) || in_array('auth:sanctum', $middleware);
    }

    protected function generateSchemas()
    {
        // Add common schemas
        $this->openApi['components']['schemas']['User'] = [
            'type' => 'object',
            'properties' => [
                'id' => ['type' => 'string'],
                'name' => ['type' => 'string'],
                'email' => ['type' => 'string', 'format' => 'email'],
                'phone' => ['type' => 'string'],
                'role' => ['type' => 'string', 'enum' => ['user', 'admin', 'moderator']],
                'is_active' => ['type' => 'boolean'],
                'created_at' => ['type' => 'string', 'format' => 'date-time'],
                'updated_at' => ['type' => 'string', 'format' => 'date-time']
            ]
        ];

        $this->openApi['components']['schemas']['PaginatedResponse'] = [
            'type' => 'object',
            'properties' => [
                'current_page' => ['type' => 'integer'],
                'data' => ['type' => 'array', 'items' => ['$ref' => '#/components/schemas/User']],
                'first_page_url' => ['type' => 'string'],
                'from' => ['type' => 'integer'],
                'last_page' => ['type' => 'integer'],
                'last_page_url' => ['type' => 'string'],
                'next_page_url' => ['type' => 'string'],
                'path' => ['type' => 'string'],
                'per_page' => ['type' => 'integer'],
                'prev_page_url' => ['type' => 'string'],
                'to' => ['type' => 'integer'],
                'total' => ['type' => 'integer']
            ]
        ];
    }
}
