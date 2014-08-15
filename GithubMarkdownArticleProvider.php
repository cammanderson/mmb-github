<?php
/*
 * Author; Cameron Manderson <cameronmanderson@gmail.com>
 */

namespace MMB\Github;

use MMB\ArticleProviderInterface;

class GithubMarkdownArticleProvider implements ArticleProviderInterface
{
    /**
     * @param $key
     * @param $path
     * @return \MMB\Article
     */
    public function provide($key, $path)
    {
        return new GithubArticle($key, $path);
    }
}
 