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
     * Fetch All Contact Entities based on Filters
     *
     * @param bool $bPaginated
     * @param array $aWhere
     * @return Paginator Paginated Table Connection
     * @since 1.0.0
     */
    public function fetchAll($bPaginated = false,$aWhere = []) {
        $oSel = new Select($this->oTableGateway->getTable());

        # Build where
        $oWh = new Where();
        foreach(array_keys($aWhere) as $sWh) {
            $bIsLike = stripos($sWh,'-like');
            if($bIsLike === false) {

            } else {
                # its a like
                $oWh->like(substr($sWh,0,strlen($sWh)-strlen('-like')),$aWhere[$sWh].'%');
            }
        }
        $oSel->where($oWh);

        # Return Paginator or Raw ResultSet based on selection
        if ($bPaginated) {
            # Create result set for user entity
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Contact($this->oTableGateway->getAdapter()));

            # Create a new pagination adapter object
            $oPaginatorAdapter = new DbSelect(
            # our configured select object
                $oSel,
                # the adapter to run it against
                $this->oTableGateway->getAdapter(),
                # the result set to hydrate
                $resultSetPrototype
            );
            # Create Paginator with Adapter
            $oPaginator = new Paginator($oPaginatorAdapter);
            return $oPaginator;
        } else {
            $oResults = $this->oTableGateway->selectWith($oSel);
            return $oResults;
        }
    }

    /**
     * Get Contact Entity
     *
     * @param int $id
     * @return mixed
     * @since 1.0.0
     */
    public function getSingle($id) {
        $id = (int) $id;
        $rowset = $this->oTableGateway->select(['Contact_ID' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new \RuntimeException(sprintf(
                'Could not find contact with identifier %d',
                $id
            ));
        }

        return $row;
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
     * Generate daily stats for contact
     *
     * @since 1.0.5
     */
    public function generateDailyStats() {
        # get all contacts
        $iTotal = count($this->fetchAll(false));
        # get newly created contacts
        $iNew = count($this->fetchAll(false,['created_date-like'=>date('Y-m-d',time())]));

        # add statistics
        CoreController::$aCoreTables['core-statistic']->insert([
            'stats_key'=>'contact-daily',
            'data'=>json_encode(['new'=>$iNew,'total'=>$iTotal]),
            'date'=>date('Y-m-d H:i:s',time()),
        ]);
    }
}