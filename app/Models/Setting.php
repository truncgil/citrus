<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'key',
        'value',
        'value_text',
        'value_boolean',
        'value_file',
        'value_date',
        'value_datetime',
        'value_array',
        'value_color_picker',
        'value_code_editor',
        'value_rich_editor',
        'value_markdown_editor',
        'value_tags_input',
        'value_checkbox_list',
        'value_radio',
        'value_toggle_buttons',
        'value_slider',
        'value_key_value',
        'type',
        'group',
        'label',
        'description',
        'is_public',
        'is_active',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Set value from different field names
     */
    public function setValueTextAttribute($value)
    {
        $this->attributes['value'] = $value;
    }

    /**
     * Set value from different field names
     */
    public function setValueBooleanAttribute($value)
    {
        $this->attributes['value'] = $value ? '1' : '0';
    }

    /**
     * Set value from different field names
     */
    public function setValueFileAttribute($value)
    {
        // Filament bazen dosya yolunu array olarak döndürebilir, bu durumda ilk elemanı alıyoruz
        if (is_array($value)) {
            $this->attributes['value'] = array_values($value)[0] ?? null;
        } else {
            $this->attributes['value'] = $value;
        }
    }

    /**
     * Set value from different field names
     */
    public function setValueDateAttribute($value)
    {
        $this->attributes['value'] = $value;
    }

    /**
     * Set value from different field names
     */
    public function setValueDatetimeAttribute($value)
    {
        $this->attributes['value'] = $value;
    }

    /**
     * Set value from different field names
     */
    public function setValueArrayAttribute($value)
    {
        $this->attributes['value'] = is_array($value) ? json_encode($value) : $value;
    }

    /**
     * Set value from color picker
     */
    public function setValueColorPickerAttribute($value)
    {
        $this->attributes['value'] = $value;
    }

    /**
     * Set value from code editor
     */
    public function setValueCodeEditorAttribute($value)
    {
        $this->attributes['value'] = $value;
    }

    /**
     * Set value from rich editor
     */
    public function setValueRichEditorAttribute($value)
    {
        $this->attributes['value'] = $value;
    }

    /**
     * Set value from markdown editor
     */
    public function setValueMarkdownEditorAttribute($value)
    {
        $this->attributes['value'] = $value;
    }

    /**
     * Set value from tags input
     */
    public function setValueTagsInputAttribute($value)
    {
        $this->attributes['value'] = is_array($value) ? json_encode($value) : $value;
    }

    /**
     * Set value from checkbox list
     */
    public function setValueCheckboxListAttribute($value)
    {
        $this->attributes['value'] = is_array($value) ? json_encode($value) : $value;
    }

    /**
     * Set value from radio
     */
    public function setValueRadioAttribute($value)
    {
        $this->attributes['value'] = $value;
    }

    /**
     * Set value from toggle buttons
     */
    public function setValueToggleButtonsAttribute($value)
    {
        $this->attributes['value'] = $value;
    }

    /**
     * Set value from slider
     */
    public function setValueSliderAttribute($value)
    {
        $this->attributes['value'] = (string) $value;
    }

    /**
     * Set value from key value
     */
    public function setValueKeyValueAttribute($value)
    {
        $this->attributes['value'] = is_array($value) ? json_encode($value) : $value;
    }

    /**
     * Get value for text field
     */
    public function getValueTextAttribute()
    {
        return $this->attributes['value'] ?? null;
    }

    /**
     * Get value for boolean field
     */
    public function getValueBooleanAttribute()
    {
        return isset($this->attributes['value']) ? filter_var($this->attributes['value'], FILTER_VALIDATE_BOOLEAN) : false;
    }

    /**
     * Get value for file field
     */
    public function getValueFileAttribute()
    {
        return $this->attributes['value'] ?? null;
    }

    /**
     * Get value for date field
     */
    public function getValueDateAttribute()
    {
        return $this->attributes['value'] ?? null;
    }

    /**
     * Get value for datetime field
     */
    public function getValueDatetimeAttribute()
    {
        return $this->attributes['value'] ?? null;
    }

    /**
     * Get value for array field
     */
    public function getValueArrayAttribute()
    {
        return isset($this->attributes['value']) ? json_decode($this->attributes['value'], true) : [];
    }

    /**
     * Get value for color picker field
     */
    public function getValueColorPickerAttribute()
    {
        return $this->attributes['value'] ?? null;
    }

    /**
     * Get value for code editor field
     */
    public function getValueCodeEditorAttribute()
    {
        return $this->attributes['value'] ?? null;
    }

    /**
     * Get value for rich editor field
     */
    public function getValueRichEditorAttribute()
    {
        return $this->attributes['value'] ?? null;
    }

    /**
     * Get value for markdown editor field
     */
    public function getValueMarkdownEditorAttribute()
    {
        return $this->attributes['value'] ?? null;
    }

    /**
     * Get value for tags input field
     */
    public function getValueTagsInputAttribute()
    {
        return isset($this->attributes['value']) ? json_decode($this->attributes['value'], true) : [];
    }

    /**
     * Get value for checkbox list field
     */
    public function getValueCheckboxListAttribute()
    {
        return isset($this->attributes['value']) ? json_decode($this->attributes['value'], true) : [];
    }

    /**
     * Get value for radio field
     */
    public function getValueRadioAttribute()
    {
        return $this->attributes['value'] ?? null;
    }

    /**
     * Get value for toggle buttons field
     */
    public function getValueToggleButtonsAttribute()
    {
        return $this->attributes['value'] ?? null;
    }

    /**
     * Get value for slider field
     */
    public function getValueSliderAttribute()
    {
        return isset($this->attributes['value']) ? (int) $this->attributes['value'] : 0;
    }

    /**
     * Get value for key value field
     */
    public function getValueKeyValueAttribute()
    {
        return isset($this->attributes['value']) ? json_decode($this->attributes['value'], true) : [];
    }

    /**
     * Get setting by key
     */
    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)
            ->where('is_active', true)
            ->first();
            
        if (!$setting) {
            return $default;
        }

        return static::castValue($setting->value, $setting->type);
    }

    /**
     * Set setting value
     */
    public static function set(string $key, $value, string $type = 'string'): void
    {
        static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'is_active' => true,
            ]
        );
    }

    /**
     * Cast value based on type
     */
    protected static function castValue($value, string $type)
    {
        return match($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $value,
            'float' => (float) $value,
            'array', 'json', 'tags_input', 'checkbox_list', 'key_value' => json_decode($value, true),
            'file' => $value, // File path as string
            'date' => $value, // Date as string (Y-m-d format)
            'datetime' => $value, // DateTime as string (Y-m-d H:i:s format)
            'color_picker' => $value, // Color as hex string
            'code_editor' => $value, // Code as string
            'rich_editor' => $value, // HTML as string
            'markdown_editor' => $value, // Markdown as string
            'radio' => $value, // Radio selection as string
            'toggle_buttons' => $value, // Toggle selection as string
            'slider' => (int) $value, // Slider value as integer
            default => $value,
        };
    }

    /**
     * Get all settings by group
     */
    public static function getGroup(string $group): array
    {
        return static::where('group', $group)
            ->where('is_active', true)
            ->pluck('value', 'key')
            ->map(function ($value, $key) use ($group) {
                $setting = static::where('key', $key)->first();
                return static::castValue($value, $setting->type);
            })
            ->toArray();
    }
}
