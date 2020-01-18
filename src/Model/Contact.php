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

use Application\Model\CoreEntityModel;

class Contact extends CoreEntityModel {
    public $label;
    public $firstname;
    public $lastname;

    /**
     * Contact constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @since 1.0.0
     */
    public function __construct($oDbAdapter) {
        parent::__construct($oDbAdapter);

        # Set Single Form Name
        $this->sSingleForm = 'contact-single';

        # Attach Dynamic Fields to Entity Model
        $this->attachDynamicFields();
    }

    /**
     * Set Entity Data based on Data given
     *
     * @param array $aData
     * @since 1.0.0
     */
    public function exchangeArray(array $aData) {
        $this->id = !empty($aData['Contact_ID']) ? $aData['Contact_ID'] : 0;
        $this->label = !empty($aData['label']) ? $aData['label'] : '';
        $this->firstname = !empty($aData['firstname']) ? $aData['firstname'] : '';
        $this->lastname = !empty($aData['lastname']) ? $aData['lastname'] : '';

        $this->updateDynamicFields($aData);
    }

    /**
     * Get Entity Label as String
     *
     * @return string
     * @since 1.0.0
     */
    public function getLabel() {
        $sLabel = $this->firstname;
        if($this->lastname != '') {
            $sLabel.=' '.$this->lastname;
        }
        return $sLabel;
    }
}