<?php

namespace App\Services\Snippets;

/*
    This class show a responsive accordion with a title that open when [+] button is clicked.
    Example of snippet:
    {slider=HOW to add contents to this website? - Create account} lorem ipsum {/slider}
*/

class AccordionService
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
        $ret = $postBody;

        // If the post body contains any accordion
        if (substr_count($postBody, '{slide') > 0) {
            /*
             * If the post is not wrapped yet with 'textHasAccordion accordion', wrap it.
             (first accordion found in the page)
            */
            if (strpos($postBody, 'textHasAccordion') == false) {
                $postBody = '<div class="textHasAccordion accordion border-t border-solid border-gray-500">' . $postBody . '</div>';
            }

            $pattern = '#(?:<p>)?\{slide[r]?=([^}]+)\}(?:</p>)?(.*?)(?:<p>)?\{/slide[r]?\}(?:</p>)?#s';
            $ret = preg_replace_callback(
                $pattern,
                function ($matches) {
                    $sliderTemplate = "<div class='slide w-full'>";
                        $sliderTemplate .= "<input type='checkbox' name='panel' id='panel-".$this->count."' class='hidden'>";
                        $sliderTemplate .= "<label for='panel-".$this->count."' class='relative block border-b border-solid border-gray-500 text-purple-600 p-4'>".$matches[1]."</label>";
                        $sliderTemplate .= "<div class='accordion__content overflow-hidden bg-grey-lighter'>";
                            //$sliderTemplate .= "<h2 class='accordion__header pt-4 pl-4'>Header</h2>";
                            $sliderTemplate .= "<div class='accordion__body p-4' id='panel".$this->count."'>".$matches[2]."</div>";
                        $sliderTemplate .= "</div>";
                    $sliderTemplate .= "</div>";

                    $this->count++;

                    return $sliderTemplate;
                },
                $postBody
            );
        }
        return $ret;
    }
}





/*
 *  ACCORDION EXAMPLE
 *
 *

<div class="accordion flex flex-col items-center justify-center h-screen">
  <!--  Panel 1  -->
  <div class="w-1/2">
    <input type="checkbox" name="panel" id="panel-1" class="hidden">
    <label for="panel-1" class="relative block bg-black text-white p-4 shadow border-b border-grey">Panel 1</label>
    <div class="accordion__content overflow-hidden bg-grey-lighter">
      <h2 class="accordion__header pt-4 pl-4">Header</h2>
      <p class="accordion__body p-4" id="panel1">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto possimus at a cum saepe molestias modi illo facere ducimus voluptatibus praesentium deleniti fugiat ab error quia sit perspiciatis velit necessitatibus.Lorem ipsum dolor sit amet, consectetur
        adipisicing elit. Lorem ipsum dolor sit amet.</p>
    </div>
  </div>
  <!-- Panel 2 -->
  <div class="w-1/2">
    <input type="checkbox" name="panel" id="panel-2" class="hidden">
    <label for="panel-2" class="relative block bg-black text-white p-4 shadow border-b border-grey">Panel 2</label>
    <div class="accordion__content overflow-hidden bg-grey-lighter">
      <h2 class="accordion__header pt-4 pl-4">Header</h2>
      <p class="accordion__body p-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto possimus at a cum saepe molestias modi illo facere ducimus voluptatibus praesentium deleniti fugiat ab error quia sit perspiciatis velit necessitatibus.Lorem ipsum dolor sit amet, consectetur
        adipisicing elit. Lorem ipsum dolor sit amet.</p>
    </div>
  </div>
  <!--  Panel 3  -->
  <div class="w-1/2">
    <input type="checkbox" name="panel" id="panel-3" class="hidden">
    <label for="panel-3" class="relative block bg-black text-white p-4 shadow border-b border-grey">Panel 3</label>
    <div class="accordion__content overflow-hidden bg-grey-lighter">
      <h2 class="accordion__header pt-4 pl-4">Header</h2>
      <p class="accordion__body p-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto possimus at a cum saepe molestias modi illo facere ducimus voluptatibus praesentium deleniti fugiat ab error quia sit perspiciatis velit necessitatibus.Lorem ipsum dolor sit amet, consectetur
        adipisicing elit. Lorem ipsum dolor sit amet.</p>
    </div>
  </div>
</div>



 *
 */