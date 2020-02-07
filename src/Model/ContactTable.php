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
     * @return mixed
     * @since 1.0.0
     */
    public function getSingle($id) {
        # Use core function
        return $this->getSingleEntity($id,'Contact_ID');
    }

    /**
     * Save Contact Entity
     *
     * @param Contact $oContact
     * @return int Contact ID
     * @since 1.0.0
     */
    public function saveSingle(Contact $oContact) {
        $aData = [
            'label' => $oContact->label,
        ];

        $aData = $this->attachDynamicFields($aData,$oContact);

        $id = (int) $oContact->id;

        if ($id === 0) {
            # Add Metadata
            $aData['created_by'] = CoreController::$oSession->oUser->getID();
            $aData['created_date'] = date('Y-m-d H:i:s',time());
            $aData['modified_by'] = CoreController::$oSession->oUser->getID();
            $aData['modified_date'] = date('Y-m-d H:i:s',time());

            # Insert Contact
            $this->oTableGateway->insert($aData);

            # Return ID
            return $this->oTableGateway->lastInsertValue;
        }

        # Check if Contact Entity already exists
        try {
            $this->getSingle($id);
        } catch (\RuntimeException $e) {
            throw new \RuntimeException(sprintf(
                'Cannot update contact with identifier %d; does not exist',
                $id
            ));
        }

        # Update Metadata
        $aData['modified_by'] = CoreController::$oSession->oUser->getID();
        $aData['modified_date'] = date('Y-m-d H:i:s',time());

        # Update Contact
        $this->oTableGateway->update($aData, ['Contact_ID' => $id]);

        return $id;
    }

    /**
     * Generate new single Entity
     *
     * @return Contact
     * @since 1.0.0
     */
    public function generateNew() {
        return new Contact($this->oTableGateway->getAdapter());
    }
}