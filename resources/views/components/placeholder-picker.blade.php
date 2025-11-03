@php
    // Desteklenen placeholder tipleri ve açıklamaları
    $placeholderTypes = [
        'text' => ['label' => __('placeholder-picker.type_text'), 'examples' => ['company_name', 'title', 'description', 'subtitle']],
        'email' => ['label' => __('placeholder-picker.type_email'), 'examples' => ['contact', 'support', 'info', 'sales']],
        'url' => ['label' => __('placeholder-picker.type_url'), 'examples' => ['website', 'facebook', 'twitter', 'linkedin']],
        'tel' => ['label' => __('placeholder-picker.type_tel'), 'examples' => ['phone', 'mobile', 'fax', 'hotline']],
        'number' => ['label' => __('placeholder-picker.type_number'), 'examples' => ['price', 'quantity', 'age', 'year']],
        'textarea' => ['label' => __('placeholder-picker.type_textarea'), 'examples' => ['content', 'about', 'description', 'notes']],
        'richtext' => ['label' => __('placeholder-picker.type_richtext'), 'examples' => ['content', 'article', 'post', 'body']],
        'markdown' => ['label' => __('placeholder-picker.type_markdown'), 'examples' => ['content', 'documentation', 'readme']],
        'code' => ['label' => __('placeholder-picker.type_code'), 'examples' => ['snippet', 'example', 'script']],
        'date' => ['label' => __('placeholder-picker.type_date'), 'examples' => ['publish_date', 'event_date', 'birthday']],
        'datetime' => ['label' => __('placeholder-picker.type_datetime'), 'examples' => ['created_at', 'updated_at', 'event_time']],
        'time' => ['label' => __('placeholder-picker.type_time'), 'examples' => ['start_time', 'end_time', 'opening_time']],
        'image' => ['label' => __('placeholder-picker.type_image'), 'examples' => ['logo', 'banner', 'avatar', 'thumbnail']],
        'images' => ['label' => __('placeholder-picker.type_images'), 'examples' => ['gallery', 'photos', 'slider_images']],
        'file' => ['label' => __('placeholder-picker.type_file'), 'examples' => ['document', 'pdf', 'download']],
        'files' => ['label' => __('placeholder-picker.type_files'), 'examples' => ['documents', 'attachments']],
        'select' => ['label' => __('placeholder-picker.type_select'), 'examples' => ['category', 'status', 'type']],
        'multiselect' => ['label' => __('placeholder-picker.type_multiselect'), 'examples' => ['tags', 'categories', 'features']],
        'checkbox' => ['label' => __('placeholder-picker.type_checkbox'), 'examples' => ['is_active', 'is_featured', 'is_published']],
        'radio' => ['label' => __('placeholder-picker.type_radio'), 'examples' => ['gender', 'type', 'status']],
        'toggle' => ['label' => __('placeholder-picker.type_toggle'), 'examples' => ['is_active', 'is_enabled', 'is_visible']],
        'color' => ['label' => __('placeholder-picker.type_color'), 'examples' => ['primary_color', 'background_color', 'text_color']],
        'tags' => ['label' => __('placeholder-picker.type_tags'), 'examples' => ['tags', 'keywords', 'labels']],
    ];
    
    // Field name'i component'ten al
    $fieldName = $fieldName ?? 'html_content';
@endphp

<div
    x-data="placeholderPickerData(@js($placeholderTypes))"
