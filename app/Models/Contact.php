<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $with = ['phoneNumbers:id,contact_id,description,number'];


    // Relationships
    public function phoneNumbers()
    {
        return $this->hasMany(PhoneNumber::class);
    }
}
