<?php


namespace App\Traits;

use \App\Generators\StructuredDataScriptGeneratorInterface;

/**
 * Trait HasStructuredData to implement a builder for all Schema.org types
 * and their properties using the spatie/schema-org package.
 *
 * @see https://schema.org
 * @see https://github.com/spatie/schema-org
 *
 * @package App\Traits
 */
trait HasStructuredData
{

    /**
     * Get the specific structured data script generator.
     *
     * @return StructuredDataScriptGeneratorInterface
     */
    protected abstract function getStructuredDataScriptGenerator() : StructuredDataScriptGeneratorInterface;

    /**
     * Render a json-ld script tag for the entity that implements this trait.
     *
     * @return string
     */
    public function toJsonLdScript() : string
    {
        return $this->getStructuredDataScriptGenerator()
                    ->generate()
                    ->toScript();
    }

    /**
     * Return an array for the entity that implements this trait.
     *
     * @return array
     */
    public function toStructuredDataArray() : array
    {
        return $this->getStructuredDataScriptGenerator()
            ->generate()
            ->toArray();
    }

    /**
     * Return a json for the entity that implements this trait.
     *
     * @return array
     */
    public function toStructuredDataJson() : string
    {
        return json_encode($this->getStructuredDataScriptGenerator()->generate());
    }
}
