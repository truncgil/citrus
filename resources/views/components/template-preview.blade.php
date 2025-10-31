@php
    $previewUrl = route('template.preview');
    // Get type and fieldName from component attributes or defaults
    $type = $attributes->get('data-type') ?? 'section';
    $fieldName = $attributes->get('data-field-name') ?? 'html_content';
@endphp

<div 
    x-data="templatePreview(@js($previewUrl), @js($type), @js($fieldName))"
    class="template-preview-wrapper w-full"
    style="width: 100%;"
    wire:ignore>
    <div class="fi-fo-field-wrp-label">
        <label class="fi-fo-field-wrp-label-label text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ __('Preview') }}
        </label>
    </div>
    
    <div class="mt-2 border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden bg-white dark:bg-gray-800" 
         style="min-height: 400px; position: relative; width: 100%;">
        <!-- Loading indicator -->
        <div 
            x-show="isLoading || !iframeSrc" 
            class="absolute inset-0 flex items-center justify-center bg-gray-50 dark:bg-gray-900"
            style="z-index: 10;"
            x-transition>
            <div class="text-center">
                <svg class="animate-spin h-8 w-8 text-gray-400 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    <span x-show="isLoading">Yükleniyor...</span>
                    <span x-show="!isLoading && !iframeSrc">Önizleme için içerik girin</span>
                </p>
            </div>
        </div>
        
        <!-- Preview iframe -->
        <iframe 
            x-show="!isLoading && iframeSrc"
            :src="iframeSrc"
            class="w-full border-0"
            style="min-height: 400px; width: 100%; display: block;"
            frameborder="0"
            loading="lazy"
            x-transition>
        </iframe>
    </div>
    
    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
        {{ __('Önizleme gerçek zamanlı olarak güncellenir') }}
    </p>
</div>

