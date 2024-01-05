<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\Order;
use App\Models\User;
use App\Notifications\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PushNotificationOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $order;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $description = 'Pesanan '.'INV'.str_pad($this->order->id, 4, '0', STR_PAD_LEFT). ' menunggu konfirmasi.';
        if($this->order->status == 'Process'){
            $description = 'Pesanan '.'INV'.str_pad($this->order->id, 4, '0', STR_PAD_LEFT). ' sedang di proses.';
        }elseif($this->order->status == 'Ready'){
            $description = 'Pesanan '.'INV'.str_pad($this->order->id, 4, '0', STR_PAD_LEFT). ' siap untuk diambil.';
        }elseif($this->order->status == 'Done'){
            $description = 'Pesanan '.'INV'.str_pad($this->order->id, 4, '0', STR_PAD_LEFT). ' selesai.';
        }elseif($this->order->status == 'Cancel'){
            $description = 'Pesanan '.'INV'.str_pad($this->order->id, 4, '0', STR_PAD_LEFT). ' telah dibatalkan.';
        }
        $notif = Notification::create([
            'user_id' => $this->order->user_id, 'user_from' => $this->order->updated_by, 'title' => 'Order '. $this->order->status, 'description' => $description,
            'status' => 'Sended', 'type' => 'Order', 'value' => $this->order->id 
        ]);    
        $user = User::find($this->order->user_id);        
        $user->notify(new Invoice(['title' => $notif->title, 'description' => $notif->description]));
    }
}
