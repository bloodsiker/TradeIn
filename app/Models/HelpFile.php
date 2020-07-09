<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpFile extends Model
{
    const TYPE_IMAGE = 1;
    const TYPE_PDF   = 2;
    const TYPE_VIDEO = 3;

    public function help()
    {
        return $this->belongsTo(Help::class);
    }

    public function typeName()
    {
        $types = static::listType();

        return array_key_exists($this->type_file, $types) ? $types[$this->type_file] : null;
    }

    public static function listType()
    {
        return [
            self::TYPE_IMAGE => 'Изображение',
            self::TYPE_PDF   => 'PDF',
            self::TYPE_VIDEO => 'Видео',
        ];
    }
}
