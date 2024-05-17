<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['seller', 'customer'];

    public function sellerUser()
    {
        return $this->belongsTo(User::class, 'seller');
    }

    public function customerUser()
    {
        return $this->belongsTo(User::class, 'customer');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }
}
