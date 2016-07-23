<?php namespace One47\FileList;

use Backend;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;

/**
 * FileList Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'FileList',
            'description' => 'Upload files to display in a list.',
            'author'      => 'One47',
            'icon'        => 'icon-list-ul'
        ];
    }

    public function registerComponents()
    {
      return [
        'One47\FileList\Components\FileList' => 'filelist'
      ];
    }

    public function registerPermissions()
    {
      return [
        'one47.filelist.manage' => [
          'tab' => 'one47.filelist::lang.plugin.tab',
          'label' => 'one47.filelist::lang.plugin.manage'
        ]
      ];
    }

    public function registerSettings()
    {
      return [
        'filelists' => [
          'label'       => 'one47.filelist::lang.filelist.name',
          'url'         => Backend::url('one47/filelist/filelists'),
          'description' => 'one47.filelist::lang.plugin.description',
          'category'    => SettingsManager::CATEGORY_CMS,
          'icon'        => 'icon-list-ul',
          'permissions' => ['one47.filelist.*'],
          'order'       => 200
        ],
      ];
    }

}
