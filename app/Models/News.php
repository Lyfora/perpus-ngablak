<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class News extends Model
{
    use HasFactory;
    protected $table = 'news';

    protected $fillable = [
        'title',
        'thumbnail',
        'slug',
        'content'
    ];

    public $fieldUpload = [
        [
            'field' => 'thumbnail',
            'type' => 'public',
        ]
    ];

    public function processUpload(&$input)
    {
        array_map(function ($row) use (&$input) {
            $field = $row['field'];
            $type = $row['type'];
            if (isset($input->$field)) {
                $file = $input->$field;
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs($this->table . '/' . $type, $fileName);
                $input->$field = $path;
            }
        }, $this->fieldUpload);
    }

    public function getFile()
    {
        array_map(function ($row) {
            $field = $row['field'];
            $type = $row['type'];
            if ($this->attributes[$field]) {
                if ($type == 'secret') {
                    $this->attributes[$field] = URL::temporarySignedRoute('getSecretFile', now()->addMinutes(5), [
                        'table' => $this->table,
                        'file' => basename($this->attributes[$field]),
                    ]);
                } else {
                    $this->attributes[$field] = URL::route('getPublicFile', [
                        'table' => $this->table,
                        'file' => basename($this->attributes[$field]),
                    ]);
                }
            }
        }, $this->fieldUpload);
        return $this;
    }
}
