<?php
namespace OFFLINE\SiteSearch\Classes\Providers;

use Illuminate\Database\Eloquent\Collection;
use OFFLINE\SiteSearch\Classes\Result;
use OFFLINE\SiteSearch\Models\Settings;
use RainLab\Pages\Classes\Page;

/**
 * Searches the contents generated by the
 * Rainlab.Pages plugin
 *
 * @package OFFLINE\SiteSearch\Classes\Providers
 */
class RainlabPagesResultsProvider extends ResultsProvider
{
    /**
     * Runs the search for this provider.
     *
     * @return ResultsProvider
     */
    public function search()
    {
        if ( ! $this->isInstalledAndEnabled()) {
            return $this;
        }

        foreach ($this->pages() as $page) {
            // Make this result more relevant, if the query is found in the title
            $relevance = $this->containsQuery($page->viewBag['title']) ? 1 : 1;

            $result        = new Result($this->query, $relevance);
            $result->title = $page->viewBag['title'];
            $result->text  = $page->parsedMarkup;
            $result->url   = $this->getUrl($page);

            $this->addResult($result);
        }

        return $this;
    }

    /**
     * Get all pages with matching title or content.
     *
     * @return Collection
     */
    protected function pages()
    {

        $pages = Page::all()->filter(function ($page) {
            return $this->containsQuery($page->parsedMarkup)
            || $this->viewBagContainsQuery($page->viewBag);
        });

        return $pages;
    }

    /**
     * Checks if the RainLab.Pages Plugin is installed and
     * enabled in the config.
     *
     * @return bool
     */
    protected function isInstalledAndEnabled()
    {
        return $this->isPluginAvailable($this->identifier)
        && Settings::get('rainlab_pages_enabled', true);
    }

    /**
     * Checks if $subject contains the query string.
     *
     * @param $subject
     *
     * @return bool
     */
    protected function containsQuery($subject)
    {
        return is_array($subject)
            ? $this->arrayContainsQuery($subject)
            : mb_strpos(mb_strtolower($subject), mb_strtolower($this->query)) !== false;
    }

    /**
     * Checks if a viewBag contains the query string.
     *
     * @param $viewBag
     *
     * @return bool
     */
    protected function viewBagContainsQuery($viewBag)
    {
        $ignoreViewBagKeys = [
            'title',
            'url',
            'layout',
            'is_hidden',
            'navigation_hidden',
        ];

        $properties = collect($viewBag)->except($ignoreViewBagKeys)->toArray();
        foreach ($properties as $property) {
            if ($this->containsQuery($property)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if an array contains the query string.
     *
     * @param $array
     *
     * @return bool
     */
    protected function arrayContainsQuery(array $array)
    {
        foreach ($array as $value) {
            if ($this->containsQuery($value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Display name for this provider.
     *
     * @return string
     */
    public function displayName()
    {
        return Settings::get('rainlab_pages_label', 'Page');
    }

    /**
     * Get the page's (translated) url.
     *
     * @param $page
     *
     * @return string
     */
    protected function getUrl($page)
    {
        $langPrefix = $this->translator ? $this->translator->getLocale() : '';

        return $langPrefix . $page->viewBag['url'];
    }

    /**
     * Returns the plugin's identifier string.
     *
     * @return string
     */
    public function identifier()
    {
        return 'RainLab.Pages';
    }
}
