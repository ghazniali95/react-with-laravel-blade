<?php
namespace Ghazniali95\ReactWithLaravelBlade;

use Blade;
use Ghazniali95\ReactWithLaravelBlade\Directives\ReactBlade;
use Illuminate\Support\ServiceProvider;

class ReactWithLaravelBladeServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind any interfaces to implementations
    }

    public function boot()
    {
        // Blade directive
        Blade::directive('reactComponent', function ($expression) {

            // Generate a unique ID for the component container
            $id = 'react-component-' . uniqid();

            // Extract the component name and arguments from the expression
            [$componentName, $args] = explode(',', $expression, 2);
            $componentName = trim($componentName, "\"' ");
            $argsArray = eval('return ' . trim($args) . ';');
//
//            // Start the div tag with the unique ID and data-component attribute
//            echo "<div id='{$id}' data-component='" . htmlentities($componentName) . "'";
$args = [];
//            // Add data attributes for each key-value pair in the arguments array
            foreach ($argsArray as $key => $value) {
                $args[] =  " data-" . htmlentities($key) . "='" . htmlentities($value) . "'";
            }
//
//            // Close the div tag
//            echo "></div>";

            return "<div id='".$id."' data-component='".$componentName."' ".implode(" ", $args)."></div>";
        });
    }
}
