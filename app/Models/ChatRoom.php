<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatRoom extends Model
{
    use SoftDeletes;

    const TYPE_SINGULAR = 'singular';
    const TYPE_GROUP = 'group';
    // const TYPE_SUPPORT  = 'support';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'private_key',
        'public_key',
    ];

    protected $hidden = ['private_key', 'public_key'];

    protected static function boot()
    {
        parent::boot();
        
        // auto create private and public key
        static::creating(function (ChatRoom $room) {
            // START: Create public key and private key
            $key_config = [
                "digest_alg" => "sha256",
                "private_key_bits" => 2048,
                "private_key_type" => OPENSSL_KEYTYPE_RSA,
            ];
    
            // Generate private key
            $private_key = openssl_pkey_new($key_config);
    
            // Export private key to a variable
            openssl_pkey_export($private_key, $private_key_output);
    
            // Get the public key
            $public_key_details = openssl_pkey_get_details($private_key);
            $public_key_output = $public_key_details['key'];
            // END: Create public key and private key

            // Auto assign when creating chat room
            $room->private_key = $private_key_output;
            $room->public_key = $public_key_output;
        });
    }

    public function encryptedMessage(ChatMessage $message)
    {
        $compressed = ($message->toJson());
        
        $maxChunkSize = 100;
        $chunks = str_split($compressed, $maxChunkSize);
        
        $encryptedChunks = [];
        foreach ($chunks as $chunk) {
            $encryptedChunk = '';
            if (openssl_public_encrypt($chunk, $encryptedChunk, $this->public_key)) {
                $encryptedChunks[] = base64_encode($encryptedChunk);
            }
        }
        
        return $encryptedChunks;
    }

    public function members(): HasMany
    {
        return $this->hasMany(ChatMember::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function getName()
    {
        $user = auth()->user();
        return $this->type == ChatRoom::TYPE_SINGULAR ?
            $this->members
                ->filter(function ($member) use ($user) {
                    return $member->getUser()->getTable() != $user->getTable();
                })
                ->map(function ($member) {
                    return $member->getUser()->full_name;
                })
                ->first() :
            $this->members->map(function ($member) {
                return $member->getUser()->full_name;
            })->join(', ');
    }

    public function getAvatar()
    {
        $user = auth()->user();
        return $this->type == ChatRoom::TYPE_SINGULAR ?
            $this->members
                ->filter(function ($member) use ($user) {
                    return $member->getUser()->getTable() != $user->getTable();
                })
                ->map(function ($member) {
                    return $member->getMemberAvatarUrl();
                })
                ->first() :
            config('const.default_avatar.admin');
    }
}
