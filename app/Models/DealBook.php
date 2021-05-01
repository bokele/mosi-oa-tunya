<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cohensive\Embed\Facades\Embed;

class DealBook extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'staff_id', 'category_id', 'author', 'dealbook_code', 'slug', 'title',
        'description',
        'content',
        'cover_image', 'video_link', 'published_by', 'published_at'
    ];


    /**
     * Get the user that owns the DealBook
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }
    /**
     * Get the user that owns the DealBook
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function published()
    {
        return $this->belongsTo(User::class, 'published_by', 'id');
    }

    /**
     * Get the user that owns the DealBook
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    /**
     * Get the dealbook's video link.
     *
     * @param  string  $value
     * @return string
     */

    public function getVideoLinkAttribute()
    {
        $embed = Embed::make($this->attributes['video_link'])->parseUrl();

        if (!$embed) {
            return '';
        }


        $embed->setAttribute(['width' => 728]);
        return $embed->getHtml();
    }
}
