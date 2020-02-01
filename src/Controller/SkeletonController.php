<?php
/**
 * SkeletonController.php - Main Controller
 *
 * Main Controller Skeleton Module
 *
 * @category Controller
 * @package Skeleton
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace OnePlace\Skeleton\Controller;

use Application\Controller\CoreEntityController;
use Application\Model\CoreEntityModel;
use OnePlace\Skeleton\Model\Skeleton;
use OnePlace\Skeleton\Model\SkeletonTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;

class SkeletonController extends CoreEntityController {
    /**
     * Skeleton Table Object
     *
     * @since 1.0.0
     */
    protected $oTableGateway;

    /**
     * SkeletonController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param SkeletonTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter,SkeletonTable $oTableGateway,$oServiceManager) {
        $this->oTableGateway = $oTableGateway;
        $this->sSingleForm = 'skeleton-single';
        parent::__construct($oDbAdapter,$oTableGateway,$oServiceManager);

        if($oTableGateway) {
            # Attach TableGateway to Entity Models
            if(!isset(CoreEntityModel::$aEntityTables[$this->sSingleForm])) {
                CoreEntityModel::$aEntityTables[$this->sSingleForm] = $oTableGateway;
            }
        }
    }

    /**
     * Skeleton Index
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function indexAction() {

        # You can just use the default function and customize it via hooks
        # or replace the entire function if you need more customization
        return $this->generateIndexView('skeleton');
    }

    /**
     * Skeleton Add Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function addAction() {
        /**
         * You can just use the default function and customize it via hooks
         * or replace the entire function if you need more customization
         *
         * Hooks available:
         *
         * skeleton-add-before (before show add form)
         * skeleton-add-before-save (before save)
         * skeleton-add-after-save (after save)
         */
        return $this->generateAddView('skeleton');
    }

    /**
     * Skeleton Edit Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function editAction() {
        /**
         * You can just use the default function and customize it via hooks
         * or replace the entire function if you need more customization
         *
         * Hooks available:
         *
         * skeleton-edit-before (before show edit form)
         * skeleton-edit-before-save (before save)
         * skeleton-edit-after-save (after save)
         */
        return $this->generateEditView('skeleton');
    }

    /**
     * Skeleton View Form
     *
     * @since 1.0.0
     * @return ViewModel - View Object with Data from Controller
     */
    public function viewAction() {
        /**
         * You can just use the default function and customize it via hooks
         * or replace the entire function if you need more customization
         *
         * Hooks available:
         *
         * skeleton-view-before
         */
        return $this->generateViewView('skeleton');
    }
}
