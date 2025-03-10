<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskList extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'name',
    'description',
    'user_id',
    'position',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function tasks(): HasMany
  {
    return $this->hasMany(Task::class, 'list_id');
  }

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($list) {
      $maxPosition = static::where('user_id', $list->user_id)->max('position');
      $list->position = $maxPosition + 1;
    });
  }
}
