<?php
/**
 * ArticleTable.php - Article Table
 *
 * Table Model for Article
 *
 * @category Model
 * @package Article
 * @author Verein onePlace
 * @copyright (C) 2020 Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Article\Model;

use Application\Controller\CoreController;
use Application\Model\CoreEntityTable;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Where;
use Laminas\Paginator\Paginator;
use Laminas\Paginator\Adapter\DbSelect;

class ArticleTable extends CoreEntityTable {

    /**
     * ArticleTable constructor.
     *
     * @param TableGateway $tableGateway
     * @since 1.0.0
     */
    public function __construct(TableGateway $tableGateway) {
        parent::__construct($tableGateway);

        # Set Single Form Name
        $this->sSingleForm = 'article-single';
    }

    /**
     * Get Article Entity
     *
     * @param int $id
     * @return mixed
     * @since 1.0.0
     */
    public function getSingle($id) {
        # Use core function
        return $this->getSingleEntity($id,'Article_ID');
    }

    /**
     * Save Article Entity
     *
     * @param Article $oArticle
     * @return int Article ID
     * @since 1.0.0
     */
    public function saveSingle(Article $oArticle) {
        $aData = [
            'label' => $oArticle->label,
        ];

        $aData = $this->attachDynamicFields($aData,$oArticle);

        $id = (int) $oArticle->id;

        if ($id === 0) {
            # Add Metadata
            $aData['created_by'] = CoreController::$oSession->oUser->getID();
            $aData['created_date'] = date('Y-m-d H:i:s',time());
            $aData['modified_by'] = CoreController::$oSession->oUser->getID();
            $aData['modified_date'] = date('Y-m-d H:i:s',time());

            # Insert Article
            $this->oTableGateway->insert($aData);

            # Return ID
            return $this->oTableGateway->lastInsertValue;
        }

        # Check if Article Entity already exists
        try {
            $this->getSingle($id);
        } catch (\RuntimeException $e) {
            throw new \RuntimeException(sprintf(
                'Cannot update article with identifier %d; does not exist',
                $id
            ));
        }

        # Update Metadata
        $aData['modified_by'] = CoreController::$oSession->oUser->getID();
        $aData['modified_date'] = date('Y-m-d H:i:s',time());

        # Update Article
        $this->oTableGateway->update($aData, ['Article_ID' => $id]);

        return $id;
    }

    /**
     * Generate new single Entity
     *
     * @return Article
     * @since 1.0.7
     */
    public function generateNew() {
        return new Article($this->oTableGateway->getAdapter());
    }
}