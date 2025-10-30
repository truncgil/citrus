<?php

return [
    // Navigation & Labels
    'title' => 'Languages',
    'navigation_label' => 'Languages',
    'model_label' => 'Language',
    'plural_model_label' => 'Languages',

    // Actions
    'create' => 'Create Language',
    'edit' => 'Edit Language',
    'save' => 'Save',
    'cancel' => 'Cancel',
    'delete' => 'Delete Language',
    'restore' => 'Restore',
    'force_delete' => 'Force Delete',
    'activate' => 'Activate',
    'deactivate' => 'Deactivate',
    'set_default' => 'Set as Default',

    // Form Sections
    'basic_information' => 'Basic Information',
    'settings' => 'Settings',

    // Form Fields
    'code' => 'Language Code',
    'code_helper' => 'ISO 639-1 language code (e.g: tr, en, de)',
    'name' => 'Language Name',
    'name_helper' => 'English language name (e.g: Turkish)',
    'native_name' => 'Native Name',
    'native_name_helper' => 'Language name in its own language (e.g: Türkçe)',
    'flag' => 'Flag',
    'flag_helper' => 'Flag emoji or icon code',
    'direction' => 'Text Direction',
    'direction_ltr' => 'Left to Right (LTR)',
    'direction_rtl' => 'Right to Left (RTL)',
    'is_active' => 'Active',
    'is_active_helper' => 'Is this language available in the system?',
    'is_default' => 'Default Language',
    'is_default_helper' => 'Should this be the default language?',
    'sort_order' => 'Sort Order',
    'sort_order_helper' => 'Display order of languages',

    // Table Columns
    'table_flag' => 'Flag',
    'table_code' => 'Code',
    'table_name' => 'Language Name',
    'table_is_active' => 'Active',
    'table_is_default' => 'Default',
    'table_direction' => 'Direction',
    'table_sort_order' => 'Order',
    'table_created_at' => 'Created',
    'table_updated_at' => 'Updated',
    'table_deleted_at' => 'Deleted',

    // Messages
    'created_successfully' => 'Language created successfully',
    'created_successfully_body' => 'New language has been added to the system.',
    'updated_successfully' => 'Language updated successfully',
    'updated_successfully_body' => 'Language information has been updated.',
    'deleted_successfully' => 'Language deleted successfully',
    'deleted_successfully_body' => 'Language has been removed from the system.',
    'restored_successfully' => 'Language restored successfully',
    'activated_successfully' => 'Language activated',
    'deactivated_successfully' => 'Language deactivated',
    'set_default_successfully' => 'Default language updated',
    'cannot_delete_default' => 'Cannot delete default language',
    'cannot_deactivate_default' => 'Cannot deactivate default language',

    // Validation
    'code_required' => 'Language code is required',
    'code_unique' => 'This language code is already in use',
    'name_required' => 'Language name is required',
    'native_name_required' => 'Native name is required',
];

