@php
    $previewUrl = route('template.preview');
    $type = $type ?? 'section';
    $fieldName = $fieldName ?? 'html_content';
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
    
    <div class="fi-section-content">
        
        <button
            @click="updatePreview()"
            :disabled="isLoading"
            class="fi-btn fi-btn-color-primary fi-btn-size-sm inline-flex items-center justify-center rounded-lg font-semibold outline-none transition duration-75 focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-70 bg-primary-600 text-white hover:bg-primary-500 dark:bg-primary-500 dark:hover:bg-primary-400 p-2"
            type="button"
            title="Önizlemeyi Çalıştır">
            <svg  class="fi-icon fi-size-lg fi-sidebar-item-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                <!-- Play icon (Heroicon solid play) -->
                <path fill-rule="evenodd" d="M5.25 4.5v15a1.125 1.125 0 0 0 1.666.974l12-7.5a1.125 1.125 0 0 0 0-1.948l-12-7.5A1.125 1.125 0 0 0 5.25 4.5zm1.875 1.99 10.178 6.36-10.179 6.36V6.491z" clip-rule="evenodd"></path>
            </svg>
           
        </button>
    </div>
    
    <div class="border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden bg-white dark:bg-gray-800" 
         style="min-height: 400px; position: relative; width: 100%;margin-top: 10px;">
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
        recordId: null,
        
        init() {
            // URL'den ID'yi al
            const urlMatch = window.location.pathname.match(/\/(\d+)\/(edit|view)$/);
            if (urlMatch && urlMatch[1]) {
                this.recordId = urlMatch[1];
            }
        },
        
        async updatePreview() {
            // ID yoksa preview yapma
            if (!this.recordId) {
                console.log('[Preview] No record ID');
                return;
            }
            
            this.isLoading = true;
            
            try {
                const formData = new FormData();
                formData.append('record_id', this.recordId);
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
                
                if (this.iframeSrc) URL.revokeObjectURL(this.iframeSrc);
                
                const blob = new Blob([html], { type: 'text/html; charset=utf-8' });
                this.iframeSrc = URL.createObjectURL(blob);
                this.isLoading = false;
            } catch (error) {
                console.error('[Preview] Error:', error);
                this.isLoading = false;
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
</style>
@endpush

