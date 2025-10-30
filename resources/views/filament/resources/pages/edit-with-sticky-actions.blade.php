@php
    $hasInlineLabels = $this->hasInlineLabels();
@endphp

<x-filament-panels::page>
    <style>
        /* Sticky Header with Actions */
        .fi-header {
            position: sticky;
            top: 0;
            z-index: 40;
            background: white;
            border-bottom: 1px solid rgb(229, 231, 235);
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .dark .fi-header {
            background: rgb(17, 24, 39);
            border-bottom-color: rgb(55, 65, 81);
        }
        
        /* Action buttons styling */
        .fi-header-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            align-items: center;
        }
        
        /* Make save button more prominent */
        .fi-header-actions button[wire\:click*="save"] {
            font-weight: 600;
        }
    </style>
    
    <form wire:submit="save">
        {{ $this->form }}
    </form>
</x-filament-panels::page>

