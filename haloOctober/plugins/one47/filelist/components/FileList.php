<?php namespace One47\FileList\Components;

use Cms\Classes\ComponentBase;
use One47\FileList\Models\FileList as ListModel;

class FileList extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'one47.filelist::lang.filelist.name',
            'description' => 'one47.filelist::lang.filelist.choice'
        ];
    }

    public function defineProperties()
    {
        return [
            'id' => [
            'title'        => 'one47.filelist::lang.filelist.name',
            'description'  => 'one47.filelist::lang.filelist.choice',
            'type'         => 'dropdown'
            ],
        ];
    }

    public function getidOptions()
    {
      return ListModel::select('id', 'name')->orderBy('name')->get()->lists('name', 'id');
    }

    public function onRender()
    {
      $filelist = new ListModel;
      $this -> filelist = $this -> page['filelist'] = $filelist->where('id', '=', $this -> property('id')) -> first();
    }

}