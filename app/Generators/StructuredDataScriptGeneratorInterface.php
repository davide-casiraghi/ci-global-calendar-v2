<?php


namespace App\Generators;

use Spatie\SchemaOrg\Type;

/**
 * Interface StructuredDataScriptGeneratorInterface
 * Implementations generate the script for specific entity.
 *
 * @see https://schema.org
 * @see https://github.com/spatie/schema-org
 *
 * @package App\Generators
 */
interface StructuredDataScriptGeneratorInterface
{
    /**
     * Generate the script for a specific Schema.org type.
     *
     * @return Type
     */
    public function generate(): Type;
}
