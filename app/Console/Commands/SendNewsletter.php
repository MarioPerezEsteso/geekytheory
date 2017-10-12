<?php

namespace App\Console\Commands;

use App\Subscriber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-newsletter { viewNewsletter : The view that contains the newsletter}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send newsletter';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get arguments
        $viewNewsletter = $this->argument('viewNewsletter');

        $subscribers = Subscriber::where('active', 1)->get();

        foreach ($subscribers as $subscriber) {
            $data = [
                'subject' => 'Novedades de Geeky Theory',
                'to' => $subscriber->email,
            ];

            try {
                Mail::send('newsletter.' . $viewNewsletter, $data, function ($message) use ($data) {
                    $message->from('no-reply@geekytheory.com', 'Geeky Theory');
                    $message->to($data['to']);
                    $message->subject($data['subject']);
                });
                $this->info("Email successfully sent to " . $subscriber->email);
            } catch (\Exception $e) {
                $this->info("Failed to send email to " . $subscriber->email);
                $this->info((string)$e);
            }
        }
    }
}
