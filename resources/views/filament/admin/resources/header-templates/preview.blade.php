<div class="w-full flex flex-col" style="height: 600px;">
    <div class="flex-1 w-full relative bg-white border rounded-lg overflow-hidden">
        <iframe 
            src="{{ route('template.preview', ['type' => 'header', 'record_id' => $record->id]) }}" 
            class="w-full h-full absolute inset-0 border-0"
            style="width: 100%; height: 100%;"
            title="Preview"
        ></iframe>
    </div>
</div>

