<?php


namespace App\Generators;


use App\Models\Event;
use Carbon\Carbon;
use Spatie\SchemaOrg\DanceEvent;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\Type;

/**
 * Class EventStructuredDataScriptGenerator
 * Generate the script for Event entity.
 *
 * @package App\Generators
 */
class EventStructuredDataScriptGenerator implements StructuredDataScriptGeneratorInterface
{
    private Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Generate the script for an Event Schema.org type.
     *
     * @return Type
     */
    public function generate(): Type
    {
        return Schema::danceEvent()
            ->name($this->event->title)
            ->description($this->event->description)
            ->if($this->event->hasMedia('introimage'), function (DanceEvent $schema) {
                $schema->image($this->event->getMedia('introimage')->first()->getUrl());
            })
            ->if(!$this->event->hasMedia('introimage'), function (DanceEvent $schema) {
                $schema->image(asset('images/static_pages/mml_default.jpg'));
            })
            ->about($this->event->category->name)
            ->startDate(Carbon::createFromFormat('Y-m-d H:i:s',  $this->event->repetitions()->first()->start_repeat)->setTimezone('Europe/Rome')->toIso8601String())
            ->endDate(Carbon::createFromFormat('Y-m-d H:i:s',  $this->event->repetitions()->first()->end_repeat)->setTimezone('Europe/Rome')->toIso8601String())
            ->if($this->event->teachers()->count() > 0, function (\Spatie\SchemaOrg\DanceEvent $schema) {
              $schema->performer(Schema::person()
                ->name($this->event->teachers()->first()->name)
              );
            })
            ->if($this->event->organizers()->count() > 0, function (\Spatie\SchemaOrg\DanceEvent $schema) {
              $schema->organizer(Schema::person()
                ->name($this->event->organizers()->first()->name)
                ->url($this->event->organizers()->first()->website)
              );
            })
            ->location(Schema::place()
                ->name($this->event->venue->name)
                ->address(Schema::postalAddress()
                    ->streetAddress($this->event->venue->address)
                    ->addressLocality($this->event->venue->city)
                    ->addressRegion($this->event->venue->state_province)
                    ->postalCode($this->event->venue->zip_code)
                    ->addressCountry($this->event->venue->country->code)
                )
            )
            ->eventStatus(Schema::eventStatusType()::EventScheduled) // create a property for it
            ->eventAttendanceMode(Schema::eventAttendanceModeEnumeration()::MixedEventAttendanceMode) // create a property for it
            /*->offers(Schema::offer()
                    ->url('https://www.googleform...') // link to the registration form
            )*/
            ;
    }
}
