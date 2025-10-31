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
    
    <div class="mt-2 flex items-center justify-end gap-2 mb-2">
        <button
            @click="openFullscreenEditor()"
            class="fi-btn fi-btn-color-gray fi-btn-size-sm inline-flex items-center justify-center rounded-lg font-semibold outline-none transition duration-75 focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-70 bg-gray-600 text-white hover:bg-gray-500 dark:bg-gray-500 dark:hover:bg-gray-400 p-2"
            type="button"
            title="Tam Ekran Editörü Aç">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
            </svg>
        </button>
        <button
            @click="updatePreview()"
            :disabled="isLoading"
            class="fi-btn fi-btn-color-primary fi-btn-size-sm inline-flex items-center justify-center rounded-lg font-semibold outline-none transition duration-75 focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-70 bg-primary-600 text-white hover:bg-primary-500 dark:bg-primary-500 dark:hover:bg-primary-400 p-2"
            type="button"
            title="Önizlemeyi Çalıştır">
            <svg x-show="!isLoading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <svg x-show="isLoading" class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
        </button>
    </div>
    
    <div class="border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden bg-white dark:bg-gray-800" 
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
                <div class="relative inline-block mb-4" x-show="isLoading">
                    <div class="w-16 h-16 border-4 border-gray-200 dark:border-gray-700 rounded-full animate-pulse"></div>
                    <div class="absolute top-0 left-0 w-16 h-16 border-4 border-transparent border-t-primary-600 dark:border-t-primary-400 rounded-full animate-spin"></div>
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
    
    <!-- Fullscreen Editor Modal (CodePen Style) -->
    <div 
        x-show="isFullscreen"
        x-cloak
        class="fixed inset-0 z-[9999] bg-gray-900 dark:bg-gray-950"
        style="display: none;"
        x-transition
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        
        <!-- Top Toolbar -->
        <div class="absolute top-0 left-0 right-0 z-10 bg-gray-800 dark:bg-gray-900 border-b border-gray-700 dark:border-gray-800 px-4 py-2 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <h3 class="text-white font-semibold text-sm">HTML Editör & Önizleme</h3>
            </div>
            <div class="flex items-center gap-2">
                <button
                    @click="toggleEditorCollapse()"
                    class="px-3 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-700 dark:hover:bg-gray-800 rounded transition"
                    type="button">
                    <svg x-show="!editorCollapsed" class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                    <svg x-show="editorCollapsed" class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                    <span class="ml-1" x-text="editorCollapsed ? 'Editörü Göster' : 'Editörü Gizle'"></span>
                </button>
                <button
                    @click="updatePreview()"
                    :disabled="isLoading"
                    class="p-2 bg-primary-600 hover:bg-primary-500 text-white rounded transition disabled:opacity-50"
                    type="button"
                    title="Önizlemeyi Çalıştır">
                    <svg x-show="!isLoading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <svg x-show="isLoading" class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
                <button
                    @click="closeFullscreenEditor()"
                    class="px-3 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-700 dark:hover:bg-gray-800 rounded transition"
                    type="button">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Editor Section (Collapsible) -->
        <div 
            class="absolute left-0 right-0 transition-all duration-300 ease-in-out overflow-hidden"
            :class="editorCollapsed ? 'top-0 h-0' : 'top-10 h-[40vh]'"
            style="background: #1e1e1e;">
            <div 
                class="h-full w-full"
                id="fullscreen-code-editor"
                style="min-height: 100%;">
                <!-- CodeMirror editor will be cloned here -->
            </div>
        </div>
        
        <!-- Preview Section (Takes remaining space) -->
        <div 
            class="absolute left-0 right-0 transition-all duration-300 ease-in-out"
            :class="editorCollapsed ? 'top-0 h-full' : 'top-[calc(40vh+2.5rem)] h-[calc(100vh-40vh-2.5rem)]'"
            style="background: white;">
            
            <!-- Loading indicator -->
            <div 
                x-show="isLoading || !fullscreenIframeSrc" 
                class="absolute inset-0 flex items-center justify-center bg-gray-100 dark:bg-gray-900"
                style="z-index: 5;"
                x-transition>
                <div class="text-center px-4">
                    <div class="relative inline-block mb-4" x-show="isLoading">
                        <div class="w-16 h-16 border-4 border-gray-200 dark:border-gray-700 rounded-full animate-pulse"></div>
                        <div class="absolute top-0 left-0 w-16 h-16 border-4 border-transparent border-t-primary-600 dark:border-t-primary-400 rounded-full animate-spin"></div>
                    </div>
                </div>
            </div>
            
            <!-- Preview iframe -->
            <iframe 
                x-show="!isLoading && fullscreenIframeSrc"
                :src="fullscreenIframeSrc"
                class="w-full h-full border-0"
                frameborder="0"
                x-transition>
            </iframe>
        </div>
    </div>
  
</div>

