<?php
namespace Lavender\View\Services;

use Lavender\View\Facades\Layout;

class LayoutInjector
{
    /**
     * Inject views into layouts
     *
     * @param array $sections
     */
    public function inject(array $sections)
    {
        foreach($sections as $sectionName => $children){

            // Sort $children by 'position'
            sort_children($children);

            // Inject $children backwards so they render in the correct order
            $children = array_reverse($children);

            foreach($children as $childName => $childConfig){

                //todo prevent render by $childName

                if($html = $this->renderByType($childConfig)){

                    \View::inject(
                        $sectionName,
                        $childConfig['mode'] == Layout::REPLACE ?
                            $html : '@parent' . PHP_EOL . $html
                    );
                }
            }
        }
    }

    /**
     * Render the layout html by type (see View/config/defaults.php)
     * @param $config
     * @return bool
     */
    private function renderByType($config)
    {
        if($config['script']){

            return \HTML::script($config['script']);

        } elseif($config['meta']){

            return \HTML::meta($config['meta']);

        } elseif($config['style']){

            return \HTML::style($config['style']);

        } elseif($config['workflow']){

            return app('workflow.resolver')->resolve($config['workflow']);

        } elseif(\View::exists($config['layout'])){

            $view = \View::make($config['layout']);

            return $view->render();

        } elseif($config['config']){

            return \Config::get($config['config']);

        }
        return false;
    }
}