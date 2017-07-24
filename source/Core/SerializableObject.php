<?php
/**
 * This file is part of OXID eShop Community Edition.
 *
 * OXID eShop Community Edition is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OXID eShop Community Edition is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID eShop Community Edition.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2016
 * @version   OXID eShop CE
 */

namespace OxidEsales\EshopCommunity\Core;

class SerializableObject implements \Serializable
{
    /**
     * Do not serialize these items on purpose.
     *
     * @var array
     */
    protected $skipSerialize = [];

    /**
     * Get class and parent.
     *
     * @return array
     */
    public function getUNCShopClass($class)
    {
        while ($class !== false) {
            if(\OxidEsales\Eshop\Core\NamespaceInformationProvider::classBelongsToShopUnifiedNamespace($class)){
                break;
            }
            $class = get_parent_class($class);
        }
        return $class;
    }

    /**
     * Implements \Serializable::serialize()
     *
     * @return string
     */
    public function serialize()
    {
        $objectVars = get_object_vars($this);
        $objectVars = is_array($objectVars) ? $objectVars : [];
        $data = $this->convertArray($objectVars);

        $objectData = [
            'unc_class' => $this->getUNCShopClass(get_class($this)),
            'class' => get_class($this),
            'hash' => md5(implode('_', array_keys($objectVars))),
            'objectvars' => serialize($data)];

        return serialize($objectData);
    }





    /**
     * Implements \Serializable::unserialize()
     *
     * TODO: verify hash
     *
     * @return mixed
     */
    public function unserialize($serialized)
    {
        $unserialized = unserialize($serialized);
        $objectvars = $this->extractArray($unserialized);

        foreach ($objectvars as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }

    /**
     * Get serialized object.
     *
     * @return string
     */
    static public function getSerializedObject($rawClassName, $serializedObjectData)
    {
        $className = \OxidEsales\Eshop\Core\Registry::getUtilsObject()->getClassName($rawClassName);
        $result = 'C:' . strlen($className) . ':"' . $className . '":' .
            strlen($serializedObjectData) . ':{' . $serializedObjectData . '}';
        return $result;
    }

    /**
     * Recursively serialize data.
     *
     * @param array $data
     *
     * @return array
     */
    protected function convertArray($data)
    {
        $return = [];
        foreach ($data as $key => $value) {
            if (in_array($key, $this->skipSerialize)) {
                continue;
            }
            if (is_object($value) && is_a($value, \OxidEsales\Eshop\Core\SerializableObject::class)) {
                $return[$key] = $value->serialize();
            } elseif (is_array($value)) {
                $return[$key] = $this->convertArray($value);
            } else {
                $return[$key] = serialize($value);
            }
        }
        return $return;
    }

    /**
     * Recursively extract data.
     *
     * @param array $incoming
     *
     * @return array
     */
    protected function extractArray($incoming)
    {
        $return = [];

        if (!is_array($incoming)) {
            return $return;
        }

        foreach ($incoming as $key => $value) {
            if (is_array($value)) {
                $return[$key] = $this->extractArray($value);
            } else {
                $extracted = unserialize($value);
                $return[$key] = $this->extract($extracted);
            }
        }

        return $return;
    }

    /**
     *
     *
     * @param mixed $extracted
     * @return array|mixed|null
     */
    protected function extract($extracted)
    {
        $return = null;
        if (is_array($extracted) && isset($extracted['objectvars']) && isset($extracted['unc_class'])) {
            $restoreThis = $this->getSerializedObject($extracted['unc_class'], $extracted['objectvars']);
            $return = unserialize($restoreThis);
        } elseif (is_array($extracted)) {
            $return = $this->extractArray($extracted);
        } else {
            $return = $extracted;
        }
        return $return;
    }

}