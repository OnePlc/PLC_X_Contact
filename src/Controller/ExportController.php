<?php
/**
 * ExportController.php - Article Export Controller
 *
 * Main Controller for Article Export
 *
 * @category Controller
 * @package Article
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.5
 */

namespace OnePlace\Article\Controller;

use Application\Controller\CoreController;
use Application\Controller\CoreExportController;
use OnePlace\Article\Model\ArticleTable;
use Laminas\Db\Sql\Where;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\View\Model\ViewModel;


class ExportController extends CoreExportController
{
    /**
     * ApiController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param ArticleTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter,ArticleTable $oTableGateway,$oServiceManager) {
        parent::__construct($oDbAdapter,$oTableGateway,$oServiceManager);
    }


    /**
     * Dump Articles to excel file
     *
     * @return ViewModel
     * @since 1.0.5
     */
    public function dumpAction() {
        $this->layout('layout/json');

        # Use Default export function
        $aViewData = $this->exportArticleBasedData('Articles','article');

        # return data to view (popup)
        return new ViewModel($aViewData);
    }
}