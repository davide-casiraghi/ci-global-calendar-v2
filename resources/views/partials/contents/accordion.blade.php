{{--
    Accordion

    PARAMETERS:
        - $accordionNumber: id of the accordion in the page. To avoid misbehaviours.
        - $elements: the text to show


Include like this:

@include('partials.contents.accordion',[
                'accordionNumber' => '1',
                'elements' => [
                    [
                        'title' => 'Lorem impusm',
                        'text' => 'Lorem ipsum',
                    ],
                    [
                        'title' => 'tttt',
                        'text' => 'eeee',
                    ],
                ]
            ])


--}}

<div class="textHasAccordion accordion border-t border-solid border-gray-500 my-8">
    @foreach($elements as $element)

        <div class='slide w-full'>
            <input type='checkbox' name='panel' id='panel-{{$accordionNumber}}{{$loop->iteration}}' class='hidden'>
            <label for='panel-{{$accordionNumber}}{{$loop->iteration}}' class='relative block border-b border-solid border-gray-500 font-semibold p-4 pr-14'>
                {{$element['title']}}
            </label>
            <div class='accordion__content overflow-hidden bg-grey-lighter'>
                <div class='accordion__body p-4' id='panel{{$accordionNumber}}{{$loop->iteration}}'>{!! $element['text'] !!}</div>
            </div>
        </div>
    @endforeach
</div>