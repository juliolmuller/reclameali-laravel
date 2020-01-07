<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Ticket extends Model
{
    use Userstamps;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['created_by', 'created_at', 'closed_at', 'product_id', 'type_id', 'status_id'];

    /**
     * Attributes to be cast to native types
     *
     * @var array
     */
    protected $casts = [
        'closed_at' => 'datetime',
    ];

    /**
     * Get the product associated with $this ticket
     *
     * @return \App\Models\TicketStatus
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the status associated with $this ticket
     *
     * @return \App\Models\TicketStatus
     */
    public function status()
    {
        return $this->belongsTo(TicketStatus::class, 'status_id');
    }

    /**
     * Get the type associated with $this ticket
     *
     * @return \App\Models\TicketType
     */
    public function type()
    {
        return $this->belongsTo(TicketType::class, 'type_id');
    }

    /**
     * Get the messages associated with $this ticket
     *
     * @return \Illuminate\Database\Eloquent\Collection<\App\Models\TicketMessage>
     */
    public function messages()
    {
        return $this->hasMany(TicketMessage::class)->orderBy('sent_at');
    }
}
