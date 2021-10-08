<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

trait DebugInfoTrait
{
    /**
     * This method is called by var_dump() when dumping an object to get the properties that should be shown.
     *
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.debuginfo
     * @return array
     */
    public function __debugInfo() // phpcs:ignore Zicht.NamingConventions.Functions.MethodNaming
    {
        $duplicateKeys = [];
        $info = ['__length__' => 0];
        if ($this instanceof \Traversable) {
            foreach ($this as $key => $value) {
                $key = (string)$key;
                while (array_key_exists($key, $info)) {
                    $duplicateKeys[$key] = array_key_exists($key, $duplicateKeys) ? $duplicateKeys[$key] + 1 : 1;
                    $key = sprintf('%s__#%s__', $key, $duplicateKeys[$key]);
                }
                $info[$key] = $value;
                $info['__length__'] += 1;
            }
        }
        return $info;
    }
}
