<?php namespace Pmietlicki\ProBlogSearch;

use System\Classes\PluginBase;
use System\Classes\PluginManager;

/**
 * blogSearch Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * @var array Plugin dependencies
     */
    public $require = [ 'Radiantweb.Problog' ];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'ProBlog Search',
            'description' => 'Adds a search function to your problog',
            'author'      => 'Pascal Mietlicki',
            'icon'        => 'icon-search'
        ];
    }

    /**
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Pmietlicki\ProBlogSearch\Components\SearchForm' => 'searchForm'
        ];
    }
}
