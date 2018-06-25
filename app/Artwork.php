<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    use Translatable;
    public $translatedAttributes = ['title', 'description'];
    protected $fillable = ['url', 'contestant_id', 'category_id'];
    protected $appends = ['imageLink', 'pathReview', 'pathEdit', 'pathApprove'];
    protected $with = ['translations'];

    public function pathReview()
    {
        return route('artwork.review', [$this->contestant->slug, $this->id]);
    }

    public function pathEdit()
    {
        return route('artwork.edit', [$this->contestant->slug, $this->id]);
    }

    public function pathUpdate()
    {
        return route('artwork.update', $this->contestant->slug);
    }

    public function pathApprove()
    {
        return route('artwork.approve', [$this->contestant->slug, $this->id]);
    }

    public function getPathReviewAttribute()
    {
        return $this->pathReview();
    }

    public function getPathEditAttribute()
    {
        return $this->pathEdit();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function contestant()
    {
        return $this->belongsTo(Contestant::class);
    }

    public function getImageLinkAttribute()
    {
        return '/'.$this->url;
    }

    public function getUpdatePathAttribute()
    {
        return $this->updatePath();
    }

    public function getPathApproveAttribute()
    {
        return $this->pathApprove();
    }

    //
}
