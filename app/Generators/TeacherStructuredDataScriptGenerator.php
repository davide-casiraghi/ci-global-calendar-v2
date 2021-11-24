<?php


namespace App\Generators;

use App\Models\Teacher;
use Spatie\SchemaOrg\Person;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\Type;

/**
 * Class TeacherStructuredDataScriptGenerator
 * Generate the script for Teacher entity.
 *
 * @package App\Generators
 */
class TeacherStructuredDataScriptGenerator implements StructuredDataScriptGeneratorInterface
{
    private Teacher $teacher;

    public function __construct(Teacher $teacher)
    {
        $this->teacher = $teacher;
    }

    /**
     * Generate the script for a person Schema.org type.
     *
     * @return Type
     */
    public function generate(): Type
    {
        return Schema::person()
            ->name($this->teacher->full_name)
            ->if($this->teacher->hasMedia('profile_picture'), function (Person $schema) {
                $schema->image($this->teacher->getMedia('profile_picture')->first()->getUrl());
            })
            ->jobTitle('Teacher')
            ->url(env('APP_URL').'/teachers/'.$this->teacher->slug)
            ->sameAs([
                $this->teacher->facebook,
                $this->teacher->website
            ]);
    }
}