>
    <x-filament::section
        collapsible
        :collapsed="true"
        :description="__('placeholder-picker.click_to_insert')"
        icon="heroicon-o-tag"
    >
        <x-slot name="heading">
            {{ __('placeholder-picker.title') }}
        </x-slot>
        
        <div class="space-y-4">
        <!-- Search Bar -->
        <x-filament::input.wrapper>
            <x-slot name="prefix">
                <x-filament::icon
                    icon="heroicon-o-magnifying-glass"
                    class="h-5 w-5"
                />
            </x-slot>
            <x-filament::input
                type="text"
                x-model="searchQuery"
                :placeholder="__('placeholder-picker.search_placeholder')"
            />
            <x-slot name="suffix">
                <button
                    x-show="searchQuery"
                    @click="searchQuery = ''"
                    type="button"
                    class="fi-icon-btn fi-icon-btn-color-gray fi-icon-btn-size-md"
                >
                    <x-filament::icon
                        icon="heroicon-o-x-mark"
                        class="h-4 w-4"
                    />
                </button>
            </x-slot>
        </x-filament::input.wrapper>
        
        <!-- Placeholder List -->
        <div class="max-h-96 overflow-y-auto space-y-4">
            <template x-for="(info, type) in filteredCategories" x-bind:key="type">
                <div class="space-y-2">
                    <h4 class="fi-section-header-heading text-xs font-semibold uppercase tracking-wide">
                        <span x-text="info.label"></span>
                    </h4>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="example in info.examples" x-bind:key="example">
                            <x-filament::button
                                size="sm"
                                color="gray"
                                outlined
                                @click="insertPlaceholder('{{ $fieldName }}', type + '.' + example)"
                                x-bind:tooltip="'{{ __('placeholder-picker.click_to_insert') }}'"
                            >
                                <code class="text-xs font-mono" x-text="'{' + type + '.' + example + '}'"></code>
                            </x-filament::button>
                        </template>
                    </div>
                </div>
            </template>
            
            <!-- Özel placeholder'lar -->
            <div x-show="hasSpecialPlaceholders" class="pt-3 border-t fi-border-color">
                <h4 class="fi-section-header-heading text-xs font-semibold uppercase tracking-wide mb-2">
                    {{ __('placeholder-picker.special_placeholders') }}
                </h4>
                <div class="flex flex-wrap gap-2">
                    <x-filament::button
                        size="sm"
                        color="primary"
                        outlined
                        @click="insertPlaceholder('{{ $fieldName }}', 'menu')"
                    >
                        <code class="text-xs font-mono">{menu}</code>
                    </x-filament::button>
                    <x-filament::button
                        size="sm"
                        color="primary"
                        outlined
                        @click="insertPlaceholder('{{ $fieldName }}', 'staticMenu')"
                    >
                        <code class="text-xs font-mono">{staticMenu}</code>
                    </x-filament::button>
                </div>
            </div>
            
            <!-- No Results -->
            <div 
                x-show="Object.keys(filteredCategories).length === 0 && !hasSpecialPlaceholders" 
                class="flex flex-col items-center justify-center gap-4 py-8"
            >
                <x-filament::icon
                    icon="heroicon-o-magnifying-glass"
                    class="h-12 w-12 text-gray-400 dark:text-gray-500"
                />
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('placeholder-picker.no_results') }}</p>
            </div>
        </div>
    </div>
    </x-filament::section>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('placeholderPickerData', (placeholderTypes) => ({
            searchQuery: '',
            placeholderTypes: placeholderTypes,
            
            get filteredCategories() {
                if (!this.searchQuery.trim()) {
                    return this.placeholderTypes;
                }
                const query = this.searchQuery.toLowerCase();
                const filtered = {};
                for (const [type, info] of Object.entries(this.placeholderTypes)) {
                    const filteredExamples = info.examples.filter(example => {
                        const placeholder = type + '.' + example;
                        return placeholder.toLowerCase().includes(query) || 
                               example.toLowerCase().includes(query) ||
                               info.label.toLowerCase().includes(query);
                    });
                    if (filteredExamples.length > 0) {
                        filtered[type] = {
                            label: info.label,
                            examples: filteredExamples
                        };
                    }
                }
                return filtered;
            },
            
            get hasSpecialPlaceholders() {
                if (!this.searchQuery.trim()) return true;
                const query = this.searchQuery.toLowerCase();
                return 'menu'.includes(query) || 'staticmenu'.includes(query) || 'özel'.includes(query) || 'special'.includes(query);
            }
        }));
    });

    function insertPlaceholder(fieldName, placeholder) {
        const placeholderText = '{' + placeholder + '}';
        
        // Monaco Editor instance'ını bul
        const editorContainer = document.querySelector('[data-field-name=\'' + fieldName + '\']');
        let monacoEditorInstance = null;
        let currentValue = '';
        let cursorPosition = null;
        
        // Monaco Editor'dan cursor pozisyonunu al
        if (editorContainer && window.monaco) {
            const editorInstances = window.monaco.editor.getEditors();
            for (let editor of editorInstances) {
                const container = editor.getContainerDomNode();
                if (container && container.closest && container.closest('[data-field-name=\'' + fieldName + '\']')) {
                    monacoEditorInstance = editor;
                    const model = editor.getModel();
                    currentValue = model.getValue();
                    const selection = editor.getSelection();
                    if (selection) {
                        cursorPosition = model.getOffsetAt(selection.getStartPosition());
                    } else {
                        cursorPosition = currentValue.length;
                    }
                    break;
                }
            }
        }
        
        // Monaco Editor varsa, doğrudan onu kullan
        if (monacoEditorInstance) {
            const model = monacoEditorInstance.getModel();
            const newValue = currentValue.slice(0, cursorPosition) + placeholderText + currentValue.slice(cursorPosition);
            
            // Monaco Editor'da değeri güncelle
            monacoEditorInstance.executeEdits('placeholder-insert', [{
                range: new window.monaco.Range(
                    model.getPositionAt(cursorPosition).lineNumber,
                    model.getPositionAt(cursorPosition).column,
                    model.getPositionAt(cursorPosition).lineNumber,
                    model.getPositionAt(cursorPosition).column
                ),
                text: placeholderText
            }]);
            
            // Cursor pozisyonunu güncelle
            const newPosition = model.getPositionAt(cursorPosition + placeholderText.length);
            monacoEditorInstance.setPosition(newPosition);
            monacoEditorInstance.focus();
            
            // Filament form state'ini güncellemek için Monaco Editor'ın change event'ini tetikle
            // Filament CodeEditor otomatik olarak değişiklikleri algılar
            setTimeout(() => {
                // Monaco Editor model değişikliğini tetikle
                // Bu, Filament'in CodeEditor component'inin otomatik olarak algılamasını sağlar
                if (monacoEditorInstance) {
                    // Model'in değerini tekrar set et (zaten set ettik ama event'i tetiklemek için)
                    const model = monacoEditorInstance.getModel();
                    
                    // Monaco Editor'ın onDidChangeContent event'ini manuel tetikle
                    // Filament CodeEditor bu event'i dinliyor ve form state'ini güncelliyor
                    model.onDidChangeContent(() => {
                        // Bu event zaten tetiklenmiş olacak, sadece emin olmak için
                    });
                    
                    // Hidden input'u bul ve güncelle (eğer varsa)
                    const hiddenInput = editorContainer.querySelector('input[type=\'hidden\']');
                    if (hiddenInput) {
                        hiddenInput.value = newValue;
                        hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
                        hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                    
                    // Filament form'unu bul ve güncelle
                    // Form component'ini bulmak için editor container'ın parent'larını kontrol et
                    let formComponent = null;
                    const formWireElement = editorContainer.closest('form [wire\\:id], [wire\\:id][wire\\:key*="form"]');
                    
                    if (formWireElement && window.Livewire) {
                        const wireId = formWireElement.getAttribute('wire:id');
                        const component = window.Livewire.find(wireId);
                        
                        // Component'in form component'i olup olmadığını kontrol et
                        // Sadece field path'lerini kontrol et, 'data' property'sine direkt erişme
                        if (component && component.get) {
                            const fieldPath = 'data.' + fieldName;
                            try {
                                // Field path'i kontrol et
                                if (component.get(fieldPath) !== undefined) {
                                    formComponent = component;
                                } else if (component.get('data.html_content') !== undefined) {
                                    formComponent = component;
                                } else if (component.get('html_content') !== undefined) {
                                    formComponent = component;
                                }
                            } catch (e) {
                                // Property kontrolü sırasında hata alırsak, component'i kullanma
                            }
                        }
                    }
                    
                    // Sadece form component'i bulunduysa güncelle
                    if (formComponent) {
                        try {
                            const fieldPath = 'data.' + fieldName;
                            if (formComponent.get(fieldPath) !== undefined) {
                                formComponent.set(fieldPath, newValue);
                            } else if (formComponent.get('data.html_content') !== undefined) {
                                formComponent.set('data.html_content', newValue);
                            } else if (formComponent.get('html_content') !== undefined) {
                                formComponent.set('html_content', newValue);
                            }
                        } catch (e) {
                            // Hata durumunda sadece console'a yaz, Monaco Editor zaten güncellenmiş
                            console.debug('Livewire form state update skipped:', e.message);
                        }
                    }
                }
            }, 150);
            
            return;
        }
        
        // Livewire component'ini bul ve güncelle (Monaco Editor yoksa)
        if (window.Livewire) {
            // Form component'ini bulmak için field name ile input elementini bul
            const formField = document.querySelector('input[name*=\'' + fieldName + '\'], textarea[name*=\'' + fieldName + '\']');
            let formComponent = null;
            
            if (formField) {
                // Input field'ın parent'ındaki wire element'i bul
                const formWireElement = formField.closest('[wire\\:id]');
                
                if (formWireElement) {
                    const wireId = formWireElement.getAttribute('wire:id');
                    const component = window.Livewire.find(wireId);
                    
                    // Component'in form component'i olup olmadığını kontrol et
                    if (component && component.get) {
                        const fieldPath = 'data.' + fieldName;
                        try {
                            // Field path'lerini kontrol et
                            if (component.get(fieldPath) !== undefined || 
                                component.get('data.html_content') !== undefined ||
                                component.get('html_content') !== undefined) {
                                formComponent = component;
                            }
                        } catch (e) {
                            // Property kontrolü sırasında hata alırsak, component'i kullanma
                        }
                    }
                }
            }
            
            if (formComponent) {
                try {
                    // Mevcut değeri al
                    let fieldValue = '';
                    if (formComponent.get('data.html_content') !== undefined) {
                        fieldValue = formComponent.get('data.html_content') || '';
                    } else if (formComponent.get('html_content') !== undefined) {
                        fieldValue = formComponent.get('html_content') || '';
                    } else {
                        const fieldPath = 'data.' + fieldName;
                        fieldValue = formComponent.get(fieldPath) || '';
                    }
                    
                    // Cursor pozisyonu yoksa sona ekle
                    if (cursorPosition === null) {
                        cursorPosition = fieldValue.length;
                    }
                    
                    // Placeholder'ı cursor pozisyonuna ekle
                    const newValue = fieldValue.slice(0, cursorPosition) + placeholderText + fieldValue.slice(cursorPosition);
                    
                    // Livewire state'ini güncelle (Livewire 3 API)
                    if (formComponent.get('data.html_content') !== undefined) {
                        formComponent.set('data.html_content', newValue);
                    } else if (formComponent.get('html_content') !== undefined) {
                        formComponent.set('html_content', newValue);
                    } else {
                        const fieldPath = 'data.' + fieldName;
                        formComponent.set(fieldPath, newValue);
                    }
                    
                    return;
                } catch (e) {
                    console.warn('Livewire form update failed:', e);
                }
            }
        }
        
        // Fallback: Textarea veya input elementini bul
        const formField = document.querySelector('input[name*=\'' + fieldName + '\'], textarea[name*=\'' + fieldName + '\']');
        if (formField) {
            const fieldValue = formField.value || '';
            const fieldCursorPosition = formField.selectionStart || fieldValue.length;
            const newValue = fieldValue.slice(0, fieldCursorPosition) + placeholderText + fieldValue.slice(fieldCursorPosition);
            
            formField.value = newValue;
            formField.setSelectionRange(fieldCursorPosition + placeholderText.length, fieldCursorPosition + placeholderText.length);
            
            // Form event'lerini tetikle
            formField.dispatchEvent(new Event('input', { bubbles: true }));
            formField.dispatchEvent(new Event('change', { bubbles: true }));
        }
    }
    
    // Global scope'a ekle
    window.insertPlaceholder = insertPlaceholder;
</script>

