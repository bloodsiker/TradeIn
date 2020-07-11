<?php
namespace App\Mail;

use App\Models\BuybackRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestChangeStatusShipped extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user buybackRequest.
     *
     * @var BuybackRequest
     */
    protected $buybackRequest;

    /**
     * Create a new message instance.
     *
     * @param BuybackRequest $buybackRequest
     */
    public function __construct(BuybackRequest $buybackRequest)
    {
        $this->buybackRequest = $buybackRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.buyback_request.status')
            ->subject('Статус заявки изменился')
            ->with([
                'id' =>  $this->buybackRequest->id,
                'status' =>  $this->buybackRequest->status->name,
                'brand' =>  $this->buybackRequest->model->brand->name,
                'model' =>  $this->buybackRequest->model->name,
                'emei' =>  $this->buybackRequest->emei,
                'packet' =>  $this->buybackRequest->packet,
                'cost' =>  $this->buybackRequest->cost,
                'created_at' =>  $this->buybackRequest->created_at->format('d.m.Y H:i'),
            ]);
    }
}
