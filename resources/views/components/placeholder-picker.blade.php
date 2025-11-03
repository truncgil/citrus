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
    x-data="{ 
        showPicker: false,
        selectedType: null,
        insertPlaceholder(placeholder) {
            const placeholderText = '{' + placeholder + '}';
            
            // Monaco Editor instance'ını bul
            const editorContainer = document.querySelector('[data-field-name=\'{{ $fieldName }}\']');
            let monacoEditorInstance = null;
            let currentValue = '';
            let cursorPosition = null;
            
            // Monaco Editor'dan cursor pozisyonunu al
            if (editorContainer && window.monaco) {
                const editorInstances = window.monaco.editor.getEditors();
                for (let editor of editorInstances) {
                    const container = editor.getContainerDomNode();
                    if (container && container.closest && container.closest('[data-field-name=\'{{ $fieldName }}\']')) {
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
                // pushEditOperations kullanarak undo/redo desteği ile güncelle
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
                
                // Filament form state'ini güncellemek için Livewire component'ini bul
                // Monaco Editor değişikliği otomatik algılar ama form state'ini manuel güncelle
                setTimeout(() => {
                    // Filament CodeEditor'ın hidden input'unu bul ve güncelle
                    const hiddenInput = editorContainer.querySelector('input[type="hidden"]');
                    if (hiddenInput) {
                        hiddenInput.value = newValue;
                        hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
                        hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                    
                    // Livewire component'ini bul ve güncelle
                    const wireElement = editorContainer.closest('[wire\\:id]');
                    if (wireElement && window.Livewire) {
                        const wireId = wireElement.getAttribute('wire:id');
                        const component = window.Livewire.find(wireId);
                        
                        if (component) {
                            // Livewire 3 API: component.set() kullan
                            const fieldPath = 'data.' + '{{ $fieldName }}';
                            try {
                                // Önce mevcut değeri kontrol et
                                if (component.get(fieldPath) !== undefined) {
                                    component.set(fieldPath, newValue);
                                } else if (component.get('data.html_content') !== undefined) {
                                    component.set('data.html_content', newValue);
                                } else if (component.get('html_content') !== undefined) {
                                    component.set('html_content', newValue);
                                }
                            } catch (e) {
                                console.warn('Livewire set failed:', e);
                            }
                        }
                    }
                }, 100);
                
                return;
            }
            
            // Livewire component'ini bul ve güncelle (Monaco Editor yoksa)
            if (window.Livewire) {
                const wireElement = document.querySelector('[wire\\:id]');
                if (wireElement) {
                    const wireId = wireElement.getAttribute('wire:id');
                    const component = window.Livewire.find(wireId);
                    
                    if (component) {
                        // Mevcut değeri al
                        let fieldValue = '';
                        if (component.get('data.html_content') !== undefined) {
                            fieldValue = component.get('data.html_content') || '';
                        } else if (component.get('html_content') !== undefined) {
                            fieldValue = component.get('html_content') || '';
                        } else {
                            const fieldPath = 'data.' + '{{ $fieldName }}';
                            fieldValue = component.get(fieldPath) || '';
                        }
                        
                        // Cursor pozisyonu yoksa sona ekle
                        if (cursorPosition === null) {
                            cursorPosition = fieldValue.length;
                        }
                        
                        // Placeholder'ı cursor pozisyonuna ekle
                        const newValue = fieldValue.slice(0, cursorPosition) + placeholderText + fieldValue.slice(cursorPosition);
                        
                        // Livewire state'ini güncelle (Livewire 3 API)
                        if (component.get('data.html_content') !== undefined) {
                            component.set('data.html_content', newValue);
                        } else if (component.get('html_content') !== undefined) {
                            component.set('html_content', newValue);
                        } else {
                            component.set('data.' + '{{ $fieldName }}', newValue);
                        }
                        
                        return;
                    }
                }
            }
            
            // Fallback: Textarea veya input elementini bul
            const formField = document.querySelector(`input[name*='{{ $fieldName }}'], textarea[name*='{{ $fieldName }}']`);
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
    }"
    class="fi-input-wrp"
>
    <div class="rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
        <div 
            @click="showPicker = !showPicker"
            class="flex items-center justify-between p-3 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
        >
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('placeholder-picker.title') }}
                </span>
            </div>
            <svg 
                x-show="!showPicker"
                class="w-4 h-4 text-gray-400 transition-transform"
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
            <svg 
                x-show="showPicker"
                class="w-4 h-4 text-gray-400 transition-transform"
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
            </svg>
        </div>
        
        <div 
            x-show="showPicker"
            x-collapse
            class="border-t border-gray-200 dark:border-gray-700 max-h-96 overflow-y-auto"
        >
            <div class="p-4 space-y-4">
                @foreach($placeholderTypes as $type => $info)
                    <div class="space-y-2">
                        <h4 class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                            {{ $info['label'] }}
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($info['examples'] as $example)
                                @php
                                    $placeholder = $type . '.' . $example;
                                @endphp
                                <button
                                    type="button"
                                    @click="insertPlaceholder('{{ $placeholder }}'); showPicker = false;"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition-colors border border-gray-300 dark:border-gray-600"
                                    title="{{ __('placeholder-picker.click_to_insert') }}"
                                >
                                    <code class="text-xs">{{ '{' . $placeholder . '}' }}</code>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                
                <!-- Özel placeholder'lar -->
                <div class="pt-2 border-t border-gray-200 dark:border-gray-700">
                    <h4 class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide mb-2">
                        {{ __('placeholder-picker.special_placeholders') }}
                    </h4>
                    <div class="flex flex-wrap gap-2">
                        <button
                            type="button"
                            @click="insertPlaceholder('menu'); showPicker = false;"
                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-md bg-blue-100 hover:bg-blue-200 dark:bg-blue-900 dark:hover:bg-blue-800 text-blue-700 dark:text-blue-300 transition-colors border border-blue-300 dark:border-blue-700"
                        >
                            <code class="text-xs">{menu}</code>
                        </button>
                        <button
                            type="button"
                            @click="insertPlaceholder('staticMenu'); showPicker = false;"
                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-md bg-blue-100 hover:bg-blue-200 dark:bg-blue-900 dark:hover:bg-blue-800 text-blue-700 dark:text-blue-300 transition-colors border border-blue-300 dark:border-blue-700"
                        >
                            <code class="text-xs">{staticMenu}</code>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


