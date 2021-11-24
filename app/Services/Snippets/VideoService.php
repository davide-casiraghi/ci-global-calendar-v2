<?php

namespace App\Services\Snippets;

/*
    This class show an alignable video to place in the posts.

    Example of snippet:
    {# youtube id=[GriEX5dAH60] alignment=[right] width=[w-2/4] #}
    {# youtube id=[GriEX5dAH60] alignment=[center] width=[w-full] #}
*/

use App\Helpers\Helper;
use App\Models\Post;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class VideoService
{
    private int $count = 1;

    /**
     * Substitute accordion snippets with the related HTML
     *
     * @param string $postBody
     *
     * @return string
     */
    public function snippetsToHTML(string $postBody): string
    {
        // Find snippet occurrences
        $ptn = '/{# +youtube +(id|alignment|width)=\[(.*)\] +(id|alignment|width)=\[(.*)\] +(id|alignment|width)=\[(.*)\] +#}/';

        if (preg_match_all($ptn, $postBody, $matches)) {
            // Transform the matches array in a way that can be used
            $matches = Helper::turnArray($matches);

            foreach ($matches as $key => $singleImageMatches) {
                $parameters = $this->getParameters($singleImageMatches);

                $imageHtml = self::prepareImageHtml($parameters);

                // Replace the TOKEN found in the article with the generatd gallery HTML
                $postBody = str_replace($parameters['token'], $imageHtml, $postBody);
            }
        } else {
            $postBody = $postBody;
        }

        return $postBody;
    }

    /**
     *  Returns the plugin parameters.
     *
     * @param array $matches
     *
     * @return array $ret
     */
    public function getParameters(array $matches): array
    {
        $ret = [];
        //ray($matches);

        // Get activation string parameters (from article)
        $ret['token'] = $matches[0];

        $ret['video_id'] = $matches[2];
        $ret['alignment'] = $matches[4];
        $ret['width'] = $matches[6];

        //ray($ret);
        return $ret;
    }

    /**
     *  Returns HTML with the image, caption, zoom functionality, etc.
     *
     * @param \Spatie\MediaLibrary\MediaCollections\Models\Media|null $image
     * @param array $parameters
     *
     * @return string $ret
     */
    public function prepareImageHtml(array $parameters): string
    {
        //dd($parameters);

        $width = "w-full sm:" . $parameters['width']; // 100% width mobile, then for bigger devices the one specified
        $margin = "my-8 sm:mb-10 ";

        switch ($parameters['alignment']) {
            case 'right':
                $alignment = "float-right";
                $margin .= 'ml-0 sm:ml-3';
                $height = "h-48 ";
                break;

            case 'center':
                $alignment = "float-right";
                $width = "w-full ";
                $height = "h-96 ";
                break;

            default:
                $alignment = "float-left";
                $margin .= 'mr-0 sm:mr-3';
                $height = "h-48 ";
                break;
        }

        $imageHtml = "";
        $imageHtml .= "<div class='relative {$width} {$margin} {$alignment} {$height} overflow-hidden max-w-full'>";
            $imageHtml .= "<iframe class='absolute top-0 left-0 w-full h-full' src='https://www.youtube.com/embed/{$parameters['video_id']}' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
        $imageHtml .= "</div>";

        return $imageHtml;
    }
}

