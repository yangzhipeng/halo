<?php namespace One47\FileList\Models;

use Model;

/**
 * List Model
 */
class FileList extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /**
     * @var string The database table used by the model.
     */
    public $table = 'one47_filelist_filelists';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Validation Rules
     */
    public $rules = [
      'name' => 'required|between:3,64',
    ];

    /**
     * @var array Attach Many relation
     */
    public $attachMany = [
      'files' => ['System\Models\File', 'order' => 'sort_order'],
    ];

}