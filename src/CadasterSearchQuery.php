<?php
/**
 * Created by PhpStorm.
 * User: Danil Pyatnitsev
 * Date: 16.09.2017
 * Time: 1:35
 */

namespace Jilfond\Apirosreestr;


class CadasterSearchQuery
{
    protected $cadNumber;
    protected $address;
    protected $regionCode;
    protected $raion;
    protected $settlement;
    protected $street;
    protected $house;
    protected $building;
    protected $block;
    protected $flat;
    protected $grouped;

    public function __construct()
    {
        $this->grouped = 0;
    }

    /**
     * @param mixed $cadNumber
     * @return $this
     */
    public function setCadNumber($cadNumber)
    {
        $this->cadNumber = $cadNumber;
        return $this;
    }

    /**
     * @param mixed $address
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @param mixed $regionCode
     * @return $this
     */
    public function setRegionCode($regionCode)
    {
        $this->regionCode = $regionCode;
        return $this;
    }

    /**
     * @param mixed $raion
     * @return $this
     */
    public function setRaion($raion)
    {
        $this->raion = $raion;
        return $this;
    }

    /**
     * @param mixed $settlement
     * @return $this
     */
    public function setSettlement($settlement)
    {
        $this->settlement = $settlement;
        return $this;
    }

    /**
     * @param mixed $street
     * @return $this
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @param mixed $house
     * @return $this
     */
    public function setHouse($house)
    {
        $this->house = $house;
        return $this;
    }

    /**
     * @param mixed $building
     * @return $this
     */
    public function setBuilding($building)
    {
        $this->building = $building;
        return $this;
    }

    /**
     * @param mixed $block
     * @return $this
     */
    public function setBlock($block)
    {
        $this->block = $block;
        return $this;
    }

    /**
     * @param mixed $flat
     * @return $this
     */
    public function setFlat($flat)
    {
        $this->flat = $flat;
        return $this;
    }

    /**
     * @param int $grouped
     * @return $this
     */
    public function setGrouped($grouped)
    {
        $this->grouped = $grouped;
        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getCadNumber()
    {
        return $this->cadNumber;
    }

    public function getJsonQuery()
    {
        return json_encode([
            'region_code' => $this->regionCode,
            'raion' => $this->raion,
            'settlement' => $this->settlement,
            'street' => $this->street,
            'house' => $this->house,
            'building' => $this->building,
            'block' => $this->block,
            'flat' => $this->flat,
        ]);
    }

    /**
     * @return int
     */
    public function getGrouped()
    {
        return $this->grouped;
    }
}