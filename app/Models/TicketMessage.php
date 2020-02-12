<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

/**
 * Ticket Message Model
 *
 * @mixin \Eloquent
 *
 * Database table:
 * @table ticket_messages
 *
 * Database columns:
 * @property integer id                            required | unique
 * @property string body                           required | length: 1 to 255
 * @property integer ticket_id                     required | \App\Models\Ticket::id
 * @property \Illuminate\Support\Carbon sent_at    nullable
 * @property integer sent_by                       nullable | \App\Models\User::id
 * @property \Illuminate\Support\Carbon updated_at nullable
 * @property integer updated_by                    nullable | \App\Models\User::id
 *
 * Database relations:
 * @property \App\Models\Ticket ticket             BelongsTo (many-to-one)
 * @property \App\Models\User sender               BelongsTo (many-to-one)
 * @property \App\Models\User creator              BelongsTo (many-to-one)
 * @property \App\Models\User editor               BelongsTo (many-to-one)
 */
class TicketMessage extends Model
{
    use Userstamps;

    /**
     * Indicate the column name for 'created_at' and 'created_by'
     *
     * @var string
     */
    const CREATED_AT = 'sent_at';
    const CREATED_BY = 'sent_by';

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['body', 'ticket_id', 'sent_by', 'sent_at'];

    /**
     * Relations to be eager loaded by default on every message
     *
     * @var array
     */
    protected $with = ['sender'];

    /**
     * Relationships to be touched when model is created/updated
     *
     * @var array
     */
    protected $touches = ['ticket'];

    /**
     * Get the ticket associated with $this message
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the user associated with $this message
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->creator();
    }
}
