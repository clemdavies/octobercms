<?php namespace Clem\Feed;

/**
 * Uses the Steam API to build components.
 */
use System\Classes\PluginBase;
use Config;

class Plugin extends PluginBase
{

    public function boot(){
        $this->componentConfig();
    }
    // registers config files for components
    private function componentConfig(){
        foreach(Config::get('clem.feed::components') as $component){
            Config::package('clem.feed.'.$component,
                    '/home/clem/Dropbox/october/plugins/clem/feed/components/'.$component.'/config',
                    'clem.feed.'.$component);
        }
    }

    public function pluginDetails()
    {
        return [
            'name'        => 'Clem\'s Feed Api Components',
            'description' => 'Creates components that uses Steam\'s API.',
            'author'      => 'Clem Davies',
            'icon'        => 'icon-cutlery'
        ];
    }
    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Clem Feed Settings',
                'description' => 'Manage Clem Feed settings.',
                'category'    => 'Plugins',
                'icon'        => 'icon-cutlery',
                'class'       => 'Clem\Feed\Models\Settings',
                'order'       => 100
            ]
        ];
    }

    public function registerComponents()
    {
        return [
            '\Clem\Feed\Components\Steam\Library' => 'feedsteamlibrary'
        ];
    }

}