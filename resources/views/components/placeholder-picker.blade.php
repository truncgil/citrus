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
    
    // Custom klasöründeki blade dosyalarını tespit et ve placeholder types'a ekle
    $customPlaceholders = [];
    $customPath = resource_path('views/components/custom');
    
    if (is_dir($customPath)) {
        $files = scandir($customPath);
        
        foreach ($files as $file) {
            // . ve .. dizinlerini atla
            if ($file === '.' || $file === '..') {
                continue;
            }
            
            // Sadece .blade.php uzantılı dosyaları al
            $filePath = $customPath . DIRECTORY_SEPARATOR . $file;
            if (is_file($filePath) && str_ends_with($file, '.blade.php')) {
                $name = str_replace('.blade.php', '', $file);
                $customPlaceholders[] = $name;
            }
        }
        sort($customPlaceholders);
        
        // Custom placeholder'ları placeholder types'a ekle
        if (!empty($customPlaceholders)) {
            $placeholderTypes['custom'] = [
                'label' => __('placeholder-picker.type_custom'),
                'examples' => $customPlaceholders
            ];
        }
    }
    
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
        <div class="overflow-y-auto overflow-x-hidden space-y-4" style="height: 200px; padding: 10px;overflow-y: auto;">
            <!-- Special Placeholders Section -->
            <div class="space-y-2">
                <h4 class="fi-section-header-heading text-xs font-semibold uppercase tracking-wide">
                    {{ __('placeholder-picker.special_placeholders') }}
                </h4>
                <div class="flex flex-wrap gap-2">
                    <x-filament::button
                        size="sm"
                        color="primary"
                        outlined
                        x-on:click="window.insertPlaceholder('{{ $fieldName }}', 'page.content')"
                        x-bind:tooltip="'{{ __('placeholder-picker.click_to_insert') }}'"
                    >
                        <code class="text-xs font-mono">{page.content}</code>
                    </x-filament::button>
                    <x-filament::button
                        size="sm"
                        color="primary"
                        outlined
                        x-on:click="window.insertPlaceholder('{{ $fieldName }}', 'page.title')"
                        x-bind:tooltip="'{{ __('placeholder-picker.click_to_insert') }}'"
                    >
                        <code class="text-xs font-mono">{page.title}</code>
                    </x-filament::button>
                    <x-filament::button
                        size="sm"
                        color="primary"
                        outlined
                        x-on:click="window.insertPlaceholder('{{ $fieldName }}', 'page.excerpt')"
                        x-bind:tooltip="'{{ __('placeholder-picker.click_to_insert') }}'"
                    >
                        <code class="text-xs font-mono">{page.excerpt}</code>
                    </x-filament::button>
                    <x-filament::button
                        size="sm"
                        color="primary"
                        outlined
                        x-on:click="window.insertPlaceholder('{{ $fieldName }}', 'menu')"
                        x-bind:tooltip="'{{ __('placeholder-picker.click_to_insert') }}'"
                    >
                        <code class="text-xs font-mono">{menu}</code>
                    </x-filament::button>
                    <x-filament::button
                        size="sm"
                        color="primary"
                        outlined
                        x-on:click="window.insertPlaceholder('{{ $fieldName }}', 'staticMenu')"
                        x-bind:tooltip="'{{ __('placeholder-picker.click_to_insert') }}'"
                    >
                        <code class="text-xs font-mono">{staticMenu}</code>
                    </x-filament::button>
                </div>
            </div>
            
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
                                x-on:click="window.insertPlaceholder('{{ $fieldName }}', type + '.' + example)"
                                x-bind:tooltip="'{{ __('placeholder-picker.click_to_insert') }}'"
                            >
                                <code 
                                    class="text-xs font-mono" 
                                    x-text="'{' + type + '.' + example + '}'"
                                    draggable="true"
                                    @dragstart="
                                        event.dataTransfer.setData(
                                            'text/plain', 
                                            '{' + type + '.' + example + '}'
                                        )
                                    "
                                ></code>
                            </x-filament::button>
                        </template>
                    </div>
                </div>
            </template>
            
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
        // Placeholder'ı {placeholder} formatında oluştur
        const placeholderText = '{' + placeholder + '}';
        
        // Monaco Editor instance'ını bul
        const editorContainer = document.querySelector('[data-field-name=\'' + fieldName + '\']');
        let monacoEditorInstance = null;
        
        // Monaco Editor instance'ını bul
        if (editorContainer && window.monaco && window.monaco.editor) {
            // Tüm Monaco Editor instance'larını kontrol et
            const editorInstances = window.monaco.editor.getEditors();
            for (let editor of editorInstances) {
                try {
                    const container = editor.getContainerDomNode();
                    if (container) {
                        // Container'ın parent'larını kontrol et
                        let parent = container;
                        while (parent && parent !== document.body) {
                            if (parent.hasAttribute && parent.hasAttribute('data-field-name') && 
                                parent.getAttribute('data-field-name') === fieldName) {
                                monacoEditorInstance = editor;
                                break;
                            }
                            parent = parent.parentElement;
                        }
                        
                        // Veya closest metodunu kullan
                        if (!monacoEditorInstance && container.closest) {
                            const closest = container.closest('[data-field-name=\'' + fieldName + '\']');
                            if (closest) {
                                monacoEditorInstance = editor;
                                break;
                            }
                        }
                    }
                } catch (e) {
                    console.debug('Monaco Editor container check failed:', e);
                }
            }
        }
        
        // Monaco Editor varsa, doğrudan onu kullan
        if (monacoEditorInstance) {
            const model = monacoEditorInstance.getModel();
            const currentValue = model.getValue();
            
            // Monaco Editor'ı focus et (önce focus et ki cursor pozisyonu doğru alınsın)
            monacoEditorInstance.focus();
            
            // Kısa bir delay ile cursor pozisyonunu al (focus işleminin tamamlanması için)
            setTimeout(() => {
                // Cursor pozisyonunu al (selection varsa onu kullan, yoksa cursor pozisyonunu)
                let selection = monacoEditorInstance.getSelection();
                let cursorPosition;
                
                if (selection && !selection.isEmpty()) {
                    // Seçili metin varsa, başlangıç pozisyonunu kullan
                    cursorPosition = model.getOffsetAt(selection.getStartPosition());
                } else {
                    // Seçim yoksa cursor pozisyonunu kullan
                    const position = monacoEditorInstance.getPosition();
                    if (position) {
                        cursorPosition = model.getOffsetAt(position);
                    } else {
                        // Cursor pozisyonu alınamazsa sona ekle
                        cursorPosition = currentValue.length;
                    }
                }
                
                // Placeholder'ı cursor pozisyonuna ekle
                const position = model.getPositionAt(cursorPosition);
                const range = new window.monaco.Range(
                    position.lineNumber,
                    position.column,
                    position.lineNumber,
                    position.column
                );
                
                // Edit işlemini yap
                monacoEditorInstance.executeEdits('placeholder-insert', [{
                    range: range,
                    text: placeholderText
                }]);
                
                // Cursor pozisyonunu güncelle (placeholder'ın sonuna)
                const newCursorPosition = model.getPositionAt(cursorPosition + placeholderText.length);
                monacoEditorInstance.setPosition(newCursorPosition);
                
                // Focus'u koru
                monacoEditorInstance.focus();
                
                // Filament form state'ini güncellemek için güncel değeri al
                const updatedValue = model.getValue();
                
                // Filament form state'ini güncelle
                setTimeout(() => {
                    // Hidden input'u bul ve güncelle (eğer varsa)
                    const hiddenInput = editorContainer.querySelector('input[type=\'hidden\']');
                    if (hiddenInput) {
                        hiddenInput.value = updatedValue;
                        hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
                        hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                    
                    // Filament form'unu bul ve güncelle
                    const formWireElement = editorContainer.closest('form [wire\\:id], [wire\\:id][wire\\:key*="form"]');
                    
                    if (formWireElement && window.Livewire) {
                        const wireId = formWireElement.getAttribute('wire:id');
                        const component = window.Livewire.find(wireId);
                        
                        if (component && component.get) {
                            const fieldPath = 'data.' + fieldName;
                            try {
                                if (component.get(fieldPath) !== undefined) {
                                    component.set(fieldPath, updatedValue);
                                } else if (component.get('data.html_content') !== undefined) {
                                    component.set('data.html_content', updatedValue);
                                } else if (component.get('html_content') !== undefined) {
                                    component.set('html_content', updatedValue);
                                }
                            } catch (e) {
                                console.debug('Livewire form state update skipped:', e.message);
                            }
                        }
                    }
                }, 100);
            }, 50);
            
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

