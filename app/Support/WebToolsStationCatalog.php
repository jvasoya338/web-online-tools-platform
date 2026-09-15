<?php

namespace App\Support;

class WebToolsStationCatalog
{
    public function toolGuideMap(): array
    {
        return require app_path('Data/tool-guide-map.php');
    }

    public function tools(): array
    {
        return require app_path('Data/tools.php');
    }

    public function guides(): array
    {
        return require app_path('Data/guides.php');
    }

    public function toolEditorial(): array
    {
        return require app_path('Data/tool-editorial.php');
    }

    public function guideMetadata(): array
    {
        return require app_path('Data/guide-metadata.php');
    }

    public function guideDepth(): array
    {
        return require app_path('Data/guide-depth.php');
    }

    public function authors(): array
    {
        return require app_path('Data/authors.php');
    }

    public function toolDepth(): array
    {
        return require app_path('Data/tool-depth.php');
    }

    public function categories(): array
    {
        return require app_path('Data/categories.php');
    }

    public function collections(): array
    {
        return require app_path('Data/collections.php');
    }
}
