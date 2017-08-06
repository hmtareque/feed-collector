<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\StoreKnownArticleRequest;
use App\Http\Requests\ArticleActionRequest;
use App\Http\Requests\ArticleConfirmActionRequest;
use App\Objects\ArticleObject;

class ArticleController extends Controller {

    private $article;

    public function __construct(ArticleObject $article) {
        $this->article = $article;
    }

    /**
     * Display a listing of today's article collection history.
     *
     * @return html 
     */
    public function home() {
        $today = date('Y-m-d');
        $collections = $this->article->collections($today);
        return view('articles.home', array('collections' => $collections));
    }

    /**
     * Displays collection options and form for articles
     * 
     * @return html
     */
    public function collect() {
        return view('articles.collect');
    }

    /**
     * Store collected articles in storage.
     * 
     * @param StoreArticleRequest $request
     * @return redirect 
     */
    public function store(StoreArticleRequest $request) {

        $url = $request->get('rss_url');
        // removed the last forwardslash (/) to keep url identical
        $rss_url = preg_replace('{/$}', '', $url);
        $source = $request->get('source');
        $collected_at = date('Y-m-d');

        $already_collected = $this->article->alreadyCollected($rss_url, $collected_at);

        if ($already_collected) {
            return redirect('articles/not-actioned')->with('error', 'Today\'s articles of ' . $source . ' already collected.');
        }

        $collect = $this->article->collect($source, $rss_url);

        if ($collect) {
            $response = json_decode($collect->getContent());

            if ($response->status == 1) {
                return redirect('articles/not-actioned')->with('success', 'Successfully collected ' . $response->no_of_article . ' articles from ' . $source . '.');
            }

            if ($response->status == 0) {
                return redirect('articles/not-actioned')->with('error', $response->msg);
            }
        }

        return redirect('articles/not-actioned')->with('error', 'Failed to collect articles from ' . $source . '! Please try again.');
    }

    /**
     * Store articles from known news feed in storage.
     * 
     * @param StoreKnownArticleRequest $request
     * @return redirect 
     */
    public function storeKnownArticle(StoreKnownArticleRequest $request) {


        $url = $request->get('known_rss_url');
        // removed the last forwardslash (/) to keep url identical
        $rss_url = preg_replace('{/$}', '', $url);
        $source = $request->get('known_source');
        $collected_at = date('Y-m-d');

        $already_collected = $this->article->alreadyCollected($rss_url, $collected_at);

        if ($already_collected) {
            return redirect('articles/not-actioned')->with('error', 'Today\'s articles of ' . $source . ' already collected.');
        }

        $collect = $this->article->collect($source, $rss_url);

        if ($collect) {
            $response = json_decode($collect->getContent());

            if ($response->status == 1) {
                return redirect('articles/not-actioned')->with('success', 'Successfully collected ' . $response->no_of_article . ' articles from ' . $source . '.');
            }

            if ($response->status == 0) {
                return redirect('articles/not-actioned')->with('error', $response->msg);
            }
        }

        return redirect('articles/not-actioned')->with('error', 'Failed to collect articles from ' . $source . '! Please try again.');
    }

    /**
     * Display the list of articles marked as "Actioned".
     * Also provides the form to unmark the articles as "Actioned" 
     * or Delete the articles 
     *
     * @return html 
     */
    public function actioned() {
        $articles = $this->article->marked(1);
        return view('articles.actioned', array('articles' => $articles));
    }

    /**
     * Display the list of articles unmarked as "Actioned".
     * Also provides the form to mark the articles as "Actioned" 
     * or Delete the articles 
     *
     * @return html 
     */
    public function notActioned() {
        $articles = $this->article->marked(0);
        return view('articles.not-actioned', array('articles' => $articles));
    }

    /**
     * Display list of articles to provide action confirmation 
     * 
     * @param ArticleConfirmActionRequest $request
     * @return html or redirect 
     */
    public function confirm(ArticleConfirmActionRequest $request) {




        $action_type = $request->get('action');
        $select_articles = $request->get('articles');

        $articles = $this->article->selected($select_articles);



        if ($action_type == 'mark') {
            return view('articles.mark-actioned', array('articles' => $articles));
        } elseif ($action_type == 'unmark') {
            return view('articles.unmark-actioned', array('articles' => $articles));
        } elseif ($action_type == 'delete') {
            return view('articles.delete', array('articles' => $articles));
        }

        return redirect()->back()->with('error', 'Failed to confirm the action! Please try again.');
    }

    /**
     * Mark articles as "Actioned"
     * 
     * @param ArticleActionRequest $request
     * @return redirect 
     */
    public function markActioned(ArticleActionRequest $request) {

        $mark = $this->article->markArticles($request->get('articles'), 1);
        if ($mark) {
            $response = json_decode($mark->getContent());
            if ($response->status == 1) {
                return redirect('articles/not-actioned')->with('success', 'Successfully marked ' . $response->no_of_article . ' article(s) actioned.');
            }

            if ($response->status == 0) {
                return redirect('articles/not-actioned')->with('error', $response->msg);
            }
        }

        return redirect('articles/not-actioned')->with('error', 'Failed to mark article(s) actioned! Please try again.');
    }

    /**
     * Unmark articles as "Actioned"
     * 
     * @param ArticleActionRequest $request
     * @return redirect 
     */
    public function unmarkActioned(ArticleActionRequest $request) {

        $articles = $request->get('articles');
        $unmark = $this->article->markArticles($articles, 0);
        if ($unmark) {
            $response = json_decode($unmark->getContent());
            if ($response->status == 1) {
                return redirect('articles/actioned')->with('success', 'Successfully unmarked ' . $response->no_of_article . ' article(s) actioned.');
            }

            if ($response->status == 0) {
                return redirect('articles/actioned')->with('error', $response->msg);
            }
        }

        return redirect('articles/actioned')->with('error', 'Failed to unmark article(s) actioned! Please try again.');
    }

    /**
     * Display list of collection history 
     *
     * @return html 
     */
    public function collectionHistory() {
        $collections = $this->article->collections();
        return view('articles.history', array('collections' => $collections));
    }

    /**
     * Display list of articles of collection source 
     * 
     * @param int $collection_id
     * @return html 
     */
    public function articleCollection($collection_id) {
        $articles = $this->article->articleCollection($collection_id);
        return view('articles.collection', array('articles' => $articles));
    }

    /**
     * Remove the specified articles from storage.
     * 
     * @param ArticleActionRequest $request
     * @return redirect 
     */
    public function destroy(ArticleActionRequest $request) {

        if (!$request->has('return_path')) {
            return redirect('/')->with('error', 'Please provide return path.');
        }

        $return_path = $request->get('return_path');

        $articles = $request->get('articles');
        $delete = $this->article->delete($articles);
        if ($delete) {
            $response = json_decode($delete->getContent());
            if ($response->status == 1) {
                return redirect($return_path)->with('success', $response->no_of_article . ' article(s) successfully deleted.');
            }

            if ($response->status == 0) {
                return redirect($return_path)->with('error', $response->msg);
            }
        }

        return redirect($return_path)->with('error', 'Failed to delete article(s)! Please try again.');
    }

}
