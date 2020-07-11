<?php
namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportShipped extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The request instance.
     *
     * @var Request
     */
    protected $request;

    /**
     * Create a new message instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.support')
            ->from('support@generalse.com', 'Trade-In')
            ->subject('Trade-In Зворотній зв’язок')
            ->with([
                'name'     =>  $this->request->name,
                'phone'    =>  $this->request->phone,
                'email'    =>  $this->request->email,
                'message'  =>  $this->request->message,
            ]);
    }
}
