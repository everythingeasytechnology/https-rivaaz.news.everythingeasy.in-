<?php

namespace App\Jobs;

use App\Mail\NewArticlePublished;
use App\Models\Article;
use App\Models\Subscriber;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendArticleNewsletter implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 300;

    public function __construct(public int $articleId)
    {
        $this->onQueue('mail');
    }

    public function handle(): void
    {
        $article = Article::find($this->articleId);

        if (! $article) {
            return;
        }

        Subscriber::query()
            ->select(['id', 'email'])
            ->orderBy('id')
            ->chunkById(100, function ($subscribers) use ($article): void {
                foreach ($subscribers as $subscriber) {
                    try {
                        Mail::to($subscriber->email)->send(new NewArticlePublished($article));
                    } catch (Throwable $exception) {
                        Log::error('Article newsletter delivery failed.', [
                            'article_id' => $article->id,
                            'subscriber_id' => $subscriber->id,
                            'exception' => $exception->getMessage(),
                        ]);
                    }
                }
            });
    }
}
