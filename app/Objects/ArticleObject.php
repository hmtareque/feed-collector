<?php

namespace App\Objects;

use DB;
use Feeds;
use Illuminate\Database\QueryException;
use App\Models\Article;
use App\Models\ArticleCollectionHistory;

/**
 * Provides all the operations of Articles
 *
 * @author Hasan Tareue
 */
class ArticleObject {

    /**
     * Collects xml news feeds and store it to database 
     * 
     * @param string $source 
     * @param string $rss_url News feeds URL 
     * @return json 
     */
    public function collect($source, $rss_url) {

        $collection = Feeds::make($rss_url);
        $feeds = $collection->get_items();

        if (!$feeds) {
            return response()->json(['status' => 0, 'msg' => 'Invaild RSS URL provided! Failed to collect articles.']);
        }

        DB::beginTransaction();

        try {
            $no_of_article = 0;
            $collection_history_data = array(
                'source' => $source,
                'rss_url' => $rss_url,
                'collected_at' => date('Y-m-d')
            );

            $history = ArticleCollectionHistory::create($collection_history_data);

            foreach ($feeds as $feed) {
                $article = array(
                    'collection_id' => $history->id,
                    'headline' => $feed->get_title(),
                    'url' => $feed->get_permalink(),
                    'published_at' => $feed->get_date('Y-m-d')
                );

                Article::create($article);
                $no_of_article++;
            }
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json(['status' => 0, 'msg' => $ex->getMessage()]);
        }

        DB::commit();
        return response()->json(['status' => 1, 'no_of_article' => $no_of_article]);
    }

    /**
     * Returns the selected articles which id is provided by array 
     * 
     * @param array $articles
     * @return collection object 
     */
    public function selected(Array $articles) {

        $info = array('articles.id as id', 'article_collection_histories.source as source', 'articles.headline', 'articles.url', 'articles.actioned', 'article_collection_histories.id as collection_id', 'article_collection_histories.collected_at as collected_at', 'articles.published_at');
        return Article::join('article_collection_histories', 'article_collection_histories.id', 'articles.collection_id')
                        ->whereIn('articles.id', $articles)
                        ->get($info);
    }

    /**
     * Returns articles marked or unmarked action
     * 
     * @param boolean $actioned
     * @return collection object 
     */
    public function marked($actioned) {

        $info = array(
            'articles.id as id', 'article_collection_histories.source as source', 'articles.headline',
            'articles.url', 'articles.actioned', 'article_collection_histories.id as collection_id',
            'article_collection_histories.collected_at as collected_at', 'articles.published_at',
            'articles.updated_at'
        );

        return Article::join('article_collection_histories', 'article_collection_histories.id', 'articles.collection_id')
                        ->where('actioned', $actioned)
                        ->get($info);
    }

    /**
     * Mark or Unmark list of articles actioned
     * 
     * @param array $articles
     * @param boolean $actioned
     * @return json 
     */
    public function markArticles(Array $articles, $actioned) {


        $no_of_article = count($articles);

        if ($no_of_article <= 0) {
            return response()->json(['status' => 0, 'msg' => 'Empty array supplied.']);
        }

        DB::beginTransaction();

        try {
            $update_data = array('actioned' => $actioned, 'updated_at' => date('Y-m-d H:i:s'));
            Article::whereIn('id', $articles)->update($update_data);
        } catch (QueryException $ex) {
            DB::rollBack();
            return response()->json(['status' => 0, 'msg' => $ex->getMessage()]);
        }

        DB::commit();
        return response()->json(['status' => 1, 'no_of_article' => $no_of_article]);
    }

    /**
     * Determines articles already collected from a specified rss or not 
     * 
     * @param type $rss_url
     * @param type $collected_at
     * @return boolean 
     */
    public function alreadyCollected($rss_url, $collected_at) {
        $collected = ArticleCollectionHistory::where('rss_url', $rss_url)
                ->where('collected_at', $collected_at)
                ->count();
        return ($collected > 0) ? true : false;
    }

    /**
     * Provides collection of articles history 
     * 
     * @param date or false $collected_at
     * @return collection object 
     */
    public function collections($collected_at = false) {

        if ($collected_at) {
            $collections = ArticleCollectionHistory::where('collected_at', $collected_at)
                    ->orderBy('collected_at', 'desc')
                    ->get();
        } else {
            $collections = ArticleCollectionHistory::orderBy('collected_at', 'desc')
                    ->get();
        }

        if ($collections->count() > 0) {
            foreach ($collections as $collection) {
                $collection->no_of_article = Article::where('collection_id', $collection->id)->count();
                $collection->no_actioned = Article::where('collection_id', $collection->id)->where('actioned', 1)->count();
                $collection->no_not_actioned = Article::where('collection_id', $collection->id)->where('actioned', 0)->count();
            }
        }

        return $collections;
    }

    /**
     * Provides articles of a specified collection source 
     * 
     * @param int $collection_id
     * @return collection object 
     */
    public function articleCollection($collection_id) {

        $info = array(
            'articles.id as id', 'article_collection_histories.source as source', 'articles.headline',
            'articles.url', 'articles.actioned', 'article_collection_histories.id as collection_id',
            'article_collection_histories.collected_at as collected_at', 'articles.published_at',
            'articles.actioned', 'articles.updated_at'
        );

        return Article::join('article_collection_histories', 'article_collection_histories.id', 'articles.collection_id')
                        ->where('collection_id', $collection_id)
                        ->get($info);
    }

    /**
     * Delete a list of articles 
     * 
     * @param array $articles
     * @return json 
     */
    public function delete(Array $articles) {

        $no_of_article = count($articles);

        if ($no_of_article <= 0) {
            return response()->json(['status' => 0, 'msg' => 'Empty array supplied.']);
        }

        DB::beginTransaction();

        try {
            Article::whereIn('id', $articles)->delete();
        } catch (QueryException $ex) {
            DB::rollBack();
            return response()->json(['status' => 0, 'msg' => $ex->getMessage()]);
        }

        DB::commit();
        return response()->json(['status' => 1, 'no_of_article' => $no_of_article]);
    }

}
