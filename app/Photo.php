<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

use Intervention\Image\ImageManagerStatic as Image;


class Photo extends Model
{

    protected $table = 'flyer_photos';
    protected $fillable = ['path', 'name', 'thumbnail_path'];

    protected $baseDir = 'images/photos';
    protected $file;

    protected static function boot()
    {
        static::creating(function ($photo) {
            return $photo->upload();
        });
    }


    public function flyer()
    {
        return $this->belongsTo('App\Flyer');
    }

    public function upload()
    {
        $this->file->move($this->baseDir, $this->fileName());
        Image::make($this->filePath())
            ->fit(200)
            ->save($this->thumbnailPath());
        return $this;
    }

    public static function fromFile(UploadedFile $file)
    {
        $photo = new static;
        $photo->file = $file;

        return $photo->fill([
            'name' => $photo->fileName(),
            'path' => $photo->filePath(),
            'thumbnail_path' => $photo->thumbnailPath()
        ]);
    }

    /**
     *
     */
    public function fileName()
    {
        $name = sha1(time() . $this->file->getClientOriginalName());
        $extension = $this->file->getClientOriginalExtension();
        return "{$name}" . ".{$extension}";
    }

    private function filePath()
    {
        return $this->baseDir . '/' . $this->fileName();
    }

    private function thumbnailPath()
    {
        return $this->baseDir . '/th-' . $this->fileName();
    }
}
