<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    /**
     * Display the Articles Page for authors.
     *
     * @return View The view for managing articles
     */
    public function showArticlesPage(): View
    {
        $title = __("pages.articles.name"); // Localized title for the articles page

        // Modal configuration for creating a new article
        $modalTitle = "modals.article.actions.new";
        $modalContent = [
            "name" => 'default.author.article-modal',
            "parameters" => [],
        ];

        // Include TinyMCE editor in this view
        $containsTinyMce = true;

        // Return the articles view with modal and editor
        return view('pages.author.articles', compact('title', 'modalTitle', 'modalContent', 'containsTinyMce'));
    }

    /**
     * Display the Trends Page for authors.
     *
     * @return View The view for managing trends
     */
    public function showTrendsPage(): View
    {
        $title = __("pages.trends.name"); // Localized title for the trends page

        // Modal configuration for adding a new trend
        $modalTitle = "modals.trend.actions.add";
        $modalContent = [
            "name" => 'default.author.trend-modal',
            "parameters" => [],
        ];

        // Include TinyMCE editor in this view
        $containsTinyMce = true;

        // Return the trends view with modal and editor
        return view('pages.author.trends', compact('title', 'modalTitle', 'modalContent', 'containsTinyMce'));
    }
}
