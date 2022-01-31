<?php

namespace App\Helpers;

/*
 * How to use one of this helper functions:
 *
 * In a blade template:
 * {!! Helper::cleanStringSpaces('this is how to use') !!}
 *
 * Anywhere else in your Laravel app:
 * Helper::cleanStringSpaces('this is how to use');
 *
 * https://stackoverflow.com/questions/28290332/best-practices-for-custom-helpers-in-laravel-5#32772686
 */

use Illuminate\Support\Collection;

class Helper
{

    /**
     * Removes from a string all whitespace (including tabs and line ends),
     *
     * @param string|null $text
     *
     * @return string|string[]|null
     */
    public static function cleanStringSpaces(?string $text): ?string
    {
        return  preg_replace('/\s+/', '', $text);
    }


    /**
     * Return a phone number without parenthesis, hyphen and spaces, characters.
     * The regex removes everything except digits and + sign.
     *
     * @param string $phoneNumber
     *
     * @return string|null
     */
    public static function cleanPhoneNumber(string $phoneNumber): ?string
    {
        if (!empty($phoneNumber)) {
            $phoneNumber = preg_replace("/[^0-9+]/", "", $phoneNumber);
        }

        if ($phoneNumber != '') {
            return $phoneNumber;
        }

        return null;
    }

    /**
     * Return the phone number without the international prefix.
     *
     * @param string $phoneNumber
     *
     * @return string
     */
    public static function removePhonePrefix(string $phoneNumber): string
    {
        // All the international phone number prefixes
        $regex = '/\+(?:998|996|995|994|993|992|977|976|975|974|973|972|971|970|968|967|966|965|964|963|962|961|960|886|880|856|855|853|852|850|692|691|690|689|688|687|686|685|683|682|681|680|679|678|677|676|675|674|673|672|670|599|598|597|595|593|592|591|590|509|508|507|506|505|504|503|502|501|500|423|421|420|389|387|386|385|383|382|381|380|379|378|377|376|375|374|373|372|371|370|359|358|357|356|355|354|353|352|351|350|299|298|297|291|290|269|268|267|266|265|264|263|262|261|260|258|257|256|255|254|253|252|251|250|249|248|246|245|244|243|242|241|240|239|238|237|236|235|234|233|232|231|230|229|228|227|226|225|224|223|222|221|220|218|216|213|212|211|98|95|94|93|92|91|90|86|84|82|81|66|65|64|63|62|61|60|58|57|56|55|54|53|52|51|49|48|47|46|45|44\D?1624|44\D?1534|44\D?1481|44|43|41|40|39|36|34|33|32|31|30|27|20|7|1\D?939|1\D?876|1\D?869|1\D?868|1\D?849|1\D?829|1\D?809|1\D?787|1\D?784|1\D?767|1\D?758|1\D?721|1\D?684|1\D?671|1\D?670|1\D?664|1\D?649|1\D?473|1\D?441|1\D?345|1\D?340|1\D?284|1\D?268|1\D?264|1\D?246|1\D?242|1)\D?/';

        $phoneNoPrefix = preg_replace($regex, '', $phoneNumber);

        // If the number then start with 0, remove it.
        return ltrim($phoneNoPrefix, '0');
    }

    /**
     * Remove all special characters from a string - Remove all special characters from a string.
     *
     * @param  string  $text
     * @return string $ret
     */
    public static function cleanString(string $text): string
    {
        // Transform whitespaces to %20 for the URL
        $text = str_replace(' ', '%20', $text);
        $text = str_replace('ß', '%DF', $text);

        $utf8 = [
            '/[áàâãªä]/u'   =>   'a',
            '/[ÁÀÂÃÄ]/u'    =>   'A',
            '/[ÍÌÎÏİ]/u'     =>   'I',
            '/[íìîïı]/u'     =>   'i',
            '/[éèêëěė]/u'     =>   'e',
            '/[ÉÈÊË]/u'     =>   'E',
            '/[óòôõºöø]/u'   =>   'o',
            '/[ÓÒÔÕÖ]/u'    =>   'O',
            '/[úùûüüū]/u'     =>   'u',
            '/[ÚÙÛÜ]/u'     =>   'U',
            '/[çć]/u'       =>   'c',
            '/Ç/'           =>   'C',
            '/ğ/'           =>   'g',
            '/ñ/'           =>   'n',
            '/Ñ/'           =>   'N',
            '/ř/'           =>   'r',
            '/[šş]/u'       =>   's',
            '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
            '/[“”«»„]/u'    =>   ' ', // Double quote
            '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
        ];
        $ret = preg_replace(array_keys($utf8), array_values($utf8), $text);

        return $ret;
    }

