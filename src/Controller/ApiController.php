<?php
/**
 * ApiController.php - Skeleton Api Controller
 *
 * Main Controller for Skeleton Api
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

namespace OnePlace\Skeleton\Controller;

use Application\Controller\CoreController;
use OnePlace\Skeleton\Model\SkeletonTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;
use Zend\I18n\Translator\Translator;

class ApiController extends CoreController {
    /**
     * Skeleton Table Object
     *
     * @since 1.0.0
     */
    private $oTableGateway;

    /**
     * ApiController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param SkeletonTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter,SkeletonTable $oTableGateway,$oServiceManager) {
        parent::__construct($oDbAdapter,$oTableGateway,$oServiceManager);
        $this->oTableGateway = $oTableGateway;
        $this->sSingleForm = 'skeleton-single';
    }

    /**
     * API Home - Main Index
     *
     * @return bool - no View File
     * @since 1.0.0
     */
    public function indexAction() {
        $this->layout('layout/json');

        $aReturn = ['state'=>'success','message'=>'Welcome to onePlace Skeleton API'];
        echo json_encode($aReturn);

        return false;
    }

    /**
     * List all Entities of Skeletons
     *
     * @return bool - no View File
     * @since 1.0.0
     */
    public function listAction() {
        $this->layout('layout/json');

        # Check license
        if(!$this->checkLicense('skeleton')) {
            $aReturn = ['state'=>'error','message'=>'no valid license for skeleton found'];
            echo json_encode($aReturn);
            return false;
        }

        # Set default values
        $bSelect2 = true;
        $sListLabel = 'label';

        # Get list mode from query
        if(isset($_REQUEST['listmode'])) {
            if($_REQUEST['listmode'] == 'entity') {
                $bSelect2 = false;
            }
        }

        # get list label from query
        if(isset($_REQUEST['listlabel'])) {
            $sListLabel = $_REQUEST['listlabel'];
        }

        # get list label from query
        $sLang = 'en_US';
        if(isset($_REQUEST['lang'])) {
            $sLang = $_REQUEST['lang'];
        }

        // translating system
        $translator = new Translator();
        $aLangs = ['en_US','de_DE'];
        foreach($aLangs as $sLoadLang) {
            if(file_exists(__DIR__.'/../../../oneplace-translation/language/'.$sLoadLang.'.mo')) {
                $translator->addTranslationFile('gettext', __DIR__.'/../../../oneplace-translation/language/'.$sLang.'.mo', 'skeleton', $sLoadLang);
            }
        }

        $translator->setLocale($sLang);


        /**
         * todo: enforce to use /api/contact instead of /contact/api so we can do security checks in main api controller
        if(!\Application\Controller\ApiController::$bSecurityCheckPassed) {
        # Print List with all Entities
        $aReturn = ['state'=>'error','message'=>'no direct access allowed','aItems'=>[]];
        echo json_encode($aReturn);
        return false;
        }
         **/

        # Init Item List for Response
        $aItems = [];

        $aFields = $this->getFormFields('skeleton-single');
        $aFieldsByKey = [];
        # fields are sorted by tab , we need an index with all fields
        foreach($aFields as $oField) {
            $aFieldsByKey[$oField->fieldkey] = $oField;
        }

        # only allow form fields as list labels
        if(!array_key_exists($sListLabel,$aFieldsByKey)) {
            $aReturn = [
                'state'=>'error',
                'results' => [],
                'message' => 'invalid list label',
            ];

            # Print List with all Entities
            echo json_encode($aReturn);
            return false;
        }

        # Get All Skeleton Entities from Database
        $oItemsDB = $this->oTableGateway->fetchAll(false);
        if(count($oItemsDB) > 0) {
            # Loop all items
            foreach($oItemsDB as $oItem) {

                # Output depending on list mode
                if($bSelect2) {
                    $sVal = null;
                    # get value for list label field
                    switch($aFieldsByKey[$sListLabel]->type) {
                        case 'select':
                            $oTag = $oItem->getSelectField($aFieldsByKey[$sListLabel]->fieldkey);
                            if($oTag) {
                                $sVal = $oTag->getLabel();
                            }
                            break;
                        case 'text':
                        case 'date':
                        case 'textarea':
                            $sVal = $oItem->getTextField($aFieldsByKey[$sListLabel]->fieldkey);
                            break;
                        default:
                            break;
                    }
                    $aItems[] = ['id'=>$oItem->getID(),'text'=>$sVal];
                } else {
                    # Init public item
                    $aPublicItem = [];

                    # add all fields to item
                    foreach($aFields as $oField) {
                        switch($oField->type) {
                            case 'multiselect':
                                # get selected
                                $oTags = $oItem->getMultiSelectField($oField->fieldkey);
                                $aTags = [];
                                foreach($oTags as $oTag) {
                                    $aTags[] = ['id'=>$oTag->id,'label'=>$translator->translate($oTag->text,'skeleton',$sLang)];
                                }
                                $aPublicItem[$oField->fieldkey] = $aTags;
                                break;
                            case 'select':
                                # get selected
                                $oTag = $oItem->getSelectField($oField->fieldkey);
                                if($oTag) {
                                    if (property_exists($oTag, 'tag_value')) {
                                        $aPublicItem[$oField->fieldkey] = ['id' => $oTag->id, 'label' => $translator->translate($oTag->tag_value,'skeleton',$sLang)];
                                    } else {
                                        $aPublicItem[$oField->fieldkey] = ['id' => $oTag->getID(), 'label' => $translator->translate($oTag->getLabel(),'skeleton',$sLang)];
                                    }
                                }
                                break;
                            case 'text':
                            case 'date':
                            case 'textarea':
                                $aPublicItem[$oField->fieldkey] = $translator->translate($oItem->getTextField($oField->fieldkey),'skeleton',$sLang);
                                break;
                            default:
                                break;
                        }
                    }

                    # add item to list
                    $aItems[] = $aPublicItem;
                }

            }
        }

        /**
         * Build Select2 JSON Response
         */
        $aReturn = [
            'state'=>'success',
            'results' => $aItems,
            'pagination' => (object)['more'=>false],
        ];

        # Print List with all Entities
        echo json_encode($aReturn);

        return false;
    }

    /**
     * Get a single Entity of Skeleton
     *
     * @return bool - no View File
     * @since 1.0.0
     */
    public function getAction() {
        $this->layout('layout/json');

        # Check license
        if(!$this->checkLicense('skeleton')) {
            $aReturn = ['state'=>'error','message'=>'no valid license for skeleton found'];
            echo json_encode($aReturn);
            return false;
        }

        # Get Skeleton ID from route
        $iItemID = $this->params()->fromRoute('id', 0);

        # Try to get Skeleton
        try {
            $oItem = $this->oTableGateway->getSingle($iItemID);
        } catch (\RuntimeException $e) {
            # Display error message
            $aReturn = ['state'=>'error','message'=>'Skeleton not found','oItem'=>[]];
            echo json_encode($aReturn);
            return false;
        }

        # Print Entity
        $aReturn = ['state'=>'success','message'=>'Skeleton found','oItem'=>$oItem];
        echo json_encode($aReturn);

        return false;
    }
}
