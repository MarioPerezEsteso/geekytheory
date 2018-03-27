<?php

namespace App\Console\Commands;

use App\Subscriber;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
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

        $users = User::all();

        $emails = [];

        foreach ($users as $user) {
            $emails[] = $user->email;
        }

        foreach ($subscribers as $subscriber) {
            if (!in_array($subscriber->email, $emails)) {
                $emails[] = $subscriber->email;
            }
        }

        foreach ($emails as $email) {
            $data = [
                'subject' => '¡Hoy lanzamos nuevo curso de Ansible!',
                'to' => $email,
            ];

            try {
                Mail::send('newsletter.' . $viewNewsletter, $data, function ($message) use ($data) {
                    $message->from('no-reply@geekytheory.com', 'Mario de Geeky Theory');
                    $message->to($data['to']);
                    $message->subject($data['subject']);
                });
                $this->info("Email successfully sent to " . $email);
            } catch (\Exception $e) {
                Log::info("Failed to send email to " . $email);
                Log::info((string)$e);
                $this->info("Failed to send email to " . $email);
                $this->info((string)$e);
            }
        }
    }
}