    /**
     * Return a string with the list of the collection id separated by comma.
     * without any space. eg. "354,320,310".
     *
     * @param  iterable $items
     * @return string $ret
     */
    public static function getCollectionIdsSeparatedByComma(iterable $items): string
    {
        $itemsIds = [];
        foreach ($items as $item) {
            array_push($itemsIds, $item->id);
        }
        $ret = implode(',', $itemsIds);

        return $ret;
    }

    /**
     * It returns a string that is composed by the array values separated by a comma.
     *
     * @param  iterable  $items
     * @return string  $ret
     */
    public static function getStringFromArraySeparatedByComma(iterable $items): string
    {
        $ret = '';
        $i = 0;
        $len = count($items); // to put "," to all items except the last

        foreach ($items as $key => $item) {
            $ret .= $item;
            if ($i != $len - 1) {  // not last
                $ret .= ', ';
            }
            $i++;
        }

        return $ret;
    }

    /**
     * Returns a random value from the input array with weighting.
     *
     * Pass in an associative array, such as array('A'=>5, 'B'=>45, 'C'=>50)
     * An array like this means that "A" has a 5% chance of being selected, "B"
     * 45%, and "C" 50%.
     *
     * The return value is the array key, A, B, or C in this case.  Note that
     * the values assigned do not have to be percentages.  The values are
     * simply relative to each other.  If one value weight was 2, and the other
     * weight of 1, the value with the weight of 2 has about a 66% chance of
     * being selected.  Also note that weights should be integers.
     *
     * @param array $weightedValues
     *
     * @return int|string
     */
    public static function getRandomWeightedElement(array $weightedValues)
    {
        $rand = mt_rand(1, (int) array_sum($weightedValues));

        foreach ($weightedValues as $key => $value) {
            $rand -= $value;
            if ($rand <= 0) {
                return $key;
            }
        }
    }


    /**
     * Return an array with the search parameters.
     * if the parameter is null, so in the request is not set,
     * it adds anyway to the array it with a null value to avoid a not found error.
     *
     * @param object $request
     * @param array $parameterNames
     *
     * @return array
     */
    public static function getSearchParameters(object $request, array $parameterNames): array
    {
        $searchParameters = [];
        foreach ($parameterNames as $parameterName) {
            $searchParameters[$parameterName] = $request->$parameterName ?? null;
        }

        return $searchParameters;
    }

    /**
     *  Turn array of the matches after preg_match_all function.
     *  https://secure.php.net/manual/en/function.preg-match-all.php
     *
     * @param array $m
     * @return array $ret
     */
    public static function turnArray(array $m): array
    {
        $ret = [];

        for ($z = 0; $z < count($m); $z++) {
            for ($x = 0; $x < count($m[$z]); $x++) {
                $ret[$x][$z] = $m[$z][$x];
            }
        }
        return $ret;
    }


    /**
     * Return a collection of objects from a given array.
     *
     * This method is used to get a collection to pass to the blade partial
     * resources/views/partials/forms/select.blade.php
     * that accept a collection of object as record attribute.
     *
     * @param  array  $items
     * @return Collection $ret
     */
    public static function getObjectsCollection(array $items): Collection
    {
        $array = [];
        foreach ($items as $key => $item){
            $array[] = (object)['id' => $key, 'name' => $item];
        }
        return collect($array);
    }

    /**
     * Return a collection of objects from a given array.
     * The value of the items have to be language strings.
     *
     * This method is used to get a collection to pass to the blade partial
     * resources/views/partials/forms/select.blade.php
     * that accept a collection of object as record attribute.
     *
     * @param  array  $items
     * @return Collection $ret
     */
    public static function getObjectsCollectionTranslated(array $items): Collection
    {
        $array = [];
        foreach ($items as $key => $item){
            $array[] = (object)['id' => $key, 'name' => __($item)];
        }
        return collect($array);
    }

}
