@php
    $previewUrl = route('template.preview');
    $type = $attributes->get('data-type') ?? 'section';
    $fieldName = $attributes->get('data-field-name') ?? 'html_content';
@endphp

<div 
    x-data="templatePreview(@js($previewUrl), @js($type), @js($fieldName))"
    class="template-preview-wrapper w-full"
    style="width: 100%;"
    wire:ignore.self>
    <div class="fi-fo-field-wrp-label">
        <label class="fi-fo-field-wrp-label-label text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ __('Preview') }}
        </label>
    </div>
    
    <div class="mt-2 border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden bg-white dark:bg-gray-800" 
         style="min-height: 400px; position: relative; width: 100%;">
        <!-- Loading indicator with modern preloader -->
        <div 
            x-show="isLoading || !iframeSrc" 
            class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800"
            style="z-index: 10;"
            x-transition
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            <div class="text-center px-4">
                <!-- Modern animated loader -->
                <div class="relative inline-block mb-4">
                    <div class="w-16 h-16 border-4 border-gray-200 dark:border-gray-700 rounded-full animate-pulse"></div>
                    <div class="absolute top-0 left-0 w-16 h-16 border-4 border-transparent border-t-primary-600 dark:border-t-primary-400 rounded-full animate-spin"></div>
                </div>
                <div class="space-y-2">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300 animate-pulse">
                        <span x-show="isLoading">Yükleniyor...</span>
                        <span x-show="!isLoading && !iframeSrc">Önizleme hazırlanıyor</span>
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        <span x-show="isLoading">İçerik işleniyor</span>
                        <span x-show="!isLoading && !iframeSrc">Önizleme için HTML içeriği girin</span>
                    </p>
                </div>
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
        intervalId: null,
        codeMirrorView: null,
        
        init() {
            console.log('[Preview] Init:', { previewUrl, type, fieldName });
            
            // Wait for everything to load
            this.$nextTick(() => {
                setTimeout(() => {
                    this.findCodeMirror();
                    this.setupWatchers();
                    this.updatePreview();
                }, 1500);
            });
        },
        
        findCodeMirror() {
            console.log('[Preview] Looking for CodeMirror editor for field:', this.fieldName);
            
            // Try multiple wrapper selectors for Filament 4 compatibility
            const wrapperSelectors = [
                '.fi-fo-field-wrp',
                '.fi-input-wrp',
                '[wire\\:id]',
            ];
            
            // Debug: List all field wrappers
            let allWrappers = [];
            wrapperSelectors.forEach(selector => {
                const wrappers = document.querySelectorAll(selector);
                if (wrappers.length > 0) {
                    console.log(`[Preview] Found ${wrappers.length} wrappers with selector: ${selector}`);
                    allWrappers = Array.from(wrappers);
                }
            });
            
            // Remove duplicates
            allWrappers = Array.from(new Set(allWrappers));
            console.log('[Preview] Total unique field wrappers found:', allWrappers.length);
            
            let targetWrapper = null;
            
            // Method 1: Find by data-field-name attribute (anywhere in wrapper)
            const dataFieldElements = document.querySelectorAll(`[data-field-name="${this.fieldName}"]`);
            if (dataFieldElements.length > 0) {
                console.log('[Preview] Found', dataFieldElements.length, 'elements with data-field-name');
                // Try to find closest wrapper from any selector
                for (const selector of wrapperSelectors) {
                    targetWrapper = dataFieldElements[0].closest(selector);
                    if (targetWrapper) break;
                }
            }
            
            // Method 2: Find by name attribute in textarea or input
            if (!targetWrapper) {
                const input = document.querySelector(`textarea[name="${this.fieldName}"], input[name="${this.fieldName}"]`);
                if (input) {
                    console.log('[Preview] Found input/textarea with name:', this.fieldName);
                    for (const selector of wrapperSelectors) {
                        targetWrapper = input.closest(selector);
                        if (targetWrapper) break;
                    }
                }
            }
            
            // Method 3: Find all CodeMirror editors and check their wrappers
            if (!targetWrapper) {
                const cmEditors = document.querySelectorAll('.cm-editor');
                console.log('[Preview] Found', cmEditors.length, 'CodeMirror editors');
                cmEditors.forEach((cmEditor, idx) => {
                    for (const selector of wrapperSelectors) {
                        const wrapper = cmEditor.closest(selector);
                        if (wrapper) {
                            const label = wrapper.querySelector('label');
                            console.log(`[Preview] CM Editor ${idx} wrapper label:`, label?.textContent?.substring(0, 30));
                            
                            // If this is the only CodeMirror editor, use it
                            // Or if label contains HTML/Content
                            if (cmEditors.length === 1 || (label && (label.textContent.toLowerCase().includes('html') || label.textContent.toLowerCase().includes('content')))) {
                                if (!targetWrapper) {
                                    targetWrapper = wrapper;
                                    console.log('[Preview] Selected wrapper for CM Editor', idx);
                                }
                            }
                            break;
                        }
                    }
                });
            }
            
            // Method 4: Find by label text (fallback)
            if (!targetWrapper && allWrappers.length > 0) {
                allWrappers.forEach((wrapper) => {
                    const label = wrapper.querySelector('label');
                    if (label) {
                        const labelText = label.textContent.toLowerCase();
                        if ((labelText.includes('html') || labelText.includes('content')) && !targetWrapper) {
                            const hasEditor = wrapper.querySelector('.cm-editor, textarea');
                            if (hasEditor) {
                                targetWrapper = wrapper;
                                console.log('[Preview] Selected wrapper by label:', labelText.substring(0, 30));
                            }
                        }
                    }
                });
            }
            
            if (!targetWrapper) {
                console.warn('[Preview] Field wrapper not found. Available wrappers:', allWrappers.length);
                console.warn('[Preview] Trying to find any CodeMirror editor...');
                
                // Last resort: Use first CodeMirror editor found
                const firstCmEditor = document.querySelector('.cm-editor');
                if (firstCmEditor) {
                    for (const selector of wrapperSelectors) {
                        targetWrapper = firstCmEditor.closest(selector);
                        if (targetWrapper) break;
                    }
                    console.log('[Preview] Using first CodeMirror editor as fallback');
                }
            }
            
            if (!targetWrapper) {
                console.error('[Preview] Could not find field wrapper. Make sure the CodeEditor is rendered.');
                return;
            }
            
            console.log('[Preview] Found field wrapper');
            
            // Try to find CodeMirror editor
            const cmEditor = targetWrapper.querySelector('.cm-editor');
            if (cmEditor) {
                console.log('[Preview] Found .cm-editor element');
                
                // Try to get from cm-content (CodeMirror 6)
                const cmContent = cmEditor.querySelector('.cm-content');
                if (cmContent) {
                    console.log('[Preview] Found .cm-content element');
                    
                    // Watch for changes
                    const observer = new MutationObserver(() => {
                        const newContent = cmContent.textContent || '';
                        if (newContent !== this.content) {
                            this.content = newContent;
                            console.log('[Preview] Content changed, length:', this.content.length);
                            this.debouncedUpdate();
                        }
                    });
                    observer.observe(cmContent, {
                        childList: true,
                        subtree: true,
                        characterData: true,
                    });
                    
                    // Get initial content
                    this.content = cmContent.textContent || '';
                    console.log('[Preview] Initial content from .cm-content, length:', this.content.length);
                    
                    if (this.content) {
                        return; // Success!
                    }
                }
                
                // Try CodeMirror 6 View
                if (cmEditor.view || cmEditor._view) {
                    const view = cmEditor.view || cmEditor._view;
                    if (view.state && view.state.doc) {
                        this.content = view.state.doc.toString();
                        console.log('[Preview] Found CodeMirror 6 View, content length:', this.content.length);
                        
                        if (view.dispatch) {
                            // Watch for changes
                            const originalDispatch = view.dispatch;
                            view.dispatch = (tr) => {
                                originalDispatch.call(view, tr);
                                this.content = view.state.doc.toString();
                                this.debouncedUpdate();
                            };
                        }
                        
                        if (this.content) {
                            return; // Success!
                        }
                    }
                }
                
                // Try CodeMirror 5
                const cmInstance = cmEditor.__cm || cmEditor.cm;
                if (cmInstance) {
                    console.log('[Preview] Found CodeMirror 5 instance');
                    if (cmInstance.getValue) {
                        this.content = cmInstance.getValue();
                        cmInstance.on('change', () => {
                            this.content = cmInstance.getValue();
                            this.debouncedUpdate();
                        });
                        console.log('[Preview] CodeMirror 5 content length:', this.content.length);
                        if (this.content) {
                            return; // Success!
                        }
                    }
                }
            } else {
                // Try textarea
                const textarea = targetWrapper.querySelector('textarea');
                if (textarea) {
                    console.log('[Preview] Found textarea');
                    this.content = textarea.value || '';
                    textarea.addEventListener('input', () => {
                        this.content = textarea.value;
                        this.debouncedUpdate();
                    });
                    console.log('[Preview] Textarea content length:', this.content.length);
                } else {
                    console.warn('[Preview] No CodeMirror editor or textarea found in wrapper');
                }
            }
        },
        
        setupWatchers() {
            // Watch for Livewire updates
            if (window.Livewire) {
                document.addEventListener('livewire:update', () => {
                    this.findCodeMirror();
                    this.debouncedUpdate();
                });
            }
            
            // Periodic update
            this.intervalId = setInterval(() => {
                this.findCodeMirror();
                this.updatePreview();
            }, 3000);
        },
        
        debouncedUpdate() {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.updatePreview();
            }, 800);
        },
        
        async updatePreview() {
            // Try to refresh content
            if (!this.content) {
                this.findCodeMirror();
            }
            
            if (!this.content || !this.content.trim()) {
                console.log('[Preview] No content, skipping update');
                if (this.iframeSrc) {
                    URL.revokeObjectURL(this.iframeSrc);
                    this.iframeSrc = '';
                }
                return;
            }
            
            this.isLoading = true;
            
            try {
                const formData = new FormData();
                formData.append('content', this.content);
                formData.append('type', this.type);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '');
                
                const response = await fetch(this.previewUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html',
                    }
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }
                
                const html = await response.text();
                
                if (this.iframeSrc) {
                    URL.revokeObjectURL(this.iframeSrc);
                }
                
                const blob = new Blob([html], { type: 'text/html; charset=utf-8' });
                this.iframeSrc = URL.createObjectURL(blob);
                this.isLoading = false;
                
                console.log('[Preview] Updated successfully, content length:', this.content.length);
            } catch (error) {
                console.error('[Preview] Error:', error);
                this.isLoading = false;
            }
        },
        
        destroy() {
            if (this.intervalId) {
                clearInterval(this.intervalId);
            }
            if (this.debounceTimer) {
                clearTimeout(this.debounceTimer);
            }
            if (this.iframeSrc) {
                URL.revokeObjectURL(this.iframeSrc);
            }
        }
    };
}
</script>
@endpush
