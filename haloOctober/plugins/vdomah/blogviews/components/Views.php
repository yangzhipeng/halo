<?php namespace Vdomah\BlogViews\Components;

use Cms\Classes\ComponentBase;
use Rainlab\Blog\Models\Post as BlogPost;
use Db;

class Views extends ComponentBase
{
    /**
     * @var Rainlab\Blog\Models\Post The post model used for display.
     */
    public $post;

    public function componentDetails()
    {
        return [
            'name'        => 'Post Views',
            'description' => 'Show post views'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'rainlab.blog::lang.settings.post_slug',
                'description' => 'rainlab.blog::lang.settings.post_slug_description',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
        ];
    }

    public function onRun()
    {
        $this->views = $this->page['views'] = $this->getViews();
    }

    protected function loadPost()
    {
        $slug = $this->property('slug');
        $post = BlogPost::isPublished()->where('slug', $slug)->first();

        return $post;
    }

    protected function getViews()
    {
        $out = 0;
        $post = $this->loadPost();

        $obj = Db::table('vdomah_blogviews_views')
            ->where('post_id', $post->getKey('slug'));

        if ($obj->count() > 0) {
            $out = $obj->first()->views;
        }

        return $out;
    }

}