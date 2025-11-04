{{-- Sticky Header CSS --}}
<style>
    /* Header'ı sticky yap */
    .fi-topbar {
        position: sticky !important;
        top: 0 !important;
        z-index: 40 !important;
        background: white !important;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1) !important;
    }
    
    /* Dark mode için */
    .dark .fi-topbar {
        background: rgb(17 24 39) !important;
    }
    
    /* Page header'ı da sticky yap */
    .fi-header {
        position: sticky !important;
        top: 0 !important;
        z-index: 39 !important;
        background: white !important;
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1) !important;
    }
    
    /* Dark mode için */
    .dark .fi-header {
        background: rgb(17 24 39) !important;
    }
    
    /* Sidebar varsa topbar'ın pozisyonunu ayarla */
    @media (min-width: 1024px) {
        .fi-sidebar-open .fi-topbar {
            left: 0 !important;
        }
    }
</style>

@if($autoSaveEnabled)
{{-- Otomatik Kaydetme Script --}}
<div x-data="{
    autoSaveInterval: null,
    init() {
        // Her 30 saniyede bir otomatik kaydet
        this.autoSaveInterval = setInterval(() => {
            $wire.autoSave();
        }, 30000); // 30 saniye (30000 ms)
    },
    destroy() {
        // Sayfa kapanırken interval'i temizle
        if (this.autoSaveInterval) {
            clearInterval(this.autoSaveInterval);
        }
    }
}" class="hidden">
    <!-- Otomatik kaydetme aktif: Her 30 saniyede bir -->
</div>
@endif

