<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class GeneratePermissionsService
{
    /**
     * Generate permissions based on models and controllers in the application
     */
    public function generate(): array
    {
        $generatedPermissions = [];

        // Get all models in the app/Models directory
        $models = $this->getModels();

        foreach ($models as $model) {
            // Generate standard CRUD permissions for each model
            $permissions = [
                "view any {$model}",
                "view {$model}",
                "create {$model}",
                "update {$model}",
                "delete {$model}",
            ];

            foreach ($permissions as $permission) {
                $permissionName = Str::slug($permission);
                if (! Permission::where('name', $permissionName)->exists()) {
                    Permission::create(['name' => $permissionName]);
                    $generatedPermissions[] = $permissionName;
                }
            }
        }

        // Additionally, scan controllers for custom permissions
        $controllerPermissions = $this->scanControllersForPermissions();
        foreach ($controllerPermissions as $permission) {
            $permissionName = Str::slug($permission);
            if (! Permission::where('name', $permissionName)->exists()) {
                Permission::create(['name' => $permissionName]);
                $generatedPermissions[] = $permissionName;
            }
        }

        return $generatedPermissions;
    }

    /**
     * Get all models from the Models directory
     */
    private function getModels(): array
    {
        $modelsPath = app_path('Models');
        $models = [];

        if (File::exists($modelsPath)) {
            $files = File::allFiles($modelsPath);

            foreach ($files as $file) {
                $fileName = $file->getFilename();
                if (Str::endsWith($fileName, '.php')) {
                    $modelName = Str::before($fileName, '.php');
                    $models[] = Str::lower($modelName);
                }
            }
        }

        return $models;
    }

    /**
     * Scan controllers for potential permission names
     */
    private function scanControllersForPermissions(): array
    {
        $controllersPath = app_path('Http/Controllers');
        $permissions = [];

        if (File::exists($controllersPath)) {
            $files = File::allFiles($controllersPath);

            foreach ($files as $file) {
                $content = File::get($file->getPathname());

                // Look for common permission patterns in controller methods
                preg_match_all('/(\'|")([a-z_ ]+ [a-z_]+)(\'|")/', $content, $matches);

                if (! empty($matches[2])) {
                    foreach ($matches[2] as $match) {
                        if (strpos($match, ' ') !== false && ! in_array($match, $permissions)) {
                            $permissions[] = $match;
                        }
                    }
                }
            }
        }

        return $permissions;
    }
}
