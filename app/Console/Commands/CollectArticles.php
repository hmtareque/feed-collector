<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Objects\ArticleObject;

/**
 * Collects news feeds as articles provided by Source and RSS URL
 * as argument 1 and 2 
 */

class CollectArticles extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'collect:articles{source}{rss_url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collect articles from rss feed';
    protected $article;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ArticleObject $article) {
        parent::__construct();
        $this->article = $article;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        // removed the last forwardslash (/) to keep url identical
        $rss_url = preg_replace('{/$}', '', $this->argument('rss_url'));
        $source = $this->argument('source');
        $collected_at = date('Y-m-d');

        $already_collected = $this->article->alreadyCollected($rss_url, $collected_at);

        if ($already_collected) {
            $this->error('Today\'s articles of ' . $source . ' already collected.');
            exit();
        }

        $collect = $this->article->collect($source, $rss_url);

        if ($collect) {
            $response = json_decode($collect->getContent());

            if ($response->status == 1) {
                $this->info('Successfully collected ' . $response->no_of_article . ' articles from ' . $source . '.');
                exit();
            }

            if ($response->status == 0) {
                $this->error($response->msg);
                exit();
            }
        }else {
            $this->error('Failed to collect articles from ' . $source . '! Please try again.');
            exit();
        }
    }
}
