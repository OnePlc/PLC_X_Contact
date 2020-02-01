<?php
/**
 * SkeletonTable.php - Skeleton Table
 *
 * Table Model for Skeleton
 *
 * @category Model
 * @package Skeleton
 * @author Verein onePlace
 * @copyright (C) 2020 Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Skeleton\Model;

use Application\Controller\CoreController;
use Application\Model\CoreEntityTable;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Where;
use Laminas\Paginator\Paginator;
use Laminas\Paginator\Adapter\DbSelect;

class SkeletonTable extends CoreEntityTable {

    /**
     * SkeletonTable constructor.
     *
     * @param TableGateway $tableGateway
     * @since 1.0.0
     */
    public function __construct(TableGateway $tableGateway) {
        parent::__construct($tableGateway);

        # Set Single Form Name
        $this->sSingleForm = 'skeleton-single';
    }

    /**
     * Get Skeleton Entity
     *
     * @param int $id
     * @return mixed
     * @since 1.0.0
     */
    public function getSingle($id) {
        # Use core function
        return $this->getSingleEntity($id,'Skeleton_ID');
    }

    /**
     * Save Skeleton Entity
     *
     * @param Skeleton $oSkeleton
     * @return int Skeleton ID
     * @since 1.0.0
     */
    public function saveSingle(Skeleton $oSkeleton) {
        $aData = [
            'label' => $oSkeleton->label,
        ];

        $aData = $this->attachDynamicFields($aData,$oSkeleton);

        $id = (int) $oSkeleton->id;

        if ($id === 0) {
            # Add Metadata
            $aData['created_by'] = CoreController::$oSession->oUser->getID();
            $aData['created_date'] = date('Y-m-d H:i:s',time());
            $aData['modified_by'] = CoreController::$oSession->oUser->getID();
            $aData['modified_date'] = date('Y-m-d H:i:s',time());

            # Insert Skeleton
            $this->oTableGateway->insert($aData);

            # Return ID
            return $this->oTableGateway->lastInsertValue;
        }

        # Check if Skeleton Entity already exists
        try {
            $this->getSingle($id);
        } catch (\RuntimeException $e) {
            throw new \RuntimeException(sprintf(
                'Cannot update skeleton with identifier %d; does not exist',
                $id
            ));
        }

        # Update Metadata
        $aData['modified_by'] = CoreController::$oSession->oUser->getID();
        $aData['modified_date'] = date('Y-m-d H:i:s',time());

        # Update Skeleton
        $this->oTableGateway->update($aData, ['Skeleton_ID' => $id]);

        return $id;
    }

    /**
     * Generate new single Entity
     *
     * @return Skeleton
     * @since 1.0.7
     */
    public function generateNew() {
        return new Skeleton($this->oTableGateway->getAdapter());
    }
}