@push('scripts')
<script>
function templatePreview(previewUrl, type, fieldName) {
    return {
        previewUrl: previewUrl,
        type: type,
        fieldName: fieldName,
        iframeSrc: '',
        isLoading: false,
        content: '',
        debounceTimer: null,
        
        init() {
            // Watch Livewire events for Filament form updates
            if (window.Livewire) {
                // Listen for form state updates
                Livewire.on('filament-forms::update-state', ({ statePath, state }) => {
                    if (statePath === this.fieldName || statePath?.endsWith(this.fieldName)) {
                        this.content = state || '';
                        this.debouncedUpdate();
                    }
                });
                
                // Listen for any Livewire updates
                document.addEventListener('livewire:update', () => {
                    this.debouncedUpdate();
                });
            }
            
            // Watch CodeMirror editor directly
            this.watchCodeMirror();
            
            // Watch for direct input changes (fallback for code editor)
            const observer = new MutationObserver(() => {
                this.debouncedUpdate();
            });
            
            // Observe form changes
            const form = document.querySelector('form[wire\\:submit]');
            if (form) {
                observer.observe(form, {
                    childList: true,
                    subtree: true,
                    characterData: true,
                });
            }
            
            // Initial update after a short delay
            setTimeout(() => {
                this.updatePreview();
            }, 1000);
            
            // Periodic update fallback (every 3 seconds)
            this.intervalId = setInterval(() => {
                this.updatePreview();
            }, 3000);
        },
        
        watchCodeMirror() {
            // Try to find CodeMirror editor instance
            const findCodeMirror = () => {
                // Look for CodeMirror editor instances
                const editors = document.querySelectorAll('.cm-editor, [data-code-editor]');
                editors.forEach(editor => {
                    // Check if this is our field
                    const fieldWrapper = editor.closest('[data-field-name], .fi-fo-field-wrp');
                    if (fieldWrapper) {
                        const fieldLabel = fieldWrapper.querySelector('label');
                        if (fieldLabel && fieldLabel.textContent.includes('HTML Content')) {
                            // Found our editor, try to get CodeMirror instance
                            const cmInstance = editor.__cm || editor.cm || editor;
                            if (cmInstance && cmInstance.getValue) {
                                // Watch for changes
                                if (cmInstance.on) {
                                    cmInstance.on('change', () => {
                                        this.content = cmInstance.getValue();
                                        this.debouncedUpdate();
                                    });
                                }
                            }
                        }
                    }
                });
            };
            
            // Try immediately and after a delay
            findCodeMirror();
            setTimeout(findCodeMirror, 1000);
            setTimeout(findCodeMirror, 2000);
        },
        
        debouncedUpdate() {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.updatePreview();
            }, 500); // 500ms debounce
        },
        
        async updatePreview() {
            // Get content from Livewire - try different methods
            let content = this.content || '';
            
            try {
                // Method 1: Try CodeMirror editor directly (most reliable for CodeEditor)
                // Find editor by data-field-name attribute
                const fieldWrapper = document.querySelector(`[data-field-name="${this.fieldName}"]`);
                if (fieldWrapper) {
                    const cmEditor = fieldWrapper.querySelector('.cm-editor');
                    if (cmEditor) {
                        const cmInstance = cmEditor.__cm || cmEditor.cm || window.CodeMirror?.fromTextArea?.(cmEditor.querySelector('textarea'));
                        if (cmInstance && typeof cmInstance.getValue === 'function') {
                            content = cmInstance.getValue() || '';
                        } else if (cmEditor.querySelector('.cm-content')) {
                            // Fallback: get text from content div
                            content = cmEditor.querySelector('.cm-content').textContent || '';
                        }
                    }
                }
                
                // Method 1b: Try all CodeMirror editors if specific one not found
                if (!content) {
                    const cmEditors = document.querySelectorAll('.cm-editor');
                    for (const cmEditor of cmEditors) {
                        const fieldWrapper = cmEditor.closest('[data-field-name]');
                        if (fieldWrapper && fieldWrapper.getAttribute('data-field-name') === this.fieldName) {
                            const cmInstance = cmEditor.__cm || cmEditor.cm;
                            if (cmInstance && typeof cmInstance.getValue === 'function') {
                                content = cmInstance.getValue() || '';
                                if (content) break;
                            } else if (cmEditor.querySelector('.cm-content')) {
                                content = cmEditor.querySelector('.cm-content').textContent || '';
                                if (content) break;
                            }
                        }
                    }
                }
                
                // Method 2: Try to find CodeEditor textarea/input directly
                if (!content) {
                    const codeEditor = document.querySelector(`textarea[name="${this.fieldName}"], 
                        textarea[wire\\:model*="${this.fieldName}"],
                        .fi-fo-field-wrp textarea,
                        .cm-content`);
                    
                    if (codeEditor) {
                        content = codeEditor.value || codeEditor.textContent || '';
                    }
                }
                
                // Method 3: Try Livewire $wire
                if (!content && window.Livewire) {
                    // Find the Livewire component
                    const livewireComponent = document.querySelector('[wire\\:id], form[wire\\:submit]');
                    if (livewireComponent) {
                        const wireId = livewireComponent.getAttribute('wire:id');
                        if (wireId) {
                            const livewire = window.Livewire.find(wireId);
                            if (livewire && livewire.get) {
                                content = livewire.get(this.fieldName) || '';
                            }
                        } else {
                            // Try Alpine.js $wire
                            const alpineData = Alpine.$data(livewireComponent);
                            if (alpineData && alpineData.$wire && alpineData.$wire.get) {
                                content = alpineData.$wire.get(this.fieldName) || '';
                            }
                        }
                    }
                }
            } catch (e) {
                console.warn('Could not get content:', e);
            }
            
            // Use existing content if new fetch failed
            if (!content && this.content) {
                content = this.content;
            }
            
            this.content = content;
            
            if (!this.content || this.content.trim() === '') {
                if (this.iframeSrc) {
                    URL.revokeObjectURL(this.iframeSrc);
                    this.iframeSrc = '';
                }
                return;
            }
            
            this.isLoading = true;
            
            try {
                // Create form data
                const formData = new FormData();
                formData.append('content', this.content);
                formData.append('type', this.type);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '');
                
                // Fetch preview HTML
                const response = await fetch(this.previewUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html',
                    }
                });
                
                if (!response.ok) {
                    throw new Error('Preview request failed');
                }
                
                const html = await response.text();
                
                // Create blob URL for iframe
                const blob = new Blob([html], { type: 'text/html; charset=utf-8' });
                
                // Revoke old URL if exists
                if (this.iframeSrc) {
                    URL.revokeObjectURL(this.iframeSrc);
                }
                
                this.iframeSrc = URL.createObjectURL(blob);
                this.isLoading = false;
            } catch (error) {
                console.error('Preview error:', error);
                this.isLoading = false;
            }
        }
    };
}
</script>
@endpush

