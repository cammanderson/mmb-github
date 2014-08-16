<?php
/*
 * Author; Cameron Manderson <cameronmanderson@gmail.com>
 */

namespace MMB\Github;

use MMB\ArticleProviderInterface;
use MMB\AbstractDocument;

class GithubArticleProvider implements ArticleProviderInterface
{
    /**
     * @param $key
     * @param $path
     * @return \MMB\Article
     */
    public function provide($key, AbstractDocument $document)
    {
        return new GithubArticle($key, $document);
    }
}
 