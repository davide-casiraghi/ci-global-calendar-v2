<?php


namespace App\Generators;

use App\Models\Post;
use Spatie\SchemaOrg\BlogPosting;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\Type;

/**
 * Class PostStructuredDataScriptGenerator
 * Generate the script for Post entity.
 *
 * @package App\Generators
 */
class PostStructuredDataScriptGenerator implements StructuredDataScriptGeneratorInterface
{
    private Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Generate the script for a blog post Schema.org type.
     *
     * @return Type
     */
    public function generate(): Type
    {
        return Schema::blogPosting()
            ->name($this->post->title)
            ->headline($this->post->title)
            ->if($this->post->hasMedia('introimage'), function (BlogPosting $schema) {
                $schema->image($this->post->getMedia('introimage')->first()->getUrl());
            })
            ->about($this->post->category->name)
            ->description($this->post->intro_text)
            ->author(Schema::person()
                ->name($this->post->user->profile->full_name)
            )
            ->dateCreated($this->post->created_at)
            ->datePublished($this->post->created_at)
            ->dateModified($this->post->updated_at)
            ->mainEntityOfPage(Schema::webPage()
                ->url(env('APP_URL').'/posts/'.$this->post->slug)
            );
    }
}
