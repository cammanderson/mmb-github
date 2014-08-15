<?php
/*
 * Author; Cameron Manderson <cameronmanderson@gmail.com>
 */

namespace MMB\Github;

use MMB\Article;
use MMB\Meta\AuthoredInterface;
use MMB\Meta\MetaAuthorTrait;
use MMB\Meta\MetaTimestampTrait;
use MMB\Meta\MetaVersionTrait;
use MMB\Meta\TimestampedInterface;
use MMB\Meta\VersionedInterface;

class GithubArticle extends Article implements VersionedInterface, TimestampedInterface
{
    use MetaVersionTrait, MetaTimestampTrait;
}
 