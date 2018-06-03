<?php

use Illuminate\Database\Seeder;

use App\Http\Models\DocumentType;
use App\Http\Models\SegmentCode;
use App\Http\Models\ProfitCenter;
use App\Http\Models\GLAccount;
use App\Http\Models\Navigation;
use App\Http\Models\NavigationPermission;
use App\Http\Models\UserGroupToNav;
use App\Http\Models\UserGroupToNavPermission;

class SFITransactionDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedProfitCenters();
        $this->addToNavigationProfitCenters();
        //$this->addToNavigationPermissionProfitCenters();
        $this->setProfitCentersUserGroupWithPermissionsToUserGroupToNav();

        $this->seedGLAccounts();
        $this->addToNavigationGLAccounts();
        //$this->addToNavigationPermissionGLAccounts();
        $this->setGLAccountsUserGroupWithPermissionsToUserGroupToNav();

        $this->seedSegmentCodes();
        $this->addToNavigationSegmentCodes();
        //$this->addToNavigationPermissionSegmentCodes();
        $this->setSegmentCodesUserGroupWithPermissionsToUserGroupToNav();

        $this->seedDocumentTypes();
        $this->addToNavigationDocumentTypes();
       // $this->addToNavigationPermissionDocumentTypes();
        $this->setDocumentTypesUserGroupWithPermissionsToUserGroupToNav();

        $this->addToNavigationSFITransactionData();
        //$this->addToNavigationPermissionSFITransactionData();
        $this->setSFITransactionDataUserGroupWithPermissionsToUserGroupToNav();
    }

    public function addToNavigationSFITransactionData()
    {
        if(!Navigation::where('name', '=', 'SFI Transaction Data')->count()){
            Navigation::insert([
                'name'       => 'SFI Transaction Data',
                //'slug'       => 'sfi-transaction-data',
                'url'        => 'sfi.transaction.data',
                'class'      => 'glyphicon glyphicon-file',
                'parent_id'  => 0,
                'order'      => 16,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'summary'    => 0,
                'active'     => 1
            ]);
        }
    }

    public function addToNavigationPermissionSFITransactionData()
    {
        $navigation_id = DB::table('navigation')->where('name', '=', 'SFI Transaction Data')->value('id');

        $permissions = [
            [
                'permission'  => 'show_filter',
                'description' => 'Show Filter'
            ],
            [
                'permission'  => 'show_table',
                'description' => 'Show User List Table'
            ],
            [
                'permission'  => 'show_download',
                'description' => 'Show Download'
            ],
            [
                'permission'  => 'show_tab_delimited',
                'description' => 'Show Tab Delimited'
            ],
            [
                'permission'  => 'show_convert_sfi',
                'description' => 'Show Convert SFI'
            ]
        ];

        foreach ($permissions as $permission) {
            if(!NavigationPermission::where('navigation_id', '=', $navigation_id)->where('permission', '=', $permission['permission'])->count()){
                NavigationPermission::create([
                    'navigation_id' => $navigation_id,
                    'permission'    => $permission['permission'],
                    'description'   => $permission['description']
                ]);
            }
        }
    }

    public function setSFITransactionDataUserGroupWithPermissionsToUserGroupToNav()
    {
        $navigation_id = DB::table('navigation')->where('name', '=', 'SFI Transaction Data')->value('id');

        $adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');

        if(!UserGroupToNav::where('navigation_id', '=', $navigation_id)->where('user_group_id', '=', $adminID)->count()){
            UserGroupToNav::create([
                'user_group_id' => $adminID,
                'navigation_id' => $navigation_id
            ]);
        }

//         $permissions = [
//             'show_filter',
//             'show_table',
//             'show_download',
//             'show_tab_delimited',
//             'show_convert_sfi',
//         ];

//         foreach ($permissions as $permission) {
//             $permission_info = NavigationPermission::where('navigation_id', '=', $navigation_id)->where('permission', '=', $permission)->first();

//             if(!UserGroupToNavPermission::where('permission_id', '=', $permission_info->id)->where('user_group_id', '=', $adminID)->count()){
//                 UserGroupToNavPermission::create([
//                     'user_group_id' => $adminID,
//                     'permission_id' => $permission_info->id
//                 ]);
//             }
//         }
    }

    public function seedProfitCenters()
    {
        $profit_centers = [
            [
                'profit_center' => '1BAC0101',
                'area_code'     => '300'
            ],
            [
                'profit_center' => '1BUT0101',
                'area_code'     => '400'
            ],
            [
                'profit_center' => '1CAG0101',
                'area_code'     => '500'
            ],
            [
                'profit_center' => '1CEB0501',
                'area_code'     => '100'
            ],
            [
                'profit_center' => '1DAV0101',
                'area_code'     => '600'
            ],
            [
                'profit_center' => '1DUM0101',
                'area_code'     => '700'
            ],
            [
                'profit_center' => '1GSC0101',
                'area_code'     => '800'
            ],
            [
                'profit_center' => '1ILO0101',
                'area_code'     => '900'
            ],
            [
                'profit_center' => '1MNL0101',
                'area_code'     => '1000'
            ],
            [
                'profit_center' => '1ORM0101',
                'area_code'     => '1400'
            ],
            [
                'profit_center' => '1OZA0101',
                'area_code'     => '1100'
            ],
            [
                'profit_center' => '1ZAM0101',
                'area_code'     => '1300'
            ],
            [
                'profit_center' => '2BAC0101',
                'area_code'     => '2300'
            ],
            [
                'profit_center' => '2BUT0101',
                'area_code'     => '2400'
            ],
            [
                'profit_center' => '2CAG0101',
                'area_code'     => '2500'
            ],
            [
                'profit_center' => '2CEB0501',
                'area_code'     => '2100'
            ],
            [
                'profit_center' => '2DAV0101',
                'area_code'     => '2600'
            ],
            [
                'profit_center' => '2DUM0101',
                'area_code'     => '2700'
            ],
            [
                'profit_center' => '2GSC0101',
                'area_code'     => '2800'
            ],
            [
                'profit_center' => '2ILO0101',
                'area_code'     => '2900'
            ],
            [
                'profit_center' => '2MNL0101',
                'area_code'     => '3000'
            ],
            [
                'profit_center' => '2ORM0101',
                'area_code'     => '3400'
            ],
            [
                'profit_center' => '2OZA0101',
                'area_code'     => '3100'
            ],
            [
                'profit_center' => '2ZAM0101',
                'area_code'     => '3300'
            ]
        ];

        foreach ($profit_centers as $profit_center) {
            if(!ProfitCenter::where('profit_center','=',$profit_center['profit_center'])->where('area_code','=',$profit_center['area_code'])->count()){
                ProfitCenter::create($profit_center);
            }
        }
    }

    public function seedGLAccounts()
    {
        $gl_accounts = [
            [
                'code'        => '110010',
                'description' => 'A/R Trade-One Time Account'
            ],
            [
                'code'        => '110000',
                'description' => 'Accounts Receivable Trade'
            ],
            [
                'code'        => '400000',
                'description' => 'Sales'
            ],
            [
                'code'        => '100162',
                'description' => 'BPI 1175-0927-37 Checks Received'
            ],
            [
                'code'        => '100152',
                'description' => 'BPI 1175-0927-02 Checks Received '
            ],
            [
                'code'        => '100163',
                'description' => 'BPI 1175-0927-37 Others'
            ],
            [
                'code'        => '100153',
                'description' => 'BPI 1175-0927-02 Others '
            ],
            [
                'code'        => '100000',
                'description' => 'Cash on Hand'
            ]
        ];

        foreach ($gl_accounts as $gl_account) {
            if(!GLAccount::where('code','=',$gl_account['code'])->where('description','=',$gl_account['description'])->count()){
                GLAccount::create($gl_account);
            }
        }
    }

    public function seedSegmentCodes()
    {
        $segment_codes = [
            [
                'segment_code' => '01-CANNED',
                'description'  => '1000-Canned Goods',
                'abbreviation' => 'CG'
            ],
            [
                'segment_code' => '02-FRESHMEAT',
                'description'  => '1000-Fresh Meat',
                'abbreviation' => 'FM'
            ],
            [
                'segment_code' => '03-FROZEN',
                'description'  => '1000-Frozen',
                'abbreviation' => 'FP'
            ],
            [
                'segment_code' => '04-KASSEL',
                'description'  => '1000-Kassel',
                'abbreviation' => 'KP'
            ],
            [
                'segment_code' => '05-MIXES',
                'description'  => '1000-Mixes',
                'abbreviation' => 'MX'
            ],
            [
                'segment_code' => '06-OTHERS',
                'description'  => '1000-Others',
                'abbreviation' => 'OT'
            ],
            [
                'segment_code' => '10-CANNED',
                'description'  => '2000-Canned Goods',
                'abbreviation' => 'CG'
            ],
            [
                'segment_code' => '20-FRESHMEAT',
                'description'  => '2000-Fresh Meat',
                'abbreviation' => 'FM'
            ],
            [
                'segment_code' => '30-FROZEN',
                'description'  => '2000-Frozen',
                'abbreviation' => 'FP'
            ],
            [
                'segment_code' => '40-KASSEL',
                'description'  => '2000-Kassel',
                'abbreviation' => 'KP'
            ],
            [
                'segment_code' => '50-MIXES',
                'description'  => '2000-Mixes',
                'abbreviation' => 'MX'
            ],
            [
                'segment_code' => '60-OTHERS',
                'description'  => '2000-Others',
                'abbreviation' => 'OT'
            ]
        ];

        foreach ($segment_codes as $segment_code) {
            if(!SegmentCode::where('segment_code','=',$segment_code['segment_code'])->where('description','=',$segment_code['description'])->where('abbreviation','=',$segment_code['abbreviation'])->count()){
                SegmentCode::create($segment_code);
            }
        }
    }

    public function seedDocumentTypes()
    {
        $document_types = [
            [
                'type'        => 'AA',
                'description' => 'Asset Posting'
            ],
            [
                'type'        => 'AB',
                'description' => 'Accounting Document'
            ],
            [
                'type'        => 'AF',
                'description' => 'Depreciation Pstngs'
            ],
            [
                'type'        => 'AN',
                'description' => 'Net Asset Posting'
            ],
            [
                'type'        => 'AP',
                'description' => 'Periodic asset post'
            ],
            [
                'type'        => 'CH',
                'description' => 'Contract Settlement'
            ],
            [
                'type'        => 'DA',
                'description' => 'Customer document'
            ],
            [
                'type'        => 'DG',
                'description' => 'Customer credit memo'
            ],
            [
                'type'        => 'DR',
                'description' => 'Customer invoice'
            ],
            [
                'type'        => 'DV',
                'description' => 'Customer Pymt-Others'
            ],
            [
                'type'        => 'DZ',
                'description' => 'Customer Payment'
            ],
            [
                'type'        => 'EU',
                'description' => 'Euro Rounding Diff.'
            ],
            [
                'type'        => 'EX',
                'description' => 'External Number'
            ],
            [
                'type'        => 'KA',
                'description' => 'Vendor Document'
            ],
            [
                'type'        => 'KG',
                'description' => 'Vendor Credit Memo'
            ],
            [
                'type'        => 'KN',
                'description' => 'Net vendors'
            ],
            [
                'type'        => 'KP',
                'description' => 'Account maintenance'
            ],
            [
                'type'        => 'KR',
                'description' => 'Vendor Invoice'
            ],
            [
                'type'        => 'KZ',
                'description' => 'Vendor payment'
            ],
            [
                'type'        => 'ML',
                'description' => 'ML Settlement'
            ],
            [
                'type'        => 'PR',
                'description' => 'Price Change'
            ],
            [
                'type'        => 'RA',
                'description' => 'Sub.Cred.Memo Stlmt'
            ],
            [
                'type'        => 'RB',
                'description' => 'Reserve for Bad Debt'
            ],
            [
                'type'        => 'RE',
                'description' => 'Invoice - Gross'
            ],
            [
                'type'        => 'RK',
                'description' => 'Invoice Reduction'
            ],
            [
                'type'        => 'RN',
                'description' => 'Invoice - Net'
            ],
            [
                'type'        => 'RT',
                'description' => 'Retention'
            ],
            [
                'type'        => 'RV',
                'description' => 'Billing doc.transfer'
            ],
            [
                'type'        => 'SA',
                'description' => 'G/L Account Document'
            ],
            [
                'type'        => 'SB',
                'description' => 'G/L Account Posting'
            ],
            [
                'type'        => 'SK',
                'description' => 'Cash Document'
            ],
            [
                'type'        => 'SU',
                'description' => 'Adjustment document'
            ],
            [
                'type'        => 'UE',
                'description' => 'Data Transfer'
            ],
            [
                'type'        => 'WA',
                'description' => 'Goods Issue'
            ],
            [
                'type'        => 'WE',
                'description' => 'Goods Receipt'
            ],
            [
                'type'        => 'WI',
                'description' => 'Inventory Document'
            ],
            [
                'type'        => 'WL',
                'description' => 'Goods Issue/Delivery'
            ],
            [
                'type'        => 'WN',
                'description' => 'Net Goods Receipt'
            ],
            [
                'type'        => 'Y1',
                'description' => 'Invoice - Gross'
            ],
            [
                'type'        => 'ZP',
                'description' => 'Payment Posting'
            ],
            [
                'type'        => 'ZR',
                'description' => 'Bank reconciliation'
            ],
            [
                'type'        => 'ZS',
                'description' => 'Payment by Check'
            ],
            [
                'type'        => 'ZT',
                'description' => 'GST BAS'
            ],
            [
                'type'        => 'ZV',
                'description' => 'Payment Clearing'
            ]
        ];

        foreach ($document_types as $document_type) {
            if(!DocumentType::where('type','=',$document_type['type'])->where('description','=',$document_type['description'])->count()){
                DocumentType::create($document_type);
            }
        }
    }

    public function addToNavigationProfitCenters()
    {
        if(!Navigation::where('name', '=', 'Profit Centers')->count()){
            Navigation::insert([
                'name'       => 'Profit Centers',
                'url'        => 'profit.centers',
                'class'      => 'glyphicon glyphicon-cog',
                'parent_id'  => 0,
                'order'      => 17,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'summary'    => 0,
                'active'     => 1
            ]);
        }
    }

    public function addToNavigationGLAccounts()
    {
        if(!Navigation::where('name', '=', 'GL Accounts')->count()){
            Navigation::insert([
                'name'       => 'GL Accounts',
                //'slug'       => 'gl-accounts',
                'url'        => 'gl.accounts',
                'class'      => 'glyphicon glyphicon-cog',
                'parent_id'  => 0,
                'order'      => 18,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'summary'    => 0,
                'active'     => 1
            ]);
        }
    }

    public function addToNavigationSegmentCodes()
    {
        if(!Navigation::where('name', '=', 'Segment Codes')->count()){
            Navigation::insert([
                'name'       => 'Segment Codes',
                //'slug'       => 'segment-codes',
                'url'        => 'segment.codes',
                'class'      => 'glyphicon glyphicon-cog',
                'parent_id'  => 0,
                'order'      => 19,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'summary'    => 0,
                'active'     => 1
            ]);
        }
    }

    public function addToNavigationDocumentTypes()
    {
        if(!Navigation::where('name', '=', 'Document Types')->count()){
            Navigation::insert([
                'name'       => 'Document Types',
                //'slug'       => 'document-types',
                'url'        => 'document.types',
                'class'      => 'glyphicon glyphicon-cog',
                'parent_id'  => 0,
                'order'      => 20,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'summary'    => 0,
                'active'     => 1
            ]);
        }
    }

    public function addToNavigationPermissionProfitCenters()
    {
        $navigation_id = DB::table('navigation')->where('name', '=', 'Profit Centers')->value('id');

        $permissions = [
            [
                'permission'  => 'show_table',
                'description' => 'Show Profit Centers Table'
            ],
            [
                'permission'  => 'show_add_button',
                'description' => 'Show Add New Profit Centers Button'
            ],
            [
                'permission'  => 'show_edit_button',
                'description' => 'Show Edit Button'
            ],
            [
                'permission'  => 'show_delete_button',
                'description' => 'Show Delete Button'
            ]
        ];

        foreach ($permissions as $permission) {
            if(!NavigationPermission::where('navigation_id', '=', $navigation_id)->where('permission', '=', $permission['permission'])->count()){
                NavigationPermission::create([
                    'navigation_id' => $navigation_id,
                    'permission'    => $permission['permission'],
                    'description'   => $permission['description']
                ]);
            }
        }
    }

    public function addToNavigationPermissionGLAccounts()
    {
        $navigation_id = DB::table('navigation')->where('name', '=', 'GL Accounts')->value('id');

        $permissions = [
            [
                'permission'  => 'show_table',
                'description' => 'Show GL Accounts Table'
            ],
            [
                'permission'  => 'show_add_button',
                'description' => 'Show Add New GL Accounts Button'
            ],
            [
                'permission'  => 'show_edit_button',
                'description' => 'Show Edit Button'
            ],
            [
                'permission'  => 'show_delete_button',
                'description' => 'Show Delete Button'
            ]
        ];

        foreach ($permissions as $permission) {
            if(!NavigationPermission::where('navigation_id', '=', $navigation_id)->where('permission', '=', $permission['permission'])->count()){
                NavigationPermission::create([
                    'navigation_id' => $navigation_id,
                    'permission'    => $permission['permission'],
                    'description'   => $permission['description']
                ]);
            }
        }
    }

    public function addToNavigationPermissionSegmentCodes()
    {
        $navigation_id = DB::table('navigation')->where('name', '=', 'Segment Codes')->value('id');

        $permissions = [
            [
                'permission'  => 'show_table',
                'description' => 'Show Segment Codes Table'
            ],
            [
                'permission'  => 'show_add_button',
                'description' => 'Show Add New Segment Codes Button'
            ],
            [
                'permission'  => 'show_edit_button',
                'description' => 'Show Edit Button'
            ],
            [
                'permission'  => 'show_delete_button',
                'description' => 'Show Delete Button'
            ]
        ];

        foreach ($permissions as $permission) {
            if(!NavigationPermission::where('navigation_id', '=', $navigation_id)->where('permission', '=', $permission['permission'])->count()){
                NavigationPermission::create([
                    'navigation_id' => $navigation_id,
                    'permission'    => $permission['permission'],
                    'description'   => $permission['description']
                ]);
            }
        }
    }

    public function addToNavigationPermissionDocumentTypes()
    {
        $navigation_id = DB::table('navigation')->where('name', '=', 'Document Types')->value('id');

        $permissions = [
            [
                'permission'  => 'show_table',
                'description' => 'Show Document Types Table'
            ],
            [
                'permission'  => 'show_add_button',
                'description' => 'Show Add New Document Types Button'
            ],
            [
                'permission'  => 'show_edit_button',
                'description' => 'Show Edit Button'
            ],
            [
                'permission'  => 'show_delete_button',
                'description' => 'Show Delete Button'
            ]
        ];

        foreach ($permissions as $permission) {
            if(!NavigationPermission::where('navigation_id', '=', $navigation_id)->where('permission', '=', $permission['permission'])->count()){
                NavigationPermission::create([
                    'navigation_id' => $navigation_id,
                    'permission'    => $permission['permission'],
                    'description'   => $permission['description']
                ]);
            }
        }
    }

    public function setProfitCentersUserGroupWithPermissionsToUserGroupToNav()
    {
        $navigation_id = DB::table('navigation')->where('name', '=', 'Profit Centers')->value('id');

        $adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');

        if(!UserGroupToNav::where('navigation_id', '=', $navigation_id)->where('user_group_id', '=', $adminID)->count()){
            UserGroupToNav::create([
                'user_group_id' => $adminID,
                'navigation_id' => $navigation_id
            ]);
        }

//         $permissions = [
//             'show_table',
//             'show_add_button',
//             'show_edit_button',
//             'show_delete_button',
//         ];

//         foreach ($permissions as $permission) {
//             $permission_info = NavigationPermission::where('navigation_id', '=', $navigation_id)->where('permission', '=', $permission)->first();

//             if(!UserGroupToNavPermission::where('permission_id', '=', $permission_info->id)->where('user_group_id', '=', $adminID)->count()){
//                 UserGroupToNavPermission::create([
//                     'user_group_id' => $adminID,
//                     'permission_id' => $permission_info->id
//                 ]);
//             }
//         }
    }

    public function setGLAccountsUserGroupWithPermissionsToUserGroupToNav()
    {
        $navigation_id = DB::table('navigation')->where('name', '=', 'GL Accounts')->value('id');

        $adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');

        if(!UserGroupToNav::where('navigation_id', '=', $navigation_id)->where('user_group_id', '=', $adminID)->count()){
            UserGroupToNav::create([
                'user_group_id' => $adminID,
                'navigation_id' => $navigation_id
            ]);
        }

//         $permissions = [
//             'show_table',
//             'show_add_button',
//             'show_edit_button',
//             'show_delete_button',
//         ];

//         foreach ($permissions as $permission) {
//             $permission_info = NavigationPermission::where('navigation_id', '=', $navigation_id)->where('permission', '=', $permission)->first();

//             if(!UserGroupToNavPermission::where('permission_id', '=', $permission_info->id)->where('user_group_id', '=', $adminID)->count()){
//                 UserGroupToNavPermission::create([
//                     'user_group_id' => $adminID,
//                     'permission_id' => $permission_info->id
//                 ]);
//             }
//         }
    }

    public function setSegmentCodesUserGroupWithPermissionsToUserGroupToNav()
    {
        $navigation_id = DB::table('navigation')->where('name', '=', 'Segment Codes')->value('id');

        $adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');

        if(!UserGroupToNav::where('navigation_id', '=', $navigation_id)->where('user_group_id', '=', $adminID)->count()){
            UserGroupToNav::create([
                'user_group_id' => $adminID,
                'navigation_id' => $navigation_id
            ]);
        }

//         $permissions = [
//             'show_table',
//             'show_add_button',
//             'show_edit_button',
//             'show_delete_button',
//         ];

//         foreach ($permissions as $permission) {
//             $permission_info = NavigationPermission::where('navigation_id', '=', $navigation_id)->where('permission', '=', $permission)->first();

//             if(!UserGroupToNavPermission::where('permission_id', '=', $permission_info->id)->where('user_group_id', '=', $adminID)->count()){
//                 UserGroupToNavPermission::create([
//                     'user_group_id' => $adminID,
//                     'permission_id' => $permission_info->id
//                 ]);
//             }
//         }
    }

    public function setDocumentTypesUserGroupWithPermissionsToUserGroupToNav()
    {
        $navigation_id = DB::table('navigation')->where('name', '=', 'Document Types')->value('id');

        $adminID = DB::table('user_group')->where(['name' => 'Admin'])->value('id');

        if(!UserGroupToNav::where('navigation_id', '=', $navigation_id)->where('user_group_id', '=', $adminID)->count()){
            UserGroupToNav::create([
                'user_group_id' => $adminID,
                'navigation_id' => $navigation_id
            ]);
        }

//         $permissions = [
//             'show_table',
//             'show_add_button',
//             'show_edit_button',
//             'show_delete_button',
//         ];

//         foreach ($permissions as $permission) {
//             $permission_info = NavigationPermission::where('navigation_id', '=', $navigation_id)->where('permission', '=', $permission)->first();

//             if(!UserGroupToNavPermission::where('permission_id', '=', $permission_info->id)->where('user_group_id', '=', $adminID)->count()){
//                 UserGroupToNavPermission::create([
//                     'user_group_id' => $adminID,
//                     'permission_id' => $permission_info->id
//                 ]);
//             }
//         }
    }
}
