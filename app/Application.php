<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = ['subject', 'content', 'file_url', 'manager_id', 'seen_by', 'active'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function manager(){
        return $this->belongsTo(User::class, 'manager_id');
    }
    public function messages(){
        return $this->belongsToMany(Message::class);
    }
    public function seenBy()
    {
        return $this->belongsTo(User::class, 'seen_by');
    }

}