@push('scripts')
<script>
function templatePreview(previewUrl, type, fieldName) {
    return {
        previewUrl: previewUrl,
        type: type,
        fieldName: fieldName,
        iframeSrc: '',
        fullscreenIframeSrc: '',
        isLoading: false,
        content: '',
        codeMirrorView: null,
        isFullscreen: false,
        editorCollapsed: false,
        clonedEditor: null,
        originalEditorWrapper: null,
        
        init() {
            console.log('[Preview] Init:', { previewUrl, type, fieldName });
            
            // Wait for everything to load
            this.$nextTick(() => {
                setTimeout(() => {
                    this.findCodeMirror();
                }, 1500);
            });
            
            // ESC key to close fullscreen
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.isFullscreen) {
                    this.closeFullscreenEditor();
                }
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
                    
                    // Get initial content (no watcher, only on demand)
                    this.content = cmContent.textContent || '';
                    console.log('[Preview] Initial content from .cm-content, length:', this.content.length);
                    
                    // Watch for content changes to update internal content variable
                    // but don't trigger preview update automatically
                    const observer = new MutationObserver(() => {
                        const newContent = cmContent.textContent || '';
                        if (newContent !== this.content) {
                            this.content = newContent;
                            console.log('[Preview] Content changed, length:', this.content.length);
                            // Don't auto-update, wait for Run button
                        }
                    });
                    observer.observe(cmContent, {
                        childList: true,
                        subtree: true,
                        characterData: true,
                    });
                    
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
                            // Watch for changes to update internal content variable
                            // but don't trigger preview update automatically
                            const originalDispatch = view.dispatch;
                            view.dispatch = (tr) => {
                                originalDispatch.call(view, tr);
                                this.content = view.state.doc.toString();
                                // Don't auto-update, wait for Run button
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
                            // Don't auto-update, wait for Run button
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
                        // Don't auto-update, wait for Run button
                    });
                    console.log('[Preview] Textarea content length:', this.content.length);
                } else {
                    console.warn('[Preview] No CodeMirror editor or textarea found in wrapper');
                }
            }
        },
        
        async updatePreview() {
            // Refresh content from editor before updating
            this.findCodeMirror();
            
            // Give a moment for content to be refreshed
            await new Promise(resolve => setTimeout(resolve, 100));
            
            if (!this.content || !this.content.trim()) {
                console.log('[Preview] No content, skipping update');
                if (this.iframeSrc) {
                    URL.revokeObjectURL(this.iframeSrc);
                    this.iframeSrc = '';
                }
                if (this.fullscreenIframeSrc) {
                    URL.revokeObjectURL(this.fullscreenIframeSrc);
                    this.fullscreenIframeSrc = '';
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
                
                // Update both iframes
                if (this.iframeSrc) {
                    URL.revokeObjectURL(this.iframeSrc);
                }
                if (this.fullscreenIframeSrc) {
                    URL.revokeObjectURL(this.fullscreenIframeSrc);
                }
                
                const blob = new Blob([html], { type: 'text/html; charset=utf-8' });
                this.iframeSrc = URL.createObjectURL(blob);
                this.fullscreenIframeSrc = URL.createObjectURL(blob);
                this.isLoading = false;
                
                console.log('[Preview] Updated successfully, content length:', this.content.length);
            } catch (error) {
                console.error('[Preview] Error:', error);
                this.isLoading = false;
            }
        },
        
        openFullscreenEditor() {
            this.isFullscreen = true;
            this.editorCollapsed = false;
            
            this.$nextTick(() => {
                setTimeout(() => {
                    this.cloneEditorToFullscreen();
                }, 100);
            });
        },
        
        closeFullscreenEditor() {
            // Restore original editor if it was moved
            if (this.clonedEditor && this.originalEditorWrapper) {
                const editorContainer = this.clonedEditor.parentElement;
                if (editorContainer && editorContainer.id === 'fullscreen-code-editor') {
                    // Move editor back to original location
                    const cmEditor = this.clonedEditor.querySelector('.cm-editor');
                    if (cmEditor && this.originalEditorWrapper) {
                        // Restore to original wrapper
                        const originalContainer = this.originalEditorWrapper.querySelector('.cm-editor').parentElement;
                        if (originalContainer) {
                            // Keep the editor where it is, just clean up
                            this.clonedEditor = null;
                            this.originalEditorWrapper = null;
                        }
                    }
                }
            }
            
            this.isFullscreen = false;
            this.editorCollapsed = false;
            
            // Clean up fullscreen iframe
            if (this.fullscreenIframeSrc) {
                URL.revokeObjectURL(this.fullscreenIframeSrc);
                this.fullscreenIframeSrc = '';
            }
        },
        
        toggleEditorCollapse() {
            this.editorCollapsed = !this.editorCollapsed;
        },
        
        cloneEditorToFullscreen() {
            const fullscreenContainer = document.getElementById('fullscreen-code-editor');
            if (!fullscreenContainer) {
                console.error('[Preview] Fullscreen container not found');
                return;
            }
            
            // Find the original CodeMirror editor
            const wrapperSelectors = ['.fi-fo-field-wrp', '.fi-input-wrp', '[wire\\:id]'];
            let targetWrapper = null;
            
            const dataFieldElements = document.querySelectorAll(`[data-field-name="${this.fieldName}"]`);
            if (dataFieldElements.length > 0) {
                for (const selector of wrapperSelectors) {
                    targetWrapper = dataFieldElements[0].closest(selector);
                    if (targetWrapper) break;
                }
            }
            
            if (!targetWrapper) {
                const input = document.querySelector(`textarea[name="${this.fieldName}"], input[name="${this.fieldName}"]`);
                if (input) {
                    for (const selector of wrapperSelectors) {
                        targetWrapper = input.closest(selector);
                        if (targetWrapper) break;
                    }
                }
            }
            
            if (!targetWrapper) {
                const cmEditor = document.querySelector('.cm-editor');
                if (cmEditor) {
                    for (const selector of wrapperSelectors) {
                        targetWrapper = cmEditor.closest(selector);
                        if (targetWrapper) break;
                    }
                }
            }
            
            if (!targetWrapper) {
                console.error('[Preview] Could not find editor wrapper');
                return;
            }
            
            this.originalEditorWrapper = targetWrapper;
            
            // Find the CodeMirror editor element
            const cmEditor = targetWrapper.querySelector('.cm-editor');
            if (!cmEditor) {
                console.error('[Preview] CodeMirror editor not found');
                return;
            }
            
            // Clone the entire editor structure
            const editorParent = cmEditor.parentElement;
            if (!editorParent) {
                console.error('[Preview] Editor parent not found');
                return;
            }
            
            // Create a deep clone
            const clone = editorParent.cloneNode(true);
            clone.id = 'cloned-editor';
            
            // Clear the container first
            fullscreenContainer.innerHTML = '';
            
            // Append clone
            fullscreenContainer.appendChild(clone);
            
            this.clonedEditor = clone;
            
            // Adjust styles for fullscreen
            const clonedCmEditor = clone.querySelector('.cm-editor');
            if (clonedCmEditor) {
                clonedCmEditor.style.height = '100%';
                clonedCmEditor.style.minHeight = '100%';
                
                // Make the cm-scroller take full height
                const cmScroller = clonedCmEditor.querySelector('.cm-scroller');
                if (cmScroller) {
                    cmScroller.style.height = '100%';
                    cmScroller.style.minHeight = '100%';
                }
                
                // Make the cm-content take full height
                const cmContent = clonedCmEditor.querySelector('.cm-content');
                if (cmContent) {
                    cmContent.style.minHeight = '100%';
                }
            }
            
            // Update content watcher for cloned editor
            const clonedCmContent = clone.querySelector('.cm-content');
            if (clonedCmContent) {
                // Watch for changes in cloned editor
                const observer = new MutationObserver(() => {
                    const newContent = clonedCmContent.textContent || '';
                    if (newContent !== this.content) {
                        this.content = newContent;
                        // Also update original editor if it exists
                        const originalCmContent = cmEditor.querySelector('.cm-content');
                        if (originalCmContent) {
                            // Sync back to original if needed
                        }
                    }
                });
                observer.observe(clonedCmContent, {
                    childList: true,
                    subtree: true,
                    characterData: true,
                });
                
                // Update content from cloned editor
                this.content = clonedCmContent.textContent || '';
            }
            
            // Try to sync CodeMirror 6 view if available
            if (clonedCmEditor) {
                if (clonedCmEditor.view || clonedCmEditor._view) {
                    const view = clonedCmEditor.view || clonedCmEditor._view;
                    if (view.state && view.state.doc) {
                        // Watch for changes
                        if (view.dispatch) {
                            const originalDispatch = view.dispatch;
                            view.dispatch = (tr) => {
                                originalDispatch.call(view, tr);
                                this.content = view.state.doc.toString();
                            };
                        }
                    }
                }
            }
            
            console.log('[Preview] Editor cloned to fullscreen');
        },
        
        destroy() {
            if (this.iframeSrc) {
                URL.revokeObjectURL(this.iframeSrc);
            }
            if (this.fullscreenIframeSrc) {
                URL.revokeObjectURL(this.fullscreenIframeSrc);
            }
            if (this.isFullscreen) {
                this.closeFullscreenEditor();
            }
        }
    };
}
</script>
@endpush

@push('styles')
<style>
    [x-cloak] {
        display: none !important;
    }
    
    /* Fullscreen editor styles */
    #fullscreen-code-editor {
        font-family: 'Fira Code', 'Consolas', 'Monaco', monospace;
    }
    
    #fullscreen-code-editor .cm-editor {
        font-size: 14px;
        line-height: 1.6;
    }
    
    #fullscreen-code-editor .cm-content {
        padding: 1rem;
    }
    
    /* Smooth transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
@endpush
