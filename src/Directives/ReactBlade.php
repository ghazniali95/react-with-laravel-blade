<?php

namespace Ghazniali95\ReactWithLaravelBlade\Directives;

class ReactBlade
{
    /**
     * Generate a unique placeholder for a React component.
     *
     * @param string $componentName The name of the React component.
     * @return string The HTML placeholder.
     */
    public static function placeholder($expression)
    {
        // Start output buffering
        ob_start();

        // Generate a unique ID for the component container
        $id = 'react-component-' . uniqid();
dd($expression);
        // Extract the component name and arguments from the expression
        dd(explode(',', $expression, 2));
        $componentName = trim($componentName, "\"' ");
        $argsArray = json_decode(trim($args), true) ?? [];

        // Start the div tag with the unique ID and data-component attribute
        echo "<div id='{$id}' data-component='" . htmlentities($componentName) . "'";

        // Add data attributes for each key-value pair in the arguments array
        foreach ($argsArray as $key => $value) {
            echo " data-" . htmlentities($key) . "='" . htmlentities($value) . "'";
        }

        // Close the div tag
        echo "></div>";

        // Get the contents of the output buffer and clean it
        $html = ob_get_clean();

        // Return the generated HTML
        return $html;
    }
}
