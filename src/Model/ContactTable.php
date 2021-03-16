<?php
/**
 * ContactTable.php - Contact Table
 *
 * Table Model for Contact
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

use Application\Controller\CoreController;
use Application\Model\CoreEntityTable;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Where;
use Laminas\Paginator\Paginator;
use Laminas\Paginator\Adapter\DbSelect;

class ContactTable extends CoreEntityTable {

    /**
     * ContactTable constructor.
     *
     * @param TableGateway $tableGateway
     * @since 1.0.0
     */
    public function __construct(TableGateway $tableGateway) {
        parent::__construct($tableGateway);

        # Set Single Form Name
        $this->sSingleForm = 'contact-single';
    }

    /**
     * Get Contact Entity
     *
     * @param int $id
     * @param string $sKey
     * @return mixed
     * @since 1.0.0
     */
    public function getSingle($id,$sKey = 'Contact_ID') {
        # Use core function
        return $this->getSingleEntity($id,$sKey);
    }

    /**
     * Save Contact Entity
     *
     * @param Contact $oContact
     * @return int Contact ID
     * @since 1.0.0
     */
    public function saveSingle(ChildContact $oContact) {
        $aDefaultData = [
            'firstname' => $oContact->getFirstname(),
            'is_company' => $oContact->isCompany(),
        ];

        return $this->saveSingleEntity($oContact,'Contact_ID',$aDefaultData);
    }

    /**
     * Generate new single Entity
     *
     * @return Contact
     * @since 1.0.0
     */
    public function generateNew() {
        return new ChildContact($this->oTableGateway->getAdapter());
    }
}