<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\EnumHelper;
use App\Http\Controllers\Admin\Traits\Permissions;
use App\Http\Requests\AdoptionRequest as StoreRequest;
use App\Http\Requests\AdoptionRequest as UpdateRequest;
use App\Models\Adoption;
use App\User;

/**
 * Class AdoptionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class AdoptionCrudController extends CrudController
{
    use Permissions;

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Adoption');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/adoption');
        $this->crud->setEntityNameStrings(__('adoption'), __('adoptions'));

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        // ------ CRUD FIELDS
        $this->crud->addFields(['process_id', 'fat_id', 'name', 'name_after', 'age', 'gender', 'sterilized', 'vaccinated', 'processed', 'images', 'features', 'history', 'status']);

        $this->crud->addField([
            'label' => ucfirst(__('process')),
            'name' => 'process_id',
            'type' => 'select2_from_ajax',
            'entity' => 'process',
            'attribute' => 'detail',
            'model' => '\App\Models\Process',
            'data_source' => url('admin/process/ajax/search'),
            'placeholder' => __('Select a process'),
            'minimum_input_length' => 2,
            'default' => \Request::get('process') ?: false,
        ]);

        if (is('admin')) {
            $this->crud->addField([
                'label' => ucfirst(__('volunteer')),
                'name' => 'user_id',
                'type' => 'select2_from_ajax',
                'entity' => 'user',
                'attribute' => 'name',
                'model' => '\App\User',
                'placeholder' => '',
                'minimum_input_length' => 2,
                'data_source' => null,
                'attributes' => [
                    'disabled' => 'disabled',
                ],
            ], 'update');
        }

        $this->crud->addField([
            'label' => __('FAT'),
            'name' => 'fat_id',
            'type' => 'select2_from_ajax',
            'entity' => 'user',
            'attribute' => 'name',
            'model' => '\App\User',
            'data_source' => url('admin/user/ajax/search/' . User::FAT),
            'placeholder' => __('Select a fat'),
            'minimum_input_length' => 2,
            'default' => \Request::get('user') ?: false,
        ]);

        $this->crud->addField([
            'label' => __('Name'),
            'name' => 'name',
        ]);

        $this->crud->addField([
            'label' => __('Name after adoption'),
            'name' => 'name_after',
        ]);

        $this->crud->addField([
            'label' => ucfirst(__('age')),
            'name' => 'age',
            'type' => 'age',
            'default' => [0, 0],
        ]);

        $this->crud->addField([
            'label' => ucfirst(__('gender')),
            'name' => 'gender',
            'type' => 'enum',
        ]);

        $this->crud->addField([
            'label' => ucfirst(__('sterilized')),
            'name' => 'sterilized',
            'type' => 'checkbox',
        ]);

        $this->crud->addField([
            'label' => ucfirst(__('vaccinated')),
            'name' => 'vaccinated',
            'type' => 'checkbox',
        ]);

        $this->crud->addField([
            'label' => ucfirst(__('processed')) . '<br /><i>Ativar se o animal já tiver sido tratado na AdR.</i>',
            'name' => 'processed',
            'type' => 'checkbox',
        ]);

        $this->crud->addField([
            'name' => 'images',
            'label' => __('Images'),
            'type' => 'dropzone',
            'upload-url' => '/admin/dropzone/images/adoptions',
            'thumb' => 340,
            'size' => 800,
            'quality' => 82,
        ]);

        $this->crud->addField([
            'label' => __('Features'),
            'type' => 'wysiwyg',
            'name' => 'features',
        ]);

        $this->crud->addField([
            'label' => __('History'),
            'type' => 'wysiwyg',
            'name' => 'history',
        ]);

        $this->crud->addField([
            'label' => __('Status'),
            'type' => 'enum',
            'name' => 'status',
            'attributes' => is('admin', 'adoptions') ? [] : [
                'disabled' => 'disabled',
            ],
        ]);

        // ------ CRUD COLUMNS
        $this->crud->addColumns(['id', 'name', 'process_id', 'fat_id', 'age', 'gender', 'sterilized', 'vaccinated', 'processed', 'status', 'user_id']);

        $this->crud->setColumnDetails('id', [
            'label' => 'ID',
        ]);

        $this->crud->setColumnDetails('name', [
            'label' => __('Name'),
        ]);

        $this->crud->setColumnDetails('process_id', [
            'name' => 'process',
            'label' => ucfirst(__('process')),
            'type' => 'model_function',
            'limit' => 120,
            'function_name' => 'getProcessLinkAttribute',
        ]);

        $this->crud->setColumnDetails('user_id', [
            'name' => 'user',
            'label' => ucfirst(__('volunteer')),
            'type' => 'model_function',
            'limit' => 120,
            'function_name' => 'getUserLinkAttribute',
        ]);

        $this->crud->setColumnDetails('fat_id', [
            'name' => 'fat',
            'label' => __('FAT'),
            'type' => 'model_function',
            'limit' => 120,
            'function_name' => 'getFatLinkAttribute',
        ]);

        $this->crud->setColumnDetails('age', [
            'name' => 'age',
            'label' => ucfirst(__('age')),
            'type' => 'model_function',
            'function_name' => 'getAgeValueAttribute',
        ]);

        $this->crud->setColumnDetails('gender', [
            'type' => 'trans',
            'label' => ucfirst(__('gender')),
        ]);

        $this->crud->setColumnDetails('sterilized', [
            'type' => 'boolean',
            'label' => ucfirst(__('sterilized')),
        ]);

        $this->crud->setColumnDetails('vaccinated', [
            'type' => 'boolean',
            'label' => ucfirst(__('vaccinated')),
        ]);

        $this->crud->setColumnDetails('processed', [
            'type' => 'boolean',
            'label' => ucfirst(__('processed')),
        ]);

        $this->crud->setColumnDetails('status', [
            'type' => 'trans',
            'label' => __('Status'),
        ]);

        // Filtrers
        $this->crud->addFilter([
            'name' => 'process',
            'type' => 'select2_ajax',
            'label' => ucfirst(__('process')),
            'placeholder' => __('Select a process'),
        ],
            url('admin/process/ajax/filter'),
            function ($value) {
                $this->crud->addClause('where', 'process_id', $value);
            });

        $this->crud->addFilter([
            'name' => 'fat',
            'type' => 'select2_ajax',
            'label' => __('FAT'),
            'placeholder' => __('Select a FAT'),
        ],
            url('admin/user/ajax/filter/' . User::FAT),
            function ($value) {
                $this->crud->addClause('where', 'user_id', $value);
            });

        $this->crud->addFilter([
            'name' => 'user',
            'type' => 'select2_ajax',
            'label' => ucfirst(__('volunteer')),
            'placeholder' => __('Select a volunteer'),
        ],
            url('admin/user/ajax/filter/' . User::VOLUNTEER),
            function ($value) {
                $this->crud->addClause('where', 'user_id', $value);
            });

        $this->crud->addFilter([
            'name' => 'gender',
            'type' => 'select2',
            'label' => ucfirst(__('gender')),
            'placeholder' => __('Select a gender'),
        ],
            EnumHelper::translate('animal.gender'),
            function ($value) {
                $this->crud->addClause('where', 'gender', $value);
            });

        $this->crud->addFilter([
            'type' => 'select2',
            'name' => 'sterilized',
            'label' => ucfirst(__('sterilized')),
        ],
            EnumHelper::translate('general.boolean'),
            function ($value) {
                $this->crud->addClause('where', 'sterilized', $value);
            });

        $this->crud->addFilter([
            'type' => 'select2',
            'name' => 'vaccinated',
            'label' => ucfirst(__('vaccinated')),
        ],
            EnumHelper::translate('general.boolean'),
            function ($value) {
                $this->crud->addClause('where', 'vaccinated', $value);
            });

        $this->crud->addFilter([
            'type' => 'select2',
            'name' => 'processed',
            'label' => __('processed'),
        ],
            EnumHelper::translate('general.boolean'),
            function ($value) {
                $this->crud->addClause('where', 'processed', $value);
            });

        $this->crud->addFilter([
            'name' => 'number',
            'type' => 'range',
            'label' => sprintf('%s (%s)', ucfirst(__('age')), ucfirst(__('months'))),
            'label_from' => __('Min value'),
            'label_to' => __('Max value'),
        ],
            false,
            function ($value) {
                $range = json_decode($value);
                if ($range->from) {
                    $this->crud->addClause('where', 'age', '>=', (float) $range->from);
                }
                if ($range->to) {
                    $this->crud->addClause('where', 'age', '<=', (float) $range->to);
                }
            });

        $this->crud->addFilter([
            'name' => 'status',
            'type' => 'select2_multiple',
            'label' => __('Status'),
            'placeholder' => __('Select a status'),
        ],
            EnumHelper::translate('adoption.status'),
            function ($values) {
                $this->crud->addClause('whereIn', 'status', json_decode($values));
            });

        // ------ ADVANCED QUERIES
        if (!is(['admin', 'volunteer'], 'processes')) {
            $this->crud->denyAccess(['list', 'show']);
        }

        if (!is('admin', 'adoptions')) {
            $this->crud->denyAccess(['update']);
        }

        if (!is('admin')) {
            $this->crud->addClause('whereHas', 'process', function ($query) {
                $query->where('headquarter_id', restrictToHeadquarter());
            })->get();

            $this->crud->denyAccess(['delete']);
        }

        $this->crud->query->with(['process', 'user', 'fat']);

        $this->crud->addClause('orderBy', 'id', 'DESC');

        // add asterisk for fields that are required in AdoptionRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // Add user
        $request->merge(['user_id' => backpack_user()->id]);

        return parent::storeCrud($request);
    }

    public function update(UpdateRequest $request)
    {
        return parent::updateCrud($request);
    }
}
