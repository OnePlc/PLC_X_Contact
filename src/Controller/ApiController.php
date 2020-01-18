<?php
/**
 * ApiController.php - Contact Api Controller
 *
 * Main Controller for Contact Api
 *
 * @category Controller
 * @package Application
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace OnePlace\Contact\Controller;

use Application\Controller\CoreController;
use OnePlace\Contact\Model\ContactTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;

class ApiController extends CoreController {
    /**
     * Contact Table Object
     *
     * @since 1.0.0
     */
    private $oTableGateway;

    /**
     * ApiController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param ContactTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter,ContactTable $oTableGateway) {
        parent::__construct($oDbAdapter);
        $this->oTableGateway = $oTableGateway;
        $this->sSingleForm = 'contact-single';
    }

    /**
     * API Home - Main Index
     *
     * @return bool - no View File
     * @since 1.0.0
     */
    public function indexAction() {
        $this->layout('layout/json');

        $aReturn = ['state'=>'success','message'=>'Welcome to onePlace Contact API'];
        echo json_encode($aReturn);

        return false;
    }

    /**
     * List all Entities of Contacts
     *
     * @return bool - no View File
     * @since 1.0.0
     */
    public function listAction() {
        $this->layout('layout/json');

        /**
         * todo: enforce to use /api/contact instead of /contact/api so we can do security checks in main api controller
        if(!\Application\Controller\ApiController::$bSecurityCheckPassed) {
            # Print List with all Entities
            $aReturn = ['state'=>'error','message'=>'no direct access allowed','aItems'=>[]];
            echo json_encode($aReturn);
            return false;
        }
        **/

        $aItems = [];

        # Get All Contact Entities from Database
        $oItemsDB = $this->oTableGateway->fetchAll(false);
        if(count($oItemsDB) > 0) {
            foreach($oItemsDB as $oItem) {
                $aItems[] = $oItem;
            }
        }

        # Print List with all Entities
        $aReturn = ['state'=>'success','message'=>'List all Contacts','aItems'=>$aItems];
        echo json_encode($aReturn);

        return false;
    }

    /**
     * Get a single Entity of Contact
     *
     * @return bool - no View File
     * @since 1.0.0
     */
    public function getAction() {
        $this->layout('layout/json');

        # Get Contact ID from route
        $iItemID = $this->params()->fromRoute('id', 0);

        # Try to get Contact
        try {
            $oItem = $this->oTableGateway->getSingle($iItemID);
        } catch (\RuntimeException $e) {
            # Display error message
            $aReturn = ['state'=>'error','message'=>'Contact not found','oItem'=>[]];
            echo json_encode($aReturn);
            return false;
        }

        # Print Entity
        $aReturn = ['state'=>'success','message'=>'Contact found','oItem'=>$oItem];
        echo json_encode($aReturn);

        return false;
    }
}
