<?php namespace Vdomah\BlogViews;

use Db;
use Session;
use System\Classes\PluginBase;
use Rainlab\Blog\Components\Post as PostComponent;
use Rainlab\Blog\Models\Post as PostModel;

/**
 * BlogViews Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * @var array   Require the RainLab.Blog plugin
     */
    public $require = ['RainLab.Blog'];

    /**
     * @var string   Table to store post views count
     */
    public $table_views = 'vdomah_blogviews_views';

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Blog Views',
            'description' => 'The plugin enables blog posts views tracking and displaying popular articles.',
            'author'      => 'Art Gek',
            'icon'        => 'icon-signal'
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Vdomah\BlogViews\Components\Views' => 'views',
            'Vdomah\BlogViews\Components\Popular' => 'popularPosts',
        ];
    }

    public function boot()
    {
        PostComponent::extend(function($component) {
            if ($this->app->runningInBackend())
                return;

            if (!Session::has('postsviewed')) {
                Session::put('postsviewed', []);
            }

            $post = PostModel::where('slug', $component->getController()->getRouter()->getParameters()['slug'])->first();

            if (!is_null($post) && !in_array($post->getKey(), Session::get('postsviewed'))) {
                $this->setViews($post);

                Session::push('postsviewed', $post->getKey());
            }

            return true;
        });
    }

    public function setViews($post, $views = null)
    {
        $obj = Db::table($this->table_views)
            ->where('post_id', $post->getKey());

        if ($obj->count() > 0) {
            $row = $obj->first();
            if (!$views) {
                $views = ++$row->views;
            }
            $obj->update(['views' => $views]);
        } else {
            if (!$views) {
                $views = 1;
            }
            Db::table($this->table_views)->insert([
                'post_id' => $post->getKey(),
                'views' => $views,
            ]);
        }
    }

}
