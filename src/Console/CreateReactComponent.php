<?php


namespace Ghazniali95\ReactWithLaravelBlade\Console;

use File;
use Illuminate\Console\Command;

class CreateReactComponent extends Command
{
    protected $signature = 'create:reactComponent {path} {--arg=* : Optional data arguments}';
    protected $description = 'Create a React component file';

    public function handle()
    {
        $path = $this->argument('path');

        $dataArguments = $this->option('arg');

        // Split the path into directories and the component name
        $pathParts = explode('/', $path);
        $componentName = array_pop($pathParts);

        // Generate a unique ID
        $uniqueId = uniqid();

        // Create the full directory path including nested directories
        $directoryPath = resource_path("js/components/" . implode('/', $pathParts));

        if (!File::isDirectory($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        } elseif (File::exists($directoryPath . '/' . $componentName . '.jsx')) {
            $this->error("Component '{$componentName}' already exists in '{$directoryPath}'");
            return;
        }

        // Create the JSX file
        $jsxFilePath = "{$directoryPath}/{$componentName}.jsx";

        // parse arguments to code
        $props = null;
        $argumentFetching = null;
        $propsToPass = null;
        $htmlArgs = null;
        if(isset($dataArguments[0])) {
            $props = "props";
            $argumentFetching = "const propsToPass = {}; \n";
            foreach (explode(',', $dataArguments[0]) as $arg) {
                $argumentFetching .= "propsToPass.$arg = rootElement.getAttribute('data-$arg');\n";
                $htmlArgs .= " data-$arg=\"\"";
            }
            $propsToPass = "{...propsToPass}";
        }
        //Define Code
        $componentCode = <<<EOD
import React from 'react';
import ReactDOM from 'react-dom/client';

export default function {$componentName}($props) {
    return "$componentName component is alive!";
}
const rootElement = document.getElementById('{$componentName}{$uniqueId}');
$argumentFetching
ReactDOM.createRoot(rootElement).render(
    <{$componentName} $propsToPass />
);
EOD;
        File::put($jsxFilePath, $componentCode);

        // Print the desired HTML to the console
        $this->info("<div id=\"{$componentName}{$uniqueId}\" $htmlArgs></div>\n@vite(\"resources/js/components/$path.jsx\")");

    }
}
