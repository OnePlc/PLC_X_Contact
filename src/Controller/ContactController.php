<?php
/**
 * ContactController.php - Main Controller
 *
 * Main Controller Contact Module
 *
 * @category Controller
 * @package Contact
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace OnePlace\Contact\Controller;

use Application\Controller\CoreController;
use OnePlace\Contact\Model\Contact;
use OnePlace\Contact\Model\ContactTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;

class ContactController extends CoreController {
    /**
     * Contact Table Object
     *
     * @since 1.0.0
     */
    private $oTableGateway;

    /**
     * ContactController constructor.
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
     * Contact Index
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function indexAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('contact');

        # Add Buttons for breadcrumb
        $this->setViewButtons('contact-index');

        # Set Table Rows for Index
        $this->setIndexColumns('contact-index');

        # Get Paginator
        $oPaginator = $this->oTableGateway->fetchAll(true);
        $iPage = (int) $this->params()->fromQuery('page', 1);
        $iPage = ($iPage < 1) ? 1 : $iPage;
        $oPaginator->setCurrentPageNumber($iPage);
        $oPaginator->setItemCountPerPage(3);

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('contact-index',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        return new ViewModel([
            'sTableName'=>'contact-index',
            'aItems'=>$oPaginator,
        ]);
    }

    /**
     * Contact Add Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function addAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('contact');

        # Get Request to decide wether to save or display form
        $oRequest = $this->getRequest();

        # Display Add Form
        if(!$oRequest->isPost()) {
            # Add Buttons for breadcrumb
            $this->setViewButtons('contact-single');

            # Load Tabs for View Form
            $this->setViewTabs($this->sSingleForm);

            # Load Fields for View Form
            $this->setFormFields($this->sSingleForm);

            # Log Performance in DB
            $aMeasureEnd = getrusage();
            $this->logPerfomance('contact-add',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

            return new ViewModel([
                'sFormName' => $this->sSingleForm,
            ]);
        }

        # Get and validate Form Data
        $aFormData = $this->parseFormData($_REQUEST);

        # Save Add Form
        $oContact = new Contact($this->oDbAdapter);
        $oContact->exchangeArray($aFormData);
        $iContactID = $this->oTableGateway->saveSingle($oContact);
        $oContact = $this->oTableGateway->getSingle($iContactID);

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('contact-save',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        # Display Success Message and View New Contact
        $this->flashMessenger()->addSuccessMessage('Contact successfully created');
        return $this->redirect()->toRoute('contact',['action'=>'view','id'=>$iContactID]);
    }

    /**
     * Contact Edit Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function editAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('contact');

        # Get Request to decide wether to save or display form
        $oRequest = $this->getRequest();

        # Display Edit Form
        if(!$oRequest->isPost()) {

            # Get Contact ID from URL
            $iContactID = $this->params()->fromRoute('id', 0);

            # Try to get Contact
            try {
                $oContact = $this->oTableGateway->getSingle($iContactID);
            } catch (\RuntimeException $e) {
                echo 'Contact Not found';
                return false;
            }

            # Attach Contact Entity to Layout
            $this->setViewEntity($oContact);

            # Add Buttons for breadcrumb
            $this->setViewButtons('contact-single');

            # Load Tabs for View Form
            $this->setViewTabs($this->sSingleForm);

            # Load Fields for View Form
            $this->setFormFields($this->sSingleForm);

            # Log Performance in DB
            $aMeasureEnd = getrusage();
            $this->logPerfomance('contact-edit',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

            return new ViewModel([
                'sFormName' => $this->sSingleForm,
                'oContact' => $oContact,
            ]);
        }

        $iContactID = $oRequest->getPost('Item_ID');
        $oContact = $this->oTableGateway->getSingle($iContactID);

        # Update Contact with Form Data
        $oContact = $this->attachFormData($_REQUEST,$oContact);

        # Save Contact
        $iContactID = $this->oTableGateway->saveSingle($oContact);

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('contact-save',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        # Display Success Message and View New User
        $this->flashMessenger()->addSuccessMessage('Contact successfully saved');
        return $this->redirect()->toRoute('contact',['action'=>'view','id'=>$iContactID]);
    }

    /**
     * Contact View Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function viewAction() {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('contact');

        # Get Contact ID from URL
        $iContactID = $this->params()->fromRoute('id', 0);

        # Try to get Contact
        try {
            $oContact = $this->oTableGateway->getSingle($iContactID);
        } catch (\RuntimeException $e) {
            echo 'Contact Not found';
            return false;
        }

        # Attach Contact Entity to Layout
        $this->setViewEntity($oContact);

        # Add Buttons for breadcrumb
        $this->setViewButtons('contact-view');

        # Load Tabs for View Form
        $this->setViewTabs($this->sSingleForm);

        # Load Fields for View Form
        $this->setFormFields($this->sSingleForm);

        # Log Performance in DB
        $aMeasureEnd = getrusage();
        $this->logPerfomance('contact-view',$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"utime"),$this->rutime($aMeasureEnd,CoreController::$aPerfomanceLogStart,"stime"));

        return new ViewModel([
            'sFormName'=>$this->sSingleForm,
            'oContact'=>$oContact,
        ]);
    }
}
