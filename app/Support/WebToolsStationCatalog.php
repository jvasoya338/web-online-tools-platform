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
}
