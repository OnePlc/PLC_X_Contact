<?php
/**
 * Contact.php - Contact Entity
 *
 * Entity Model for Contact
 *
 * @category Model
 * @package Contact
 * @author Verein onePlace
 * @copyright (C) 2020 Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Contact\Model;

class ChildContact extends Contact
{
    protected $is_company;

    /**
     * Contact constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @since 1.0.0
     */
    public function __construct($oDbAdapter) {
        parent::__construct($oDbAdapter);
    }

    /**
     * Set Entity Data based on Data given
     *
     * @param array $aData
     * @since 1.0.0
     */
    public function exchangeArray(array $aData) {
        $this->id = !empty($aData['Contact_ID']) ? $aData['Contact_ID'] : 0;
        $this->is_company = !empty($aData['is_company']) ? $aData['is_company'] : 0;
        $this->updateDynamicFields($aData);
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLabel()
    {
        $sLabel = $this->firstname;
        if($this->lastname != '') {
            $sLabel .= ' '.$this->lastname;
        }
        return $sLabel;
    }
}
