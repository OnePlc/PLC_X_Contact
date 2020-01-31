<?php
/**
 * ExportController.php - Contact Export Controller
 *
 * Main Controller for Contact Export
 *
 * @category Controller
 * @package Contact
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.5
 */

namespace OnePlace\Contact\Controller;

use Application\Controller\CoreController;
use Application\Controller\CoreExportController;
use OnePlace\Contact\Model\ContactTable;
use Laminas\Db\Sql\Where;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\View\Model\ViewModel;


class ExportController extends CoreExportController
{
    /**
     * ApiController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param ContactTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter,ContactTable $oTableGateway,$oServiceManager) {
        parent::__construct($oDbAdapter,$oTableGateway,$oServiceManager);
    }


    /**
     * Dump Contacts to excel file
     *
     * @return ViewModel
     * @since 1.0.5
     */
    public function dumpAction() {
        $this->layout('layout/json');

        # Use Default export function
        $aViewData = $this->exportContactBasedData('Contacts','contact');

        # return data to view (popup)
        return new ViewModel($aViewData);
    }
}